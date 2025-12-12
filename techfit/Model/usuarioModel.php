<?php
namespace techfit;

require_once "Connection.php";
require_once "usuario.php";
USE PDO;

class usuarioDAO {
    private $conn;

    public function __construct() {
        // Obtenção da conexão
        $this->conn = Connection::getInstacia();

        // Cria a tabela 'usuarios' se não existir
        $this->conn->exec("
            CREATE TABLE IF NOT EXISTS usuarios (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nome VARCHAR(100) NOT NULL,
                cpf VARCHAR(14) NOT NULL UNIQUE,
                email VARCHAR(150) NOT NULL UNIQUE,
                senha VARCHAR(255) NOT NULL,
                plano VARCHAR(100) NOT NULL
            )
        ");
    }

    public function criarUsuario(usuario $usuario) {
        $stmt = $this->conn->prepare("
            INSERT INTO usuarios (nome, cpf, email, senha, plano)
            VALUES (:nome, :cpf, :email, :senha, :plano)
        ");
        $stmt->execute([
            ':nome' => $usuario->getNome(),
            ':cpf' => $usuario->getCpf(),
            ':email' => $usuario->getEmail(),
            ':senha' => $usuario->getSenha(),
            ':plano' => $usuario->getPlano()
        ]);
        
        // Define o ID do usuário recém-criado
        $usuario->setId($this->conn->lastInsertId());
    }

    public function lerUsuarios() {
        $stmt = $this->conn->query("SELECT * FROM usuarios ORDER BY nome");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Instancia o objeto usuario com o ID do banco
            $result[] = new usuario(
                $row['nome'],
                $row['cpf'],
                $row['email'],
                $row['senha'],
                $row['plano'],
                $row['id']  // Passa o ID
            );
        }
        return $result;
    }

    public function atualizarUsuario($emailOriginal, $novoNome, $novoCpf, $novoEmail, $novaSenha, $novoPlano) {
        $stmt = $this->conn->prepare("
            UPDATE usuarios
            SET nome = :novoNome, cpf = :novoCpf, email = :novoEmail, senha = :novaSenha, plano = :novoPlano
            WHERE email = :emailOriginal
        ");
        $stmt->execute([
            ':novoNome' => $novoNome,
            ':novoCpf' => $novoCpf,
            ':novoEmail' => $novoEmail,
            ':novaSenha' => $novaSenha,
            ':novoPlano' => $novoPlano,
            ':emailOriginal' => $emailOriginal
        ]);
    }

    public function atualizarUsuarioPorId($id, $novoNome, $novoCpf, $novoEmail, $novaSenha, $novoPlano) {
        $stmt = $this->conn->prepare("
            UPDATE usuarios
            SET nome = :novoNome, cpf = :novoCpf, email = :novoEmail, senha = :novaSenha, plano = :novoPlano
            WHERE id = :id
        ");
        $stmt->execute([
            ':novoNome' => $novoNome,
            ':novoCpf' => $novoCpf,
            ':novoEmail' => $novoEmail,
            ':novaSenha' => $novaSenha,
            ':novoPlano' => $novoPlano,
            ':id' => $id
        ]);
    }

    public function excluirUsuario($email) {
        $stmt = $this->conn->prepare("DELETE FROM usuarios WHERE email = :email");
        $stmt->execute([':email' => $email]);
    }

    public function excluirUsuarioPorId($id) {
        $stmt = $this->conn->prepare("DELETE FROM usuarios WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }

    public function buscarPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new usuario(
                $row['nome'],
                $row['cpf'],
                $row['email'],
                $row['senha'],
                $row['plano'],
                $row['id']
            );
        }
        return null;
    }

    public function buscarPorEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new usuario(
                $row['nome'],
                $row['cpf'],
                $row['email'],
                $row['senha'],
                $row['plano'],
                $row['id']
            );
        }
        return null;
    }

    public function buscarPorCpf($cpf) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE cpf = :cpf LIMIT 1");
        $stmt->execute([':cpf' => $cpf]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new usuario(
                $row['nome'],
                $row['cpf'],
                $row['email'],
                $row['senha'],
                $row['plano'],
                $row['id']
            );
        }
        return null;
    }

    public function buscarPorNome($nome) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE nome LIKE :nome ORDER BY nome");
        $stmt->execute([':nome' => "%$nome%"]);
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new usuario(
                $row['nome'],
                $row['cpf'],
                $row['email'],
                $row['senha'],
                $row['plano'],
                $row['id']
            );
        }
        return $result;
    }

    public function buscarPorPlano($plano) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE plano = :plano ORDER BY nome");
        $stmt->execute([':plano' => $plano]);
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new usuario(
                $row['nome'],
                $row['cpf'],
                $row['email'],
                $row['senha'],
                $row['plano'],
                $row['id']
            );
        }
        return $result;
    }

    public function verificarLogin($email, $senha) {
        $usuario = $this->buscarPorEmail($email);
        
        // 1. Verifica se o usuário foi encontrado
        if ($usuario) {
            // 2. Compara a senha fornecida com o hash armazenado usando password_verify()
            // Isso é seguro, pois não expõe o hash e usa um algoritmo forte (DEFAULT = Argon2 ou Bcrypt).
            if (password_verify($senha, $usuario->getSenha())) {
                // Login bem-sucedido
                return $usuario;
            }
        }
        
        // Login falhou (usuário não encontrado ou senha incorreta)
        return null;
    }
}
?>