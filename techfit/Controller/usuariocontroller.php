<?php

namespace techfit;

require_once __DIR__ . "\\..\\Model\\usuarioModel.php"; 
require_once __DIR__ . "\\..\\Model\\usuario.php";

class usuarioController {
    private $dao;

    public function __construct() {
        $this->dao = new usuarioDAO();
    }

    public function ler() {
        return $this->dao->lerUsuarios();
    }

    public function criar($nome, $cpf, $email, $senha, $plano) {
        // Cria o objeto Model/Entidade (ID será null pois ainda não existe no banco)
        $usuario = new usuario($nome, $cpf, $email, $senha, $plano);
        
        // Chama o método de persistência (DAO)
        $this->dao->criarUsuario($usuario);
        
        // Retorna o usuário criado (agora com o ID preenchido)
        return $usuario;
    }

    public function deletar($email) {
        $this->dao->excluirUsuario($email);
    }

    public function deletarPorId($id) {
        $this->dao->excluirUsuarioPorId($id);
    }

    public function editar($email, $nome, $cpf, $senha, $plano) {
        // Atualiza usando o email como referência
        $this->dao->atualizarUsuario(
            $email,  // $emailOriginal
            $nome,   // $novoNome
            $cpf,    // $novoCpf
            $email,  // $novoEmail (mantém o mesmo)
            $senha,  // $novaSenha
            $plano   // $novoPlano
        );
    }

    public function editarPorId($id, $nome, $cpf, $email, $senha, $plano) {
        // Atualiza usando o ID como referência (mais seguro)
        $this->dao->atualizarUsuarioPorId($id, $nome, $cpf, $email, $senha, $plano);
    }

    public function buscar($email) {
        return $this->dao->buscarPorEmail($email);
    }

    public function buscarPorId($id) {
        return $this->dao->buscarPorId($id);
    }

    public function buscarPorCpf($cpf) {
        return $this->dao->buscarPorCpf($cpf);
    }

    public function buscarPorNome($nome) {
        return $this->dao->buscarPorNome($nome);
    }

    public function buscarPorPlano($plano) {
        return $this->dao->buscarPorPlano($plano);
    }

    public function verificarLogin($email, $senha) {
        return $this->dao->verificarLogin($email, $senha);
    }
}
?>