<?php
namespace techfit;

require_once "Connection.php";
require_once "treino.php";
USE PDO;

class treinoDAO {
    private $conn;

    public function __construct() {
        // Obtenção da conexão
        $this->conn = Connection::getInstacia();

        // Cria a tabela 'treinos' se não existir, com as colunas da classe treino
        $this->conn->exec("
            CREATE TABLE IF NOT EXISTS treinos (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nome VARCHAR(100) NOT NULL,
                horario VARCHAR(50) NOT NULL,
                data DATE NOT NULL,
                repeticoes INT NOT NULL DEFAULT 0
            )
        ");
    }

    public function criarTreino(treino $treino) {
        $stmt = $this->conn->prepare("
            INSERT INTO treinos (nome, horario, data, repeticoes)
            VALUES (:nome, :horario, :data, :repeticoes)
        ");
        $stmt->execute([
            ':nome' => $treino->getNome(),
            ':horario' => $treino->getHorario(),
            ':data' => $treino->getData(),
            ':repeticoes' => $treino->getRepeticoes()
        ]);
    }

    public function lerTreinos() {
        $stmt = $this->conn->query("SELECT * FROM treinos ORDER BY data DESC, horario");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Instancia o objeto treino a partir dos dados do banco
            $result[] = new treino(
                $row['id'],
                $row['nome'],
                $row['horario'],
                $row['data'],
                $row['repeticoes']
            );
        }
        return $result;
    }

    public function atualizarTreino($idOriginal, $novoNome, $novoHorario, $novaData, $novasRepeticoes) {
        $stmt = $this->conn->prepare("
            UPDATE treinos
            SET nome = :novoNome, horario = :novoHorario, data = :novaData, repeticoes = :novasRepeticoes
            WHERE id = :idOriginal
        ");
        $stmt->execute([
            ':novoNome' => $novoNome,
            ':novoHorario' => $novoHorario,
            ':novaData' => $novaData,
            ':novasRepeticoes' => $novasRepeticoes,
            ':idOriginal' => $idOriginal
        ]);
    }

    public function excluirTreino($id) {
        $stmt = $this->conn->prepare("DELETE FROM treinos WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }

    public function buscarPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM treinos WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            // Instancia o objeto treino a partir dos dados do banco
            return new treino(
                $row['id'],
                $row['nome'],
                $row['horario'],
                $row['data'],
                $row['repeticoes']
            );
        }
        return null;
    }

    public function buscarPorNome($nome) {
        $stmt = $this->conn->prepare("SELECT * FROM treinos WHERE nome LIKE :nome ORDER BY data DESC");
        $stmt->execute([':nome' => "%$nome%"]);
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new treino(
                $row['id'],
                $row['nome'],
                $row['horario'],
                $row['data'],
                $row['repeticoes']
            );
        }
        return $result;
    }

    public function buscarPorData($data) {
        $stmt = $this->conn->prepare("SELECT * FROM treinos WHERE data = :data ORDER BY horario");
        $stmt->execute([':data' => $data]);
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new treino(
                $row['id'],
                $row['nome'],
                $row['horario'],
                $row['data'],
                $row['repeticoes']
            );
        }
        return $result;
    }

    public function buscarPorPeriodo($dataInicio, $dataFim) {
        $stmt = $this->conn->prepare("SELECT * FROM treinos WHERE data BETWEEN :dataInicio AND :dataFim ORDER BY data DESC, horario");
        $stmt->execute([
            ':dataInicio' => $dataInicio,
            ':dataFim' => $dataFim
        ]);
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new treino(
                $row['id'],
                $row['nome'],
                $row['horario'],
                $row['data'],
                $row['repeticoes']
            );
        }
        return $result;
    }

    public function buscarTreinosHoje() {
        $hoje = date('Y-m-d');
        return $this->buscarPorData($hoje);
    }
}
?>