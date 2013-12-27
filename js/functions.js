function follow(id,type,style,text)
{
style = (typeof style === "undefined") ? "button" : style; //button or link
text = (typeof text === "undefined") ? "short" : text; //short or long

var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
            // handle return data
            data = xmlhttp.responseText;
	    ftext=" ";
	    if (text == "long") {	
	    	if (type=="T") ftext=" Topic";
		if (type=="Q") ftext=" Question";
		if (type=="P") ftext=" User"; 
	    } 
	    document.getElementById("follow"+type+id).innerHTML = data + ftext; 
	    if (style == "button"){
		    if (data == "Follow") {
			document.getElementById("follow"+type+id).setAttribute("class", "btn btn-success");
		    } else {
			document.getElementById("follow"+type+id).setAttribute("class", "btn btn-danger");
		    }
	    }
    }
  }
xmlhttp.open("GET","/mednet/index.php/following/toggle/id/"+id+"/type/"+type,true);
xmlhttp.send();
}

function invite(id,style)
{
style = (typeof style === "undefined") ? "button" : style; //button or link
text = (typeof text === "undefined") ? "short" : text; //short or long

var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
            // handle return data
            data = xmlhttp.responseText;
            document.getElementById("invite"+id).innerHTML = data;
            if (style == "button"){
                    if (data == "Sent") {
                        document.getElementById("invite"+id).setAttribute("class", "btn btn-success");
                        document.getElementById("invite"+id).setAttribute("disabled", "disabled");
                    } else {
                        document.getElementById("invite"+id).setAttribute("class", "btn btn-danger");
                    }
            }
	    mixpanel.track('Sent Invite', {'type': 'Direct'});
    }
  }
xmlhttp.open("GET","/mednet/index.php/invitation/InviteUser/id/"+id,true);
xmlhttp.send();
}

function share(id,type,user,modal)
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
            // handle return data
            data = xmlhttp.responseText;
            document.getElementById("share"+"_"+type+"_"+modal+"_"+id+"_"+user).innerHTML = data;
                    if (data == "Sent") {
                        document.getElementById("share"+"_"+type+"_"+modal+"_"+id+"_"+user).setAttribute("class", "question-disable");
                        document.getElementById("share"+"_"+type+"_"+modal+"_"+id+"_"+user).style.color = "#a19d9d";
                    } else {
                        document.getElementById("share"+"_"+type+"_"+modal+"_"+id+"_"+user).setAttribute("class", "question-disable");
			document.getElementById("share"+"_"+type+"_"+modal+"_"+id+"_"+user).style.color = "#a19d9d";
                    }
    }
  }
xmlhttp.open("GET","/mednet/index.php/question/share/id/"+id+"/user/"+user+"/type/"+type,true);
xmlhttp.send();

}


