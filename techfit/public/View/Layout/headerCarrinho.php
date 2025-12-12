<link rel="stylesheet" href="../../css/header.css">
<link rel="stylesheet" href="../../css/headerCarrinho.css">
<header class="header-content">
    <nav class="navbar">
        <ul class="nav-list">
            <li class="nav-item"><a onclick="navegarPara('/home')" data-page="home">HOME</a></li>
            <li class="nav-item"><a onclick="navegarPara('/planos')" data-page="planos">PLANOS</a></li>
            <li class="nav-item active"><a onclick="navegarPara('/produtos')" data-page="produtos">PRODUTOS</a></li>
            <li class="nav-item"><a onclick="navegarPara('/contato')" data-page="contato">CONTATO</a></li>
            <li class="nav-item"><a onclick="navegarPara('/sobrenos')" data-page="sobre">SOBRE NÓS</a></li>
        </ul>
    </nav>
    
    <div class="nav-actions">
        <li class="nav-item cart-icon-item">
            <a onclick="navegarPara('/carrinho')" data-page="carrinho">
                <i class="fas fa-shopping-cart"></i>
                <span id="cart-counter" class="cart-badge">0</span>
            </a>
        </li>
    </div>
</header>
<script src="./js/navegar.js"></script>