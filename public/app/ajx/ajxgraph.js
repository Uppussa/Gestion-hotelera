$(".btnReloadGraph").click(function(){
	loadGraphLogs();
});

function loadGraphLogs() {
	var tipo_graph 	= $(".slt-tipo-graph-logs").val();
	var per_graph 	= $(".slt-per-graph-logs").val();
	var ini_per 	= $(".dt-per-ini-graph-logs").val();
	var fin_per 	= $(".dt-per-fin-graph-logs").val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
	$.ajax({
		type: 		"POST",
        url:        base_url + "/loadGraphLogs",
		dataType: 	"JSON",
		data: {
			div: 'div-graph-logs',
			per_graph: 	per_graph,
			ini_per: 	ini_per,
			fin_per: 	fin_per,
			tipo_graph: tipo_graph,
		},
		beforeSend: function(objeto) {
			$('#btn-search').attr("disabled", true);
			$('#btn-search').html('<span class="spinner-border spin-x" role="status" aria-hidden="true"></span>');
		},
		success: function(data) {
			$('#btn-search').attr("disabled", false);
			$("#btn-search").html('<i class="fas fa-sync-alt"></i>');
			$(".div-cnt-graph-highcharts").html(data.graph);
		},
		error: function(datos) {
			$('#btn-search').attr("disabled", false);
			$("#btn-search").html('<i class="fas fa-sync-alt"></i>');
            notifyMsg("Error en los datos, intenta más tarde.", '#', 'danger', '');
		}
	});
}