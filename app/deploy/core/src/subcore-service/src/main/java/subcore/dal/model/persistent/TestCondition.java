package subcore.dal.model.persistent;

import com.fasterxml.jackson.annotation.JsonAutoDetect;
import com.fasterxml.jackson.annotation.JsonInclude;
import lombok.*;

import javax.persistence.*;
import java.time.LocalDateTime;

@Entity
@Table(name = "test_condition")
@NoArgsConstructor(access = AccessLevel.PROTECTED)
@ToString
@Getter
@Setter
@JsonInclude(JsonInclude.Include.NON_NULL)
@JsonAutoDetect(getterVisibility = JsonAutoDetect.Visibility.NONE, setterVisibility = JsonAutoDetect.Visibility.NONE)
public class TestCondition {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    private long subgroupId;

    private long teacherId;

    private long studentId;

    private LocalDateTime startTime;

    private LocalDateTime finishTime;

    private long testId;
}
