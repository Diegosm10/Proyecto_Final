<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="..\css\login_styles.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/solid.css">

</head>

<body>
    <form action="../../main_login.php" method="post">
        <div class="section">
            <div class="container">
                <div class="row full-height justify-content-center">
                    <div class="col-12 text-center align-self-center py-5">
                        <div class="section pb-5 pt-5 pt-sm-2 text-center">
                            <div class="card-3d-wrap mx-auto">
                                <div class="card-3d-wrapper">
                                    <div class="card-front">
                                        <div class="center-wrap">
                                            <div class="section text-center">
                                                <h4 class="mb-4 pb-3">Iniciar sesion</h4>
                                                <div class="form-group">
                                                    <div class="input-container">
                                                        <img src="../img/at.svg" class="input-icon-img"
                                                            alt="Icono de carta">
                                                        <input type="email" name="email" class="form-style"
                                                            placeholder="Email" id="logemail" autocomplete="off">
                                                    </div>
                                                </div>
                                                <div class="form-group mt-2">
                                                    <div class="input-container">
                                                        <img src="../img/padlock.svg" class="input-icon-img"
                                                            alt="Icono de candado">
                                                        <input type="password" name="contrasena" class="form-style"
                                                            placeholder="Contraseña" id="logpass" autocomplete="off">
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn mt-4">Iniciar sesion</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>

</html>