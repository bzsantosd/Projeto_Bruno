<?php
namespace techfit;

require_once "Connection.php";
require_once "plano.php";
USE PDO;

class planoDAO {
    private $conn;

    public function __construct() {
        // Obtenção da conexão
        $this->conn = Connection::getInstacia();

        // Cria a tabela 'planos' se não existir, com as colunas da classe plano
        $this->conn->exec("
            CREATE TABLE IF NOT EXISTS planos (
                id INT AUTO_INCREMENT PRIMARY KEY,
                plano VARCHAR(100) NOT NULL UNIQUE,
                valor DECIMAL(10, 2) NOT NULL,
                beneficios TEXT NOT NULL,
                pagamento VARCHAR(50) NOT NULL
            )
        ");
    }

    public function criarPlano(plano $plano) {
        $stmt = $this->conn->prepare("
            INSERT INTO planos (plano, valor, beneficios, pagamento)
            VALUES (:plano, :valor, :beneficios, :pagamento)
        ");
        $stmt->execute([
            ':plano' => $plano->getPlano(),
            ':valor' => $plano->getValor(),
            ':beneficios' => $plano->getBeneficios(),
            ':pagamento' => $plano->getPagamento()
        ]);
    }

    public function lerPlanos() {
        $stmt = $this->conn->query("SELECT * FROM planos ORDER BY valor");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Instancia o objeto plano a partir dos dados do banco
            $result[] = new plano(
                $row['plano'],
                $row['valor'],
                $row['beneficios'],
                $row['pagamento']
            );
        }
        return $result;
    }

    public function atualizarPlano($planoOriginal, $novoPlano, $novoValor, $novosBeneficios, $novoPagamento) {
        $stmt = $this->conn->prepare("
            UPDATE planos
            SET plano = :novoPlano, valor = :novoValor, beneficios = :novosBeneficios, pagamento = :novoPagamento
            WHERE plano = :planoOriginal
        ");
        $stmt->execute([
            ':novoPlano' => $novoPlano,
            ':novoValor' => $novoValor,
            ':novosBeneficios' => $novosBeneficios,
            ':novoPagamento' => $novoPagamento,
            ':planoOriginal' => $planoOriginal
        ]);
    }

    public function excluirPlano($plano) {
        $stmt = $this->conn->prepare("DELETE FROM planos WHERE plano = :plano");
        $stmt->execute([':plano' => $plano]);
    }

    public function buscarPorNome($plano) {
        $stmt = $this->conn->prepare("SELECT * FROM planos WHERE plano = :plano LIMIT 1");
        $stmt->execute([':plano' => $plano]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            // Instancia o objeto plano a partir dos dados do banco
            return new plano(
                $row['plano'],
                $row['valor'],
                $row['beneficios'],
                $row['pagamento']
            );
        }
        return null;
    }

    public function buscarPorValor($valorMinimo, $valorMaximo) {
        $stmt = $this->conn->prepare("SELECT * FROM planos WHERE valor BETWEEN :minimo AND :maximo ORDER BY valor");
        $stmt->execute([
            ':minimo' => $valorMinimo,
            ':maximo' => $valorMaximo
        ]);
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new plano(
                $row['plano'],
                $row['valor'],
                $row['beneficios'],
                $row['pagamento']
            );
        }
        return $result;
    }

    public function buscarPorPagamento($pagamento) {
        $stmt = $this->conn->prepare("SELECT * FROM planos WHERE pagamento = :pagamento ORDER BY valor");
        $stmt->execute([':pagamento' => $pagamento]);
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new plano(
                $row['plano'],
                $row['valor'],
                $row['beneficios'],
                $row['pagamento']
            );
        }
        return $result;
    }
}
?>