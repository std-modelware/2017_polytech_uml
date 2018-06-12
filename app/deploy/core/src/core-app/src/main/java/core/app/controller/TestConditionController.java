package core.app.controller;

import com.fasterxml.jackson.core.JsonProcessingException;
import com.fasterxml.jackson.databind.ObjectMapper;
import core.app.controller.annotation.IgnoreToken;
import core.app.controller.properties.RequestProperties;
import lombok.extern.slf4j.Slf4j;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.MediaType;
import org.springframework.web.bind.annotation.*;
import subcore.dal.model.persistent.Subgroup;
import subcore.dal.model.persistent.TestCondition;
import subcore.exceptions.EntityNotFoundException;
import subcore.service.TestConditionService;

import java.util.*;


@Slf4j
@RestController
@RequestMapping(value = "tests/conditions", consumes = MediaType.APPLICATION_JSON_VALUE, produces = MediaType.APPLICATION_JSON_VALUE)
public class TestConditionController {
    @Autowired
    TestConditionService testConditionService;

    @Autowired
    ObjectMapper objectMapper;

    @Autowired
    RequestProperties requestProperties;

    @PostMapping
    @IgnoreToken
    public TestCondition createCondition(@RequestBody TestCondition condition) throws EntityNotFoundException, JsonProcessingException {
        log.info("\n\tRequest for CORE: " + objectMapper.writeValueAsString(condition) + "\n\tURL: "
                + requestProperties.getRequestURI());
        TestCondition resopnseTestCondition = testConditionService.createCondition(condition);
        log.info("\n\tResponse from CORE: " + objectMapper.writeValueAsString(resopnseTestCondition) + "\n\tURL: "
                + requestProperties.getRequestURI());
        return resopnseTestCondition;
    }

    @GetMapping(value = "/teacher/{teacherId}", consumes = MediaType.ALL_VALUE)
    @IgnoreToken
    public Set<TestCondition> getByTeacher(@PathVariable long teacherId) throws EntityNotFoundException, JsonProcessingException {
        log.info("\n\tRequest for CORE: \n\tURL: "
                + requestProperties.getRequestURI());
        Set<TestCondition> resopnseTestConditions = testConditionService.getByTeacher(teacherId);
        log.info("\n\tResponse from CORE: " + objectMapper.writeValueAsString(resopnseTestConditions) + "\n\tURL: "
                + requestProperties.getRequestURI());
        return resopnseTestConditions;
    }

    @GetMapping(value = "/teacher/{studentId}", consumes = MediaType.ALL_VALUE)
    @IgnoreToken
    public Set<TestCondition> getByStudent(@PathVariable long studentId) throws EntityNotFoundException, JsonProcessingException {
        log.info("\n\tRequest for CORE: \n\tURL: "
                + requestProperties.getRequestURI());
        Set<TestCondition> resopnseTestConditions = testConditionService.getByStudent(studentId);
        log.info("\n\tResponse from CORE: " + objectMapper.writeValueAsString(resopnseTestConditions) + "\n\tURL: "
                + requestProperties.getRequestURI());
        return resopnseTestConditions;
    }

    @PutMapping(value = "/{id}", consumes = MediaType.ALL_VALUE)
    @IgnoreToken
    public TestCondition updateTestCondition(@RequestBody TestCondition condition, @PathVariable long id) throws EntityNotFoundException, JsonProcessingException {
        log.info("\n\tRequest for CORE: " + objectMapper.writeValueAsString(condition) + "\n\tURL: "
                + requestProperties.getRequestURI());
        TestCondition resopnseTestCondition = testConditionService.updateTestCondition(condition, id);
        log.info("\n\tResponse from CORE: " + objectMapper.writeValueAsString(resopnseTestCondition) + "\n\tURL: "
                + requestProperties.getRequestURI());
        return resopnseTestCondition;
    }

    @DeleteMapping(value = "/{id}", consumes = MediaType.ALL_VALUE)
    @IgnoreToken
    public void deleteTestCondition(@PathVariable long id) throws EntityNotFoundException {
        log.info("\n\tRequest for CORE: \n\tURL: "
                + requestProperties.getRequestURI());
        testConditionService.deleteTestCondition(id);
        log.info("\n\tResponse from CORE: \n\tURL: "
                + requestProperties.getRequestURI());
    }
}
