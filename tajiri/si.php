<?php
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
