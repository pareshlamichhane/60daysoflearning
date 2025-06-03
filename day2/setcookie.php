<?php
$cookie_name = "name";
$cookie_value = "Paresh Lamichhane";
setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
echo "Cookie named '$cookie_name' is set!";
?>
