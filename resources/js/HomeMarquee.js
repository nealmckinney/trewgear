/**
 * Description goes here.
 * @class   HomeMarquee
 * @author  Neal Mckinney
 * @date    08.12.2011
 * @version 0.1
**/

function HomeMarquee(target, navTarget) {
	this.target = target;
	this.navTarget = navTarget;
	this.index = 0;
	this.rotateID = 0;
	this.initObjects();
	this.initEvents();
	this.selectIndex(0);
}

HomeMarquee.prototype.toString = function() {
	return "HomeMarquee";
}

// INITIALIZATION =======================================================================================================

HomeMarquee.prototype.initObjects = function() {
	this.marquees = this.target.find(".marqueeItem");
	var len = this.marquees.length;
	for (var i=0; i < len; i++) {
		var marquee = this.marquees[i];
		
		// add marquee links:
		var link = $("<div>");
		link.addClass("marqueeLink");
		this.navTarget.append(link);
	};
	
	this.buttonGroup = new ButtonGroup(this.navTarget.children(".marqueeLink"));
	this.buttonGroup.addEventListener("click", this, this.onMarqueeButtonClick);
	this.buttonGroup.selectButton(0);
	
	if (len < 2) {
		this.navTarget.hide(0);
	}

}

HomeMarquee.prototype.initEvents = function() {

}

// ACTIONS ==============================================================================================================

HomeMarquee.prototype.startRotation = function() {
	if (this.marquees.length > 1) {
		var self = this;
		this.rotateID = setInterval(function(){self.rotate();}, 8000);
	}
};


HomeMarquee.prototype.rotate = function() {
	this.index++;
	if (this.index == this.marquees.length) this.index = 0;
	this.buttonGroup.selectButton(this.index);
	this.selectIndex(this.index);
};


HomeMarquee.prototype.showMarquee = function() {
	var marquee = this.marquees[this.index];
	var path = marquee.getAttribute("data-bg");
	var color = "#000";
	$(marquee).css("background", color+" url("+path+") top center no-repeat");
	$(marquee).fadeIn(1000, "easeOutQuad");
	this.prevMarquee = marquee;
};

HomeMarquee.prototype.selectIndex = function(index) {
	// hide the previous marquee:
	if (this.prevMarquee) $(this.prevMarquee).fadeOut(0);
	var marquee = this.marquees[index];
	if ($(marquee).attr("data-loaded") != "true") {
		this.loadBackground($(marquee).attr("data-bg"));
	} else {
		this.showMarquee();
	}
};

HomeMarquee.prototype.loadBackground = function(path) {
	var img = $("<img>");
	img.on("load", this.onBackgroundLoad.bind(this));
	img.attr("src", path);
	this.addLoader();
};

HomeMarquee.prototype.addLoader = function() {
	var loader = $("<div class='loading'></div>");
	var opts = {
	  lines: 13, // The number of lines to draw
	  length: 7, // The length of each line
	  width: 4, // The line thickness
	  radius: 10, // The radius of the inner circle
	  color: '#FF0000', // #rgb or #rrggbb
	  speed: 3, // Rounds per second
	  trail: 60, // Afterglow percentage
	  shadow: false, // Whether to render a shadow
	  top: 'auto',
	  left: 'auto'
	};
	//this.spinner = new Spinner(opts).spin($(loader));
	this.target.append(loader);
	loader.spin(opts);
	loader.fadeIn(500);
};

HomeMarquee.prototype.removeLoader = function() {
	this.target.find(".loading").remove();
};




// EVENTS ===============================================================================================================

HomeMarquee.prototype.onMarqueeButtonClick = function() {
	this.index = this.buttonGroup.selectedIndex;
	this.selectIndex(this.index);
	if (this.rotateID) clearInterval(this.rotateID);
	this.rotationCleared = true;
};

HomeMarquee.prototype.onBackgroundLoad = function(e) {
	$(this.marquees[this.index]).attr("data-loaded", "true");
	this.showMarquee();
	if (!this.rotateID) this.startRotation();
	this.removeLoader();
};

