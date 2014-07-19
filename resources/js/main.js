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
	emeraldcode.handleLoginState();
	emeraldcode.cart.triggerUpdateUI();
	
	// Nav toggle:
	$(".btn-navbar").on("click", function() {
		var navCollapse = $(".nav-collapse");
		if (navCollapse.hasClass("open")) {
			navCollapse.removeClass("open");
			navCollapse.removeClass("auto");
			navCollapse.animate({"height":0}, 300, "easeOutExpo");
		} else {
			navCollapse.addClass("open");
			var height = $("#trew-nav").height();
			navCollapse.animate({"height":height}, 500, "easeOutExpo");
			setTimeout(function() {
				navCollapse.addClass("auto");
			}, 500);
		}
	});
	
	var url = window.location.href;
	$("#trew-nav a").each(function() {
		var found = false;
		var href = $(this).attr("href");
		if (url.indexOf(href) != -1 && !found) {
			$(this).parent().addClass("current");
			found = true;
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

function addLoader(target, color) {
	removeLoader(target);
	var theColor = (color) ? color : "#CC6600";
	//<div class='dimmer'></div>
	var loader = $("<div class='loading'></div>");
	var opts = {
	  lines: 13, // The number of lines to draw
	  length: 7, // The length of each line
	  width: 4, // The line thickness
	  radius: 10, // The radius of the inner circle
	  color: theColor, // #rgb or #rrggbb
	  speed: 3, // Rounds per second
	  trail: 60, // Afterglow percentage
	  shadow: false, // Whether to render a shadow
	  top: 'auto',
	  left: 'auto'
	};
	//this.spinner = new Spinner(opts).spin($(loader));
	target.append(loader);
	loader.spin(opts);
	loader.fadeIn(500);
}

function removeLoader(target) {
	target.find(".loading").remove();
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