/*
 * Arquivo: cadproduto.js
 * Descrição: Lógica para cadastrar produtos com imagem
 */

document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('.cadastro-form');
    const notificacao = document.getElementById('notificacao');

    // Função para exibir notificações
    function exibirNotificacao(mensagem, tipo = 'sucesso') {
        notificacao.textContent = mensagem;
        notificacao.className = `notificacao-popup show ${tipo}`;
        
        setTimeout(() => {
            notificacao.classList.remove('show');
        }, 3000);
    }

    // Função para gerar ID único
    function gerarId() {
        return Date.now();
    }

    // Função para converter imagem em Base64
    function converterImagemParaBase64(file) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.onload = () => resolve(reader.result);
            reader.onerror = reject;
            reader.readAsDataURL(file);
        });
    }

    // Event listener do formulário
    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        // Captura os valores do formulário
        const nome = document.getElementById('nome').value;
        const descricao = document.getElementById('descricao').value;
        const categoria = document.getElementById('categoria').value;
        const preco = parseFloat(document.getElementById('preco').value).toFixed(2);
        const quantidade = parseInt(document.getElementById('quantidade').value);
        const imagemInput = document.getElementById('imagem');

        // Validação básica
        if (!nome || !categoria || !preco || !quantidade) {
            exibirNotificacao('Por favor, preencha todos os campos obrigatórios!', 'erro');
            return;
        }

        // Processa a imagem (se fornecida)
        let imagemBase64 = 'https://via.placeholder.com/300x200?text=Sem+Imagem'; // Imagem padrão
        
        if (imagemInput && imagemInput.files.length > 0) {
            try {
                imagemBase64 = await converterImagemParaBase64(imagemInput.files[0]);
            } catch (error) {
                console.error('Erro ao converter imagem:', error);
                exibirNotificacao('Erro ao processar a imagem', 'erro');
                return;
            }
        }

        // Cria o objeto do produto
        const novoProduto = {
            id: gerarId(),
            codigo: `PROD${gerarId()}`,
            nome: nome,
            descricao: descricao,
            categoria: categoria,
            preco: `R$ ${preco}`,
            precoNumerico: parseFloat(preco),
            quantidade: quantidade,
            imagem: imagemBase64
        };

        // Recupera produtos existentes do localStorage
        let produtos = JSON.parse(localStorage.getItem('produtosAcademia')) || [];
        
        // Adiciona o novo produto
        produtos.push(novoProduto);
        
        // Salva no localStorage
        localStorage.setItem('produtosAcademia', JSON.stringify(produtos));

        // Exibe notificação de sucesso
        exibirNotificacao('Produto cadastrado com sucesso!', 'sucesso');

        // Limpa o formulário
        form.reset();
    });
});