resortDisabled = false;

var IE = document.all?true:false
if (!IE) document.captureEvents(Event.MOUSEMOVE)
document.onmousemove = getMouseXY;

if (!Array.prototype.indexOf) {
	Array.prototype.indexOf = function(searchElement /*, fromIndex */) {
		"use strict";

		if (this === void 0 || this === null)
			throw new TypeError();

		var t = Object(this);
		var len = t.length >>> 0;
		if (len === 0) return -1;

		var n = 0;
		if (arguments.length > 0) {
			n = Number(arguments[1]);
			if (n !== n) // shortcut for verifying if it's NaN
				n = 0;
			else if (n !== 0 && n !== (1 / 0) && n !== -(1 / 0))
				n = (n > 0 || -1) * Math.floor(Math.abs(n));
		}

		if (n >= len) return -1;

		var k = n >= 0 ? n : Math.max(len - Math.abs(n), 0);

		for (; k < len; k++) {
			if (k in t && t[k] === searchElement)
				return k;
		}
		return -1;
	};
}

selectedActivities = new Array();
selectedActivityFields = new Array();
organisations = new Array();
matrices2organisations = new Array();
matrices = new Array();

function addSelectedActivity( activity ) {
	for (i=0;i<selectedActivities.length;i++) {
		if (selectedActivities[i] == activity) {
			return false;
		}
	}

	selectedActivities[selectedActivities.length] = activity;

	refreshActivityFieldList();

	if (selectedActivities.length == 5) {
		disableActivityField();
	}
}

function refreshActivityFieldList() {
	var activityFieldsToDisplay = new Array();

	for (var i=0;i<selectedActivities.length;i++) {
		activityFieldsToDisplay = activityFieldsToDisplay.concat(activities_activityfields["a"+selectedActivities[i]]);
	}
	activityFieldsToDisplayNew = activityFieldsToDisplay.sort();

	removeChildrenFromNode(document.getElementById("activityfields"), 1);

	var lastElement = null;
	for (var i=0;i<activityFieldsToDisplayNew.length;i++) {
		if (activityFieldsToDisplayNew[i] != lastElement && activityFieldsToDisplayNew[i] != null && !in_array(activityFieldsToDisplayNew[i], selectedActivityFields)) {
			lastElement = activityFieldsToDisplayNew[i];
			newOptionElement = document.createElement("option");
			newOptionElement.value = lastElement;
			newOptionElement.id = "option_activityfield_"+lastElement;

			lastElementKey = activityfields_ids.indexOf(lastElement);
			if (lastElementKey != -1 && lastElementKey < field_activityfields.length) {
				newOptionElement.innerHTML = field_activityfields[lastElementKey];
				newOptionElement.title = description_activityfields[lastElementKey];
				document.getElementById("activityfields").appendChild(newOptionElement);
			}
		}
	}
}

function disableActivityField() {
	document.getElementById("helfen_kann_jeder_search_field").disabled = true;
	document.getElementById("helfen_kann_jeder_search_field").style.backgroundColor = "#cccccc";
	document.getElementById("helfen_kann_jeder_search_button1").style.opacity=0.5;
//	document.getElementById("helfen_kann_jeder_search_button2").style.opacity=0.5;
	if (document.getElementById("helfen_kann_jeder_search_button1").filters) {
		document.getElementById("helfen_kann_jeder_search_button1").style.filter = 'alpha(opacity=50)';
//		document.getElementById("helfen_kann_jeder_search_button2").style.filter = 'alpha(opacity=50)';
	}
}

function enableActivityField() {
	document.getElementById("helfen_kann_jeder_search_field").disabled = false;
	document.getElementById("helfen_kann_jeder_search_field").style.backgroundColor = "";
	document.getElementById("helfen_kann_jeder_search_button1").style.opacity=1;
//	document.getElementById("helfen_kann_jeder_search_button2").style.opacity=1;

	if (document.getElementById("helfen_kann_jeder_search_button1").filters) {
		document.getElementById("helfen_kann_jeder_search_button1").style.filter = 'alpha(opacity=100)';
//		document.getElementById("helfen_kann_jeder_search_button2").style.filter = 'alpha(opacity=100)';
	}
}

function removeSelectedActivity( activity ) {
	start = selectedActivities.indexOf(parseInt(activity));
//	alert(start+"==>"+selectedActivities+"==>"+activity+"===>"+parseInt(activity)+"==>"+selectedActivities[1]);
	if (start == -1) return false;

/*	setDisplayByClassName('helfen_kann_jeder_display_'+activity, 'none');
	for (i=0;i<start;i++) {
		//jQuery('.helfen_kann_jeder_display_'+selectedActivities[i]).css('display', 'block');
		setDisplayByClassName('helfen_kann_jeder_display_'+selectedActivities[i], 'block');
	}
*/
	for (i=start;i<selectedActivities.length-1;i++) {
		selectedActivities[i] = selectedActivities[i+1];
//		setDisplayByClassName('helfen_kann_jeder_display_'+selectedActivities[i], 'block');
		//jQuery('.helfen_kann_jeder_display_'+selectedActivities[i]).css('display', 'block');
	}
/*	for (i=0;i<selectedActivityFields.length;i++) {
		if (document.getElementById('option_activityfield_'+parseInt(selectedActivityFields[i]))) {
			document.getElementById('option_activityfield_'+parseInt(selectedActivityFields[i])).style.display = "none";
		}
	}*/

	selectedActivities.length--;
	refreshActivityFieldList();

	enableActivityField();
}

function addSelectedActivityField( activityfield ) {
	for (i=0;i<selectedActivityFields.length;i++) {
		if (selectedActivityFields[i] == activityfield) {
			return false;
		}
	}

	selectedActivityFields[selectedActivityFields.length] = parseInt(activityfield);
}

function removeSelectedActivityField( activityfield ) {
	start = selectedActivityFields.indexOf(parseInt(activityfield));
	if (start == -1) return false;

//	myActivityList = document.getElementById('option_activityfield_'+parseInt(activityfield)).className.split(" ");

	displayIt = false;
/*	for (i=0;i<selectedActivities.length;i++) {
		if (in_array('helfen_kann_jeder_display_'+selectedActivities[i], myActivityList)) {
			displayIt = true;
			break;
		}
	}
	if (displayIt == false) {
		document.getElementById('option_activityfield_'+parseInt(activityfield)).style.display = "none";
	}*/

	for (i=start;i<selectedActivityFields.length-1;i++) {
		selectedActivityFields[i] = selectedActivityFields[i+1];
	}
	selectedActivityFields.length--;

	refreshActivityFieldList();
}

function new_activity(activity) {
	if (activity == "" || activity == null || isNaN(activity)) return false;
	if (in_array(activity, selectedActivities)) {
		return false;
	}
	document.getElementById("helfen_kann_jeder_search_field").value = "";
	delButton = document.createElement("span");
	delButton.appendChild(document.createTextNode("X"));
	delButton.className = "helfen_kann_jeder_del_button";
	delButton.id = "activity_del_" + activity;
	delButton.onclick = function () {
		this.parentNode.parentNode.removeChild(this.parentNode);
//		document.getElementById('activities').options[parseInt(this.id.substring(13))+1].style.display = "";
//		document.getElementById('activities').disabled = false;
		if (document.getElementById('helfen_kann_jeder_activity_list_' + this.id.substring(13)) != null) {
			document.getElementById('helfen_kann_jeder_activity_list_' + this.id.substring(13)).style.display = "";
		}
		document.getElementById('helfen_kann_jeder_activity_lis2_' + this.id.substring(13)).style.display = "";
		removeSelectedActivity(this.id.substring(13));

		if (selectedActivities.length == 0) {
			while (document.getElementById("activityfields_list_ul").getElementsByTagName("span").length > 0) {
				el = document.getElementById("activityfields_list_ul").getElementsByTagName("span")[0];
				el.parentNode.parentNode.removeChild(el.parentNode);
//				document.getElementById('option_activityfield_'+parseInt(el.id.substring(18))).style.display = "";
				removeSelectedActivityField(el.id.substring(18));
			}

			document.getElementById('activityfields').disabled = true;
		}
		start_resort("activity", 2, this.id.substring(13));
		store_activities();
	}

	newLi = document.createElement("li");
	newLi.id = "activity_" + activity;

	textContent = "";
	if (document.getElementById('helfen_kann_jeder_activity_lis2_' + activity)) {
		textContent = " " + document.getElementById('helfen_kann_jeder_activity_lis2_' + activity).innerHTML;
	}
	if (textContent.indexOf("<") != -1) {
		textContent = textContent.substring(0,textContent.indexOf("<"));
	}
	text = document.createTextNode(textContent+" ");
	newLi.appendChild(delButton);
	newLi.appendChild(text);

	helptext = document.getElementById("helfen_kann_jeder_activity_id_static_"+activity+"_help").innerHTML;
	if (helptext != "") {
		newLiHelp = document.createElement("a");
		newLiHelp.className = "show-tooltip";
		newLiHelp.appendChild(document.createTextNode("?"));
		newLi.appendChild(newLiHelp);
		newTooltip(newLiHelp, helptext);
	}
// TODO
//	newLi.title = activity.options[activity.selectedIndex].title;

	document.getElementById("activities_list_ul").appendChild(newLi);

// TODO
/*	if (activity.options[activity].title != "") {
		newTooltip(newLi, activity.options[activity.selectedIndex].title);
	}*/

	addSelectedActivity(activity);

	start_resort("activity", 1, activity);

	if (document.getElementById('helfen_kann_jeder_activity_list_' + activity) != null) {
		document.getElementById('helfen_kann_jeder_activity_list_' + activity).style.display = "none";
	}
	document.getElementById('helfen_kann_jeder_activity_lis2_' + activity).style.display = "none";
//	activity.options[activity.selectedIndex].style.display = "none";
//	activity.selectedIndex = 0;
	document.getElementById('helfen_kann_jeder_search_result').style.display = 'none';

	if (selectedActivityFields.length < 5) {
		document.getElementById('activityfields').disabled = false;
	}

	if (selectedActivities.length == 5) {
// TODO
//		document.getElementById('activities').disabled = true;
	}
	store_activities();
}

var indSearch = 0;

function start_resort(typChange, newStatus, changeId) {
	if (resortDisabled == true) return false;

	indSearch++;
	document.getElementById("helfen_kann_jeder_result_box").style.display = "";
	document.getElementById("organisation_searching").style.display = "";
	document.getElementById("organisation_none").style.display = "none";
	document.getElementById("organisation_0").style.display = "none";
	document.getElementById("organisation_1").style.display = "none";
	document.getElementById("organisation_2").style.display = "none";
	document.getElementById("organisation_3").style.display = "none";
	document.getElementById("organisation_4").style.display = "none";
	document.getElementById("organisation_5").style.display = "none";
	document.getElementById("organisation_6").style.display = "none";
	document.getElementById("organisation_7").style.display = "none";
	document.getElementById("organisation_8").style.display = "none";
	document.getElementById("organisation_9").style.display = "none";

	selectedActivitiesIds = selectedActivities;

	selectedActivityFieldsIds = selectedActivityFields;;

	if (selectedActivitiesIds.length == 0) {
		document.getElementById("organisation_searching").style.display = "none";
		document.getElementById("helfen_kann_jeder_result_box").style.display = "none";
	} else {
		var downloadSuccess = 1;
		do {

			var d = new Date();
			$.ajaxSetup({ cache: false });
			$.post(addr, { tx_helfenkannjeder_generatorlist: {activities: selectedActivitiesIds,
						activityfields: selectedActivityFieldsIds,
						organisations: organisations, age: getAgeInputValue(),
						newId: changeId, newStatus: newStatus, typeChange: typChange,
						lat: globalLat, lng: globalLng, ind: indSearch} }, function(response) {
				var data = $.parseJSON(response);
                        
				if (data != null && data["status"] == "OK") {
					if (data["index"] == indSearch) {
						output_organisations(data["organisations"]);
					} else {
						window.setTimeout(function() {
							if (data["index"] == indSearch) {
								output_organisations(data["organisations"]);
							}
						}, 500);
					}
					downloadSuccess = 0;
				} else {
//					alert("Fehler: "+response);
					downloadSuccess++;
				}
			});
		} while (downloadSuccess == 0 || downloadSuccess == 5);
	}
}

function output_organisations(orga) {
	document.getElementById("organisation_none").style.display = (orga.length==0) ? "" : "none";

	startpercentage = -1;
	listOfOrganisations = new Array();

	for (i=0;i<orga.length && i < 10;i++) {
		if (i==0) {
			startpercentage = orga[i]["grade"];
		}
		if (startpercentage == orga[i]["grade"]) {
			if (listOfOrganisations.indexOf(orga[i]["organisationtype"]) == -1) {
				listOfOrganisations[listOfOrganisations.length] = orga[i]["organisationtype"];
			}
		}

		document.getElementById("organisation_" + i + "_link").innerHTML = orga[i]["name"];
		document.getElementById("organisation_" + i + "_link").href = orga[i]["link"];
		document.getElementById("organisation_" + i + "_percentage").innerHTML = orga[i]["grade"];
		document.getElementById("organisation_" + i + "_distance").innerHTML = "("+number_format(orga[i]["distance"],1,',','.')+" km)";
		document.getElementById("organisation_" + i).style.display = "";
	}
	for (;i<10;i++) {
		document.getElementById("organisation_" + i).style.display = "none";
	}
	document.getElementById("organisation_searching").style.display = "none";

	tx_helfenkannjeder_set_organisation(listOfOrganisations);
}

function resort_organisations(matrixList) {
	lastElement = document.getElementById('organisation_start');
	output_organisation_done = new Array();

	for (i = 0; i < matrixList.length; i++) {
		matrix_id = matrixList[i]["matrix"];
		matrix_percent = parseInt(matrixList[i]["gradesum"]);
		for (j=0;j<matrices2organisations.length;j++) {
			organisation_id = matrices2organisations[matrix_id];

			if (!in_array(''+organisation_id, output_organisation_done)) {
				oldNode = document.getElementById('organisation_' + organisation_id);
				if (oldNode != null) {
					newNode = oldNode.cloneNode(true);
					lastElement.parentNode.insertBefore(newNode, lastElement.nextSibling);
					removeChildrenFromNode(oldNode, 0);
					oldNode.parentNode.removeChild(oldNode);
					lastElement = newNode;
				}
				document.getElementById('organisation_' + organisation_id + '_percentage').innerHTML = Math.round(matrix_percent);
				output_organisation_done[output_organisation_done.length] = ''+organisation_id;
			}
		}
	}
/*

*/
}

function new_activity_field(activityfieldId) {
	if (activityfieldId == -1) { return false; }

	if (in_array(activityfieldId, selectedActivityFields)) {
		document.getElementById('activityfields').selectedIndex = 0;
		return false;
	}


	delButton = document.createElement("span");
	delButton.appendChild(document.createTextNode("X"));
	delButton.className = "helfen_kann_jeder_del_button";
	delButton.id = "activityfield_del_" + activityfieldId;
	delButton.onclick = function () {
		this.parentNode.parentNode.removeChild(this.parentNode);
//		document.getElementById('option_activityfield_'+this.id.substring(18)).style.display = "";
		document.getElementById('activityfields').disabled = false;
		removeSelectedActivityField(this.id.substring(18));
		refreshActivityFieldList();
		start_resort("activityfield", 2, this.id.substring(18));
		store_activities();
	}

	newLi = document.createElement("li");
	newLi.id = "activityfield_" + activityfieldId;

	textContent = " " + document.getElementById('option_activityfield_' + activityfieldId).innerHTML;
	if (textContent.indexOf("<") != -1) {
		textContent = textContent.substring(0,textContent.indexOf("<"));
	}
	text = document.createTextNode(" " + textContent+" ");
	newLi.appendChild(delButton);
	newLi.appendChild(text);

	titleText = document.getElementById('option_activityfield_' + activityfieldId).title;
	if (titleText != "") {
		helpText = document.createElement("a");
		helpText.appendChild(document.createTextNode("?"));
		helpText.href = "#";
		helpText.onclick = function () { return false; }
//		helpText.title = titleText;
		helpText.className = "show-tooltip";

		newLi.appendChild(helpText);
		newTooltip(helpText, titleText);
	}

	document.getElementById("activityfields_list_ul").appendChild(newLi);

	addSelectedActivityField(activityfieldId);

	start_resort("activityfield", 1, activityfieldId);

//	document.getElementById('option_activityfield_' + activityfieldId).style.display = "none";
	refreshActivityFieldList();
	document.getElementById('activityfields').selectedIndex = 0;

	if (selectedActivityFields.length >= 5) {
		document.getElementById('activityfields').disabled = true;
	}
	store_activities();
}

function store_activities() {
	act = implode("#.#",selectedActivities);
	actfield = implode("#.#",selectedActivityFields);

	cookieContent = act+"---"+actfield;
	eraseCookie("hkj_generator2");
	createCookie("hkj_generator2",cookieContent,365);
	//alert(cookieContent);
}

function restoreActivitiesFromCookie() {
	cookieContent = readCookie("hkj_generator2");
	if (cookieContent == null) return false;

	coparts = cookieContent.split("---");
	if (coparts.length == 2) {
		acti = coparts[0].split("#.#");
		actfieldi = coparts[1].split("#.#");
		
		resortDisabled = true;
		for (ji=0;ji<acti.length;ji++) {
			new_activity(parseInt(acti[ji]));
		}
		if (coparts[1] != "") {
			for (ji=0;ji<actfieldi.length;ji++) {
				new_activity_field(parseInt(actfieldi[ji]));
			}
		}
		resortDisabled = false;
		start_resort("reload", 0, 0);
	}
}

function removeChildrenFromNode(node, start) {
	var len = node.childNodes.length;

	minusdo = 1;
/*	if (IE) {
		minusdo = 0;
	}*/

	for(var i = 0; i < len-start-minusdo; i++) {
		node.removeChild(node.childNodes[len-i-1]);
	}
}

function in_array (needle, haystack, argStrict) {
    // http://kevin.vanzonneveld.net
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: vlado houba
    // +   input by: Billy
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // *     example 1: in_array('van', ['Kevin', 'van', 'Zonneveld']);
    // *     returns 1: true
    // *     example 2: in_array('vlado', {0: 'Kevin', vlado: 'van', 1: 'Zonneveld'});
    // *     returns 2: false
    // *     example 3: in_array(1, ['1', '2', '3']);
    // *     returns 3: true
    // *     example 3: in_array(1, ['1', '2', '3'], false);
    // *     returns 3: true
    // *     example 4: in_array(1, ['1', '2', '3'], true);
    // *     returns 4: false
    var key = '',
        strict = !! argStrict;

    if (strict) {
        for (key in haystack) {
            if (haystack[key] === needle) {
                return true;
            }
        }
    } else {
        for (key in haystack) {
            if (haystack[key] == needle) {
                return true;
            }
        }
    }

    return false;
}

oldValue = "";
var autocomplete_ident = 0;
var autocomplete_request = null;
var autocomplete_ident_displayed = -1;

function hkjautocomplete(newValue) {
	if (oldValue == newValue) return false;
	oldValue = newValue;

	$('#helfen_kann_jeder_search_result_list_dynamic').empty();
	if (newValue == "") {
		document.getElementById("helfen_kann_jeder_search_result").style.display = "none";
		document.getElementById('helfen_kann_jeder_search_result_list_dynamic').style.display = "none";
		document.getElementById('helfen_kann_jeder_search_result_list_all').style.display = "";
		return false;
	}

	overSelectOutputBox = false;
	document.getElementById("helfen_kann_jeder_search_result").style.display = "";
	document.getElementById("helfen_kann_jeder_search_result").style.top = absTop(document.getElementById("helfen_kann_jeder_search_field"))+(document.getElementById("helfen_kann_jeder_search_field").offsetHeight)+"px";
	autocomplete_ident++;

	if (newValue.length == 1) {
		document.getElementById('helfen_kann_jeder_search_result_list_dynamic').style.display = "none";
		document.getElementById('helfen_kann_jeder_search_result_list_all').style.display = "";
	} else {
		document.getElementById('helfen_kann_jeder_search_result_list_dynamic').style.display = "";
		document.getElementById('helfen_kann_jeder_search_result_list_all').style.display = "none";
	}

	var d = new Date();
	$.ajaxSetup({ cache: false });

	if(autocomplete_request && autocomplete_request.readystate != 4){
		autocomplete_request.abort();
	}

	autocomplete_request = $.post(addr_autocomplete, { tx_helfenkannjeder_generatorlist: {search: newValue, ident: autocomplete_ident} }, function(response) {
		var data = $.parseJSON(response);
		if (data != null && data["status"] == "OK") {
			if (parseInt(data["ident"]) < autocomplete_ident_displayed) {
				return false;
			}
			autocomplete_ident_displayed = parseInt(data["ident"]);

			founded = false;
			$('#helfen_kann_jeder_search_result_list_dynamic').empty();
			for (i=0;i<data["activities"].length;i++) {
				currentId = selectedActivities.indexOf(parseInt(data["activities"][i]["uid"]));
				if (currentId != -1) continue;
				if (parseFloat(data["activities"][i]["vote"]) > 0.2 && proveActivity(parseInt(data["activities"][i]["uid"]))) {
					founded = true;
					newLi = document.createElement("li");
					newLiName = document.createTextNode(data["activities"][i]["name"]+" ");
					newLi.appendChild(newLiName);
					newLiWord = document.createTextNode("("+data["activities"][i]["word"]+") ");
					newLiWordSpan = document.createElement("span");
					newLiWordSpan.className = "helfen_kann_jeder_gray";
					newLiWordSpan.appendChild(newLiWord);
					newLi.appendChild(newLiName);
					newLi.appendChild(newLiWordSpan);
					newLi.id = "helfen_kann_jeder_activity_list_"+data["activities"][i]["uid"];
					newLi.onclick = function () {
						new_activity(parseInt(this.id.substring(32)));
						document.getElementById('helfen_kann_jeder_search_result_list_dynamic').style.display = "none";
						document.getElementById('helfen_kann_jeder_search_result_list_all').style.display = "";
					}

					if (data["activities"][i]["description"] != undefined && data["activities"][i]["description"] != "") {
						newLiHelp = document.createElement("a");
						newLiHelp.appendChild(document.createTextNode("?"));
						newLiHelp.className = "show-tooltip";
						newLiHelp.id = "helfen_kann_jeder_activity_id_dynamic_"+data["activities"][i]["uid"];
						newLiHelp.href = "#";
						newLiHelp.onclick = function () { return false; }
						newLi.appendChild(newLiHelp);
						newTooltipOtherPos(newLiHelp, ""+data["activities"][i]["description"], document.getElementById('helfen_kann_jeder_generator_step12'));
					}

					document.getElementById("helfen_kann_jeder_search_result_list_dynamic").appendChild(newLi);


					//document.createTextNode(data["activities"][i]["name"]
				}
			}

			if (founded == false) {
				newLi = document.createElement("li");
				newLiName = document.createTextNode(generatorErrorMessageNothingFound);
				newLi.appendChild(newLiName);
				newLi.className = "helfen_kann_jeder_search_nothing_found";
				document.getElementById("helfen_kann_jeder_search_result_list_dynamic").appendChild(newLi);
			}
		} else {
//			alert("Fehler: "+response);
		}
	});
} 

overSelectOutputBox = false;

window.onclick = function () {
	if (!overSelectOutputBox && document.getElementById('helfen_kann_jeder_search_result')) {
		document.getElementById('helfen_kann_jeder_search_result').style.display = 'none';
	}
}

function generator_display_list() {
	if (selectedActivities.length == 5) {
		return false;
	}
	if (document.getElementById('helfen_kann_jeder_search_result').style.display == 'none') {
		overSelectOutputBox = true;
		window.setTimeout("overSelectOutputBox = false;", 500);
		document.getElementById('helfen_kann_jeder_search_result').style.display = '';
		document.getElementById("helfen_kann_jeder_search_result").style.top = absTop(document.getElementById("helfen_kann_jeder_search_field"))+(document.getElementById("helfen_kann_jeder_search_field").offsetHeight)+"px";
	} else {
		overSelectOutputBox = true;
		document.getElementById('helfen_kann_jeder_search_result').style.display = 'none';
	}
}



var tempX = 0;
var tempY = 0;

function getMouseXY(e) {
	if (IE) { // grab the x-y pos.s if browser is IE
		tempX = event.clientX + document.body.scrollLeft;
		tempY = event.clientY + document.body.scrollTop;
	} else {  // grab the x-y pos.s if browser is NS
		tempX = e.pageX;
		tempY = e.pageY;
	}  
	if (tempX < 0){tempX = 0;}
	if (tempY < 0){tempY = 0;}

	if (document.getElementById("helfen_kann_jeder_search_result") != undefined && document.getElementById("helfen_kann_jeder_search_result").style.display != "none") {
		overSelectOutputBox = (document.getElementById("helfen_kann_jeder_search_result").offsetTop <= tempY &&
			document.getElementById("helfen_kann_jeder_search_result").offsetTop+document.getElementById("helfen_kann_jeder_search_result").offsetHeight >= tempY &&
			document.getElementById("helfen_kann_jeder_search_result").offsetLeft <= tempX &&
                        document.getElementById("helfen_kann_jeder_search_result").offsetLeft+document.getElementById("helfen_kann_jeder_search_result").offsetWidth >= tempX);
	} else {
		overSelectOutputBox = true;
	}

	return true;
}

function proveActivity(act) {
	return (activities_activityfields["a"+act] != undefined && activities_activityfields["a"+act] != null && activities_activityfields["a"+act].indexOf(18) != -1) || getAgeInputValue() >= 18;
}

function number_format (number, decimals, dec_point, thousands_sep) {
    // http://kevin.vanzonneveld.net
    // +   original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +     bugfix by: Michael White (http://getsprink.com)
    // +     bugfix by: Benjamin Lupton
    // +     bugfix by: Allan Jensen (http://www.winternet.no)
    // +    revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +     bugfix by: Howard Yeend
    // +    revised by: Luke Smith (http://lucassmith.name)
    // +     bugfix by: Diogo Resende
    // +     bugfix by: Rival
    // +      input by: Kheang Hok Chin (http://www.distantia.ca/)
    // +   improved by: davook
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // +      input by: Jay Klehr
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // +      input by: Amir Habibi (http://www.residence-mixte.com/)
    // +     bugfix by: Brett Zamir (http://brett-zamir.me)
    // +   improved by: Theriault
    // +      input by: Amirouche
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // *     example 1: number_format(1234.56);
    // *     returns 1: '1,235'
    // *     example 2: number_format(1234.56, 2, ',', ' ');
    // *     returns 2: '1 234,56'
    // *     example 3: number_format(1234.5678, 2, '.', '');
    // *     returns 3: '1234.57'
    // *     example 4: number_format(67, 2, ',', '.');
    // *     returns 4: '67,00'
    // *     example 5: number_format(1000);
    // *     returns 5: '1,000'
    // *     example 6: number_format(67.311, 2);
    // *     returns 6: '67.31'
    // *     example 7: number_format(1000.55, 1);
    // *     returns 7: '1,000.6'
    // *     example 8: number_format(67000, 5, ',', '.');
    // *     returns 8: '67.000,00000'
    // *     example 9: number_format(0.9, 0);
    // *     returns 9: '1'
    // *    example 10: number_format('1.20', 2);
    // *    returns 10: '1.20'
    // *    example 11: number_format('1.20', 4);
    // *    returns 11: '1.2000'
    // *    example 12: number_format('1.2000', 3);
    // *    returns 12: '1.200'
    // *    example 13: number_format('1 000,50', 2, '.', ' ');
    // *    returns 13: '100 050.00'
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

if (!document.getElementsByClassName) {
	document.getElementsByClassName = function(class_name) {
		var docList = this.all || this.getElementsByTagName('*');
		var matchArray = new Array();

		/*Create a regular expression object for class*/
		var re = new RegExp("(?:^|\\s)"+class_name+"(?:\\s|$)");
		for (var i = 0; i < docList.length; i++) {
			if (re.test(docList[i].className) ) {
				matchArray[matchArray.length] = docList[i];
			}
		}
		return matchArray;
	}//eof annonymous function
}

function setDisplayByClassName(clName, newDisplay) {
	elemToModify = document.getElementsByClassName(clName);
	for (qui=0;qui<elemToModify.length;qui++) {
		elemToModify[qui].style.display = newDisplay;
	}
}

function implode (glue, pieces) {
    // http://kevin.vanzonneveld.net
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Waldo Malqui Silva
    // +   improved by: Itsacon (http://www.itsacon.net/)
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // *     example 1: implode(' ', ['Kevin', 'van', 'Zonneveld']);
    // *     returns 1: 'Kevin van Zonneveld'
    // *     example 2: implode(' ', {first:'Kevin', last: 'van Zonneveld'});
    // *     returns 2: 'Kevin van Zonneveld'
    var i = '',
        retVal = '',
        tGlue = '';
    if (arguments.length === 1) {
        pieces = glue;
        glue = '';
    }
    if (typeof(pieces) === 'object') {
        if (Object.prototype.toString.call(pieces) === '[object Array]') {
            return pieces.join(glue);
        } else {
            for (i in pieces) {
                retVal += tGlue + pieces[i];
                tGlue = glue;
            }
            return retVal;
        }
    } else {
        return pieces;
    }
}

function array_unique (inputArr) {
    // http://kevin.vanzonneveld.net
    // +   original by: Carlos R. L. Rodrigues (http://www.jsfromhell.com)
    // +      input by: duncan
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   bugfixed by: Nate
    // +      input by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Michael Grier
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // %          note 1: The second argument, sort_flags is not implemented;
    // %          note 1: also should be sorted (asort?) first according to docs
    // *     example 1: array_unique(['Kevin','Kevin','van','Zonneveld','Kevin']);
    // *     returns 1: {0: 'Kevin', 2: 'van', 3: 'Zonneveld'}
    // *     example 2: array_unique({'a': 'green', 0: 'red', 'b': 'green', 1: 'blue', 2: 'red'});
    // *     returns 2: {a: 'green', 0: 'red', 1: 'blue'}
    var key = '',
        tmp_arr2 = {},
        val = '';

    var __array_search = function (needle, haystack) {
        var fkey = '';
        for (fkey in haystack) {
            if (haystack.hasOwnProperty(fkey)) {
                if ((haystack[fkey] + '') === (needle + '')) {
                    return fkey;
                }
            }
        }
        return false;
    };

    for (key in inputArr) {
        if (inputArr.hasOwnProperty(key)) {
            val = inputArr[key];
            if (false === __array_search(val, tmp_arr2)) {
                tmp_arr2[key] = val;
            }
        }
    }

    return tmp_arr2;
}
