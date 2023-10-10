<?php
// pripojeni databaze
$servername = "sql6.webzdarma.cz";
$username = "migmigmanwzc7578";
$password = "QKi@^#rXrbf!Uv7U";
$dbname = "migmigmanwzc7578";

$conn = new mysqli($servername, $username, $password, $dbname);

// check pripojeni databaze
if ($conn->connect_error) {
    die("database error: " . $conn->connect_error);
}

// smazani obrazku
if (isset($_POST["delete"])) {
    $image_id = $_POST["image_id"];

    // ziskani id obrazku k smazani
    $sql = "SELECT image_data FROM images WHERE id = $image_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // smazani obrazku
        $delete_sql = "DELETE FROM images WHERE id = $image_id";
        if ($conn->query($delete_sql) === TRUE) {
            header('Location: http://bagrnenitobogan.wz.cz');
        } else {
            echo "Error deleting image: " . $conn->error;
        }
    } else {
        echo "Image not found.";
    }
}

$conn->close();
?>
