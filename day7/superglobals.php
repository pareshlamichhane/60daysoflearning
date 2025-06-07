<?php
// PHP Superglobals Example
echo "Server Name: " . $_SERVER['SERVER_NAME'] . "<br>";
echo "Request Method: " . $_SERVER['REQUEST_METHOD'] . "<br>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"] ?? '';
    echo "Hello, " . htmlspecialchars($name);
} else {
    ?>
    <form method="post" action="">
        Name: <input type="text" name="name"><br>
        <input type="submit" value="Submit">
    </form>
    <?php
}
?>