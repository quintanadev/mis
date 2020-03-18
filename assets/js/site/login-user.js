"use strict";

// Class Definition
var LoginUser = function() {

    var login = $('#kt_login');

    var showErrorMsg = function(form, type, msg) {
        var alert = $('<div class="alert alert-' + type + ' alert-dismissible" role="alert">\
			<div class="alert-text">'+msg+'</div>\
			<div class="alert-close">\
                <i class="flaticon2-cross kt-icon-sm" data-dismiss="alert"></i>\
            </div>\
		</div>');

        form.find('.alert').remove();
        alert.prependTo(form);
        //alert.animateClass('fadeIn animated');
        KTUtil.animateClass(alert[0], 'fadeIn animated');
        alert.find('span').html(msg);
    }

    // Private Functions
    var displaySignUpForm = function() {
        login.removeClass('kt-login--forgot');
        login.removeClass('kt-login--signin');

        login.addClass('kt-login--signup');
        KTUtil.animateClass(login.find('.kt-login__signup')[0], 'flipInX animated');
    }

    var displaySignInForm = function() {
        login.removeClass('kt-login--forgot');
        login.removeClass('kt-login--signup');

        login.addClass('kt-login--signin');
        KTUtil.animateClass(login.find('.kt-login__signin')[0], 'flipInX animated');
        //login.find('.kt-login__signin').animateClass('flipInX animated');
    }

    var displayForgotForm = function() {
        login.removeClass('kt-login--signin');
        login.removeClass('kt-login--signup');

        login.addClass('kt-login--forgot');
        //login.find('.kt-login--forgot').animateClass('flipInX animated');
        KTUtil.animateClass(login.find('.kt-login__forgot')[0], 'flipInX animated');

    }

    var handleFormSwitch = function() {
        $('#kt_login_forgot').click(function(e) {
            e.preventDefault();
            displayForgotForm();
        });

        $('#kt_login_forgot_cancel').click(function(e) {
            e.preventDefault();
            displaySignInForm();
        });

        $('#kt_login_signup').click(function(e) {
            e.preventDefault();
            displaySignUpForm();
        });

        $('#kt_login_signup_cancel').click(function(e) {
            e.preventDefault();
            displaySignInForm();
        });
    }

    var handleSignInFormSubmit = function() {
        $('#kt_login_signin_submit').click(function(e) {
            e.preventDefault();
            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
                    Login: {
                        required: true
                    },
                    Senha: {
                        required: true
                    }
                },
                messages: {
                    Login: {
                        required: "Informe seu usuário."
                    },
                    Senha: {
                        required: "Informe sua senha."
                    }
                }
            });

            if (!form.valid()) {
                return;
            }

            btn.addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', true);

            form.ajaxSubmit({
                data: form.serialize(),
                url: MetApp.getSiteUrl('user/login'),
                success: function(response, status, xhr, $form) {
                    var res = JSON.parse(response);
                    if (res.type === 'success') {
                        $(location).attr('href', MetApp.getSiteUrl())
                    } else {
                        setTimeout(function() {
                            btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                            showErrorMsg(form, res.type, res.msg);
                        }, 1000);
                    }
                }
            });
        });
    }

    var handleSignUpFormSubmit = function() {
        $('#kt_login_signup_submit').click(function(e) {
            e.preventDefault();

            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
                    NomeUsuario: {
	                    required: true
	                },
	                Email: {
	                    required: true,
	                    email: true
	                },
	                MatriculaElo: {
						required: true,
						maxlength: 9
	                },
	                CPF: {
						required: true,
						maxlength: 11,
                    	minlength: 11
	                },
	                Login: {
	                    required: true
					},
					Senha: {
	                    required: true
	                }
                },
                messages: {
	                NomeUsuario: {
	                    required: 'Informe seu nome completo.'
	                },
	                Email: {
	                    required: 'Informe seu email.',
	                    email: 'Informe um email válido.'
	                },
	                MatriculaElo: {
						required: 'Informe sua matrícula Elo.',
						maxlength: 'Informe uma Matrícula Elo válida.'
	                },
	                CPF: {
						required: 'Informe seu CPF.',
						maxlength: 'Informe um CPF válido.',
                    	minlength: 'Informe um CPF válido.'
	                },
	                Login: {
	                    required: 'Informe seu login de acesso à rede.'
					},
					Senha: {
	                    required: 'Informe sua senha.'
	                },
	            }
            });

            if (!form.valid()) {
                return;
            }

            btn.addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', true);

            form.ajaxSubmit({
                data: form.serialize(),
                url: MetApp.getSiteUrl('user/register'),
                success: function(response, status, xhr, $form) {
                    console.log(response);
                	var res = JSON.parse(response);
                    if (res.type === 'success' || res.type === 'info') {
                        setTimeout(function() {
                            btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);
                            form.clearForm();
                            form.validate().resetForm();

                            // display signup form
                            displaySignInForm();
                            var signInForm = login.find('.kt-login__signin form');
                            signInForm.clearForm();
                            signInForm.validate().resetForm();

                            showErrorMsg(signInForm, res.type, res.msg);
                        }, 2000);
                    } else {
                        setTimeout(function() {
                            btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false);

                            showErrorMsg(form, res.type, res.msg);
                        }, 2000);
                    }
                }
            });
        });
    }

    var handleForgotFormSubmit = function() {
        $('#kt_login_forgot_submit').click(function(e) {
            e.preventDefault();

            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    }
                }
            });

            if (!form.valid()) {
                return;
            }

            btn.addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', true);

            form.ajaxSubmit({
                url: '',
                success: function(response, status, xhr, $form) {
                	// similate 2s delay
                	setTimeout(function() {
                		btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false); // remove
	                    form.clearForm(); // clear form
	                    form.validate().resetForm(); // reset validation states

	                    // display signup form
	                    displaySignInForm();
	                    var signInForm = login.find('.kt-login__signin form');
	                    signInForm.clearForm();
	                    signInForm.validate().resetForm();

	                    showErrorMsg(signInForm, 'success', 'Cool! Password recovery instruction has been sent to your email.');
                	}, 2000);
                }
            });
        });
    }

    // Public Functions
    return {
        // public functions
        init: function() {
            handleFormSwitch();
            handleSignInFormSubmit();
            handleSignUpFormSubmit();
            //handleForgotFormSubmit();
        }
    };
}();

// Class Initialization
jQuery(document).ready(function() {
    LoginUser.init();
});
