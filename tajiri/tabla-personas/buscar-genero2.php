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

cabecera("Genre - Search");

$genero = recoge("genero");

// Comprobamos los datos recibidos procedentes de un formulario
$generoOk = false;
if ($genero == "") {
    print "<p class=\"aviso\">The provided name is empty.</p>\n";
} else {
    $generoOk = true;
}

// Comprobamos si existen registros con las condiciones de búsqueda recibidas
$registrosEncontradosOk = false;

if ($generoOk) {
    $consulta = "SELECT COUNT(*) FROM cantantes
                 WHERE genero = :genero;";

    $resultado = $pdo->prepare($consulta);
    if (!$resultado) {
        print "    <p class=\"aviso\">Error preparing the query. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } elseif (!$resultado->execute([":genero" => $genero])) {
        print "    <p class=\"aviso\">Error executing the query. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } elseif ($resultado->fetchColumn() == 0) {
        print "    <p class=\"aviso\">No records found.</p>\n";
    } else {
        $registrosEncontradosOk = true;
    }
}

// Si todas las comprobaciones han tenido éxito ...
if ($generoOk && $registrosEncontradosOk) {
    // Seleccionamos todos los registros con las condiciones de búsqueda recibidas
    $consulta = "SELECT * FROM cantantes
                 WHERE genero = :genero";

    $resultado = $pdo->prepare($consulta);
    if (!$resultado) {
        print "    <p class=\"aviso\">Error preparing the query. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } elseif (!$resultado->execute([":genero" => $genero])) {
        print "    <p class=\"aviso\">Error executing the query. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } else {
?>
      <p>Registros encontrados:</p>

      <table class="conborde franjas">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Genre</th>
            <th>Major Hit</th>
          </tr>
        </thead>
<?php
        foreach ($resultado as $registro) {
            print "        <tr>\n";
            print "          <td>$registro[id]</td>\n";
            print "          <td>$registro[nombre]</td>\n";
            print "          <td>$registro[genero]</td>\n";
            print "          <td>$registro[mayor_exito]</td>\n";
            print "        </tr>\n";
        }
        print "      </table>\n";
    }
}

pie();