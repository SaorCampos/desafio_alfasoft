<h2>Criar Novo Contato</h2>
<form id="create-contact-form">
    <input type="text" name="nome" placeholder="Nome" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="telefone" placeholder="Telefone" required>
    <button type="submit">Criar</button>
</form>

<script>
    document.getElementById('create-contact-form').addEventListener('submit', async function(event) {
        event.preventDefault();

        const formData = new FormData(event.target);

        try {
            const response = await axios.post('/api/contact/create', {
                nome: formData.get('nome'),
                email: formData.get('email'),
                telefone: formData.get('telefone')
            });

            alert('Contato criado com sucesso!');
            fetchContacts();
        } catch (error) {
            console.error('Erro ao criar contato:', error);
            alert('Erro ao criar contato.');
        }
    });
</script>
