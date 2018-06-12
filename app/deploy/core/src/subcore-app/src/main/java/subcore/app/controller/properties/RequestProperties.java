package subcore.app.controller.properties;


import lombok.Getter;
import lombok.Setter;
import org.springframework.http.HttpMethod;
import org.springframework.stereotype.Component;
import org.springframework.web.context.annotation.RequestScope;
import subcore.app.controller.enums.RestServiceEnum;

@Getter
@Setter
@RequestScope
@Component
public class RequestProperties {
    private String requestURI;
    private HttpMethod requestMethod;
    private RestServiceEnum restService;

}
