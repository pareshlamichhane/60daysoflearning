<?php
require "App.php";
use App\Greetings as GG;
     $G =  new GG();

     $G->greet();

    function printIterable(iterable $items) {
        foreach ($items as $item) {
            echo $item . "<br>";
        }
    }

    $cpus = ["Intel", "AMD", "nVidia", "Qualcomm", "Apple"];
    echo "<br>List of CPU's in the market<br>";
    printIterable($cpus);
?>