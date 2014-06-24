var Pdp = {
	
	init: function(productID, colors, related, isSwag) {
		this.productID = productID;
		this.colors = colors.split(",");
		this.related = related;
		this.isSwag = isSwag;
		this.toolTipOffset = 20;
		this.bgCache = [];
		this.initObjects();
	},
	
	initObjects: function() {
		EventDispatcher.init(this);
		var btns = [];
		var len = this.colors.length;
		for (var i=0; i < len; i++) {
			var btn = $("#thumb"+i);
			btns.push(btn);
		};
		this.buttonGroup = new ButtonGroup(btns);
		this.buttonGroup.addEventListener("click", this, this.onBtnClick);
		this.buttonGroup.triggerButton(0);
		
		if (len < 2) $("#colorNav").hide();
		
		this.wall = new Wall(this.related);
		
		//this.path = "resources/images/products/backgrounds/"+this.productID+"_"+this.colors[0]+".jpg";
		//var img = $.create("img", {src:this.path});
		//$(img).load(proxy(this.onBackgroundLoad, this));

	},
	
	onBackgroundLoad: function() {
		//console.log("onBackgroundLoad");
		this.bgCache[this.buttonGroup.selectedIndex] = true;
		$("#productBackground").hide();
		$("#productBackground").css({background:"url("+this.path+") bottom right no-repeat"});
		$("#productBackground").fadeIn(1000);
	},
	
	positionToolTip: function(e) {
		$(".tooltip").css("top", e.pageY);
		var offset = (e.pageX + 205 < 1168) ? this.toolTipOffset : -(205+this.toolTipOffset);
		//console.log("offset: "+offset);
		$(".tooltip").css("left", e.pageX + offset);
	},
	
	onRelatedOver: function(e, index) {
		if (!index) index = 0;
		var obj = this.related[index];
		$(".tooltip").empty();
		
		var title = $.create("p", {"class": "title"},[obj.name]);
		$(".tooltip").append(title);
		
		if (obj.desc_short) {
			var desc = $.create("p", {},[obj.desc_short]);
			$(".tooltip").append(desc);
		}
		
		var cta = $.create("p", {"class": "cta"},["Learn More"]);
		$(".tooltip").append(cta);
		
		
		this.positionToolTip(e);
		$(".tooltip").fadeIn(250);
	},
	
	onRelatedOut: function(e, index) {
		//console.log("onRelatedOut: ");
		if (!index) index = 0;
		$(".tooltip").hide();
	},
	
	onMouseMove: function(e, index) {
		if (!index) index = 0;
		var target = $("#related"+index);
		//console.log("target: "+target);
		
		//var position = target.offset();
		
		this.positionToolTip(e);
		//console.log("e.pageX: "+e.pageX);
		//console.log("e.pageY: "+e.pageY);
		//console.log("position.left: "+position.left);
		
	},
	
	onBtnClick: function() {

		var index = this.buttonGroup.selectedIndex;
		var color = this.colors[index].split(" ").join("").split("?").join("");
		
		if (this.isSwag == 1) {
			this.path = "resources/images/products/backgrounds/"+this.productID + ".jpg";
		} else {
			this.path = "resources/images/products/backgrounds/"+this.productID + "_" + color + ".jpg";
		}
		
		$("#productBackground").hide();
		if (this.bgCache[this.buttonGroup.selectedIndex] != true) {
			var img = $.create("img", {src:this.path});
			$(img).load(proxy(this.onBackgroundLoad, this));
		} else {
			console.log("cached!");
			this.onBackgroundLoad();
		}
		

	}
}