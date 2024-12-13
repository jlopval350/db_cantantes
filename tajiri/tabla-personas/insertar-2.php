<?php
/**
 * @author    Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   https://www.gnu.org/licenses/agpl-3.0.txt AGPL 3 or later
 * @link      https://www.mclibre.org
 */

require_once "../comunes/biblioteca.php";

session_name("sesiondb");
session_start();

if (!isset($_SESSION["conectado"])) {
    header("Location:../index.php");
    exit;
}

$pdo = conectaDb();

cabecera("Singers - Add");

$nombre = recoge("nombre");
$genero = recoge("genero");
$mayor_exito = recoge("mayor_exito");

// Comprobamos que no se intenta crear un registro vacío
$registroNoVacioOk = false;

if ($nombre == "" && $genero == "" && $mayor_exito == "") {
    print "    <p class=\"aviso\">You must fill out at least one field. The record has not been saved.</p>\n";
    print "\n";
} else {
    $registroNoVacioOk = true;
}

// Comprobamos que no se intenta crear un registro idéntico a uno que ya existe
$registroDistintoOk = false;

if ($registroNoVacioOk) {
    $consulta = "SELECT COUNT(*) FROM cantantes
                 WHERE nombre = :nombre
                 AND genero = :genero
                 AND mayor_exito = :mayor_exito";

    $resultado = $pdo->prepare($consulta);
    if (!$resultado) {
        print "    <p class=\"aviso\">Error preparing the query. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } elseif (!$resultado->execute([":nombre" => $nombre, ":genero" => $genero, ":mayor_exito" => $mayor_exito])) {
        print "    <p class=\"aviso\">Error executing the query. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } elseif ($resultado->fetchColumn() > 0) {
        print "    <p class=\"aviso\">The record already exists.</p>\n";
    } else {
        $registroDistintoOk = true;
    }
}

// Si todas las comprobaciones han tenido éxito ...
if ($registroNoVacioOk && $registroDistintoOk) {
    // Insertamos el registro en la tabla
    $consulta = "INSERT INTO cantantes
                 (nombre, genero, mayor_exito)
                 VALUES (:nombre, :genero, :mayor_exito)";

    $resultado = $pdo->prepare($consulta);
    if (!$resultado) {
        print "    <p class=\"aviso\">Error preparing the query. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } elseif (!$resultado->execute([":nombre" => $nombre, ":genero" => $genero, ":mayor_exito" => $mayor_exito])) {
        print "    <p class=\"aviso\">Error executing the query. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } else {
        print "    <p>Record created successfully.</p>\n";
    }
}

pie();
