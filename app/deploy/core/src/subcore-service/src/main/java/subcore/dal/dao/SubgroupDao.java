package subcore.dal.dao;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.repository.CrudRepository;
import org.springframework.data.repository.Repository;
import subcore.dal.model.persistent.Subgroup;

public interface SubgroupDao extends CrudRepository<Subgroup, Long> {
}
