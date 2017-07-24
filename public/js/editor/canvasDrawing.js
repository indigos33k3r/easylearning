var CanvasDrawing = function() {
	var canvas;
	var color 		= EditorOptions.color;
	var lineWidth 	= 22;
	var vLinePatternBrush;
	var hLinePatternBrush;
	var squarePatternBrush;
	var diamondPatternBrush;

	fabric.Object.prototype.transparentCorners = false;

	$("#drawing").click(function() {
		canvas.isDrawingMode = !canvas.isDrawingMode;
	});

	$("#drawingWidth").bind('keyup mouseup', function ()  {
		changeLineWidth($(this).val());
	})

	function initPatterns() {

	  	if (fabric.PatternBrush) {
	  		vLinePatternBrush = new fabric.PatternBrush(canvas);
			hLinePatternBrush = new fabric.PatternBrush(canvas);
		  	squarePatternBrush = new fabric.PatternBrush(canvas);
		  	diamondPatternBrush = new fabric.PatternBrush(canvas);
	  	}

	  	if (canvas.freeDrawingBrush) {
	  		canvas.freeDrawingBrush.color = color;
	  		canvas.freeDrawingBrush.width = parseInt(lineWidth, 10) || 1;
	  		canvas.freeDrawingBrush.shadowBlur = 0;
	  	}

	  	vLinePatternBrush.getPatternSrc = function() {
	  		var patternCanvas = fabric.document.createElement('canvas');
	  		patternCanvas.width = patternCanvas.height = 10;
	  		var ctx = patternCanvas.getContext('2d');
	  		ctx.strokeStyle = this.color;
	  		ctx.lineWidth = 5;
	  		ctx.beginPath();
	  		ctx.moveTo(0, 5);
	  		ctx.lineTo(10, 5);
	  		ctx.closePath();
	  		ctx.stroke();

	  		return patternCanvas;
	  	};

	  	hLinePatternBrush.getPatternSrc = function() {
	  		var patternCanvas = fabric.document.createElement('canvas');
	  		patternCanvas.width = patternCanvas.height = 10;
	  		var ctx = patternCanvas.getContext('2d');
	  		ctx.strokeStyle = this.color;
	  		ctx.lineWidth = 5;
	  		ctx.beginPath();
	  		ctx.moveTo(5, 0);
	  		ctx.lineTo(5, 10);
	  		ctx.closePath();
	  		ctx.stroke();

	  		return patternCanvas;
	  	};

	  	squarePatternBrush.getPatternSrc = function() {
	  		var squareWidth = 10, squareDistance = 2;

	  		var patternCanvas = fabric.document.createElement('canvas');
	  		patternCanvas.width = patternCanvas.height = squareWidth + squareDistance;
	  		var ctx = patternCanvas.getContext('2d');

	  		ctx.fillStyle = this.color;
	  		ctx.fillRect(0, 0, squareWidth, squareWidth);

	  		return patternCanvas;
	  	};

	  	diamondPatternBrush.getPatternSrc = function() {
	  		var squareWidth = 10, squareDistance = 5;
	  		var patternCanvas = fabric.document.createElement('canvas');
	  		var rect = new fabric.Rect({
	  			width: squareWidth,
	  			height: squareWidth,
	  			angle: 45,
	  			fill: this.color
	  		});

	  		var canvasWidth = rect.getBoundingRectWidth();

	  		patternCanvas.width = patternCanvas.height = canvasWidth + squareDistance;
	  		rect.set({ left: canvasWidth / 2, top: canvasWidth / 2 });

	  		var ctx = patternCanvas.getContext('2d');
	  		rect.render(ctx);

	  		return patternCanvas;
	  	};
	}

  	$('#drawing-mode-selector li').click(function() {
  		canvas.isDrawingMode = true;
	  	if ($(this).data('value') === 'hline') {
	  		canvas.freeDrawingBrush = vLinePatternBrush;
	  	} else if ($(this).data('value') === 'vline') {
	  		canvas.freeDrawingBrush = hLinePatternBrush;
	  	} else if ($(this).data('value') === 'square') {
	  		canvas.freeDrawingBrush = squarePatternBrush;
	  	} else if ($(this).data('value') === 'diamond') {
	  		canvas.freeDrawingBrush = diamondPatternBrush;
	  	} else {
	  		canvas.freeDrawingBrush = new fabric[$(this).data('value') + 'Brush'](canvas);
	  	}

	  	if (canvas.freeDrawingBrush) {
	  		canvas.freeDrawingBrush.color = color;
	  		canvas.freeDrawingBrush.width = parseInt(lineWidth, 10) || 1;
	  	}
  	});


	function changeColor(newColor) {
		console.log(newColor);
		color = newColor;
		canvas.freeDrawingBrush.color = color;	
	}

	function changeLineWidth(newLineWidth) {
		lineWidth = newLineWidth;
		canvas.freeDrawingBrush.width = parseInt(lineWidth, 10) || 1;
	}

	function updateCanvas(newCanvas) {
		canvas = newCanvas;
		initPatterns();

	}

  	return {
		changeColor: changeColor,
		changeLineWidth: changeLineWidth,
		updateCanvas: updateCanvas
	}
}