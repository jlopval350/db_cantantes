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

cabecera("Singers - Delete all 1");
?>

    <form action="borrar-todo-2.php" method="get">
      <p>Are you sure?</p>

      <p>
        <input type="submit" name="borrar" value="Yes">
        <input type="submit" name="borrar" value="No">
      </p>
    </form>

<?php
pie();
?>
