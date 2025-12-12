<?php
namespace techfit;

require_once "Connection.php";
require_once "Aulas.php";
USE PDO;

class AulasDAO {
    private $conn;

    public function __construct() {
        // Obtenção da conexão
        $this->conn = Connection::getInstacia();

        // Cria a tabela 'aulas' se não existir, com as colunas da classe Aulas
        $this->conn->exec("
            CREATE TABLE IF NOT EXISTS aulas (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nome VARCHAR(100) NOT NULL,
                horario VARCHAR(50) NOT NULL,
                professor VARCHAR(100) NOT NULL
            )
        ");
    }

    public function criarAula(Aulas $aula) {
        $stmt = $this->conn->prepare("
            INSERT INTO aulas (nome, horario, professor)
            VALUES (:nome, :horario, :professor)
        ");
        $stmt->execute([
            ':nome' => $aula->getNome(),
            ':horario' => $aula->getHorario(),
            ':professor' => $aula->getProfessor()
        ]);
    }

    public function lerAulas() {
        $stmt = $this->conn->query("SELECT * FROM aulas ORDER BY nome");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Instancia o objeto Aulas a partir dos dados do banco
            $result[] = new Aulas(
                $row['nome'],
                $row['horario'],
                $row['professor']
            );
        }
        return $result;
    }

    public function atualizarAula($nomeOriginal, $novoNome, $novoHorario, $novoProfessor) {
        $stmt = $this->conn->prepare("
            UPDATE aulas
            SET nome = :novoNome, horario = :novoHorario, professor = :novoProfessor
            WHERE nome = :nomeOriginal
        ");
        $stmt->execute([
            ':novoNome' => $novoNome,
            ':novoHorario' => $novoHorario,
            ':novoProfessor' => $novoProfessor,
            ':nomeOriginal' => $nomeOriginal
        ]);
    }

    public function excluirAula($nome) {
        $stmt = $this->conn->prepare("DELETE FROM aulas WHERE nome = :nome");
        $stmt->execute([':nome' => $nome]);
    }

    public function buscarPorNome($nome) {
        $stmt = $this->conn->prepare("SELECT * FROM aulas WHERE nome = :nome LIMIT 1");
        $stmt->execute([':nome' => $nome]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            // Instancia o objeto Aulas a partir dos dados do banco
            return new Aulas(
                $row['nome'],
                $row['horario'],
                $row['professor']
            );
        }
        return null;
    }

    public function buscarPorProfessor($professor) {
        $stmt = $this->conn->prepare("SELECT * FROM aulas WHERE professor = :professor ORDER BY horario");
        $stmt->execute([':professor' => $professor]);
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new Aulas(
                $row['nome'],
                $row['horario'],
                $row['professor']
            );
        }
        return $result;
    }
}
?>