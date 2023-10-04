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

// Manejo de la eliminación de productos
if (isset($_POST['btnAccion']) && $_POST['btnAccion'] === 'Eliminar') {
    if (isset($_POST['id'])) {
        $ID = filter_var($_POST['id'], FILTER_VALIDATE_INT);
        if ($ID !== false) {
            $carrito_actualizado = array(); // Arreglo para el carrito actualizado
            foreach ($_SESSION['CARRITO'] as $producto) {
                if ($producto['ID'] !== $ID) {
                    $carrito_actualizado[] = $producto; // Agrega productos no eliminados
                }
            }
            $_SESSION['CARRITO'] = $carrito_actualizado; // Actualiza el carrito
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="Diseño/estilo.css">
    <script src="https://kit.fontawesome.com/6305bb531f.js" crossorigin="anonymous"></script>

</head>

<body>

    <nav>
        <div class="logo">
            <h4>Productos</h4>
        </div>
        <ul class="nav-links">
            <li><a href="perfil.php"><i class="fa-solid fa-backward" style="color: #ffffff;"></i> Tienda</a></li>
            <li><a href="mostrarCarrito.php"><i class="fa-solid fa-cart-shopping" style="color: #ffffff;"></i> Mis Productos (<?php echo (empty($_SESSION['CARRITO'])) ? 0 : count($_SESSION['CARRITO']); ?>)</a></li>
            <li><a href="https://maps.app.goo.gl/bL8W1KFXjx3vAX78A" target="_blank"><i class="fa-solid fa-location-dot" style="color: #ffffff;"></i> Ubicación</a></li>
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

    <div class="container">
        <br>
        <div>
            <h1 class="text-center">Lista de productos a comprar</h1><br>
            <?php if (!empty($_SESSION['CARRITO'])) { ?>
                <div class="table-responsive">
                    <form action="" method="POST">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tabla-producto">
                                <thead>
                                    <tr>
                                        <th>Descripción</th>
                                        <th class="text-center">Cantidad</th>
                                        <th class="text-center">Precio</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total = 0; ?>
                                    <?php foreach ($_SESSION['CARRITO'] as $indice => $producto) { ?>
                                        <tr>
                                            <td><?php echo $producto['NOMBRE']; ?></td>
                                            <td class="text-center"><?php echo $producto['CANTIDAD']; ?></td>
                                            <td class="text-center"><?php echo $producto['PRECIO']; ?></td>
                                            <td class="text-center">$<?php echo number_format($producto['PRECIO'] * $producto['CANTIDAD'], 2); ?></td>
                                            <td class="text-center">
                                                <input type="hidden" name="id" value="<?php echo $producto['ID']; ?>">
                                                <button type="submit" name="btnAccion" value="Eliminar" class="btn btn-warning btn-sm">Eliminar</button>
                                            </td>
                                        </tr>
                                        <?php $total = $total + ($producto['PRECIO'] * $producto['CANTIDAD']); ?>
                                    <?php  } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" align="left">
                                            <h3>TOTAL A PAGAR</h3>
                                        </td>
                                        <td colspan="2" class="text-center">
                                            <h3 id="dinero-2">$<?php echo number_format($total, 2); ?></h3>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </form>

                </div>
                <div class="container">
                    <form action="pagar.php" method="POST">
                        <form action="pagar.php" method="POST">
                            <div class="alert alert-success" id="formulario" role="alert">
                                <h2 align="center">Ingrese sus datos para realizar el envío</h2>
                                <form method="POST" action="pagar.php">
                                    <hr>
                                    <div class="form__group field">
                                        <input type="text" name="nombre" id="nombre_contacto" placeholder="Ingrese su nombre" class="form__field" required>
                                        <label for="nombre_contacto" class="form__label">Nombre del contacto:</label>

                                    </div>

                                    <div class="form__group field">
                                        <input type="text" name="email" id="correo_contacto" placeholder="Ingrese su correo electronico" class="form__field" required>
                                        <label for="correo_contacto" class="form__label">Correo de contacto:</label>

                                    </div>

                                    <div class="form__group field">
                                        <input type="text" name="telefono" id="telefono_contacto" placeholder="Ingrese su numero de contacto" class="form__field" required>
                                        <label for="telefono_contacto" class="form__label">Teléfono de contacto:</label>

                                    </div>
                                    <hr>
                                    <div class="container-fluid" align="center">
                                        <h3 align="center"><i class="fa-solid fa-arrow-down" style="color: #fff;"></i> Seleccione la ubicación de entrega en el mapa <i class="fa-solid fa-arrow-down" style="color: #fff;"></i></h3>
                                        <br>
                                        <div id="map" style="height: 400px; width: 100%;"></div>
                                        <br>
                                        <hr>
                                        <input type="text" id="latitud" name="latitud" readonly />
                                        <input type="text" id="longitud" name="longitud" readonly />
                                        <br>
                                        <hr>

                                        <div>
                                            <button class="Proceso-pago" type="submit" name="btnAccion" value="Proceder">
                                                <h3>Proceder a pagar</h3>
                                            </button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </form>
                    </form>
                </div>
            <?php } else { ?>
                <div class="alert alert-success" role="alert" align="center">
                    <h3>No hay productos en el carrito...</h3>
                </div>
            <?php } ?>
        </div>

        <br>




        <script>
            var map; // Variable global para el mapa
            var marcador; // Variable global para el marcador

            function initMap() {
                // Definir las coordenadas iniciales del mapa
                var mapOptions = {
                    center: {
                        lat: 13.701330386737299,
                        lng: -89.22421158274344
                    }, // Cambia estas coordenadas
                    zoom: 15
                };

                // Crear el mapa y asignarlo a un elemento HTML con el id "map"
                map = new google.maps.Map(document.getElementById("map"), mapOptions);

                // Agregar un listener al mapa para capturar el clic del usuario
                google.maps.event.addListener(map, 'click', function(event) {
                    // Actualizar los campos de latitud y longitud con las coordenadas del clic
                    document.getElementById("latitud").value = event.latLng.lat();
                    document.getElementById("longitud").value = event.latLng.lng();

                    // Si ya existe un marcador, mueve el marcador a la nueva ubicación
                    if (marcador) {
                        marcador.setPosition(event.latLng);
                    } else {
                        // Si no existe un marcador, crea uno nuevo
                        marcador = new google.maps.Marker({
                            position: event.latLng,
                            map: map,
                            icon: {
                                url: 'assets/Iconos/map-pin.svg', // Reemplaza esto con la URL de tu imagen de flecha
                                scaledSize: new google.maps.Size(30, 30),
                                origin: new google.maps.Point(0, 0),
                                anchor: new google.maps.Point(15, 15)
                            }
                        });
                    }
                });
            }
        </script>



        <!-- Mis scripts -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="scripts.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCgzjMIqUSAp6XqcW09hkzbJB3UYEpmx5A&libraries=places&callback=initMap" async defer></script>

        <!-- scripts de bootstrap -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    </div>
</body>

</html>