package subcore.dal.dao;

import org.springframework.data.domain.Example;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.repository.CrudRepository;
import subcore.dal.model.persistent.TestCondition;

import java.util.Optional;
import java.util.Set;

public interface TestConditionDao extends CrudRepository<TestCondition, Long> {
    Set<TestCondition> findBySubgroupId(long subgroupId);

    Set<TestCondition> findByTestId(long testId);
}
