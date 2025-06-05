<?php
// Parent class
class Person {
    public $name;
    protected $email;
    private $age;

    // Constructor
    public function __construct($name, $email, $age) {
        $this->name = $name;
        $this->email = $email;
        $this->age = $age;
        echo "Person object created.<br>";
    }

    // Public method
    public function introduce() {
        return "Hi, I'm $this->name. Contact: $this->email<br>";
    }

    // Protected method
    protected function getEmail() {
        return $this->email;
    }

    // Private method
    private function getAge() {
        return $this->age;
    }

    // Destructor
    public function __destruct() {
        echo "Person object destroyed.<br>";
    }
}

// Child class
class Student extends Person {
    public $studentId;

    public function __construct($name, $email, $age, $studentId) {
        parent::__construct($name, $email, $age);
        $this->studentId = $studentId;
        echo "Student object created.<br>";
    }

    public function getDetails() {
        return $this->introduce() . "Student ID: $this->studentId<br>";
    }
}

// Create object
$student = new Student("Paresh", "pareshlamichhane@gmail.com", 22, "ST12345");
echo $student->getDetails();
?>