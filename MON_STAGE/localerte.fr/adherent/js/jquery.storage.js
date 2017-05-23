(function($){
	$.storage={
		'name':'aicom',
		
		'init':function(){
			if(sessionStorage.getItem(this.name)===null) sessionStorage.setItem(this.name,JSON.stringify({}));
			if(localStorage.getItem(this.name)===null) localStorage.setItem(this.name,JSON.stringify({}));
		},
		
		'setSession':function(index,value){
			this.init();
			tableau=JSON.parse(sessionStorage.getItem(this.name));
			tableau[index]=value;
			sessionStorage.setItem(this.name,JSON.stringify(tableau));
		},
		'getSession':function(index){
			this.init();
			tableau=JSON.parse(sessionStorage.getItem(this.name));
			return index===null?tableau:tableau[index];
		},
		'existSession':function(index){
			this.init();
			tableau=JSON.parse(sessionStorage.getItem(this.name));
			return typeof(tableau[index])!=='undefined';
		},
		'removeSession':function(index){
			this.init();
			tableau=JSON.parse(sessionStorage.getItem(this.name));
			delete tableau[index];
			sessionStorage.setItem(this.name,JSON.stringify(tableau));
		},
		
		'setLocal':function(index,value){
			this.init();
			tableau=JSON.parse(localStorage.getItem(this.name));
			tableau[index]=value;
			localStorage.setItem(this.name,JSON.stringify(tableau));
		},
		'getLocal':function(index){
			this.init();
			tableau=JSON.parse(localStorage.getItem(this.name));
			return index===null?tableau:tableau[index];
		},
		'existLocal':function(index){
			this.init();
			tableau=JSON.parse(localStorage.getItem(this.name));
			return typeof(tableau[index])!=='undefined';
		},
		'removeLocal':function(index){
			this.init();
			tableau=JSON.parse(localStorage.getItem(this.name));
			delete tableau[index];
			localStorage.setItem(this.name,JSON.stringify(tableau));
		}
	};
})(jQuery);
