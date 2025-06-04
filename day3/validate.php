<?php
$email = "te@st@example.com";
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "$email is a valid email format.";
} else {
    echo "$email is a invalid email format.";
}
?>