document.addEventListener('DOMContentLoaded', function() {
    const chatForm = document.getElementById('chatForm');
    const chatContainer = document.getElementById('chatContainer');
    const chatInput = document.getElementById('chatInput');

    if (!chatForm || !chatContainer || !chatInput) return;

    chatForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const message = chatInput.value.trim();
        if (!message) return;

        // Mostrar mensaje del usuario
        const userMsg = document.createElement('div');
        userMsg.textContent = "Tú: " + message;
        userMsg.style.fontWeight = 'bold';
        chatContainer.appendChild(userMsg);
        chatContainer.scrollTop = chatContainer.scrollHeight;

        chatInput.value = '';

        // Enviar a PHP usando fetch
        const response = await fetch('/chat', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ message })
        });

        const data = await response.json();

        // Mostrar respuesta de la IA
        const botMsg = document.createElement('div');
        botMsg.textContent = "IA: " + data.reply;
        chatContainer.appendChild(botMsg);
        chatContainer.scrollTop = chatContainer.scrollHeight;
    });
});
