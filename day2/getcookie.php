<?php
if(isset($_COOKIE["name"])) {
  echo "Welcome back, " . $_COOKIE["name"];
} else {
  echo "Cookie is not set!";
}
?>