INSERT INTO core.disciplines(name) VALUES('discrete mathematics');

INSERT INTO core.topics(name, discipline_id) VALUES('combinatorics', 1);

INSERT INTO core.problems(statement, difficulty, discipline_id, topic_id, start_expression, final_expression) 
VALUES('Prove that A(m,n) equals A(m-1,n) + n*A(m-1,n-1)', 1, 1, 1, 'A(m,n)', 'A(m-1,n) + n*A(m-1,n-1)');

INSERT INTO core.problems(statement, difficulty, discipline_id, topic_id, start_expression, final_expression) 
VALUES('Prove that F(n+3) - F(n) equals 2 * F(n+1)', 2, 1, 1, 'F(n+3) - F(n)', '2 * F(n+1)');

INSERT INTO core.problems(statement, difficulty, discipline_id, topic_id, start_expression, final_expression) 
VALUES('Prove that B(m) equals S(n,0,m,S1(m,n)/P(n))', 3, 1, 1, 'B(m)', 'S(n,0,m,S1(m,n)/P(n))');

INSERT INTO core.problems(statement, difficulty, discipline_id, topic_id, start_expression, final_expression) 
VALUES('Prove that B(m) equals S(n,0,m,S1(m,n)/P(n))', 3, 1, 1, 'B(m)', 'S(n,0,m,S1(m,n)/P(n))');

INSERT INTO core.tests(discipline_id) VALUES(1);

INSERT INTO core.tests_problems(problem_id, test_id, score, problem_local_id) VALUES(1, 1, 20, 2);

INSERT INTO core.tests_problems(problem_id, test_id, score, problem_local_id) VALUES(2, 1, 35, 3);

INSERT INTO core.tests_problems(problem_id, test_id, score, problem_local_id) VALUES(3, 1, 45, 1);



