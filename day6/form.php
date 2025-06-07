<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $email = "";
    $nameErr = $emailErr = "";

    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $name = htmlspecialchars($_POST["name"]);
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        } else {
            $email = htmlspecialchars($_POST["email"]);
        }
    }

    if (!$nameErr && !$emailErr) {
        echo "Form Submitted Successfully!<br>";
        echo "Name: $name<br>";
        echo "Email: $email";
    } else {
        echo $nameErr . "<br>" . $emailErr;
    }
} else {
    ?>
    <form method="post" action="">
        Name: <input type="text" name="name"><br><br>
        Email: <input type="text" name="email"><br><br>
        <input type="submit">
    </form>
    <?php
}
?>