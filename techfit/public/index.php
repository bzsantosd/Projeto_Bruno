<?php

// Roteador simples que serve arquivos estáticos HTML existentes
// Evita depender dos Controllers enquanto a API não estiver pronta

define('ROOT_PATH', dirname(__DIR__));
$publicDir = __DIR__;

$rawPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request_uri = trim($rawPath, '/');

// Pegamos só o primeiro segmento (ex: /cadastro/ops -> cadastro)
if ($request_uri !== '') {
    $parts = explode('/', $request_uri);
    $request_uri = $parts[0];
}

$routes = [
    '' => './View/index.php',
    'home' => './View/index.php',
    'cadastro' => './View/login/usuario.php',
    'login' => './View/login/login.php',
    'perfil' => 'perfil.html',
    'produtos' => './View/inicial/produtos.php',
    'planos' => './View/inicial/planos.php',
    'contato' => './View/inicial/contato.php',
    'carrinho' => './View/inicial/carrinho.php',
    'sobrenos'=> './View/inicial/sobrenos.php',
    'cliente' => './View/cliente/cliente.php'
];

if (array_key_exists($request_uri, $routes)) {
    $file = $publicDir . DIRECTORY_SEPARATOR . $routes[$request_uri];
    if (file_exists($file)) {
        include $file;
        exit;
    }
}

http_response_code(404);
echo "Página não encontrada.";

?>