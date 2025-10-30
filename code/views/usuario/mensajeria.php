<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mensajería | QueLaburo</title>

  <link rel="stylesheet" href="css/header.css">
  <link rel="stylesheet" href="css/footer.css">
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/mensajeria.css">
</head>
<body>

  <?php include 'components/header-usuario.php'; ?>

  <main class="chat-container">
    <aside class="chat-sidebar">
      <h2>Contactos</h2>
      <ul id="lista-contactos"></ul>
    </aside>

    <section class="chat-main">
      <div id="chat-header">
        <h2 id="chat-nombre"></h2>
      </div>
      <div id="chat-mensajes" class="chat-mensajes"></div>

      <form id="form-mensaje" class="chat-form">
        <input type="hidden" id="id_receptor" name="id_receptor">
        <textarea id="contenido" name="contenido" placeholder="Escribe un mensaje..." required></textarea>
        <button type="submit">Enviar</button>
      </form>
    </section>
  </main>

  <?php include 'components/footer.php'; ?>

  <script>
    const idEmisor = <?= $_SESSION['usuario']['id'] ?>;

    // Cargar lista de contactos
    async function cargarContactos() {
      const res = await fetch('index.php?controller=mensaje&action=getContactos');
      const data = await res.json();
      const lista = document.getElementById('lista-contactos');
      lista.innerHTML = '';
      data.forEach(u => {
        const li = document.createElement('li');
        li.textContent = u.nombre;
        li.dataset.id = u.id;
        li.onclick = () => abrirChat(u.id, u.nombre);
        lista.appendChild(li);
      });
    }

    // Abrir chat con usuario
    async function abrirChat(id, nombre) {
      document.getElementById('chat-nombre').textContent = nombre;
      document.getElementById('id_receptor').value = id;
      const res = await fetch(`index.php?controller=mensaje&action=getConversacion&id=${id}`);
      const mensajes = await res.json();
      const cont = document.getElementById('chat-mensajes');
      cont.innerHTML = '';
      mensajes.forEach(m => {
        const div = document.createElement('div');
        div.classList.add('msg', m.id_emisor == idEmisor ? 'msg-emisor' : 'msg-receptor');
        div.innerHTML = `<p>${m.contenido}</p><small>${m.fecha}</small>`;
        cont.appendChild(div);
      });
      cont.scrollTop = cont.scrollHeight;
    }

    // Enviar mensaje
    document.getElementById('form-mensaje').addEventListener('submit', async (e) => {
      e.preventDefault();
      const receptor = document.getElementById('id_receptor').value;
      const contenido = document.getElementById('contenido').value.trim();
      if (!contenido || !receptor) return;

      await fetch('index.php?controller=mensaje&action=enviar', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: `id_receptor=${receptor}&contenido=${encodeURIComponent(contenido)}`
      });

      document.getElementById('contenido').value = '';
      abrirChat(receptor, document.getElementById('chat-nombre').textContent);
    });

    cargarContactos();
  </script>

</body>
</html>
