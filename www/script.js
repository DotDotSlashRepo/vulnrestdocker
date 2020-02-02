function reset() {
	document.getElementById("url_box").value = '';
	document.getElementById("request_method").value = 'GET';
	document.getElementById("json_body").value = '';
}

function api_test() {
	var method = document.getElementById("request_method").value;
	var theUrl = document.getElementById("url_box").value;
	var theBody = document.getElementById("json_body").value;
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("json_response").innerHTML = this.responseText;
		}
	};
	xmlhttp.open(method, theUrl);
	xmlhttp.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
	if (document.getElementById("json_body").value == '')
		xmlhttp.send(JSON.stringify());
	else
		xmlhttp.send(theBody);
	//document.getElementById("json_response").innerHTML=xmlhttp.responseText;
}