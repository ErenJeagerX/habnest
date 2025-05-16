<?php
ini_set('session.use_only_cookies', true);
ini_set('session.use_strict_mode', true);

session_set_cookie_params([
    'lifetime' => 1800,
    'secure' => true,
    'httponly' => true 
]);

session_start();

if(!isset($_SESSION['last_regeneration_time'])) {
    session_regenerate_id();
    $_SESSION['last_regeneration_time'] = time();
} else {
    $interval = 1800; // 30 minutes
    if(time() - $_SESSION['last_regeneration_time'] >= $interval) {
        session_regenerate_id();
        $_SESSION['last_regeneration_time'] = time();
    }
}