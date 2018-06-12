package core.app.controller;

import com.fasterxml.jackson.databind.JsonNode;
import com.fasterxml.jackson.databind.node.JsonNodeFactory;
import com.fasterxml.jackson.databind.node.ObjectNode;
import core.app.controller.annotation.ForwardTo;
import core.app.controller.annotation.IgnoreToken;
import core.app.error.exceptions.RestServiceResponseException;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.PutMapping;
import org.springframework.web.bind.annotation.GetMapping;
import core.app.service.ForwardService;
import lombok.extern.slf4j.Slf4j;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.MediaType;
import org.springframework.web.bind.annotation.*;

import static core.app.service.enums.RestServiceEnum.TASK;


@Slf4j
@RestController
@RequestMapping(value = "/task", consumes = MediaType.APPLICATION_JSON_VALUE, produces = MediaType.APPLICATION_JSON_VALUE)
public class TaskController {
    @Autowired
    ForwardService forwardService;

    @ForwardTo(TASK)
    @IgnoreToken
    @GetMapping(value = "/problems/*", consumes = MediaType.ALL_VALUE)
    public JsonNode GetProblem() throws RestServiceResponseException {
        System.out.println();
        JsonNode node = forwardService.forwardForGet();
        System.out.println(node);
        System.out.println();
        return node;
    }

    @ForwardTo(TASK)
    @IgnoreToken
    @PostMapping(value = "/problems/*")
    public JsonNode AddProblemwithId(@RequestBody JsonNode problemData) throws RestServiceResponseException {
        return forwardService.forwardJson(problemData);
    }

    @ForwardTo(TASK)
    @IgnoreToken
    @PostMapping(value = "/problems")
    public JsonNode AddProblem(@RequestBody JsonNode problemData) throws RestServiceResponseException {
        return forwardService.forwardJson(problemData);
    }

    @ForwardTo(TASK)
    @IgnoreToken
    @PostMapping(value= "/tests")
    public  JsonNode generateProblemsSet(@RequestBody JsonNode problemData) throws RestServiceResponseException {
        return forwardService.forwardJson(problemData);
    }

    @ForwardTo(TASK)
    @IgnoreToken
    @PutMapping(value = "/tests/*")
    public JsonNode createTest(@RequestBody JsonNode problemData) throws RestServiceResponseException {
        return  forwardService.forwardJson(problemData);
    }

    @ForwardTo(TASK)
    @IgnoreToken
    @GetMapping(value = "/marks", consumes = MediaType.ALL_VALUE)
    public JsonNode evaluateTestSolution(@RequestBody JsonNode problemData) throws RestServiceResponseException{
        return  forwardService.forwardJson(problemData);
    }

    @ForwardTo(TASK)
    @IgnoreToken
    @GetMapping(value = "/problems", consumes = MediaType.ALL_VALUE)
    public JsonNode getProblems(@RequestBody JsonNode problemData) throws RestServiceResponseException {
        return  forwardService.forwardJson(problemData);
    }
}
