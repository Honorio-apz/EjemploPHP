<?php
$servername = "localhost"; // Nombre del servidor MySQL
$username = "tu_usuario_mysql"; // Nombre de usuario de MySQL
$password = "tu_contraseña_mysql"; // Contraseña de MySQL
$dbname = "nombre_de_tu_base_de_datos"; // Nombre de la base de datos MySQL

// Crea una conexión a la base de datos MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica si la conexión a la base de datos fue exitosa
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error); // Muestra un mensaje de error si la conexión falla
}

// Verifica el método de solicitud HTTP
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true); // Obtiene los datos del usuario enviados como JSON
    $name = $data['name']; // Obtiene el nombre del usuario
    $email = $data['email']; // Obtiene el correo electrónico del usuario

    // Crea una consulta SQL para insertar un nuevo usuario en la tabla "usuarios"
    $sql = "INSERT INTO usuarios (nombre, email) VALUES ('$name', '$email')";

    // Ejecuta la consulta SQL y verifica si fue exitosa
    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("success" => true)); // Devuelve una respuesta JSON indicando que la operación fue exitosa
    } else {
        echo json_encode(array("success" => false)); // Devuelve una respuesta JSON indicando que la operación falló
    }
} else {
    $sql = "SELECT * FROM usuarios"; // Crea una consulta SQL para seleccionar todos los usuarios de la tabla "usuarios"
    $result = $conn->query($sql); // Ejecuta la consulta SQL

    $users = array(); // Crea un array para almacenar los usuarios

    // Verifica si se encontraron usuarios en la base de datos
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $users[] = array("name" => $row["nombre"], "email" => $row["email"]); // Agrega cada usuario encontrado al array de usuarios
        }
    }

    echo json_encode($users); // Devuelve una respuesta JSON con la lista de usuarios
}

$conn->close(); // Cierra la conexión a la base de datos MySQL
?>
