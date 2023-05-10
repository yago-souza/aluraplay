<?php
/*
 * Ao enviar arquivos através de um formulário para um servidor PHP, uma variável $_FILES é automaticamente preenchida. Uma das chaves de cada arquivo presente em $_FILES é error. Nessa chave nós encontraremos o valor que indica o código de erro (ou sucesso) da operação de upload.
 * Discutimos sobre como arquivos normalmente são armazenados e os motivos para não salvarmos arquivos diretamente no banco de dados
 * Aprendemos a enviar arquivos através de formulários HTML, definindo corretamente o enctype
 * Vimos como podemos receber envios de arquivos na variável $_FILES do PHP
 * Aprendemos a usar a função move_uploaded_file para armazenar um arquivo enviado corretamente na pasta desejada.
 * */