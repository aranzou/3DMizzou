/*-----------------------------------------------------------------------------------
/* Custom JS
-----------------------------------------------------------------------------------*/
	  
/* ----------------- Start Document ----------------- */
jQuery(document).ready(function() {

/*----------------------------------------------------*/
/*	Main Navigation
/*----------------------------------------------------*/

	/* Menu */
	(function() {

		var $mainNav    = $('#navigation').children('ul');

		$mainNav.on('mouseenter', 'li', function() {
			var $this    = $(this),
				$subMenu = $this.children('ul');
			if( $subMenu.length ) $this.addClass('hover');
			$subMenu.hide().stop(true, true).slideDown('fast');
		}).on('mouseleave', 'li', function() {
			$(this).removeClass('hover').children('ul').stop(true, true).slideUp('fast');
		});
		
	})();
	
	/* Responsive Menu */
	(function() {
		selectnav('nav', {
			label: 'Menu',
			nested: true,
			indent: '-'
		});
				
	})();


/*----------------------------------------------------*/
/*	Image Overlay
/*----------------------------------------------------*/

	$(document).ready(function () {
	  $('.picture a').hover(function () {
		$(this).find('.image-overlay-zoom, .image-overlay-link').stop().fadeTo('fast', 1);
	  },function () {
		$(this).find('.image-overlay-zoom, .image-overlay-link').stop().fadeTo('fast', 0);
	  });
	});


/*----------------------------------------------------*/
/*	Back To Top Button
/*----------------------------------------------------*/

	jQuery('#scroll-top-top a').click(function(){
		jQuery('html, body').animate({scrollTop:0}, 300); 
		return false; 
	}); 
	
	
/*----------------------------------------------------*/
/*	Accordion
/*----------------------------------------------------*/
	(function() {

		var $container = $('.acc-container'),
			$trigger   = $('.acc-trigger');

		$container.hide();
		$trigger.first().addClass('active').next().show();

		var fullWidth = $container.outerWidth(true);
		$trigger.css('width', fullWidth);
		$container.css('width', fullWidth);
		
		$trigger.on('click', function(e) {
			if( $(this).next().is(':hidden') ) {
				$trigger.removeClass('active').next().slideUp(300);
				$(this).toggleClass('active').next().slideDown(300);
			}
			e.preventDefault();
		});

		// Resize
		$(window).on('resize', function() {
			fullWidth = $container.outerWidth(true)
			$trigger.css('width', $trigger.parent().width() );
			$container.css('width', $container.parent().width() );
		});

	})();
	
/*----------------------------------------------------*/
/*	Alert Boxes
/*----------------------------------------------------*/
jQuery(document).ready(function()
{
	jQuery(document.body).pixusNotifications({
			speed: 300,
			animation: 'fadeAndSlide',
			hideBoxes: false
	});
});

(function()
{
	$.fn.pixusNotifications = function(options)
	{
		var defaults = {
			speed: 200,
			animation: 'fade',
			hideBoxes: false
		};
		
		var options = $.extend({}, defaults, options);
		
		return this.each(function()
		{
			var wrapper = $(this),
				notification = wrapper.find('.notification'),
				content = notification.find('p'),
				title = content.find('strong'),
				closeBtn = $('<a class="close" href="#"></a>');
			
			$(document.body).find('.notification').each(function(i)
			{
				var i = i+1;
				$(this).attr('id', 'notification_'+i);
			});
			
			notification.filter('.closeable').append(closeBtn);
			
			closeButton = notification.find('> .close');
			
			closeButton.click(function()
			{
				hideIt( $(this).parent() );
				return false;
			});			
			
			function hideIt(object)
			{
				switch(options.animation)
				{
					case 'fade': fadeIt(object);     break;
					case 'slide': slideIt(object);     break;
					case 'box': boxAnimIt(object);     break;
					case 'fadeAndSlide': fadeItSlideIt(object);     break;
					default: fadeItSlideIt(object);
				}
			};
			
			function fadeIt(object)
			{	object
				.fadeOut(options.speed);
			}			
			function slideIt(object)
			{	object
				.slideUp(options.speed);
			}			
			function fadeItSlideIt(object)
			{	object
				.fadeTo(options.speed, 0, function() { slideIt(object) } );
			}			
			function boxAnimIt(object)
			{	object
				.hide(options.speed);
			}
			
			if (options.hideBoxes){}
			
			else if (! options.hideBoxes)
			{
				notification.css({'display': 'block', 'visiblity': 'visible'});
			}
			
		});
	};
})();

/*----------------------------------------------------*/
/*	Tabs
/*----------------------------------------------------*/

	(function() {

		var $tabsNav    = $('.tabs-nav'),
			$tabsNavLis = $tabsNav.children('li'),
			$tabContent = $('.tab-content');

		$tabsNav.each(function() {
			var $this = $(this);

			$this.next().children('.tab-content').stop(true,true).hide()
												 .first().show();

			$this.children('li').first().addClass('active').stop(true,true).show();
		});

		$tabsNavLis.on('click', function(e) {
			var $this = $(this);

			$this.siblings().removeClass('active').end()
				 .addClass('active');
			
			$this.parent().next().children('.tab-content').stop(true,true).hide()
														  .siblings( $this.find('a').attr('href') ).fadeIn();

			e.preventDefault();
		});

	})();

	
/*----------------------------------------------------*/
/*	Form Processing and Verification
/*----------------------------------------------------*/
//The following is for the registration system
(function() {
var animateSpeed=300;
var emailReg = /^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z0-9.-]{2,4}$/;
var stringReg = /[^A-Z0-9]+/i;

	// Validating
	function validateName(name,regex) {
		if (name.val()=='*'||regex.test(name.val())) {name.addClass('validation-error',animateSpeed); return false;}
		else {name.removeClass('validation-error',animateSpeed); return true;}
	}
	
	function validatePawPrint(variable,regex) {
		if (((variable.val()).length)<=4||((variable.val()).length)>6||regex.test(variable.val())) {variable.addClass('validation-error',animateSpeed); return false;}
		else {variable.removeClass('validation-error',animateSpeed); return true;}
	}

	function validateEmail(email,regex) {
		if (!regex.test(email.val())) {email.addClass('validation-error',animateSpeed); return false;}
		else {email.removeClass('validation-error',animateSpeed); return true;}
	}
	
	function validatePassword(pass) {
		if(pass.val()==""||(pass.val().length)<5||(pass.val().length)>30) {pass.addClass('validation-error',animateSpeed); return false;}
		else {pass.removeClass('validation-error',animateSpeed); return true;}
	}
	
	function validateMajor(name) {
		if(name.val()=='*') {name.addClass('validation-error',animateSpeed); return false;}
		else {name.removeClass('validation-error',animateSpeed); return true;}
	}

//Users will update their profile with this
	$('#mainprofile').click(function() {
	
		var result=true;
		
		var userID = $('input[name=username]');
		var firstname = $('input[name=firstname]');
		var lastname = $('input[name=lastname]');
		var email = $('input[name=email]');
		var currentmajor = $('input[name=currentmajor]');
		var select_form = document.getElementById("yearschool");
		
		var yearschool = (select_form.options[select_form.selectedIndex]).value;
			
		//validation
		if(!validateName(firstname,stringReg)) result=false;
		if(!validateName(lastname,stringReg)) result=false;
		if(!validateEmail(email,emailReg)) result=false;
		
		if(result==false) return false;
						
		var data = 'userid=' + userID.val() + '&firstname=' + firstname.val() + '&lastname=' + lastname.val() + '&email=' + email.val() + '&currentmajor=' + currentmajor.val() + '&yearschool=' + yearschool;
						
		// Loading icon
		$('.loading').show();
		
		// Start jQuery
		$.ajax({
		
			url: "config/functions.php?f=updateprofile",	
			
			// POST method is used
			type: "POST",

			// Pass the data			
			data: data,		
			
			//Do not cache the page
			cache: false,
			
			// Success
			success: function (html) {				
			
				if (html==1) {	

					// Loading icon
					$('.loading').fadeOut('slow');	
						
					//show the success message
					$('.success-message').slideDown('slow');
											
					// Disable send button
					$('#send').attr('disabled',true);
					
				}
				
				else {
					$('.loading').fadeOut('slow')
					//alert('Sorry, unexpected error. Please try again later.');
					alert(html);				
				}
			}		
		});
	
		return false;
	
	});
	
//This is the login form
	$('#loginform').click(function() {
	
		var result=true;
		
		var username = $('input[name=username]');
		var password = $('input[name=passfield]');
							
		//validation
		if(!validateName(username,stringReg)) result=false;
		if(!validatePassword(password)) result=false;
		
		if(result==false) return false;
				
		var data = 'username=' + username.val() + '&pass=' + password.serialize();
						
		// Loading icon
		$('.loading').show();
		
		// Start jQuery
		$.ajax({
		
			url: "config/phpbbauthapi.php?r=tiger",	
			
			// POST method is used
			type: "POST",

			// Pass the data			
			data: data,		
			
			//Do not cache the page
			cache: false,
			
			// Success
			success: function (html) {				
			
				if (html==1) {	

					// Loading icon
					$('.loading').fadeOut('slow');	
						
					//show the success message
					$('.success-message').slideDown('slow');
											
					// Disable send button
					$('#send').attr('disabled',true);
					
					window.location = '/';
					
				}
				
				else {
					$('.loading').fadeOut('slow')
					//alert('Sorry, unexpected error. Please try again later.');
					alert(html);				
				}
			}		
		});
	
		return false;
	
	});
	
	//Specific to Creating a Member		
	$('#createmem').click(function() {
		
		var result=true;
		
		var first = $('input[name=first]');
		var last = $('input[name=last]');
		var pawprint = $('input[name=pawprint]');
		var email = $('input[name=email]');
		var major = $('input[name=major]');
		var password = $('input[name=pass]');
		
		var select_form = document.getElementById("yearschool");
		
		var yearschool = (select_form.options[select_form.selectedIndex]).value;
				
		// Validate
		if(!validateName(first,stringReg)) result=false;
		if(!validateName(last,stringReg)) result=false;
		if(!validatePawPrint(pawprint,stringReg)) result=false;
		if(!validatePassword(password)) result=false;
		if(!validateEmail(email,emailReg)) result=false;
		if(!validateMajor(major)) result=false;
		
		if(result==false) return false;
				
		// Data
		var data = 'first=' + first.val() + '&last=' + last.val() + '&pawprint=' + pawprint.val() + '&email=' + email.val() + '&major=' + major.val() + '&yearschool=' + yearschool + '&pass=' + password.serialize();
		// Disable fields
		$('.text').attr('disabled','true');
		
		// Loading icon
		$('.loading').show();
		
		// Start jQuery
		$.ajax({
		
			url: "config/phpbbapi.php?r=tiger",	
			
			// POST method is used
			type: "POST",

			// Pass the data			
			data: data,		
			
			//Do not cache the page
			cache: false,
			
			// Success
			success: function (html) {				
			
				if (html==1) {	

					// Loading icon
					$('.loading').fadeOut('slow');	
						
					//show the success message
					$('.success-message').slideDown('slow');
											
					// Disable send button
					$('#send').attr('disabled',true);
					
				}
				
				else if (html==0){
					// Loading icon
					$('.loading').fadeOut('slow');	
						
					//show the success message
					$('.failure-message').slideDown('slow');
					
				} else {
					$('.loading').fadeOut('slow')
					//alert('Sorry, unexpected error. Please try again later.');
					alert(html);				
				}
			}		
		});
	
		return false;
		
	});
        
$('#createnonmem').click(function() {
		
		var result=true;
		
		var first = $('input[name=first]');
		var last = $('input[name=last]');
		var username = $('input[name=username]');
		var email = $('input[name=email]');
		var password = $('input[name=pass]');
				
		// Validate
		if(!validateName(first,stringReg)) result=false;
		if(!validateName(last,stringReg)) result=false;
		if(!validateName(username,stringReg)) result=false;
		if(!validatePassword(password)) result=false;
		if(!validateEmail(email,emailReg)) result=false;
		
		if(result==false) return false;
				
		// Data
		var data = 'first=' + first.val() + '&last=' + last.val() + '&username=' + username.val() + '&email=' + email.val() + '&pass=' + password.serialize();
		// Disable fields
		$('.text').attr('disabled','true');
		
		// Loading icon
		$('.loading').show();
		
		// Start jQuery
		$.ajax({
		
			url: "config/phpbbapi.php?r=tiger",	
			
			// POST method is used
			type: "POST",

			// Pass the data			
			data: data,		
			
			//Do not cache the page
			cache: false,
			
			// Success
			success: function (html) {				
			
				if (html==1) {	

					// Loading icon
					$('.loading').fadeOut('slow');	
						
					//show the success message
					$('.success-message').slideDown('slow');
											
					// Disable send button
					$('#send').attr('disabled',true);
					
				}
				
				else if (html==0){
					// Loading icon
					$('.loading').fadeOut('slow');	
						
					//show the success message
					$('.failure-message').slideDown('slow');
					
				} else {
					$('.loading').fadeOut('slow')
					//alert('Sorry, unexpected error. Please try again later.');
					alert(html);				
				}
			}		
		});
	
		return false;
		
	});
	
	$('#rsvp').click(function() {
		
		var result=true;
		
		var eventid = $('input[name=eventid]');
		var name = $('input[name=rsvpname]');
		var pawprint = $('input[name=rsvppawprint]');
		var email = $('input[name=rsvpemail]');
				
		// Validate
		if(!validatePawPrint(pawprint,stringReg)) result=false;
		if(!validateEmail(email,emailReg)) result=false;
		
		if(result==false) return false;
				
		// Data
		var data = 'eventid=' + eventid.val() + '&name=' + name.val() + '&pawprint=' + pawprint.val() + '&email=' + email.val();
		// Disable fields
		$('.text').attr('disabled','true');
		
		// Loading icon
		$('.loading').show();
	
		
		// Start jQuery
		$.ajax({
		
			url: "config/functions.php?f=rsvp",	
			
			// POST method is used
			type: "POST",

			// Pass the data			
			data: data,		
			
			//Do not cache the page
			cache: false,
			
			// Success
			success: function (html) {				
			
				if (html==1) {	

					// Loading icon
					$('.loading').fadeOut('slow');	
						
					//show the success message
					$('.success-message').slideDown('slow');
											
					// Disable send button
					$('#send').attr('disabled',true);
					
				}
				
				else {
					$('.loading').fadeOut('slow')
					//alert('Sorry, unexpected error. Please try again later.');
					alert(html);				
				}
			}		
		});
	
		return false;
		
	});
	
	function submit_rsvp() {
		var result=true;
		
		var eventid = $('input[name=eventid]');
		var pawprint = $('input[name=username]');
								
		// Data
		var data = 'eventid=' + eventid.val() + '&pawprint=' + pawprint.val();
		// Disable fields
		$('.text').attr('disabled','true');
		
		// Loading icon
		$('.loading').show();
	
		
		// Start jQuery
		$.ajax({
		
			url: "config/functions.php?f=userrsvp",	
			
			// POST method is used
			type: "POST",

			// Pass the data			
			data: data,		
			
			//Do not cache the page
			cache: false,
			
			// Success
			success: function (html) {				
			
				if (html==1) {	

					// Loading icon
					$('.loading').fadeOut('slow');	
						
					//show the success message
					$('.success-message').slideDown('slow');
											
					// Disable send button
					$('#send').attr('disabled',true);
					
					//Show the proper button
					var rsvp = '.rsvp' + eventid;
					var rsvplock = '.rsvplock' + eventid; 
					
					$(rsvp).hide();
					$(rsvplock).show();
										
				}
				
				else {
					$('.loading').fadeOut('slow')
					//alert('Sorry, unexpected error. Please try again later.');
					alert(html);				
				}
			}		
		});
	
		return false;
		
	};
	
	$('#email_unsubscribe').click(function() {
	
		var result=true;
		
		var email = $('input[name=email]');
							
		//validation
		if(!validateEmail(email,stringReg)) result=false;
		
		if(result==false) return false;
				
		var data = 'email=' + email.val();
						
		// Loading icon
		$('.loading').show();
		
		// Start jQuery
		$.ajax({
		
			url: "config/functions.php?f=unsubscribe",	
			
			// POST method is used
			type: "POST",

			// Pass the data			
			data: data,		
			
			//Do not cache the page
			cache: false,
			
			// Success
			success: function (html) {				
			
				if (html==1) {	

					// Loading icon
					$('.loading').fadeOut('slow');	
						
					//show the success message
					$('.success-message').slideDown('slow');
											
					// Disable send button
					$('#send').attr('disabled',true);
					
					window.location = '/';
					
				}
				
				else {
					$('.loading').fadeOut('slow')
					//alert('Sorry, unexpected error. Please try again later.');
					alert(html);				
				}
			}		
		});
	
		return false;
	
	});
	
	//Update User Profile
	$('input[name=firstname]').blur(function(){validateName($(this),stringReg);});
	$('input[name=lastname]').blur(function(){validateName($(this),stringReg);});
	$('input[name=email]').blur(function(){validateEmail($(this),emailReg); });
		
	//Login Form
	$('input[name=username]').blur(function(){validateName($(this),stringReg);});
	$('input[name=password]').blur(function(){validatePassword($(this));});
		
	//Register Form
	$('input[name=first]').blur(function(){validateName($(this),stringReg);});
	$('input[name=last]').blur(function(){validateName($(this),stringReg);});
	$('input[name=pawprint]').blur(function(){validatePawPrint($(this),stringReg);});
	$('input[name=pass]').blur(function(){validatePassword($(this));});
	$('input[name=email]').blur(function(){validateEmail($(this),emailReg);});
	$('input[name=major]').blur(function(){validateMajor($(this));});
	
	//RSVP Form
	$('input[name=rsvppawprint]').blur(function(){validatePawPrint($(this),stringReg);});
	$('input[name=rsvpemail]').blur(function(){validateEmail($(this),emailReg);}); 
})();

/*----------------------------------------------------*/
/*	Isotope Portfolio Filter
/*----------------------------------------------------*/

	$(function() {
		var $container = $('#portfolio-wrapper');
				$select = $('#filters select');
				
		// initialize Isotope
		$container.isotope({
		  // options...
		  resizable: false, // disable normal resizing
		  // set columnWidth to a percentage of container width
		  masonry: { columnWidth: $container.width() / 12 }
		});

		// update columnWidth on window resize
		$(window).smartresize(function(){
		  $container.isotope({
			// update columnWidth to a percentage of container width
			masonry: { columnWidth: $container.width() / 12 }
		  });
		});
		
		
	  $container.isotope({
		itemSelector : '.portfolio-item'
	  });
	  
	$select.change(function() {
			var filters = $(this).val();
	
			$container.isotope({
				filter: filters
			});
		});
	  
	  var $optionSets = $('#filters .option-set'),
		  $optionLinks = $optionSets.find('a');

	  $optionLinks.click(function(){
		var $this = $(this);
		// don't proceed if already selected
		if ( $this.hasClass('selected') ) {
		  return false;
		}
		var $optionSet = $this.parents('.option-set');
		$optionSet.find('.selected').removeClass('selected');
		$this.addClass('selected');
  
		// make option object dynamically, i.e. { filter: '.my-filter-class' }
		var options = {},
			key = $optionSet.attr('data-option-key'),
			value = $this.attr('data-option-value');
		// parse 'false' as false boolean
		value = value === 'false' ? false : value;
		options[ key ] = value;
		if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
		  // changes in layout modes need extra logic
		  changeLayoutMode( $this, options )
		} else {
		  // otherwise, apply new options
		  $container.isotope( options );
		}
		
		return false;
	  });
});
	
/*----------------------------------------------------*/
/*	Fancybox
/*----------------------------------------------------*/
(function() {

	$('[rel=image]').fancybox({
		type        : 'image',
		openEffect  : 'fade',
		closeEffect	: 'fade',
		nextEffect  : 'fade',
		prevEffect  : 'fade',
		helpers     : {
			title   : {
				type : 'inside'
			}
		}
	});
	
	$('[rel=image-gallery]').fancybox({
		nextEffect  : 'fade',
		prevEffect  : 'fade',
		helpers     : {
			title   : {
				type : 'inside'
			},
			buttons  : {},
			media    : {}
		}
	});
	
	
})();
	
/* ------------------ End Document ------------------ */
});

function submit_rsvp(eventid, pawprint) {
	var result=true;
								
	// Data
	var data = 'eventid=' + eventid + '&pawprint=' + pawprint;
	// Disable fields
	$('.text').attr('disabled','true');
	
	// Loading icon
	$('.loading').show();
	
	// Start jQuery
	$.ajax({
	
		url: "config/functions.php?f=userrsvp",	
		
		// POST method is used
		type: "POST",

		// Pass the data			
		data: data,		
		
		//Do not cache the page
		cache: false,
		
		// Success
		success: function (html) {				
		
			if (html==1) {
				// Loading icon
				$('.loading').fadeOut('slow');	
					
				//show the success message
				$('.success-message').slideDown('slow');
										
				// Disable send button
				$('.rsvp' + eventid).attr('disabled',true);
				
			}
			
			else {
				$('.loading').fadeOut('slow')
				//alert('Sorry, unexpected error. Please try again later.');
				//alert(html);				
			}
		}		
	});
	
	$('.rsvp' + eventid).hide();
	$('.rsvplock' + eventid).show();

	return false;
	
};

function unsubmit_rsvp(eventid, pawprint) {
	var result=true;
								
	// Data
	var data = 'eventid=' + eventid + '&pawprint=' + pawprint;
	// Disable fields
	$('.text').attr('disabled','true');
	
	// Loading icon
	$('.loading').show();
	
	// Start jQuery
	$.ajax({
	
		url: "config/functions.php?f=userunrsvp",	
		
		// POST method is used
		type: "POST",

		// Pass the data			
		data: data,		
		
		//Do not cache the page
		cache: false,
		
		// Success
		success: function (html) {				
		
			if (html==1) {
				// Loading icon
				$('.loading').fadeOut('slow');	
					
				//show the success message
				$('.success-message').slideDown('slow');
										
				// Disable send button
				$('.rsvp' + eventid).attr('disabled',true);
				
			}
			
			else {
				$('.loading').fadeOut('slow')
				//alert('Sorry, unexpected error. Please try again later.');
				//alert(html);				
			}
		}		
	});
	
	$('.rsvplock' + eventid).hide();
	$('.rsvp' + eventid).show();

	return false;
	
};
