<?php
namespace techfit;
session_start();

// Importa o Controller
require_once __DIR__ . '\\..\\..\\..\\Controller\\usuariocontroller.php';



$erro = '';
$controller = new usuarioController();

// Processa o formulário quando enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    if (empty($email) || empty($senha)) {
        $erro = 'Por favor, preencha todos os campos.';
    } else {
        // Verifica o login usando o controller
        $usuario = $controller->verificarLogin($email, $senha);
        
        if ($usuario) {
            // Login bem-sucedido - armazena dados na sessão
            // O método retorna um objeto, então usamos ->
            $_SESSION['usuario_id'] = $usuario->getId();
            $_SESSION['usuario_nome'] = $usuario->getNome();
            $_SESSION['usuario_email'] = $usuario->getEmail();
            $_SESSION['usuario_plano'] = $usuario->getPlano();
            
            // Redireciona para a página inicial ou perfil
            header('Location: /cliente');
            exit;
        } else {
            $erro = 'Email ou senha incorretos.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TechFit Academia</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="../../css/login.css">
</head>
<body>
    
    <?php include_once __DIR__ . "\\..\\Layout\\header.php" ?>

    <div class="main-content-wrapper"> 
        
        <div class="login-container">
            <div class="image-section"></div>

            <div class="login-section">
                <div class="login-box">
                    <img src="../assets/logo.png" alt="TechFit Logo" class="background-image">

                    <?php if (!empty($erro)): ?>
                        <div class="error-message" style="display: block;">
                            <?php echo htmlspecialchars($erro); ?>
                        </div>
                    <?php endif; ?>

                    <form class="login-form" method="POST" action="">
                        <label for="email">Email</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            placeholder="Digite seu email"
                            required
                        >

                        <label for="senha">Senha</label>
                        <input 
                            type="password" 
                            id="senha" 
                            name="senha" 
                            placeholder="Digite sua senha"
                            required
                        >

                        <button type="submit" class="btn-login-full">ENTRAR</button>
                    </form>

                    <div class="links">
                        <span class="register-text">Não tem uma conta? </span>
                        <a onclick="navegarPara('cadastro')">Cadastre-se</a>
                    </div>
                </div>
            </div>
        </div>

    </div> <script src="../js/navegar.js"></script>
    
    <?php // include_once __DIR__ . "\\..\\Layout\\footer.php" ?>
    
</body>
</html>