fabric.Object.prototype.uid = 0;
var EditorOptions = {
	canvasBgImage: "removeBg",
	color: "#00000",
	fontFamily: "Roboto",
	fontSize: 28,
	fontWeight: "normal",
	fontStyle: "normal",
	textDecoration: "none",
	textAlign: "left",
	lineWidth: $("#lineWidth").val(),
	textInputValue: "Enter Text",
	scaleFactor: 1.1
}

var socketMessage = {
	room: eventId,
	userId: userId
}

var EditorUI = function(pages) {
	var canvasOriginalWidth;
	var canvasOriginalHeight;
	var selectedObject = null;
	var copiedObject;
	var copiedObjects = new Array();
	var canvasPages = [];
	var canvas;
	var currentPage = -1;
	var state;
	var undoArray = [];
	var redoArray = [];
	var saveUndoFlag = false;
	var pasteFlag = false;
	var socketEmitFlag = true;
	var socketEmitCommandFlag = true;
	var customIdIndex = 1;
	var canvasDrawing = new CanvasDrawing();

	init();

	function init() {
		let workbenchHeight = $(".workbench").height()-50;
		let workbenchWidth = $(".workbench").width();
		$("#canvas-div").css('max-height', workbenchHeight);
		$("#canvas-div").css('max-width', workbenchWidth);
		fabric.Object.prototype.objectCaching = false;
		EditorOptions.color = "#000000";
		createCanvasPages();
		addEventListeners();
		addSocketListeners();
	}

	function createCanvasPages() {
		if (pages.length) {
			var image = JSON.parse(pages[0]).backgroundImage;
			canvasOriginalHeight    = image.height;
			canvasOriginalWidth     = image.width;
			for (var i = 0; i < pages.length; i++) {
				$("#canvas-div").append($("<canvas id='canvas"  + i + "'><canvas>"));
				var newCanvas = new fabric.Canvas('canvas' + i);
				$("#canvas" + i).parent().hide();
				newCanvas.loadFromJSON(pages[i]);
				canvasPages.push(newCanvas);
				newCanvas.setHeight(image.height);
				newCanvas.setWidth(image.width);
			}
			canvas = canvasPages[0];
		} else {
			$("#canvas-div").append($("<canvas id='canvas0'><canvas>"));
			var newCanvas = new fabric.Canvas('canvas0');
			canvasPages.push(newCanvas);
			canvas = newCanvas;
			loadBackgroundImage();
		}

		changePage(0);
		setTimeout(function() {
			undoArray.push(JSON.stringify(canvas));
			saveUndoFlag = true;
			saveForUndo();
			$("#undo, #redo").prop('disabled', true);
		}, 300);

	}

	function changePage(pageNumber) {
		$("#canvas" + currentPage).parent().hide();
		$("#canvas" + pageNumber).parent().show();
		currentPage = pageNumber;
		canvas = canvasPages[currentPage];
		canvasDrawing.updateCanvas(canvas);
	}

	function addEventListeners() {
		canvas.on('object:added', onObjectAdded);
		canvas.on('object:selected', onObjectSelected);
		canvas.on('object:modified', onObjectModified);
		canvas.on('object:scaling', onObjectScaling);
		canvas.on('object:moving', onObjectMoving);
		canvas.on('text:selection:changed', onTextSelectionChanged);
		canvas.on('selection:cleared', onSelectionCleared);
		$.subscribe("menuCommand", onMenuCommand); 
		$.subscribe("styleEvent", onStyleEvent);
		$.subscribe("styleHoverEvent", onStyleHoverEvent);
		$.subscribe('templateUse', onTemplateUse);
		$.subscribe("shapeUse", onShapeUse);
		$.subscribe("clipartUse", onClipartUse);
	}

	function addSocketListeners() {
		socketFactory.on('objectAdded', function(message) {
			console.log('received object added', JSON.parse(message));
			socketEmitFlag = false;
			addToCanvas(canvas, {objects: [JSON.parse(message)]});
			canvas.renderAll();
			setTimeout(function() {
				socketEmitFlag = true;
			}, 500);
		});

		$("#history").click(function() {
			console.log('emiting history');
			socketFactory.emit('clearHistory', JSON.stringify(socketMessage));
		})

		socketFactory.on('objectModified', function(message) {
			socketEmitFlag = false;
			var message = JSON.parse(message);
			if (message.type == "group") {
				var objects = message.objects;
				var newGroup = [];
				for (var i = 0; i < objects.length; i++) {
					newGroup.push(canvas.getItemByCustomId(objects[i].customId));
				}
				newGroup = new fabric.Group(newGroup, {
					originX: "center",
					originY: "center"
				});
				delete message.objects;
				newGroup.set(message);
				canvas._activeObject = null;
				newGroup.setCoords();
				canvas.setActiveGroup(newGroup);

			} else {
				var object = canvas.getItemByCustomId(message.customId);
				if (object.get('type') == 'path-group') {
					var customProperties = {};
					for (var key in message) {
						if (isPrimitive(message[key])) {
							customProperties[key] = message[key];
						}
					}
					// object.paths = 
					// console.log(message.paths);
					// console.log(object.paths);
					// for (var i = 0; i < message.paths.length; i++) {
					// 	_obj = new fabric.Path.fromObject(message.paths[i], function(foo) {
					// 		object.paths[i] = foo;
					// 	});
					// }
					object.set(customProperties);
					// console.log(object);
				} else {
					object.set(message);
					$.publish("objectModified", {object: object}); 
				}
			}
			canvas.renderAll();
			saveForUndo();
			
			socketEmitFlag = true;
		});

		socketFactory.on('objectRemoved', function(message) {
			console.log('object removed');
			socketEmitFlag = false;
			var message = JSON.parse(message);
			for (var i = 0; i < message.length; i++) {
				console.log(message[i]);
				var object = canvas.getItemByCustomId(message[i]);
				console.log(object);
				canvas.remove(object);
			}
			canvas.renderAll();
			saveForUndo();
			socketEmitFlag = true;
		})

		socketFactory.on('command', function(message) {
			console.log('received command', JSON.parse(message));
			socketEmitCommandFlag = false;
			var handler = menuCommands[JSON.parse(message)];
			socketEmitCommandFlag = true;	
		});

		socketFactory.on('history', function(message) {
			var message = JSON.parse(message);
			console.log('history received', message);
			saveUndoFlag 		= false;
			socketEmitFlag 		= false;
			var addObjects 		= [];
			if (! jQuery.isEmptyObject(message)) {
				for (var property in message) {
				    if (message.hasOwnProperty(property)) {
				        console.log(message[property]);
				        addObjects.push(message[property]);
				    }
				}
			}
			addToCanvas(canvas, {objects: addObjects});
			canvas.renderAll();

			setTimeout(function() {
				socketEmitFlag = true;
				saveUndoFlag = true;
			}, 500);
		});

		socketFactory.on('undo', function(message) {
			socketEmitCommandFlag = false;
			undo();
			setTimeout(function() {
				socketEmitCommandFlag = true;	
			}, 1000);
		});

		socketFactory.on('redo', function(message) {
			socketEmitCommandFlag = false;
			redo();
			setTimeout(function() {
				socketEmitCommandFlag = true;	
			}, 1000);
		});
	}

	function isPrimitive(test) {
	    return (test !== Object(test));
	};

	function loadBackgroundImage() {
		function getDataUri(url, callback) {
			var image = new Image();

			image.onload = function () {
				var cnv = document.createElement('canvas');
				cnv.width = this.naturalWidth; // or 'width' if you want a special/scaled size
				cnv.height = this.naturalHeight; // or 'height' if you want a special/scaled size
				cnv.getContext('2d').drawImage(this, 0, 0);
				callback(cnv.toDataURL('image/png').replace(/^data:image\/(png|jpg);base64,/, ''));
				callback(cnv.toDataURL('image/png'));
			};
			image.src = url;
		}

		var image = new Image();
		image.onload = function() {
			canvasOriginalHeight    = image.height;
			canvasOriginalWidth     = image.width;
			canvas.setHeight(image.height);
			canvas.setWidth(image.width);
			canvas.setBackgroundImage(new fabric.Image(image), canvas.renderAll.bind(canvas), {
				originX: 'left',
				originY: 'top',
				left: 0,
				top: 0
			});
		}
		getDataUri(EditorOptions.backgroundImage, function(dataURL) {
			image.src = dataURL;
		})
	}

	function addShape(shape) {
		canvas.add(shape).renderAll();
	}

	function saveForUndo() {
		if (saveUndoFlag == false) {
			return;
		}
		redoArray = [];
		$('#redo').prop('disabled', true);
		$('#undo').prop('disabled', false);
		if (state) {
			undoArray.push(state);
			if (undoArray.length >= 15) {
				undoArray.shift();
			}
		}
		state = JSON.stringify(canvas);
	}

	function replay(playStack, saveStack, buttonsOn, buttonsOff) {
		saveStack.push(state);
		state       = playStack.pop();
		var on      = $(buttonsOn);
		var off     = $(buttonsOff);
		on.prop('disabled', true);
		off.prop('disabled', true);
		saveUndoFlag = false;
		canvas.clear();
		
		canvas.loadFromJSON(state, function() {
			saveUndoFlag = true;
			on.prop('disabled', false);
			if (playStack.length) {
				off.prop('disabled', false);
			}
		});
	}

	function onObjectAdded(e) {
		if (socketEmitCommandFlag == false) {
			return;
		}
		console.log("object addeed", e.target.customId);
		if (e.target.customId != undefined) {
			if (customIdIndex <= e.target.customId) {
				customIdIndex = e.target.customId;
			}
			customIdIndex++;
			console.log("new index", customIdIndex);
		}

		if (socketEmitFlag) {
			if (e.target.customId == undefined) {
				if (PROJECT_TYPE != 'template') {
					e.target.customId = customIdIndex;
				}
				customIdIndex++;
			}
			socketMessage.content = e.target; 
			socketFactory.emit('objectAdded', JSON.stringify(socketMessage));
		} 
		fabric.Object.prototype.objectCaching = false;
		canvas.setActiveObject(e.target);
		e.target.setCoords();
		saveForUndo();  
	}

	function onObjectModified(e) {
		console.log("object modified", e.target.customId);
		var object = canvas.getActiveObject() ? canvas.getActiveObject() : canvas.getActiveGroup();
		if (socketEmitFlag) {
			socketMessage.content = object; 
			socketFactory.emit('objectModified', JSON.stringify(socketMessage));
		} 
		$.publish("objectModified", {object: object}); 
		saveForUndo();
	}

	function onObjectSelected(e) {
		selectedObject = canvas.getActiveObject();
		if (selectedObject == null) {
			selectedObject = canvas.getActiveGroup();
		}
		$.publish("objectSelected", {object: selectedObject});
	}

	function onObjectScaling(e) {
		var obj = e.target;
		if (obj.getHeight() > obj.canvas.height || obj.getWidth() > obj.canvas.width) {
			if (obj.originalState) {
				obj.setScaleY(obj.originalState.scaleY);
				obj.setScaleX(obj.originalState.scaleX);        
			}
		}

		obj.setCoords();
		
		if (obj.getBoundingRect().top - (obj.cornerSize / 2) < 0 ||  obj.getBoundingRect().left -  (obj.cornerSize / 2) < 0) {
			obj.top = Math.max(obj.top, obj.top-obj.getBoundingRect().top + (obj.cornerSize / 2));
			obj.left = Math.max(obj.left, obj.left-obj.getBoundingRect().left + (obj.cornerSize / 2));    
		}

		if (obj.getBoundingRect().top+obj.getBoundingRect().height + obj.cornerSize  > obj.canvas.height || obj.getBoundingRect().left+obj.getBoundingRect().width + obj.cornerSize  > obj.canvas.width) {
			obj.top = Math.min(obj.top, obj.canvas.height-obj.getBoundingRect().height+obj.top-obj.getBoundingRect().top - obj.cornerSize / 2);
			obj.left = Math.min(obj.left, obj.canvas.width-obj.getBoundingRect().width+obj.left-obj.getBoundingRect().left - obj.cornerSize /2);    
		}
	}

	function onObjectMoving(e) {
		var obj = e.target;
		if (obj.getHeight() > obj.canvas.height || obj.getWidth() > obj.canvas.width) {
			obj.setScaleY(obj.originalState.scaleY);
			obj.setScaleX(obj.originalState.scaleX);        
		}
		obj.setCoords();
		if (obj.getBoundingRect().top - (obj.cornerSize / 2) < 0 || obj.getBoundingRect().left -  (obj.cornerSize / 2) < 0) {
			obj.top = Math.max(obj.top, obj.top-obj.getBoundingRect().top + (obj.cornerSize / 2));
			obj.left = Math.max(obj.left, obj.left-obj.getBoundingRect().left + (obj.cornerSize / 2));    
		}

		if (obj.getBoundingRect().top+obj.getBoundingRect().height + obj.cornerSize  > obj.canvas.height || obj.getBoundingRect().left+obj.getBoundingRect().width + obj.cornerSize  > obj.canvas.width) {
			obj.top = Math.min(obj.top, obj.canvas.height-obj.getBoundingRect().height+obj.top-obj.getBoundingRect().top - obj.cornerSize / 2);
			obj.left = Math.min(obj.left, obj.canvas.width-obj.getBoundingRect().width+obj.left-obj.getBoundingRect().left - obj.cornerSize /2);    
		}
	}

	function onSelectionCleared(e) {
		$.publish("selectionCleared");
		selectedObject = null;
	}

	function onShapeUse(e, parameters) {
		fabric.loadSVGFromURL(parameters.path, function(objects, opt) {
			var shape = fabric.util.groupSVGElements(objects, opt);
			shape.set({
				left: parameters.left,
				top: parameters.top,
			});

			addShape(shape);
		}); 
	}


	function onClipartUse(e, parameters) {
		fabric.Image.fromURL(parameters.path, function(oImg) {
			oImg = Helper.resizeImage(oImg, canvas.width - 50, canvas.height - 50);
			oImg.set({
				left: parameters.left,
				top: parameters.top,
			});
			canvas.add(oImg).renderAll();
		});
	}

	function onTemplateUse(e, parameters) {
		saveForUndo();
		saveUndoFlag = false;
		var myObj = parameters.content;
		addToCanvas(canvas, myObj);
		saveUndoFlag = true;
		canvas.renderAll();
	}

	function onTextSelectionChanged(e) {
		$.publish("textSelectionChanged");
	}

	function addToCanvas(canvas, JSONObjects) {
		for (var i = 0; i < JSONObjects.objects.length; i++) {
			if (JSONObjects.objects[i].type == "path-group" || typeof eval('fabric.'+fabric.util.string.capitalize(JSONObjects.objects[i].type)+'.async') !== 'undefined') {
				var obj = new fabric[fabric.util.string.camelize(fabric.util.string.capitalize(JSONObjects.objects[i].type))].fromObject(JSONObjects.objects[i], function (obj) {
					canvas.add(obj);
				});
			} else {
				var obj = new fabric[fabric.util.string.camelize(fabric.util.string.capitalize(JSONObjects.objects[i].type))].fromObject(JSONObjects.objects[i]);
				canvas.add(obj);
			}
		}
	}

	function toggleDrawMode(options) {
		canvas.isDrawingMode = ! canvas.isDrawingMode;
	}

	function onMenuCommand(e, parameters) {
		var handler = menuCommands[parameters.command];
		handler(parameters.value);
	}

	function onStyleEvent(e, parameters) {
		var handler = styleEvents[parameters.eventName];
		handler(parameters.value);
		canvas.renderAll();
		canvas.calcOffset();
		if (selectedObject) {
			selectedObject.setCoords();
		}
		var object = canvas.getActiveObject() ? canvas.getActiveObject() : canvas.getActiveGroup();
		if (socketEmitFlag) {
			socketMessage.content = object; 
			socketFactory.emit('objectModified', JSON.stringify(socketMessage));
		}
		saveForUndo();
	}

	 function onStyleHoverEvent(e, parameters) {
		var handler = styleHoverEvents[parameters.eventName];
		handler(parameters.value);
		canvas.renderAll();
		canvas.calcOffset();
		if (selectedObject) {
			selectedObject.setCoords();
		}
	}

	// MENU COMMANDS

	var menuCommands = {
		'addText'         	: addText,
		'addImage'          : addImage,
		'bringForward'    	: bringForward,
		'clearCanvas'     	: clearCanvas,
		'copy'            	: copy,
		'paste'             : paste,
		'redo'           	: redo,
		'removeSelected'  	: removeSelected, 
		'sendBackwards'   	: sendBackwards,
		'undo'              : undo,
		'viewMirror'      	: viewMirror
	}

	function addText() {
		var textBox = new fabric.Textbox(EditorOptions.textInputValue, {
			fontFamily: EditorOptions.fontFamily,
			fontSize: EditorOptions.fontSize,
			fontWeight: EditorOptions.fontWeight,
			fontStyle: EditorOptions.fontStyle,
			textDecoration: EditorOptions.textDecoration,
			textAlign: EditorOptions.textAlign,
			fill: EditorOptions.color,
			width: 200,
			height: 100,
			left: 100,
			top: 100, 
		});

		canvas.add(textBox); 
	}

	function addImage(file) {
		socketEmitFlag = false;
		var reader = new FileReader();
		var height  = 100;
		var width   = 100;

		function validateFile(file) {
			var maxFileSize = 2.1;
			var allowedFileTypes = ["jpg", "jpeg", "gif", "png"];
			var result = Helper.isValidImage(file, allowedFileTypes, maxFileSize);
			if (result == "size") {
				alert("File too big");
				return false;
			}

			if (result == "extension") {
				alert("File extension not allowed");
				return false;
			}

			return true;
		}
		
		reader.onload = function (e) {
			var file = $("#fileImage")[0].files[0];
			if (validateFile(file) == false) {
				return;
			}

			var imgObj = new Image();
			imgObj.src = e.target.result;

			imgObj.onload = function () {
				var resizedImage = new Image();
				var targetDimensions = Helper.getImageTargetDimensions(imgObj, 500, 500);
				imgObj = Helper.imageToDataUri(imgObj, targetDimensions.width, targetDimensions.height);
				// resizes image itself

				resizedImage.src = imgObj;
				resizedImage.onload = function() {
					var image = new fabric.Image(resizedImage);
					image = Helper.resizeImage(image, canvas.width, canvas.height);
					// resizing image to canvas dimensions
					socketEmitFlag = true;
					canvas.add(image);
					$("#fileImage").val("");
				}
		   }
	   }

	   reader.readAsDataURL(file);
	}

	function bringForward() {
		if (selectedObject == null) {
			return;
		}
		canvas.bringForward(selectedObject);
		socketMessage.content = selectedObject; 
		socketFactory.emit('objectModified', JSON.stringify(socketMessage));
		saveForUndo();
	}

	function clearCanvas() {
		if (socketEmitCommandFlag) {
			socketMessage.content = "clearCanvas";
			socketFactory.emit("command", JSON.stringify(socketMessage));
		}
		$.publish('resetZoom');
		canvas.clear();
		if (pages.length) {
			canvas.loadFromJSON(pages[currentPage]);
		} else {
			loadBackgroundImage();
		}
	}

	function copy() {
		if (canvas.getActiveGroup()) {
			var activeGroup = canvas.getActiveGroup();
			var objects = activeGroup.getObjects();
			for (var i in objects) {
				var object = fabric.util.object.clone(objects[i]);
				object.set("top", activeGroup.top + activeGroup.height / 2 + object.top + 10);
				object.set("left", activeGroup.left + activeGroup.width / 2 + object.left + 10);
				copiedObjects[i] = object;
			}                    
		} else if (canvas.getActiveObject()) {
			var object = fabric.util.object.clone(canvas.getActiveObject());
			object.set('top', object.top + 10);
			object.set('left', object.left + 10);
			copiedObject = object;
			copiedObjects = new Array();
		}
	}

	function paste() {
		pasteFlag = true;
		if (copiedObjects.length > 0) {
			for (var i in copiedObjects){
			   canvas.add(copiedObjects[i]);
			}                    
		} else if(copiedObject) {
			canvas.add(copiedObject);
		}
		
		canvas.renderAll();
		pasteFlag = false;    
	}

	function redo() {
		socketEmitFlag = false;
		replay(redoArray, undoArray, '#undo', $("#redo"));
		if (socketEmitCommandFlag) {
			socketMessage.content = "redo";
			socketFactory.emit("command", JSON.stringify(socketMessage));
		}
		socketEmitFlag = true;
	}

	function removeSelected() {
		var activeObject = canvas.getActiveObject(),
		activeGroup = canvas.getActiveGroup();
		if (activeObject) {
			if (socketEmitFlag) {
				socketMessage.content = [activeObject.customId];
				socketFactory.emit("objectRemoved", JSON.stringify(socketMessage));
			}
			canvas.remove(activeObject);
		} else if (activeGroup) {
			var objectsInGroup = activeGroup.getObjects();
			canvas.discardActiveGroup();
			var objectIds = [];
			objectsInGroup.forEach(function(object) {
				objectIds.push(object.customId);
				canvas.remove(object);
			});

			socketMessage.content = objectIds;
			socketFactory.emit("objectRemoved", JSON.stringify(socketMessage));
		}
		saveForUndo();
	}

	function sendBackwards() {
		if (selectedObject == null) {
			return;
		}
		canvas.sendBackwards(selectedObject);
		socketMessage.content = selectedObject; 
		socketFactory.emit('objectModified', JSON.stringify(socketMessage));
		saveForUndo();
	}

	function undo() {
		socketEmitFlag = false;
		replay(undoArray, redoArray, '#redo', $("#undo"));
		if (socketEmitCommandFlag) {
			socketMessage.content = "undo";
			socketFactory.emit("command", JSON.stringify(socketMessage));
		}
		socketEmitFlag = true;
	}

	function viewMirror() {
		if (selectedObject == null) {
			return;
		}
		selectedObject.toggle('flipX');
		canvas.renderAll();
		socketMessage.content = selectedObject; 
		socketFactory.emit('objectModified', JSON.stringify(socketMessage));
		saveForUndo();
	}

	// STYLE EVENTS
	var styleHoverEvents = {
		'colorHoverChanged'     : onColorHoverChanged,
		'fontHoverChanged'      : onFontHoverChanged,
		
	}
	var styleEvents = {
		'charSpacingChanged'    : onCharSpacingChanged,
		'colorChanged'          : onColorChanged,
		'fontFamilyChanged'     : onFontFamilyChanged,
		'fontSizeChanged'       : onFontSizeChanged,
		'fontStyleChanged'      : onFontStyleChanged,
		'fontWeightChanged'     : onFontWeightChanged,
		'heightChanged'         : onHeightChanged,
		'lineWidthChanged'      : onLineWidthChanged,
		'opacityChanged' 		: onOpacityChanged,
		'positionXChanged'      : onPositionXChanged,
		'positionYChanged'      : onPositionYChanged,
		'rotationChanged'       : onRotationChanged,
		'shapeColorChanged'     : onShapeColorChanged,
		'shapeStrokeChanged'    : onShapeStrokeChanged,
		'textAlignChanged'      : onTextAlignChanged,
		'textDecorationChanged' : onTextDecorationChanged,
		'widthChanged' 			: onWidthChanged
	}

	function onCharSpacingChanged(spacing) {
		if (selectedObject == null || selectedObject.get('type') != "textbox") {
			return;
		}

		if (selectedObject.setSelectionStyles && selectedObject.isEditing) {
			var style = { };
			style["charSpacing"] = spacing;
			selectedObject.setSelectionStyles(style);
		} else {
			selectedObject.set({
				charSpacing: spacing
			});
		}
	}

	function onColorChanged() {
		canvasDrawing.changeColor(EditorOptions.color);
		if (selectedObject == null || selectedObject.get('type') != "textbox") {
			return;
		}
		if (selectedObject.setSelectionStyles && selectedObject.isEditing) {
			var style = { };
			style["fill"] = EditorOptions.color;
			selectedObject.setSelectionStyles(style);
		} else {
			selectedObject.set({
			   fill: EditorOptions.color
			});
		}

	   
	}

	function onColorHoverChanged(color) {
		if (selectedObject == null || selectedObject.get('type') != "textbox") {
			return;
		}

		if (color == "none") {
			color = EditorOptions.color;
		}

		if (selectedObject.setSelectionStyles && selectedObject.isEditing) {
			var style = { };
			style["fill"] = color;
			selectedObject.setSelectionStyles(style);
		} else {
			selectedObject.set({
			   fill: color
			});
		}
	}

	function onFontFamilyChanged() {
		if (selectedObject == null) {
			return;
		}

		if (selectedObject.setSelectionStyles && selectedObject.isEditing) {
			var style = { };
			style["fontFamily"] = EditorOptions.fontFamily;
			selectedObject.setSelectionStyles(style);
		} else {
			selectedObject["fontFamily"] = EditorOptions.fontFamily;
		}
	}

	function onFontHoverChanged(fontFamily) {
		if (selectedObject == null) {
			return;
		}

		if (selectedObject.setSelectionStyles && selectedObject.isEditing) {
			var style = { };
			style["fontFamily"] = fontFamily;
			selectedObject.setSelectionStyles(style);
		} else {
			selectedObject["fontFamily"] = fontFamily;
		}
	}

	function onFontSizeChanged() {
		if (selectedObject == null) {
			return;
		}

		if (selectedObject.setSelectionStyles && selectedObject.isEditing) {
			var style = { };
			style["fontSize"] = EditorOptions.fontSize;
			selectedObject.setSelectionStyles(style);
		} else {
			selectedObject["fontSize"] = EditorOptions.fontSize;
		}
	}

	function onFontWeightChanged() {
		if (selectedObject.setSelectionStyles && selectedObject.isEditing) {
			var style = { };
			style["fontWeight"] = EditorOptions.fontWeight;
			selectedObject.setSelectionStyles(style);
		} else {
			selectedObject["fontWeight"] = EditorOptions.fontWeight;
		}
	}

	function onFontStyleChanged() {
		if (selectedObject == null) {
			return;
		}

		if (selectedObject.setSelectionStyles && selectedObject.isEditing) {
			var style = { };
			style["fontStyle"] = EditorOptions.fontStyle;
			selectedObject.setSelectionStyles(style);
		} else {
			selectedObject["fontStyle"] = EditorOptions.fontStyle;
		}
	}

	function onHeightChanged(height) {
		if (selectedObject.get('type') == "textbox") {
			selectedObject.height = height;
		} else {
			selectedObject.scaleY = height / selectedObject.height;
		}
	}


	function onLineWidthChanged(width) {
		if (selectedObject == null || selectedObject.get('type') != "path-group") {
			return;
		}

		selectedObject.paths[0].set({
			strokeWidth: width
		});
	}

	function onPositionXChanged(positionX) {
		selectedObject.left = positionX;
	}

	function onPositionYChanged(positionY) {
		selectedObject.top = positionY;
	}

	function onRotationChanged(rotation) {
		if (selectedObject != null) {
			selectedObject.angle = rotation;
		}
	}

	function onShapeColorChanged(color) {
		if (selectedObject == null) {
			return;
		}
		if (selectedObject.get('type') == "path-group") {
			selectedObject.paths[0].set({
				fill: color
			});
		}

		if (selectedObject.get('type') == "path") {
			selectedObject.set({
				fill: color
			});
		}

	}

	function onShapeStrokeChanged(color) {
		if (selectedObject == null) {
			return;
		}
		if (selectedObject.get('type') == "path-group") {
			if (selectedObject.paths[0].strokeWidth == "undefined") {
				selectedObject.paths[0].strokeWidth = 1;
			}

			selectedObject.paths[0].set({
				stroke: color
			});
		}

		if (selectedObject.get('type') == "path") {
			if (selectedObject.strokeWidth == "undefined") {
				selectedObject.strokeWidth = 1;
			}
			selectedObject.set({
				stroke: color
			});
		}
	}

	function onTextDecorationChanged() {
		if (selectedObject == null) {
			return;
		}

		if (selectedObject.setSelectionStyles && selectedObject.isEditing) {
			var style = { };
			style["textDecoration"] = EditorOptions.textDecoration;
			selectedObject.setSelectionStyles(style);
		} else {
			selectedObject["textDecoration"] = EditorOptions.textDecoration;
		}
	}

	function onTextAlignChanged() {
		if (selectedObject != null) {
			selectedObject.textAlign = EditorOptions.textAlign;
		}
	}

	function onOpacityChanged(opacity) {
		if (selectedObject != null) {
			selectedObject.opacity = opacity;
		}
	}

	function onWidthChanged(width) {
		if (selectedObject.get('type') == "textbox") {
			selectedObject.width = width;
		} else {
			selectedObject.scaleX = width / selectedObject.width;
		}
	}

	function getCanvasPages() {
		return canvasPages;
	}

	return {
		getCanvasPages: getCanvasPages,
	}
}