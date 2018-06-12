package subcore.dal.model.readonly;

import lombok.Getter;
import lombok.Setter;

import javax.persistence.Entity;
import javax.persistence.ForeignKey;
import javax.persistence.Id;
import javax.persistence.Table;

@Entity
@Table(name = "tests")
@Getter
@Setter
public class Test {
    @Id
    private int testId;

    private int disciplineId;
}
