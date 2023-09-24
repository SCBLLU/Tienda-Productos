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
    <title>Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="Diseño/estilo.css">
    <style>
        /* Aplica estilos al input para alinear el texto al centro */
        #cantidad {
            text-align: center;
        }
    </style>
</head>

<body>

    <nav>
        <div class="logo">
            <h4>Menu</h4>
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
            <div><br>
                <h2 align="center">
                    Bienvenidos
                </h2>
            </div>

            <br>

            <div class="carousel-container">
                <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active" data-bs-interval="5000">
                            <img src="assets/Carrusel/NIKE-1.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item" data-bs-interval="6000">
                            <img src="assets/Carrusel/NIKE-2.jpg" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                            <img src="assets/Carrusel/NIKE-3.jpg" class="d-block w-100" alt="...">
                        </div>
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true-Brothers
            e"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>

        <br>

        <div class="ropa-box">
            <h2 class="fw-bold" align="center">
                Listado de productos
            </h2>
        </div>

        <br><br>

        <div>
            <?php
            $sentencia = $pdo->prepare("SELECT * FROM tblproductos");
            $sentencia->execute();
            $listaProductos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            //print_r($listaProductos);
            ?>
            <div class="container">
                <div class="row">
                    <?php foreach ($listaProductos as $key => $producto) { ?>
                        <?php if ($key < 8) { ?>
                            <div class="col-md-3 col-sm-6"> <!-- Utiliza las clases de Bootstrap para definir el ancho en diferentes dispositivos -->
                                <div class="card">
                                    <img src="<?php echo $producto['Imagen']; ?>" class="card-img-top" alt="Producto">
                                    <div class="card-body">
                                        <span id="Producto" class="fw-bold"><?php echo $producto['Nombre']; ?></span>
                                        <h5 id="Precio" class="fw-normal card-title">$<?php echo $producto['Precio']; ?></h5>
                                        <?php echo $producto['Descripcion']; ?></p>
                                        <form action="" method="POST">
                                            <input type="text" name="id" id="id" value="<?php echo $producto['ID']; ?>" hidden>
                                            <input type="text" name="nombre" id="nombre" value="<?php echo $producto['Nombre']; ?>" hidden>
                                            <input type="text" name="precio" id="precio" value="<?php echo $producto['Precio']; ?>" hidden>

                                            <label id="Cantidad" for="cantidad" align="center">Cantidad:</label>
                                            <div style="display: flex; align-items: center; justify-content: center;">
                                                <input type="number" name="cantidad" id="cantidad" value="1" min="1" style="margin: 0;">
                                            </div>

                                            <br>

                                            <button type="submit" class="Comprar" name="btnAccion" value="Agregar">Agregar al carrito</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>



        </div>

    </div>

    </div>

    <br><br>

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

</body>

</html>