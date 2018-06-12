package subcore.dal.dao;

import org.springframework.data.repository.CrudRepository;
import subcore.dal.model.persistent.TestCondition;
import subcore.dal.model.readonly.Discipline;
import subcore.dal.model.readonly.Test;

import java.util.Set;

public interface TestDao extends CrudRepository<Test, Long> {
    Set<Test> findByDisciplineId(int disciplineId);
}
