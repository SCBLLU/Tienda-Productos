<?php
include 'Bases/config.php';
include 'Bases/conexion.php';
include 'carrito.php';

session_start();
if (!isset($_SESSION['usuario'])) {
    // El usuario no está autenticado, redirige al inicio de sesión
    header('Location: login.php');
    exit;
}
$usuario = $_SESSION['usuario'];

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pago</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="Diseño/estilo.css">
    <script src="https://kit.fontawesome.com/6305bb531f.js" crossorigin="anonymous"></script>

</head>

<body>
    <nav>
        <div class="logo">
            <h4>Pago</h4>
        </div>
        <ul class="nav-links">
            <li><a href="perfil.php"><i class="fa-solid fa-house" style="color: #ffffff;"></i> Tienda</a></li>
            <li><a href="mostrarCarrito.php"><i class="fa-solid fa-backward" style="color: #ffffff;"></i> Mis Productos</a></li>

            <?php if (isset($_SESSION['usuario'])) { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-user" style="color: #ffffff;"></i> <span style="color: gray;"><?php echo $usuario['username']; ?></span> <!-- Nombre de usuario rojo -->
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li class="text-center align-bottom custom-dropdown-item"> <a href="cerrar_sesion.php" class="custom-logout-btn">Cerrar Sesión</a> </li>
                    </ul>
                </li>
            <?php } else { ?>
                <li><a href="login.php">Iniciar Sesión</a></li>
            <?php } ?>

        </ul>
        <div class="burger">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>
        </div>
    </nav>

    <br>

    <?php
    if ($_POST) {
        $total = 0;
        $Correo = $_POST['email'];
        $SID = session_id(); // Recupera la clave de la sesion
        foreach ($_SESSION['CARRITO'] as $indice => $producto) {
            $total = $total + ($producto['PRECIO'] * $producto['CANTIDAD']);
        }
        $sentencia = $pdo->prepare("INSERT INTO `tblventas` (`ID`, `ClaveTransaccion`, `PaypalDatos`, `Fecha`, `Correo`, `Total`, `status`) 
                        VALUES (NULL, :ClaveTransaccion, '', NOW(), :Correo, :Total, 'pendiente')");

        $sentencia->bindParam(":ClaveTransaccion", $SID);
        $sentencia->bindParam(":Correo", $Correo);
        $sentencia->bindParam(":Total", $total);
        $sentencia->execute();
        $idVenta = $pdo->lastInsertId(); //relaciona los articulos seleccionados en el ultimo Id de session del usuario

        //INSERTAR INFORMACION DE PRODUCTOS EN LA TABLA TBLDETALLEVENTA
        foreach ($_SESSION['CARRITO'] as $indice => $producto) {

            $sentencia = $pdo->prepare("INSERT INTO 
            `tbldetalleventa` (`ID`, `IDVENTA`, `IDPRODUCTO`, `PRECIOUNITARIO`, `CANTIDAD`, `DESCARGADO`) 
            VALUES (NULL, :IDVENTA, :IDPRODUCTO, :PRECIOUNITARIO, :CANTIDAD, '0');");

            $sentencia->bindParam(":IDVENTA", $idVenta);
            $sentencia->bindParam(":IDPRODUCTO", $producto['ID']);
            $sentencia->bindParam(":PRECIOUNITARIO", $producto['PRECIO']);
            $sentencia->bindParam(":CANTIDAD",  $producto['CANTIDAD']);
            $sentencia->execute();
        }
    }

    ?>

    <?php
    // Conexión a la base de datos (ajusta los valores de acuerdo a tu configuración)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tienda";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar la conexión
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }

    // Obtener los datos del formulario
    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];
    $name = $_POST['nombre'];

    // Insertar los datos en la base de datos
    $sql = "INSERT INTO ubicaciones (latitud, longitud, nombre) VALUES ('$latitud', '$longitud', '$name')";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-primary'  role='alert' align='center'>Ubicacion guardada exitosamente</div>";
    } else {
        echo "Error al guardar la ubicación: " . $conn->error;
    }

    $conn->close();

    ?>

    <div class="alert alert-success" id="pago" role="alert" align="center">
        <h4 class="alert-heading">Ultimo paso.</h4>
        <p id="monto">El monto a pagar es de:
        <h3 id="dinero">$ <?php echo number_format($total, 2); ?></h3>
        </p>
        <hr>
        <p class="mb-0" id="monto">¿Tiene algun problema o consula? Comunicarse a <a id="soporte" href="mailto:scbllu.200@gmail.com">
                soporte@gmail.com</a>.</p>

        <br>
        <div class="d-flex justify-content-center mt-3">
            <button class="Pago-final" type="button">Pagar</button>
        </div><br>

    </div>



    <div>
        <div class="legal-box" href="index.php"><img src="assets/Iconos/Nike-Logo.jpeg" width="150" alt="">
            <hr>
            <p class="text-legal">Ubicación: <a href="https://maps.app.goo.gl/bL8W1KFXjx3vAX78A" target="_blank">HPR6+3XV, Zaragoza</a>
            </p>
            <p class="text-legal">© 2023 NIKE. Todos los derechos reservados.
            </p>
            <p class="text-legal">Telefonos: <a href="tel:+503 7701-5982" id="cel1">7701-5982</a> - <a href="tel:+503 7758-9485" id="cel2">7758-9485</a>
            </p>
            <p class="text-legal">Correo Electronico: <a href="mailto:scbllu.200@gmail.com">
                    scbllu.200@gmail.com</a>.
            </p>
            <hr>
        </div>
    </div>

    <!-- Mis scripts -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="scripts.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</body>

</html>