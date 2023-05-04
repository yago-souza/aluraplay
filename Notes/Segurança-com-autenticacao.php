<?php
/*
 * PASSWORD_ARGON2ID -> atualmente é o melhor padrão de hash é o mais premiado
 * Armazenando senhas usando hash(password_hash($password, PASSWORD_ARGON2ID))
 * Verificando password com password_verify($password, $statement->getPassword());
 * Controller fazendo processo de autenticação por email e senha
 *
 * Autorização(após autenticar verificar quais permissoes)
 *
 *
 *  */