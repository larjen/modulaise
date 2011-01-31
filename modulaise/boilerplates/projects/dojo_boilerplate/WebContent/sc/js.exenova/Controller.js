/*
 * Provides a controller, this is the only Object
 * any given other object should ever know about.
 * 
 * This is the only place where instructions should be sent
 * from one object to another, via the internal messaging
 * system.
 * 
 * This is currently not documented.
 * 
 */

dojo.provide("exenova.Controller");
dojo.declare("exenova.Controller", null, {

	_registry:[],
	debug:false,

	constructor: function(){
		return this;
	},

	doAction: function (arg){
		try {
			try {
				if (typeof arg.action === 	"string"){

					// loop through all registered objects
					// for the given action message
					var objectsToPoke = this._getObjects(arg.action);
					var i;
					for (i in objectsToPoke){
						var tempObj = objectsToPoke[i];
						if (typeof tempObj.resolveAction === "function"){
							///if(this.debug){console.log('doAction = '+arg.action);}
							///if(this.debug){console.log(tempObj);}
							tempObj.resolveAction(arg);
						}
					}
				}
			} catch (err){
				///if(this.debug){console.log('err:');console.log(err);}
				if (typeof err.action === 	"string"){

					// loop through all registered objects
					// for the given action message
					var objectsToPoke = this._getObjects(err.action);
					var i;
					for (i in objectsToPoke){
						var tempObj = objectsToPoke[i];
						if (typeof tempObj.resolveAction === "function"){
							tempObj.resolveAction(err);
						}
					}
				}
			}
		}catch(outerError){
			///if(this.debug){console.log('outerError:');console.log(outerError);}
			throw new Error(outerError);
		}
	},

	/*
	 * Register objects in the controller in order for them
	 * to catch events that are being fired.
	 * 
	 * Each registered object must have a function with the
	 * name:
	 * 
	 * resolveAction(Action);
	 * 
	 */

	register : function(action, obj){
		///if(this.debug){console.log('Registering new object with action ='+action);}
		///if(this.debug){console.log(obj);}
		if (typeof obj !== "function"){
			if (this._registry[action]===undefined){
				this._registry[action]= [];
			}
			this._registry[action].push(obj);
		}
	},

	/* returns an array of message types */

	_getActionTypes: function(){
		var messageTypes = [];
		var i;
		for (i in this._registry){
			messageTypes.push(this._registry[i]);
		}
		return messageTypes;	
	},

	/* returns an array of objects registered for a specific message */

	_getObjects: function(action){
		var objectsRegistered = [];
		for (var i in this._registry[action]){
			if (typeof this._registry[action][i] !== "function"){
				///if(this.debug){console.log('Listing object with action = '+action);console.log(this._registry[action][i]);}
				objectsRegistered.push(this._registry[action][i]);
			}
		}
		return objectsRegistered;	
	}
});
