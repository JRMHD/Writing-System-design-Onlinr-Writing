import "./bootstrap";
import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

// Replace `receiver_id` with the actual receiver ID you need to listen for.
const receiver_id = "your_receiver_id"; // Make sure to set this appropriately

// Listen to the private channel for new messages
window.Echo.private(`chat.${receiver_id}`).listen("MessageSent", (e) => {
    console.log(e.message);
    // Here you can update your chat window dynamically
    // For example, append the message to the chat UI
    const chatWindow = document.getElementById("chat-window"); // Replace with your chat window ID
    if (chatWindow) {
        const messageElement = document.createElement("div");
        messageElement.textContent = e.message;
        chatWindow.appendChild(messageElement);
    }
});
