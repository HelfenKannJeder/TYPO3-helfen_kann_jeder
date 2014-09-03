ShowTooltip = function(e)
{
	var text = $(this).next('.show-tooltip-text');
	if (text.attr('class') != 'show-tooltip-text')
		return false;

	text.fadeIn()
		.css('top', e.pageY)
		.css('left', e.pageX+10);

	return false;
}
ShowTooltip2 = function(e)
{
	var text = $("#"+this.id+"_help"); //$(this).next('.show-tooltip-text');
	if (text.attr('class') != 'show-tooltip-text')
		return false;

	text.fadeIn()
		.css('top', e.pageY)
		.css('left', e.pageX+10);

	return false;
}

HideTooltip = function(e)
{
	var text = $(this).next('.show-tooltip-text');
	if (text.attr('class') != 'show-tooltip-text')
		return false;

	text.fadeOut();
}

HideTooltip2 = function(e)
{
	var text = $("#"+this.id+"_help"); //$(this).next('.show-tooltip-text');
	if (text.attr('class') != 'show-tooltip-text')
		return false;

	text.fadeOut();
}

SetupTooltips = function()
{
	$('.show-tooltip')
		.each(function(){
			$(this)
				.after($('<span/>')
					.attr('class', 'show-tooltip-text')
					.html($(this).attr('title')))
				.attr('title', '');
		})
		.hover(ShowTooltip, HideTooltip);

	$('.show-tooltip-extend').hover(ShowTooltip2, HideTooltip2);
}

function newTooltip(newentry, message) {
		$(newentry).after($('<span/>').attr('class', 'show-tooltip-text').html(message));
		$(newentry).hover(ShowTooltip, HideTooltip);
}

function newTooltipOtherPos(newentry, message, pos) {
	if (document.getElementById(newentry.id+"_help") == undefined) {
		$(pos).after($('<span/>').attr('class', 'show-tooltip-text').attr('id', newentry.id+"_help").html(message));
	}
	$(newentry).hover(ShowTooltip2, HideTooltip2);
}

$(document).ready(function() {
	SetupTooltips();
});

