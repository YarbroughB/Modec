window.onload = function() {
	// Bootstrap file input fix with added image preview
	$('.btn-file input[type="file"].form-control').each(function(index, element) {
		if (!element.name) { return; }
		
		// Find this element's form
		var form = $(element).closest('form');
		
		// Setup the file button
		$(element).before((element.title ? element.title : 'Browse'));

		$(element).parent().on('click', function(event) {
			element.click();
		});

		// Setup the file label
		var label = form.find("[data-file-label='" + element.name + "']");
		
		if (label) {
			label.on('click', function(event) {
				element.click();
			});

			$(element).change(function(event) {
				label.html(event.target.files[0]['name']);
			});
		}
		
		// Setup the file preview
		var preview = form.find("[data-file-preview='" + element.name + "']");
		
		if (preview) {
			$(element).change(function(event) {
				var file = event.target.files[0];

				if (!file || !file.type.match('image.*')) {
					preview.hide();
					return;
				}

				var reader = new FileReader();

				reader.onload = (function(file) {
					return function(event) {
						preview.attr("src", event.target.result);
						preview.show();
					};
				}) (file);

				reader.readAsDataURL(file);
			});
		}
	});
};
