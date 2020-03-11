"use strict";

// Class Definition
var CeabsTabulations = function() {

    var initTableTabulacao = function () {
        $('#table-tabulations').DataTable({
            "language": {
                "aria": {
                    "sortAscending": ": Ascendente",
                    "sortDescending": ": Decrescente"
                },
                "emptyTable": "Nenhum registro disponível",
                "info": "Visualizando _START_ até _END_ de _TOTAL_ registros",
                "infoEmpty": "Registros não localizados",
                "infoFiltered": "(filtrado 1 de _MAX_ registros)",
                "lengthMenu": "Visualizar _MENU_",
                "search": "Localizar:",
                "zeroRecords": "Nenhum registro disponível",
                "paginate": {
                    "previous": "<i class='mdi mdi-chevron-left'>",
                    "next": "<i class='mdi mdi-chevron-right'>",
                    "last": "Último",
                    "first": "Primeiro"
                }
            },
            "drawCallback": function () {
                $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
            },
            "lengthMenu": [
                [-1],
                ["Todos"]
            ],
            "scrollX": true,
            "lengthChange": false,
            "pageLength": -1,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "type": 'post',
                "url": MetApp.getSiteUrl('ceabs/tabulations/get-result-table'),
                "timeout": 20000,
                "data": function (data) {
                    MetApp.startPageLoading();
                    data['filters'] = {
                        DataReferenciaDe: $("input[name='DataReferenciaDe']").val(),
                        DataReferenciaAte: $("input[name='DataReferenciaAte']").val(),
                        Visao: $("input[name='radioVisao']:checked").val()
                    };
                },
                "dataSrc": function (res) {
                    MetApp.stopPageLoading();
                    if (res.msg) {
                        return false;
                    } else {
                        return res.data;
                    }
                }
            },
            "columns": [
                {title: 'FINALIZADOR', data: 'Finalizador', name: 'Finalizador', className: '', defaultContent: '--'},
                {title: 'TOTAL', data: 'QtdTotalTabulacao', name: 'QtdTotalTabulacao', className: 'text-center', defaultContent: '-'},
                {title: '7', data: '7', name: '7', className: 'text-center', defaultContent: '-'},
                {title: '8', data: '8', name: '8', className: 'text-center', defaultContent: '-'},
                {title: '9', data: '9', name: '9', className: 'text-center', defaultContent: '-'},
                {title: '10', data: '10', name: '10', className: 'text-center', defaultContent: '-'},
                {title: '11', data: '11', name: '11', className: 'text-center', defaultContent: '-'},
                {title: '12', data: '12', name: '12', className: 'text-center', defaultContent: '-'},
                {title: '13', data: '13', name: '13', className: 'text-center', defaultContent: '-'},
                {title: '14', data: '14', name: '14', className: 'text-center', defaultContent: '-'},
                {title: '15', data: '15', name: '15', className: 'text-center', defaultContent: '-'},
                {title: '16', data: '16', name: '16', className: 'text-center', defaultContent: '-'},
                {title: '17', data: '17', name: '17', className: 'text-center', defaultContent: '-'},
                {title: '18', data: '18', name: '18', className: 'text-center', defaultContent: '-'},
                {title: '19', data: '19', name: '19', className: 'text-center', defaultContent: '-'},
                {title: '20', data: '20', name: '20', className: 'text-center', defaultContent: '-'},
                {title: '21', data: '21', name: '21', className: 'text-center', defaultContent: '-'}
            ],
            "order": [
                [1, "desc"]
            ],
            "searching": false
        });
    };

    // Gráfico de Performance
    var updateChart = function (chartId) {
        var DataReferenciaDe = $("input[name='DataReferenciaDe']").val();
        var DataReferenciaAte = $("input[name='DataReferenciaAte']").val();
        $.ajax({
            type: 'POST',
            cache: true,
            url: MetApp.getSiteUrl('ceabs/tabulations/get-result-chart-' + chartId),
            async: true,
            data: {filters: {DataReferenciaDe: DataReferenciaDe, DataReferenciaAte: DataReferenciaAte}},
            beforeSend: function () {
                MetApp.startPageLoading();
            },
            success: function (result) {
                var res = JSON.parse(result);
                var dataProvider = [];
                var ttTabulacao = 0;
                var ttAgendamento = 0;
                var ttSucesso = 0;
                var ttInsucesso = 0;
                for (var x = 0; x < res.length; x++) {
                    ttTabulacao += res[x]['QtdTabulacao'];
                    ttAgendamento += res[x]['QtdAgendamento'];
                    ttSucesso += res[x]['QtdSucesso'];
                    ttInsucesso += res[x]['QtdInsucesso'];
                    dataProvider.push({
                        Categoria: (chartId === 'date' ? res[x]['DataReferencia'].substr(0, 5) : res[x]['Intervalo']),
                        QtdTabulacao: res[x]['QtdTabulacao'],
                        QtdAgendamento: res[x]['QtdAgendamento'],
                        QtdSucesso: res[x]['QtdSucesso'],
                        PercAgendamento: Math.round((res[x]['QtdAgendamento'] / res[x]['QtdSucesso']) * 100).toFixed(2),
                        PercSucesso: Math.round((res[x]['QtdSucesso'] / res[x]['QtdTabulacao']) * 100).toFixed(2)
                    });
                }
                if (chartId === 'interval') {
                    var PerTTAgendamento = Math.round((ttAgendamento / ttSucesso) * 100).toFixed(1);
                    var PerTTSucesso = Math.round((ttSucesso / ttTabulacao) * 100).toFixed(1);
                    var PerTTInsucesso = Math.round((ttInsucesso / ttTabulacao) * 100).toFixed(1);
                    $("#counterup-agendamento").html(PerTTAgendamento).counterUp();
                    $("#counterup-sucesso").html(PerTTSucesso).counterUp();
                    $("#counterup-insucesso").html(PerTTInsucesso).counterUp();
                }
                setChart(dataProvider, chartId);
                if (res.type) {
                    MetApp.alert({
                        container: '.chart',
                        place: 'prepend',
                        message: res.msg,
                        type: res.type + ' text-center'
                    });
                }
                MetApp.stopPageLoading();
            }
        });
    };

    var setChart = function (dataProvider, chartId) {
        var chart = AmCharts.makeChart("chart-" + chartId, {
            "type": "serial",
            "theme": "dark",
            "pathToImages": MetApp.getSiteUrl('assets/plugins/amcharts/amcharts/images/'),
            "autoMargins": false,
            "marginLeft": 10,
            "marginRight": 10,
            "marginTop": 25,
            "marginBottom": 25,
            "fontFamily": 'Open Sans',
            "color": '#FFFFFF',
            "dataProvider": dataProvider,
            "balloon": {
                "adjustBorderColor": false,
                "horizontalPadding": 10,
                "verticalPadding": 5,
                "color": "#363636"
            },
            "valueAxes": [{
                    "id": "graf-1",
                    "gridAlpha": 0,
                    "dashLength": 0,
                    "labelsEnabled": false,
                    "axisThickness": 0,
                    "tickLength": 0
                },{
                    "id": "graf-2",
                    "gridAlpha": 0,
                    "dashLength": 0,
                    "labelsEnabled": false,
                    "axisThickness": 0,
                    "tickLength": 0,
                    "position": "right"
                },{
                    "id": "graf-3",
                    "gridAlpha": 0,
                    "dashLength": 0,
                    "labelsEnabled": false,
                    "axisThickness": 0,
                    "tickLength": 0,
                    "position": "right"
                }],
            "startDuration": 1,
            "graphs": [{
                    "id": "graf-1",
                    "balloonText": "<span style='font-size:12px;'><b>[[value]]</b><br>TABULAÇÕES</span>",
                    "fillAlphas": 0.5,
                    "type": "column",
                    "valueAxis": "graf-1",
                    "valueField": "QtdTabulacao"
                },
                {
                    "id": "graf-2",
                    "balloonText": "<span style='font-size:12px;'><b>[[QtdAgendamento]] ( [[value]]% )</b><br>AGENDAMENTOS</span>",
                    "bullet": "round",
                    "type": "line",
                    "bulletSize": 4,
                    "valueAxis": "graf-2",
                    "valueField": "PercAgendamento",
                    "lineColor": "#00FFFF"
                },{
                    "id": "graf-2",
                    "balloonText": "<span style='font-size:12px;'><b>[[QtdSucesso]] ( [[value]]% )</b><br>SUCESSO</span>",
                    "bullet": "round",
                    "type": "line",
                    "bulletSize": 4,
                    "valueAxis": "graf-3",
                    "valueField": "PercSucesso",
                    "lineColor": "#FFF68F"
                }],
            "chartCursor": {
                "categoryBalloonEnabled": false,
                "cursorAlpha": 0,
                "zoomable": true
            },
            "categoryField": "Categoria"
        });
    };

    // Exportar Analitico
    var exportFile = function () {
        var DataReferenciaDe = encodeURIComponent($("input[name='DataReferenciaDe']").val());
        var DataReferenciaAte = encodeURIComponent($("input[name='DataReferenciaAte']").val());
        $(location).attr('href', MetApp.getSiteUrl('ceabs/export-file-excel?DataReferenciaDe=' + DataReferenciaDe + '&DataReferenciaAte=' + DataReferenciaAte));
    };

    return {
        init: function () {
            if (!jQuery().DataTable) {
                return;
            }

            $(".btn-update, .btn-export-csv, .btn-filter").removeClass("d-none");

            // Datepicker
            $('.flatpickr').flatpickr({
                "dateFormat": "d/m/Y",
                "defaultDate": 'today',
                "maxDate": 'today'
            });

            updateChart('interval');
            updateChart('date');
            initTableTabulacao();

            $(".btn-update").click(function() {
                updateChart('interval');
                $("#table-tabulations").DataTable().ajax.reload();
            });

            $('.btn-export-csv').click(function () {
                exportFile();
            });

            $('.btn-save-filter').click(function () {
                updateChart('interval');
                updateChart('date');
                $("#table-tabulations").DataTable().ajax.reload();
                $('#filter').modal('hide');
            });
        }
    };

}();

// Class Initialization
jQuery(document).ready(function() {
    CeabsTabulations.init();
});
