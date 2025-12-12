<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras - Tech Fit</title>
    <link rel="stylesheet" href="../../css/carrinho.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <?php include_once __DIR__ . "\\..\\Layout\\headerCarrinho.php" ?>

    <main class="container">
        
        <h2 class="page-title">Seu Carrinho</h2>

        <div class="cart-container">
            <section class="cart-items" id="cart-items-list">
                </section>

            <aside class="cart-summary" id="cart-summary">
                <h3>Resumo do Pedido</h3>
                <div class="summary-line">
                    <span>Subtotal:</span>
                    <span id="subtotal-value">R$ 0,00</span>
                </div>
                <div class="summary-line">
                    <span>Frete:</span>
                    <span id="shipping-value">R$ 0,00</span> </div>
                <div class="summary-line total-line">
                    <span>Total:</span>
                    <span id="total-value">R$ 0,00</span>
                </div>
                <button class="action-button checkout-btn" disabled>Finalizar Compra</button>
            </aside>

        </div>
        
    </main>
    
    <script src="../../js/carrinho.js"></script> 
</body>
</html>