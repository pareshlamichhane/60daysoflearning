<?php include 'header.php'; ?>

<h2>Time</h2>

<p>We provide you your real-time info:</p>

<?php
date_default_timezone_set("Asia/Kathmandu");
echo "Date: " . date("Y-m-d") . "<br>";
echo "Time: " . date("H:i:s") . "<br>";
echo "Day: " . date("l") . "<br>";
?>

<?php include 'footer.php'; ?>
