<?php
/* Regenerar o ID de sessão
 * Serve para renovar o ID do cookie e protejer contra sequestro de sessão
 * Conferir documentação como fazer isso de forma mais confiavel session_regenerate_id();
 *
 * definir parametros dos cookies como http only para não ser acessado pelo javascript por exemplo em um ataque
 * secure que só permite acessar o cookie por https etc
 * Para saber mais : https://cursos.alura.com.br/course/php-web-lidando-seguranca-api/task/118601
 *
 * Cookies e segurnaça: https://dias.dev/2022-09-27-cookies-e-seguranca/
 *
 *
 * Usando um nome de arquivo mais seguro
 * identificando se o tipo do arquivo é realmente uma imagem lendo os primeiros bites do arquivo
 *
 * */