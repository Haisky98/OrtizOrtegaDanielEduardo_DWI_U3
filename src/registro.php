<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
    <!--begin::Head-->
    <head>
        <base href="../" />
        <title>Registro - E-commerce DWI</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
        <!--begin::Fonts-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
        <!--end::Fonts-->
        <!--begin::Global Stylesheets Bundle-->
        <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
        <!--end::Global Stylesheets Bundle-->
    </head>
    <!--end::Head-->
    <!--begin::Body-->
    <body id="kt_body" class="auth-bg">
        <!--begin::Main-->
        <div class="d-flex flex-column flex-root">
            <!--begin::Authentication - Sign-up -->
            <div class="d-flex flex-column flex-lg-row flex-column-fluid">
                <!--begin::Body-->
                <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
                    <!--begin::Form-->
                    <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                        <!--begin::Wrapper-->
                        <div class="w-lg-500px p-10">

                            <!-- Mensajes de error o éxito -->
                            <?php if (isset($_GET['error'])): ?>
                                <div class="alert alert-danger text-center mb-5">
                                    <?php 
                                        if ($_GET['error'] == 'campos_vacios') echo 'Por favor, llene todos los campos.';
                                        elseif ($_GET['error'] == 'email_existente') echo 'El correo electrónico ya está registrado.';
                                        elseif ($_GET['error'] == 'db_error') echo 'Error al registrar en la base de datos.';
                                    ?>
                                </div>
                            <?php endif; ?>

                            <!--begin::Form (Conectado a actions/registro_action.php) -->
                            <form class="form w-100" method="POST" action="actions/registro_action.php">
                                <!--begin::Heading-->
                                <div class="text-center mb-11">
                                    <h1 class="text-gray-900 fw-bolder mb-3">Crear Cuenta</h1>
                                    <div class="text-gray-500 fw-semibold fs-6">Registro de nuevo cliente</div>
                                </div>
                                <!--begin::Heading-->

                                <!--begin::Input group= Nombre -->
                                <div class="fv-row mb-8">
                                    <input type="text" placeholder="Nombre completo" name="nombre" autocomplete="off" class="form-control bg-transparent" required />
                                </div>
                                <!--end::Input group-->

                                <!--begin::Input group= Email -->
                                <div class="fv-row mb-8">
                                    <input type="email" placeholder="Correo electrónico" name="email" autocomplete="off" class="form-control bg-transparent" required />
                                </div>
                                <!--end::Input group-->

                                <!--begin::Input group= Password -->
                                <div class="fv-row mb-8">
                                    <input type="password" placeholder="Contraseña" name="password" autocomplete="off" class="form-control bg-transparent" required />
                                </div>
                                <!--end::Input group-->

                                <!--begin::Submit button-->
                                <div class="d-grid mb-10">
                                    <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
                                        <span class="indicator-label">Registrarse</span>
                                    </button>
                                </div>
                                <!--end::Submit button-->

                                <!--begin::Sign up-->
                                <div class="text-gray-500 text-center fw-semibold fs-6">¿Ya tienes una cuenta? 
                                <a href="login.php" class="link-primary fw-semibold">Inicia Sesión</a></div>
                                <!--end::Sign up-->
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Form-->
                </div>
                <!--end::Body-->

                <!--begin::Aside-->
                <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2" style="background-image: url(assets/media/misc/auth-bg.png)">
                    <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
                        <h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7">E-commerce DWI</h1>
                        <div class="d-none d-lg-block text-white fs-base text-center">Seguridad y Web Services integrados</div>
                    </div>
                </div>
                <!--end::Aside-->
            </div>
            <!--end::Authentication - Sign-up-->
        </div>
        <!--end::Main-->
        <!--begin::Javascript-->
        <script>var hostUrl = "assets/";</script>
        <script src="assets/plugins/global/plugins.bundle.js"></script>
        <script src="assets/js/scripts.bundle.js"></script>
        <!--end::Javascript-->
    </body>
    <!--end::Body-->
</html>