var ColorPicker = function() {

	return {
		clickColor: clickColor,
		mouseOutMap: mouseOutMap,
		mouseOverColor: mouseOverColor
	}

	function mouseOverColor(hex) {
		// document.getElementById("divpreview").style.visibility = "visible";
		// document.getElementById("divpreview").style.backgroundColor = hex;
		// document.body.style.cursor = "pointer";
		if ($("#hoverToChangeColor").is(":checked")) {
			$.publish('colorHoverChanged', {color: hex});
		}
	}

	function mouseOutMap() {
		var colorhex = "#FF0000";
		var color = "#FF0000";
		var colorObj = w3color(color);
		var hh = 0;

		// if (hh == 0) {
		// 	document.getElementById("divpreview").style.visibility = "hidden";
		// } else {
		// 	hh = 0;
		// }
		// document.getElementById("divpreview").style.backgroundColor = colorObj.toHexString();
		document.body.style.cursor = "";
		if ($("#hoverToChangeColor").is(":checked")) {
			$.publish('colorHoverChanged', {color: "none"});
		}
	}

	function clickColor(hex, seltop, selleft, html5) {
		var c, cObj, colormap, areas, i, areacolor, cc;
		if (html5 && html5 == 5)  {
			c = document.getElementById("html5colorpicker").value;
		} else {
			if (hex == 0)  {
				c = document.getElementById("entercolor").value;
			} else {
				c = hex;
			}
		}
		cObj = w3color(c);
		colorhex = cObj.toHexString();
		if (cObj.valid) {
			clearWrongInput();
		} else {
			wrongInput();
			return;
		}

		if ((!seltop || seltop == -1) && (!selleft || selleft == -1)) {
			colormap = document.getElementById("colormap");
			areas = colormap.getElementsByTagName("AREA");
			for (i = 0; i < areas.length; i++) {
				areacolor = areas[i].getAttribute("onmouseover").replace('mouseOverColor("', '');
				areacolor = areacolor.replace('")', '');
				if (areacolor.toLowerCase() == colorhex) {
					cc = areas[i].getAttribute("onclick").replace(')', '').split(",");
					seltop = Number(cc[1]);
					selleft = Number(cc[2]);
				}
			}
		}
		if ((seltop+200)>-1 && selleft>-1) {
			document.getElementById("selectedhexagon").style.top=seltop + "px";
			document.getElementById("selectedhexagon").style.left=selleft + "px";
			document.getElementById("selectedhexagon").style.visibility="visible";
		} else {
			document.getElementById("divpreview").style.backgroundColor = cObj.toHexString();
			document.getElementById("selectedhexagon").style.visibility = "hidden";
		}

		document.getElementById("selectedcolor").style.background = cObj.toHexString();
		// setContrast(cObj.toHexString());

		$.publish('colorChanged', {color: cObj.toHexString()});
	}

	function wrongInput() {
		document.getElementById("entercolorDIV").className = "has-error";
		document.getElementById("wronginputDIV").style.display = "block";
	}

	function clearWrongInput() {
		document.getElementById("entercolorDIV").className = "";
		document.getElementById("wronginputDIV").style.display = "none";
	}

	function setContrast(bgColor) {
		var rgb = [0, 0, 0];
		// randomly update
		rgb[0] = Math.round(Math.random() * 255);
		rgb[1] = Math.round(Math.random() * 255);
		rgb[2] = Math.round(Math.random() * 255);

		// http://www.w3.org/TR/AERT#color-contrast
		var o = Math.round(((parseInt(rgb[0]) * 299) +
		                  (parseInt(rgb[1]) * 587) +
		                  (parseInt(rgb[2]) * 114)) / 1000);
		var fore = (o > 125) ? 'black' : 'white';
		var back = 'rgb(' + rgb[0] + ',' + rgb[1] + ',' + rgb[2] + ')';
		$('#selectedcolor').css('color', fore); 
		$('#selectedcolor').css('background-color', back);
	}

	function hex2rgb (hex, opacity) {
	    hex = hex.trim();
	    hex = hex[0] === '#' ? hex.substr(1) : hex;
	    var bigint = parseInt(hex, 16), h = [];
	    if (hex.length === 3) {
	        h.push((bigint >> 4) & 255);
	        h.push((bigint >> 2) & 255);
	    } else {
	        h.push((bigint >> 16) & 255);
	        h.push((bigint >> 8) & 255);
	    }
	    h.push(bigint & 255);
	    if (arguments.length === 2) {
	        h.push(opacity);
	        return 'rgba('+h.join()+')';
	    } else {
	        return 'rgb('+h.join()+')';
	    }
	}

}