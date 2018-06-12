package subcore.dal.dao;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.repository.CrudRepository;
import subcore.dal.model.persistent.TestCondition;
import subcore.dal.model.persistent.TestSolution;

import java.util.Set;

public interface TestSolutionDao extends CrudRepository<TestSolution, Long> {
    Set<TestSolution> findByStudentId(long studentId);
}
