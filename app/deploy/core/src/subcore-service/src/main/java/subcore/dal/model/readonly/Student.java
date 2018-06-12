package subcore.dal.model.readonly;

import lombok.AccessLevel;
import lombok.AllArgsConstructor;
import lombok.Getter;
import lombok.NoArgsConstructor;
import subcore.dal.model.persistent.Subgroup;

import javax.persistence.*;
import java.util.Set;
import java.util.stream.Collectors;

@Entity
@Table(name = "students")
@NoArgsConstructor(access = AccessLevel.PROTECTED)
@AllArgsConstructor
@Getter
public class Student {
    @Id
    private long id;

    @ManyToMany
    @JoinTable(name = "subgroup_student",
            joinColumns = @JoinColumn(name="student_id", referencedColumnName = "id"),
            inverseJoinColumns = @JoinColumn(name="subgroup_id", referencedColumnName = "id"))
    private Set<Subgroup> subgroups;

    public Student(long id) {
        this.id = id;
    }

    public Set<Long> getSubgroupIds(){
        return subgroups.stream().map(Subgroup::getId).collect(Collectors.toSet());
    }
}
