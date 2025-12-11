<?php
namespace techfit;

require_once "Connection.php";
require_once "adm.php";
USE PDO;
// Assumindo que Connection::getInstacia() retorna uma instância PDO.
// Você precisará incluir a classe admin e Connection.

class admDAO {
    private $conn;

    public function __construct() {
        // Obtenção da conexão.
        // É essencial que a classe Connection esteja definida e acessível.
        $this->conn = Connection::getInstacia(); 

        // Cria a tabela 'admins' se não existir, com as colunas da classe admin.
        $this->conn->exec("
            CREATE TABLE IF NOT EXISTS admins (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nome VARCHAR(100) NOT NULL,
                cargo VARCHAR(100) NOT NULL,
                email VARCHAR(150) NOT NULL UNIQUE,
                senha VARCHAR(255) NOT NULL
            )
        ");
    }

    // CREATE
    /**
     * @param admin $admin O objeto admin a ser persistido.
     */
    public function criarAdmin(admin $admin) {
        $stmt = $this->conn->prepare("
            INSERT INTO admins (nome, cargo, email, senha)
            VALUES (:nome, :cargo, :email, :senha)
        ");
        $stmt->execute([
            ':nome' => $admin->getNome(),
            ':cargo' => $admin->getCargo(),
            ':email' => $admin->getEmail(),
            ':senha' => $admin->getSenha()
        ]);
    }

    // READ (Todos)
    /**
     * @return admin[] Um array de objetos admin.
     */
    public function lerAdmins() {
        $stmt = $this->conn->query("SELECT * FROM admins ORDER BY nome");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Instancia o objeto admin a partir dos dados do banco.
            $result[] = new admin(
                $row['nome'],
                $row['cargo'],
                $row['email'],
                $row['senha']
                // Se você adicionar 'id' na classe admin, deve passá-lo aqui também.
            );
        }
        return $result;
    }

    // UPDATE
    /**
     * Atualiza os dados de um admin, buscando pelo email original.
     */
    public function atualizarAdmin($emailOriginal, $novoNome, $novoCargo, $novoEmail, $novaSenha) {
        $stmt = $this->conn->prepare("
            UPDATE admins
            SET nome = :novoNome, cargo = :novoCargo, email = :novoEmail, senha = :novaSenha
            WHERE email = :emailOriginal
        ");
        $stmt->execute([
            ':novoNome' => $novoNome,
            ':novoCargo' => $novoCargo,
            ':novoEmail' => $novoEmail,
            ':novaSenha' => $novaSenha,
            ':emailOriginal' => $emailOriginal
        ]);
    }

    // DELETE
    /**
     * Exclui um admin buscando pelo email.
     */
    public function excluirAdmin($email) {
        $stmt = $this->conn->prepare("DELETE FROM admins WHERE email = :email");
        $stmt->execute([':email' => $email]);
    }

    // BUSCAR POR EMAIL
    /**
     * Busca um admin pelo email.
     * @return admin|null O objeto admin se encontrado, ou null.
     */
    public function buscarPorEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM admins WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            // Instancia o objeto admin a partir dos dados do banco.
            return new admin(
                $row['nome'],
                $row['cargo'],
                $row['email'],
                $row['senha']
            );
        }
        return null;
    }
}
?>