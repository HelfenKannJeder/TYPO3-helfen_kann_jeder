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

function helfenKannJederChangeHelfOMatQuestion(uid, newValue) {
	var current = $('#tx-helfenkannjeder-helfomat-question-buttons-' + uid + '-select').val();

	if (current != newValue) {
		$('#tx-helfenkannjeder-helfomat-question-buttons-' + uid + '-image-' + current + '-yes').hide();
		$('#tx-helfenkannjeder-helfomat-question-buttons-' + uid + '-image-' + current + '-no').show();
		$('#tx-helfenkannjeder-helfomat-question-buttons-' + uid + '-image-' + newValue + '-yes').show();
		$('#tx-helfenkannjeder-helfomat-question-buttons-' + uid + '-image-' + newValue + '-no').hide();

		$('#tx-helfenkannjeder-helfomat-question-buttons-' + uid + '-select').val(newValue);

		var result = new Object();
		$('.tx-helfenkannjeder-helfomat-question-options').each(function () {
			result[$(this).attr('name')] = $(this).val();
		});


		var url = $('base').attr('href') + $('#tx-helfenkannjeder-helfomat-form').attr('action');

		$('#organisation_searching').show();

		$('.organisation_entry', $('.helfen_kann_jeder_generator_step3_organisations')).hide();


		$.ajax({
			type: 'post',
			url: url,
			data: result,
			success: function(response) {
				$('#organisation_searching').hide();
				for (var i = 0; i < response.length; i++) {
					var par = $('#organisation_' + i, $('.helfen_kann_jeder_generator_step3_organisations'));
					var grade = parseInt(response[i]['grade']);
					$('.helfen_kann_jeder_generator_organisation_resultbar', par).width(parseInt(response[i]['grade'])*2)
						.css({backgroundColor: 'rgb(' + parseInt((100-grade)*2.46) + ',' + parseInt(149+(100-grade)*0.37) + ',' + parseInt(grade*0.71) + ')'});
					$('#organisation_' + i + '_link', par).attr('href', response[i]['link']);
					$('#organisation_' + i + '_link', par).html(response[i]['name']);

					if (response[i]['distance'] >= 0) {
						$('.helfen_kann_jeder_generator_step3_organisations_distance', par).html('(' + response[i]['distance'].toFixed(1).replace('.', ',') + ' km)');
					} else {
						$('.helfen_kann_jeder_generator_step3_organisations_distance', par).html('');
					}
					par.show();
				}
			},
			dataType: 'json'
		});
		// TODO: Send result as ajax request
	}
}
