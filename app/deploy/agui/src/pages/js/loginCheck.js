function Check(){
	if (!$('input[name=login]').val() || !$('input[name=password]').val()) {  
		if (!$('input[name=login]').val()) {
			$('#loginForm').addClass('has-error');
		}
		if (!$('input[name=password]').val()) {
			$('#passwordForm').addClass('has-error');
		} 
		$('#error-login').modal('show') // заполнены не все поля
	} else {
		// проверка логина и пароля, переход на страницы
		if ($('input[name=login]').val()=="teacher")
			window.location="teacher_problems.html";
		else if ($('input[name=login]').val()=="student")
			window.location="student_results.html";
		else if ($('input[name=login]').val()=="admin")
			window.location="admin_data_insert.html";
		else {
			// неверный логин или пароль
			$('#loginForm').addClass('has-error');
			$('#passwordForm').addClass('has-error');
			$('#error-login-1').modal('show') 
		}
	}
}

function Input() {
	if ($('input[name=login]').val()) {
		$('#loginForm').removeClass('has-error');
	}
	else{
		$('#loginForm').addClass('has-error');
	}
	if ($('input[name=password]').val()) {
		$('#passwordForm').removeClass('has-error');
	}
	else {
		$('#passwordForm').addClass('has-error');
	}
}