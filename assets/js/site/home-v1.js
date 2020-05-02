"use strict";

// Class Definition
var Home = function() {

    var getBirthdays = function () {
        $.ajax({
            type: 'POST',
            cache: false,
            url: MetApp.getSiteUrl('home/get-birthdays'),
            async: true,
            data: {},
            beforeSend: function () {
                MetApp.startPageLoading();
            },
            success: function (result) {
                var birthdays = '';

                if (result !== 'false') {
                    var res = JSON.parse(result);
                    res.map((arr) => {
                        birthdays += '<div class="inbox-item"> \
                            <div class="inbox-item-img"><img src="assets/media/users/default.jpg" class="rounded-circle" alt=""></div> \
                            <p class="inbox-item-author"> ' + arr.nome + ' </p> \
                            <p class="inbox-item-text">This theme is awesome!</p> \
                            <p class="inbox-item-date"> \
                                <a href="javascript:;" class="btn btn-sm btn-link text-info font-13 btn-send-gift" data-estrutura="' + arr.id_estrutura + '"> Enviar Gift <i class="fas fa-gift"></i> </a> \
                            </p> \
                        </div>';                        
                    });
                } else {
                    birthdays += '<div class="inbox-item"> \
                            <div class="inbox-item-img"><img src="assets/media/users/default.jpg" class="rounded-circle" alt=""></div> \
                            <p class="inbox-item-author">NENHUM ANIVERSARIANTE HOJE!</p> \
                        </div>'; 
                }

                $('#birthdays').append(birthdays);
                $('.btn-send-gift').click(function() {
                    Swal.fire({
                        title: 'Gift enviado! <i class="fas fa-hand-middle-finger"></i>',
                        confirmButtonClass: "btn btn-confirm mt-2"
                    });
                });
                MetApp.stopPageLoading();
            }
        });
    };

    // Public Functions
    return {
        init: function() {
            getBirthdays();

            
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    Home.init();
});
