document.addEventListener('DOMContentLoaded', () => {
    // Carrega o resumo da compra
    const summaryJSON = localStorage.getItem('finalOrderSummary');
    const summary = summaryJSON ? JSON.parse(summaryJSON) : null;
    
    const subtotalDisplay = document.getElementById('subtotal-checkout-value');
    const shippingDisplay = document.getElementById('shipping-checkout-value');
    const totalDisplay = document.getElementById('total-checkout-value');
    const itemsListDisplay = document.getElementById('items-in-order-list');
    const placeOrderBtn = document.getElementById('place-order-btn');
    
    // Elementos das formas de pagamento
    const paymentRadios = document.querySelectorAll('input[name="payment"]');
    const pixSection = document.getElementById('pix-section');
    const cartaoSection = document.getElementById('cartao-section');
    const boletoSection = document.getElementById('boleto-section');

    /**
     * Atualiza os valores e a lista de itens na tela de checkout.
     */
    function updateCheckoutSummary() {
        if (summary && summary.items) {
            subtotalDisplay.textContent = `R$ ${summary.subtotal.toFixed(2).replace('.', ',')}`;
            shippingDisplay.textContent = `R$ ${summary.shipping.toFixed(2).replace('.', ',')}`;
            totalDisplay.textContent = `R$ ${summary.total.toFixed(2).replace('.', ',')}`;
            
            itemsListDisplay.innerHTML = '';
            summary.items.forEach(item => {
                const listItem = document.createElement('li');
                listItem.textContent = `${item.quantidade}x ${item.nome}`;
                itemsListDisplay.appendChild(listItem);
            });

        } else {
            alert('Nenhum pedido para finalizar. Redirecionando para o carrinho.');
            window.location.href = 'carrinho.html';
            return;
        }
    }

    /**
     * Gera um código PIX aleatório (simulação)
     */
    function gerarCodigoPix() {
        const caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let codigo = '';
        for (let i = 0; i < 32; i++) {
            codigo += caracteres.charAt(Math.floor(Math.random() * caracteres.length));
        }
        return codigo;
    }

    /**
     * Gera QR Code usando uma API pública
     */
    function gerarQRCode(texto) {
        return `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${encodeURIComponent(texto)}`;
    }

    /**
     * Exibe a seção correspondente ao método de pagamento
     */
    function mostrarSecaoPagamento(metodo) {
        // Esconde todas as seções
        pixSection.style.display = 'none';
        cartaoSection.style.display = 'none';
        boletoSection.style.display = 'none';

        // Mostra a seção selecionada
        if (metodo === 'pix') {
            pixSection.style.display = 'block';
            
            // Gera código PIX
            const codigoPix = gerarCodigoPix();
            document.getElementById('pix-code-text').value = codigoPix;
            
            // Gera QR Code
            const qrCodeImg = document.getElementById('qr-code-img');
            qrCodeImg.src = gerarQRCode(codigoPix);
            
        } else if (metodo === 'cartao') {
            cartaoSection.style.display = 'block';
            
            // Atualiza o valor total no formulário do cartão
            const valorTotal = document.getElementById('valor-total-cartao');
            if (valorTotal && summary) {
                valorTotal.textContent = `R$ ${summary.total.toFixed(2).replace('.', ',')}`;
            }
            
        } else if (metodo === 'boleto') {
            boletoSection.style.display = 'block';
            
            // Preenche o email automaticamente se disponível
            const emailInput = document.getElementById('email-boleto');
            const emailCadastro = document.getElementById('email');
            if (emailInput && emailCadastro && emailCadastro.value) {
                emailInput.value = emailCadastro.value;
            }
        }
    }

    /**
     * Copia o código PIX
     */
    function copiarCodigoPix() {
        const codigoInput = document.getElementById('pix-code-text');
        codigoInput.select();
        codigoInput.setSelectionRange(0, 99999); // Para dispositivos móveis
        
        try {
            document.execCommand('copy');
            
            const btnCopiar = document.getElementById('copy-pix-btn');
            const textoOriginal = btnCopiar.textContent;
            btnCopiar.textContent = '✓ Copiado!';
            btnCopiar.style.backgroundColor = '#28a745';
            
            setTimeout(() => {
                btnCopiar.textContent = textoOriginal;
                btnCopiar.style.backgroundColor = '';
            }, 2000);
        } catch (err) {
            alert('Erro ao copiar. Por favor, copie manualmente.');
        }
    }

    /**
     * Processa o pagamento com cartão
     */
    function processarPagamentoCartao(e) {
        e.preventDefault();
        
        // Validação básica
        const numeroCartao = document.getElementById('numero-cartao').value;
        const nomeCartao = document.getElementById('nome-cartao').value;
        const validadeCartao = document.getElementById('validade-cartao').value;
        const cvvCartao = document.getElementById('cvv-cartao').value;
        
        if (!numeroCartao || !nomeCartao || !validadeCartao || !cvvCartao) {
            alert('Por favor, preencha todos os campos do cartão.');
            return;
        }
        
        // Valida formato da validade (MM/AA)
        const validadeRegex = /^(0[1-9]|1[0-2])\/\d{2}$/;
        if (!validadeRegex.test(validadeCartao)) {
            alert('Validade inválida. Use o formato MM/AA');
            return;
        }
        
        // Valida CVV
        if (cvvCartao.length < 3) {
            alert('CVV inválido. Digite 3 ou 4 números.');
            return;
        }
        
        // Simula processamento
        finalizarPedido('Cartão de Crédito');
    }

    /**
     * Finaliza o pedido (SEM REDIRECIONAMENTO)
     */
    function finalizarPedido(metodoPagamento) {
        // Mostra mensagem de sucesso
        alert(`🎉 Pedido Realizado com Sucesso!\n\nMétodo de pagamento: ${metodoPagamento}\n\nObrigado por comprar na Tech Fit!`);
        
        // Limpa o carrinho
        localStorage.removeItem('techfitCart'); 
        localStorage.removeItem('finalOrderSummary');
        
        // Atualiza o contador do carrinho
        updateCartCounter();
        
        // Limpa os formulários
        document.getElementById('checkout-data-form').reset();
        const formCartao = document.getElementById('form-cartao');
        if (formCartao) {
            formCartao.reset();
        }
        
        // Esconde as seções de pagamento
        pixSection.style.display = 'none';
        cartaoSection.style.display = 'none';
        boletoSection.style.display = 'none';
        
        // Reseta os valores do resumo
        subtotalDisplay.textContent = 'R$ 0,00';
        shippingDisplay.textContent = 'R$ 0,00';
        totalDisplay.textContent = 'R$ 0,00';
        itemsListDisplay.innerHTML = '<li style="color: #999;">Nenhum item no carrinho</li>';
    }

    /**
     * Confirma pagamento via PIX
     */
    function confirmarPagamentoPix() {
        const confirmacao = confirm('Você realizou o pagamento via PIX?\n\nClique em OK para confirmar.');
        if (confirmacao) {
            finalizarPedido('PIX');
        }
    }

    /**
     * Envia boleto por email
     */
    function enviarBoleto() {
        const email = document.getElementById('email-boleto').value;
        
        if (!email) {
            alert('Por favor, informe seu e-mail.');
            return;
        }
        
        // Valida email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            alert('Por favor, informe um e-mail válido.');
            return;
        }
        
        alert(`📧 Boleto enviado com sucesso para: ${email}\n\nVerifique sua caixa de entrada e também a pasta de spam.\n\nO boleto vence em 3 dias úteis.`);
        
        // Finaliza o pedido
        finalizarPedido('Boleto Bancário');
    }

    /**
     * Atualiza o contador de itens no carrinho
     */
    function updateCartCounter() {
        const cart = JSON.parse(localStorage.getItem('techfitCart') || '[]');
        const totalCount = cart.reduce((sum, item) => sum + item.quantidade, 0);
        const cartCounter = document.getElementById('cart-counter');
        
        if (cartCounter) {
            cartCounter.textContent = totalCount > 0 ? totalCount : 0;
        }
    }

    // Máscaras para os campos do cartão
    const numeroCartaoInput = document.getElementById('numero-cartao');
    const validadeCartaoInput = document.getElementById('validade-cartao');
    const cvvCartaoInput = document.getElementById('cvv-cartao');

    // Máscara para número do cartão (0000 0000 0000 0000)
    if (numeroCartaoInput) {
        numeroCartaoInput.addEventListener('input', (e) => {
            let value = e.target.value.replace(/\D/g, '');
            value = value.replace(/(\d{4})(?=\d)/g, '$1 ');
            e.target.value = value.trim();
        });
    }

    // Máscara para validade (MM/AA)
    if (validadeCartaoInput) {
        validadeCartaoInput.addEventListener('input', (e) => {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.slice(0, 2) + '/' + value.slice(2, 4);
            }
            e.target.value = value;
        });
    }

    // Máscara para CVV (somente números)
    if (cvvCartaoInput) {
        cvvCartaoInput.addEventListener('input', (e) => {
            e.target.value = e.target.value.replace(/\D/g, '');
        });
    }

    // Event Listeners
    paymentRadios.forEach(radio => {
        radio.addEventListener('change', (e) => {
            mostrarSecaoPagamento(e.target.value);
        });
    });

    // Botão copiar PIX
    const btnCopiarPix = document.getElementById('copy-pix-btn');
    if (btnCopiarPix) {
        btnCopiarPix.addEventListener('click', copiarCodigoPix);
    }

    // Botão confirmar PIX
    const btnConfirmarPix = document.getElementById('confirm-pix-btn');
    if (btnConfirmarPix) {
        btnConfirmarPix.addEventListener('click', confirmarPagamentoPix);
    }

    // Formulário do cartão
    const formCartao = document.getElementById('form-cartao');
    if (formCartao) {
        formCartao.addEventListener('submit', processarPagamentoCartao);
    }

    // Botão enviar boleto
    const btnEnviarBoleto = document.getElementById('send-boleto-btn');
    if (btnEnviarBoleto) {
        btnEnviarBoleto.addEventListener('click', enviarBoleto);
    }

    // Inicialização
    updateCheckoutSummary();
    updateCartCounter();
    mostrarSecaoPagamento('cartao'); // Inicia com cartão selecionado
});