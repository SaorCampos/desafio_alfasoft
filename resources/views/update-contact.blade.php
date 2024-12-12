<h2>Atualizar Contato</h2>
<form id="create-contact-form">
    <input type="text" name="nome" placeholder="Nome">
    <input type="email" name="email" placeholder="Email">
    <input type="text" name="telefone" placeholder="Telefone">
    <button type="submit">Atualizar</button>
</form>

<script>
    // Função para preencher os campos do formulário com os dados do contato
    async function loadContactData() {
        const contactId = window.location.pathname.split('/').pop();

        try {
            const response = await axios.get(`/api/contact/${contactId}`);
            const contact = response.data.data;

            // Preencher o formulário com os dados do contato
            document.querySelector('input[name="nome"]').value = contact.nome;
            document.querySelector('input[name="email"]').value = contact.email;
            document.querySelector('input[name="telefone"]').value = contact.telefone;
        } catch (error) {
            console.error('Erro ao buscar dados do contato:', error);
            alert('Erro ao carregar dados do contato.');
        }
    }

    // Carregar os dados do contato assim que a página carregar
    window.addEventListener('load', loadContactData);

    // Submissão do formulário de atualização
    document.getElementById('create-contact-form').addEventListener('submit', async function(event) {
        event.preventDefault();

        const contactId = window.location.pathname.split('/').pop();
        const formData = new FormData(event.target);

        try {
            const response = await axios.put(`/api/contact/update/${contactId}`, {
                nome: formData.get('nome'),
                email: formData.get('email'),
                telefone: formData.get('telefone')
            });

            alert('Contato atualizado com sucesso!');
            window.location.href = '/contact-list';
        } catch (error) {
            console.error('Erro ao atualizar contato:', error);
            alert('Erro ao atualizar contato.');
        }
    });
</script>
