/*
 * Arquivo: produtoscadastrados.js
 * Descrição: Lógica para exibir e excluir produtos.
 */

document.addEventListener('DOMContentLoaded', () => {
    const listaContainer = document.getElementById('lista-produtos');
    const notificacao = document.getElementById('notificacao');

    // --- FUNÇÕES DE UTILIDADE ---

    function exibirNotificacao(mensagem, tipo = 'sucesso') {
        notificacao.textContent = mensagem;
        notificacao.className = `notificacao-popup show ${tipo}`; // Adiciona classe 'sucesso' ou 'erro'
        
        setTimeout(() => {
            notificacao.classList.remove('show');
        }, 3000);
    }
    
    // --- FUNÇÃO DE EXCLUSÃO ---

    window.excluirProduto = function(id) {
        // Confirmação de segurança
        if (!confirm("Tem certeza que deseja excluir este produto?")) {
            return;
        }

        let produtos = JSON.parse(localStorage.getItem('produtosAcademia')) || [];
        
        // Filtra a lista, mantendo apenas os produtos que NÃO têm o ID fornecido
        const novaLista = produtos.filter(produto => produto.id !== id);
        
        // Salva a nova lista (sem o produto excluído) no localStorage
        localStorage.setItem('produtosAcademia', JSON.stringify(novaLista));

        // Atualiza a interface (re-renderiza a lista)
        renderizarProdutos(novaLista);
        
        exibirNotificacao("Produto excluído com sucesso!", 'erro'); // Usa 'erro' para um fundo de destaque
    }

    // --- FUNÇÃO DE RENDERIZAÇÃO DA LISTA ---

    function renderizarProdutos(produtos) {
        // Se nenhuma lista foi passada, carrega do localStorage
        if (!produtos) {
            produtos = JSON.parse(localStorage.getItem('produtosAcademia')) || [];
        }

        if (produtos.length === 0) {
            listaContainer.innerHTML = '<p class="sem-produtos">Nenhum produto cadastrado ainda. Volte para o cadastro.</p>';
            return;
        }

        // Cria a estrutura da tabela
        let html = '<table>';
        html += '<thead><tr><th>Nome</th><th>Categoria</th><th>Preço</th><th>Estoque</th><th>Ações</th></tr></thead>';
        html += '<tbody>';

        produtos.forEach(produto => {
            html += `
                <tr>
                    <td>${produto.nome}</td>
                    <td>${produto.categoria}</td>
                    <td>R$ ${produto.preco}</td>
                    <td>${produto.quantidade}</td>
                    <td>
                        <button class="btn-excluir" onclick="excluirProduto(${produto.id})">
                            Excluir
                        </button>
                    </td>
                </tr>
            `;
        });

        html += '</tbody></table>';
        listaContainer.innerHTML = html;
    }

    // Inicia a renderização quando a página carrega
    renderizarProdutos();
});