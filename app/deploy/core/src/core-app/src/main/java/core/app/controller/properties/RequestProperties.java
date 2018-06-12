package core.app.controller.properties;

import core.app.service.enums.RestServiceEnum;
import lombok.Getter;
import lombok.Setter;
import org.springframework.http.HttpMethod;
import org.springframework.stereotype.Component;
import org.springframework.web.context.annotation.RequestScope;

@Getter
@Setter
@RequestScope
@Component
public class RequestProperties {
    private String requestURI;
    private HttpMethod requestMethod;
    private RestServiceEnum restService;

}
