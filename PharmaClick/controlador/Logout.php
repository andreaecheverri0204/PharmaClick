<?php
session_start();
session_destroy();
//redirecionar login
header('Location: ../index.php');
?>