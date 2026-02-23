<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trajetória do Casal - ECC Santo Antônio</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        .search-container { position: relative; margin-bottom: 30px; }
        
        .lista-sugestoes {
            position: absolute; width: 100%; background: white;
            border: 1px solid #ddd; border-radius: 0 0 8px 8px;
            max-height: 300px; overflow-y: auto; z-index: 100; display: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .item-sugestao { 
            padding: 12px; cursor: pointer; border-bottom: 1px solid #eee; 
            transition: background 0.2s;
        }
        
        .item-sugestao:hover { background: #f8f9fa; color: #81693b; }
        
        .item-todos { 
            background: #e8f5e9; font-weight: bold; color: #2e7d32;
            position: sticky; top: 0; z-index: 101;
        }

        .resumo-header { 
            background: #fafafa; padding: 20px; border-radius: 12px; 
            border-left: 5px solid #81693b; margin-bottom: 25px; display: none; 
        }

        .badge-ano { background: #81693b; color: white; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; }
    </style>
</head>
<body>

        <header class="navbar">
        <div class="nav-container">
            <a href="dashboard.html" class="logo"><img src="img/logoParoquia.png" width="160" alt="Logo Paróquia"></a>
            <nav>
                <ul class="nav-links">
                    <li><a href="secretaria.php">Secretária</a></li>
                    <li><a href="#"></a></li>
                    <li>
                        <a href="api/logout.php" class="logout-btnlogout-btn" title="Sair do Sistema">Logout
                            <i class="fa-solid fa-power-off"></i>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="content">
        <div class="form-card full-width">
            <header class="form-header">
                <h2>Histórico de Trajetória</h2>
                <p>Pesquise um casal ou selecione "Ver Todos" para o relatório geral.</p>
            </header>

            <div class="search-container">
                <input type="text" id="inputBusca" placeholder="Comece a digitar o nome do marido ou da esposa..." class="form-control" style="width: 100%; padding: 15px; border-radius: 8px; border: 1px solid #ddd; box-sizing: border-box; font-size: 16px;">
                <div id="sugestoes" class="lista-sugestoes"></div>
            </div>

            <div id="resumo" class="resumo-header">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h3 id="nome-casal-display" style="margin:0;"></h3>
                    <span id="ano-vivencia-display" class="badge-ano"></span>
                </div>
                <p id="contato-casal-display" style="margin: 10px 0 0 0; color: #666; font-size: 0.9rem;"></p>
            </div>

            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Ano</th>
                            <th>Encontro</th>
                            <th>Equipe de Trabalho</th>
                            <th>Função</th>
                        </tr>
                    </thead>
                    <tbody id="tabela-corpo">
                        <tr>
                            <td colspan="4" style="text-align:center; padding: 40px; color: #999;">
                                Use o campo de busca acima para carregar o histórico.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; 2026 - Gestão Paroquial Inteligente | ECC Santo Antônio</p>
    </footer>

    <script>
        const inputBusca = document.getElementById('inputBusca');
        const sugestoes = document.getElementById('sugestoes');
        let listaCasaisGlobal = [];

        // 1. Carregar lista de casais ao iniciar
        async function carregarCasais() {
            try {
                const res = await fetch('api/listar_casais_api.php');
                listaCasaisGlobal = await res.json();
            } catch (e) {
                console.error("Erro ao carregar casais:", e);
            }
        }

        // 2. Lógica de busca dinâmica
        inputBusca.addEventListener('input', () => {
            const termo = inputBusca.value.trim().toLowerCase();
            
            sugestoes.innerHTML = '';
            sugestoes.style.display = 'block';

            // Adiciona opção "Ver Todos" sempre no topo
            const divTodos = document.createElement('div');
            divTodos.className = 'item-sugestao item-todos';
            divTodos.innerHTML = `📁 VER RELATÓRIO GERAL (TODOS OS CASAIS)`;
            divTodos.onclick = () => carregarTrajetoria(0, "Relatório Geral");
            sugestoes.appendChild(divTodos);

            if (termo.length >= 2) {
                const filtrados = listaCasaisGlobal.filter(c => 
                    (c.ele && c.ele.toLowerCase().includes(termo)) || 
                    (c.ela && c.ela.toLowerCase().includes(termo))
                );

                filtrados.forEach(c => {
                    const div = document.createElement('div');
                    div.className = 'item-sugestao';
                    div.innerHTML = `<strong>${c.ele} & ${c.ela}</strong>`;
                    div.onclick = () => carregarTrajetoria(c.codigo, `${c.ele} & ${c.ela}`);
                    sugestoes.appendChild(div);
                });
            }
        });

        // 3. Função para buscar a trajetória (Individual ou Geral)
        async function carregarTrajetoria(id, nomes) {
            sugestoes.style.display = 'none';
            inputBusca.value = (id === 0) ? "" : nomes;

            try {
                const res = await fetch(`api/listar_trajetoria_api.php?id=${id}`);
                const dados = await res.json();
                const tbody = document.getElementById('tabela-corpo');
                const resumo = document.getElementById('resumo');

                resumo.style.display = 'block';
                tbody.innerHTML = '';

                if (id === 0) {
                    document.getElementById('nome-casal-display').innerText = "Histórico Geral de Equipes";
                    document.getElementById('ano-vivencia-display').innerText = "Geral";
                    document.getElementById('contato-casal-display').innerText = "Listagem cronológica de todos os serviços prestados.";
                } else {
                    document.getElementById('nome-casal-display').innerText = nomes;
                    document.getElementById('ano-vivencia-display').innerText = `Ano ECC: ${dados[0]?.ano_ecc || '---'}`;
                    document.getElementById('contato-casal-display').innerText = `Bairro: ${dados[0]?.bairro || '---'} | Fone: ${dados[0]?.fone || '---'}`;
                }

                // Filtrar apenas quem tem equipe vinculada
                const historico = dados.filter(d => d.encontro !== null);

                if (historico.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="4" style="text-align:center; padding:20px;">Nenhum serviço registrado para este critério.</td></tr>';
                } else {
                    historico.forEach(s => {
                        const tr = document.createElement('tr');
                        // Se for busca geral (id 0), mostra o nome do casal na coluna encontro
                        const localEncontro = id === 0 ? `<strong>[${s.ele} & ${s.ela}]</strong><br>${s.encontro}` : s.encontro;
                        
                        tr.innerHTML = `
                            <td><strong>${s.periodo}</strong></td>
                            <td>${localEncontro}</td>
                            <td>${s.equipe}</td>
                            <td>${s.funcao}</td>
                        `;
                        tbody.appendChild(tr);
                    });
                }
            } catch (e) {
                console.error("Erro na trajetória:", e);
                alert("Erro ao carregar dados do servidor.");
            }
        }

        // Fechar sugestões ao clicar fora
        document.addEventListener('click', (e) => {
            if (e.target !== inputBusca) sugestoes.style.display = 'none';
        });

        // Iniciar lista
        window.addEventListener('DOMContentLoaded', carregarCasais);
    </script>
</body>
</html>