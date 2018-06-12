package subcore.exceptions;

import lombok.Getter;
import org.springframework.http.HttpStatus;

public class BaseException extends Exception {

    @Getter
    private HttpStatus statusCode;

    protected BaseException(HttpStatus statusCode){
        super();
        this.statusCode = statusCode;
    }

    protected BaseException(HttpStatus statusCode, String message){
        super(message);
        this.statusCode = statusCode;
    }

    protected BaseException(HttpStatus statusCode, String message, Throwable cause){
        super(message, cause);
        this.statusCode = statusCode;
    }
}
