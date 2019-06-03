$(document).ready(function(){

	var url = document.location.href;
	if(url.indexOf('#') != -1){
		sub = url.slice(url.indexOf('#'));
		if(sub == "#invoice_address"){
			$('#m_user_profile_tab_2').addClass('active');
			$('#m_user_profile_tab_1').removeClass('active');
			$('.m-tabs__link').eq(0).removeClass('active')
			$('.m-tabs__link').eq(1).addClass('active')
		}
		if(sub == "#my_detail"){
			$('#m_user_profile_tab_3').addClass('active');
			$('#m_user_profile_tab_1').removeClass('active');
			$('.m-tabs__link').eq(0).removeClass('active')
			$('.m-tabs__link').eq(2).addClass('active')
		}
	}

	$('.file-dropdown').click(function(){
	    var filename = $(this).html();
	    $(this).parent().prev().html(filename);
	    $('input[type="file"]', $(this).parent().parent().prev()).attr('fileName',filename);
	    $('input[type="file"]', $(this).parent().parent().prev()).removeClass('unchecked');
	    $('label', $(this).parent().parent().prev()).html(filename);
	    $('label', $(this).parent().parent().prev()).addClass('unchecked')
	});

	$("#vendor-code-form").submit(function(e) {
    	e.preventDefault(); // avoid to execute the actual submit of the form.
	    var form = $(this);
	    var url = form.attr('action');

	    $.ajax({
           	type: "POST",
	        url: url,
	        data: form.serialize(), // serializes the form's elements.
	        success: function(data){
            	alert("Promocode successfully entered");
            	document.location.reload(true);
	    	},
	    	error: function (jqXHR, exception) {
	    		alert('The given data was invalid.');
	    		form.trigger('reset');
	    	}
    	});
	});
});