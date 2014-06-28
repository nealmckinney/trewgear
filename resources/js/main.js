emeraldcode.cart.updateUI(function () {
    var cartCount = emeraldcode.cart.itemCount();
    if (cartCount > 0) {
        $('#cartStatus').find('.count').text(cartCount);
        $('#cartStatusLi').show();
    } else {
        $('#cartStatusLi').hide();
    }
});


emeraldcode.handleLoginState = function () {
    $('.loggedin,.loggedout').hide();
    console.log(emeraldcode.isLoggedIn());
    if (emeraldcode.isLoggedIn()) {
        if (sessionStorage['username']) {
            $('.loggedin').find('a .username').text(sessionStorage['username']).end().show();
        }
        $('.loggedin.signoutlink').show();
    } else {
        $('.loggedout').show();
    }
};

$(document).ready(function() {
	emeraldcode.clientid = 'trewgear';
	//emeraldcode.removeCoupon();
	emeraldcode.handleLoginState();
	emeraldcode.cart.triggerUpdateUI();
	
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
	
	
});



jQuery(function () {
    $('.signoutlink a').click(function (ev) {
        ev.preventDefault();
        delete sessionStorage['username'];
        emeraldcode.logout(function (data) {
            window.location = '/index.php';
        });
    });
});

function getMarqueeSize() {
	var size;
	var windowWidth = $(window).width();
	console.log("getMarqueeSize: "+windowWidth);
	if (windowWidth < 321) {
		size = {width:320, height:178};
	} else if (windowWidth < 481) {
		//size = {width:320, height:178};
		size = {width:480, height:267};
	} else if (windowWidth < 641 && windowWidth > 480) {
		size = {width:600, height:334};
	} else if (windowWidth < 750 && windowWidth > 641) {
		size = {width:640, height:356};
	} else if (windowWidth < 979 && windowWidth > 750) {
		size = {width:768, height:428};
		//size = {width:640, height:356};
	} else {
		// default:
		size = {width:970, height:530};
	}
	
	return size;
}

function getParameterByName(url, name) {
  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
  var regexS = "[\\?&]"+name+"=([^&#]*)";
  var regex = new RegExp( regexS );
  var results = regex.exec( url );
  if( results == null )
    return "";
  else
    return decodeURIComponent(results[1].replace(/\+/g, " "));
}