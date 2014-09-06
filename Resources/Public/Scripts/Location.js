function hkjChangeLocation(newLocation, errorId, errorClass) {
	$(errorClass).hide();
	geocoder = new google.maps.Geocoder();
	address = "Germany, "+newLocation;

	if (newLocation == '') {
		eraseCookie('hkj_info');
	}


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
					createCookie("hkj_info",results[0].geometry.location.lat()+"##1##"+
								results[0].geometry.location.lng()+"##1##"+
								newLocation+"##1##"+
								city+"##1####1##"+street+" "+streetnumber
								,365);

					var currentSide = window.location.pathname.split("/");

//					if (currentSide[1] == "bei-wem" || (currentSide[1] == "helf-o-mat" && window.location.search != '')) {
						window.location.reload();
//					}
				} else {
					$(errorId+"1").show();
				}
			} else {
				if (status == "ZERO_RESULTS") {
					$(errorId+"2").show();
				} else {
					$(errorId+"3").show();
				}
			}
		});
	}

}

$(document).ready(function () {
	cookieContent = readCookie('hkj_info');

	if (cookieContent == null) return;

	infosDetail = cookieContent.split("##1##");

	if (infosDetail[2] != null) {
		$('#hkj_location_city').val(infosDetail[2]);
	}
});

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

