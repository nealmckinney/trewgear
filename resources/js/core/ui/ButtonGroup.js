function ButtonGroup(elements) {
	this.elements = elements;
	this.selectedIndex = null;
	this.initObjects();
}

ButtonGroup.prototype.toString = function() {
	return "ButtonGroup";
}

ButtonGroup.prototype.initObjects = function() {
	if (!this.eventInit) {
		EventDispatcher.init(this);
		this.eventInit = true;
	}
	var len = this.elements.length;
	for (var i=0; i < len; i++) {
		var element = this.elements[i];
		$(element).on("click", {index:i}, this.onBtnClick.bind(this));
	};
}


// ACTIONS =====================================================================================================================

ButtonGroup.prototype.updateButtons = function(elements) {
	this.elements = elements;
	this.initObjects();
};


ButtonGroup.prototype.selectButton = function(index) {
	if (this.selectedIndex != null) {
		var prevElement = this.elements[this.selectedIndex];
		if ($(prevElement).hasClass("selected")) $(prevElement).removeClass("selected");
	}
	this.selectedIndex = index;
	var element = this.elements[this.selectedIndex];
	if (!$(element).hasClass("selected")) $(element).addClass("selected");
}

ButtonGroup.prototype.triggerButton = function(index) {
	this.selectButton(index);
	this.dispatchEvent("click");
}

ButtonGroup.prototype.disableButton = function(index) {
	var element = this.elements[index];
	if (!$(element).hasClass("disabled")) $(element).addClass("disabled");
}

ButtonGroup.prototype.enableButton = function(index) {
	var element = this.elements[index];
	if ($(element).hasClass("disabled")) $(element).removeClass("disabled");
}

// disable all buttons:
ButtonGroup.prototype.disable = function() {
	var len = this.elements.length;
	for (var i=0; i < len; i++) {
		var element = this.elements[i];
		if (!$(element).hasClass("disabled")) $(element).addClass("disabled");
	};
}

// enable all buttons:
ButtonGroup.prototype.enable = function() {
	var len = this.elements.length;
	for (var i=0; i < len; i++) {
		var element = this.elements[i];
		if ($(element).hasClass("disabled")) $(element).removeClass("disabled");
	};
}

ButtonGroup.prototype.getButton = function(index) {
	return this.elements[index];
}

ButtonGroup.prototype.getCurrentButton = function() {
	return this.elements[this.selectedIndex];
}

ButtonGroup.prototype.clear = function() {
	if (this.selectedIndex != null) {
		var prevElement = this.elements[this.selectedIndex];
		if ($(prevElement).hasClass("selected")) $(prevElement).removeClass("selected");
		this.selectedIndex = null;
	}
}


// EVENTS ======================================================================================================================

ButtonGroup.prototype.onBtnClick = function(e) {
	var index = e.data.index;
	if (index == this.selectedIndex) return;
	var element = this.elements[index];
	if ($(element).hasClass("disabled")) return;
	this.selectButton(index);
	this.dispatchEvent("click");
}

