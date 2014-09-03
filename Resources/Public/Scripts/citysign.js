var citysignask = null;
var addressLine = "";
var ageInputValue = "";
var globalLat = null;
var globalLng = null;
var citysigninputButton = null;
var dontAskedSaved = true;

function citysignStartup(force, dontask) {
	addressInfo = readCookie('hkj_info');
	if (force == false) {
		dontAskedSaved = dontask;
	}
	if (addressInfo == null || force) {
		if (dontask) return false;
		added = false;
		if (document.getElementById("helfen_kann_jeder_citysign") == null) {
			insertCitysignAskscreen();
			added = true;
		}
		if (force == true) {
			if (document.getElementById("helfen_kann_jeder_citysign").style.display == "" && !added) {
				citysigninputButton.onclick();
				return false;
			}
			document.getElementById("helfen_kann_jeder_citysign").style.display = "none";
			showQuestionBox(0);
		}
	} else {
		infosDetail = addressInfo.split("##1##");
		if (infosDetail.length >= 6) {
			setAddressInfo(infosDetail[3], infosDetail[0], infosDetail[1], infosDetail[2], infosDetail[4], infosDetail[5]);
		}
	}
}

function absLeft(el) {
	return (el.offsetParent)?  el.offsetLeft+absLeft(el.offsetParent) : el.offsetLeft;
}

function absTop(el) {
	return (el.offsetParent)?  el.offsetTop+absTop(el.offsetParent) : el.offsetTop;
} 



function insertCitysignAskscreen() {
	if (citysignask == null) {
		citysignask = document.createElement("div");
		citysignask.id = "helfen_kann_jeder_citysign";
		citysignask.style.width = document.getElementById("inner_body").offsetWidth+"px";
		citysignask.style.height = document.getElementById("inner_body").offsetHeight+"px";

		citysignask.style.backgroundImage = CITYSIGN_CONSTANT_BACKGROUND_IMAGE;
		citysignask.style.position = "absolute";
		citysignask.style.top = absTop(document.getElementById("inner_body"))+"px";
		citysignask.style.left = absLeft(document.getElementById("inner_body"))+"px";

		citysignsymbolDiv = document.createElement("div");
		citysignsymbolDiv.className = "helfen_kann_jeder_citysign_exclamationmark";
		citysignsymbol = document.createElement("img");
		citysignsymbol.src = CITYSIGN_CONSTANT_EXCLEMATIONMARK;
		citysignsymbolDiv.appendChild(citysignsymbol);
		citysignask.appendChild(citysignsymbolDiv);

		citysigninfoDiv = document.createElement("div");
		citysigninfoDiv.className = "helfen_kann_jeder_citysign_text";
		citysigninfoDiv.innerHTML = document.getElementById("helfenkannjeder_citysign_description").innerHTML;
		citysignask.appendChild(citysigninfoDiv);

		clearer = document.createElement("br");
		clearer.style.clear = "both";
		citysignask.appendChild(clearer);

		citysigninputDiv = document.createElement("div");

		citysigninputDiv.className = "helfen_kann_jeder_citysign_input_div";
		citysigninput = document.createElement("input");
		citysigninput.tabIndex = 1;
		citysigninput.className = "helfen_kann_jeder_citysign_input";
		citysigninput.id = "helfen_kann_jeder_citysign_input";
		citysigninput.onkeyup = function (e) {
			if ((e?e.which:event.keyCode) == 13) {
				citysigninputButton.onclick();
			}
		}

		if (addressLine == "") {
			citysigninput.value = CITYSIGN_CONSTANT_LANGUAGE_INPUT_FIELD;
		} else {
			citysigninput.value = addressLine;
		}
		citysigninput.onfocus = function() {
			if (this.value == CITYSIGN_CONSTANT_LANGUAGE_INPUT_FIELD) {
				this.value = "";
			}
		}
		citysigninput.onblur = function() {
			if (this.value == "") {
				this.value = CITYSIGN_CONSTANT_LANGUAGE_INPUT_FIELD;
			}
		}

		citysigninputDiv.appendChild(citysigninput);

		citysigninputButton = document.createElement("input");
		citysigninputButton.type = "submit";
		citysigninputButton.tabIndex = 3;
		citysigninputButton.className = "helfen_kann_jeder_citysign_submit";
		citysigninputButton.value = CITYSIGN_CONSTANT_LANGUAGE_SUBMIT_BUTTON;
		citysigninputButton.onclick = function () {
			geocoder = new google.maps.Geocoder();
			address = "Germany, "+document.getElementById("helfen_kann_jeder_citysign_input").value;
			if (geocoder) {
				geocoder.geocode( { 'address': address}, function(results, status) {
					if (status == google.maps.GeocoderStatus.OK) {
						city = "";
						postalcode = "";
						street = "";
						streetnumber = "";
						country = "";
						level1 = "";
						for (i=0;i<results[0].address_components.length;i++) {
							if (results[0].address_components[i]["types"][0] == "country") {
								country = results[0].address_components[i]["short_name"];
							}
							if (results[0].address_components[i]["types"][0] == "administrative_area_level_1") {
								level1 = results[0].address_components[i]["short_name"];
							}
							if (results[0].address_components[i]["types"][0] == "locality") {
								city = results[0].address_components[i]["long_name"];
							}
							if (results[0].address_components[i]["types"][0] == "postal_code") {
								postalcode = results[0].address_components[i]["long_name"];
							}
							if (results[0].address_components[i]["types"][0] == "route") {
								street = results[0].address_components[i]["long_name"];
							}
							if (results[0].address_components[i]["types"][0] == "street_number") {
								streetnumber = results[0].address_components[i]["long_name"];
							}
						}
						if (level1 == "BW" && (country == "Germany" || country == "Deutschland" || country == "DE")) {
							document.getElementById("helfen_kann_jeder_citysign_error").style.display = "none";
							hideQuestionBox(100);
							createCookie("hkj_info",results[0].geometry.location.lat()+"##1##"+
										results[0].geometry.location.lng()+"##1##"+
										document.getElementById("helfen_kann_jeder_citysign_input").value+"##1##"+
										city+"##1##"+parseInt(document.getElementById("helfen_kann_jeder_citysign_age_input").value)+"##1##"+street+" "+streetnumber
										,365);
							if (parseInt(document.getElementById("helfen_kann_jeder_citysign_age_input").value)+"-" == "NaN-")
								document.getElementById("helfen_kann_jeder_citysign_age_input").value = "";

							setAddressInfo(city, results[0].geometry.location.lat(), results[0].geometry.location.lng(), document.getElementById("helfen_kann_jeder_citysign_input").value, parseInt(document.getElementById("helfen_kann_jeder_citysign_age_input").value), street+" "+streetnumber);
							var currentSide = window.location.pathname.split("/");
							if (currentSide[1] == "bei-wem" || (currentSide[1] == "helf-o-mat" && window.location.search != '')) {
								window.location.reload();
							}
						} else {
							// Error
							document.getElementById("helfen_kann_jeder_citysign_error").innerHTML = CITYSIGN_CONSTANT_LANGUAGE_ERROR_NOT_KA;
							document.getElementById("helfen_kann_jeder_citysign_error").style.display = "";
						}
        				} else {
						if (status == "ZERO_RESULTS") {
							document.getElementById("helfen_kann_jeder_citysign_error").innerHTML = CITYSIGN_CONSTANT_LANGUAGE_ERROR_NOT_FOUND;
						} else {
							document.getElementById("helfen_kann_jeder_citysign_error").innerHTML = CITYSIGN_CONSTANT_LANGUAGE_ERROR_TECHNICAL + status;
						}
						document.getElementById("helfen_kann_jeder_citysign_error").style.display = "";
					}
					$.post(CITYSIGN_AJAX_URL, { tx_helfenkannjeder_citysignlist: {address: address,
						street: street, city: city, zipcode: postalcode, longitude: results[0].geometry.location.lng(), latitude: results[0].geometry.location.lat(), response: status, age: document.getElementById("helfen_kann_jeder_citysign_age_input").value} }, function(response) { });
				});
			}

		}
		citysigninputDiv.appendChild(citysigninputButton);

		citysignask.appendChild(citysigninputDiv);


		ageDiv = document.createElement("div");
		ageDiv.className = "helfen_kann_jeder_citysign_age";
		ageText = document.createTextNode(CITYSIGN_CONSTANT_LANGUAGE_ASK_AGE);
		ageDiv.appendChild(ageText);

		ageInput = document.createElement("input");
		ageInput.id = "helfen_kann_jeder_citysign_age_input";
		ageInput.tabIndex = 2;
		if (ageInputValue != null && ageInputValue != NaN && ageInputValue != "NaN") {
			ageInput.value = ageInputValue;
		}
		ageInput.onkeyup = function (e) {
			if ((e?e.which:event.keyCode) == 13) {
				citysigninputButton.onclick();
			}
		}
		ageDiv.appendChild(ageInput);

		citysignask.appendChild(ageDiv);

		errorDiv = document.createElement("div");
		errorDiv.style.display = "none";
		errorDiv.id = "helfen_kann_jeder_citysign_error";
		citysignask.appendChild(errorDiv);
		document.getElementById("inner_bodys").appendChild(citysignask);
	}
}

function hideQuestionBox(percent) {
	leftScaleEnd = document.getElementById("citysign").offsetLeft-document.getElementById("helfen_kann_jeder_citysign").offsetLeft+(document.getElementById("citysign").offsetWidth/2);

	leftScale = (100-percent)/100*leftScaleEnd;
	rightScaleEnd = leftScaleEnd + (document.getElementById("helfen_kann_jeder_citysign").offsetWidth-leftScaleEnd)*percent/100;
	bottomScale = percent/100*document.getElementById("helfen_kann_jeder_citysign").offsetHeight;

	document.getElementById("helfen_kann_jeder_citysign").style.clip = "rect(auto "+rightScaleEnd+"px "+bottomScale+"px "+leftScale+"px)";

	if (percent == 0) {
		document.getElementById("helfen_kann_jeder_citysign").style.display = "none";
	}
	percent -= 10;
	if (percent >= 0) {
		window.setTimeout("hideQuestionBox("+percent+");", 50);
	}
}

function showQuestionBox(percent) {
	if (percent == 0) {
		if (document.getElementById("helfen_kann_jeder_citysign").style.display == "") {
			return false;
		}
		document.getElementById("helfen_kann_jeder_citysign").style.display = "";
	}

	leftScaleEnd = document.getElementById("citysign").offsetLeft-document.getElementById("helfen_kann_jeder_citysign").offsetLeft+(document.getElementById("citysign").offsetWidth/2);

	leftScale = (100-percent)/100*leftScaleEnd;
	rightScaleEnd = leftScaleEnd + (document.getElementById("helfen_kann_jeder_citysign").offsetWidth-leftScaleEnd)*percent/100;
	bottomScale = percent/100*document.getElementById("helfen_kann_jeder_citysign").offsetHeight;

	document.getElementById("helfen_kann_jeder_citysign").style.clip = "rect(auto "+rightScaleEnd+"px "+bottomScale+"px "+leftScale+"px)";

	percent += 10;
	if (percent <= 100) {
		window.setTimeout("showQuestionBox("+percent+");", 50);
	}
}

function createCookie(name,value,days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime()+(days*24*60*60*1000));
		var expires = "; expires="+date.toGMTString();
	}
	else var expires = "";

	value = encodeURIComponent(value);
	document.cookie = name+"="+value+expires+"; path=/";
}

function readCookie(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return decodeURIComponent(c.substring(nameEQ.length,c.length));
	}
	return null;
}

function eraseCookie(name) {
	createCookie(name,"",-1);
}

marker = null;

function setAddressInfo(city, lat, lng, addressline, userAge, street) {
	addressLine = addressline;
	ageInputValue = userAge;
	globalLat = lat;
	globalLng = lng;

	if (document.getElementById("helfen_kann_jeder_generator_step2") != null) {
		if (userAge < 18) {
			document.getElementById("helfen_kann_jeder_generator_step2").style.display = "none";
			document.getElementById("helfen_kann_jeder_generator_background").style.backgroundImage = CITYSIGN_CONSTANT_BACKGROUND_IMAGE_YOUTH;
			document.getElementById("helfen_kann_jeder_generator_background").className = "helfen_kann_jeder_generator_background_youth";
			

			actField = selectedActivityFields;
			refreshActivityFieldList();

			for (i=0;i<document.getElementById("helfen_kann_jeder_search_result_list_all").getElementsByTagName("li").length;i++) {
				if (!proveActivity(document.getElementById("helfen_kann_jeder_search_result_list_all").getElementsByTagName("li")[i].id.substring(32))) {
					document.getElementById("helfen_kann_jeder_search_result_list_all").getElementsByTagName("li")[i].style.display = "none";
				}
			}

			selectedActivityFields = new Array();
			addSelectedActivityField(18);
			start_resort();
		} else {
			document.getElementById("helfen_kann_jeder_generator_step2").style.display = "";
			document.getElementById("helfen_kann_jeder_generator_background").style.backgroundImage = CITYSIGN_CONSTANT_ARROW_IMAGE;
			document.getElementById("helfen_kann_jeder_generator_background").className = "helfen_kann_jeder_generator_background_normal";
			selectedActivityFields = new Array();
			refreshActivityFieldList();
			start_resort();

			for (i=0;i<document.getElementById("helfen_kann_jeder_search_result_list_all").getElementsByTagName("li").length;i++) {
				document.getElementById("helfen_kann_jeder_search_result_list_all").getElementsByTagName("li")[i].style.display = "";
			}
		}
	}

	if (typeof(hkjMap) != "undefined" && hkjMap != null) {
		if (marker != null) {
			marker.setMap(null);
		}

		loc = new google.maps.LatLng(lat, lng);
		hkjMap.setCenter(loc);
		if (fluster != undefined) {
			fluster.zoomChanged();
		}
		markerInfo = new Object();
		markerInfo["map"] = hkjMap;
		markerInfo["position"] = loc;
		markerInfo["title"] = CITYSIGN_CONSTANT_LANGUAGE_YOUR_POSITION;
		marker = new google.maps.Marker(markerInfo);
		google.maps.event.addListener(marker, 'click', function() {
			citysignStartup(true, false);
		});
	}


	$("#logo_text").text(CITYSIGN_CONSTANT_LANGUAGE_ALSO_IN+city);
	if (dontAskedSaved == false) {
		if (document.getElementById("helfen_kann_jeder_citysign_current_addressbar") != undefined) {
			document.getElementById("helfen_kann_jeder_citysign_current_addressbar").parentNode.removeChild(document.getElementById("helfen_kann_jeder_citysign_current_addressbar"));
		}

		newElement = document.createElement("div");
		newElement.id = "helfen_kann_jeder_citysign_current_addressbar";
        
		newElement.appendChild(document.createTextNode("Deine Adresse: "+city+", "+street+" "));
		newElementEdit = document.createElement("span");
		newElementEdit.className = "helfen_kann_jeder_citysign_current_addressbar_edit";
		newElementEdit.appendChild(document.createTextNode("(ändern)"));
        
		newElementEdit.onclick = function () {
			citysignStartup(true, false);
		}
        
		newElement.appendChild(newElementEdit);
        
		document.getElementById("content").insertBefore(newElement, document.getElementById("content").firstChild);
	}
}

tx_helfenkannjeder_organisation_current = new Array();
tx_helfenkannjeder_organisation_current[0] = 1;
tx_helfenkannjeder_organisation_current[1] = 2;
tx_helfenkannjeder_organisation_current[2] = 3;
tx_helfenkannjeder_organisation_current[3] = 4;
tx_helfenkannjeder_organisation_current[4] = 5;
tx_helfenkannjeder_organisation_current[5] = 6;
tx_helfenkannjeder_organisation_current[6] = 7;
tx_helfenkannjeder_organisation_current[7] = 8;
tx_helfenkannjeder_organisation_current[8] = 10;

window.onload = function() {
	citysignStartup(false, true);
	// Slideshow
	if (typeof tx_helfenkannjeder_set_organisation == 'function') {
		tx_helfenkannjeder_set_organisation(tx_helfenkannjeder_organisation_current);
	}
}

function getAgeInputValue() {
	if (ageInputValue == "" || ageInputValue == NaN || ageInputValue == "NaN" || isNaN(ageInputValue)) {
		return 18;
	} else {
		return ageInputValue;
	}
}

var gl;
 
function displayPosition(position) {
	geocoder = new google.maps.Geocoder();
	if (geocoder) {
		latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
		geocoder.geocode( { 'latLng': latlng }, function(results, status) {
			city = "";
			postalcode = "";
			street = "";
			streetnumber = "";
			country = "";
			level1 = "";
			if (status == google.maps.GeocoderStatus.OK) {
				for (i=0;i<results[0].address_components.length;i++) {
					if (results[0].address_components[i]["types"][0] == "country") {
						country = results[0].address_components[i]["long_name"];
					}
					if (results[0].address_components[i]["types"][0] == "administrative_area_level_1") {
						level1 = results[0].address_components[i]["short_name"];
					}
					if (results[0].address_components[i]["types"][0] == "locality") {
						city = results[0].address_components[i]["long_name"];
					}
					if (results[0].address_components[i]["types"][0] == "postal_code") {
						postalcode = results[0].address_components[i]["long_name"];
					}
					if (results[0].address_components[i]["types"][0] == "route") {
						street = results[0].address_components[i]["long_name"];
					}
					if (results[0].address_components[i]["types"][0] == "street_number") {
						streetnumber = results[0].address_components[i]["long_name"];
					}
				}
			}
			if (level1 == "BW" && (country == "Germany" || country == "Deutschland" || country == "DE")) {
				createCookie("hkj_info",position.coords.latitude+"##1##"+
							position.coords.longitude+"##1##"+
							street+" "+streetnumber+", "+postalcode+" "+city+"##1##"+
							city+"##1##25##1##"+street+" "+streetnumber
							,365);
				setAddressInfo(city, position.coords.latitude, position.coords.longitude, street+" "+streetnumber+", "+postalcode+" "+city, 25, street);
				hideQuestionBox(100);
				$.post(CITYSIGN_AJAX_URL, { tx_helfenkannjeder_citysignlist: {address: 'Geocoding',
					street: street, city: city, zipcode: postalcode, longitude: position.coords.longitude, latitude: position.coords.latitude, response: status, age: document.getElementById("helfen_kann_jeder_citysign_age_input").value} }, function(response) { });
			}
		});
	}
/*  var p = document.getElementById("content");
  p.innerHTML = "<table border='1'><tr><th>Timestamp</th><td>" + position.timestamp +
  "<tr><th>Latitude (WGS84)</th><td>" + position.coords.latitude + " deg</td></tr>" +
  "<tr><th>Longitude (WGS84)</th><td>" + position.coords.longitude + " deg</td></tr></table>";*/
}
 
function displayError(positionError) {
}

jQuery(document).ready(function($){
	addressInfo = readCookie('hkj_info');
	if (addressInfo == null) {
		try {
			if (typeof navigator.geolocation === 'undefined'){
				gl = google.gears.factory.create('beta.geolocation');
			} else {
				gl = navigator.geolocation;
			}
		} catch(e) {
		}
         
		if (gl) {
			gl.getCurrentPosition(displayPosition, displayError);
		}
	}
});
