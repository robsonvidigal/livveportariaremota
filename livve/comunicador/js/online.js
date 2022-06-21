function falarcom(nick,frase,id){ 
	parent.document.getElementById("falacom").value = nick;
	//parent.document.getElementById("idfalacom").value = id;
	parent.document.getElementById("exibefrase").innerHTML = frase;
	parent.document.getElementById("exibefalacom").innerHTML = nick;
	parent.document.getElementById('mensagem').focus();
}

function reenvia(){
	Online();
}

obj_online = new montaXMLHTTP();
function Online(){	
	obj_online.open("POST","online.php",true);
	obj_online.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	obj_online.onreadystatechange = function(){
		if(obj_online.readyState == 4){
				document.getElementById("online").innerHTML = obj_online.responseText;
				clearTimeout(re);
				setTimeout("Online()",5000);
		}
	}
	obj_online.send(null);
	var re = setTimeout("reenvia()",10000);
}