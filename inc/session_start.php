<?php
ini_set('session.use_strict_mode', '1');
ini_set('session.gc_maxlifetime', 3600);

session_set_cookie_params([
    'samesite' => 'Strict',
    'lifetime' => 3600,
    'httponly' => true,
    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'

]);

session_name('SIV');
session_start();