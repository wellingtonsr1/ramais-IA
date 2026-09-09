<?php
/**
 * Shared server-side validation functions (regex per field).
 */

/** Sector name: letters, accents, digits, separators and spaces (relaxed). */
function setor($setor)
{
    return preg_match('/^[A-Za-z0-9à-úÀ-ÚçÇ][A-Za-z0-9à-úÀ-ÚçÇ\s\/\.\-_]{0,34}$/u', $setor) === 1;
}

/** Ramal: 3 to 8 digits. */
function ramal($ramal)
{
    return preg_match('/^[0-9]{3,8}$/', (string)$ramal) === 1;
}

/** Responsible name: letters, accents, spaces and separators (relaxed, P-39). */
function responsavel($responsavel)
{
    return preg_match('/^[A-Za-zà-úÀ-ÚçÇ][A-Za-zà-úÀ-ÚçÇ\s\/\.\-]{0,24}$/u', $responsavel) === 1;
}

/** Username: lowercase letters and optional dots (e.g. joao.silva). */
function usuario($usuario)
{
    return preg_match('/^[a-z]+([.][a-z]+)*$/', $usuario) === 1;
}

/** Password: allowed chars AND minimum length of 8 (P-28). */
function senha($senha)
{
    return preg_match('/^[A-Za-z0-9@$&!#%]{8,}$/', $senha) === 1;
}

/** Access level must be one of the allowed values (P-06 hardening). */
function nivel($nivel)
{
    return in_array($nivel, ['admin', 'atendente'], true);
}

/** 'First access' flag accepts only sim/nao. */
function primeiroacesso($primeiroacesso)
{
    return preg_match('/^(sim|nao)$/', $primeiroacesso) === 1;
}

/** Email or the legacy literal 'não informado'. */
function email($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false || $email === 'não informado';
}

/** Both new password fields valid. */
function verificarSenhas($novaSenha, $senhaConfirmada)
{
    return senha($novaSenha) && senha($senhaConfirmada);
}

/** Employee name: letters, accents, spaces and separators (relaxed, P-39). */
function nome($nome)
{
    return preg_match('/^[A-Za-zà-úÀ-ÚçÇ][A-Za-zà-úÀ-ÚçÇ\s\/\.\-]{0,38}$/u', $nome) === 1;
}

/** Phone: 10 or 11 digits. */
function telefone($telefone)
{
    return preg_match('/^[0-9]{10,11}$/', (string)$telefone) === 1;
}
