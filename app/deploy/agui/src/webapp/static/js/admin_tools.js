var groups = 
[
    {
        "number": "13641/1"
    },
    {
        "number": "13641/2"
    },
    {
        "number": "13641/3"
    }
];
var classes = 
[
    {
        "name": "Математический анализ"
    },
    {
        "name": "Программирование на С"
    },
    {
        "name": "UML"
    }
];
var teachers = 
[
    {
        "name": "Новиков Федор Александрович"
    },
    {
        "name": "Штурц Игорь Викторович"
    }
];

$(function () {
    populateGroupSelect();
    populateClassSelect();
    populateTeachersSelect();
    $('#group-date-picker').datepicker();
});

function populateGroupSelect() {
    var sel = document.getElementsByClassName("group-select");
    for(var j = 0; j < sel.length; j++) {
        for(var i = 0; i < groups.length; i++) {
            var opt = document.createElement('option');
            opt.innerHTML = groups[i].number;
            opt.value = groups[i].number;
            sel[j].appendChild(opt);
        }
    }
}

function populateClassSelect() {
    var sel = document.getElementsByClassName("classes-select");
    for(var j = 0; j < sel.length; j++) {
        for(var i = 0; i < classes.length; i++) {
            var opt = document.createElement('option');
            opt.innerHTML = classes[i].name;
            opt.value = classes[i].name;
            sel[j].appendChild(opt);
        }
    }
}

function populateTeachersSelect() {
    var sel = document.getElementsByClassName("teachers-select");
    for(var j = 0; j < sel.length; j++) {
        for(var i = 0; i < teachers.length; i++) {
            var opt = document.createElement('option');
            opt.innerHTML = teachers[i].name;
            opt.value = teachers[i].name;
            sel[j].appendChild(opt);
        }
    }
}

function CheckFromFile() {
	if (!$('input[id=file-input]').val()) {
		$('#fileForm').addClass('has-error');
		$('#errorSpaces').modal('show');
	}
	else {
		$('#new-success').modal('show');
	}
}

function insertSuccessModalOpen() {
		$('#new-success').modal('show');
}

function InputNewGroup() {
	if ($('input[id=number]').val()) {
		$('#numberForm').removeClass('has-error');
	}
	else {
		$('#numberForm').addClass('has-error');
	}
	
	if ($('input[id=date-input]').val()) {
		$('#dateForm').removeClass('has-error');
	}
	else {
		$('#dateForm').addClass('has-error');
	}
}

function CheckNewGroup() {
	if (!$('input[id=number]').val() || !$('input[id=date-input]').val()) {
		if (!$('input[id=number]').val()) {
			$('#numberForm').addClass('has-error');
		}
		if (!$('input[id=date-input]').val()) {
			$('#dateForm').addClass('has-error');
		}
		$('#errorSpaces').modal('show');
	}
	else {
		$('#new-group').modal('hide');
		$('#new-success').modal('show');
	}
}

function InputNewTeacher() {
	if ($('input[id=fio-input]').val()) {
		$('#fioForm').removeClass('has-error');
	}
	else {
		$('#fioForm').addClass('has-error');
	}
}

function CheckNewTeacher() {
	if (!$('input[id=fio-input]').val()) {
		$('#fioForm').addClass('has-error');
		$('#errorSpaces').modal('show');
	}
	else {
		$('#new-teach').modal('hide');
		$('#new-success').modal('show');
	}
}

function InputNewStudent() {	
	if ($('input[id=name-input]').val()) {
		$('#nameForm').removeClass('has-error');
	}
	else {
		$('#nameForm').addClass('has-error');
	}
}

function CheckNewStudent() {
	if (!$('input[id=name-input]').val()) {
		$('#nameForm').addClass('has-error');
		$('#errorSpaces').modal('show');
	}
	else {
		$('#new-student').modal('hide');
		$('#new-success').modal('show');
	}
}


function CheckNewDiscipline() {
	if (!$('input[id=discipline]').val()) {
		$('#disciplineForm').addClass('has-error');
		$('#errorSpaces').modal('show');
	}
	else {
		$('#new-class').modal('hide');
		$('#new-success').modal('show');
	}
}

function InputNewDiscipline() {		
	if ($('input[id=discipline]').val()) {
		$('#disciplineForm').removeClass('has-error');
	}
	else {
		$('#disciplineForm').addClass('has-error');
	}	
}

function addSuccess() {
    $('#new-assign').modal('hide');
    $('#new-success').modal('show');
}
