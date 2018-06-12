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
import subcore.dal.model.readonly.Student;
import subcore.exceptions.EntityNotFoundException;
import subcore.service.SubgroupService;

import java.util.Set;

@Slf4j
@RestController
@RequestMapping(value = "subgroups", consumes = MediaType.APPLICATION_JSON_VALUE, produces = MediaType.APPLICATION_JSON_VALUE)
public class SubgroupController {
    @Autowired
    SubgroupService subgroupService;

    @Autowired
    ObjectMapper objectMapper;

    @Autowired
    RequestProperties requestProperties;

    @PostMapping
    @IgnoreToken
    public Subgroup CreateSubgroup(@RequestBody Subgroup subgroup) throws EntityNotFoundException, JsonProcessingException {
        log.info("\n\tRequest for CORE: " + objectMapper.writeValueAsString(subgroup) + "\n\tURL: "
                + requestProperties.getRequestURI());
        Subgroup responseSubgroup =  subgroupService.create(subgroup);
        log.info("\n\tResponse from CORE: " + objectMapper.writeValueAsString(responseSubgroup) + "\n\tURL: "
                + requestProperties.getRequestURI());
        return responseSubgroup;
    }

    @GetMapping(value = "/student/{studentId}", consumes = MediaType.ALL_VALUE)
    @IgnoreToken
    public Set<Subgroup> getByStudent(@PathVariable long studentId) throws EntityNotFoundException, JsonProcessingException {
        log.info("\n\tRequest for CORE: n\tURL: "
                + requestProperties.getRequestURI());
        Set<Subgroup> responseSubgroups =  subgroupService.getByStudent(studentId);
        log.info("\n\tResponse from CORE: " + objectMapper.writeValueAsString(responseSubgroups) + "\n\tURL: "
                + requestProperties.getRequestURI());
        return responseSubgroups;
    }

    @PutMapping(value = "/{subgroupId}", consumes = MediaType.ALL_VALUE)
    @IgnoreToken
    public Subgroup updateStudentList(@RequestBody Subgroup subgroup, @PathVariable long subgroupId) throws EntityNotFoundException, JsonProcessingException {
        log.info("\n\tRequest for CORE: " + objectMapper.writeValueAsString(subgroup) + "\n\tURL: "
                + requestProperties.getRequestURI());
        Subgroup responseSubgroup =  subgroupService.updateStudentList(subgroup, subgroupId);
        log.info("\n\tResponse from CORE: " + objectMapper.writeValueAsString(responseSubgroup) + "\n\tURL: "
                + requestProperties.getRequestURI());
        return responseSubgroup;
    }

    @DeleteMapping(value = "/{subgroupId}", consumes = MediaType.ALL_VALUE)
    @IgnoreToken
    public void deleteSubgroup(@PathVariable long subgroupId) throws EntityNotFoundException {
        log.info("\n\tRequest for CORE: \n\tURL: "
                + requestProperties.getRequestURI());
        subgroupService.deleteSubgroup(subgroupId);
        log.info("\n\tResponse from CORE: \n\tURL: "
                + requestProperties.getRequestURI());
    }

    @GetMapping(value = "/{subgroupId}", consumes = MediaType.ALL_VALUE)
    @IgnoreToken
    public Subgroup getStudents(@PathVariable long subgroupId) throws EntityNotFoundException, JsonProcessingException {
        log.info("\n\tRequest for CORE: \n\tURL: "
                + requestProperties.getRequestURI());
        Subgroup responseSubgroup =  subgroupService.getStudents(subgroupId);
        log.info("\n\tResponse from CORE: " + objectMapper.writeValueAsString(responseSubgroup) + "\n\tURL: "
                + requestProperties.getRequestURI());
        return responseSubgroup;
    }

}
