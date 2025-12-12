<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/Produtos.css"> 
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Produtos - Tech Fit</title>
</head>
<body>
    <?php include_once __DIR__ . "\\..\\Layout\\headerCarrinho.php" ?>
    <main>
   
        
        <section class="products-section"> 
            <div class="products-grid">
                
                <div class="product-card">
                    <img src="/IMAGENS/01.jpg" alt="Conjunto Masculino Tech Fit" class="product-image">
                    <div class="product-details">
                        <h3 class="product-title">Conjunto Masculino</h3>
                        <p class="product-description">O Kit Camiseta e Shorts de Performance...</p>
                    </div>
                    <div class="product-price-box">
                        <p class="product-price">R$69,90</p>
                        <button class="action-button add-to-cart" data-code="C001">Colocar no Carrinho</button>
                    </div>
                </div>

                <div class="product-card">
                    <img src="/IMAGENS/02.jpg" alt="Conjunto Feminino Tech Fit" class="product-image">
                    <div class="product-details">
                        <h3 class="product-title">Conjunto Feminino</h3>
                        <p class="product-description">Este conjunto de fitness feminino em preto apresenta um top cropped...</p>
                    </div>
                    <div class="product-price-box">
                        <p class="product-price">R$69,90</p>
                        <button class="action-button add-to-cart" data-code="C002">Colocar no Carrinho</button>
                    </div>
                </div>
                
                <div class="product-card">
                    <img src="/IMAGENS/CREATINA.png" alt="Creatina Tech Fit" class="product-image">
                    <div class="product-details">
                        <h3 class="product-title">Creatina 500g</h3>
                        <p class="product-description">Aumenta a força e explosão muscular.</p>
                    </div>
                    <div class="product-price-box">
                        <p class="product-price">R$34,90</p>
                        <button class="action-button add-to-cart" data-code="S001">Colocar no Carrinho</button>
                    </div>
                </div>
                
                <div class="product-card">
                    <img src="/IMAGENS/whey.png" alt="Whey Tech Fit" class="product-image">
                    <div class="product-details">
                        <h3 class="product-title">Whey Protein</h3>
                        <p class="product-description">Fonte rápida de proteína para a recuperação.</p>
                    </div>
                    <div class="product-price-box">
                        <p class="product-price">R$39,90</p>
                        <button class="action-button add-to-cart" data-code="S002">Colocar no Carrinho</button>
                    </div>
                </div>
                
                <div class="product-card">
                    <img src="/IMAGENS/suplemento.png" alt="Suplementos Tech Fit" class="product-image">
                    <div class="product-details">
                        <h3 class="product-title">Suplementos</h3>
                        <p class="product-description">Auxiliam a nutrição e performance no treino.</p>
                    </div>
                    <div class="product-price-box">
                        <p class="product-price">R$34,90</p>
                        <button class="action-button add-to-cart" data-code="S003">Colocar no Carrinho</button>
                    </div>
                </div>

            </div>
        </section>
    </main>
    
    <script src="../../js/Produtos.js"></script> 
</body>
</html>