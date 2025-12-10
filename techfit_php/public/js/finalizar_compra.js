document.addEventListener('DOMContentLoaded', () => {
    // Tenta carregar o resumo da compra
    const summaryJSON = localStorage.getItem('finalOrderSummary');
    const summary = summaryJSON ? JSON.parse(summaryJSON) : null;
    
    const subtotalDisplay = document.getElementById('subtotal-checkout-value');
    const shippingDisplay = document.getElementById('shipping-checkout-value');
    const totalDisplay = document.getElementById('total-checkout-value');
    const itemsListDisplay = document.getElementById('items-in-order-list');
    const placeOrderBtn = document.getElementById('place-order-btn');

    /**
     * Atualiza os valores e a lista de itens na tela de checkout.
     */
    function updateCheckoutSummary() {
        if (summary && summary.items) {
            // Atualiza os valores do resumo
            subtotalDisplay.textContent = `R$ ${summary.subtotal.toFixed(2).replace('.', ',')}`;
            shippingDisplay.textContent = `R$ ${summary.shipping.toFixed(2).replace('.', ',')}`;
            totalDisplay.textContent = `R$ ${summary.total.toFixed(2).replace('.', ',')}`;
            
            // Lista os itens do carrinho
            itemsListDisplay.innerHTML = ''; // Limpa a lista antes de adicionar os novos
            summary.items.forEach(item => {
                const listItem = document.createElement('li');
                listItem.textContent = `${item.quantidade}x ${item.nome}`;
                itemsListDisplay.appendChild(listItem);
            });

        } else {
            // Se o resumo não for encontrado, redireciona para o carrinho
            alert('Nenhum pedido para finalizar. Redirecionando para o carrinho.');
            window.location.href = 'carrinho.html';
            return; // Interrompe a execução
        }
    }

    /**
     * Simula a finalização do pedido.
     */
    function handlePlaceOrder() {
        // Validação básica do formulário (pode ser mais complexa)
        const form = document.getElementById('checkout-data-form');
        if (!form.reportValidity()) {
            // Se o formulário não for válido (campos 'required' vazios), interrompe
            return;
        }

        // 1. Notificação de Sucesso
        alert('🎉 Pedido Realizado com Sucesso! (Simulação)');
        
        // 2. Limpar o carrinho e o resumo após a finalização
        localStorage.removeItem('techfitCart'); 
        localStorage.removeItem('finalOrderSummary'); 
        
        // 3. Redirecionar para uma página de confirmação (aqui, para a home)
        window.location.href = 'tela inicial.html';
    }

    /**
     * Atualiza o contador de itens no ícone do carrinho no header (se houver).
     */
    function updateCartCounter() {
        const cart = JSON.parse(localStorage.getItem('techfitCart') || '[]');
        const totalCount = cart.reduce((sum, item) => sum + item.quantidade, 0);
        const cartCounter = document.getElementById('cart-counter');
        
        if (cartCounter) {
            cartCounter.textContent = totalCount > 0 ? totalCount : 0;
            // Opcional: esconder se for 0, mas aqui mantemos 0.
        }
    }

    // Inicialização
    updateCheckoutSummary();
    updateCartCounter();
    
    // Adiciona o listener ao botão
    if (placeOrderBtn) {
        placeOrderBtn.addEventListener('click', handlePlaceOrder);
    }
});