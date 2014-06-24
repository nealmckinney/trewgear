
/**
* Adds Event Dispatching functionality to a Class.
**/

var EventDispatcher = {
	
	toString:function() {
		return "EventDispatcher";
	},
	
	init:function(obj) {
		
		obj.eventListeners = [];
		
		obj.addEventListener = function(event, listener, callback) {
			obj.eventListeners.push({event:event, listener:listener, callback:callback});
		};
		
		obj.removeEventListener = function(event, listener, callback) {
			var eventObj;
			for (var i=0; i < obj.eventListeners.length; i++) {
				eventObj = obj.eventListeners[i];
				if (event == eventObj.event && listener == eventObj.listener) {
					//console.log(this + " : removeEventListener event: " + event + " listener: " + listener);
					obj.eventListeners.splice(i, 1);
					break;
				}
			};
		};
		
		obj.dispatchEvent = function(event) {
			var eventObj;
			for (var i=0; i < obj.eventListeners.length; i++) {
				eventObj = obj.eventListeners[i];
				if (event == eventObj.event) {
					// fire the callback of each object listening for this event:
					eventObj.callback.apply(eventObj.listener);
				}
			};
		};
	}
}