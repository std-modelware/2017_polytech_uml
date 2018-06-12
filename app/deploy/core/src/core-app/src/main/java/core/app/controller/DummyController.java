package core.app.controller;

import org.springframework.http.MediaType;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

@RestController
@RequestMapping(value = "/core/dummy", consumes = MediaType.APPLICATION_JSON_VALUE)
public class DummyController {

    @GetMapping(consumes = MediaType.ALL_VALUE)
    public void dummyMethod(){
    }
}
