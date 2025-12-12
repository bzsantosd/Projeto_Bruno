<?php

namespace techfit;

require_once __DIR__ . "\\..\\Model\\AulasModel.php"; 

require_once __DIR__ . "\\..\\Model\\Aulas.php";


class aulasController {
    private $dao;

    public function __construct() {
        $this->dao = new AulasDAO();
    }

    public function ler() {
        return $this->dao->lerAulas();
    }

    public function criar($nome, $horario, $professor) {
        // 1. Cria o objeto Model/Entidade
        $aula = new Aulas($nome, $horario, $professor);
        
        // 2. Chama o método de persistência (DAO)
        $this->dao->criarAula($aula);
    }

    public function deletar($nome) {
        $this->dao->excluirAula($nome);
    }

    
    public function editar($nome, $horario, $professor) {
        // Chama o método de atualização do DAO, onde o nomeOriginal é igual ao novoNome.
        $this->dao->atualizarAula(
            $nome,      // $nomeOriginal
            $nome,      // $novoNome (mantém o mesmo)
            $horario,   // $novoHorario
            $professor  // $novoProfessor
        );
    }

    public function buscar($nome) {
        return $this->dao->buscarPorNome($nome);
    }

    // Método adicional para buscar aulas por professor
    public function buscarPorProfessor($professor) {
        return $this->dao->buscarPorProfessor($professor);
    }
}