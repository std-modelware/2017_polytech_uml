package subcore.app.error.handler;

import com.fasterxml.jackson.databind.JsonNode;
import com.fasterxml.jackson.databind.ObjectMapper;
import com.fasterxml.jackson.databind.node.ObjectNode;
import com.fasterxml.jackson.databind.node.TextNode;
import lombok.extern.slf4j.Slf4j;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.ControllerAdvice;
import org.springframework.web.bind.annotation.ExceptionHandler;
import subcore.exceptions.BaseException;

@Slf4j
@ControllerAdvice
public class ErrorHandler {

    @Autowired
    private ObjectMapper objectMapper;

    @ExceptionHandler(BaseException.class)
    protected ResponseEntity<JsonNode> handleBaseException(final BaseException ex) {
        log.error(ex.getMessage() + ": " + ex.getStatusCode(), ex);
        return handleAnyException(ex.getMessage(), ex.getStatusCode());
    }

    @ExceptionHandler(Exception.class)
    protected ResponseEntity<JsonNode> handleException(final Exception ex) {
        log.error(ex.getMessage(), ex);
        return handleAnyException(ex.getMessage(), HttpStatus.INTERNAL_SERVER_ERROR);
    }

    protected ResponseEntity<JsonNode> handleAnyException(String message, HttpStatus statusCode){
        ObjectNode jsonNode = objectMapper.createObjectNode();
        TextNode messageNode = jsonNode.textNode(message);
        jsonNode.set("message", messageNode);

        return ResponseEntity.status(statusCode).body(jsonNode);
    }
}
