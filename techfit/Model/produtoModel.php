<?php
namespace techfit;

require_once "Connection.php";
require_once "produto.php";
USE PDO;

class produtoDAO {
    private $conn;

    public function __construct() {
        // Obtenção da conexão
        $this->conn = Connection::getInstacia();

        // Cria a tabela 'produtos' se não existir, com as colunas da classe produto
        $this->conn->exec("
            CREATE TABLE IF NOT EXISTS produtos (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nome VARCHAR(100) NOT NULL,
                valor DECIMAL(10, 2) NOT NULL,
                qtde INT NOT NULL DEFAULT 0,
                estoque VARCHAR(50) NOT NULL
            )
        ");
    }

    public function criarProduto(produto $produto) {
        $stmt = $this->conn->prepare("
            INSERT INTO produtos (nome, valor, qtde, estoque)
            VALUES (:nome, :valor, :qtde, :estoque)
        ");
        $stmt->execute([
            ':nome' => $produto->getNome(),
            ':valor' => $produto->getValor(),
            ':qtde' => $produto->getQtde(),
            ':estoque' => $produto->getEstoque()
        ]);
    }

    public function lerProdutos() {
        $stmt = $this->conn->query("SELECT * FROM produtos ORDER BY nome");
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Instancia o objeto produto a partir dos dados do banco
            $result[] = new produto(
                $row['nome'],
                $row['valor'],
                $row['qtde'],
                $row['estoque'],
                $row['id']
            );
        }
        return $result;
    }

    public function atualizarProduto($idOriginal, $novoNome, $novoValor, $novaQtde, $novoEstoque) {
        $stmt = $this->conn->prepare("
            UPDATE produtos
            SET nome = :novoNome, valor = :novoValor, qtde = :novaQtde, estoque = :novoEstoque
            WHERE id = :idOriginal
        ");
        $stmt->execute([
            ':novoNome' => $novoNome,
            ':novoValor' => $novoValor,
            ':novaQtde' => $novaQtde,
            ':novoEstoque' => $novoEstoque,
            ':idOriginal' => $idOriginal
        ]);
    }

    public function excluirProduto($id) {
        $stmt = $this->conn->prepare("DELETE FROM produtos WHERE id = :id");
        $stmt->execute([':id' => $id]);
    }

    public function buscarPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM produtos WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            // Instancia o objeto produto a partir dos dados do banco
            return new produto(
                $row['nome'],
                $row['valor'],
                $row['qtde'],
                $row['estoque'],
                $row['id']
            );
        }
        return null;
    }

    public function buscarPorNome($nome) {
        $stmt = $this->conn->prepare("SELECT * FROM produtos WHERE nome LIKE :nome ORDER BY nome");
        $stmt->execute([':nome' => "%$nome%"]);
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new produto(
                $row['nome'],
                $row['valor'],
                $row['qtde'],
                $row['estoque'],
                $row['id']
            );
        }
        return $result;
    }

    public function buscarPorEstoque($estoque) {
        $stmt = $this->conn->prepare("SELECT * FROM produtos WHERE estoque = :estoque ORDER BY nome");
        $stmt->execute([':estoque' => $estoque]);
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new produto(
                $row['nome'],
                $row['valor'],
                $row['qtde'],
                $row['estoque'],
                $row['id']
            );
        }
        return $result;
    }

    public function buscarProdutosBaixoEstoque($qtdeMinima) {
        $stmt = $this->conn->prepare("SELECT * FROM produtos WHERE qtde <= :qtdeMinima ORDER BY qtde ASC");
        $stmt->execute([':qtdeMinima' => $qtdeMinima]);
        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[] = new produto(
                $row['nome'],
                $row['valor'],
                $row['qtde'],
                $row['estoque'],
                $row['id']
            );
        }
        return $result;
    }
}
?>