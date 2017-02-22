function asynchronousTreatment(path,params){
	var request = new XMLHttpRequest();
	request.open("POST", path, true);
	request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	request.onload = function(e) {
		//document.write(request.responseText);
		var arrayResult = JSON.parse(request.responseText);
		var formOk = arrayResult[0];
		if (formOk) {
			window.location = "pages/connected/listFiles.php";
		}else{
			message.innerHTML = arrayResult[1];
		}
	};
	request.send(params);
}


window.onload = function(){
	var buttonDisplay = document.getElementById('buttonDisplay');
	buttonDisplay.onclick = function(){
		var toDisplay = document.getElementsByTagName('form')[0];
		toDisplay.className = "appearingSlowly";
	}




	/*What follows is probably bad, since it is mostly copy paste, so to avoid*/

	var form = document.forms["connect"];
	form.onsubmit = function(){
		var username = encodeURIComponent(form["username"].value);
		var password = encodeURIComponent(form["password"].value);
		
		var message = document.getElementById('message');

		message.innerHTML = "";


		var params = "username="+username+"&password="+password;
		asynchronousTreatment("assets/scripts/PHP/validateLogIn.php", params);
		

		return false;	
	}
}
