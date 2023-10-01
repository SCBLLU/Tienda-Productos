<?php
if (isset($_POST['btnAccion'])) {
    if (isset($_POST['id'], $_POST['nombre'], $_POST['precio'], $_POST['cantidad'])) {
        $ID = filter_var($_POST['id'], FILTER_VALIDATE_INT);
        $NOMBRE = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
        $PRECIO = filter_var($_POST['precio'], FILTER_VALIDATE_FLOAT);
        $CANTIDAD = filter_var($_POST['cantidad'], FILTER_VALIDATE_INT);

        if ($ID !== false && $NOMBRE !== false && $PRECIO !== false && $CANTIDAD !== false) {
            // Los datos son válidos, puedes continuar con el procesamiento
            switch ($_POST['btnAccion']) {
                case 'Agregar':
                    // Agregar producto al carrito
                    $producto = array(
                        'ID' => $ID,
                        'NOMBRE' => $NOMBRE,
                        'PRECIO' => $PRECIO,
                        'CANTIDAD' => $CANTIDAD
                    );
                    // Verificar si ya existe el producto en el carrito y actualizar la cantidad si es necesario
                    $indice = -1;
                    if (isset($_SESSION['CARRITO'])) {
                        foreach ($_SESSION['CARRITO'] as $key => $prod) {
                            if ($prod['ID'] === $ID) {
                                $indice = $key;
                                break;
                            }
                        }
                    }

                    if ($indice !== -1) {
                        $_SESSION['CARRITO'][$indice]['CANTIDAD'] += $CANTIDAD;
                    } else {
                        $_SESSION['CARRITO'][] = $producto;
                    }
                    break;
                case 'Eliminar':
                    // Verificar si se presionó un botón de eliminar específico
                    foreach ($_SESSION['CARRITO'] as $key => $producto) {
                        $eliminarBtnName = 'btnEliminar_' . $producto['ID'];
                        if (isset($_POST[$eliminarBtnName]) && $_POST[$eliminarBtnName] === 'Eliminar') {
                            // Eliminar el producto del carrito
                            unset($_SESSION['CARRITO'][$key]);
                            break; // Salir del bucle una vez que se elimine el producto
                        }
                    }
                    break;
                default:
                    // Otras acciones (si es necesario)
                    break;
            }
        } else {
            $mensaje = "Los datos ingresados no son válidos. Por favor, verifique la información.";
        }
    } else {
        $mensaje = "No se proporcionaron todos los datos necesarios.";
    }
}
