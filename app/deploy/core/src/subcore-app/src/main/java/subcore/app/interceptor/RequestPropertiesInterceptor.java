package subcore.app.interceptor;



import lombok.extern.slf4j.Slf4j;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpMethod;
import org.springframework.web.method.HandlerMethod;
import org.springframework.web.servlet.HandlerInterceptor;
import subcore.app.controller.properties.RequestProperties;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;

@Slf4j
public class RequestPropertiesInterceptor implements HandlerInterceptor {
    @Autowired
    RequestProperties requestProperties;

    @Override
    public boolean preHandle(HttpServletRequest request, HttpServletResponse response, Object handler) throws IOException {
        requestProperties.setRequestURI(request.getRequestURI());
        requestProperties.setRequestMethod(HttpMethod.valueOf(request.getMethod()));
        return true;
    }
}
