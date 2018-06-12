package subcore.service;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import subcore.dal.dao.TestSolutionDao;
import subcore.dal.model.persistent.Subgroup;
import subcore.dal.model.persistent.TestCondition;
import subcore.dal.model.persistent.TestSolution;
import subcore.dal.model.readonly.Student;
import subcore.exceptions.EntityNotFoundException;

import java.time.LocalDateTime;
import java.util.Set;

@Service
public class TestSolutionService {
    @Autowired
    TestSolutionDao testSolutionDao;

    public TestSolution createSolution(TestSolution solution) {
        solution.setLoadTime(LocalDateTime.now());
        return testSolutionDao.save(solution);
    }

    public Set<TestSolution> getSolution(long studentId) {
        Set<TestSolution> testSolutions = testSolutionDao.findByStudentId(studentId);
        for(TestSolution testSolution : testSolutions){
            testSolution.setScore(null);
            testSolution.setAutocheckingScore(null);
            testSolution.setNote(null);
        }
        return testSolutions;
    }

    public TestSolution updateTestSolution(TestSolution newSolution, long id) throws EntityNotFoundException {
        TestSolution solution = testSolutionDao.findById(id).orElseThrow(() -> new EntityNotFoundException(TestSolution.class.getSimpleName(), id));
        solution.setProblemSolution(newSolution.getProblemSolution());
        solution = testSolutionDao.save(solution);
        solution.setNote(null);
        solution.setScore(null);
        solution.setAutocheckingScore(null);
        return solution;
    }

    public void deleteTestSolution(long id) throws EntityNotFoundException {
        TestSolution testSolution = testSolutionDao.findById(id).orElseThrow(() -> new EntityNotFoundException(TestSolution.class.getSimpleName(), id));
        testSolutionDao.delete(testSolution);
    }

    public TestSolution getReport(long solutionId) throws EntityNotFoundException {
        TestSolution testSolution = testSolutionDao.findById(solutionId).orElseThrow(() -> new EntityNotFoundException(TestSolution.class.getSimpleName(), solutionId));
        testSolution.setId(null);
        testSolution.setProblemSolution(null);
        testSolution.setLoadTime(null);
        return testSolution;
    }

    public TestSolution updateReport(TestSolution newTestSolution, long solutionId) throws EntityNotFoundException {
        TestSolution testSolution = testSolutionDao.findById(solutionId).orElseThrow(() -> new EntityNotFoundException(TestSolution.class.getSimpleName(), solutionId));

        testSolution.setScore(newTestSolution.getScore());
        testSolution.setNote(newTestSolution.getNote());
        testSolution = testSolutionDao.save(testSolution);
        testSolution.setLoadTime(null);
        testSolution.setProblemSolution(null);
        return testSolution;
    }
}
