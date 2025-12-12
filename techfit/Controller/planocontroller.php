<?php

namespace techfit;

require_once __DIR__ . "\\..\\Model\\planoModel.php"; 

require_once __DIR__ . "\\..\\Model\\plano.php";


class planoController {
    private $dao;

    public function __construct() {
        $this->dao = new planoDAO();
    }

    public function ler() {
        return $this->dao->lerPlanos();
    }

    public function criar($plano, $valor, $beneficios, $pagamento) {
        // 1. Cria o objeto Model/Entidade
        $planoObj = new plano($plano, $valor, $beneficios, $pagamento);
        
        // 2. Chama o método de persistência (DAO)
        $this->dao->criarPlano($planoObj);
    }

    public function deletar($plano) {
        $this->dao->excluirPlano($plano);
    }

    
    public function editar($plano, $valor, $beneficios, $pagamento) {
        // Chama o método de atualização do DAO, onde o planoOriginal é igual ao novoPlano.
        $this->dao->atualizarPlano(
            $plano,      // $planoOriginal
            $plano,      // $novoPlano (mantém o mesmo)
            $valor,      // $novoValor
            $beneficios, // $novosBeneficios
            $pagamento   // $novoPagamento
        );
    }

    public function buscar($plano) {
        return $this->dao->buscarPorNome($plano);
    }

    // Método adicional para buscar planos por faixa de valor
    public function buscarPorValor($valorMinimo, $valorMaximo) {
        return $this->dao->buscarPorValor($valorMinimo, $valorMaximo);
    }

    // Método adicional para buscar planos por tipo de pagamento
    public function buscarPorPagamento($pagamento) {
        return $this->dao->buscarPorPagamento($pagamento);
    }
}