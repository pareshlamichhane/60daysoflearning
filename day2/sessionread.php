<?php
session_start();
echo "Username: " . $_SESSION["username"] . "<br>";
echo "Role: " . $_SESSION["role"];
?>