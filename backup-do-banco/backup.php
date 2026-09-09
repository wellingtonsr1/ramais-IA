<?php
    // Incluindo o autoload do Composer para carregar a biblioteca
    //require_once 'vendor/autoload.php';

    // Incluindo a classe que criamos
    require_once 'class/BackupDatabase.php';

    require_once 'mysqldump/Mysqldump.php';

    require_once '../modelo/conecta-banco.php';
  

    // Como a geração do backup pode ser demorada, retiramos
    // o limite de execução do script
    set_time_limit(0);

    $host = 'localhost';
    $base = 'listagemDeRamais';
    $directory = 'backups';

    // Utilizando a classe para gerar um backup na pasta 'backups'
    // e manter os últimos dez arquivos
    $backup = new BackupDatabase($directory, 10);

    $backup->setDatabase($host, $base, $user, $password);

    $backup->generate();
?>