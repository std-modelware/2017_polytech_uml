package subcore.dal.dao;

import org.springframework.data.repository.CrudRepository;
import subcore.dal.model.readonly.Teacher;
import subcore.dal.model.readonly.Test;

public interface TeacherDao extends CrudRepository<Teacher, Long> {
}
