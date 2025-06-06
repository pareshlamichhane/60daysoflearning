<?php
trait Hello {
    public function Hello() {
        echo "Hello from trait!<br>";
    }
}

abstract class Shape {
    abstract public function area();
}

class Circle extends Shape {
    use Hello;
    const PI = 3.14;
    public static $count = 0;

    public function __construct(public $radius) {
        self::$count++;
    }

    public function area() {
        return self::PI * $this->radius * $this->radius;
    }

    public static function getCount() {
        return self::$count;
    }
}

$c1 = new Circle(10);
$c1->Hello();
echo "Area of Circle 1: " . $c1->area() . "<br>";

$c2 = new Circle(20);
echo "Area of Circle 2: " . $c2->area() . "<br>";
echo "Total Circles: " . Circle::getCount() . "<br>";
?>