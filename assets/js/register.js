$(document).ready(function() {

	//Hide login and show registration form
	$("#signUp").click(function() {
		$("#first").slideUp("slow", function() {
			$("#second").slideDown("slow");
		});
	});

	//Hide registration and show login form
	$("#signIn").click(function() {
		$("#second").slideUp("slow", function() {
			$("#first").slideDown("slow");
		});
	});

});