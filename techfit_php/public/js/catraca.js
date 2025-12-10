const openModalBtn = document.getElementById('open-catraca-modal');
const closeModalBtn = document.getElementById('close-catraca-modal');
const modalOverlay = document.getElementById('catraca-modal-overlay');
const catracaText = document.getElementById('qr-status-text');
const qrcodeDiv = document.getElementById('qrcode');

let approvalTimeout;
let qrcodeInstance = null;

// Função para gerar um novo QR Code
function generateQRCode() {
    // Limpa o conteúdo anterior
    qrcodeDiv.innerHTML = '';
    
    // Gera um ID de acesso aleatório
    const accessId = 'TECHFIT-' + Math.random().toString(36).substr(2, 9).toUpperCase();
    
    // Instancia o objeto QRCode
    qrcodeInstance = new QRCode(qrcodeDiv, {
        text: accessId,
        width: 200,
        height: 200,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H
    });
}

// Função para abrir o modal
function openCatracaModal() {
    generateQRCode();
    
    // Reseta o estado
    catracaText.textContent = "Escaneie o QR Code para acessar";
    catracaText.style.color = ''; // Remove cor de aprovação/rejeição
    qrcodeDiv.classList.remove('approved');

    // Exibe o modal com transição
    modalOverlay.style.display = 'flex';
    setTimeout(() => {
        modalOverlay.classList.add('active');
    }, 10);
    
    startApprovalTimer();
}

// Função para fechar o modal
function closeCatracaModal() {
    clearTimeout(approvalTimeout); // Limpa o timer de aprovação
    modalOverlay.classList.remove('active');
    
    // Esconde o modal após a transição de opacidade
    setTimeout(() => {
        modalOverlay.style.display = 'none';
    }, 300);
}

// Função para simular a aprovação automática do QR Code
function startApprovalTimer() {
    // Simula o tempo de processamento do escaneamento (3 segundos)
    approvalTimeout = setTimeout(() => {
        // Estado de APROVADO
        catracaText.textContent = "✓ Acesso APROVADO!";
        catracaText.style.color = '#1abc9c'; // Cor verde de aprovação
        qrcodeDiv.classList.add('approved'); // Adiciona o efeito visual de aprovação
        
        // Fecha o modal após 2 segundos de visualização da aprovação
        setTimeout(() => {
            closeCatracaModal();
            // Reseta a cor do texto após o fechamento
            setTimeout(() => {
                catracaText.style.color = '';
            }, 500); 
        }, 2000);
    }, 3000);
}

// Event Listeners
openModalBtn.addEventListener('click', openCatracaModal);
closeModalBtn.addEventListener('click', closeCatracaModal);

// Fecha o modal ao clicar fora da área de conteúdo (overlay)
modalOverlay.addEventListener('click', function(e) {
    if (e.target === modalOverlay) {
        closeCatracaModal();
    }
});