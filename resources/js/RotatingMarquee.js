/**
 * Description goes here.
 * @class   RotatingMarquee
 * @author  Neal Mckinney
 * @date    22.04.2012
 * @version 0.1
**/

function RotatingMarquee(target, nav) {
	this.target = target;
	this.nav = nav;
	this.initObjects();
	this.initEvents();
	this.onResize();
}

RotatingMarquee.prototype.toString = function() {
	return "RotatingMarquee";
}

// INITIALIZATION =======================================================================================================

RotatingMarquee.prototype.initObjects = function() {
	this.index = 0;
	this.prevIndex = 0;
	this.navTimeOut = 0;
	this.itemWidth = 950;
	this.nextBtn = this.target.find(".next");
	this.prevBtn = this.target.find(".prev");
	this.scroll = this.target.find(".scroll");
	this.items = $.makeArray(this.scroll.children(".slide"));
	this.count = this.items.length;
	var countOffset = Math.floor((this.items.length-1)*.5);
	this.positions = [];
	//this.videoMarquee = new VideoMarquee(this.target.find(".video-embed"));
	
	var len = this.items.length;
	console.log("len: "+len);
	for (var i=0; i < len; i++) {
		
		var item = this.items[i];
		// if ($(item).attr("data-video")) {
		// 			$(item).on("click", {id:$(item).attr("data-video")}, this.playVideo.bind(this));
		// 		}
		
		var pos = this.itemWidth*(i-countOffset);
		this.positions[i] = pos;
		// var navItem = $("<div class='multi-nav-item animated'>");
		// 		this.nav.append(navItem);
	};
	
	// if (len < 2) this.nav.hide();
	// this.navGroup = new ButtonGroup(this.nav.find(".multi-nav-item"));
	
	// set the initial item position offset:
	var last = this.items.length-1;
	var len = countOffset;
	for (var i=0; i < len; i++) {
		var item = this.items[last];
		this.items.pop();
		this.items.unshift(item);
	};
	
	var len = this.items.length;
	for (var i=0; i < len; i++) {
		var item = this.items[i];
		$(item).css("left", this.positions[i]);
	};
}

RotatingMarquee.prototype.initEvents = function() {
	this.nextBtn.on("click", this.onNextClick.bind(this));
	this.prevBtn.on("click", this.onPrevClick.bind(this));
	// this.navGroup.addEventListener("click", this, this.onNavButtonClick);
	// this.navGroup.selectButton(0);
	
	var instance = this;
	$(window).resize(function() {
	  instance.onResize();
	});
	
	window.onorientationchange = function() {
		var windowWidth = $(window).width();
		console.log("onorientationchange: " + windowWidth);
		instance.onResize();
	}
	
	this.target.wipetouch({
	  wipeLeft: this.onSwipeLeft.bind(this),
	  wipeRight: this.onSwipeRight.bind(this),
	  preventDefault: false
	});
}

// ACTIONS ==============================================================================================================

RotatingMarquee.prototype.rotate = function(dir) {
	//this.videoMarquee.closePlayer();
	var len = this.items.length;
	for (var i=0; i < len; i++) {
		var item = this.items[i];
		
		var currentLeft = $(item).css("left");
		var destLeft = this.positions[i];
		
		//if (dir == 1) {
			//if (i == len-1) {
			//if (destLeft > currentLeft) {
				$(item).css("left", this.positions[i]);
			//} else {
				//$(item).stop(true, true).animate({left:this.positions[i]}, 500, "easeOutExpo");
			//}
		//} else {
			//if (i == 0) {
			//if (destLeft < currentLeft) {
				//$(item).css("left", this.positions[i]);
			//} else {
				//$(item).stop(true, true).animate({left:this.positions[i]}, 500, "easeOutExpo");
			//}
		//}
	};
	
	var offset = this.index - this.prevIndex;
	// direction override for prev and next clicks:
	if (dir) offset = dir;
	//console.log("offset: "+offset);
	this.scroll.stop(true, true).css("left", (this.itemWidth*offset));
	this.scroll.animate({left:0}, 500, "easeOutExpo");
	this.prevIndex = this.index;
};

RotatingMarquee.prototype.jumpToIndex = function(index, dir) {
	
	//console.log("index: "+index);
	//console.log("this.index: "+this.index);
	var direction = (dir) ? dir : 0;
	
	if (index > this.index) {
		var len = index - this.index;
		for (var i=0; i < len; i++) {
			var first = this.items.shift();
			this.items.push(first);
		};
		
	} else {
		var len = this.index - index;
		for (var i=0; i < len; i++) {
			var last = this.items.pop();
			this.items.unshift(last);
		};
		//this.rotate(-1);
	}
	this.index = index;
	//console.log("index: "+index);
	this.rotate(direction);
};

// RotatingMarquee.prototype.playVideo = function(e) {
// 	e.preventDefault();
// 	var id = e.data.id;
// 	console.log("id: "+id);
// 	this.videoMarquee.playVideo(e);
// };

RotatingMarquee.prototype.fadeButton = function(btn) {
	clearTimeout(this.navTimeOut);
	btn.removeClass("animated").addClass("clicked");
	this.navTimeOut = setTimeout(function() { btn.removeClass("clicked").addClass("animated"); }, 500);
};

RotatingMarquee.prototype.redraw = function() {
	
	var countOffset = Math.floor((this.items.length-1)*.5);
	this.positions = [];
	
	var len = this.items.length;
	for (var i=0; i < len; i++) {
		var pos = this.itemWidth*(i-countOffset);
		this.positions[i] = pos;
	};
	
	for (var i=0; i < len; i++) {
		var item = this.items[i];
		var currentLeft = $(item).css("left");
		var destLeft = this.positions[i];
		$(item).css("left", this.positions[i]);
	};
};




// EVENTS ===============================================================================================================

RotatingMarquee.prototype.onSwipeLeft = function(e) {
	this.swiped = true;
	this.nextBtn.trigger("click");
};

RotatingMarquee.prototype.onSwipeRight = function(e) {
	this.swiped = true;
	this.prevBtn.trigger("click");
};

RotatingMarquee.prototype.onNextClick = function(e) {
	console.log("onNextClick");
	var index = (this.index+1 < this.count) ? this.index+1 : 0;
	this.jumpToIndex(index, 1);
	// this.navGroup.selectButton(index);
	this.fadeButton(this.nextBtn);
};

RotatingMarquee.prototype.onPrevClick = function(e) {
	var index = (this.index-1 > -1) ? this.index-1 : this.count-1;
	this.jumpToIndex(index, -1);
	// this.navGroup.selectButton(index);
	this.fadeButton(this.prevBtn);
};

RotatingMarquee.prototype.onNavButtonClick = function() {
	this.jumpToIndex(this.navGroup.selectedIndex);
}

RotatingMarquee.prototype.onResize = function() {
	
	if (this.swiped) {
		this.swiped = false;
	} else {
		var width = $(window).width();

		var marqueeSize = getMarqueeSize();
		var marqueeWidth = marqueeSize.width;
		if (this.itemWidth != marqueeWidth) {
			this.itemWidth = marqueeWidth;
			this.redraw();
		}

		//if (window.isMobile) width = 1024;
		//var padding = (width > this.itemWidth) ? Math.floor((width-this.itemWidth)*.5) : 0;
		var padding = Math.floor((width-(this.itemWidth))*.5);
		console.log("width: "+width);
		console.log("this.itemWidth: "+this.itemWidth);
		if (width < this.itemWidth) padding = 0;
		this.target.css("padding-left", padding);
		this.target.css("padding-right", padding);

		this.nextBtn.css("padding-right", padding);
		this.prevBtn.css("padding-left", padding);
	}
	
};

