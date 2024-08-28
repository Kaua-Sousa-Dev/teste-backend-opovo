<?php 
define('HOST', '127.0.0.1');
define('USUARIO', 'root');
define('SENHA', 'admin123');
define('DB', 'teste_backend_opovo');

$connect = mysqli_connect(HOST, USUARIO, SENHA, DB) or die ("Conexão Interrompida!")
?>