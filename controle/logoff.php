<?php
/**
 * Logout: clears the session and its cookie, then goes back to the home page.
 */

require_once __DIR__ . '/../includes/sessao.php';

$_SESSION = [];

if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
}

session_destroy();

// Prevents protected pages from being served from the browser cache via "back".
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');

redirecionar('../index.php');
