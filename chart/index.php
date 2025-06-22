<?php 


$option_value = `a:5:{i:0;a:3:{s:3:"day";s:3:"One";s:7:"summary";s:196:"📚 Learned:
✅ Modular PHP with include & require
⏰ Dynamic dates with date() & timezone handling
Didn’t code much today, but kept the learning streak alive!
Small steps > No steps 💪";s:9:"timestamp";s:19:"2025-06-10 22:00:33";}i:1;a:3:{s:3:"day";s:3:"Two";s:7:"summary";s:302:"#LSPPDay2

📘 Learnt about Cookies & Sessions in PHP:

✅ setcookie(),
✅ session_start(),
✅ session_destroy()

Tested with:
✔️ setcookie.php, getcookie.php
✔️ sessionstart.php, sessionread.php, sessiondestroy.php

#60DaysOfLearning2025 
@lftechnology
 #LearningWithLeapfrog";s:9:"timestamp";s:19:"2025-06-16 21:59:52";}i:2;a:3:{s:3:"day";s:5:"Three";s:7:"summary";s:307:"#LSPPDay3

🔎 Learnt PHP Filters, Callback Functions & JSON today!

✔️ filter_var() with sanitize & validate  
✔️ Advanced filter options (min/max range)  
✔️ Callbacks using array_map()  
✔️ JSON encode/decode in PHP

#60DaysOfLearning2025 
@lftechnology
 #LearningWithLeapfrog";s:9:"timestamp";s:19:"2025-06-16 22:00:04";}i:3;a:3:{s:3:"day";s:4:"Four";s:7:"summary";s:247:"#LSPPDay4

🎯 Finished PHP Advanced and started PHP OOP  today!

✅ try-catch & throw  
✅ Classes, Objects, Constructors & Destructors  
✅ Access Modifiers & Inheritance

#60DaysOfLearning2025 
@lftechnology
 #LearningWithLeapfrog";s:9:"timestamp";s:19:"2025-06-16 22:00:13";}i:4;a:3:{s:3:"day";s:4:"Five";s:7:"summary";s:284:"#LSPPDay5

📘 Continued OOP in PHP:
🔹 const for defining class constants
🔹 abstract classes and methods
🔹 interface for enforcing structure
🔹 trait for reusable code
🔹 static properties and methods

#60DaysOfLearning2025 #LearningWithLeapfrog 
@lftechnology";s:9:"timestamp";s:19:"2025-06-16 22:00:21";}}`;

var_dump($option_value);
function is_serialized($data) {
    // If it isn't a string, it isn't serialized
    if (!is_string($data)) {
        return false;
    }
    
    // Try to unserialize it
    $data = trim($data);
    if ('N;' == $data || 'b:0;' == $data) {
        return true;
    }
    
    $length = strlen($data);
    $end = false;
    
    if ($length < 4 || ':' !== $data[1]) {
        return false;
    }
    
    $char = $data[0];
    $string = substr($data, 2, -1);
    
    switch ($char) {
        case 'a': // array
            return preg_match('/^[a-zA-Z0-9_]+$/', $string);
        case 's': // string
            return true;
        case 'b': // boolean
            return true;
        default:
            return false;
    }
}

if (is_serialized($option_value)) {
        // Deserialize the value into a PHP array
        $logs = unserialize($option_value);
    }
    var_dump($logs);
// $logs = unserialize($option_value);
// $days = array_column($logs, 'day');
// $counts = array_count_values($days);

