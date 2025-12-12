<?php
namespace techfit;
session_start();

// Importa o Controller
require_once __DIR__ . '\\..\\..\\..\\Controller\\usuariocontroller.php';
USE Exception;
$erro = '';
$sucesso = '';
$controller = new usuarioController();

// Processa o formulário quando enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitização dos dados
    $nome = trim(filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS));
    $cpf = trim(filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_SPECIAL_CHARS));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $senha = $_POST['senha'] ?? '';
    $confirma_senha = $_POST['confirma_senha'] ?? '';
    $plano = trim(filter_input(INPUT_POST, 'plano', FILTER_SANITIZE_SPECIAL_CHARS)) ?? 'Básico';

    // Validações
    if (empty($nome) || empty($cpf) || empty($email) || empty($senha)) {
        $erro = 'Por favor, preencha todos os campos obrigatórios.';
    } elseif (strlen($nome) < 3) {
        $erro = 'O nome deve ter pelo menos 3 caracteres.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'Por favor, insira um email válido.';
    } elseif (strlen($senha) < 6) {
        $erro = 'A senha deve ter pelo menos 6 caracteres.';
    } elseif ($senha !== $confirma_senha) {
        $erro = 'As senhas não coincidem.';
    } else {
        // Remove formatação do CPF
        $cpf_limpo = preg_replace('/[^0-9]/', '', $cpf);
        
        // Valida CPF
        if (strlen($cpf_limpo) !== 11) {
            $erro = 'CPF inválido. Deve conter 11 dígitos.';
        } else {
            // Verifica se o email já está cadastrado
            $usuarioExistente = $controller->buscar($email);
            if ($usuarioExistente) {
                $erro = 'Este email já está cadastrado.';
            } else {
                // Verifica se o CPF já está cadastrado
                $cpfExistente = $controller->buscarPorCpf($cpf_limpo);
                if ($cpfExistente) {
                    $erro = 'Este CPF já está cadastrado.';
                } else {
                    try {
                        // Hash da senha para segurança
                        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
                        
                        // Cria o usuário
                        $usuarioCriado = $controller->criar($nome, $cpf_limpo, $email, $senhaHash, $plano);
                        
                        $sucesso = 'Cadastro realizado com sucesso! Redirecionando para o login...';
                        
                        // Redireciona após 2 segundos
                        header("refresh:2;url=/login");
                        
                    } catch (Exception $e) {
                        $erro = 'Erro ao cadastrar usuário. Tente novamente mais tarde.';
                    }
                }
            }
        }
    }
}
?>

<?php include_once __DIR__ . "\\..\\Layout\\header.php" ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Cadastro de Usuário</h4>
            </div>
            <div class="card-body">
                
                <!-- Mensagem de Erro -->
                <?php if (!empty($erro)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Erro!</strong> <?php echo htmlspecialchars($erro); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Mensagem de Sucesso -->
                <?php if (!empty($sucesso)): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <strong>Sucesso!</strong> <?php echo htmlspecialchars($sucesso); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form action="" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nome Completo <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                class="form-control" 
                                name="nome" 
                                value="<?php echo isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : ''; ?>"
                                required
                                minlength="3"
                                maxlength="100"
                            >
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">CPF <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                class="form-control" 
                                name="cpf" 
                                placeholder="000.000.000-00"
                                value="<?php echo isset($_POST['cpf']) ? htmlspecialchars($_POST['cpf']) : ''; ?>"
                                required
                                maxlength="14"
                                id="cpf"
                            >
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">E-mail <span class="text-danger">*</span></label>
                        <input 
                            type="email" 
                            class="form-control" 
                            name="email" 
                            value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                            required
                            maxlength="150"
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Plano</label>
                        <select class="form-select" name="plano">
                            <option value="Básico" <?php echo (isset($_POST['plano']) && $_POST['plano'] === 'Básico') ? 'selected' : ''; ?>>Básico</option>
                            <option value="Premium" <?php echo (isset($_POST['plano']) && $_POST['plano'] === 'Premium') ? 'selected' : ''; ?>>Premium</option>
                            <option value="VIP" <?php echo (isset($_POST['plano']) && $_POST['plano'] === 'VIP') ? 'selected' : ''; ?>>VIP</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Senha <span class="text-danger">*</span></label>
                            <input 
                                type="password" 
                                class="form-control" 
                                name="senha" 
                                required
                                minlength="6"
                                id="senha"
                            >
                            <small class="text-muted">Mínimo de 6 caracteres</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Confirme a Senha <span class="text-danger">*</span></label>
                            <input 
                                type="password" 
                                class="form-control" 
                                name="confirma_senha" 
                                required
                                minlength="6"
                                id="confirma_senha"
                            >
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <a onclick="navegarPara('login')" class="btn btn-secondary me-2">Cancelar</a>
                        <button type="submit" class="btn btn-success">Salvar Cadastro</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script para Máscara de CPF -->
<script>
document.getElementById('cpf').addEventListener('input', function (e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length <= 11) {
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
        e.target.value = value;
    }
});

// Validação de senhas iguais em tempo real
document.getElementById('confirma_senha').addEventListener('input', function (e) {
    const senha = document.getElementById('senha').value;
    const confirmaSenha = e.target.value;
    
    if (senha !== confirmaSenha && confirmaSenha.length > 0) {
        e.target.setCustomValidity('As senhas não coincidem');
        e.target.classList.add('is-invalid');
    } else {
        e.target.setCustomValidity('');
        e.target.classList.remove('is-invalid');
    }
});
</script>

<script src="../js/navegar.js"></script>

<?php include_once __DIR__ . "\\..\\Layout\\footer.php" ?>