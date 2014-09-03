buttonOver = false;
smallMap = null;
newCounter = 0;

function register_organisation_object_create(elementId) {
	cloneableCopy = document.getElementById(elementId+"_new");
	newNode = cloneableCopy.cloneNode(true);
	newNode.style.display = "";

	cloneableCopyDetail = cloneableCopy.nextSibling;
	newNodeDetail = cloneableCopyDetail.cloneNode(true);
	newNodeDetail.style.display = "";

	register_organisation_object_replace_recursive(newNode, 'new', 'new'+newCounter);
	register_organisation_object_replace_recursive(newNodeDetail, 'new', 'new'+newCounter);

	cloneableCopy.parentNode.insertBefore(newNode, cloneableCopy);
	cloneableCopy.parentNode.insertBefore(newNodeDetail, cloneableCopy);
	$('.show-tooltip', $(newNodeDetail)).hover(ShowTooltip, HideTooltip);
	$('.show-tooltip-extend', $(newNodeDetail)).hover(ShowTooltip, HideTooltip);

	document.getElementById(elementId+'Delete_new'+newCounter).value = '0';
	newCounter++;
}

function register_organisation_object_replace_recursive(node, oldValue, newValue) {
	elementsToWork = node.getElementsByTagName("*");
	node.id = node.id.replace(new RegExp(oldValue, 'g'),newValue);
	for (i=0;i < elementsToWork.length; i++) {
		elementsToWork[i].id = elementsToWork[i].id.replace(new RegExp(oldValue, 'g'),newValue);
		if (elementsToWork[i].name != undefined) {
			elementsToWork[i].name = elementsToWork[i].name.replace(new RegExp(oldValue, 'g'),newValue);
		}
		if (elementsToWork[i].value != undefined) {
			elementsToWork[i].value = elementsToWork[i].value.replace(new RegExp(oldValue, 'g'),newValue);
		}
	}
}

function register_organisation_object_detail_show(element) {
	if (buttonOver == false) {
		element.nextSibling.style.display = element.nextSibling.style.display == "none" ? "" : "none";
	}
}

function register_organisation_object_delete_button_over(element) {
	buttonOver = true;
}

function register_organisation_object_delete_button_out(element) {
	buttonOver = false;

}

function register_organisation_object_delete(element) {
	elementIdSplited = element.parentNode.id.split("_");
	if (elementIdSplited.length == 2) {
		document.getElementById(elementIdSplited[0]+"Delete_"+elementIdSplited[1]).value = 1;
		register_organisation_object_fadeout(element.parentNode.id);
	}
}

function register_organisation_object_fadeout(elementId, fadeOutCounter) {
	if (fadeOutCounter == null) fadeOutCounter = 9;

	element = document.getElementById(elementId);
	setOpacity(element, fadeOutCounter/10);
	setOpacity(element.nextSibling, fadeOutCounter/10);

	if (fadeOutCounter > 0) {
		fadeOutCounter--;
		window.setTimeout("register_organisation_object_fadeout('"+elementId+"', "+fadeOutCounter+");", 50);
	} else {
		element.style.display = "none";
		element.nextSibling.style.display = "none";
	}
}


function setOpacity( element, alpha ) {
	var style = element.style;
	if( style.MozOpacity != undefined ) { //Moz and older
		style.MozOpacity = alpha;
	}
	else if( style.opacity != undefined ) { //Opera
		style.opacity = alpha;
	}
	else if( style.filter != undefined ) { //IE
		style.filter = "alpha(opacity=0)";
		element.filters.alpha.opacity = ( alpha * 100 );
	}
}


function register_organisation_address_init(lat, lng) {
    var latlng = new google.maps.LatLng(lat, lng);
    var myOptions = {};
	myOptions["zoom"] = 10;
 	myOptions["center"] = latlng;
	myOptions["mapTypeId"] = google.maps.MapTypeId.ROADMAP;
    smallMap = new google.maps.Map(document.getElementById("organisationAddressContainerMap"), myOptions);
}

function register_organisation_address_draw(lat, lng, name) {
	obj = {};
        obj["map"] = smallMap;

	obj["position"] = new google.maps.LatLng(lat, lng);
        obj["title"] = name;

	new google.maps.Marker(obj);
}

function register_organisation_group_show_detail(element) {
	element.parentNode.parentNode.nextSibling.style.display = element.checked ? '' : 'none';
}
