<?php
/**
 * src/helpers.php — funções partilhadas por todos os endpoints
 * Responsável: Samuel
 *
 * TODO (funções sugeridas):
 *  1. json_ok($data, $status = 200)
 *       - define Content-Type JSON, devolve {"ok": true, "data": ...}, termina o script.
 *  2. json_error($code, $message, $status)
 *       - devolve {"ok": false, "error": {"code":..., "message":...}} (ver docs/api.md).
 *  3. read_json_body()
 *       - lê php://input, faz json_decode, devolve array; JSON inválido → 400.
 *  4. require_method(array $allowed)
 *       - se o método não estiver na lista → 405 METHOD_NOT_ALLOWED.
 *  5. start_secure_session()
 *       - nome da sessão vindo da config; cookie com httponly + samesite.
 *  6. require_login()  → devolve o utilizador atual ou 401.
 *  7. require_role($role) → 403 se o perfil não corresponder.
 *  8. CSRF: generate_csrf_token(), verify_csrf()
 *       - token guardado na sessão; verificar header X-CSRF-Token nos POST com hash_equals().
 *  9. Validação: funções para inteiros dentro de intervalo, valores de whitelist
 *     (severity, status, attack_type...), datas, strings com tamanho máximo.
 * 10. Paginação: normalizar page/per_page (per_page máx. 100) e devolver offset/limit.
 * 11. set_exception_handler(): regista o erro em logs/ e responde 500 SERVER_ERROR genérico.
 * 12. Constantes do domínio (arrays de valores válidos) — iguais às do README.
 */
