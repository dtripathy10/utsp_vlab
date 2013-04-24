function allElementAreSelected() {
	var optionTexts = [];
	$("ul li").each(function() { optionTexts.push($(this).text()) });
}