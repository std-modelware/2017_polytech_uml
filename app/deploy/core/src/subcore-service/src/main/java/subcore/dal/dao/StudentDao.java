package subcore.dal.dao;

import org.springframework.data.repository.CrudRepository;
import subcore.dal.model.readonly.Student;

public interface StudentDao extends CrudRepository<Student, Long> {
}
