<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "RegistroUsuario";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);
    $name = $data['name'];
    $email = $data['email'];

    $sql = "INSERT INTO usuarios (nombre, email) VALUES ('$name', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("success" => true));
    } else {
        echo json_encode(array("success" => false));
    }
} else {
    $sql = "SELECT * FROM usuarios";
    $result = $conn->query($sql);
    $users = array();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $users[] = array("name" => $row["nombre"], "email" => $row["email"]);
        }
    }

    echo json_encode($users);
}

$conn->close();
?>
