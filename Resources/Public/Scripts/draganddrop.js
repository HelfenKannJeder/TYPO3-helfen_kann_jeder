disable_button=false;

var IE = document.all?true:false
if (!IE) document.captureEvents(Event.MOUSEMOVE)

document.onmousemove = getMouseXY;

var tempX = 0
var tempY = 0

var moveElement = null;
var moveElementOriginal = null;
var moveElementTime = 0;
var offsetMoveX = 0;
var offsetMoveY = 0;
var isOverDeleteButton = 0;

function getMouseXY(e) {
	if (IE) {
		tempX = event.clientX + document.body.scrollLeft;
		tempY = event.clientY + document.body.scrollTop;
	} else {
		tempX = e.pageX;
		tempY = e.pageY;
	}  
	if (tempX < 0) tempX = 0;
	if (tempY < 0) tempY = 0;

	if(moveElement != null) {
		moveElement.style.top = (tempY-offsetMoveY)+'px';
		moveElement.style.left = (tempX-offsetMoveX)+'px';


		dummyAlreadyFound = false;

		for(i=0;i<document.getElementById('blockview').getElementsByTagName("div").length;i++) {
			if(document.getElementById('blockview').getElementsByTagName("div")[i].className == "borderChange") {
				element = document.getElementById('blockview').getElementsByTagName("div")[i];
				start_y = element.offsetTop; // - scrolling
				start_x = element.offsetLeft;
				end_y = start_y+element.offsetHeight;
				end_x = start_x+element.offsetWidth;

				if(start_x <= tempX && end_x >= tempX && start_y <= tempY && end_y >= tempY) {
					newPlaceholder = document.getElementById("dummyElement").cloneNode(true);
					newPlaceholder.onmousedown = document.getElementById("dummyElement").onmousedown;
					if (document.getElementById("dummyElement").getElementsByTagName("div").length > 0) {
						newPlaceholder.getElementsByTagName("div")[0].onmouseover = document.getElementById("dummyElement").getElementsByTagName("div")[0].onmouseover;
						newPlaceholder.getElementsByTagName("div")[0].onmouseout = document.getElementById("dummyElement").getElementsByTagName("div")[0].onmouseout;
						newPlaceholder.getElementsByTagName("div")[0].onclick = document.getElementById("dummyElement").getElementsByTagName("div")[0].onclick;
					}
					document.getElementById("dummyElement").parentNode.removeChild(document.getElementById("dummyElement"));
					if(dummyAlreadyFound == true) {
						element.parentNode.insertBefore(newPlaceholder,element.nextSibling);
					} else {
						element.parentNode.insertBefore(newPlaceholder,element);
					}
					
				}
			} else if(document.getElementById('blockview').getElementsByTagName("div")[i].className == "dummyElement") {
				dummyAlreadyFound = true;
			}
		}
	}

	return true;
}


function sorter_start(element) {
	moveElement = element;
	moveElementOriginal = element.cloneNode(true);
	moveElementOriginal.onmousedown = element.onmousedown;
	if (element.getElementsByTagName("div").length > 0) {
		moveElementOriginal.getElementsByTagName("div")[0].onclick = element.getElementsByTagName("div")[0].onclick;
		moveElementOriginal.getElementsByTagName("div")[0].onmouseover = element.getElementsByTagName("div")[0].onmouseover;
		moveElementOriginal.getElementsByTagName("div")[0].onmouseout = element.getElementsByTagName("div")[0].onmouseout;
	}
	moveElementTime = new Date();

	offsetMoveX = (tempX-element.offsetLeft);
	offsetMoveY = (tempY-element.offsetTop); // Offset page scrolling

	placeholderDiv = document.createElement('div');
	placeholderDiv.className = 'dummyElement';
	placeholderDiv.id = 'dummyElement';
	element.parentNode.insertBefore(placeholderDiv,element);

	element.style.display = 'block';
	element.style.position = 'absolute';
	element.style.top = (tempY-offsetMoveY)+'px';
	element.style.left = (tempX-offsetMoveX)+'px';
	element.className = "borderChangeDrag";
}

var draganddropClickFunction = function () {
}

window.onmouseup = function () {
	if(moveElement != null) {
		moveElementId = moveElementOriginal.id;
		moveElementToPositionId = document.getElementById('dummyElement').nextSibling.id;
		moveElement.parentNode.removeChild(moveElement);
		moveElement = null;
		document.getElementById('dummyElement').parentNode.insertBefore(moveElementOriginal,document.getElementById('dummyElement'));
		document.getElementById('dummyElement').parentNode.removeChild(document.getElementById('dummyElement'));

		var nowDate = new Date();
		//xajax_moveSlide(moveElementId.substr(6), moveToSubstr);

		newOrder = "";
		for (i=0;i < document.getElementById("blockview").getElementsByTagName("span").length;i++) {
			newOrder += "," + document.getElementById("blockview").getElementsByTagName("span")[i].innerHTML;
		}
		document.getElementById("organisation_register_pictures").value = newOrder.substring(1);
	}
}

function removeElementFromList(elementNode) {
	elementNode.parentNode.removeChild(elementNode);
	newOrder = "";
	for (i=0;i < document.getElementById("blockview").getElementsByTagName("span").length;i++) {
		newOrder += "," + document.getElementById("blockview").getElementsByTagName("span")[i].innerHTML;
	}
	document.getElementById("organisation_register_pictures").value = newOrder.substring(1);
}

