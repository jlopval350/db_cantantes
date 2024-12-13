<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php
// Archivo: estadisticas.php
require_once "../comunes/biblioteca.php";

session_name("sesiondb");
session_start();

if (!isset($_SESSION["conectado"])) {
    header("Location:../index.php");
    exit;
}

$pdo = conectaDb();
// Generar cabecera de la página
cabecera('Estadísticas de Cantantes');

exportarCantantesAcsv();

pie();
?>
