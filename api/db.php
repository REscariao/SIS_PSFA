<?php


// Configurações do Banco de Dados
// Dica: Futuramente, mova isso para um arquivo .env por segurança
$host = 'localhost';
$db   = 'banco_ecc_santoantonio';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lança exceções em erros
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Retorna arrays associativos
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Desativa emulação para maior segurança contra SQL Injection
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",    // Garante o charset na conexão
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Para produção, não é recomendado exibir o erro detalhado (mensagens do banco) para o usuário.
    // Logamos o erro internamente e exibimos uma mensagem amigável.
    error_log($e->getMessage());
    exit("Erro ao conectar com o banco de dados. Por favor, tente mais tarde.");
}

// Opcional: Função global para facilitar o uso do PDO em outros arquivos
function db() {
    global $pdo;
    return $pdo;
}