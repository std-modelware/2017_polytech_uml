package core.app.error.exceptions;

import org.springframework.http.HttpStatus;
import subcore.exceptions.BaseException;

/**
 * Exception for handling errors in responses from other services (dean, task, pico)
 */
public class RestServiceResponseException extends BaseException {
    public RestServiceResponseException(HttpStatus statusCode){
        super(statusCode);
    }

    public RestServiceResponseException(HttpStatus statusCode, String message){
        super(statusCode, message);
    }

    public RestServiceResponseException(HttpStatus statusCode, String message, Throwable cause){
        super(statusCode, message, cause);
    }
}
