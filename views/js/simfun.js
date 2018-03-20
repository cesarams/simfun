$(document).ready(function(e) {
	isJson = function isJson(item) {
    	item = typeof item !== "string"
			? JSON.stringify(item)
			: item;
	
		try {
			item = JSON.parse(item);
		} catch (e) {
			return false;
		}
	
		if (typeof item === "object" && item !== null) {
			return true;
		}
	
		return false;
	}
	hasChange = function () {
  		var hash = window.location.hash.substring(1);
		
		if(hash && isJson(hash)) {
			hash = JSON.parse(hash);
			$('#step1 #value').val(hash.capital);
			$('#step1 #quota option').each(function(index, element) {
				if($(element).val() == hash.quotes) {
					$(element).attr('selected','selected');
				}else {
					$(element).removeAttr('selected');
				}
			});
			$('#step1').hide();
			$('#step2').hide();
			$('#step3').show().promise().done(function(){
				window.location.hash = '';
			});
		}
	}
	window.onhashchange = function() {hasChange()};
	if(window.location.hash) {
		console.log('lado 2');
		hasChange();
	}
	
	
	$('#product-simulate').on('click',function(e){
		e.preventDefault();
		$.fancybox($('.simfun-modal').html());
	})
	$('body').on('change','#simfun-modal-cuotes',function(e){
		var calculate = JSON.parse($(this).val());
		if(calculate.quote) {
			$('#simfun-quota price').html(calculate.quote);
			$('.fancybox-skin #gotosimulator').attr('data-value',$('option:selected',$('.fancybox-skin #simfun-modal-cuotes')).attr('data-value'));
		}
	});
	$('body').on('click','#gotosimulator',function(e){
		e.preventDefault();
		var Link = $(this).attr('data-link'); 
		var choosen = JSON.parse($(this).attr('data-value'));
		window.open(Link+'#'+$(this).attr('data-value'), "new");
	})
	$('#fecha_vinculacion').datepicker({
		changeYear: true,
		changeMonth: true,
		yearRange: "c-60:c+0",
		dateFormat: "yy-mm-dd"
	});
	$('#calculate').on('click',function(e){
		e.preventDefault();
		$('#step2').hide();
		$("#message").hide().html('');
		$.ajax({
		  type: 'POST',
		  url: $(this).closest('form#formsimulate').attr('data-action'),
		  data: {
			  ajax: 'calculate',
			  value: $('#step1 #value').val(),
			  quota: $('#step1 #quota').val(),
		  },
		  success: function(data) {
			data = JSON.parse(data);
			if(data.haserror) {
				$("#message").html(data.message).show();
				$(window).scrollTop($("#message").offset().top -50)
			} else {
				$("#message").html('').hide();
				$('#capital').html(data.message.capital);
				$('#quotes').html(data.message.quotes);
				$('#quote').html(data.message.quote);
				$('#step2').show().promise().done(function() {
					$(this).resize();
				});
			}
		  }
		});
	});
	$('#request').on('click',function(e) {
		e.preventDefault();
		$('#step1').hide();
		$('#step3').show().promise().done(function() {
			$(this).resize();
		});;
	})
	$('#register').on('click',function(e) {
		e.preventDefault();
		var post = {};
		$('#step3 input, #step3 select').each(function(index, element) {
			if($(element).attr('type') == 'checkbox' || $(element).attr('type') == 'radio') {
				post[$(element).attr('name')] = $(element).prop("checked")
			} else {
				post[$(element).attr('name')] = $(element).val();
			}
		});
		post['value'] = $('#step1 #value').val();
		post['quota'] = $('#step1 #quota').val();

		$.ajax({
		  type: 'POST',
		  url: $(this).closest('form#formsimulate').attr('data-action'),
		  data: {
			  ajax: 'register',
			  post: post
		  },
		  success: function(data) {
			data = JSON.parse(data);
			if(data.haserror) {
				$("#message").html(data.message).show();
				$(window).scrollTop($("#message").offset().top -50)
			} else {
				$.fancybox(data.message);
				$('#step3 input, #step3 select').each(function(index, element) {
					$(element).val('');
				});
				$("#message").html('').hide();
				$('#step1').show();
				$('#step2').hide();
				$('#step3').hide();
				$('#step1 #value').val('');
				$('#step1 #quota').val('');
			}
		  }
		});
	});
});
	