<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Contato</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        .details {
            margin-bottom: 20px;
        }
        .details label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Detalhes do Contato</h1>

    <button style="margin-bottom: 20px"> <a href="/contact-list">Voltar</a></button>
    <div id="contact-details">

    </div>

    <script>
        const apiUrl = '/api/contact';
        const contactId = window.location.pathname.split('/').pop();

        async function fetchContactDetails(id) {
            try {
                const response = await axios.get(`${apiUrl}/${id}`);

                const contact = response.data.data;

                const detailsDiv = document.getElementById('contact-details');
                detailsDiv.innerHTML = `
                <div class="details">
                        <label>Id:</label>
                        <span>${contact.id}</span>
                    </div>
                    <div class="details">
                        <label>Nome:</label>
                        <span>${contact.nome}</span>
                    </div>
                    <div class="details">
                        <label>Email:</label>
                        <span>${contact.email}</span>
                    </div>
                    <div class="details">
                        <label>Telefone:</label>
                        <span>${contact.telefone}</span>
                    </div>
                    <div class="details">
                        <label>Criado Em:</label>
                        <span>${contact.criadoEm}
                    </div>
                    <div class="details">
                        <label>Atualizado Em:</label>
                        <span>${contact.atualizadoEm}
                    </div>
                    <div class="details">
                        <label>Deletado Em:</label>
                        <span>${contact.deletadoEm}
                    </div>
                    <!-- Adicione outros campos aqui -->
                `;
            } catch (error) {
                console.error('Erro ao buscar detalhes do contato:', error);
            }
        }
        fetchContactDetails(contactId);
    </script>
</body>
</html>
