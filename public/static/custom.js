$(document).ready(function(){

	$('.sidebar-dropdown').on('shown.bs.collapse', function(){
		window.simpleBar.recalculate();
	});
	// Active Menu
	let path = location.pathname.substring(1);
	if (path) {
		$('#sidebar .sidebar-item').removeClass("active");
		$('#sidebar .sidebar-link[href$="' + path + '"]').removeClass('collapsed'); 
		$('#sidebar li ul').removeClass('show'); 
		$('#sidebar .sidebar-link[href$="' + path + '"]').parents("li").addClass('active'); 
		$('#sidebar .sidebar-link[href$="' + path + '"]').parents("li").find('ul').addClass('show'); 
		$('.list-group-item[href$="' + path + '"], .nav-link[href$="' + path + '"]').addClass('active');
	} 

	$('[data-toggle=addable]').each(function(){
        window['addable'+$(this).data('label')] = $(this).html();
    });
    $("[data-trigger=addmore]").click(function(e){
        e.preventDefault();
        $('#'+$(this).data('for')+'').append('<div class="row mt-2">'+window['addable'+$(this).data('for')]+'</div><p><a href="#" class="btn btn-danger btn-sm mt-1" data-trigger="deletemore">'+lang.del+'</a></p>');
		$('[data-toggle="select"]').select2();
		initautocomplete();
    }); 
    $(document).on('click','[data-trigger=deletemore]',function(e){
        e.preventDefault();
        let t = $(this);
        $(this).parent('p').prev('.row').slideUp('slow',function(){
            $(this).remove();
            t.parent('p').remove();
        });
        return false;
    });

	$('[data-trigger=darkmode]').click(function(e){
		e.preventDefault();
			const d = new Date();
			d.setTime(d.getTime() + (30*24*60*60*1000));
			let expires = "expires="+ d.toUTCString();
			document.cookie = 'darkmode' + "=1;" + expires + ";path=/";
			$('body').addClass('dark');
			$(this).addClass('d-none');
			$('[data-trigger=lightmode]').removeClass('d-none');
	});

	$('[data-trigger=lightmode]').click(function(e){
		e.preventDefault();
			document.cookie = "darkmode=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
			$('body').removeClass('dark');
			$(this).addClass('d-none');
			$('[data-trigger=darkmode]').removeClass('d-none');
	});

	initautocomplete();

	// SelectJS
	let $select = $('[data-toggle="select"]');
	if ($select.length) {
		$select.each(function() {
			$(this).select2();
		});
	}
	// Tags Input
	let $tags = $('[data-toggle="tags"]');
	if ($tags.length) {
		$tags.each(function() {
			$(this).tagsinput({
				tagClass: 'badge badge-primary'
			});
		});
	}	

	let $dtpicker = $('[data-toggle=datetimepicker]');
	if ($dtpicker.length) {
		$dtpicker.each(function() {
			$(this).datepicker({
				autoPick: true,
				format: "yyyy-mm-dd"
			}); 
		});
	}	
	let $dpicker = $('[data-toggle=datepicker]');
	if ($dpicker.length) {
		$dpicker.each(function() {
			$(this).datepicker({
				autoPick: false,
				format: "yyyy-mm-dd"
			}); 
		});
	}

	// Custom Checkbox
	$('[data-toggle=togglefield]').change(function(){
		let $this = $(this);
		let fields = $(this).data('toggle-for');
		if(!fields) return false;
		fields.split(',').forEach(function(field){
			if($this.is(':checked') == true) {
				$('#'+field+'').parent('.form-group').removeClass('d-none');
				$('#'+field+'').removeClass('d-none');
			}else{
				$('#'+field+'').parent('.form-group').addClass('d-none');
				$('#'+field+'').addClass('d-none');
			}
		});
	});
	$('input[data-binary=true]').each(function(){
		$(this).before('<input type="hidden" value="0" name="'+ $(this).attr('name')+'">');
	});
	$(document).on('change', '[data-toggle=select]', function(){
		let callback = $(this).data('trigger');
		if(callback !==undefined){
			window[callback]($(this));
		} 
	});
	$('[data-trigger=removeimage]').click(function(e){
		e.preventDefault();
		$(this).parents('form').prepend("<input type='hidden' name='"+$(this).attr("id")+"' value='1'>");
		$(this).text("Image will be removed upon submission");
	  });  
	// Modal Trigger
	$(document).on('click', '[data-trigger=modalopen]', function(e){
		e.preventDefault();
		let target = $(this).data('bs-target');
		$(target).find('a[data-trigger=confirm]').attr('href', $(this).attr('href'));
	});
	$('[data-toggle=updateFormContent]').click(function(e){
		e.preventDefault();
		let target = $(this).data('bs-target');
		let content = $(this).data('content');
		$(target).find('form').attr('action', $(this).attr('href'));
		for(input in content){
			$(target).find('#'+input).val(content[input]);
		}
	});		
	$('[data-trigger=checkall]').on('click', function() {		
		if($(this).prop('checked')){
		  $('[data-dynamic]').prop('checked', true);
		}else{
		  $('[data-dynamic]').prop('checked', false);
		}    
	}); 
	$('[data-trigger=options] a[data-trigger=submitchecked]').click(function(e){
		e.preventDefault();
		$('[data-trigger=options]').attr('action', $(this).attr('href'));
		let ids = [];
		$('[data-dynamic]').each(function(){
			if($(this).prop('checked')) ids.push($(this).val());
		});

		$('input[name=selected]').val(JSON.stringify(ids));
		$('[data-trigger=options]').submit();
	});
	$('[data-trigger=getchecked]').click(function(e){
		e.preventDefault();
		let ids = [];
		$('[data-dynamic]').each(function(){
			if($(this).prop('checked')) ids.push($(this).val());
		});

		$($(this).data('for')).val(JSON.stringify(ids));
	});
	if($(".copy").length > 0){
		new ClipboardJS('.copy');  
		$(document).on("click", ".copy", function(e){
			e.preventDefault();  
			$(this).prev("small").addClass("float-away");
			setTimeout(function() {
			  $("small").removeClass('float-away');
			}, 400);    
		}); 		
	}
	if($('[data-trigger=dynamic-chart]').length > 0){
		$('[data-trigger=dynamic-chart]').each(function(){
			var el = $(this);
			$.get($(this).data('url'), function(data){
				let datax = [];			
				let datay = [];			
				let gradient =el.get(0).getContext("2d").createLinearGradient(0, 0, 0, 225);
				gradient.addColorStop(0,el.data('color-start'));
				gradient.addColorStop(1,el.data('color-stop'));
	
				for(var x in data['data']){
					datax.push(x);
					datay.push(data['data'][x]);
				}
	
				new Chart(el, {
					type: "line",
					data: {
						labels: datax,
						datasets: [{
							label: data['label'],
							fill: true,
							backgroundColor: gradient,
							borderColor: el.data('color-start'),
							data: datay
						}]
					},
					options: {
						maintainAspectRatio: false,
						legend: {
							display: false
						},
						tooltips: {
							intersect: false
						},
						hover: {
							intersect: true
						},
						plugins: {
							filler: {
								propagate: false
							}
						},
						scales: {
							xAxes: [{
								reverse: true,
								gridLines: {
									color: "rgba(0,0,0,0.0)"
								}
							}],
							yAxes: [{
								ticks: {
									stepSize: 1000
								},
								display: true,
								borderDash: [3, 3],
								gridLines: {
									color: "rgba(0,0,0,0.0)"
								}
							}]
						}
					}
				});		
			})
			.fail(function() {
				$.notify({
					message: 'Cannot retrieve charts. Server did not respond or an error ocurred.'
				},{
					type: 'danger',
					placement: {
						from: "bottom",
						align: "right"
					},
				});
			});		
		});			
	}
	if($('[data-trigger=dynamic-map]').length > 0){
		$('[data-trigger=dynamic-map]').each(function(){
			var el = $(this);
			$.get($(this).data('url'), function(data){
				var map = new jsVectorMap({
					map: "world",
					selector: "#"+el.attr('id'),
					zoomButtons: true,
					visualizeData: {
						scale: ['#eeeeee', window.theme.danger],
						values: data['list']
					},					
					zoomOnScroll: false,
					onRegionTooltipShow (tooltip, index) {
						tooltip.text(
						  tooltip.text() + ' ('+ (typeof data['list'][index] != 'undefined'  ? data['list'][index] : 0) + ' clicks)'
						)
					}
				});
				for (const [key, value] of Object.entries(data['top'])) {
					$('#top-countries').append('<li class="d-block mb-2 w-100 border-bottom pb-2 fw-bold">'+key+' <span class="badge bg-danger float-end">'+value+' clicks</span></li>');
				}
				window.addEventListener("resize", () => {
					map.updateSize();
				});
			})
			.fail(function() {
				$.notify({
					message: 'Cannot retrieve maps. Server did not respond or an error ocurred.'
				},{
					type: 'danger',
					placement: {
						from: "bottom",
						align: "right"
					},
				});
			});	
		});		
	}

	if($('[data-trigger=dynamic-pie]').length > 0){
		$('[data-trigger=dynamic-pie]').each(function(){
			var el = $(this);
			$.get($(this).data('url'), function(data){
				let labels = [];			
				let counts = [];
	
				for(var x in data){
					labels.push(x);
					counts.push(data[x]);
				}			
				new Chart(el, {
					type: "pie",
					data: {
						labels: labels,
						datasets: [{
							data: counts,
							backgroundColor: [window.theme.success, window.theme.warning],
							borderWidth: 5
						}]
					},
					options: {
						responsive: !window.MSInputMethodContext,
						maintainAspectRatio: false,
						legend: {
							display: false
						},
						cutoutPercentage: 75
					}
				});
			})
			.fail(function() {
				$.notify({
					message: 'Cannot retrieve charts. Server did not respond or an error ocurred.'
				},{
					type: 'danger',
					placement: {
						from: "bottom",
						align: "right"
					},
				});
			});
		});
	}	
	$('[data-trigger=preview]').click(function(e){
		e.preventDefault();
		let data = new FormData($(this).parents('form')[0]);
		$.ajax({
            type: "POST",
            url: $(this).data('url'),
            data: data,		
			contentType: false,
			processData: false,
            beforeSend: function() {
              $("#return-ajax").html('<div class="preloader"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>');
            },
            complete: function() {      
              $('.preloader').fadeOut("fast", function(){$(this).remove()});
            },          
            success: function (response) { 
                $('#return-ajax').html(response);
            }
        }); 
	});
	$('[data-trigger=color]').click(function(){
		let id = $(this).attr('href');
		let input = $('input[name=mode]');
		if(input.length > 0){
			input.val(id.replace('#', ''));
		}
	});	
	$('[data-trigger=generateqr]').submit(function(e){
		e.preventDefault();
		let data = new FormData($(this).parents('form')[0]);
		$.ajax({
            type: "POST",
            url: $(this).data('url'),
            data: data,
			contentType: false,
			processData: false,
            beforeSend: function() {
              $("#return-ajax").html('<div class="preloader"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>');
            },
            complete: function() {      
              $('.preloader').fadeOut("fast", function(){$(this).remove()});
            },          
            success: function (response) { 
                $('#return-ajax').html(response);
            }
        }); 
	});
	$('[data-trigger=translate]').click(function(e){
		e.preventDefault();
		let el = $(this);
		if($('#code').val().length < 1){
			return $.notify({
				message: 'Cannot detect language code. Please enter an ISO 639-1 code in the code input.'
			},{
				type: 'danger',
				placement: {
					from: "bottom",
					align: "right"
				},
			});			
		}
		$.ajax({
            type: "POST",
            url: $(this).data('url'),
            data: 'lang='+$('#code').val()+'&string='+$(this).data('string'),
            success: function (response) { 
               el.parent('div').find('textarea[data-new]').html(response);
            }
        }); 
	});
	var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
	tooltipTriggerList.map(function (tooltipTriggerEl) {
		return new bootstrap.Tooltip(tooltipTriggerEl)
	});

	$('[data-bs-toggle=collapse]').click(function() {
		let parent = $(this).data('bs-parent')
		$(parent).find('.collapse.show').collapse('hide');
		$(this).parents('.btn-group').find('.active').removeClass('active');
		$(this).parents('.list-group').find('.active').removeClass('active');
		$(this).parents('.nav-pills').find('.active').removeClass('active');
		$(this).addClass('active');
	});
	$('[data-trigger=toggleSM]').click(function(e){
		let value = $(this).data('value');
		if(value == 'multiple'){
			$('input[name=custom]').parents('.form-group').parent('div').hide();
			$('button[data-bs-target=\"#metatags\"]').hide();
			$('#metatags').removeClass('show');
			$('button[data-bs-target=\"#geo\"]').hide();
			$('#geo').removeClass('show');
			$('button[data-bs-target=\"#device\"]').hide();
			$('#device').removeClass('show');
			$('input[name=multiple]').val('1');
			$("#multiple").addClass('show');
		} else {
			$('button[data-bs-target=\"#metatags\"]').show();			
			$('button[data-bs-target=\"#geo\"]').show();
			$('button[data-bs-target=\"#device\"]').show();			
			$('input[name=custom]').parents('.form-group').parent('div').show();
			$('input[name=multiple]').val('0');
			$("#single").addClass('show');
		}
	});
	$('.list-group-dynamic a').click(function(){
		$('.list-group-dynamic a').removeClass('active');
		$(this).addClass('active');
		$('input[name=type]').val($(this).attr('href').replace('#', ''));
	})
	$(document).on('click', '[data-trigger=shortinfo]', function(e){
		e.preventDefault();
		triggerShortModal($(this).data('shorturl'));
	});
	$(document).on('click',"[data-trigger=clearsearch]",function(e){
		e.preventDefault();
		$("#return-ajax").slideUp('medium',function(){
		  $(this).html('');
		  $("#search").find("input[type=text]").val('');
		  $("#link-holder").slideDown('medium');
		  $('#search button[type=submit]').removeClass('d-none'); 
		  $('#search button[type=button]').addClass('d-none');
		});
	}); 
	$(document).on('click','[data-trigger=selectall]',function(e) {
		e.preventDefault();   
		if($(this).hasClass("fa-check-square")){
		  	$(this).removeClass('fa-check-square').addClass('fa-minus-square');
		  	$('[data-dynamic]').prop('checked', true);
		}else{
			$(this).addClass('fa-check-square').removeClass('fa-minus-square');
		  	$('[data-dynamic]').prop('checked', false);
		}
	}); 
});
window.redirect = function(e){
	window.location = "?"+e.data('name')+"="+e.val();
}
window.paymentkeys = function(e){
	$('.toggles').addClass('d-none');
	$('#'+e.val()+'holder').removeClass('d-none');
}
function initautocomplete(){
	var parameters = [
		{ value: 'utm_source', data: 'utm_source' },
		{ value: 'utm_medium', data: 'utm_medium' },
		{ value: 'utm_campaign', data: 'utm_campaign' },
		{ value: 'utm_term', data: 'utm_term' },
		{ value: 'utm_content', data: 'utm_content' },
		{ value: 'tag', data: 'tag' },
	  ];
	  if($().devbridgeAutocomplete){
		$("[data-trigger=autofillparam]").devbridgeAutocomplete({
		  lookup: parameters
		});
	  }
}
function getStates(el){
	$.ajax({
		type: "GET",
		url: $('[data-label=geo]').data('states')+'?country='+el.val()+'&output=true',
		success: function (response) { 
			var html = '<option value="0">All States</option>';
			for(var key in response){
				html += '<option value="'+response[key].name.toLowerCase()+'">'+response[key].name+'</option>';
			}
		  	el.parents('.col').parent('.row').find('select[name="state[]"]').html(html);
			$('[data-toggle="select"]').select2();
		}
	});   
}
function validateForm(e){
  
	$(".form-group").removeClass("has-danger");
	$(".form-control-feedback").remove();
	let error = 0;
  
	e.find("[data-required]").each(function(){
  
	  let type = $(this).attr("type");
  
	  if(type == "email"){
		let regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		if(!regex.test($(this).val())) error = 1;    
	  } else {    
		if($(this).val() == "") error = 1;
	  }
  
	  if(error == 1) {
		$(this).parents(".form-group").addClass("has-danger");
		$(this).after("<div class='form-control-feedback'>This field is required</div>");
	  }
  
	});
	if(error == 1) {
	  return false;
	}  
  
	return true;
}