"use strict";

// Class Definition
var Index = function() {

    var initTable = function() {
        $('#structure-table').DataTable({
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
                "url": MetApp.getSiteUrl('structure/get-current-structure'),
                "data": function (data) {
                }
            },
            "columns": [
                {title: 'Matrícula Elo', data: 'matricula_elo', name: 'matricula_elo', className: 'text-center', defaultContent: '-'},
                {title: 'Nome', data: 'nome', name: 'nome', className: '', defaultContent: '-'},
                {title: 'Ações', data: 'actions', className: 'text-center', defaultContent: '-'}
            ],
            "order": [
                [1, "asc"]
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
    Index.init();
});
