var daterangeObj;

$(function() {
	// daterangeObj = $('.daterange-basic').daterangepicker({
	// 	applyClass: 'bg-slate-600',
	// 	cancelClass: 'btn-default',
	// 	locale: {
	// 		format: 'YYYY/MM/DD'
	// 	}
	// });

	if( $('#barChart').get(0) ) {
		var plot = $.plot('#barChart', [flotBarsData], {
			colors: ['#8CC9E8'],
			series: {
				bars: {
					show: true,
					barWidth: 0.8,
					align: 'center'
				}
			},
			xaxis: {
				mode: 'categories',
				tickLength: 1
			},
			yaxis: {
				// autoscaleMargin: 1
			},
			grid: {
				hoverable: true,
				clickable: true,
				borderColor: 'rgba(0,0,0,0.1)',
				borderWidth: 1,
				labelMargin: 15,
				backgroundColor: 'transparent'
			},
			tooltip: true,
			tooltipOpts: {
				content: '%y',
				shifts: {
					x: -10,
					y: 20
				},
				defaultTheme: false
			}
		});
	}

	// $('input[name="daterange"]').on('apply.daterangepicker', function(e){
	// 	onSearch();
	// });
});

function onSearch() {
	$('#searchForm').submit();
}