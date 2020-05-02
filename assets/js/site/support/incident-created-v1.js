"use strict";

// Class Definition
var IncidentCreated = function() {

    var initRequestType = function () {
        $.ajax({
            type: 'POST',
            cache: false,
            url: MetApp.getSiteUrl('support/incident/get-request-type'),
            async: true,
            data: {},
            beforeSend: function () {
                MetApp.startPageLoading();
            },
            success: function (result) {
                var res = JSON.parse(result);

                $("select[name='id_request_type']").html('<option value="0">Selecione...</option>');
                for (var i = 0; i < res.length; i++) {
                    $("select[name='id_request_type']").append('<option value="' + res[i].id_request_type + '">' + res[i].request_type + '</option>');
                }
                $("select[name='id_request_type']").selectpicker('refresh');
                MetApp.stopPageLoading();
            }
        });
    };

    var initRequest = function () {
        $.ajax({
            type: 'POST',
            cache: false,
            url: MetApp.getSiteUrl('support/incident/get-request'),
            async: true,
            data: {id_request_type: $("select[name='id_request_type']").val()},
            beforeSend: function () {
                MetApp.startPageLoading();
            },
            success: function (result) {
                var res = JSON.parse(result);

                $("select[name='id_request']").html('<option value="0">Selecione...</option>');
                for (var i = 0; i < res.length; i++) {
                    $("select[name='id_request']").append('<option value="' + res[i].id_request + '">' + res[i].request + '</option>');
                }
                $("select[name='id_request']").selectpicker('refresh');
                MetApp.stopPageLoading();
            }
        });
    };

    var initOperation = function () {
        if ($("select[name='id_request']").val() !== "0") {
            $.ajax({
                type: 'POST',
                cache: false,
                url: MetApp.getSiteUrl('support/incident/get-operation'),
                async: true,
                data: {},
                beforeSend: function () {
                    MetApp.startPageLoading();
                },
                success: function (result) {
                    var res = JSON.parse(result);

                    $("select[name='id_operation']").html('<option value="0">Selecione...</option>');
                    for (var i = 0; i < res.length; i++) {
                        $("select[name='id_operation']").append('<option value="' + res[i].id_operation + '">' + res[i].operation + '</option>');
                    }
                    $("select[name='id_operation']").selectpicker('refresh');
                    MetApp.stopPageLoading();
                }
            });
        } else {
            $("select[name='id_operation']").html('<option value="0">Selecione...</option>');
        }
    };

    var saveIncident = function () {
        var dados = $("form").serialize();
        $.ajax({
            type: 'POST',
            cache: false,
            url: MetApp.getSiteUrl('support/incident/post-incident'),
            async: true,
            data: dados,
            beforeSend: function () {
                MetApp.startPageLoading();
            },
            success: function (result) {
                var res = JSON.parse(result);
                if (res.msg) {
                    if (res.type === 'success') {
                        $(location).attr('href', MetApp.getSiteUrl('support/incident'));
                    }
                    MetApp.alert({
                        message: res.msg,
                        type: res.type,
                        closeInSeconds: 5
                    });
                }
                MetApp.stopPageLoading();
            }
        });
    };

    // Public Functions
    return {
        init: function() {

            $('[data-toggle="input-mask"]').each(function(a, e) {
                var t=$(e).data("maskFormat"), n=$(e).data("reverse");
                null!=n ? $(e).mask(t,{reverse:n}) : $(e).mask(t)
            });

            initRequestType();

            var quill = new Quill(".bubble-editor", {
                theme: "snow",
                placeholder: 'Descreva de forma detalhada e com clareza. Ao citar algum funcionário, por favor, insira sempre a matrícula e o nome para que possamos localizar na estrutura.',
                modules: {
                    toolbar: [
                        [{ font: [] }],
                        ["bold", "italic", "link"],
                        [{ color: [] }, { background: [] }],
                        [{ header: [!1,1,2,3,4,5,6] }, "blockquote", "code-block"],
                        [{ list: "ordered" }, { list: "bullet" }],
                        [{ align: [] }],
                        ["clean"]
                    ]
                }
            });

            $("select[name='id_request_type']").change(function() {
                initRequest();
                initOperation();
            });

            $("select[name='id_request']").change(function() {
                initOperation();
            });

            $(".btn-save-incident").click(function() {
                var btn = $(this);
                btn.addClass('disabled');
                
                var form = document.querySelector('form');
                var description = document.querySelector('input[name="description"]');
                description.value = JSON.stringify(quill.getContents());
                var dados = $(form).serializeArray();

                var arr = [];
                for (var i = 0; i < dados.length; i++) {
                    arr[dados[i].name] = dados[i].value;
                }
                var msg = "";
                if (arr["id_request_type"] === '0') {
                    msg = "Favor preencher todos os campos!";
                } else if (arr["id_request"] === '0') {
                    msg = "Favor preencher todos os campos!";
                } else if (arr["id_operation"] === '0') {
                    msg = "Favor preencher todos os campos!";
                } else if (arr["phone"] === '' || arr["phone"].replace(/_/g, "").length < 13) {
                    msg = "Favor informe um telefone de contato!";
                } else if (arr["subject"] === '' || arr["subject"].length < 5) {
                    msg = "Favor informe o assunto principal!";
                } else if (arr["description"] === '' || arr["description"].length < 10) {
                    msg = "Favor descreva sua solicitação de forma mais detalhada!";
                }
                
                if (msg) {
                    Swal.fire({
                        title: msg,
                        confirmButtonClass: "btn btn-confirm mt-2"
                    });
                } else {
                    saveIncident();
                }

                btn.removeClass('disabled');
            });
            
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    IncidentCreated.init();
});
