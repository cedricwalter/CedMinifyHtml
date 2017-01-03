(function($) {
//get all angle_selector tags and create angle_selector objects for each
	var dom_angle_selectors = $('angle_selector');

	var angle_selectors = {};

	for (var i = 0; i < dom_angle_selectors.length; i++) {

		var das = $('#' + dom_angle_selectors[i].id);

		// galaxiis
		var das2 = $('#' + dom_angle_selectors[i].id+ '2');
		var displayValue = $('#' + dom_angle_selectors[i].id+ '3');

		displayValue.html(Number(das2.attr("value")).toFixed(3) + " rad");
		// end galaxiis

		angle_selectors[das.attr("id")] = new angle_selector(das.attr("id"), das.attr("height"), das.attr("width"), das2.attr("value"), das.attr("angle2"), das.attr("radius"), das.attr("handle_radius"), das.attr("ccw"), das.attr("angle1_label"), das.attr("angle2_label"));
		angle_selectors[das.attr("id")].init();
	}

	function angle_selector(id, height, width, angle1, angle2, radius, handle_radius, ccw, angle1_label, angle2_label) {

		if (id == undefined)
			throw 'ID for angle_selector undefined';
		if (height == undefined)
			throw 'Height for angle_selector undefined';
		if (width == undefined)
			throw 'Width for angle_selector undefined';

		this.id = id;
		this.height = parseInt(height);
		this.width = parseInt(width);

		this.angle1 = parseFloat(angle1);
		this.angle2 = parseFloat(angle2);
		if (radius == undefined)
			this.radius = 50;
		else
			this.radius = parseInt(radius);
		if (handle_radius == undefined)
			this.handle_radius = 10;
		else
			this.handle_radius = parseInt(handle_radius);
		if (ccw != undefined && ccw.toLowerCase() == 'true')
			this.ccw = true;
		else if (ccw != undefined)
			this.ccw = false;
		this.angle1_label = angle1_label;
		this.angle2_label = angle2_label;

		this.mouse_is_down = false;
		this.mouse_down_position = {x: 0, y: 0};
		this.angle1_selected = false;
		this.angle2_selected = false;

		this.init = function () {

			var canvas_id = id + '_canvas';
			$('#' + id).append(
				$('<canvas>').attr(
					{id: canvas_id, height: this.height, width: this.width}
				)
			);

			this.canvas = $('#' + canvas_id)[0];
			this.context = this.canvas.getContext('2d');

			this.canvas.onmousedown = function (e) {
				//since this function is run within the canvas
				//we need access the angle selector via the global hash angle_selectors
				//in order to get mouse_is_down, mouse_down_position, etc

				var angle_selector = angle_selectors[this.parentElement.id];

				angle_selector.mouse_is_down = true;
				var click = {x: e.offsetX, y: e.offsetY};
				angle_selector.mouse_down_position.x = click.x;
				angle_selector.mouse_down_position.y = click.y;

				//check if either handle was selected
				if (angle_selector.angle1 != undefined) {
					var angle1_pos = {
						x: angle_selector.width / 2 + Math.cos(angle_selector.angle1) * angle_selector.radius
						, y: angle_selector.height / 2 - Math.sin(angle_selector.angle1) * angle_selector.radius
					};

					//if the click was inside the handle, the handle is selected
					if ((angle1_pos.x - click.x) * (angle1_pos.x - click.x) + (angle1_pos.y - click.y) * (angle1_pos.y - click.y) <= angle_selector.handle_radius * angle_selector.handle_radius) {
						angle_selector.angle1_selected = true;
					}
				}

				//check if either handle was selected
				if (angle_selector.angle2 != undefined) {
					var angle2_pos = {
						x: angle_selector.width / 2 + Math.cos(angle_selector.angle2) * angle_selector.radius
						, y: angle_selector.height / 2 - Math.sin(angle_selector.angle2) * angle_selector.radius
					};

					//if the click was inside the handle, the handle is selected
					if ((angle2_pos.x - click.x) * (angle2_pos.x - click.x) + (angle2_pos.y - click.y) * (angle2_pos.y - click.y) <= angle_selector.handle_radius * angle_selector.handle_radius) {
						angle_selector.angle2_selected = true;
					}
				}

				angle_selector.draw();

			}

			this.canvas.onmouseup = function (e) {
				//see onmousedown regarding this

				var angle_selector = angle_selectors[this.parentElement.id];

				if (angle_selector.mouse_is_down) {
					var click = {x: e.offsetX, y: e.offsetY};

					//if neither angle handle is selected and the click wasn't "dragged" reverse the direction
					if (!angle_selector.angle1_selected && !angle_selector.angle2_selected && Math.abs(click.x - angle_selector.mouse_down_position.x) + Math.abs(click.y - angle_selector.mouse_down_position.y) < 5) {
						//need to explicitly check for true/false so angle selectors without ccw defined don't all the sudden define it
						if (angle_selector.ccw == true)
							angle_selector.ccw = false;
						else if (angle_selector.ccw == false)
							angle_selector.ccw = true;
					}

					angle_selector.mouse_is_down = false;
					angle_selector.angle1_selected = false;
					angle_selector.angle2_selected = false;

					angle_selector.sync_dom_element();

					angle_selector.draw();

				}

			}

			this.canvas.onmousemove = function (e) {
				//see onmousedown regarding this

				var angle_selector = angle_selectors[this.parentElement.id];

				//if one of the handles is selected, move it to the closest point to the mouse
				if (angle_selector.mouse_is_down && (angle_selector.angle1_selected || angle_selector.angle2_selected)) {
					var click = {x: e.offsetX, y: e.offsetY};

					var vx = click.x - angle_selector.width / 2;
					var vy = -(click.y - angle_selector.height / 2); //need the strangely place negative here because the y coordinate on the canvas is reversed from what normal people do

					var angle = Math.atan(vy / vx);

					//depending on the quadrant we may need to add to the atan result
					if (vx < 0) {
						angle += Math.PI;
					} else if (vx > 0 && vy < 0) {
						angle += 2 * Math.PI;
					}

					if (angle_selector.angle1_selected)
						angle_selector.angle1 = angle;
					else if (angle_selector.angle2_selected)
						angle_selector.angle2 = angle;

					angle_selector.draw();

					angle_selector.sync_dom_element();

				}
			}


			this.draw();

		}

		this.draw = function () {
			this.context.clearRect(0, 0, this.width, this.height);

			//draw full circle
			if (this.mouse_is_down) {
				this.context.fillStyle = '#eeeeee';
			} else {
				this.context.fillStyle = '#ffffff';
			}
			this.context.beginPath();
			this.context.arc(this.width / 2, this.height / 2, this.radius, 0, 2 * Math.PI);
			this.context.stroke();
			this.context.fill();

			//path
			if (this.ccw != undefined) {

				//bold path between two angles
				if (this.angle1 != undefined && this.angle2 != undefined) {
					this.context.beginPath();
					this.context.arc(this.width / 2, this.height / 2, this.radius, 2 * Math.PI - this.angle1, 2 * Math.PI - this.angle2, this.ccw);
					this.context.lineWidth = 4;
					this.context.stroke();
				}

				//direction indicator
				var dir = 1;
				if (this.ccw)
					dir = -1;

				this.context.beginPath();
				this.context.arc(this.width / 2, this.height / 2, this.radius / 2, Math.PI / 2, 3 * Math.PI / 2, !this.ccw);
				this.context.lineWidth = 1;
				this.context.stroke();
				this.context.beginPath();
				this.context.moveTo(this.width / 2, this.height / 2 + this.radius / 2);
				this.context.lineTo(this.width / 2 + dir * 10, this.height / 2 + this.radius / 2 + 10);
				this.context.stroke();
				this.context.beginPath();
				this.context.moveTo(this.width / 2, this.height / 2 + this.radius / 2);
				this.context.lineTo(this.width / 2 + dir * 10, this.height / 2 + this.radius / 2 - 10);
				this.context.stroke();

			}

			//angle1 handle
			if (this.angle1 != undefined) {
				this.context.fillStyle = '#ff0000';
				this.context.beginPath();
				this.context.arc(this.width / 2 + this.radius * Math.cos(2 * Math.PI - this.angle1), this.height / 2 + this.radius * Math.sin(2 * Math.PI - this.angle1), this.handle_radius, 0, 2 * Math.PI);
				this.context.stroke();
				this.context.fill();
				if (this.angle1_label != undefined) {
					this.context.fillStyle = '#000000';
					this.context.font = 'bold 16pt Calibri';
					this.context.fillText(angle1_label, this.width / 2 + this.radius * Math.cos(2 * Math.PI - this.angle1) - 6, this.height / 2 + this.radius * Math.sin(2 * Math.PI - this.angle1) + 6);
				}
			}

			//angle2 handle
			if (this.angle2 != undefined) {
				this.context.fillStyle = '#ff0000';
				this.context.beginPath();
				this.context.arc(this.width / 2 + this.radius * Math.cos(2 * Math.PI - this.angle2), this.height / 2 + this.radius * Math.sin(2 * Math.PI - this.angle2), this.handle_radius, 0, 2 * Math.PI);
				this.context.stroke();
				this.context.fill();
				if (this.angle2_label != undefined) {
					this.context.fillStyle = '#000000';
					this.context.font = 'bold 16pt Calibri';
					this.context.fillText(angle2_label, this.width / 2 + this.radius * Math.cos(2 * Math.PI - this.angle2) - 6, this.height / 2 + this.radius * Math.sin(2 * Math.PI - this.angle2) + 6);
				}
			}

		}

		this.sync_dom_element = function () {
			//this persists the object properties to the dom element
			var das = $('#' + this.id);

			// galaxiis
			var hidden = $('#' + this.id + "2");
			var displayValue = $('#' + this.id + "3");
			// end galaxiis

			if (this.angle1 != undefined) {
				das.attr('angle1', this.angle1);
				// galaxiis
				hidden.attr('value', this.angle1);
				displayValue.html(Number(this.angle1).toFixed(3) + " rad");
				// end galaxiis
			}
			if (this.angle2 != undefined) {
				das.attr('angle2', this.angle2);
			}
			if (this.ccw != undefined)
				das.attr('ccw', this.ccw);

		}

	}
})(jQuery);