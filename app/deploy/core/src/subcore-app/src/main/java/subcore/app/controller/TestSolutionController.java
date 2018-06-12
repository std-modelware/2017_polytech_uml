package subcore.app.controller;

import com.fasterxml.jackson.core.JsonProcessingException;
import com.fasterxml.jackson.databind.ObjectMapper;
import lombok.extern.slf4j.Slf4j;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.MediaType;
import org.springframework.web.bind.annotation.*;
import subcore.app.controller.properties.RequestProperties;
import subcore.dal.model.persistent.TestSolution;
import subcore.exceptions.EntityNotFoundException;
import subcore.service.TestSolutionService;

import java.util.Set;

@Slf4j
@RestController
@RequestMapping(value = "solutions", consumes = MediaType.APPLICATION_JSON_VALUE, produces = MediaType.APPLICATION_JSON_VALUE)
public class TestSolutionController {

    @Autowired
    TestSolutionService testSolutionService;

    @Autowired
    RequestProperties requestProperties;

    @Autowired
    ObjectMapper objectMapper;

    @PostMapping
    public TestSolution createSolution(@RequestBody TestSolution solution) throws EntityNotFoundException, JsonProcessingException {
        log.info("\n\tRequest for CORE: " + objectMapper.writeValueAsString(solution) + "\n\tURL: "
                + requestProperties.getRequestURI());
        TestSolution responseSolution = testSolutionService.createSolution(solution);
        log.info("\n\tResponse from CORE: " + objectMapper.writeValueAsString(responseSolution) + "\n\tURL: "
                + requestProperties.getRequestURI());
        return responseSolution;
    }

    @GetMapping(value = "/{studentId}", consumes = MediaType.ALL_VALUE)
    public Set<TestSolution> getSolution(@PathVariable long studentId) throws EntityNotFoundException, JsonProcessingException {
        log.info("\n\tRequest for CORE: \n\tURL: "
                + requestProperties.getRequestURI());
        Set<TestSolution> responseSolutions =  testSolutionService.getSolution(studentId);
        log.info("\n\tResponse from CORE: " + objectMapper.writeValueAsString(responseSolutions) + "\n\tURL: "
                + requestProperties.getRequestURI());
        return responseSolutions;
    }

    @PutMapping(value = "/{solutionId}", consumes = MediaType.ALL_VALUE)
    public TestSolution updateTestSolution(@RequestBody TestSolution solution, @PathVariable long solutionId) throws EntityNotFoundException, JsonProcessingException {
        log.info("\n\tRequest for CORE: " + objectMapper.writeValueAsString(solution) + "\n\tURL: "
                + requestProperties.getRequestURI());
        TestSolution responseSolution = testSolutionService.updateTestSolution(solution, solutionId);
        log.info("\n\tResponse from CORE: " + objectMapper.writeValueAsString(responseSolution) + "\n\tURL: "
                + requestProperties.getRequestURI());
        return responseSolution;
    }

    @DeleteMapping(value = "/{solutionId}", consumes = MediaType.ALL_VALUE)
    public void deleteTestSolution(@PathVariable long solutionId) throws EntityNotFoundException {
        log.info("\n\tRequest for CORE: \n\tURL: "
                + requestProperties.getRequestURI());
        testSolutionService.deleteTestSolution(solutionId);
        log.info("\n\tResponse from CORE: \n\tURL: "
                + requestProperties.getRequestURI());
    }

    @GetMapping(value = "/report/{solutionId}", consumes = MediaType.ALL_VALUE)
    public TestSolution getReport(@PathVariable long solutionId) throws EntityNotFoundException, JsonProcessingException {
        log.info("\n\tRequest for CORE: \n\tURL: "
                + requestProperties.getRequestURI());
        TestSolution responseSolution = testSolutionService.getReport(solutionId);
        log.info("\n\tResponse from CORE: " + objectMapper.writeValueAsString(responseSolution) + "\n\tURL: "
                + requestProperties.getRequestURI());
        return responseSolution;
    }

    @PostMapping(value = "/report/{solutionId}", consumes = MediaType.ALL_VALUE)
    public TestSolution addReport(@RequestBody TestSolution solution, @PathVariable long solutionId) throws EntityNotFoundException, JsonProcessingException {
        log.info("\n\tRequest for CORE: " + objectMapper.writeValueAsString(solution) + "\n\tURL: "
                + requestProperties.getRequestURI());
        TestSolution responseSolution = testSolutionService.updateReport(solution, solutionId);
        log.info("\n\tResponse from CORE: " + objectMapper.writeValueAsString(responseSolution) + "\n\tURL: "
                + requestProperties.getRequestURI());
        return responseSolution;
    }

    @PutMapping(value = "/report/{solutionId}", consumes = MediaType.ALL_VALUE)
    public TestSolution updateReport(@RequestBody TestSolution solution, @PathVariable long solutionId) throws EntityNotFoundException, JsonProcessingException {
        log.info("\n\tRequest for CORE: " + objectMapper.writeValueAsString(solution) +"\n\tURL: "
                + requestProperties.getRequestURI());
        TestSolution responseSolution = testSolutionService.updateReport(solution, solutionId);
        log.info("\n\tResponse from CORE: " + objectMapper.writeValueAsString(responseSolution) + "\n\tURL: "
                + requestProperties.getRequestURI());
        return responseSolution;
    }


}
