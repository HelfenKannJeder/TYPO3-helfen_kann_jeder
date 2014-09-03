function onUploadResponse(event) {
	responseData = $.trim(event.data);
	if (responseData.substring(0,13) == "uploadSuccess") {
		responseDataArray = responseData.split(":");

		if (document.getElementById("upload_row_"+event.id)) {
			document.getElementById("upload_row_"+event.id).parentNode.removeChild(document.getElementById("upload_row_"+event.id));
		}

		if (responseDataArray[2] != "") {
			createNewPictureNode(responseDataArray[2], responseDataArray[1]);
		}
		if (document.getElementById("organisation_register_pictures").value == "") {
			document.getElementById("organisation_register_pictures").value = responseDataArray[1];
		} else {
			document.getElementById("organisation_register_pictures").value = document.getElementById("organisation_register_pictures").value + "," + responseDataArray[1];
		}
		uploadStart();
	} else {
		document.getElementById( "upload_status_"+event.id ).innerHTML = uploadStatusFailed;
		uploadErrors[uploadErrors.length] = document.getElementById( "upload_name_"+event.id ).innerHTML;
		uploadStart();
	}
}

function createNewPictureNode(picturePath, imageName) {
	document.getElementById("sort_headline").style.display = '';

	newDiv = document.createElement("div");
	newDiv.style.backgroundImage = "url("+picturePath+")";
	newDiv.className = "borderChange";
	newDiv.onmousedown = function () {
		if (isOverDeleteButton==0){sorter_start(this);}
	}
	newSpan = document.createElement("span");
	newSpan.className = "picture_name";
	newSpan.style.display = "none";
	newSpan.appendChild(document.createTextNode(imageName));
	newDiv.appendChild(newSpan);

	newInnerDiv = document.createElement("div");
	newInnerDiv.onclick = function () { if (window.confirm(deleteButtonQuestion)) {removeElementFromList(this.parentNode);} };
	newInnerDiv.onmouseover = function () { isOverDeleteButton=1; };
	newInnerDiv.onmouseout = function () { isOverDeleteButton=0; };
	newInnerDiv.className = "organisation_picture_delete";

	newImage = document.createElement("img");
	newImage.src = deleteButtonPath;
	newImage.alt = deleteButtonAlt;
	newInnerDiv.appendChild(newImage);
	newDiv.appendChild(newInnerDiv);
	document.getElementById("blockview").insertBefore(newDiv, document.getElementById("sorterEndingBr"));
}

function buildUploader() {
	uploaderImport = new YAHOO.widget.Uploader( "uploader", uploaderImage );

	uploaderImport.addListener('contentReady', function () { 
		uploaderImport.setAllowLogging(true); 
		uploaderImport.setAllowMultipleFiles(true);

		pictureField = new Object();
		pictureField["description"] = uploadDescriptionPicture;
		pictureField["extensions"] = "*.png;*.PNG;*.jpg;*.JPG";

		ff = new Array(	pictureField ); 
		uploaderImport.setFileFilters(ff); 
		uploaderImport.addListener('uploadCompleteData',onUploadResponse);
		uploaderImport.addListener('uploadError', function (event) {
			alert("TEST:"+uploadGeneralError+event.type+" "+event.id+"-"+event.status);
		} ); 
		uploaderImport.addListener('uploadProgress', function (event) { 
			progUpload = Math.round(100*(event["bytesLoaded"]/event["bytesTotal"]));
		
			if(progUpload <= 99) {
				if(document.getElementById( "upload_status_"+event["id"] ) != null ) {
					document.getElementById( "upload_status_"+event["id"] ).innerHTML = progUpload + " %";
				}
			}
		} ); 
	}); 

	uploaderImport.addListener('fileSelect', function (event) {

		for (var item in event.fileList) { 
			if(YAHOO.lang.hasOwnProperty(event.fileList, item)) {
				if (event.fileList[item].name != "") {
					document.getElementById("uploads").style.display = "";
					document.getElementById("uploadsListPosition").style.top = document.getElementById("uploader").offsetTop+"px";
					document.getElementById("uploadsListPosition").style.left = (document.getElementById("uploader").offsetLeft+document.getElementById("uploader").offsetWidth)+"px";

					nameArray = event.fileList[item].name.split(".");
					uploadAddTableRow(event.fileList[item].id, event.fileList[item].name, nameArray[nameArray.length-1].toLowerCase(), event.fileList[item].size);
				} else {
					uploaderImport.removeFile(event.fileList[item].id);
					alert(uploadFileAddError);
				}
			}
		}
		uploadStart();
	} );

}

function uploadStart() {
	if (uploadCounter < uploadsList.length) {
		uploaderImport.disable();
		document.getElementById( "upload_status_"+uploadsList[uploadCounter][0] ).innerHTML = uploadStatusStart;
		uploaderImport.upload(uploadsList[uploadCounter][0], uploadUri,"POST", new Object() ,'import'); 
		uploadCounter++;
	} else {
		document.getElementById("uploads").style.display = "none";
		if (uploadErrors.length > 0) {
			uploadErrorList = "";
			for (i=0;i<uploadErrors.length;i++) {
				uploadErrorList += "\n" + uploadErrors[i];
			}
			alert(uploadErrorMessage + uploadErrorList);
		}
		uploadErrors = new Array();
		uploadErrors.length = 0;
		for (i=document.getElementById("uploads").getElementsByTagName("tr").length-1; i >= 0; i--) {
			if (document.getElementById("uploads").getElementsByTagName("tr")[i].id != "headline") {
				document.getElementById("uploads").getElementsByTagName("tr")[i].parentNode.removeChild(document.getElementById("uploads").getElementsByTagName("tr")[i]);
			}
		} 
		uploaderImport.clearFileList();
		uploaderImport.enable();
	}

}


function uploadAddTableRow(uid, name, type, size) {
	uploadEntry = new Array();
	uploadEntry[0] = uid;
	uploadEntry[1] = name;
	uploadsList[uploadsList.length] = uploadEntry;

	trElement = document.createElement("tr");
	trElement.id = "upload_row_"+uploadEntry[0];
	tdElement = document.createElement("td");
	tdElement.id = "upload_name_"+uploadEntry[0];
	tdElement.appendChild(document.createTextNode(name));
	trElement.appendChild(tdElement);
	tdElement = document.createElement("td");
	tdElement.id = "upload_status_"+uploadEntry[0];
	tdElement.appendChild(document.createTextNode(uploadStatusWait));
	trElement.appendChild(tdElement);
	tdElement = document.createElement("td");
	tdElement.appendChild(document.createTextNode(type));
	trElement.appendChild(tdElement);
	tdElement = document.createElement("td");
	tdElement.appendChild(document.createTextNode(Math.round(size/1024/1024*1000)/1000+" MB"));
	trElement.appendChild(tdElement);
	document.getElementById('uploads').appendChild(trElement);
}

buildUploader();
