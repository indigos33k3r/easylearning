var colorPicker;
var EditorStyles = function() {
	let fontWeightComponent 	= $('#fontWeight');
	let fontStyleComponent 		= $('#fontStyle');
	let textDecorationComponent = $('#textDecoration');
	let canvasBgImageComponent 	= $('#canvasImageBg');
	var selectedObject;
	var width;
	var height;
	var positionX;
	var positionY;
	init();

	function init() {
		initColorPickers();

		for (var i = 0; i < fonts.length; i++) {
			addGoogleFont(fonts[i]);
		}

		addListeners();
		disableProperties(true);
		$.subscribe('colorChanged', onColorChanged);
		$.subscribe('colorHoverChanged', onColorHoverChanged);
		$.subscribe('objectSelected', onObjectSelected);
		$.subscribe('objectModified', onObjectSelected);
		$.subscribe('selectionCleared', onSelectionCleared);
		$.subscribe('textSelectionChanged', onTextSelectionChanged);

		$('#transparency').on('input', function(e){
			var min = e.target.min,
			max = e.target.max,
			val = e.target.value;	

			$(e.target).css({
				'backgroundSize': ((val - min) * 100) / (max - min) + '% 100%'
			});

			$("#opacityTooltip").css({'transform': 'translateX('+ ((((val - min) * 100) / (max - min)) + 5) +'px)'});
		}).trigger('input');

		$('#zoomRange').on('input', function(e){
			var min = e.target.min,
			max = e.target.max,
			val = e.target.value;	

			$(e.target).css({
				'backgroundSize': ((val - min) * 100) / (max - min) + '% 100%'
			});

			$("#zoomRangeTooltip").css({'transform': 'translateX('+ ((((val - min) * 100) / (max - min)) + 0) +'px)'});
		}).trigger('input');

		$('#charSpacing').on('input', function(e){
			var min = e.target.min,
			max = e.target.max,
			val = e.target.value;	

			$(e.target).css({
				'backgroundSize': ((val - min) * 100) / (max - min) + '% 100%'
			});

			$("#charSpacingTooltip").css({'transform': 'translateX('+ ((((val - min) * 100) / (max - min)) + 5) +'px)'});
		}).trigger('input');


		// $('input[type=range]').on('input', function(e){
		// 	var min = e.target.min,
		// 	max = e.target.max,
		// 	val = e.target.value;

		// 	$(".bubble-tip").css({
		// 		'perspective': '1000px',
		// 		'backface-visibility': 'hidden', 
		// 		'transform': 'translateX('+ (val - min) * 100 / (max - min) +')'
		// 	});
		// }).trigger('.bubble-tip');

	}

	function addListeners() {
		$("#canvasImageBg").click(onCanvasImageBgChanged);
		$("#charSpacing").change(onCharSpacingChanged);
		$("#charSpacingDecrease").click(function() {
			var currentValue = parseInt($("#charSpacing").val());
			$("#charSpacing").val(currentValue - 50);
			$("#charSpacing").change();
		});
		$("#charSpacingIncrease").click(function() {
			var currentValue = parseInt($("#charSpacing").val());
			$("#charSpacing").val(currentValue +  50);
			$("#charSpacing").change();
		});
		$(".fontFamily").click(onFontFamilyChanged);
		$(".fontFamily").hover(
			function() {
				onFontHoverChanged($(this).data('value'))
			}, 
			function() {
				onFontHoverChanged(EditorOptions.fontFamily);
			}
		);
		$(".fontOpt-selectPicker").change(onFontSizeChanged);
		$("#fontStyle").click(onFontStyleChanged);
		$("#fontWeight").click(onFontWeightChanged);
		$("#height").change(onHeightChanged);
		$("#lineWidth").change(onLineWidthChanged);
		$("#positionX").change(onPositionXChanged);
		$("#positionY").change(onPositionYChanged);
		$("#rotation").change(onRotationChanged);
		$("#selectEditable").focusout(onFontSizeChanged);
		$("#shapeColor").change(onShapeColorChanged);
		$("#shapeStroke").change(onShapeStrokeChanged);
		$(".textAlign").click(onTextAlignChanged);
		$("#textDecoration").click(onTextDecorationChanged);
		$("#transparency").change(onOpacityChanged);
		$("#transparencyDecrease").click(function() {
			var currentValue = parseInt($("#transparency").val());
			$("#transparency").val(currentValue - 10);
			$("#transparency").change();
		});
		$("#transparencyIncrease").click(function() {
			var currentValue = parseInt($("#transparency").val());
			$("#transparency").val(currentValue +  10);
			$("#transparency").change();
		});
		$("#width").change(onWidthChanged);
	}

	function onObjectSelected(e, params) {
		selectedObject = params.object;
		disableProperties(false);
		fillObjectProperties();
	}

	function disableProperties(value) {
		if (!selectedObject || selectedObject.get('type') != "path-group") {
			$("#lineWidth").prop('disabled', value);
			var svalue = value === true ? "disable" : "enable";
			$("#shapeColor").spectrum(svalue);
			$("#shapeStroke").spectrum(svalue);
		} 

		$("#transparency").prop('disabled', value);
		$("#width").prop('disabled', value);
		$('#height').prop('disabled', value);
		$("#positionX").prop('disabled', value);
		$("#positionY").prop('disabled', value);
		$("#rotation").prop('disabled', value);
		$("#maintainProportions").prop('disabled', value);
		
		if (value == true) {
			$("#width").val("");
			$('#height').val("");
			$("#positionX").val("");
			$("#positionY").val("");
			$("#rotation").val("");
			$("#maintainProportions").val("");
		}
	}

	function fillObjectProperties() {
		$("#width").val(parseInt(selectedObject.width * selectedObject.scaleX));
		$('#height').val(parseInt(selectedObject.height * selectedObject.scaleY));
		$("#positionX").val(parseInt(selectedObject.left));
		$("#positionY").val(parseInt(selectedObject.top));
		$("#rotation").val(parseInt(selectedObject.angle));

		width       = $("#width").val();
		height      = $("#height").val();
		positionX   = $("#positionX").val();
		positionY   = $("#positionY").val();

		if (selectedObject.get('type') == 'image') {
			return;			
		}
		if (selectedObject.get('type') == "path-group") {
			$("#shapeColor").spectrum("set", selectedObject.paths[0].fill);
			$("#shapeStroke").spectrum("set", selectedObject.paths[0].stroke);
			$("#lineWidth").val(parseInt(selectedObject.paths[0].strokeWidth));
			$("#transparency").val(100 - (selectedObject.opacity * 100))
			return;
		}

		$("#charSpacing").val(selectedObject.charSpacing);
		$(".fontOpt-selectPicker").val(parseInt(selectedObject.fontSize));
		if (selectedObject.setSelectionStyles && selectedObject.isEditing) {
			var styles = selectedObject.getSelectionStyles(selectedObject.selectionStart, selectedObject.selectionEnd);
			highlightFontWeight(selectedObject.getSelectionStyles()['fontWeight']);
			highlightFontStyle(selectedObject.getSelectionStyles()['fontStyle']);
			highlightTextDecoration(selectedObject.getSelectionStyles()['textDecoration']);
			highlightFontFamily(selectedObject.getSelectionStyles()['fontFamily']);
		} else {
			highlightFontFamily(selectedObject.fontFamily);
			highlightFontWeight(selectedObject.fontWeight);
			highlightFontStyle(selectedObject.fontStyle);
			highlightTextDecoration(selectedObject.textDecoration);
		}
		
		highlightTextAlign(selectedObject.textAlign);
		// highlightCanvasBgImage(selectedObject.canvasBgImage);
		
		
	}

	function onCanvasImageBgChanged() {
		var newCanvasBgImage = "addBg";
		if (canvasBgImageComponent.attr('data-value') == "addBg") {			
			newCanvasBgImage = "removeBg";
		}
		EditorOptions.canvasBgImage = newCanvasBgImage;
		highlightCanvasBgImage(newCanvasBgImage);
		dispatchEvent("canvasBgImageChanged", EditorOptions.canvasBgImage); 
	}

	function onCharSpacingChanged() {
		dispatchEvent("charSpacingChanged", $(this).val());
	}

	function onColorChanged(e, params) {
		EditorOptions.color = params.color;
		dispatchEvent('colorChanged', params.color);
	}

	function onColorHoverChanged(e, params) {
		dispatchHoverEvent('colorHoverChanged', params.color);
	}

	function onFontSizeChanged() {
		EditorOptions.fontSize = $(this).val();
		dispatchEvent("fontSizeChanged", EditorOptions.fontSize);
	}


	function onFontFamilyChanged() {
		var fontFamilyComponent = $(this);
		var newFontFamily = fontFamilyComponent.attr('data-value');
		EditorOptions.fontFamily = newFontFamily;
		highlightFontFamily(newFontFamily);
		dispatchEvent("fontFamilyChanged", EditorOptions.fontFamily); 
	}
	
	function onFontHoverChanged(fontFamily) {
		if ($("#hoverToChangeFont").is(":checked")) {
			dispatchHoverEvent("fontHoverChanged", fontFamily);
		} 
	}

	function onFontWeightChanged() {
		var newFontWeight = "bold";
		if (fontWeightComponent.attr('data-value') == "bold") {
			newFontWeight = "normal";
		}
		EditorOptions.fontWeight = newFontWeight;
		highlightFontWeight(newFontWeight);
		dispatchEvent("fontWeightChanged", EditorOptions.fontWeight);        
	}

	function onFontStyleChanged() {
		var newFontStyle = "italic";
		if (fontStyleComponent.attr('data-value') == "italic") {
			newFontStyle = "normal";
		}
		EditorOptions.fontStyle = newFontStyle;
		highlightFontStyle(newFontStyle);
		dispatchEvent("fontStyleChanged", EditorOptions.fontStyle);        
	}

	function onHeightChanged() {
		if ($('#maintainProportions').is(":checked")) {
			var newWidth = parseInt(width * ($(this).val() / height));
			$('#width').val(newWidth);
			dispatchEvent("widthChanged", newWidth);
			width = $(this).val();
		}
		height = $(this).val();
		dispatchEvent("heightChanged", parseInt($(this).val()));
	}


	function onLineWidthChanged() {
		dispatchEvent("lineWidthChanged", $(this).val());
	}


	function onOpacityChanged() {
		var opacity = (100 - $(this).val()) / 100;;
		dispatchEvent("opacityChanged", opacity);
	}

	function onPositionXChanged() {
		if ($('#maintainProportions').is(":checked")) {
			var newPositionY = parseInt(positionY * ($(this).val() / positionX));
			$('#positionY').val(newPositionY);
			dispatchEvent("positionYChanged", newPositionY);
			positionY = $(this).val();
		}
		positionX = $(this).val();
		dispatchEvent("positionXChanged", parseInt($(this).val()));
	}

	function onPositionYChanged() {
		if ($('#maintainProportions').is(":checked")) {
			var newPositionX = parseInt(positionX * ($(this).val() / positionY));
			$('#positionX').val(newPositionX);
			dispatchEvent("positionXChanged", newPositionX);
			positionX = $(this).val();
		}
		positionY = $(this).val();
		dispatchEvent("positionYChanged", parseInt($(this).val()));
	}

	function onRotationChanged() {
        dispatchEvent("rotationChanged", $(this).val());
    }

	function onShapeColorChanged() {
		shapeColor = $(this).val();
		dispatchEvent('shapeColorChanged', shapeColor);
	}

	function onShapeStrokeChanged() {
		shapeStroke = $(this).val();
		dispatchEvent('shapeStrokeChanged', shapeStroke);
	}

	function onTextDecorationChanged() {
		var newTextDecoration = "underline";
		if (textDecorationComponent.attr('data-value') == "underline") {
			newTextDecoration = "none";
		}
		EditorOptions.textDecoration = newTextDecoration;
		highlightTextDecoration(newTextDecoration);
		dispatchEvent("textDecorationChanged", EditorOptions.textDecoration); 
	}

	function onTextAlignChanged() {
		var textAlignComponent = $(this);
		var newTextAlign = textAlignComponent.attr('data-value');
		EditorOptions.textAlign = newTextAlign;
		highlightTextAlign(newTextAlign);
		dispatchEvent("textAlignChanged", EditorOptions.textAlign); 
	}

	function onTextSelectionChanged() {
		fillObjectProperties();
	}

	function onWidthChanged() {
		if ($('#maintainProportions').is(":checked")) {
			var newHeight = parseInt(height * ($(this).val() / width));
			$('#height').val(newHeight);
			dispatchEvent("heightChanged", newHeight);
			height = $(this).val();
		}
		width = $(this).val();
		dispatchEvent("widthChanged", parseInt($(this).val()));
	}

	function highlightFontWeight(fontWeight) {
		fontWeightComponent.attr('data-value', fontWeight);
		if (fontWeight == "bold") {
			fontWeightComponent.css({ 
				"background-color": "#ccc",
				"padding": "0.1rem"
			});          
		} else {
			fontWeightComponent.css({
				"background-color": "transparent",
				"padding": "0"
			});   
		}
	}

	function highlightFontStyle(fontStyle) {
		fontStyleComponent.attr('data-value', fontStyle);
		if (fontStyle == "italic") {
			fontStyleComponent.css({ 
				"background-color": "#ccc",
				"padding": "0.1rem"
			});  
		} else {
			fontStyleComponent.css({
				"background-color": "transparent",
				"padding": "0"
			});
		}
	}

	function highlightTextDecoration(textDecoration) {
		textDecorationComponent.attr('data-value', textDecoration);
		if (textDecoration == "underline") {
			textDecorationComponent.css({ 
				"background-color": "#ccc",
				"padding": "0.1rem"
			});          
		} else {
			textDecorationComponent.css({
				"background-color": "transparent",
				"padding": "0"
			});   
		}
	}

	function highlightTextAlign(textAlign) {
		$(".textAlign").css({
			"background-color": "transparent",
			"padding": "0"
		});   

		$("#textAlign-" + textAlign).css({ 
			"background-color": "#ccc",
			"padding": "0.1rem"
		});          
	}

	function highlightFontFamily(fontFamily) {
		$(".fontFamily").css({
			"background-color": "transparent",
			"color": "#000",
		    "cursor": "cursor",
		    "padding": ".5rem 2rem"
		});   

		$("#fontFamily-" + fontFamily).css({ 
		    "background-color": "#3875b3",
		    "color": "#fff",
		    "cursor": "pointer",
		    "padding": "1rem 2rem"
		});          
	}

	function highlightCanvasBgImage(canvasBgImage) {
		canvasBgImageComponent.attr('data-value', canvasBgImage);
		if (canvasBgImage == "removeBg") {
			canvasBgImageComponent.css({
				"background-color": "transparent",
				"padding": "0"
			}); 
        
		} else {
			canvasBgImageComponent.css({ 
				"background-color": "#ccc",
				"padding": "0.1rem"
			});  	  
		} 
 	}


	function onSelectionCleared() {
		$("#shapeColor").spectrum("set", shapeColor);
		$("#shapeStroke").spectrum("set", shapeStroke);
		$("#opacity").val(0);
		$(".fontOpt-selectPicker").val(EditorOptions.fontSize);
		highlightFontWeight(EditorOptions.fontWeight);
		highlightFontStyle(EditorOptions.fontStyle);
		highlightTextDecoration(EditorOptions.textDecoration);
		highlightTextAlign(EditorOptions.textAlign);
		highlightFontFamily(EditorOptions.fontFamily);
		highlightCanvasBgImage(EditorOptions.canvasBgImage);

		disableProperties(true);
	}

	function dispatchHoverEvent(eventName, value) {
		$.publish('styleHoverEvent', {'eventName': eventName, 'value': value});
	}


	function dispatchEvent(eventName, value) {
		$.publish('styleEvent', {'eventName': eventName, 'value': value});
	}

	function addGoogleFont(fontName) {
		if (true) {
    		$("head").append("<link href='storage/fonts/" + fontName + ".ttf' type='text/css'>");
    		// var fontFamilyString = 'font-family:"' + fontName + '"';
    		// $("body").append("<div style='" + fontFamilyString + ";' class='hiddenContent'>Font</div>");
		}
	}

	function initColorPickers() {
		colorPicker = new ColorPicker();

		$("#shapeColor, #shapeStroke").spectrum({
			showPaletteOnly: true,
			togglePaletteOnly: true,
			togglePaletteMoreText: 'more',
			togglePaletteLessText: 'less',
			color: 'blanchedalmond',
			hideAfterPaletteSelect:true,
			palette: [
				["#000","#444","#666","#999","#ccc","#eee","#f3f3f3","#fff"],
				["#f00","#f90","#ff0","#0f0","#0ff","#00f","#90f","#f0f"],
				["#f4cccc","#fce5cd","#fff2cc","#d9ead3","#d0e0e3","#cfe2f3","#d9d2e9","#ead1dc"],
				["#ea9999","#f9cb9c","#ffe599","#b6d7a8","#a2c4c9","#9fc5e8","#b4a7d6","#d5a6bd"],
				["#e06666","#f6b26b","#ffd966","#93c47d","#76a5af","#6fa8dc","#8e7cc3","#c27ba0"],
				["#c00","#e69138","#f1c232","#6aa84f","#45818e","#3d85c6","#674ea7","#a64d79"],
				["#900","#b45f06","#bf9000","#38761d","#134f5c","#0b5394","#351c75","#741b47"],
				["#600","#783f04","#7f6000","#274e13","#0c343d","#073763","#20124d","#4c1130"]
			]
		});

		var x = document.createElement("input");
		x.setAttribute("type", "color");
		if (x.type == "text") {
			if (document.getElementById("html5DIV")) {
				document.getElementById("html5DIV").style.visibility = "hidden";
			}
		}
	}
}