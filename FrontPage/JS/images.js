	var browserAreaHeight;
	var headerHeight;
	var imagesAreaHeight;
	var imageOffset = 5;

	$(document).ready(function() {
		heightCalculate();
		setContentHeight(imagesAreaHeight);
	});

	$(window).load(function () {

		refreshImagesHeight();

		$(window).resize(function(){
			refreshImagesHeight();
		});

		setContentHeight('');
	});

	function refreshImagesHeight()
	{
		heightCalculate();
		$('.resizing').each(function(i) {
			imageName = $(this).attr('src');
			imageHeight = $(this).attr('height');

			$(this).imgResize({maxHeight: imagesAreaHeight});
		});
	}

	function heightCalculate()
	{
		browserAreaHeight = $(window).height();
		headerHeight = $('#headerholder').height();
		imagesAreaHeight = browserAreaHeight - headerHeight - imageOffset;
	}

	function setContentHeight(height)
	{
		$('#content').attr('height', height);
		$('.resizing').each(function(i) {
			$(this).css('height', height);
		});
	}