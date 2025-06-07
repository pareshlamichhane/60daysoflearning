<?php
// PHP Regex Examples
$pattern = "/\bdog\b/i";
$text = "A quick brown fox jumps over the lazy dog.";
if (preg_match($pattern, $text)) {
    echo "Match found!<br>";
} else {
    echo "No match found.<br>";
}

$pattern2 = "/[0-9]{3}/";
$text2 = "My number is 123456.";
preg_match_all($pattern2, $text2, $matches);
var_dump($matches);
?>