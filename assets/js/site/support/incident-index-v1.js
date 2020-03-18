"use strict";

// Class Definition
var IncidentIndex = function() {

    var initTable = function() {
        $('#tickets-table').DataTable({
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
                {title: 'ID', data: 'IDTicket', name: 'TKT.IDTicket', className: 'text-center', defaultContent: '-'},
                {title: 'Operação', data: 'Operacao', name: 'OPE.Operacao', className: 'text-center', defaultContent: '-'},
                {title: 'Usuario Abertura', data: 'UsuarioCadastro', name: 'USU.NomeUsuario', className: '', defaultContent: '-'},
                {title: 'Tipo Solicitação', data: 'TipoSolicitacao', name: 'TSOL.TipoSolicitacao', className: '', defaultContent: '-'},
                {title: 'Data Cadastro', data: 'DataCadastro', name: 'TKT.DataCadastro', className: 'text-center', defaultContent: '-'},
                {title: 'Status', data: 'Status', name: 'STS.Status', className: '', defaultContent: '-'},
                {title: 'Ações', data: 'Acoes', className: 'text-center', defaultContent: '-'}
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
