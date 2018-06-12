package core.app.interceptor;


import core.app.controller.annotation.ForwardTo;
import core.app.controller.properties.RequestProperties;
import lombok.extern.slf4j.Slf4j;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpMethod;
import org.springframework.web.method.HandlerMethod;
import org.springframework.web.servlet.HandlerInterceptor;
import subcore.dal.dao.StudentDao;
import subcore.dal.dao.SubgroupDao;
import subcore.dal.model.persistent.Subgroup;

import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import java.io.IOException;
import java.util.ArrayList;
import java.util.HashSet;
import java.util.Set;
import java.util.TreeSet;

@Slf4j
public class RequestPropertiesInterceptor implements HandlerInterceptor {
    @Autowired
    RequestProperties requestProperties;

    @Override
    public boolean preHandle(HttpServletRequest request, HttpServletResponse response, Object handler) throws IOException {
        requestProperties.setRequestURI(request.getRequestURI());
        requestProperties.setRequestMethod(HttpMethod.valueOf(request.getMethod()));

        if(!(handler instanceof HandlerMethod)) {
            log.trace("Unknown resource");
            response.sendError(HttpServletResponse.SC_NOT_FOUND, "Unknown resource");
            return false;
        }

        HandlerMethod methodHandler = (HandlerMethod) handler;
        ForwardTo annotation = methodHandler.getMethod().getAnnotation(ForwardTo.class);
        if(annotation != null){
            requestProperties.setRestService(annotation.value());
        }
        return true;
    }
}
