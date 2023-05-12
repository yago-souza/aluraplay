<?php
/*
 * PASSWORD_ARGON2ID -> atualmente é o melhor padrão de hash é o mais premiado
 * Armazenando senhas usando hash(password_hash($password, PASSWORD_ARGON2ID))
 * Verificando password com password_verify($password, $statement->getPassword());
 * Controller fazendo processo de autenticação por email e senha
 *
 * Autorização(após autenticar verificar quais permissoes)
 *
 *  */

## Serve para renovar o ID do cookie e protejer contra sequestro de sessão
## Conferir documentação como fazer isso de forma mais confiavel
if (isset($_SESSION['logado'])) {
    $originalInfo = $_SESSION['logado'];
    unset($_SESSION['logado']);
    session_regenerate_id();
    $_SESSION['logado'] = $originalInfo;
}
## Dessa forma, a sessão anterior não terá mais a informação de autenticação
# e a nova sessão terá a informação que já havia sido salva.