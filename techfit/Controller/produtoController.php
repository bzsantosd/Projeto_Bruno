<?php

namespace techfit;

require_once __DIR__ . "\\..\\Model\\produtoModel.php"; 

require_once __DIR__ . "\\..\\Model\\produto.php";


class produtoController {
    private $dao;

    public function __construct() {
        $this->dao = new produtoDAO();
    }

    public function ler() {
        return $this->dao->lerProdutos();
    }

    public function criar($nome, $valor, $qtde, $estoque) {
        // 1. Cria o objeto Model/Entidade (id será gerado automaticamente pelo banco)
        $produto = new produto($nome, $valor, $qtde, $estoque, null);
        
        // 2. Chama o método de persistência (DAO)
        $this->dao->criarProduto($produto);
    }

    public function deletar($id) {
        $this->dao->excluirProduto($id);
    }

    
    public function editar($id, $nome, $valor, $qtde, $estoque) {
        // Chama o método de atualização do DAO usando o ID como identificador
        $this->dao->atualizarProduto(
            $id,      // $idOriginal
            $nome,    // $novoNome
            $valor,   // $novoValor
            $qtde,    // $novaQtde
            $estoque  // $novoEstoque
        );
    }

    public function buscar($id) {
        return $this->dao->buscarPorId($id);
    }

    // Método adicional para buscar produtos por nome
    public function buscarPorNome($nome) {
        return $this->dao->buscarPorNome($nome);
    }

    // Método adicional para buscar produtos por localização no estoque
    public function buscarPorEstoque($estoque) {
        return $this->dao->buscarPorEstoque($estoque);
    }

    // Método adicional para buscar produtos com estoque baixo
    public function buscarProdutosBaixoEstoque($qtdeMinima = 10) {
        return $this->dao->buscarProdutosBaixoEstoque($qtdeMinima);
    }
}