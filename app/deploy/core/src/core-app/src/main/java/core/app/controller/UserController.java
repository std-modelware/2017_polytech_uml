package core.app.controller;

import com.fasterxml.jackson.databind.JsonNode;
import core.app.controller.annotation.ForwardTo;
import core.app.controller.annotation.IgnoreToken;
import core.app.error.exceptions.RestServiceResponseException;
import core.app.service.ForwardService;
import lombok.extern.slf4j.Slf4j;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.MediaType;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RestController;

import java.util.*;

import static core.app.service.enums.RestServiceEnum.PICO;
import static core.app.service.enums.RestServiceEnum.TASK;

@Slf4j
@RestController
@RequestMapping(value = "", consumes = MediaType.APPLICATION_JSON_VALUE, produces = MediaType.APPLICATION_JSON_VALUE)
public class UserController {
    @Autowired
    ForwardService forwardService;

    @ForwardTo(PICO)
    @IgnoreToken
    @PostMapping(value = "/login")
    public JsonNode login(@RequestBody JsonNode loginData) throws RestServiceResponseException {
        return forwardService.forwardJson(loginData);
    }

    @ForwardTo(PICO)
    @IgnoreToken
    @PostMapping(value = "/logout")
    public JsonNode logout(@RequestBody JsonNode logoutData) throws RestServiceResponseException {
        return forwardService.forwardJson(logoutData);
    }
}