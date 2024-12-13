<?php
/**
 * @author   
 * Bartolomé Sintes Marco - bartolome.sintes+mclibre@gmail.com
 * @license   
 * https://www.gnu.org/licenses/agpl-3.0.txt AGPL 3 or later
 * @link   
 * https://www.mclibre.org
 */

// Load specific database library used

function recoge($key, $type = "", $default = null, $allowed = null)
{
    if (!is_string($key) && !is_int($key) || $key == "") {
        trigger_error("Function recoge(): Argument #1 (\$key) must be a non-empty string or an integer", E_USER_ERROR);
    } elseif ($type !== "" && $type !== []) {
        trigger_error("Function recoge(): Argument #2 (\$type) is optional, but if provided, it must be an empty array or an empty string", E_USER_ERROR);
    } elseif (isset($default) && !is_string($default)) {
        trigger_error("Function recoge(): Argument #3 (\$default) is optional, but if provided, it must be a string", E_USER_ERROR);
    } elseif (isset($allowed) && !is_array($allowed)) {
        trigger_error("Function recoge(): Argument #4 (\$allowed) is optional, but if provided, it must be an array of strings", E_USER_ERROR);
    } elseif (is_array($allowed) && array_filter($allowed, function ($value) { return !is_string($value); })) {
        trigger_error("Function recoge(): Argument #4 (\$allowed) is optional, but if provided, it must be an array of strings", E_USER_ERROR);
    } elseif (!isset($default) && isset($allowed) && !in_array("", $allowed)) {
        trigger_error("Function recoge(): If argument #3 (\$default) is not set and argument #4 (\$allowed) is set, the empty string must be included in the \$allowed array", E_USER_ERROR);
    } elseif (isset($default, $allowed) && !in_array($default, $allowed)) {
        trigger_error("Function recoge(): If arguments #3 (\$default) and #4 (\$allowed) are set, the \$default string must be included in the \$allowed array", E_USER_ERROR);
    }

    if ($type == "") {
        if (!isset($_REQUEST[$key]) || (is_array($_REQUEST[$key]) != is_array($type))) {
            $tmp = "";
        } else {
            $tmp = trim(htmlspecialchars($_REQUEST[$key]));
        }
        if ($tmp == "" && !isset($allowed) || isset($allowed) && !in_array($tmp, $allowed)) {
            $tmp = $default ?? "";
        }
    } else {
        if (!isset($_REQUEST[$key]) || (is_array($_REQUEST[$key]) != is_array($type))) {
            $tmp = [];
        } else {
            $tmp = $_REQUEST[$key];
            array_walk_recursive($tmp, function (&$value) use ($default, $allowed) {
                $value = trim(htmlspecialchars($value));
                if ($value == "" && !isset($allowed) || isset($allowed) && !in_array($value, $allowed)) {
                    $value = $default ?? "";
                }
            });
        }
    }
    return $tmp;
}

/* 
This function outputs the header of web pages
IF SESSION IS ACTIVE: Displays the menu of database functions + LOG OUT option
IF SESSION IS NOT ACTIVE: Displays only the LOGIN menu 
*/
function cabecera($texto)
{
    print "<!DOCTYPE html>\n";
    print "<html lang=\"es\">\n";
    print "<head>\n";
    print "  <meta charset=\"utf-8\">\n";
    print "  <title>\n";
    print "    $texto. Databases (3) 2. Databases (3). Exercises. PHP. Bartolomé Sintes Marco. www.mclibre.org\n";
    print "  </title>\n";
    print "  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\n";
    print "  <link rel=\"stylesheet\" href=\"mclibre-php-proyectos.css\" title=\"Color\">\n";
    
    print '
    <style>
    body {
        background-color: #f0f0f0; /* Un tono suave de fondo para la temática musical */
        font-family: \'Arial\', sans-serif; /* Fuente legible para la aplicación de música */
        color: #333; /* Color de texto para un mejor contraste */
        margin: 0;
        padding: 20px;
    }

    h1, h2, h3 {
        color: #007BFF; /* Un color azul que puede simbolizar música o relajación */
    }

    a {
        color: #007BFF; /* Color azul en los enlaces para que resalten */
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline; /* Añade un efecto de subrayado al pasar el cursor por los enlaces */
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .navbar {
        background-color: #007BFF;
        color: white;
        padding: 10px;
        text-align: center;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .navbar a {
        color: white;
        margin: 0 15px;
    }

    .navbar a:hover {
        color: #ddd;
    }

    .button {
        background-color: #007BFF;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .button:hover {
        background-color: #0056b3;
    }

    .footer {
        margin-top: 20px;
        text-align: center;
        font-size: 12px;
        color: #555;
    }
    table {
        border-collapse: collapse;
        width: 100%;
        text-align: center;
        font-family: Arial, sans-serif;
        border: 1px solid #ccc;
    }

    thead tr {
        background-color: #f4a261;
        color: white;
    }

    th, td {
        border: 1px solid #ccc;
        padding: 8px;
    }

    tbody tr:nth-child(odd) {
        background-color: #fff5e6;
    }

    tbody tr:nth-child(even) {
        background-color: #fff;
    }
</style>';
    
    print "</head>\n";
    print "\n";
    print "<body>\n";
    print "  <header>\n";
    print "    <h1>Databases (3) 2 - $texto</h1>\n";
    print "\n";
    print "    <nav>\n";
    print "      <ul>\n";
    if (!isset($_SESSION["conectado"])) {
      
            print "        <li><a href=\"login-1.php\">Log In</a></li>\n";
       
        } 
       
     else {
           
            print "        <li><a href=\"insertar-1.php\">Add Record</a></li>\n";
            print "        <li><a href=\"listar.php\">List</a></li>\n";
            print "        <li><a href=\"borrar-1.php\">Delete</a></li>\n";
            print "        <li><a href=\"buscar-1.php\">Search</a></li>\n";
            print "        <li><a href=\"modificar-1.php\">Edit</a></li>\n";
            print "        <li><a href=\"borrar-todo-1.php\">Delete All</a></li>\n";
            print "        <li><a href=\"estadistica.php\">Statistics</a></li>\n";
            print "        <li><a href=\"buscar-genero1.php\">Search Genre</a></li>\n";
            print "        <li><a href=\"exportar.php\">Export Data</a></li>\n";
             print "        <li><a href=\"../logout.php\">Log Out</a></li>\n";
        } 
    print "      </ul>\n";
    print "    </nav>\n";
    print "  </header>\n";
    print "\n";
    print "  <main>\n";
}

function pie()
{
    print "  </main>\n";
    print "\n";
    print "  <footer>\n";
    print "    <p class=\"licencia\">\n";
    print "      The PHP program generating this page is distributed under the\n";
    print "      <a rel=\"license\" href=\"https://www.gnu.org/licenses/agpl-3.0.txt\">AGPL 3 or later license</a>.\n";
    print "    </p>\n";
    print "  </footer>\n";
    print "</body>\n";
    print "</html>\n";
}

// DATABASE FUNCTIONS
function conectaDb()
{
    

    try {
        $tmp = new PDO("mysql:host=localhost;dbname=db_iaw_jjlv;charset=utf8mb4", "josejulio", "usuario2020");
       return $tmp;
    }  catch (PDOException $e) {
        print "    <p class=\"aviso\">Error: Unable to connect to the database. {$e->getMessage()}</p>\n";
    } 

}

// MYSQL: Delete and create database and tables

function borraTodo()
{
    global $pdo;

    print "    <p>Database Management System: MySQL.</p>\n";
    print "\n";

    $consulta = "DROP DATABASE IF EXISTS db_iaw_jjlv";

    if (!$pdo->query($consulta)) {
        print "    <p class=\"aviso\">Error deleting the database. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } else {
        print "    <p>Database deleted successfully (if it existed).</p>\n";
    }
    print "\n";

    $consulta = "CREATE DATABASE db_iaw_jjlv
                 CHARACTER SET utf8mb4
                 COLLATE utf8mb4_unicode_ci";

    if (!$pdo->query($consulta)) {
        print "    <p class=\"aviso\">Error creating the database. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
    } else {
        print "    <p>Database created successfully.</p>\n";
        print "\n";

        $consulta = "USE db_iaw_jjlv";

        if (!$pdo->query($consulta)) {
            print "    <p class=\"aviso\">Query error. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
        } else {
            print "    <p>Database selected successfully.</p>\n";
            print "\n";

            $consulta = "CREATE TABLE cantantes (
                         id INT AUTO_INCREMENT PRIMARY KEY,
                         nombre VARCHAR(50) NOT NULL,
                         genero VARCHAR(50) NOT NULL,
                         mayor_exito VARCHAR(50) NOT NULL
                         )";

            if (!$pdo->query($consulta)) {
                print "    <p class=\"aviso\">Error creating the table. SQLSTATE[{$pdo->errorCode()}]: {$pdo->errorInfo()[2]}</p>\n";
            } else {
                print "    <p>Table created successfully.</p>\n";
            }
        }
    }
}

function encripta($cadena)
{
    

    return hash("sha256", $cadena);
}


function obtenerEstadisticasCantantes() {
    // Datos de conexión a la base de datos
    $servidor = "localhost";
    $usuario = "josejulio";
    $contrasena = "usuario2020"; // Cambia esto si tienes una contraseña para tu base de datos
    $baseDeDatos = "db_iaw_jjlv";

    // Crear la conexión
    $conexion = new mysqli($servidor, $usuario, $contrasena, $baseDeDatos);

    // Verificar si la conexión fue exitosa
    if ($conexion->connect_error) {
        die("Conection error: " . $conexion->connect_error);
    }

    // Consulta para obtener el número total de cantantes
    $consultaTotal = "SELECT COUNT(*) AS total_cantantes FROM cantantes";
    $resultadoTotal = $conexion->query($consultaTotal);

    if ($resultadoTotal && $resultadoTotal->num_rows > 0) {
        $filaTotal = $resultadoTotal->fetch_assoc();
        $totalCantantes = $filaTotal['total_cantantes'];
    } else {
        $totalCantantes = 0;
    }

    // Consulta para obtener el género con más cantantes
    $consultaGenero = "SELECT genero, COUNT(*) AS cantidad FROM cantantes GROUP BY genero ORDER BY cantidad DESC LIMIT 1";
    $resultadoGenero = $conexion->query($consultaGenero);

    if ($resultadoGenero && $resultadoGenero->num_rows > 0) {
        $filaGenero = $resultadoGenero->fetch_assoc();
        $generoMasPopular = $filaGenero['genero'];
        $cantidadGenero = $filaGenero['cantidad'];
    } else {
        $generoMasPopular = "N/A";
        $cantidadGenero = 0;
    }

    // Cerrar la conexión
    $conexion->close();

    // Mostrar los resultados
    print "<p>Total amount of singers: " . $totalCantantes . "</p>";
    print "<p>Genres with more singers: " . $generoMasPopular . " (" . $cantidadGenero . " singers)</p>";
}

function exportarCantantesAcsv() {
    // Configuración de la conexión a la base de datos
    $host = 'localhost'; // Ajusta el host según tu configuración
    $db = 'db_iaw_jjlv';
    $user = 'josejulio'; // Cambia 'tu_usuario' por tu nombre de usuario de la base de datos
    $pass = 'usuario2020'; // Cambia 'tu_contraseña' por tu contraseña
    
    // Conexión a la base de datos
    $conn = new mysqli($host, $user, $pass, $db);
    
    // Verifica la conexión
    if ($conn->connect_error) {
        die("Connection error: " . $conn->connect_error);
    }
    
    // Consulta para obtener los datos de la tabla cantantes
    $sql = "SELECT id, nombre, genero, mayor_exito FROM cantantes";
    $result = $conn->query($sql);
    
    // Verifica que se obtuvieron resultados
    if ($result->num_rows > 0) {
        // Abrimos un archivo CSV
        $filename = "../comunes/cantantes_export.csv";
        $fp = fopen($filename, 'w');
        
        if (!$fp) {
            die("Error opening the CSV file for writing.");
        }
        
        // Escribir el encabezado
        fputcsv($fp, array('ID', 'Nombre', 'Género', 'Mayor Éxito'));
        
        // Leer y escribir los datos en el CSV
        while ($row = $result->fetch_assoc()) {
            if (!fputcsv($fp, $row)) {
                die("Error writing data in the CSV file.");
            }
        }
        
        fclose($fp);
        
        echo "Data exported successfully to cantantes_export.csv";
    } else {
        echo "No data was found in the table cantantes.";
    }
    
    // Cerrar la conexión
    $conn->close();
}



