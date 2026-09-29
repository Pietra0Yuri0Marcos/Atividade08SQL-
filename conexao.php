<?php 

$host = "192.168.10.38"; 

$banco = "manutencao"; 

$senha = "oceuelindoeomundogrande"; 

$usuario = "postgres";

$pdo = new PDO("pgsql:host=$host;port=5432;dbname=$banco", $usuario, $senha ); ?>