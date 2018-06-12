package core.app;

import core.app.interceptor.RequestPropertiesInterceptor;
import core.app.interceptor.SecurityTokenInterceptor;
import lombok.Setter;
import lombok.extern.slf4j.Slf4j;
import org.springframework.beans.factory.BeanFactory;
import org.springframework.beans.factory.BeanFactoryAware;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.context.annotation.Bean;
import org.springframework.context.annotation.PropertySource;
import org.springframework.web.client.RestTemplate;
import org.springframework.web.servlet.config.annotation.InterceptorRegistry;
import org.springframework.web.servlet.config.annotation.WebMvcConfigurer;

@Slf4j
@SpringBootApplication(scanBasePackages = {"core.app", "subcore"})
@PropertySource("classpath:security.properties")
public class CoreApplication implements WebMvcConfigurer, BeanFactoryAware{

    @Setter
    private BeanFactory beanFactory;

    public static void main(String[] args) {
        log.info("Start application.");
        SpringApplication.run(CoreApplication.class, args);
        log.info("Application started.");
    }

    @Override
    public void addInterceptors(InterceptorRegistry registry) {
        registry.addInterceptor(beanFactory.getBean(RequestPropertiesInterceptor.class));
        registry.addInterceptor(beanFactory.getBean(SecurityTokenInterceptor.class));
    }

    @Bean
    RequestPropertiesInterceptor requestPropertiesInterceptor(){
        return new RequestPropertiesInterceptor();
    }

    @Bean
    SecurityTokenInterceptor securityTokenInterceptor(){
        return new SecurityTokenInterceptor();
    }

    @Bean
    RestTemplate restTemplate(){
        return new RestTemplate();
    }

}
