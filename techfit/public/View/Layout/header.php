<?php

// Verifica se a sessão está ativa e se as variáveis necessárias existem
$logado = isset($_SESSION['usuario_id']) && !empty($_SESSION['usuario_nome']);
$nomeUsuario = $logado ? htmlspecialchars($_SESSION['usuario_nome']) : ''; 
// Usar htmlspecialchars é crucial para segurança contra XSS!
?>

<link rel="stylesheet" href="../../css/header.css">

<header class="header-content">
    <nav class="navbar">
        <ul class="nav-list">
            <li class="nav-item"><a onclick="navegarPara('/home')" data-page="home">HOME</a></li>
            <li class="nav-item"><a onclick="navegarPara('/planos')" data-page="planos">PLANOS</a></li>
            <li class="nav-item"><a onclick="navegarPara('/produtos')" data-page="produtos">PRODUTOS</a></li>
            <li class="nav-item"><a onclick="navegarPara('/contato')" data-page="contato">CONTATO</a></li>
            <li class="nav-item"><a onclick="navegarPara('/sobrenos')" data-page="sobre">SOBRE NÓS</a></li>
            
            <?php if ($logado): ?>
                <li class="nav-item user-greeting">
                    <a href="#" data-page="perfil">OLÁ, <?php echo strtoupper($nomeUsuario); ?></a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
    
    <div class="auth-buttons">
        <?php if ($logado): ?>
            <a onclick="navegarPara('/home')" class="btn btn-logout">SAIR</a>
        <?php else: ?>
            <a onclick="navegarPara('/login')" class="btn btn-login">ENTRAR</a>
        <?php endif; ?>
    </div>
</header>

<script src="./js/navegar.js"></script>

<div class="container my-5 flex-grow-1"></div>