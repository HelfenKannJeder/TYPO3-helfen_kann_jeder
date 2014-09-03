tx_helfenkannjeder_organisation_playlist = new Array();

function arrayShuffle(){
	var tmp, rand;
	for(var i =0; i < this.length; i++){
		rand = Math.floor(Math.random() * this.length);
		tmp = this[i]; 
		this[i] = this[rand]; 
		this[rand] =tmp;
	}
}
Array.prototype.shuffle = arrayShuffle;

function tx_helfenkannjeder_set_organisation(orgatypes) {
	tx_helfenkannjeder_organisation_current = orgatypes;
	newPosTop = absTop(document.getElementById("tx_helfenkannjeder_picturerotating_box"));
	newPosLeft = absLeft(document.getElementById("tx_helfenkannjeder_picturerotating_box"));

	document.getElementById("tx_helfenkannjeder_picturerotating_picture1").style.top = newPosTop+"px";
	document.getElementById("tx_helfenkannjeder_picturerotating_picture1").style.left = newPosLeft+"px";
	document.getElementById("tx_helfenkannjeder_picturerotating_picture2").style.top = newPosTop+"px";
	document.getElementById("tx_helfenkannjeder_picturerotating_picture2").style.left = newPosLeft+"px";
	k = 0;
	tx_helfenkannjeder_organisation_playlist = new Array();
	for (i=0;i<tx_helfenkannjeder_organisation_current.length;i++) {
		if (tx_helfenkannjeder_organisation_pictures[tx_helfenkannjeder_organisation_current[i]] != undefined) {
			for (j=0;j<tx_helfenkannjeder_organisation_pictures[tx_helfenkannjeder_organisation_current[i]].length;j++) {
				tx_helfenkannjeder_organisation_pictures[tx_helfenkannjeder_organisation_current[i]][j]
				tx_helfenkannjeder_organisation_playlist[k] = tx_helfenkannjeder_organisation_pictures[tx_helfenkannjeder_organisation_current[i]][j];
				k++;
			}
		}
	}
	for (i=0;i<10;i++) {
		tx_helfenkannjeder_organisation_playlist.shuffle();
	}
	tx_helfenkannjeder_picturerotating(true);
}

tx_helfenkannjeder_organisation_playlist_position = 0;

function tx_helfenkannjeder_picturerotating(directDisplay) {
	document.getElementById("tx_helfenkannjeder_picturerotating_picture"+((tx_helfenkannjeder_organisation_playlist_position%2)+1)).src = tx_helfenkannjeder_organisation_playlist[tx_helfenkannjeder_organisation_playlist_position];
	if (directDisplay == null) {
		tx_helfenkannjeder_picturefading(((tx_helfenkannjeder_organisation_playlist_position%2)+1), (((tx_helfenkannjeder_organisation_playlist_position+1)%2)+1), 100);
	}

	tx_helfenkannjeder_organisation_playlist_position++;
	if (tx_helfenkannjeder_organisation_playlist_position >= tx_helfenkannjeder_organisation_playlist.length) {
		tx_helfenkannjeder_organisation_playlist_position = 0;
		tx_helfenkannjeder_organisation_playlist.shuffle();
	}
}

function tx_helfenkannjeder_picturefading(picture1, picture2, picalpha) {
	document.getElementById("tx_helfenkannjeder_picturerotating_picture"+picture1).style.opacity = (100-picalpha)/100;
	document.getElementById("tx_helfenkannjeder_picturerotating_picture"+picture1).style.filter = 'alpha(opacity=' + (100-picalpha) + ')';

	document.getElementById("tx_helfenkannjeder_picturerotating_picture"+picture2).style.opacity = picalpha/100;
	document.getElementById("tx_helfenkannjeder_picturerotating_picture"+picture2).style.filter = 'alpha(opacity=' + picalpha + ')';

	if (picalpha > 0) {
		window.setTimeout("tx_helfenkannjeder_picturefading('"+picture1+"','"+picture2+"','"+(picalpha-10)+"');", 100);
	}
}

var tx_helfenkannjeder_organisation_playlist_interval = window.setInterval("tx_helfenkannjeder_picturerotating()", 16000);
