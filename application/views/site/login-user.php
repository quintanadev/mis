<!DOCTYPE html>

<html lang="pt-br">

	<!-- begin::Head -->
	<head>
		<meta charset="utf-8" />
		<title>Portal MIS - Login</title>
		<meta name="description" content="Login page">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!--begin::Fonts -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">

		<!--end::Fonts -->

		<!--begin::Page Custom Styles(used by this page) -->
		<link href="<?= base_url('assets/css/login-user.css'); ?>" rel="stylesheet" type="text/css" />

		<!--end::Page Custom Styles -->

		<!--begin::Global Theme Styles(used by all pages) -->
		<link href="<?= base_url('assets/css/plugins.bundle.css'); ?>" rel="stylesheet" type="text/css" />
		<link href="<?= base_url('assets/css/style.bundle.css'); ?>" rel="stylesheet" type="text/css" />

		<!--end::Global Theme Styles -->

		<!--begin::Layout Skins(used by all pages) -->

		<!--end::Layout Skins -->
		<link rel="shortcut icon" href="<?= base_url('assets/media/logos/favicon.ico'); ?>" />
	</head>

	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-aside--enabled kt-aside--fixed kt-page--loading">

		<!-- begin:: Page -->
		<div class="kt-grid kt-grid--ver kt-grid--root kt-page">
			<div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v4 kt-login--signin" id="kt_login">
				<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" style="background-image: url(<?= base_url('assets/media/bg/bg-2.jpg'); ?>);">
					<div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
						<div class="kt-login__container">
							<div class="kt-login__logo">
								<a href="<?= base_url(); ?>">
									<img src="<?= base_url('assets/media/logos/logo-login-mis2018.png'); ?>">
								</a>
							</div>
							<div class="kt-login__signin">
								<div class="kt-login__head">
									<h3 class="kt-login__title">Acesso Restrito</h3>
								</div>
								<form class="kt-form" action="" method="POST">
									<div class="input-group">
										<input class="form-control" type="text" placeholder="Usuário" name="Login" autocomplete="off" value="<?= ($this->session->userdata('USUARIO')['Login'] ? $this->session->userdata('USUARIO')['Login'] : ''); ?>">
									</div>
									<div class="input-group">
										<input class="form-control" type="password" placeholder="Senha" name="Senha">
									</div>
									<div class="row kt-login__extra sr-only">
										<div class="col kt-align-right">
											<a href="javascript:;" id="kt_login_forgot" class="kt-login__link">Esqueceu a senha ?</a>
										</div>
									</div>
									<div class="kt-login__actions">
                                        <input type="hidden" name="form_acao" value="login">
                                        <button id="kt_login_signin_submit" class="btn btn-brand btn-pill kt-login__btn-primary">Acessar</button>
									</div>
								</form>
							</div>
							<div class="kt-login__signup">
								<div class="kt-login__head">
									<h3 class="kt-login__title">Cadastro de Usuário</h3>
									<div class="kt-login__desc">Informe seus dados abaixo:</div>
								</div>
								<form class="kt-form" action="" method="POST">
									<div class="input-group">
										<input class="form-control" type="text" placeholder="Nome Completo" name="NomeUsuario" autocomplete="off">
									</div>
									<div class="input-group">
										<input class="form-control" type="text" placeholder="Email" name="Email" autocomplete="off">
                                    </div>
                                    <div class="input-group">
										<input class="form-control" type="text" placeholder="Matrícula" name="MatriculaElo" autocomplete="off">
                                    </div>
                                    <div class="input-group">
										<input class="form-control" type="text" placeholder="CPF" name="CPF" autocomplete="off">
                                    </div>
                                    <div class="input-group">
										<input class="form-control" type="text" placeholder="Login de Rede" name="Login" autocomplete="off">
									</div>
									<div class="input-group">
										<input class="form-control" type="password" placeholder="Senha" name="Senha" autocomplete="off">
									</div>
									<div class="kt-login__actions">
										<input type="hidden" name="form_acao" value="register">
										<button id="kt_login_signup_submit" class="btn btn-brand btn-pill kt-login__btn-primary">Solicitar</button>&nbsp;&nbsp;
										<button id="kt_login_signup_cancel" class="btn btn-secondary btn-pill kt-login__btn-secondary">Cancelar</button>
									</div>
								</form>
							</div>
							<div class="kt-login__forgot">
								<div class="kt-login__head">
									<h3 class="kt-login__title">Forgotten Password ?</h3>
									<div class="kt-login__desc">Enter your email to reset your password:</div>
								</div>
								<form class="kt-form" action="">
									<div class="input-group">
										<input class="form-control" type="text" placeholder="Email" name="email" id="kt_email" autocomplete="off">
									</div>
									<div class="kt-login__actions">
										<button id="kt_login_forgot_submit" class="btn btn-brand btn-pill kt-login__btn-primary">Request</button>&nbsp;&nbsp;
										<button id="kt_login_forgot_cancel" class="btn btn-secondary btn-pill kt-login__btn-secondary">Cancel</button>
									</div>
								</form>
							</div>
							<div class="kt-login__account">
								<span class="kt-login__account-msg">
									Não possui cadastro ? 
								</span>
								&nbsp;&nbsp;
								<a href="javascript:;" id="kt_login_signup" class="kt-login__account-link">Solicite aqui!</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- end:: Page -->

		<!-- begin::Global Config(global config for global JS sciprts) -->
		<script>
			var KTAppOptions = {
				"colors": {
					"state": {
						"brand": "#2c77f4",
						"light": "#ffffff",
						"dark": "#282a3c",
						"primary": "#5867dd",
						"success": "#34bfa3",
						"info": "#36a3f7",
						"warning": "#ffb822",
						"danger": "#fd3995"
					},
					"base": {
						"label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
						"shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"]
					}
				}
			};
		</script>

		<!-- end::Global Config -->

		<!--begin::Global Theme Bundle(used by all pages) -->
		<script src="<?= base_url('assets/plugins/plugins.bundle.js'); ?>" type="text/javascript"></script>
		<script src="<?= base_url('assets/js/scripts.bundle.js'); ?>" type="text/javascript"></script>

		<!--end::Global Theme Bundle -->

		<!--begin::Page Scripts(used by this page) -->
		<script src="<?= base_url('assets/js/site/login-user.js'); ?>" type="text/javascript"></script>

		<!--end::Page Scripts -->
	</body>

	<!-- end::Body -->
</html>