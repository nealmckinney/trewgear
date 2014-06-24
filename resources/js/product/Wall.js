function Wall(info) {
	this.info = info;
	this.toolTipOffset = 20;
	this.initObjects();
}

Wall.prototype.initObjects = function() {
	var len = this.info.length;
	console.log("len: "+len);
	for (var i=0; i < len; i++) {
		var item = $("#wallItem"+i);
		item.on("mouseenter", {index:i}, this.onWallItemOver.bind(this));
		item.on("mouseleave", {index:i}, this.onWallItemOut.bind(this));
		item.on("mousemove", {index:i}, this.onMouseMove.bind(this));
	};
};

Wall.prototype.positionToolTip = function(e) {
	$(".tooltip").css("top", e.pageY);
	var offset = (e.pageX + 205 < 980) ? this.toolTipOffset : -(205+this.toolTipOffset);
	$(".tooltip").css("left", e.pageX + offset);
};

Wall.prototype.onWallItemOver = function(e) {
	var index = e.data.index;
	if (!index) index = 0;
	var obj = this.info[index];
	$(".tooltip").empty();
	
	var title = $.create("p", {"class": "title"},[obj.productName + " - " + obj.colorName]);
	$(".tooltip").append(title);
	
	//console.log("obj.desc_short: "+obj.desc_short);
	// if (obj.desc_short) {
	// 	var desc = $.create("p", {},[obj.desc_short.split("&#174;").join("®")]);
	// 	$(".tooltip").append(desc);
	// }
	
	var cta = $.create("p", {"class": "cta"},["Learn More"]);
	$(".tooltip").append(cta);
	
	this.positionToolTip(e);
	$(".tooltip").fadeIn(250);
};

Wall.prototype.onWallItemOut = function(e, index) {
	//if (!index) index = 0;
	$(".tooltip").hide();
};

Wall.prototype.onMouseMove = function(e, index) {
	//if (!index) index = 0;
	//var target = $("#wallItem"+index);
	this.positionToolTip(e);
};

