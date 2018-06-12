package subcore.app;

import lombok.Setter;
import lombok.extern.slf4j.Slf4j;
import org.springframework.beans.factory.BeanFactory;
import org.springframework.beans.factory.BeanFactoryAware;
import org.springframework.boot.SpringApplication;
import org.springframework.boot.autoconfigure.SpringBootApplication;
import org.springframework.context.annotation.Bean;
import org.springframework.web.servlet.config.annotation.InterceptorRegistry;
import org.springframework.web.servlet.config.annotation.WebMvcConfigurer;
import subcore.app.interceptor.RequestPropertiesInterceptor;

@Slf4j
@SpringBootApplication(scanBasePackages = {"subcore.app", "subcore"})
public class SubcoreApplication implements WebMvcConfigurer, BeanFactoryAware {

    @Setter
    private BeanFactory beanFactory;

    public static void main(String[] args) {
        log.info("Start application.");
        SpringApplication.run(SubcoreApplication.class, args);
        log.info("Application started.");
    }

    @Override
    public void addInterceptors(InterceptorRegistry registry) {
        registry.addInterceptor(beanFactory.getBean(RequestPropertiesInterceptor.class));
    }

    @Bean
    RequestPropertiesInterceptor requestPropertiesInterceptor(){
        return new RequestPropertiesInterceptor();
    }
}
