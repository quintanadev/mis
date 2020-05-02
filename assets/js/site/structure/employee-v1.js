"use strict";

// Class Definition
var Employee = function() {

    var getStructure = async function (id) {
        var structure = await $.ajax({
            type: 'POST',
            cache: false,
            url: MetApp.getSiteUrl('structure/get-employee'),
            async: true,
            data: { id },
            beforeSend: function () {
                MetApp.startPageLoading();
            },
            success: function (result) {
                MetApp.stopPageLoading();
            }
        });

        return structure;
    };

    var setStructure = async function (structure) {
        $('input[name="id_estrutura"]').val(structure.id_estrutura);
        $('input[name="matricula_elo"]').val(structure.matricula_elo);
        $('input[name="status"]').val(structure.status);
        $('input[name="status_gestor"]').val(structure.status_gestor);
        $('input[name="funcao"]').val(structure.funcao);
        $('input[name="nivel_hierarquico"]').val(structure.nivel_hierarquico);
        $('input[name="tipo_contratacao"]').val(structure.tipo_contratacao);
        $('input[name="data_admissao"]').val(structure.data_admissao);
        $('input[name="data_desligamento"]').val(structure.data_desligamento);
        $('input[name="motivo_desligamento"]').val(structure.motivo_desligamento);
        $('input[name="horario_entrada"]').val(structure.horario_entrada);
        $('input[name="horario_saida"]').val(structure.horario_saida);
        $('input[name="jornada_trabalho_dia"]').val(structure.jornada_trabalho_dia);
        $('input[name="jornada_trabalho_mes"]').val(structure.jornada_trabalho_mes);

        $('input[name="nome_gestor_1"]').val(structure.nome_gestor_1);
        $('input[name="nome_gestor_2"]').val(structure.nome_gestor_2);
        $('input[name="nome_gestor_3"]').val(structure.nome_gestor_3);
        $('input[name="nome_diretor"]').val(structure.nome_diretor);
        $('input[name="setor"]').val(structure.setor);
        $('input[name="site"]').val(structure.site);
        $('input[name="cliente"]').val(structure.cliente);
        $('input[name="segmento"]').val(structure.segmento);

        $('input[name="cpf"]').val(structure.cpf);
        $('input[name="identidade"]').val(structure.identidade);
        $('input[name="data_nascimento"]').val(structure.data_nascimento);
        $('input[name="sexo"]').val(structure.sexo);
        $('input[name="estado_civil"]').val(structure.estado_civil);
        $('input[name="grau_instrucao"]').val(structure.grau_instrucao);
        $('input[name="nome_mae"]').val(structure.nome_mae);
        $('input[name="nome_pai"]').val(structure.nome_pai);

        $('input[name="telefone_celular"]').val(structure.telefone_celular);
        $('input[name="telefone_fixo"]').val(structure.telefone_fixo);
        $('input[name="telefone_comercial"]').val(structure.telefone_comercial);
        $('input[name="telefone_corporativo"]').val(structure.telefone_corporativo);
        $('input[name="email_corporativo"]').val(structure.email_corporativo);
        $('input[name="email_pessoal"]').val(structure.email_pessoal);
        $('input[name="telefone_emergencia"]').val(structure.telefone_emergencia);
        $('input[name="contato_emergencia"]').val(structure.contato_emergencia);
    };

    var setDataSelect = async function (select, value) {
        var form = $('form').serialize();
        var data = await $.ajax({
            type: 'POST',
            cache: false,
            url: MetApp.getSiteUrl('structure/get-data-select'),
            async: true,
            data: { select, form },
            beforeSend: function () {
                MetApp.startPageLoading();
            },
            success: function (result) {
                var nameSelect = "id_" + select;
                $(`select[name="${nameSelect}"]`).html('<option value="0">SELECIONE...</option>');

                if (result !== 'false') {
                    var res = JSON.parse(result);

                    var val = 0;
                    res.map((arr) => {
                        $(`select[name="${nameSelect}"]`).append('<option value="' + arr.value + '">' + arr.title + '</option>');
                        if (arr.value === value) val = value;
                    });
                    
                    $(`select[name="${nameSelect}"]`).val(val);
                }

                $(`select[name="${nameSelect}"]`).selectpicker('refresh');
                MetApp.stopPageLoading();
            }
        });

        return data;
    };

    var saveDataForm = async function (page) {
        var form = $('form').serialize();
        var data = await $.ajax({
            type: 'POST',
            cache: false,
            url: MetApp.getSiteUrl(`structure/update-${page}-data`),
            async: true,
            data: form,
            beforeSend: function () {
                MetApp.startPageLoading();
            },
            success: function (result) {
                MetApp.stopPageLoading();
            }
        });

        return data;
    };

    // Public Functions
    return {
        init: async function() {

            var url = new URL(window.location.href);
            var id = url.searchParams.get('id');
            var edit = url.searchParams.get('edit');
            var structure = await getStructure(id);
            structure = JSON.parse(structure);

            if (edit) {
                $('input[name="id_estrutura"]').val(structure.id_estrutura);
                
                Ladda.bind(".btn-save", { callback: async function(a) {
                    var save = await saveDataForm(edit);
                    save = JSON.parse(save);
                    if (save.msg === 'success') {
                        url.searchParams.delete('edit');
                        window.location.replace(url.toString());
                    } else {
                        Swal.fire({
                            title: save.msg,
                            confirmButtonClass: "btn btn-confirm mt-2"
                        });
                        a.stop();
                    }
                }});

                Ladda.bind(".btn-cancel-edit", { callback: function(a) {
                    url.searchParams.delete('edit');
                    window.location.replace(url.toString());
                }});

                if (edit === 'corporate') {
                    await setDataSelect('status_gestor', structure.id_status_gestor);
                    $('input[name="horario_entrada"]').val(structure.horario_entrada);
                    $('input[name="horario_saida"]').val(structure.horario_saida);

                    $('.time').flatpickr({enableTime:!0,noCalendar:!0,dateFormat:"H:i",time_24hr:!0});
                } else if (edit === 'allocation') {
                    await setDataSelect('gestor', structure.id_gestor_1);
                    await setDataSelect('setor', structure.id_setor);
                    await setDataSelect('site', structure.id_site);
                    await setDataSelect('cliente', structure.id_cliente);
                    await setDataSelect('segmento', structure.id_cliente);

                    $('select[name="id_cliente"]').change(async function() {
                        await setDataSelect('segmento', structure.id_cliente);
                    });
                } else if (edit === 'personal') {
                    await setDataSelect('estado_civil', structure.id_estado_civil);
                    await setDataSelect('grau_instrucao', structure.id_grau_instrucao);
                    $('input[name="nome_mae"]').val(structure.nome_mae);
                    $('input[name="nome_pai"]').val(structure.nome_pai);
                } else if (edit === 'contact') {
                    $('input[name="telefone_celular"]').val(structure.telefone_celular);
                    $('input[name="telefone_fixo"]').val(structure.telefone_fixo);
                    $('input[name="telefone_comercial"]').val(structure.telefone_comercial);
                    $('input[name="telefone_corporativo"]').val(structure.telefone_corporativo);
                    $('input[name="email_corporativo"]').val(structure.email_corporativo);
                    $('input[name="email_pessoal"]').val(structure.email_pessoal);
                    $('input[name="telefone_emergencia"]').val(structure.telefone_emergencia);
                    $('input[name="contato_emergencia"]').val(structure.contato_emergencia);

                    $('[data-toggle="input-mask"]').each(function(a, e) {
                        var t=$(e).data("maskFormat"), n=$(e).data("reverse");
                        null!=n ? $(e).mask(t,{reverse:n}) : $(e).mask(t)
                    });
                }
            } else {
                await setStructure(structure);
                
                $('.btn-edit').click(function() {
                    var page = $(this).data('page');
                    url.searchParams.set('edit', page);
                    window.location.replace(url.toString());
                });
            }
            
            $('form').removeClass('d-none');
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    Employee.init();
});
