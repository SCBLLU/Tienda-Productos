<?php
// Iniciar la sesión si aún no está iniciada
session_start();

// Destruir la sesión
session_destroy();

// Redirigir al usuario a la página de inicio o a donde desees
header("Location: index.php");
exit;
