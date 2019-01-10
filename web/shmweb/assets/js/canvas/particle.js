/**
	 * Generates random particles using canvas
	 * 
	 * @class Particles
	 * @constructor
	 * 随机灰尘
	 */
	var canvasDom = document.getElementById('particle');
	function Particles() {
		//particle colors
//		this.colors = ['242, 243, 246']
		this.colors = ['195, 197, 200']
			//adds gradient to particles on true
		this.blurry = true;
		//adds white border
		this.border = false;
		//particle radius min/max
		this.minRadius = 1;
		this.maxRadius = 4;
		//particle opacity min/max
		this.minOpacity = .015;
		this.maxOpacity = .5;
		//particle speed min/max
		this.minSpeed = .05;
		this.maxSpeed = .5;
		//frames per second 
		this.fps = 60;
		//number of particles
		this.numParticles = 350;
		//required canvas variables
		this.canvas = document.getElementById('particle');;
		this.ctx = this.canvas.getContext('2d');
	}

	/**
	 * Initializes everything
	 * @method init
	 */
	Particles.prototype.init = function() {
		this.render();
		this.createCircle();
	}

	/**
	 * generates random number between min and max values
	 * @param  {number} min value
	 * @param  {number} max malue
	 * @return {number} random number between min and max
	 * @method _rand
	 */
	Particles.prototype._rand = function(min, max) {
		return Math.random() * (max - min) + min;
	}

	/**
	 * Sets canvas size and updates values on resize
	 * @method render
	 */
	Particles.prototype.render = function() {
		var self = this,
			// wHeight = $(window).height(),
			// wWidth = $(window).width();
			wHeight = canvasDom.parentNode.offsetHeight,
			wWidth = canvasDom.parentNode.offsetWidth;

		self.canvas.width = wWidth;
		self.canvas.height = wHeight*0.5;

		$(window).on('resize', self.render);
	}

	/**
	 * Randomly creates particle attributes
	 * @method createCircle
	 */
	Particles.prototype.createCircle = function() {
		var particle = [];

		for(var i = 0; i < this.numParticles; i++) {
			var self = this,
				color = self.colors[~~(self._rand(0, self.colors.length))];

			particle[i] = {
				radius: self._rand(self.minRadius, self.maxRadius),
				xPos: self._rand(0, canvasDom.width),
				yPos: self._rand(0, canvasDom.height),
				xVelocity: self._rand(self.minSpeed, self.maxSpeed),
				yVelocity: self._rand(self.minSpeed, self.maxSpeed),
				color: 'rgba(' + color + ',' + self._rand(self.minOpacity, self.maxOpacity) + ')'
			}

			//once values are determined, draw particle on canvas
			self.draw(particle, i);
		}
		//...and once drawn, animate the particle
		self.animate(particle);
	}

	/**
	 * Draws particles on canvas
	 * @param  {array} Particle array from createCircle method
	 * @param  {number} i value from createCircle method
	 * @method draw
	 */
	Particles.prototype.draw = function(particle, i) {
		var self = this,
			ctx = self.ctx;

		if(self.blurry === true) {
			//creates gradient if blurry === true
			var grd = ctx.createRadialGradient(particle[i].xPos, particle[i].yPos, particle[i].radius, particle[i].xPos, particle[i].yPos, particle[i].radius / 1.25);

			grd.addColorStop(1.000, particle[i].color);
			grd.addColorStop(0.000, 'rgba(34, 34, 34, 0)');
			ctx.fillStyle = grd;
		} else {
			//otherwise sets to solid color w/ opacity value
			ctx.fillStyle = particle[i].color;
		}

		if(self.border === true) {
			ctx.strokeStyle = "rgb(201,203,209,0.05)";
			ctx.stroke();
		}

		ctx.beginPath();
		ctx.arc(particle[i].xPos, particle[i].yPos, particle[i].radius, 0, 2 * Math.PI, false);
		ctx.fill();
	}

	/**
	 * Animates particles 
	 * @param  {array} particle value from createCircle & draw methods
	 * @method animate
	 */
	Particles.prototype.animate = function(particle) {
		var self = this,
			ctx = self.ctx;

		setInterval(function() {
			//clears canvas
			self.clearCanvas();
			//then redraws particles in new positions based on velocity
			for(var i = 0; i < self.numParticles; i++) {
				particle[i].xPos += particle[i].xVelocity;
				particle[i].yPos -= particle[i].yVelocity;

				//if particle goes off screen call reset method to place it offscreen to the left/bottom
				if(particle[i].xPos > self.canvas.width + particle[i].radius || particle[i].yPos > self.canvas.height + particle[i].radius) {
					self.resetParticle(particle, i);
				} else {
					self.draw(particle, i);
				}
			}
		}, 1000 / self.fps);
	}

	/**
	 * Resets position of particle when it goes off screen
	 * @param  {array} particle value from createCircle & draw methods
	 * @param  {number} i value from createCircle method
	 * @method resetParticle
	 */
	Particles.prototype.resetParticle = function(particle, i) {
		var self = this;

		var random = self._rand(0, 1);

		if(random > .5) {
			// 50% chance particle comes from left side of window...
			particle[i].xPos = -particle[i].radius;
			particle[i].yPos = self._rand(0, canvasDom.height);
		} else {
			//... or bottom of window
			particle[i].xPos = self._rand(0, canvasDom.width);
			particle[i].yPos = canvasDom.height + particle[i].radius;
		}
		//redraw particle with new values
		self.draw(particle, i);
	}

	/**
	 * Clears canvas between animation frames
	 * @method clearCanvas
	 */
	Particles.prototype.clearCanvas = function() {
		this.ctx.clearRect(0, 0, canvasDom.width, canvasDom.height);
	}

	// go go go!
	var particle = new Particles().init();