<?php
include 'Bases\config.php';
include 'Bases\conexion.php';
include 'carrito.php';
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Compras</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="Diseño/estilo.css">
</head>

<body>

    <nav>
        <div class="logo">
            <h4>Compras</h4>
        </div>
        <ul class="nav-links">
            <a href="index.php">Inicio</a>
            <a href="mostrarCarrito.php">Carrito (<?php echo (empty($_SESSION['CARRITO'])) ? 0 : count($_SESSION['CARRITO']); ?>)</a>
            <a href="#">Contacto</a>
            <a href="https://maps.app.goo.gl/bL8W1KFXjx3vAX78A" target="_blank">Ubicación</a>

        </ul>
        <div class="burger">
            <div class="line1"></div>
            <div class="line2"></div>
            <div class="line3"></div>
        </div>
    </nav>

    <div>
        <div class="container">
            <div><br><br>
                <h2 align="center">
                    Carro De Compras 🛒
                </h2>
            </div><br><br>


            <div>
                <h1 class="text-center">Lista de productos a comprar</h1><br>
                <?php if (!empty($_SESSION['CARRITO'])) { ?>
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
                                        <form action="" method="POST">
                                            <td class="text-center">
                                                <input type="hidden" id="id" name="id" value="<?php echo $producto['ID']; ?>">
                                                <button type="submit" name="btnAccion" value="Eliminar" class="btn btn-warning btn-sm">Eliminar</button>
                                            </td>
                                        </form>
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
                    <div class="container">
                        <form action="pagar.php" method="POST">
                            <div class="alert alert-success" id="formulario" role="alert">
                                <h2>Ingrese sus datos para realizar el envío</h2>
                                <form method="POST" action="pagar.php">
                                    <hr>
                                    <div class="form-group">
                                        <label for="nombre_contacto">Nombre del contacto:</label>
                                        <input type="text" name="nombre" id="nombre_contacto" placeholder="Ingrese su nombre" class="form-control" required>
                                    </div><br>
                                    <div class="form-group">
                                        <label for="correo_contacto">Correo de contacto:</label>
                                        <input type="email" name="email" id="correo_contacto" placeholder="Ingrese su correo electronico" class="form-control">
                                    </div><br>
                                    <div class="form-group">
                                        <label for="telefono_contacto">Teléfono de contacto:</label>
                                        <input type="text" name="telefono" id="telefono_contacto" placeholder="Ingrese su numero de contacto" class="form-control" required>
                                    </div>
                                    <hr>
                                    <div class="container-fluid" align="center">
                                        <h3 align="center">&#8681; Seleccione la ubicación de entrega en el mapa &#8681;</h3>
                                        <br>
                                        <div id="map" style="height: 400px; width: 80%;"></div>
                                        <br>
                                        <hr>
                                        <input type="text" id="latitud" name="latitud" readonly />
                                        <input type="text" id="longitud" name="longitud" readonly />
                                        <input type="text" name="nombre_lugar" id="nombre_lugar" placeholder="Nombre del lugar" required />
                                        <br>
                                        <hr>

                                        <div class="d-flex justify-content-center mt-3">
                                            <button class="Proceso-pago" type="submit" name="btnAccion" value="Proceder">
                                                <h3>Proceder a pagar</h3>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </form>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-success" role="alert" align="center">
                        <h3>No hay productos en el carrito...</h3>
                    </div>
                <?php } ?>
            </div>

            <script>
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
                    var map = new google.maps.Map(document.getElementById("map"), mapOptions);

                    // Agregar un listener al mapa para capturar el clic del usuario
                    google.maps.event.addListener(map, 'click', function(event) {
                        // Actualizar los campos de latitud y longitud con las coordenadas del clic
                        document.getElementById("latitud").value = event.latLng.lat();
                        document.getElementById("longitud").value = event.latLng.lng();
                    });
                }
            </script>

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


        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="scripts.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCgzjMIqUSAp6XqcW09hkzbJB3UYEpmx5A&libraries=places&callback=initMap" async defer></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

</body>

</html>