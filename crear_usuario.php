<?php
include 'Bases/config.php';
include 'Bases/conexion.php';

// Inicializa la variable de error antes de verificar
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];

    // Realiza la inserción del nuevo usuario en la base de datos
    // Asegúrate de encriptar la contraseña antes de almacenarla en la base de datos
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Realiza la validación de nombre de usuario y correo electrónico
    $sentencia = $pdo->prepare("SELECT COUNT(*) AS count FROM usuarios WHERE username = ? OR email = ?");
    $sentencia->execute([$username, $email]);
    $result = $sentencia->fetch(PDO::FETCH_ASSOC);

    if ($result['count'] > 0) {
        // Nombre de usuario o correo electrónico ya en uso
        $error_message = "Nombre de usuario o correo electrónico ya está en uso. Intente con otro.";
    } else {
        // Inserta el nuevo usuario en la base de datos
        $sentencia = $pdo->prepare("INSERT INTO usuarios (username, password, nombre, email) VALUES (?, ?, ?, ?)");
        if ($sentencia->execute([$username, $hashedPassword, $nombre, $email])) {
            // Usuario creado exitosamente, redirige a login.php
            header('Location: login.php');
            exit;
        } else {
            // Error al crear el usuario
            $error_message = "Error al crear el usuario. Por favor, inténtelo de nuevo más tarde.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="Diseño/estilo.css">
    <script src="https://kit.fontawesome.com/6305bb531f.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center"><i class="fa-solid fa-user-plus" style="color: #ffffff;"></i> Crear Nuevo Usuario</h2>
                <h6 class="text-center">Por favor ingrese los datos solisitados.</h6>

                <br>
                <?php if (!empty($error_message)) : ?>
                    <div class="alert alert-warning" role="alert">
                        <?php echo $error_message; ?>
                    </div>
                <?php endif; ?>
                <form action="crear_usuario.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Nombre de Usuario</label>
                        <input type="text" class="form-control" id="username" name="username" required placeholder="Ingrese su nombre de usuario">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required placeholder="Ingrese su contraseña">
                    </div>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Ingrese su nombre completo">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" required placeholder="Ingrese su correo electronico">
                    </div>
                    <div class="Botton">
                        <button class="Login" type="submit">Crear usuario</button>
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