var Home = {
	
	init: function(featuredProducts) {
		this.featuredProducts = featuredProducts;
		this.initObjects();
	},
	
	initObjects: function() {
		this.marquee = $("#marquee");
		this.productInfo = $("#productInfo");
		var btns = $("#featureProductNav").children(".featureProductItem");
		this.buttonGroup = new ButtonGroup(btns);
		this.buttonGroup.addEventListener("click", this, this.onBtnClick);
		this.buttonGroup.triggerButton(0);
	},
	
	onBtnClick: function() {
		
		var index = this.buttonGroup.selectedIndex;
		var id = this.featuredProducts[index].id;
		var name = this.featuredProducts[index].name;
		var desc_short = this.featuredProducts[index].desc_short;
		var desc_long = this.featuredProducts[index].desc_long;
		
		this.marquee.empty();
		var bg = $.create("img", {"id":"homeBackground", "src":"resources/images/home/"+id+".jpg?random="+ (new Date()).getTime()});
		var prod = $.create("img", {"id":"homeFeaturedProduct", "src":"resources/images/home/products/"+id+".png?random="+ (new Date()).getTime()});
		this.marquee.append(bg);
		this.marquee.append(prod);
		this.fadeIn(bg);
		this.fadeIn(prod);
		
		this.productInfo.empty();
		var title = $.create("h2", {}, [name]);
		var sub = $.create("h4", {}, [desc_short]);
		var body = $.create("p", {}, [desc_long]);
		var link = $.create("a", {"href":"pdp.php?pID="+id, "class":"largeLink"}, ["Get to Know " + name]);
		this.productInfo.append(title);
		this.productInfo.append(sub);
		this.productInfo.append(body);
		this.productInfo.append(link);
	},
	
	fadeIn: function(element) {
		$(element).hide();
		$(element).bind("load", function () {
			$(this).fadeIn(1000);
		});
	}
}