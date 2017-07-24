var Helper = {
	getImageTargetDimensions: function(imgObj, maxWidth, maxHeight) {
		var targetWidth = imgObj.width;
		var targetHeight = imgObj.height;

		if (imgObj.width > maxWidth || imgObj.height > maxHeight) {
			if ((imgObj.width / maxWidth) > (imgObj.height / maxHeight)) {
				var scaleFactor = maxWidth / imgObj.width;
				targetWidth 	= maxWidth;
				targetHeight 	= imgObj.height * scaleFactor;
			} else {
				var scaleFactor = maxHeight / imgObj.height;
				targetHeight 	= maxHeight;
				targetWidth 	= imgObj.width * scaleFactor;
			}
		}
		return {width: targetWidth, height: targetHeight};
	},
	resizeImage: function(image, maxWidth, maxHeight) {
		var dimensions = this.getImageTargetDimensions(image, maxWidth, maxHeight);
		image.width = dimensions.width;
		image.height = dimensions.height;
		return image;
	},
	imageToDataUri: function(img, width, height) {
		// create an off-screen canvas
		var canvas = document.createElement('canvas'),
			ctx = canvas.getContext('2d');

		// set its dimension to target size
		canvas.width = width;
		canvas.height = height;

		// draw source image into the off-screen canvas:
		ctx.drawImage(img, 0, 0, width, height);

		// encode image to data-uri with base64 version of compressed image
		return canvas.toDataURL();
	}, 
	isValidImage: function(file, allowedFileTypes, maxFileSize) {
		var maxFileSize = 2.1;
		if ((file.size / 1024).toFixed(2) / 1024 > maxFileSize) {
			return "size";
		}

		var re = /(?:\.([^.]+))?$/;
		var extension = re.exec(file.name)[1];
		if (allowedFileTypes.indexOf(extension) == -1) {
			return "extension";
		}

		return true;
	}
}