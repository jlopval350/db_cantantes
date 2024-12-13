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

cabecera("Singers - Modify 1");


// Comprobamos si la base de datos contiene registros
$hayRegistrosOk = false;

$consulta = "SELECT COUNT(*) FROM cantantes";

$resultado = $pdo->query($consulta);
if (!$resultado) {
    print "    <p class=\"aviso\">Error in the query. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
} elseif ($resultado->fetchColumn() == 0) {
    print "    <p class=\"aviso\">No records have been created yet.</p>\n";
} else {
    $hayRegistrosOk = true;
}

// Si todas las comprobaciones han tenido éxito ...
if ($hayRegistrosOk) {
    // Recuperamos todos los registros para mostrarlos en una <table>
    $consulta = "SELECT * FROM cantantes";

    $resultado = $pdo->query($consulta);
    if (!$resultado) {
        print "    <p class=\"aviso\">Error in the query. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } else {
?>
      <p>Specify the record you want to modify:</p>
	<form action="modificar-2.php" method="post">
      <table class="conborde franjas">
        <thead>
          <tr>
            <th>Modify</th>
            <th>ID</th>
            <th>Name</th>
            <th>Genre</th>
            <th>Major Hit</th>
          </tr>
        </thead>
<?php
        foreach ($resultado as $registro) {
            print "        <tr>\n";
            print "          <td class=\"centrado\"><input type=\"radio\" name=\"id\" value=\"$registro[id]\"></td>\n";
            print "          <td>$registro[id]</td>\n";
            print "          <td>$registro[nombre]</td>\n";
            print "          <td>$registro[genero]</td>\n";
            print "          <td>$registro[mayor_exito]</td>\n";
            print "        </tr>\n";
        }
        print "      </table>\n";
        print "\n";
        print "      <p>\n";
        print "        <input type=\"submit\" value=\"Modify record\">\n";
        print "        <input type=\"reset\" value=\"Reset form\">\n";
        print "      </p>\n";
        print "    </form>\n";
    }
}

pie();
?>
