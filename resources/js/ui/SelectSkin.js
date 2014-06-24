/**
 * Description goes here.
 * @class   SelectSkin
 * @author  Neal Mckinney
 * @date    20.10.2011
 * @version 0.1
**/

function SelectSkin(target) {
	this.target = target;
	this.initObjects();
	this.initEvents();
}

SelectSkin.prototype.toString = function() {
	return "SelectSkin";
}

// INITIALIZATION =======================================================================================================

SelectSkin.prototype.initObjects = function() {
	EventDispatcher.init(this);
	this.select = this.target.find("select");
	this.label = $("<input></input>");
	$(this.label).attr('readonly', "readonly");
	//var text = $(this.select)[$(this.select).selectedIndex].text;
	//var text = $(this.select + 'option:selected').text();
	var text = $("option:selected", this.select).html();
	//this.selectID = this.select.attr("id");
	//console.log("this.selectID: "+this.selectID);
	//if (this.selectID) var text = $('#' + this.selectID + ' option:selected').html();
	//console.log("text: "+text);
	$(this.label).val(text);
	$(this.label).addClass("label");
	this.target.append(this.label);
}

SelectSkin.prototype.initEvents = function() {
	//this.select.addEvent("change", this.onSelectChange.bind(this));
	$(this.select).on("change", this.onSelectChange.bind(this));
}

// ACTIONS ==============================================================================================================


// EVENTS ===============================================================================================================

SelectSkin.prototype.onSelectChange = function(e) {
	//var text = $(this.select)[this.select.selectedIndex].text;
	//var text = $(this.select).label();
	var text = $("option:selected", this.select).html();
	//if (this.selectID) var text = $('#' + this.selectID + ' option:selected').html();
	//console.log("text: "+text);
	$(this.label).val(text);
	this.dispatchEvent("onChange");
};
/*
$(document).ready(function() {
	var selects = $(document).find(".select-skin");
	for (var i=0; i < selects.length; i++) {
		console.log("selects[i]: "+selects[i]);;
		var select = new SelectSkin($(selects[i]));
	};
});
*/