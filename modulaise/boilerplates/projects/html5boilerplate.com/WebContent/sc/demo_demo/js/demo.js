    $('#expand').click(function() {
      $('#container').css('height','auto').css('overflow','');
			return false;
    });
		
		$('#shorten').click(function() {
      $('#container').css('height','300px').css('overflow','hidden');
			return false;
    });
		
		$('#atag').click(function() {
			return false;
    });
		
		$('.show').click(function(){
		  $('.show').addClass('current')
		  $('.hide').removeClass('current');
			showStyle();
			return false;
		});
		$('.hide').click(function(){
		  $('.hide').addClass('current')
		  $('.show').removeClass('current');
		  // freeze the size of each tests so the page doesnt jump.
		  $('dd').each(function(){
        $(this).height( $(this).height() );
      });
      
			hideStyle();
			return false;
		});
		
		var linkTags = $('link');
		function hideStyle() {
		  // tee hee
			$('link[href*=all.css]').attr('media','braille');
		}
		function showStyle() {
			$('link[href*=all.css]').attr('media','all');
		}
		
		$('.preventDefault').click(function() {
			return false;
		});
		
		$(function(){
		  $('.show').addClass('current');
		})