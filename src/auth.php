<?php
/**
 * src/auth.php — autenticação e utilizador atual
 * Responsável: Samuel
 *
 * TODO (funções sugeridas):
 *  1. attempt_login($username, $password)
 *       - procurar utilizador com prepared statement;
 *       - password_verify() contra password_hash;
 *       - em caso de sucesso: session_regenerate_id(true) e guardar user_id/role na sessão;
 *       - devolver o utilizador (sem password_hash) ou falso.
 *       - mesmo tempo/mensagem para "não existe" e "password errada".
 *  2. logout_user()
 *       - limpar $_SESSION, apagar cookie de sessão, session_destroy().
 *  3. current_user()
 *       - devolve o utilizador da sessão (consultar BD) ou null.
 *  4. Limitação de tentativas (opcional mas recomendado)
 *       - contar falhas por IP/username e bloquear temporariamente.
 *  5. Função auxiliar para criar utilizadores com password_hash() (usada no seed/admin).
 */
