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

cabecera("Singers - Edit 2");

$id = recoge("id");

// Comprobamos el dato recibido
$idOk = false;

if ($id == "") {
    print "    <p class=\"aviso\">No record has been selected.</p>\n";
} else {
    $idOk = true;
}

// Comprobamos que el registro con el id recibido existe en la base de datos
$registroEncontradoOk = false;

if ($idOk) {
    $consulta = "SELECT COUNT(*) FROM cantantes
                 WHERE id = :id";

    $resultado = $pdo->prepare($consulta);
    if (!$resultado) {
        print "    <p class=\"aviso\">Error preparing the query. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } elseif (!$resultado->execute([":id" => $id])) {
        print "    <p class=\"aviso\">Error executing the query. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } elseif ($resultado->fetchColumn() == 0) {
        print "    <p class=\"aviso\">Record not found.</p>\n";
    } else {
        $registroEncontradoOk = true;
    }
}

// Si todas las comprobaciones han tenido éxito ...
if ($idOk && $registroEncontradoOk) {
    // Recuperamos el registro con el id recibido para incluir sus valores en el formulario
    $consulta = "SELECT * FROM cantantes
                 WHERE id = :id";

    $resultado = $pdo->prepare($consulta);
    if (!$resultado) {
        print "    <p class=\"aviso\">Error preparing the query. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } elseif (!$resultado->execute([":id" => $id])) {
        print "    <p class=\"aviso\">Error executing the query. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } else {
        $registro = $resultado->fetch();

    print "<form action=\"modificar-3.php\" method=\"get\">";
    print "      <p>Edit the fields as desired:</p>";

    print "      <table>";
    print "        <tr>";
    print "          <td>Name:</td>";
    print "          <td>$registro[id]</td>";
    print "        </tr>";
    print "        <tr>";
    print "          <td>Name:</td>";
    print "          <td><input type=\"text\" name=\"nombre\" value=\"$registro[nombre]\"></td>";
    print "        </tr>";
    print "        <tr>";
    print "          <td>Genre:</td>";
    print "          <td><input type=\"text\" name=\"genero\" value=\"$registro[genero]\"></td>";
    print "        </tr>";
    print "        <tr>";
    print "          <td>Major Success:</td>";
    print "          <td><input type=\"text\" name=\"mayor_exito\" value=\"$registro[mayor_exito]\"></td>";
    print "        </tr>";
    print "      </table>";
    print "";
    print "      <p>";
    print "        <input type=\"hidden\" name=\"id\" value=\"$id\">";
    print "        <input type=\"submit\" value=\"Update\">";
    print "        <input type=\"reset\" value=\"Reset form\">";
    print "      </p>";
    print "    </form>";
  }
}

pie();
?>
