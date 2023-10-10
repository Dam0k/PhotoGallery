<!DOCTYPE html>
<html>
<head>
    <title>Photo gallery</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Photo gallery</h1>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <label for="image">Choose an image:</label>
        <input type="file" name="image" id="image" required>
        <br>
        <label for="caption">Image caption:</label>
        <input type="text" name="caption" id="caption" required>
        <br>
        <input type="submit" name="submit" value="Upload image">
    </form>
    
</body>
</html>

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

// nahrani obrazku
if (isset($_POST["submit"])) {
    $caption = $_POST["caption"];
    
    $image = addslashes(file_get_contents($_FILES["image"]["tmp_name"]));
    
    $sql = "INSERT INTO images (caption, image_data) VALUES ('$caption', '$image')";

    if ($conn->query($sql) === TRUE) {
        echo "Image uploaded!";
    } else {
        echo "Image upload error: " . $conn->error;
    }
}

// zobrazeni obrazku
$sql = "SELECT * FROM images";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<p>' . $row['caption'] . '</p>';
        echo '<img src="data:image/jpeg;base64,'.base64_encode($row['image_data']).'" alt="' . $row['caption'] . '">';
         // tlactiko pro smazani
        echo '<form action="delete.php" method="post">';
        echo '<input type="hidden" name="image_id" value="' . $row['id'] . '">';
        echo '<input type="submit" name="delete" id="delete" value="Delete">';
        echo '</form>';
    }   
} else {
    echo "There are no pictures. Yet...";
}

$conn->close();
?>
