function Send(){
	$.ajax({
            url: "/login/",
            type: "POST",
            data: JSON.stringify({
            	"login": $('input[name=login]').val(), 
            	"password": $('input[name=password]').val()
            	 }),
            contentType: 'application/json;charset=UTF-8',
            success: function () {
				window.location.replace("/");
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
			    console.log("error");	    
				$('#error-login-1').modal('show') // заполнены не все поля
            }

       });
}

function CheckSend(){
    console.log("ckicked");
	if (!$('input[name=login]').val() || !$('input[name=password]').val()) {  
		$('#error-login').modal('show') // заполнены не все поля
	} else {
	    console.log("sending");	    
		Send();
	}
}

function Input() {
    console.log("input");	    
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