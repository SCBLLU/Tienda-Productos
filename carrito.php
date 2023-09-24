<?php

    session_start(); //Uso de variables de sesion
    $mensaje="";

    if(isset($_POST['btnAccion'])){

        switch($_POST['btnAccion']){

            case 'Agregar':

                if(is_numeric($_POST['id'])){
                    $ID=$_POST['id'];
                    $mensaje="Id correcto".$ID."<br/>";
                }else{ $mensaje="UPS, Id Incorrecto".$ID."<br/>";}

                if(is_string($_POST['nombre'])){
                    $NOMBRE=$_POST['nombre'];
                    $mensaje="Nombre correcto".$NOMBRE."<br/>";
                }else{ $mensaje="UPS, Nombre Incorrecto"."<br/>"; break;}

                if(is_numeric($_POST['precio'])){
                    $PRECIO=$_POST['precio'];
                    $mensaje="Precio correcto".$PRECIO."<br/>";
                }else{ $mensaje="UPS, Precio Incorrecto"."<br/>"; break;}

                if(is_numeric($_POST['cantidad'])){
                    $CANTIDAD=$_POST['cantidad'];
                    $mensaje="Cantidad correcta".$CANTIDAD."<br/>";
                }else{ $mensaje="UPS, Cantidad Incorrecta"."<br/>"; break;}

            if(!isset($_SESSION['CARRITO'])){ //Si no existe variable de sesion
                // recupera informacion del producto
                $producto=array( // agregar esa info en la variable producto
                    'ID'=>$ID,
                    'NOMBRE'=>$NOMBRE,
                    'CANTIDAD'=>$CANTIDAD,
                    'PRECIO'=>$PRECIO
                );
                $_SESSION['CARRITO'][0]=$producto;//agregar la info a la primera casilla del arreglo.
                $mensaje="Producto agregado al carrito...";  
            }else{
                // EVITAR QUE SE REPITA EL MISMO PRODUCTO EN EL CARRITO
                $idProductos=array_column($_SESSION['CARRITO'],"ID");
                if (in_array($ID, $idProductos)){
                        $mensaje="El producto ya ha sido seleccionado";
                }else{
                // Si existe algo en el producto, contabilizara la cantidad de productos
                //permitira depositar mas productos en el carrito de compras
                $numerpProductos=count($_SESSION['CARRITO']);
                $producto=array( // agregar esa info en la variable producto
                    'ID'=>$ID,
                    'NOMBRE'=>$NOMBRE,
                    'CANTIDAD'=>$CANTIDAD,
                    'PRECIO'=>$PRECIO
                );
                // La info se almacena en la misma variable de sesion y luego se pone el numero de elementos
                $_SESSION['CARRITO'][$numerpProductos]=$producto;   
                $mensaje="Producto agregado al carrito..."; 
            }
            //$mensaje=print_r($_SESSION['CARRITO'], true);
            }
            break;
            case 'Eliminar':
                $ID='ID';
                if (is_numeric($_POST['id'])){
                    $ID=$_POST['id'];
                    
                        foreach($_SESSION['CARRITO'] as $indice=>$producto){
                            if($producto['ID']==$ID){
                                unset($_SESSION['CARRITO'][$indice]);
                                //echo "<script>alert('Elemento borrado...')</script>";
                            }   
                        }
                    }else{ $mensaje="UPS, Id Incorrecto"."<br/>";}
            break;
            }
        }
