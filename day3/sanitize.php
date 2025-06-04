<?php
$email = "paresh@gmail.com";
$sanitized = filter_var($email, FILTER_SANITIZE_EMAIL);
echo "Sanitized Email: " . $sanitized;
?>