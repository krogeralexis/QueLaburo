const contactos = document.querySelectorAll(".contacto");
const chatMensajes = document.getElementById("chat-mensajes");
const formChat = document.getElementById("form-chat");
const idReceptorInput = document.getElementById("id_receptor");
const inputMensaje = document.getElementById("mensaje");

contactos.forEach(c => {
  c.addEventListener("click", async () => {
    const id = c.dataset.id;
    idReceptorInput.value = id;
    chatMensajes.innerHTML = "<p>Cargando conversación...</p>";

    const res = await fetch(`index.php?controller=mensaje&action=getConversacion&id_otro=${id}`);
    const mensajes = await res.json();

    chatMensajes.innerHTML = mensajes.map(m => `
      <div class="msg ${m.id_emisor == id ? 'recibido' : 'enviado'}">
        <p>${m.contenido}</p>
        <small>${m.fecha}</small>
      </div>
    `).join('');
  });
});

formChat.addEventListener("submit", async e => {
  e.preventDefault();
  const contenido = inputMensaje.value.trim();
  const id_receptor = idReceptorInput.value;

  if (!contenido || !id_receptor) return;

  await fetch("index.php?controller=mensaje&action=enviarMensaje", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `id_receptor=${id_receptor}&contenido=${encodeURIComponent(contenido)}`
  });

  inputMensaje.value = "";
  document.querySelector(`li[data-id="${id_receptor}"]`).click();
});
