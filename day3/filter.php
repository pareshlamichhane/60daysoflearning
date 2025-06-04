<?php
$int = "200";
$options = array("options" => array("min_range" => 100, "max_range" => 300));
if (filter_var($int, FILTER_VALIDATE_INT, $options)) {
    echo "Integer is within the range.";
} else {
    echo "Integer is out of range.";
}
?>