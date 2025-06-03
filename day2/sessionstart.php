<?php
session_start();
$_SESSION["username"] = "paresh";
$_SESSION["role"] = "learner";
echo "Session started and data stored.";
?>