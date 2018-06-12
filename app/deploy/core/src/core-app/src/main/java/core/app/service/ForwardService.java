package core.app.service;

import com.fasterxml.jackson.databind.JsonNode;
import com.fasterxml.jackson.databind.ObjectMapper;
import com.fasterxml.jackson.databind.node.JsonNodeFactory;
import com.fasterxml.jackson.databind.node.ObjectNode;
import core.app.controller.properties.RequestProperties;
import core.app.error.exceptions.RestServiceResponseException;
import core.app.service.enums.RestServiceEnum;
import lombok.extern.slf4j.Slf4j;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.MediaType;
import org.springframework.http.RequestEntity;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Service;
import org.springframework.web.client.HttpStatusCodeException;
import org.springframework.web.client.RestTemplate;

import java.io.IOException;
import java.net.URI;
import java.net.URISyntaxException;
import java.util.Optional;

@Slf4j
@Service
public class ForwardService {

    @Autowired
    RequestProperties requestProperties;

    @Autowired
    RestTemplate restTemplate;

    @Autowired
    private ObjectMapper objectMapper;

    public JsonNode forwardJson(JsonNode requestData) throws RestServiceResponseException {

        log.info("\n\tRequest for CORE: " + requestData.toString() + "\n\tURL: "
                + requestProperties.getRequestURI() +
        "\n\tForward to " + requestProperties.getRestService().toString());

        RestServiceEnum restService = requestProperties.getRestService();

        String url = "http://localhost:" + restService.getPort() + restService.getMapping() + requestProperties.getRequestURI();


        try {

            RequestEntity<JsonNode> requestToPico = RequestEntity.method(requestProperties.getRequestMethod(), new URI(url))
                                                                 .contentType(MediaType.APPLICATION_JSON)
                                                                 .body(requestData);

            ResponseEntity<JsonNode> responseFromPico = restTemplate.exchange(requestToPico, JsonNode.class);

            log.info("\n\tResponse from CORE: " +
                    (responseFromPico.getBody() != null ? responseFromPico.getBody().toString() : "")
                    + "\n\tURL: "
                     + requestProperties.getRequestURI() +
                     "\n\tBackward from " + requestProperties.getRestService().toString());

            return responseFromPico.getBody();
        } catch (URISyntaxException e) {
            throw new RuntimeException(e);
        } catch (HttpStatusCodeException e) {
            log.info("\n\tPico has returned response with status code " + Integer.toString(e.getStatusCode().value()));
            HttpStatus statusCode = e.getStatusCode();
            String message;
            try {
                message = objectMapper.readValue(e.getResponseBodyAsString(), JsonNode.class).get("msg").asText();
            } catch (IOException ioEx) {
                throw new RuntimeException(ioEx);
            }
            throw new RestServiceResponseException(statusCode, message);
        }
    }

    public JsonNode forwardForGet() throws RestServiceResponseException {

        log.info("\n\tRequest for CORE: {}" + "\n\tURL: "
                + requestProperties.getRequestURI() +
                "\n\tForward to " + requestProperties.getRestService().toString());

        RestServiceEnum restService = requestProperties.getRestService();

        String url = "http://localhost:" + restService.getPort() + restService.getMapping() + requestProperties.getRequestURI();


        try {

            ObjectNode node = JsonNodeFactory.instance.objectNode();
            RequestEntity<JsonNode> requestToPico = RequestEntity.method(requestProperties.getRequestMethod(), new URI(url))
                    .contentType(MediaType.APPLICATION_JSON)
                    .body(node);
            ResponseEntity<JsonNode> responseFromPico = restTemplate.exchange(requestToPico, JsonNode.class);

            log.info("\n\tResponse from CORE: " +
                    (responseFromPico.getBody() != null ? responseFromPico.getBody().toString() : "")
                    + "\n\tURL: "
                    + requestProperties.getRequestURI() +
                    "\n\tBackward from " + requestProperties.getRestService().toString());

            return responseFromPico.getBody();
        } catch (URISyntaxException e) {
            throw new RuntimeException(e);
        } catch (HttpStatusCodeException e) {
            log.info("\n\tPico has returned response with status code " + Integer.toString(e.getStatusCode().value()));
            HttpStatus statusCode = e.getStatusCode();
            String message;
            try {
                message = objectMapper.readValue(e.getResponseBodyAsString(), JsonNode.class).get("msg").asText();
            } catch (IOException ioEx) {
                throw new RuntimeException(ioEx);
            }
            throw new RestServiceResponseException(statusCode, message);
        }
    }

}
