<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechFit Academia - Nossos Planos</title>
    
    <link rel="stylesheet" href="../../css/Planos.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&display=swap" rel="stylesheet">
</head>
<body>
    
    <?php include_once __DIR__ . "\\..\\Layout\\header.php" ?>

    <main class="container">
        
        <h2 class="page-title">ESCOLHA SEU PLANO</h2> 

        <section class="products-section"> 
            <div class="products-grid">
                
                <div class="product-card">
                    <div class="product-details">
                        <h3 class="product-title">PLANO BÁSICO</h3>
                        <p class="card-text"> 
                            🟣 Acesso à Área de Musculação <br>
                            🟣 Aulas coletivas <br>
                            🟣 Estacionamento gratuito
                        </p>
                    </div>
                    <div class="product-price-box">
                        <p class="price-old">de R$150,00</p>
                        <p class="price-new">por R$89,90</p>
                        <a href="Assinatura.html" data-page="assinar agora" class="action-button">Assinar Agora</a>
                    </div>
                </div>   
                
                <div class="product-card">
                    <div class="product-details">
                        <h3 class="product-title">PLANO AVANÇADO</h3>
                        <p class="card-text"> 
                            🟣 Avaliação física trimestral <br>
                            🟣 Treino personalizado <br>
                            🟣 Aulas coletivas <br>
                            🟣 Desconto em Suplementos<br>
                            🟣 TechDance, TechBox, TechCardio
                        </p>
                    </div>
                    <div class="product-price-box">
                        <p class="price-old">de R$199,90</p>
                        <p class="price-new">por R$159,90</p>
                        <a href="Assinatura.html" data-page="Assinar agora" class="action-button">Assinar Agora</a>
                    </div>
                </div>   
                
                <div class="product-card">
                    <div class="product-details">
                        <h3 class="product-title">PLANO PREMIUM</h3>
                       <p class="card-text"> 
                            🟣 Avaliação física Mensal <br>
                            🟣 Armário Privativo <br>
                            🟣 Treino personalizado <br>
                            🟣 Consulta com nutricionista <br>
                            🟣 Tech Fit App<br>
                            🟣 Acesso Ilimitado à Cadeira de massagem
                        </p>
                    </div>
                    <div class="product-price-box">
                        <p class="price-old">de R$260,00</p>
                        <p class="price-new">por R$199,90</p>
                        <a href="Assinatura.html" data-page="assinar agora" class="action-button">Assinar Agora</a>
                    </div>
                </div>
            </div>
        </section>             
    </main>

    <script src="/techfit/public/js/planos.js"></script> 
</body>
</html>