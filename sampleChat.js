// Replace with your WebSocket server URL
const wsUrl = 'ws://localhost:8080/chat'; 

const socket = new WebSocket(wsUrl);
const chatBox = document.getElementById('chat-box');
const messageInput = document.getElementById('message-input');
const sendBtn = document.getElementById('send-btn');

// Handle WebSocket connection open
socket.onopen = () => {
    console.log('Connected to the WebSocket server.');
};

// Handle incoming messages
socket.onmessage = (event) => {
    const message = event.data;
    const messageElement = document.createElement('div');
    messageElement.textContent = message;
    chatBox.appendChild(messageElement);
    chatBox.scrollTop = chatBox.scrollHeight; // Auto-scroll to the latest message
};

// Handle WebSocket errors
socket.onerror = (error) => {
    console.error('WebSocket error:', error);
};

// Handle WebSocket close
socket.onclose = () => {
    console.log('WebSocket connection closed.');
};

// Send message on button click
sendBtn.addEventListener('click', () => {
    const message = messageInput.value.trim();
    if (message) {
        socket.send(message); // Send message to the server
        messageInput.value = ''; // Clear input field
    }
});

// Allow pressing Enter to send the message
messageInput.addEventListener('keypress', (event) => {
    if (event.key === 'Enter') {
        sendBtn.click();
    }
});
