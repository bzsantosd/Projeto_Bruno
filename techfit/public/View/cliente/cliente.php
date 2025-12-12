<?php
session_start();
$nomeCompleto = isset($_SESSION['usuario_nome']) ? htmlspecialchars($_SESSION['usuario_nome']) : 'Usuário não logado';
$emailUsuario = isset($_SESSION['usuario_email']) ? htmlspecialchars($_SESSION['usuario_email']) : 'N/A';
$planoAtivo = isset($_SESSION['usuario_plano']) ? htmlspecialchars($_SESSION['usuario_plano']) : 'Nenhum plano ativo';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil - TechFit</title> 
    <link rel="stylesheet" href="../../css/cliente.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    
    <?php include_once __DIR__ . "\\..\\Layout\\header.php" ?>

    <main>
        
        <section id="informacoes-pessoais" class="perfil-secao">
            <h2>Minhas Informações Pessoais (Dados do Cadastro)</h2>
            
            <div class="info-bloco">
                <label for="nome">Nome Completo</label>
                <p id="nome"><?php echo $nomeCompleto; ?></p>
            </div>
            
            <div class="info-bloco">
                <label for="email">E-mail</label>
                <p id="email"><?php echo $emailUsuario; ?></p>
            </div>

            <div class="info-bloco">
                <label for="plano">Plano Ativo</label>
                <p id="plano"><?php echo $planoAtivo; ?></p>
            </div>

            <button class="editar-btn"><i class="fas fa-edit"></i> Editar Informações</button>
        </section>

        <section id="pedidos" class="perfil-secao">
            <h2>Meus Últimos Pedidos (Histórico do Cadastro)</h2>
            <button class="editar-btn"><i class="fas fa-list-alt"></i> Ver Histórico Completo</button>
        </section>

    </main>

    <footer>
        <p>&copy; 2025 TechFit - Todos os direitos reservados.</p>
    </footer>
    
    <script src="/techfit/public/js/cliente.js"></script> 
</body>
</html>