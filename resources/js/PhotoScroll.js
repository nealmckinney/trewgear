/**
 * Description goes here.
 * @class   PhotoScroll
 * @author  Neal Mckinney
 * @date    03.08.2013
 * @version 0.1
**/

function PhotoScroll(target) {
	this.target = target;
	this.initObjects();
	this.initEvents();
	this.onResize();
}

PhotoScroll.prototype.toString = function() {
	return "PhotoScroll";
}

// INITIALIZATION =======================================================================================================

PhotoScroll.prototype.initObjects = function() {
	this.prevLeft = 0;
	this.loadCount = 0;
	this.scroll = this.target.find(".scroll");
	this.slides = this.target.find(".slide");
	this.currentSlide = $(this.slides[0]);
	this.currentSlide.addClass("current");
}

PhotoScroll.prototype.initEvents = function() {
	var len = this.slides.length;
	for (var i=0; i < len; i++) {
		var slide = $(this.slides[i]);
		slide.on("click", {slide:slide}, this.onSlideClick.bind(this));
		var image = slide.attr("data-photo");
		
		var link = getParameterByName(image, "link");
		if (link) slide.attr("data-link", link);
		
		var content = slide.find(".slide-content");
		var img = $('<img src="'+image+'">');
		$(img).on("load", this.onImageLoad.bind(this));
		content.append(img);
	};
	
	var instance = this;
	$(window).resize(function() {
	  instance.onResize();
	});
	
	var instance = this;
	this.target.swipe({
		
			swipeStatus:function(event, phase, direction, distance) {
				// speed up the swipe a bit here:
				//distance = distance*1.5;
				
				var str = "";

				if (phase=="move") {
					str="You have moved " + distance +" pixels, past 200 and the handler will fire";
					if (direction == "right") {
						distance = -distance;
					}
					//console.log("distance: "+distance);
					//console.log("str: "+str);
					instance.scroll.removeClass("animated");
					instance.scroll.css("left", instance.prevLeft-distance*.5);
				}
				
				if (phase=="cancel") {
					str="You took to long and the swipe was canceled";
					dragOffset = 0;
					instance.scroll.css("left", instance.prevLeft);
					instance.scroll.addClass("animated");
				}

				if (phase=="end") {
					
					console.log("distance: "+distance);
					if (distance > 200) {
						
						var slides = instance.scroll.find(".slide");
						var index = slides.index(instance.currentSlide);

						// if (direction == "right") {
						// 							index--;
						// 							if (index < 0) index = slides.length-1;
						// 							var next = $(slides[index]);
						// 						} else {
						// 							index++;
						// 							if (index == slides.length) index = 0;
						// 							var next = $(slides[index]);
						// 
						// 						}
						var next = instance.getNextSlide(direction);
						
						instance.scroll.addClass("animated");
						instance.showSlide(next);
					} else {
						instance.scroll.css("left", instance.prevLeft);
						instance.scroll.addClass("animated");
					}
					
					if (distance > 0) instance.swiped = true;
					
					//console.log("direction: "+direction);
					  
				}

			},
			
	        //Generic swipe handler for all directions
	        swipe:function(event, direction, distance, duration, fingerCount) {
	          //console.log("You swiped " + direction + distance );

	        },
	        //Default is 75px, set to 0 for demo so any distance triggers swipe
	         // threshold:75,
			 allowPageScroll:"vertical"
	      });

	$(this.target).find(".arrow.next").on("click", this.onNextClick.bind(this));
	$(this.target).find(".arrow.prev").on("click", this.onPrevClick.bind(this));
	
}

// ACTIONS ==============================================================================================================

PhotoScroll.prototype.getNextSlide = function(direction) {
	var slides = this.scroll.find(".slide");
	var index = slides.index(this.currentSlide);

	if (direction == "right") {
		index--;
		if (index < 0) index = slides.length-1;
		var next = $(slides[index]);
	} else {
		index++;
		if (index == slides.length) index = 0;
		var next = $(slides[index]);

	}
	return next;
};


PhotoScroll.prototype.centerSlides = function() {
	var countOffset = Math.floor((this.slides.length-1)*.5);
	console.log("countOffset: "+countOffset);
	// set the initial item position offset:
	//this.scroll.removeClass("animated");
	var len = countOffset;
	for (var i=0; i < len; i++) {
		var children = this.scroll.children(".slide");
		var lastChild = children[children.length-1];
		this.scroll.prepend(lastChild);
	};
	//this.swiped = true;
	this.currentSlide.removeClass("current");
	this.currentSlide.trigger("click");
	console.log("this.currentSlide.length: "+this.currentSlide.length);
	this.centered = true;
};

PhotoScroll.prototype.showSlide = function(slide) {
	var image = slide.attr("data-photo");
	console.log("clicked image: "+image);
	if (slide.hasClass("current")) return;
	if (this.currentSlide) this.currentSlide.removeClass("current");
	slide.addClass("current");
	
	var shifted = false;
	var offset = slide.position();
	var fullWidth = this.scroll.width();
	this.currentSlide = slide;
	console.log("set current slide");
	// console.log("offset.left: "+offset.left);
	
	if (-offset.left < this.prevLeft) {
		// scrolling right:
		if (offset.left > fullWidth*.5) {
			var firstChild = this.scroll.children(".slide")[0];
			this.scroll.removeClass("animated");
			this.scroll.append(firstChild);

			var width = $(firstChild).width();
			var currentLeft = this.scroll.cssNumber("left");
			this.scroll.css("left", currentLeft+width);
			shifted = true;
		}
		
	} else if (-offset.left > this.prevLeft) {
		// scrolling left:
		if (offset.left < fullWidth*.5) {
			var children = this.scroll.children(".slide");
			var lastChild = children[children.length-1];
			this.scroll.removeClass("animated");
			this.scroll.prepend(lastChild);

			var width = $(lastChild).width();
			var currentLeft = this.scroll.cssNumber("left");
			this.scroll.css("left", currentLeft-width);
			shifted = true;
		}
		
	}
	
	var offset = slide.position(); // pull again here
	var currentLeft = this.scroll.css("left");
	this.scroll.css("left", -offset.left);
	if (shifted) this.scroll.addClass("animated");
	this.prevLeft = -offset.left;
	
	var img = slide.find("img");
	var width = img.width()+20;
	//console.log("width: "+width);
	// this.target.width(width);
	// this.currentWidth = width;
	// this.onResize();
};



// EVENTS ===============================================================================================================

PhotoScroll.prototype.onNextClick = function(e) {
	var next = this.getNextSlide("left");
	this.scroll.addClass("animated");
	this.showSlide(next);
};

PhotoScroll.prototype.onPrevClick = function(e) {
	var next = this.getNextSlide("right");
	this.scroll.addClass("animated");
	this.showSlide(next);
};


PhotoScroll.prototype.onImageLoad = function(e) {
	this.loadCount++;
	console.log("onImageLoad: " + this.loadCount);
	if (this.loadCount == this.slides.length) {
		if (this.target.attr("data-center")) {
			this.centerSlides();
		}
	}
};


PhotoScroll.prototype.onResize = function() {
	if (this.swiped) {
		this.swiped = false;
	} else {
		var width = $(window).width();
		
		console.log("window width: "+width);
		if (width < 640) width = 640;

		//var marqueeSize = this.currentSlide;
		this.itemWidth = (width > 979) ? 980 : 490;//this.currentSlide.width();
		//this.itemWidth = this.currentWidth;
		console.log("this.itemWidth: "+this.itemWidth);
		// if (this.itemWidth != marqueeWidth) {
		// 	this.itemWidth = marqueeWidth;
		// 	this.redraw();
		// }

		//if (window.isMobile) width = 1024;
		//var padding = (width > this.itemWidth) ? Math.floor((width-this.itemWidth)*.5) : 0;
		var padding = Math.floor((width-(this.itemWidth))*.5);
		console.log("width: "+width);
		console.log("this.itemWidth: "+this.itemWidth);
		if (width < this.itemWidth) padding = 0;
		this.target.css("padding-left", padding);
		this.target.css("padding-right", padding);

		//this.nextBtn.css("padding-right", padding);
		//this.prevBtn.css("padding-left", padding);
	}
};


PhotoScroll.prototype.onSlideClick = function(e) {
	console.log("this.swiped: "+this.swiped);
	if (this.swiped) {
		this.swiped = false;
	} else {
		console.log("click!!!");
		
		var slide = e.data.slide;
		var image1 = this.currentSlide.attr("data-photo");
		console.log("image1: "+image1);
		
		var image2 = slide.attr("data-photo");
		console.log("image2: "+image2);
		
		if (image1 == image2 && this.centered) {
			console.log("link here!");
			var link = slide.attr("data-link");
			if (link) {
				if (link.indexOf("/") != -1) {
					window.location = link;
				} else {
					window.location = window.rootpath+"pdp/"+link;
				}
				
			}
		} else {
			console.log("else no link");
			this.showSlide(slide);
		}
	}
	
};

