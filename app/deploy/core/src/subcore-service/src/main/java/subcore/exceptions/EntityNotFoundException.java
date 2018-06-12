package subcore.exceptions;

import org.springframework.http.HttpStatus;

public class EntityNotFoundException extends BaseException {
    public EntityNotFoundException(String entityName, long entityId){
        this(entityName, entityId, null);
    }

    public EntityNotFoundException(String entityName, long entityId, Throwable cause){
        super(HttpStatus.BAD_REQUEST, "entity " + entityName + " with id " + entityId + " was not found", cause);
    }
}
