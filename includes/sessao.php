<?php
/**
 * Centralized, hardened session bootstrap.
 * Include (or require) this file at the very top of every entry point.
 */

if (session_status() === PHP_SESSION_NONE) {
    // Cookie hardening: JS cannot read it; only sent over HTTPS when available;
    // not exposed to referees; strict-ish same-site.
    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'secure'   => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    // NOTE: do NOT rename the session cookie (keep the default PHPSESSID).
    // A custom name made mixed deploys (old+new files on the server) fail with
    // login=erro2, because old files wrote to PHPSESSID and new ones read RAMAISSESSID.
    session_start();
}

// Idle timeout: 30 minutes without activity ends the session (fixes P-15).
$timeoutInatividade = 30 * 60;
if (isset($_SESSION['ultimo_acesso']) && (time() - (int)$_SESSION['ultimo_acesso']) > $timeoutInatividade) {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();
    session_start();
}
$_SESSION['ultimo_acesso'] = time();
