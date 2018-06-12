package subcore.service;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;
import subcore.dal.dao.StudentDao;
import subcore.dal.dao.SubgroupDao;
import subcore.dal.model.persistent.Subgroup;
import subcore.dal.model.readonly.Student;
import subcore.exceptions.EntityNotFoundException;

import java.util.Set;

@Service
public class SubgroupService {
    @Autowired
    private SubgroupDao subgroupDao;

    @Autowired
    private StudentDao studentDao;

    public Subgroup create(Subgroup subgroup) throws EntityNotFoundException{
        for(long studentId : subgroup.getStudentIds()){
            if (!studentDao.existsById(studentId)){
                throw new EntityNotFoundException(Student.class.getSimpleName(), studentId);
            }
        }
        return subgroupDao.save(subgroup);
    }

    public Set<Subgroup> getByStudent(long studentId) throws EntityNotFoundException{
        return studentDao.findById(studentId)
                         .orElseThrow(() -> new EntityNotFoundException(Student.class.getSimpleName(), studentId))
                         .getSubgroups();
    }

    public Subgroup getStudents(long subgroupId) throws EntityNotFoundException {
        return subgroupDao.findById(subgroupId)
                          .orElseThrow(() -> new EntityNotFoundException(Subgroup.class.getSimpleName(), subgroupId));
    }

    public Subgroup updateStudentList(Subgroup subgroup, long subgroupId) throws EntityNotFoundException{
        if (!subgroupDao.existsById(subgroupId)) {
            throw new EntityNotFoundException(Subgroup.class.getSimpleName(), subgroupId);
        }

        for (long studentId : subgroup.getStudentIds()) {
            if (!studentDao.existsById(studentId)) {
                throw new EntityNotFoundException(Student.class.getSimpleName(), studentId);
            }
        }
        subgroup.setId(subgroupId);
        return subgroupDao.save(subgroup);
    }

    public void deleteSubgroup(long subgroupId) throws EntityNotFoundException {
        Subgroup subGroup = subgroupDao.findById(subgroupId)
                                       .orElseThrow(() -> new EntityNotFoundException(Subgroup.class.getSimpleName(), subgroupId));
        subgroupDao.delete(subGroup);
    }


}
