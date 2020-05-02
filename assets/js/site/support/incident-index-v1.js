"use strict";

// Class Definition
var IncidentIndex = function() {

    var initTable = function() {
        $('#incidents-table').DataTable({
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
                [10, 25, 50, -1],
                [10, 25, 50, "Todos"]
            ],
            "pageLength": 10,
            "processing": true,
            "serverSide": true,
            "ajax": {
                "type": 'post',
                "url": MetApp.getSiteUrl('support/incident/get-incident'),
                "data": function (data) {
                }
            },
            "columns": [
                {title: 'ID', data: 'id_incident', name: 'TKT.id_incident', className: 'text-center', defaultContent: '-'},
                {title: 'Operação', data: 'operation', name: 'OPE.operation', className: 'text-center', defaultContent: '-'},
                {title: 'Usuario Abertura', data: 'user_created', name: 'USU.user_name', className: '', defaultContent: '-'},
                {title: 'Tipo Solicitação', data: 'request_type', name: 'TSOL.request_type', className: '', defaultContent: '-'},
                {title: 'Data Cadastro', data: 'created_at', name: 'TKT.created_at', className: 'text-center', defaultContent: '-'},
                {title: 'Status', data: 'status', name: 'STS.status', className: '', defaultContent: '-'},
                {title: 'Ações', data: 'actions', className: 'text-center', defaultContent: '-'}
            ],
            "order": [
                [5, "asc"],
                [0, 'asc']
            ],
            "buttons": [{extend: 'excel'}]
        });
    }

    // Public Functions
    return {
        init: function() {
            initTable();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    IncidentIndex.init();
});
