<?php
/**
 * Script para modificar registros en la base de datos de personas.
 * 
 * Autor: Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * Licencia: AGPL 3 o posterior - https://www.gnu.org/licenses/agpl-3.0.txt
 * Web: https://www.mclibre.org
 */

require_once "../comunes/biblioteca.php";

// Iniciar sesión
session_name("sesiondb");
session_start();

// Redirigir a la página de inicio si no hay sesión activa
if (!isset($_SESSION["conectado"])) {
    header("Location:../index.php");
    exit;
}

// Conectar a la base de datos
$pdo = conectaDb();

// Encabezado de la página
cabecera("Singers - Edit");

// Obtener los datos del formulario
$id        = recoge("id");
$nombre    = recoge("nombre");
$genero = recoge("genero");
$mayor_exito  = recoge("mayor_exito");

// Validar el ID recibido
if (empty($id)) {
    print "<p class=\"aviso\">No record has been selected.</p>\n";
} else {
    $idValido = true;
}

// Validar que al menos uno de los campos está relleno
$camposNoVacios = false;

if (empty($nombre) && empty($genero) && empty($mayor_exito)) {
    print "<p class=\"aviso\">At least one field must be filled. No record was saved.</p>\n";
} else {
    $camposNoVacios = true;
}

// Verificar si el registro con el ID existe
$registroEncontrado = false;

if ($idValido && $camposNoVacios) {
    $consulta = "SELECT COUNT(*) FROM cantantes WHERE id = :id";

    $resultado = $pdo->prepare($consulta);
    if (!$resultado) {
        print "<p class=\"aviso\">Error preparing the query. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } elseif (!$resultado->execute([":id" => $id])) {
        print "<p class=\"aviso\">Error executing the query. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } elseif ($resultado->fetchColumn() == 0) {
        print "<p class=\"aviso\">Record not found.</p>\n";
    } else {
        $registroEncontrado = true;
    }
}

// Si todas las validaciones son correctas, actualizar el registro
if ($idValido && $camposNoVacios && $registroEncontrado) {
    $consulta = "UPDATE cantantes
                 SET nombre = :nombre, genero = :genero, mayor_exito = :mayor_exito
                 WHERE id = :id";

    $resultado = $pdo->prepare($consulta);
    if (!$resultado) {
        print "<p class=\"aviso\">Error preparing the query. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } elseif (!$resultado->execute([
        ":id" => $id,
        ":nombre" => $nombre, 
        ":genero" => $genero, 
        ":mayor_exito" => $mayor_exito
    ])) {
        print "<p class=\"aviso\">Error executing the query. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } else {
        print "<p>Record successfully updated.</p>\n";
    }
}

// Mostrar pie de página
pie();
?>
