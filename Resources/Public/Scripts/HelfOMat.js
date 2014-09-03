helfenKannJederHelfOMatMaxItem = 0;
helfenKannJederHelfOMatCurrentItem = 0;
helfenKannJederHelfOMatItemsComplete = 0;
helfenKannJederHelfOMatItemsWidth = 0;

$(document).ready(function () {
	if ($('.tx-helfenkannjeder-helfomat-quiz').length == 1) {
		$('.tx-helfenkannjeder-helfomat-question').hide();
		$('.tx-helfenkannjeder-helfomat-question-options').hide();
		$('.tx-helfenkannjeder-helfomat-question-submit').hide();
		$('.tx-helfenkannjeder-helfomat-question-buttons').show();
		$('.tx-helfenkannjeder-helfomat-question-status').show();
		$('.tx-helfenkannjeder-helfomat-question-buttons-yes').click(function (ev) { helfenKannJederButtonPressed(ev, 1); });
		$('.tx-helfenkannjeder-helfomat-question-buttons-no').click(function (ev) { helfenKannJederButtonPressed(ev, 2); });
		$('.tx-helfenkannjeder-helfomat-question-buttons-neutral').click(function (ev) { helfenKannJederButtonPressed(ev, 0); });

		var listItemBox = $('#tx-helfenkannjeder-helfomat-question-status-num');
		var listItem = $('li', $('#tx-helfenkannjeder-helfomat-question-status-num'));
		helfenKannJederHelfOMatItemsWidth = Math.floor(listItemBox.width()/listItem.length);
		helfenKannJederHelfOMatItemsComplete = listItem.length;
		listItem.each(function (key, val) {
			$(val).css('width', helfenKannJederHelfOMatItemsWidth+"px");
		});

		helfenKannJederSetCurrentQuestion(0, 0);
	}
});

function helfenKannJederButtonPressed(ev, num) {
	$("#"+$(ev.target).parent().parent().attr('id')+"-select").val(num);
	if (helfenKannJederHelfOMatCurrentItem < (helfenKannJederHelfOMatItemsComplete-1)) {
		helfenKannJederSetCurrentQuestion(helfenKannJederHelfOMatCurrentItem+1, 1);
	} else {
		$("#tx-helfenkannjeder-helfomat-form").submit();
	}
}

function helfenKannJederSetCurrentQuestion(num,offset) {
	if (num < helfenKannJederHelfOMatItemsComplete) {
		if (num > helfenKannJederHelfOMatMaxItem+offset) {
			return;
		}
		if (num > helfenKannJederHelfOMatMaxItem) {
			helfenKannJederHelfOMatMaxItem = num;
		}
		var listItem = $('li', $('#tx-helfenkannjeder-helfomat-question-status-num'));
		$(listItem.get(helfenKannJederHelfOMatCurrentItem)).removeClass("tx-helfenkannjeder-helfomat-question-status-li-current");
		$('#tx-helfenkannjeder-helfomat-question-'+helfenKannJederHelfOMatCurrentItem).hide();
		helfenKannJederHelfOMatCurrentItem = num;
		$('#tx-helfenkannjeder-helfomat-question-status-bar-current').css('width', ((helfenKannJederHelfOMatMaxItem+1)*helfenKannJederHelfOMatItemsWidth)+"px");
		$('#tx-helfenkannjeder-helfomat-question-'+num).show();
		$(listItem.get(num)).addClass("tx-helfenkannjeder-helfomat-question-status-li-current");
		$(listItem.get(num)).addClass("tx-helfenkannjeder-helfomat-question-status-li-clickable");
	}
}
