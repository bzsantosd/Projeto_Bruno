<?php

namespace techfit;

require_once __DIR__ . "\\..\\Model\\treinoModel.php"; 

require_once __DIR__ . "\\..\\Model\\treino.php";


class treinoController {
    private $dao;

    public function __construct() {
        $this->dao = new treinoDAO();
    }

    public function ler() {
        return $this->dao->lerTreinos();
    }

    public function criar($nome, $horario, $data, $repeticoes) {
        // 1. Cria o objeto Model/Entidade (id será gerado automaticamente pelo banco)
        $treino = new treino(null, $nome, $horario, $data, $repeticoes);
        
        // 2. Chama o método de persistência (DAO)
        $this->dao->criarTreino($treino);
    }

    public function deletar($id) {
        $this->dao->excluirTreino($id);
    }

    
    public function editar($id, $nome, $horario, $data, $repeticoes) {
        // Chama o método de atualização do DAO usando o ID como identificador
        $this->dao->atualizarTreino(
            $id,         // $idOriginal
            $nome,       // $novoNome
            $horario,    // $novoHorario
            $data,       // $novaData
            $repeticoes  // $novasRepeticoes
        );
    }

    public function buscar($id) {
        return $this->dao->buscarPorId($id);
    }

    // Método adicional para buscar treinos por nome
    public function buscarPorNome($nome) {
        return $this->dao->buscarPorNome($nome);
    }

    // Método adicional para buscar treinos por data específica
    public function buscarPorData($data) {
        return $this->dao->buscarPorData($data);
    }

    // Método adicional para buscar treinos em um período
    public function buscarPorPeriodo($dataInicio, $dataFim) {
        return $this->dao->buscarPorPeriodo($dataInicio, $dataFim);
    }

    // Método adicional para buscar treinos do dia atual
    public function buscarTreinosHoje() {
        return $this->dao->buscarTreinosHoje();
    }
}