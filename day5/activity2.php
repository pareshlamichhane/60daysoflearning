<?php
interface Logger {
    public function log($msg);
}

trait Timestamps {
    public function createdAt() {
        return date("Y-m-d H:i:s");
    }
}

abstract class User {
    abstract public function getRole();
}

class Admin extends User implements Logger {
    use Timestamps;

    const ROLE = "Admin";
    public static $adminCount = 0;

    public function __construct(public string $name) {
        self::$adminCount++;
        echo "Admin created: {$this->name} (" . $this->createdAt() . ")<br>";
    }

    public function getRole() {
        return self::ROLE;
    }

    public function log($msg) {
        echo "[LOG] {$msg}<br>";
    }

    public static function getAdminCount() {
        return self::$adminCount;
    }
}

$admin1 = new Admin("Paresh");
$admin1->log("First admin created.");
echo "Role: " . $admin1->getRole() . "<br>";

$admin2 = new Admin("Hserap");
echo "Total Admins: " . Admin::getAdminCount() . "<br>";
?>