<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Contatos Paginada</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>Lista de Contatos</h1>
    <button style="margin: 20px"><a href="/contact-create">Criar</a></button>
    <form id="filter-form">
        <label>
            Nome:
            <input type="text" id="filter-name" name="nome">
        </label>
        <label>
            Email:
            <input type="text" id="filter-email" name="email">
        </label>
        <label>
            Telefone:
            <input type="text" id="filter-phone" name="telefone">
        </label>
        <button type="button" onclick="applyFilters()">Pesquisar</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody id="contact-list">

        </tbody>
    </table>

    <div id="pagination">

    </div>

    <script>
        const apiUrl = '/api/contact';

        let currentPage = 1;
        const perPage = 10;
        let filters = {};

        function loadFiltersFromURL() {
            const params = new URLSearchParams(window.location.search);

            filters = {
                nome: params.get('nome') || '',
                email: params.get('email') || '',
                telefone: params.get('telefone') || ''
            };

            currentPage = parseInt(params.get('page')) || 1;

            document.getElementById('filter-name').value = filters.nome;
            document.getElementById('filter-email').value = filters.email;
            document.getElementById('filter-phone').value = filters.telefone;
        }

        function saveFiltersToURL() {
            const params = new URLSearchParams();

            if (filters.nome) params.set('nome', filters.nome);
            if (filters.email) params.set('email', filters.email);
            if (filters.telefone) params.set('telefone', filters.telefone);
            if (currentPage > 1) params.set('page', currentPage);

            const queryString = params.toString();
            const newUrl = queryString ? `?${queryString}` : window.location.pathname;
            history.replaceState(null, '', newUrl);
        }

        async function fetchContacts(page = 1) {
            try {
                const sanitizedFilters = {};
                for (const key in filters) {
                    if (filters[key]) sanitizedFilters[key] = filters[key];
                }

                const response = await axios.get(apiUrl, {
                    params: {
                        page: page,
                        perPage: perPage,
                        ...sanitizedFilters
                    }
                });

                const { list, pagination } = response.data.data;

                const contactList = document.getElementById('contact-list');
                contactList.innerHTML = '';

                list.forEach(contact => {
                    const row = `
                        <tr>
                            <td><a href="javascript:void(0)" onclick="viewContactDetails(${contact.id})">${contact.nome}</a></td>
                            <td>${contact.email}</td>
                            <td>${contact.telefone}</td>
                            <td>
                                <button class="delete-btn" data-id="${contact.id}">Excluir</button>
                                <button onclick="updateContact(${contact.id})">Atualizar</button>
                            </td>
                        </tr>
                    `;
                    contactList.innerHTML += row;
                });

                // Adicionando o evento de exclusão após o carregamento
                const deleteButtons = document.querySelectorAll('.delete-btn');
                deleteButtons.forEach(button => {
                    button.addEventListener('click', (event) => {
                        const contactId = event.target.getAttribute('data-id');
                        deleteContact(contactId);
                    });
                });

                updatePagination(pagination);
            } catch (error) {
                console.error('Erro ao buscar contatos:', error);
            }
        }

        function updatePagination(pagination) {
            const paginationDiv = document.getElementById('pagination');
            paginationDiv.innerHTML = '';

            const totalPages = Math.ceil(pagination.total / pagination.perPage);

            for (let page = 1; page <= totalPages; page++) {
                const button = document.createElement('button');
                button.textContent = page;
                button.disabled = page === currentPage;
                button.addEventListener('click', () => {
                    currentPage = page;
                    saveFiltersToURL();
                    fetchContacts(page);
                });

                paginationDiv.appendChild(button);
            }
        }

        function applyFilters() {
            const name = document.getElementById('filter-name').value.trim();
            const email = document.getElementById('filter-email').value.trim();
            const phone = document.getElementById('filter-phone').value.trim();

            filters = {};
            if (name) filters.nome = name;
            if (email) filters.email = email;
            if (phone) filters.telefone = phone;

            currentPage = 1;
            saveFiltersToURL();
            fetchContacts(currentPage);
        }

        function viewContactDetails(id) {
            window.location.href = `/contact-list/${id}`;
        }

        function deleteContact(id) {
            if (confirm('Tem certeza que deseja excluir este contato?')) {
                axios.delete(`/api/contact/${id}`)
                    .then(response => {
                        alert('Contato excluído com sucesso!');
                        fetchContacts(currentPage);
                    })
                    .catch(error => {
                        console.error('Erro ao excluir contato:', error);
                        alert('Erro ao excluir contato.');
                    });
            }
        }

        function updateContact(id) {
            window.location.href = `/contact-edit/${id}`;
        }

        loadFiltersFromURL();
        fetchContacts(currentPage);
    </script>

</body>
</html>
