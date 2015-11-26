document.observe("dom:loaded", function() {
    $("b_xml").observe("click", function(){
    	new Ajax.Request("songs_xml.php", {
    		method: "get",
    		parameters: {top: $F("top")},
    		onSuccess: showSongs_XML,
    		onFailure: ajaxFailed,
    		onException: ajaxFailed
    	});
    });
    $("b_json").observe("click", function(){
    	new Ajax.Request("songs_json.php", {
    		method: "get",
    		parameters: {top: $F("top")},
    		onSuccess: showSongs_JSON,
    		onFailure: ajaxFailed,
    		onException: ajaxFailed
    	});
    });
});

function showSongs_XML(ajax) {
	
	while($("songs").firstChild) {
		$("songs").removeChild($("songs").firstChild);
	}
	
	var temp = ajax.responseXML.getElementsByTagName("song");
	
	for (var i = 0; i < temp.length; i++) {
		var title = ajax.responseXML.getElementsByTagName("title")[i].firstChild.nodeValue;
		var artist = ajax.responseXML.getElementsByTagName("artist")[i].firstChild.nodeValue;
		var genre = ajax.responseXML.getElementsByTagName("genre")[i].firstChild.nodeValue;
		var time = ajax.responseXML.getElementsByTagName("time")[i].firstChild.nodeValue;
		
		var li = document.createElement("li");
		li.innerHTML = title+" - "+artist+" ["+genre+"] ("+time+")";
		$("songs").appendChild(li);
	}
}

function showSongs_JSON(ajax) {
	
	while($("songs").firstChild) {
		$("songs").removeChild($("songs").firstChild);
	}
	
	var data = JSON.parse(ajax.responseText);
	
	for (var i = 0; i < data.songs.length; i++) {
		var li = document.createElement("li");
		li.innerHTML = data.songs[i].title+" - "+data.songs[i].artist+" ["+data.songs[i].genre+"] ("+data.songs[i].time+")"; 
		$("songs").appendChild(li);
	}
	
}

function ajaxFailed(ajax, exception) {
	var errorMessage = "Error making Ajax request:\n\n";
	if (exception) {
		errorMessage += "Exception: " + exception.message;
	} else {
		errorMessage += "Server status:\n" + ajax.status + " " + ajax.statusText + 
		                "\n\nServer response text:\n" + ajax.responseText;
	}
	alert(errorMessage);
}
