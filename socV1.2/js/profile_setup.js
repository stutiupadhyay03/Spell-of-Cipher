function select_female()
{
	document.getElementById("gender").value= "female";
	girl = document.getElementById("female");
	girl.style.border ="3px solid black";
	boy = document.getElementById("male");
	boy.style.border ="0px solid transparent";
	girl.value="female";
	boy.value="";
}

function select_male()
{
	document.getElementById("gender").value= "male";
	boy = document.getElementById("male");
	boy.style.border ="3px solid black";
	girl = document.getElementById("female");
	girl.style.border ="0px solid transparent";
	boy.value="male";
	girl.value="";
}

function profile_pics(id){
	 document.getElementById("userlogo").value = id;
	 document.getElementById("selected").src = "images/profiletoons/"+id+".png";

	
}