package core.app.interceptor;

import com.fasterxml.jackson.databind.JsonNode;
import com.fasterxml.jackson.databind.ObjectMapper;
import com.fasterxml.jackson.databind.node.ObjectNode;
import com.fasterxml.jackson.databind.node.TextNode;
import core.app.controller.annotation.IgnoreToken;
import core.app.error.exceptions.RestServiceResponseException;
import core.app.service.enums.RestServiceEnum;
import lombok.extern.slf4j.Slf4j;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.beans.factory.annotation.Value;
import org.springframework.http.HttpStatus;
import org.springframework.http.MediaType;
import org.springframework.http.RequestEntity;
import org.springframework.http.ResponseEntity;
import org.springframework.web.client.HttpStatusCodeException;
import org.springframework.web.client.RestTemplate;
import org.springframework.web.method.HandlerMethod;
import org.springframework.web.servlet.HandlerInterceptor;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;
import java.net.URI;
import java.net.URISyntaxException;

@Slf4j
public class SecurityTokenInterceptor implements HandlerInterceptor{

    @Value("${core.app.security.token.header}")
    private String securityTokenHeader;

    @Autowired
    private ObjectMapper objectMapper;

    @Autowired
    private RestTemplate restTemplate;

    @Override
    public boolean preHandle(HttpServletRequest request, HttpServletResponse response, Object handler) throws IOException, RestServiceResponseException {
        //TODO replays basic error handler and remove this temporary fix
        if(request.getRequestURI().equals("/error")){
            return true;
        }

        if(!(handler instanceof HandlerMethod)) {
            log.trace("Unknown resource");
            response.sendError(HttpServletResponse.SC_NOT_FOUND, "Unknown resource");
            return false;
        }

        HandlerMethod handlerMethod = (HandlerMethod) handler;
        IgnoreToken ignoreToken = handlerMethod.getMethod().getAnnotation(IgnoreToken.class);
        if(ignoreToken != null){
            log.trace("Method with IgnoreToken annotation is being processed");
            return true;
        }

        String method = request.getMethod();

        String url = request.getRequestURL().toString();

        String token = request.getHeader(securityTokenHeader);

        if(token == null){
            response.sendError(HttpServletResponse.SC_FORBIDDEN, "token is required");
            return false;
        }


        ObjectNode root = objectMapper.createObjectNode();
        TextNode methodNode = root.textNode(method);
        TextNode urlNode = root.textNode(url);
        TextNode tokenNode = root.textNode(token);
        root.set("method", methodNode);
        root.set("url", urlNode);
        root.set("token", tokenNode);

        RestServiceEnum securityService = RestServiceEnum.PICO;

        String securityServiceUri = "http://localhost:" + securityService.getPort() +
                securityService.getMapping() + "/check";
        log.info("\n\tRequest to PICO " + root.toString());
        try {
            log.info(securityServiceUri);
            RequestEntity<JsonNode> requestToPico = RequestEntity.post(new URI(securityServiceUri))
                                                                 .contentType(MediaType.APPLICATION_JSON)
                                                                 .body(root);
            ResponseEntity responseFromPico = restTemplate.exchange(requestToPico, JsonNode.class);
            log.info("\n\tResponse from PICO " + responseFromPico.getBody().toString());
        } catch (URISyntaxException e){
            log.error(e.getMessage(), e);
        } catch (HttpStatusCodeException e){
            log.info("\n\tPico has returned response with status code " + Integer.toString(e.getStatusCode().value()));
            HttpStatus statusCode = e.getStatusCode();
            String message = objectMapper.readValue(e.getResponseBodyAsString(), JsonNode.class).get("msg").asText();
            throw new RestServiceResponseException(statusCode, message);
        }
        return true;
    }
}
