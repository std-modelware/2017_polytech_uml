package subcore;

import org.springframework.boot.autoconfigure.EnableAutoConfiguration;
import org.springframework.context.annotation.ComponentScan;
import org.springframework.context.annotation.Configuration;
import org.springframework.context.annotation.PropertySource;
import org.springframework.data.jpa.repository.config.EnableJpaRepositories;
import org.springframework.transaction.annotation.EnableTransactionManagement;

@EnableAutoConfiguration
@Configuration
@ComponentScan({"subcore"})
@EnableJpaRepositories
@EnableTransactionManagement
@PropertySource("classpath:dal.properties")
public class SubcoreServiceModule {
}
