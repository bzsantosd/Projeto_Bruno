// Produtos.js - Exibe produtos fixos + cadastrados dinamicamente

document.addEventListener('DOMContentLoaded', () => {
    const productsGrid = document.querySelector('.products-grid');

    // 1. PRODUTOS FIXOS (os que já existem no HTML)
    const productDataMap = {
        'C001': { 'nome-produto': 'Conjunto Masculino', 'preco-unitario': 'R$ 69,90' },
        'C002': { 'nome-produto': 'Conjunto Feminino', 'preco-unitario': 'R$ 69,90' },
        'S001': { 'nome-produto': 'Creatina 500g', 'preco-unitario': 'R$ 34,90' },
        'S002': { 'nome-produto': 'Whey', 'preco-unitario': 'R$ 39,90' },
        'S003': { 'nome-produto': 'Suplementos', 'preco-unitario': 'R$ 34,90' }
    };

    // --- FUNÇÕES DE CARRINHO ---

    const getCart = () => {
        const cartJSON = localStorage.getItem('techfitCart');
        return cartJSON ? JSON.parse(cartJSON) : [];
    };

    const saveCart = (cart) => {
        localStorage.setItem('techfitCart', JSON.stringify(cart));
        updateCartCount();
    };

    const addToCart = (productCode, productName, productPrice) => {
        const cart = getCart();
        const existingItemIndex = cart.findIndex(item => item.codigo === productCode);

        if (existingItemIndex > -1) {
            cart[existingItemIndex].quantidade++;
        } else {
            cart.push({
                codigo: productCode,
                nome: productName,
                preco: productPrice,
                quantidade: 1
            });
        }
        saveCart(cart);
        alert(`"${productName}" adicionado ao carrinho!`);
    };
    
    const updateCartCount = () => {
        const cart = getCart();
        const totalItems = cart.reduce((sum, item) => sum + item.quantidade, 0);
        
        const cartBadge = document.getElementById('cart-counter');
        if (cartBadge) {
            cartBadge.textContent = totalItems;
        }
    };

    // --- FUNÇÃO PARA CARREGAR PRODUTOS CADASTRADOS ---
    
    function carregarProdutosCadastrados() {
        const produtosCadastrados = JSON.parse(localStorage.getItem('produtosAcademia')) || [];
        
        if (produtosCadastrados.length === 0) {
            return; // Não há produtos cadastrados
        }

        // Para cada produto cadastrado, cria um card
        produtosCadastrados.forEach(produto => {
            const productCard = document.createElement('div');
            productCard.className = 'product-card';
            
            productCard.innerHTML = `
                <img src="${produto.imagem}" alt="${produto.nome}" class="product-image">
                <div class="product-details">
                    <h3 class="product-title">${produto.nome}</h3>
                    <p class="product-description">${produto.descricao || 'Produto cadastrado na academia'}</p>
                </div>
                <div class="product-price-box">
                    <p class="product-price">${produto.preco}</p>
                    <button class="action-button add-to-cart" data-code="${produto.codigo}" data-name="${produto.nome}" data-price="${produto.preco}">
                        Colocar no Carrinho
                    </button>
                </div>
            `;
            
            productsGrid.appendChild(productCard);
        });
    }

    // --- MANIPULAÇÃO DE EVENTOS ---

    if (productsGrid) {
        // Event delegation para produtos fixos E dinâmicos
        productsGrid.addEventListener('click', (e) => {
            if (e.target.classList.contains('add-to-cart')) {
                const productCode = e.target.getAttribute('data-code');
                
                // Verifica se é produto fixo (tem no map)
                if (productDataMap[productCode]) {
                    const product = productDataMap[productCode];
                    addToCart(productCode, product['nome-produto'], product['preco-unitario']);
                } else {
                    // É um produto cadastrado dinamicamente
                    const productName = e.target.getAttribute('data-name');
                    const productPrice = e.target.getAttribute('data-price');
                    
                    if (productName && productPrice) {
                        addToCart(productCode, productName, productPrice);
                    } else {
                        alert('Erro: Produto não encontrado.');
                    }
                }
            }
        });
    }
    
    // Carrega produtos cadastrados ao iniciar
    carregarProdutosCadastrados();
    
    // Atualiza o contador do carrinho
    updateCartCount();
});