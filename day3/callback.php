<?php
function callBackFunction($item) {
    return strlen($item);
}
$items = ["CPU", "Keyboard", "Mouse"];
$lengths = array_map("callBackFunction", $items);
print_r($lengths);
?>