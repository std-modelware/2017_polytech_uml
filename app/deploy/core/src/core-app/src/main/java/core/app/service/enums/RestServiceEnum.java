package core.app.service.enums;

import lombok.Getter;

@Getter
public enum RestServiceEnum {
    DEAN(9874),
    TASK(7777),
    PICO(5000)
    ;

    private int port;
    private String mapping = "";

    RestServiceEnum(int port){
        this.port = port;
    }

    RestServiceEnum(int port, String mapping){
        this(port);
        this.mapping = mapping;
    }
}
