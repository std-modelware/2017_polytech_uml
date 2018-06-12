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

import static core.app.service.enums.RestServiceEnum.DEAN;

@Slf4j
@RestController
@RequestMapping(value = "/dean", consumes = MediaType.APPLICATION_JSON_VALUE, produces = MediaType.APPLICATION_JSON_VALUE)
public class DeanController {
    @Autowired
    ForwardService forwardService;

    @ForwardTo(DEAN)
    @IgnoreToken
    @PostMapping(value = "/admin/add_student")
    public JsonNode AddStudent(@RequestBody JsonNode problemData) throws RestServiceResponseException {
        return forwardService.forwardJson(problemData);
    }

    @ForwardTo(DEAN)
    @IgnoreToken
    @PostMapping(value = "/admin/add_teacher")
    public JsonNode  PutTeacherByHand_In(@RequestBody JsonNode teacherData) throws RestServiceResponseException{
        return forwardService.forwardJson(teacherData);
    }

    @ForwardTo(DEAN)
    @IgnoreToken
    @PostMapping(value = "/admin/add_discipline")
    public JsonNode PutDisciplineByHand_In(@RequestBody JsonNode disciplineData) throws RestServiceResponseException{
        return forwardService.forwardJson(disciplineData);
    }

    @ForwardTo(DEAN)
    @IgnoreToken
    @PostMapping(value = "admin/add_group")
    public JsonNode PutGroupByHand_In(@RequestBody JsonNode groupData) throws RestServiceResponseException{
        return forwardService.forwardJson(groupData);
    }

    @ForwardTo(DEAN)
    @IgnoreToken
    @PostMapping(value = "admin/make_curriculum")
    public JsonNode MakeCurriculum_In(@RequestBody JsonNode curriculumData) throws RestServiceResponseException{
        return forwardService.forwardJson(curriculumData);
    }

    @ForwardTo(DEAN)
    @IgnoreToken
    @PostMapping(value = "admin/link_group_curriculum")
    public  JsonNode LinkGroupAndCurriculum_In(@RequestBody JsonNode groupCurricilumData) throws RestServiceResponseException{
        return forwardService.forwardJson(groupCurricilumData);
    }

    @ForwardTo(DEAN)
    @IgnoreToken
    @PostMapping(value = "admin/link_group_disc_teach")
    public  JsonNode LinkGroupDiscpAndTeacher_In(@RequestBody JsonNode groupDiscData) throws RestServiceResponseException{
        return forwardService.forwardJson(groupDiscData);
    }

}
