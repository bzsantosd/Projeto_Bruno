<?php
namespace techfit;

require_once __DIR__ . "\\..\\Model\\admModel.php"; 

require_once __DIR__ . "\\..\\Model\\admin.php";


class admController {
    private $dao;

    public function __construct() {
        $this->dao = new admDAO();
    }

    public function ler() {
        return $this->dao->lerAdmins();
    }

    public function criar($nome, $cargo, $email, $senha) {
        // 1. Cria o objeto Model/Entidade
        $admin = new admin($nome, $cargo, $email, $senha);
        
        // 2. Chama o método de persistência (DAO)
        $this->dao->criarAdmin($admin);
    }

    public function deletar($email) {
        $this->dao->excluirAdmin($email);
    }

    
    public function editar($email, $nome, $cargo, $senha) {
        // Chama o método de atualização do DAO, onde o emailOriginal é igual ao novoEmail.
        $this->dao->atualizarAdmin(
            $email,     // $emailOriginal
            $nome,      // $novoNome
            $cargo,     // $novoCargo
            $email,     // $novoEmail (mantém o mesmo)
            $senha      // $novaSenha
        );
    }
    public function buscar($email) {
        return $this->dao->buscarPorEmail($email);
    }
}