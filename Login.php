<?php
include 'Bases/config.php';
include 'Bases/conexion.php';

// Inicializa la variable de error antes de verificar
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sentencia = $pdo->prepare("SELECT * FROM usuarios WHERE username = ?");
    $sentencia->execute([$username]);
    $usuario = $sentencia->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($password, $usuario['password'])) {
        // Usuario autenticado correctamente
        session_start();
        $_SESSION['usuario'] = $usuario;
        header('Location: perfil.php'); // Redirige al perfil del usuario
        exit;
    } else {
        // Usuario no encontrado o contraseña incorrecta
        $error_message = "Usuario o contraseña incorrectos. Intente de nuevo...";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="Diseño/estilo.css">
    <script src="https://kit.fontawesome.com/6305bb531f.js" crossorigin="anonymous"></script>

</head>

<body style="background-color: #5b648a;">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center"><i class="fa-solid fa-key" style="color: #ffffff;"></i> Iniciar Cesion</h2>
                <br>
                <h6 class="text-center">Ingrese sus credenciales o cree un usuario.</h6>
                <?php if (!empty($error_message)) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Usuario</label>
                        <input type="text" class="form-control" id="username" name="username" required placeholder="Ingrese su usuario">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required placeholder="Ingrese su contraseña">
                    </div>
                    <div class="Botton">
                        <button class="Login" type="submit">Iniciar sesión</button>
                    </div>
                    <br><br>
                    <div class="col">
                        <div class="d-flex justify-content-center">
                            <a href="crear_usuario.php">
                                <h6 class="fw-normal" id="Subtitulo">¿No tiene un usuario?</h6>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Mis scripts -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="scripts.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</body>

</html>