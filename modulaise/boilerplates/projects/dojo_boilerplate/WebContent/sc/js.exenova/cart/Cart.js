dojo.provide("exenova.cart.Cart");
dojo.declare("exenova.cart.Cart", null, {

	debug:true,

	constructor: function(){

		// setup this object
		this.debugOut('exenova.cart.Cart constructor');
		window.Controller.register("init", this);
		window.Controller.register("addtocart", this);
	},

	resolveAction:function(arg){
		switch (arg.action){
		case 'init':
			this.init();
			break;
		case 'addtocart':
			this.addtocart(arg);
			break;
		}
	},
	
	init: function(action){
		this.debugOut('exenova.cart.Cart init');
		dojo.query(".js_buy").connect("onclick",function(e){
			window.Controller.doAction({"action":"addtocart","message":this});
			e.preventDefault(); // stop the event
		});
	},

	addtocart: function(arg){
		this.debugOut('exenova.cart.Cart addtocart');
		this.debugOut(arg.message);
		var productid = arg.message.getAttribute('productid');
		this.debugOut('You have added the product with id='+productid);
		alert('You have added the product with id='+productid);
	},
	
	debugOut: function(msg){
		if(this.debug===true){
			try{
				console.log(msg);
			}catch(err){}
		}
	}
});
