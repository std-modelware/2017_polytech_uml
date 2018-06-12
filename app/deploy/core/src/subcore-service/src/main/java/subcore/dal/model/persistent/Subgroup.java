package subcore.dal.model.persistent;

import com.fasterxml.jackson.annotation.JsonAutoDetect;
import com.fasterxml.jackson.annotation.JsonInclude;
import com.fasterxml.jackson.annotation.JsonProperty;
import lombok.AccessLevel;
import lombok.Getter;
import lombok.NoArgsConstructor;
import lombok.Setter;
import subcore.dal.model.readonly.Student;

import javax.persistence.*;
import java.time.LocalDateTime;
import java.util.Set;
import java.util.stream.Collectors;

@Entity
@Table(name = "subgroups")
@NoArgsConstructor(access = AccessLevel.PROTECTED)
@Getter
@Setter
@JsonInclude(JsonInclude.Include.NON_NULL)
@JsonAutoDetect(getterVisibility = JsonAutoDetect.Visibility.NONE, setterVisibility = JsonAutoDetect.Visibility.NONE)
public class Subgroup {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @JsonProperty
    private Long id;

    @ManyToMany
    @JoinTable(name = "subgroup_student",
            joinColumns = @JoinColumn(name="subgroup_id", referencedColumnName = "id"),
            inverseJoinColumns = @JoinColumn(name="student_id", referencedColumnName = "id"))
    private Set<Student> students;

    public Subgroup(Set<Long> studentIds){
        this.students = studentIds.stream().map(Student::new).collect(Collectors.toSet());
    }

    @JsonProperty
    public Set<Long> getStudentIds() {
        return students.stream().map(Student::getId).collect(Collectors.toSet());
    }

    @JsonProperty
    public void setStudentIds(Set<Long> studentIds){
        this.students = studentIds.stream().map(Student::new).collect(Collectors.toSet());
    }
 }
