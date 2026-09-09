<?php
/**
 * Shared helpers - Ramais system.
 *
 * SECURITY: every dynamic output must go through e() (htmlspecialchars wrapper).
 */

if (!defined('RAMAIS_HELPERS')) {
    define('RAMAIS_HELPERS', 1);

    /** Escapes for safe HTML output (default UTF-8). */
    function e($value): string
    {
        return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    /** True when the request is an authenticated POST with a valid CSRF token. */
    function eh_post_valido(): bool
    {
        $token = (string)($_POST['csrf_token'] ?? '');
        return isset($_SESSION['csrf_token'])
            && !empty($_SESSION['csrf_token'])
            && !empty($token)
            && hash_equals((string)$_SESSION['csrf_token'], $token);
    }

    /** CSRF hidden input for forms. */
    function campo_csrf(): string
    {
        return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
    }

    /** Creates the session CSRF token when it does not exist. */
    function csrf_token(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /** Adds CSRF + Flash headers. */
    function cabecalhos_seguranca(): void
    {
        csrf_token();
        if (!headers_sent()) {
            header('X-Frame-Options: SAMEORIGIN');
            header('X-Content-Type-Options: nosniff');
            header('Referrer-Policy: same-origin');
        }
    }

    /** Redirect and stop execution. */
    function redirecionar(string $url): void
    {
        if (!headers_sent()) {
            header('Location: ' . $url);
        }
        exit;
    }

    /** Value from $_POST, always as trimmed string (never null). */
    function post_str(string $campo, string $default = ''): string
    {
        $v = $_POST[$campo] ?? $default;
        return is_string($v) ? trim($v) : $default;
    }

    /** Value from $_GET, always as string (never null). */
    function get_str(string $campo, string $default = ''): string
    {
        $v = $_GET[$campo] ?? $default;
        return is_string($v) ? trim($v) : $default;
    }

    /** Positive integer from $_GET/$_POST or null when invalid. */
    function requisicao_id(string $campo): ?int
    {
        $v = $_POST[$campo] ?? $_GET[$campo] ?? null;
        if ($v === null || $v === '' || !is_numeric($v)) {
            return null;
        }
        $id = (int)$v;
        return $id > 0 ? $id : null;
    }

    /** Formats a 10/11 digit phone string for display; returns the input unchanged otherwise. */
    function formatarTelefone(string $telefone): string
    {
        if (preg_match('/^[0-9]{10}$/', $telefone) === 1) {
            return '(' . substr($telefone, 0, 2) . ') 9' . substr($telefone, 2, 4) . '-' . substr($telefone, 6, 4);
        }
        if (preg_match('/^[0-9]{11}$/', $telefone) === 1) {
            return '(' . substr($telefone, 0, 2) . ') ' . substr($telefone, 2, 5) . '-' . substr($telefone, 7, 4);
        }
        return $telefone;
    }
}
