$(function () {
	var index = [],
		highlightedPage,
		highlight;

	$('#examples').children().each(function () {
		index.push( [$(this).position().top, $(this).position().top + $(this).outerHeight(true)] );
	});

	$(document).on('scroll', function () {
		var i = index.length,
			offset = $(document).scrollTop() + 200;

		while (i--) {
			if (offset >= index[i][0] && offset <= index[i][1]) {
				highlight(i + 1);

				break;
			}
		}
		// 
	});

	highlight = function (i) {
		if (highlightedPage && highlightedPage == i) {
			return;
		}

		highlightedPage = i;

		$('#sidebar .nav li').removeClass('active').eq(i - 1).addClass('active');
	};

	$('#sidebar .nav').on('click', 'li', function () {
		var i = $(this).index(),
			page = $('#examples').children().eq(i);

		//console.log(page.position().top);

		$('body').animate({scrollTop: page.position().top}, 500);
	});
});