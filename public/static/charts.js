$(document).ready(function(){    

    if($('[data-trigger=chart]').length > 0){

        charts($('[data-trigger=chart').data('url'));
       			
        $('input[name=customreport]').on('apply.daterangepicker', function(ev, picker) {
            
            if( window.clickchart !== undefined) window.clickchart.destroy();

            charts($('[data-trigger=chart').data('url')+'?from='+picker.startDate.format('MM/DD/YYYY')+'&to='+picker.endDate.format('MM/DD/YYYY'));
        
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });
    }   
    
    if($('[data-trigger=dynamic-map]').length > 0){

        maps($('[data-trigger=dynamic-map]'), $('[data-trigger=dynamic-map]').data('url'));		

        $('input[name=customreport]').on('apply.daterangepicker', function(ev, picker) {

            window.map.reset();
            
            maps($('[data-trigger=dynamic-map]'), $('[data-trigger=dynamic-map]').data('url')+'?from='+picker.startDate.format('MM/DD/YYYY')+'&to='+picker.endDate.format('MM/DD/YYYY'));
        
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });        
	}

    if($('[data-trigger=dynamic-pie]').length > 0){
        piechart($('[data-trigger=dynamic-pie]'), $('[data-trigger=dynamic-pie]').data('url'));

        $('input[name=customreport]').on('apply.daterangepicker', function(ev, picker) {

            if( window.datachart !== undefined) window.datachart.destroy();
            
            piechart($('[data-trigger=dynamic-pie]'), $('[data-trigger=dynamic-pie]').data('url')+'?from='+picker.startDate.format('MM/DD/YYYY')+'&to='+picker.endDate.format('MM/DD/YYYY'));
        
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });    
	}
});
function cities(code){
    let el = $('[data-toggle=cities]');

    $.get(el.data('url')+'?country='+code, function(response){
        el.html(response);
    })
    .fail(function() {
        $.notify({
            message: lang.nodata
        },{
            type: 'danger',
            placement: {
                from: "bottom",
                align: "right"
            },
        });
    });	
}
function piechart(el, url){

    $.get(url, function(data){
        let labels = [];			
        let counts = [];

        for(var x in data['chart']){
            labels.push(x);
            counts.push(data['chart'][x]);
        }			
        window.datachart = new Chart(el, {
            type: "pie",
            data: {
                labels: labels,
                datasets: [{
                    data: counts,
                    borderWidth: 5,
                    backgroundColor: ['#0F87FF','#0080C0','#80FFFF','#FF0000','#C0C0C0','#000000','#F1DF03','#d40000','#4D4D4D','#464646','#7A7A7A','#a4c639','#0080FF','#FF0080','#EEEEEE']
                }]
            },
            options: {
                responsive: !window.MSInputMethodContext,
                maintainAspectRatio: false,
                plugins:{
                    legend: {
                        position: 'bottom',
                        display: true
                    }
                },
                cutoutPercentage: 75
            }
        });
        $('#top-'+el.data('type')).html('');
        for (const [key, value] of Object.entries(data['top'])) {        

            if(el.data('type') == 'languages'){
                $('#top-'+el.data('type')).append('<li class="d-block mb-2 w-100 border-bottom pb-2 fw-bold"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColorÞ" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user mx-1"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> '+key+' <small class="badge bg-primary text-white float-right">'+value+'</small></li>');
            } else {
                let thumb = appurl+'static/images/'+el.data('type')+'/'+key.split(' ')[0].toLowerCase()+'.svg';
                if(value.split(' ')[0] == 'Unknown') thumb = appurl+'static/images/unknown.svg';
                $('#top-'+el.data('type')).append('<li class="d-block mb-2 w-100 border-bottom pb-2 fw-bold"><img src="'+thumb+'" width="16" class="mr-1"> '+key+' <small class="badge bg-primary text-white float-right">'+value+'</small></li>');
            }
        }
    })
    .fail(function() {
        $.notify({
            message: lang.nodata
        },{
            type: 'danger',
            placement: {
                from: "bottom",
                align: "right"
            },
        });
    });
}
function charts(url){
    let el = $('canvas').get()[0].getContext('2d');
    $.get(url, function(data){
        let datax = [];			
        let datay = [];			
        let gradient = el.createLinearGradient(0, 0, 0, 225);
        gradient.addColorStop(0,'rgba(0, 138, 255, 1)');
        gradient.addColorStop(1,'rgba(255,255,255,0)');

        for(var x in data['data']){
            datax.push(x);
            datay.push(data['data'][x]);
        }

        window.clickchart = new Chart(el, {
            type: 'line',
            data: {
                labels: datax,
                datasets: [{
                    label: data['label'],
                    fill: true,
                    tension: 0.3,
                    backgroundColor: gradient,
                    borderColor: '#008aff',
                    data: datay
                }]
            },
            options: {
                maintainAspectRatio: false,
                legend: {display: false},
                tooltips: {intersect: false},hover: {intersect: true},
                plugins: {filler: {propagate: false}, legend: {display: false}},
                scales: {
                    x: {grid: {display: false}, min: 0},
                    y: {display: true,grid: {display: false}, min: 0}
                }
            }
        });		
    }).fail(function() {
        $.notify({
            message: lang.nodata
        },{
            type: 'danger',
            placement: {
                from: 'bottom',
                align: 'right'
            },
        });
    });	
}
function maps(el, url){
    $.get(url, function(data){
        window.map = new jsVectorMap({
            map: "world",
            selector: "#"+el.attr('id'),
            zoomButtons: true,
            visualizeData: {
                scale: ['008aff', '#D3EBFF'],
                values: data['list']
            },					
            regionsSelectable: true,
            regionsSelectableOne: true,
            zoomOnScroll: false,
            onRegionTooltipShow(tooltip, index) {
                tooltip.text(
                    tooltip.text() + ' ('+ (typeof data['list'][index] != 'undefined'  ? data['list'][index] : 0) + ')'
                )
            },
            onRegionSelected(code) {
                cities(code);
            }
        });
        $('#top-countries').html('');
        for (const [key, value] of Object.entries(data['top'])) {
            let thumb = appurl+'static/images/flags/'+key.toLowerCase()+'.svg';
            if(value.name == 'Unknown') thumb = appurl+'static/images/unknown.svg';
            $('#top-countries').append('<li class="d-block mb-2 w-100 border-bottom pb-2 fw-bold"><img src="'+thumb+'" width="16" class="mr-1">'+value.name+' <small class="badge bg-primary text-white float-right">'+value.count+'</small></li>');
        }
        window.addEventListener("resize", () => {
            window.map.updateSize();
        });
    })
    .fail(function() {
        $.notify({
            message: lang.nodata
        },{
            type: 'danger',
            placement: {
                from: "bottom",
                align: "right"
            },
        });
    });
}