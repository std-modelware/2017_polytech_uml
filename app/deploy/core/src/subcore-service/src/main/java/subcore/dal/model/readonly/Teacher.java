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
@Table(name = "disciplines")
@NoArgsConstructor(access = AccessLevel.PROTECTED)
@AllArgsConstructor
@Getter
public class Teacher {
    @Id
    private int id;

    @ManyToMany
    @JoinTable(name = "disciplines_teachers",
            joinColumns = @JoinColumn(name="teachers_id", referencedColumnName = "id"),
            inverseJoinColumns = @JoinColumn(name="disciplines_id", referencedColumnName = "id"))
    private Set<Discipline> disciplines;

    public Set<Integer> getDisciplinesIds(){
        return disciplines.stream().map(Discipline::getId).collect(Collectors.toSet());
    }
}
