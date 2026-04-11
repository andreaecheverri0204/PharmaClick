<?php
session_start();
if($_SESSION['us_tipo']==2){
?>
<!-- SI ES ADMIN MUESTRA LA PAGINA -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tecnico</title>
</head>
<body>
    <h1>Hola Tecnico</h1>
    <a href="../controlador/Logout.php">Cerrar Sesion</a>
</body>
</html>
<?php
}
/* SI NO ES ADMIN DE NUEVO AL LOGIN*/
else{
    header('Location: ../index.php');
}
?>
