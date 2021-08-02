jQuery(document).ready(function($){
  
  $('.nav-tabs li').on('click',function(e){
	  e.preventDefault();
  	 $('.nav-tabs li').removeClass('active');
  	 $(this).addClass('active');
  	 var s= $('.nav-tabs .active a').attr('href');
	 var l=  $('.tab-content .tab-pane ').attr('id');
     $('.tab-content .tab-pane').removeClass('in active');
	 
	  if(s=='#home'){
		   $('.tab-pane[id="home"]').addClass('in active');
	  }
	  else if(s=='#menu1'){
		   $('.tab-pane[id="menu1"]').addClass('in active');
	  }
	  else{
		  $('.tab-pane[id="menu2"]').addClass('in active');
	  }
	 
	 
  });
 

});