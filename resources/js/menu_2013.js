function mainmenu(){
	
	// Nav toggle:
	$(".btn-navbar").on("click", function() {
		var navCollapse = $(".nav-collapse");
		if (navCollapse.hasClass("open")) {
			navCollapse.removeClass("open");
			navCollapse.removeClass("auto");
			navCollapse.css("height", 0);
		} else {
			navCollapse.addClass("open");
			var height = $("#trew_nav").height();
			console.log("height: "+height);
			navCollapse.css("height", height);
			setTimeout(function() {
				navCollapse.addClass("auto");
			}, 500);
		}
	});
	
	
	
$(" #trew_nav ul ").css({display: "none"}); // Opera Fix
$(" #trew_nav ul ").css({visibility: "hidden"}); // Opera Fix
$(" #trew_nav li").hover(function(){
	
		var width = $(window).width();
		if (width < 980) return;
	
		if ($(this).hasClass("topButton")) {
			// clear out pre-selected items from back button:
			$(" #trew_nav ul ").css({visibility: "hidden"}); // Opera Fix
		}
		var yOffset = 0;
		var child = $(this).find('ul:first');
		
		if (child.hasClass('product_cta')) {
			//console.log("show image");
			var id = child.attr("id");
			$(child).empty();
			
			//var shadow = $.create("div", {"class": "trew_nav_shadow drop"});
			var link = $.create("a", { href:rootpath+"pdp/"+id });
			var imagePath = child.attr("data-image");
			if (imagePath) {
				var image = $.create("img", { src:imagePath});
			} else {
				var image = $.create("img", { src:rootpath+"resources/images/nav/products/"+id+".jpg?random="+ (new Date()).getTime()});
			}
			
			$(link).css({"min-width": "208px"});
			//$(image).css({"min-width": "208px"});
			//$(child).append(shadow);
			$(child).append(link);
			$(link).append(image);
			
			
			//$(child).html("<a href='/pdp.php?pID="+id+"'><img class='trew_nav_image' src='/resources/images/nav/products/" + id + ".jpg'></a>");
			
			$(image).hide();
			$(image).bind("load", function () {
				//console.log("this: "+this);
				$(this).fadeIn(500);
			});
		}
		
		var element = $(this).find('ul:first');
		//var destHeight = element.css("height");
		//var destWidth = element.css("width");
		
		// noticed some dimensions getting set during rollout, so hardcoding for now:
		var destHeight = 267;
		var destWidth;
		//var destWidth = 116px;
		//console.log("destWidth: "+destWidth);
		
		
		var startHeight = "0px";
		var startWidth = "0px";
		
		// if tier 1 retain the top value, otherwise offset from parent top:
		if (child.hasClass("tier1")) {
			destWidth = 149;
			yOffset = child.css("top");
			startWidth = destWidth;
		} else if (child.hasClass("tier2")) {
			destWidth = 149;
			yOffset = -$(this).position().top;
			startHeight = destHeight;
		} else {
			destWidth = 208;
			yOffset = -$(this).position().top;
			//yOffset += 20;
			startHeight = destHeight;
		}

		//if ($(this).) var yOffset = $(this).position().top;
		
		//console.log(destHeight);
		element.css({visibility: "visible", display:"block", top:yOffset, height:startHeight, width:startWidth}).animate({height:destHeight, width:destWidth},250);
		},function(){
		$(this).find('ul:first').css({visibility: "hidden"});
		});
		
}

 
 
 $(document).ready(function(){
	mainmenu();
	// $("#newsletter-signup").css("display", "block");
});