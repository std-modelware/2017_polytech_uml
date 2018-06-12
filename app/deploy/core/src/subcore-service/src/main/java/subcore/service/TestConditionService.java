package subcore.service;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import subcore.dal.dao.*;
import subcore.dal.model.persistent.TestCondition;
import subcore.dal.model.readonly.Discipline;
import subcore.dal.model.readonly.Student;
import subcore.dal.model.readonly.Teacher;
import subcore.dal.model.readonly.Test;
import subcore.exceptions.EntityNotFoundException;

import java.util.HashSet;
import java.util.Set;
import java.util.TreeSet;

@Service
public class TestConditionService {
    @Autowired
    private SubgroupDao subgroupDao;

    @Autowired
    private TestConditionDao testConditionDao;

    @Autowired
    private TestDao testDao;

    @Autowired
    private StudentDao studentDao;

    @Autowired
    private TeacherDao teacherDao;

    public TestCondition createCondition(final TestCondition condition) throws EntityNotFoundException {
        if (!subgroupDao.existsById(condition.getSubgroupId())){
                throw new EntityNotFoundException(Student.class.getSimpleName(), condition.getSubgroupId());
        }
        if (!subgroupDao.existsById(condition.getSubgroupId())){
            throw new EntityNotFoundException(Student.class.getSimpleName(), condition.getSubgroupId());
        }
        return testConditionDao.save(condition);
    }

    public Set<TestCondition> getByTeacher(final long teacherId) throws EntityNotFoundException{
        final Set<TestCondition> testConditions = new HashSet<>();

        Teacher teacher = teacherDao.findById(teacherId)
                                   .orElseThrow(() -> new EntityNotFoundException(Teacher.class.getSimpleName(), teacherId));

        for(Integer disciplineId: teacher.getDisciplinesIds()) {
            for(Test test: testDao.findByDisciplineId(disciplineId)){
                testConditions.addAll(testConditionDao.findByTestId(test.getTestId()));
            }
        }

        return testConditions;
    }

    public Set<TestCondition> getByStudent(final long studentId) throws EntityNotFoundException{
        final Set<TestCondition> testConditions = new HashSet<>();

        final Student student = studentDao.findById(studentId)
                                          .orElseThrow(() -> new EntityNotFoundException(Student.class.getSimpleName(), studentId));

        for(long subgroupId: student.getSubgroupIds()){
            testConditions.addAll(testConditionDao.findBySubgroupId(subgroupId));
        }

        return testConditions;
    }

    public TestCondition updateTestCondition(TestCondition newCondition, long id) throws EntityNotFoundException{
        TestCondition condition = testConditionDao.findById(id)
                                                  .orElseThrow(() -> new EntityNotFoundException(TestCondition.class.getSimpleName(), id));
        condition.setStartTime(newCondition.getStartTime());
        condition.setFinishTime(newCondition.getFinishTime());
        return testConditionDao.save(condition);
    }

    public void deleteTestCondition(long id) throws EntityNotFoundException {
        TestCondition testCondition = testConditionDao.findById(id)
                                                      .orElseThrow(() -> new EntityNotFoundException(TestCondition.class.getSimpleName(), id));
        testConditionDao.delete(testCondition);
    }
}
