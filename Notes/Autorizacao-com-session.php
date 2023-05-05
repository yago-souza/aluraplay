<?php
/*
 * Implementando sessões no index(front-controller)
 * a func "session_start" tem que ser chamada antes de qualquer outro header para funcionar
 * Chammando ela no index garante que irá funcionar em trodos outros arquivos chamados por ele
 * por tanto valida nesse caso se o usuario foi validado
 * E também valida se ele não está na tela de login para não gerar um loop
 * session_start();
 * E usando o session_destroy() para finalizar uma sessão
 *  */