INSERT INTO core.disciplines(name) VALUES('discrete mathematics');

INSERT INTO core.topics(name, discipline_id) VALUES('combinatorics', 1);

INSERT INTO core.problems(statement, difficulty, discipline_id, topic_id, start_expression, final_expression) 
VALUES('Prove that tg(sin(x+y))*sin(y+ctg(x)) equals tg(sin(x+2*y-y))*sin(y+ctg(x))', 1, 1, 1, 'tg(sin(x+y))*sin(y+ctg(x))', 'tg(sin(x+2*y-y))*sin(y+ctg(x))');

INSERT INTO core.problems(statement, difficulty, discipline_id, topic_id, start_expression, final_expression) 
VALUES('Prove that 2 equals 2', 2, 1, 1, '2', '2');

INSERT INTO core.problems(statement, difficulty, discipline_id, topic_id, start_expression, final_expression) 
VALUES('Prove that 3 equals 3', 3, 1, 1, '3', '3');

INSERT INTO core.problems(statement, difficulty, discipline_id, topic_id, start_expression, final_expression) 
VALUES('Prove that tg(sin(x+y))*sin(y+ctg(x)) + 1 equals tg(sin(x+2*y-y))*sin(y+ctg(x)) + 1', 3, 1, 1, 'tg(sin(x+y))*sin(y+ctg(x)) + 1', 'tg(sin(x+2*y-y))*sin(y+ctg(x)) + 1');

INSERT INTO core.tests(discipline_id) VALUES(1);

INSERT INTO core.tests_problems(problem_id, test_id, score, problem_local_id) VALUES(1, 1, 20, 1);

INSERT INTO core.tests_problems(problem_id, test_id, score, problem_local_id) VALUES(2, 1, 35, 2);

INSERT INTO core.tests_problems(problem_id, test_id, score, problem_local_id) VALUES(3, 1, 45, 3);

INSERT INTO core.tests_problems(problem_id, test_id, score, problem_local_id) VALUES(4, 1, 50, 4);



