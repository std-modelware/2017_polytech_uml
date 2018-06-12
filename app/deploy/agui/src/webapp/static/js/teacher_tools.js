var problems = 
[
    {
        "id": 15,
        "disciplines_name": "Дискретная математика",
        "topics_name": "Комбинаторика",
        "difficulty": 2,
        "statement": "Посчитать 2 + 2"
    },
    {
        "id": 678,
        "disciplines_name": "Дискретная математика",
        "topics_name": "Логика",
        "difficulty": 3,
        "statement": "Посчитать 2 + 3"
    },
    {
        "id": 1456,
        "disciplines_name": "Программирование",
        "topics_name": "Кодирование",
        "difficulty": 5,
        "statement": "Посчитать 5 + 2"
    },
    {
        "id": 1457,
        "disciplines_name": "Физика",
        "topics_name": "Теория относительности",
        "difficulty": 5,
        "statement": "Посчитать 2 * 2"
    }
];

var tests = 
[
    {
        "id": 15,
        "disciplines_name": "Дискретная математика",
        "teachers_name": "Новиков Федор Александрович"
    },
    {
        "id": 678,
        "disciplines_name": "Численные методы",
        "teachers_name": "Иванов Иван Иванович"
    },
    {
        "id": 1044,
        "disciplines_name": "Интернет технологии",
        "teachers_name": "Новиков Федор Александрович"
    },
    {
        "id": 1698,
        "disciplines_name": "Физика",
        "teachers_name": "Смирнов Илья Семенович"
    }
];

var test_problems = 
[
    {
        "id": 15,
        "topics_name": "Алгебра",
        "statement": "Посчитать 2+2",
        "difficulty": 1,
        "score": 40
    },
    {
        "id": 678,
        "topics_name": "Комбинаторика",
        "statement": "Посчитать 2+2",
        "difficulty": 3,
        "score": 35
    },
        {
        "id": 1056,
        "topics_name": "Алгебра",
        "statement": "Посчитать 2+2",
        "difficulty": 2,
        "score": 10
    }
];

var new_test_problems = 
[
    {
        "id": 15,
        "topics_name": "Алгебра",
        "statement": "Посчитать 2+2",
        "difficulty": 1,
        "score": 40
    },
    {
        "id": 678,
        "topics_name": "Комбинаторика",
        "statement": "Посчитать 2+2",
        "difficulty": 3,
        "score": 35
    },
    {
        "id": 1056,
        "topics_name": "Алгебра",
        "statement": "Посчитать 2+2",
        "difficulty": 2,
        "score": 10
    }
];

var report = 
[
    {
        "student_name": "Васильев И.П.",
        "score": "хорошо"
    },
    {
        "student_name": "Иванов П.В.",
        "score": "отлично"
    },
    {
        "student_name": "Петров В.И.",
        "score": "удовлетворительно"
    }
];

$(function () {
    $('#tableProblems').bootstrapTable({ 
    	data: problems
    });
});

$(function () {
    $('#tableTests').bootstrapTable({ 
    	data: tests
    });
});

$(function () {
    $('#tableTestProblems').bootstrapTable({ 
    	data: test_problems
    });
});

$(function () {
    $('#tableNewTest').bootstrapTable({ 
    	data: new_test_problems
    });
});

$(function () {
    $('#tableReport').bootstrapTable({ 
    	data: report
    });
});

function watchProblem() {
    return '<a href="#" class="btn btn-info" onclick="problemStatementModal()">Просмотреть</a>';
}

function editProblem() {
    return '<a href="teacher_edit_problem.html" class="btn btn-warning">Изменить</a>';
}

function deleteProblem() {
    return '<a href="#" class="btn btn-danger" onclick="deleteProblemModal()">Удалить</a>';
}

function problemStatementModal(){
	$('#problemStatement').modal('show');
}

function deleteProblemModal(){
	$('#deleteProblem').modal('show');
}

function onDeleteProblem() {
	$('#deleteProblem').modal('hide');
    $('#deleteProblemSuccess').modal('show');
}

function watchProblems() {
    return '<a href="teacher_test_problems.html" class="btn btn-info">Просмотреть</a>';
}

function deleteTest() {
    return '<a href="#" class="btn btn-danger" onclick="deleteTestModal()">Удалить</a>';
}

function deleteTestModal(){
	$('#deleteTest').modal('show');
}

function onDeleteTest() {
	$('#deleteTest').modal('hide');
    $('#deleteTestSuccess').modal('show');
}

var currentNumber = 1;
function number(){
	return currentNumber++;
}

function editScore() {
	return '<input type="text" id="editScore"/>';
}

function CheckNewTest() {
	$('#newTestSuccess').modal('show');
}

function Check(){
	if (!$('textarea[name=statement]').val() || 
		!$('input[name=startExpression]').val() || 
		!$('input[name=finalExpression]').val() ||
		!$('input[name=difficulty]').val()) {  
		if (!$('textarea[name=statement]').val()) {
			$('#statementForm').addClass('has-error');
		}
		if (!$('input[name=startExpression]').val()) {
			$('#startExprForm').addClass('has-error');
		} 
		if (!$('input[name=finalExpression]').val()) {
			$('#finalExprForm').addClass('has-error');
		}
		if (!$('input[name=difficulty]').val()) {
			$('#difficultyForm').addClass('has-error');
		}
		$('#errorSpaces').modal('show');
	}
	else {
		$('#newProblemSuccess').modal('show');
	}
}

function Input() {
	if ($('textarea[name=statement]').val()) {
		$('#statementForm').removeClass('has-error');
	}
	else {
		$('#statementForm').addClass('has-error');
	}
	if ($('input[name=startExpression]').val()) {
		$('#startExprForm').removeClass('has-error');
	}
	else {
		$('#startExprForm').addClass('has-error');
	} 
	if ($('input[name=finalExpression]').val()) {
		$('#finalExprForm').removeClass('has-error');
	}
	else {
		$('#finalExprForm').addClass('has-error');
	}
	if ($('input[name=difficulty]').val()) {
		$('#difficultyForm').removeClass('has-error');
	}
	else {
		$('#difficultyForm').addClass('has-error');
	}
}

function toggleList() {
	var lst = document.getElementById("lst");
	lst.classList.toggle("hidden");
	
}

function toggleReportCreate() {
	var reportForm = document.getElementById("reportForm");
	reportForm.classList.toggle("hidden");
}