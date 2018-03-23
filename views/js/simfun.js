$(document).ready(function(e) {
	if(localStorage.simfun_capital && localStorage.simfun_quote) {
		$('#step1 #value').val(localStorage.simfun_capital);
		$('#step1 #quota option').each(function(index, element) {
			if($(element).val() == localStorage.simfun_quotes) {
				$(element).attr('selected','selected');
			}else {
				$(element).removeAttr('selected');
			}
		});
		$('#step1').hide();
		$('#step2').hide();
		$('#step3').show().promise().done(function(){
			localStorage.removeItem('simfun_capital');
			localStorage.removeItem('simfun_quotes');
			localStorage.removeItem('simfun_quote');
		});
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
		localStorage.setItem("simfun_capital", choosen.capital);
		localStorage.setItem("simfun_quotes", choosen.quotes);
		localStorage.setItem("simfun_quote", choosen.quote);
		window.open(Link, "_blank");
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
	