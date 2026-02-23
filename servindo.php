<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servindo - Sistema Paroquial</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            <header class="form-header header-flex" style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 20px;">
                <div>
                    <h2>Equipes de Trabalho (Servindo)</h2>
                    <p>Gerencie as escalas de casais para cada equipe do encontro.</p>
                    
                    <div style="display: flex; align-items: center; gap: 15px; margin-top: 15px;">
                        <select id="filtro_encontro" class="form-select" style="width: 350px; margin-top: 0;">
                            <option value="">Carregando encontros...</option>
                        </select>
                        
                        <button onclick="toggleForm()" class="btn btn-primary" style="min-width: 100px;">
                            <i class="fas fa-plus"></i> Novo Cadastro
                        </button>
                        <button onclick="geraCrachas()" class="btn btn-primary" style="min-width: 100px;">
                            <i class="fa-regular fa-address-card"> </i>Gerar Crachas
                        </button>
                    </div>
                </div>
            </header>

            <div id="area-cadastro" style="display:none; background: #f9fafb; padding: 25px; border-radius: 12px; margin-top: 30px; border: 1px dashed #c5a059;">
                <h4 style="margin-bottom: 20px; color: #81693b;">Alimentação de Equipe</h4>
                <form id="formServindo">
                    <div class="form-row">
                        <div class="form-section">
                            <label>Equipe / Pastoral</label>
                            <select name="funcao_equipe" id="cad_funcao" required>
                                <option value="">Carregando equipas...</option>
                            </select>
                        </div>
                        <div class="form-section">
                            <label>Cargo</label>
                            <select name="cargo" required>
                                <option value="Membro">Membro</option>
                                <option value="Coordenador">Coordenador</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-section">
                            <label>Nome do Casal (Ele & Ela)</label>
                            <select name="nome_casal" id="cad_casal" required>
                                <option value="">Carregando casais...</option>
                            </select>
                        </div>
                        <div class="form-section">
                            <label>Telefone / WhatsApp</label>
                            <input type="text" name="telefone" placeholder="(00) 00000-0000">
                        </div>
                    </div>
                    <div class="form-buttons" style="justify-content: flex-start; margin-top: 20px;">
                        <button type="submit" class="btn btn-secondary">Salvar Membro</button>
                        <button type="button" onclick="toggleForm()" class="btn btn-outline" style="min-width: 100px;">Cancelar</button>
                    </div>
                </form>
            </div>

            <hr class="form-divider" style="margin: 30px 0; border: 0; border-top: 1px solid #eee;">

            <div id="lista-servindo">
                <div style="text-align:center; padding: 60px;">
                    <div style="font-size: 3rem; margin-bottom: 20px;">📋</div>
                    <p style="color: #999;">Escolha um encontro acima para visualizar as equipes.</p>
                </div>
            </div>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; 2026 - Gestão Paroquial Inteligente - Patos-PB</p>
    </footer>

 <script>
    // Função para abrir o formulário de novo cadastro
    function toggleForm() {
        const form = document.getElementById('area-cadastro');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }

    // NOVA FUNÇÃO: Gerar Crachás
    function geraCrachas() {
        const idEncontro = document.getElementById('filtro_encontro').value;
        
        if (!idEncontro) {
            alert('Por favor, selecione um encontro primeiro para gerar os crachás!');
            return;
        }

        // Abre a página de crachás em uma nova aba passando o ID do encontro
        window.open(`api/gerar_crachas_servindo.php?encontro=${idEncontro}`, '_blank');
    }

    // Carregar a lista de encontros no select superior
    async function carregarEncontros() {
        try {
            const res = await fetch('api/listar_encontros_api.php');
            const dados = await res.json();
            const select = document.getElementById('filtro_encontro');
            select.innerHTML = '<option value="">Selecione o Encontro...</option>';
            dados.forEach(e => {
                const opt = document.createElement('option');
                opt.value = e.codigo; 
                opt.textContent = `${e.tema} (${e.periodo})`;
                select.appendChild(opt);
            });
        } catch (e) { console.error("Erro encontros:", e); }
    }

    // Carregar as equipes (funções) no select do formulário
    async function carregarFuncoes() {
        try {
            const res = await fetch('api/listar_funcoes.php');
            const dados = await res.json();
            const select = document.getElementById('cad_funcao');
            select.innerHTML = '<option value="">Selecione a Equipa...</option>';
            dados.forEach(f => {
                const opt = document.createElement('option');
                opt.value = f.nome_funcao;
                opt.textContent = f.nome_funcao;
                select.appendChild(opt);
            });
        } catch (e) { console.error("Erro funções:", e); }
    }

    // Carregar todos os casais cadastrados para o formulário
    async function carregarCasaisMembros() {
        try {
            const res = await fetch('api/listar_casais_api.php');
            const casais = await res.json();
            const select = document.getElementById('cad_casal');
            select.innerHTML = '<option value="">Selecione o Casal...</option>';
            casais.forEach(c => {
                const opt = document.createElement('option');
                opt.value = c.codigo;
                opt.textContent = `${c.ele} & ${c.ela}`;
                select.appendChild(opt);
            });
        } catch (e) { console.error("Erro casais:", e); }
    }

    // Buscar e renderizar a tabela de quem está servindo no encontro selecionado
    async function carregarEquipe(idEncontro) {
        if(!idEncontro) return;
        const container = document.getElementById('lista-servindo');
        container.innerHTML = '<p style="text-align:center; padding: 40px;">Buscando escalas...</p>';

        try {
            const res = await fetch(`api/listar_servindo.php?encontro_id=${idEncontro}`);
            const membros = await res.json();
            container.innerHTML = '';

            if (membros.length === 0) {
                container.innerHTML = '<div style="text-align:center; padding: 40px;"><p>Ninguém escalado para este encontro.</p></div>';
                return;
            }

            // Agrupa os membros por Equipe para criar subtítulos
            const equipes = membros.reduce((acc, m) => {
                (acc[m.funcao_equipe] = acc[m.funcao_equipe] || []).push(m);
                return acc;
            }, {});

            for (const nomeEquipe in equipes) {
                let html = `
                <div style="margin-bottom: 35px;">
                    <h3 style="color: #81693b; border-bottom: 2px solid #c5a059; display: inline-block; margin-bottom: 15px; padding-right: 20px;">
                        ${nomeEquipe}
                    </h3>
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Casal</th>
                                <th>Cargo</th>
                                <th>Contacto</th>
                                <th style="text-align:right;">Acções</th>
                            </tr>
                        </thead>
                        <tbody>`;

                equipes[nomeEquipe].forEach(m => {
                    const isCoord = m.cargo === 'Coordenador' ? 'style="font-weight: bold; color: #c5a059;"' : '';
                    html += `
                        <tr>
                            <td ${isCoord}>${m.nome_casal}</td>
                            <td><span class="badge ${m.cargo === 'Coordenador' ? 'badge-success' : 'badge-warning'}" style="min-width: 100px; height: 25px; font-size: 0.7rem;">${m.cargo}</span></td>
                            <td>${m.telefone || '-'}</td>
                            <td style="text-align:right;">
                                <button class="btn-sm btn-delete"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>`;
                });

                html += `</tbody></table></div>`;
                container.innerHTML += html;
            }
        } catch (e) { container.innerHTML = '<p style="text-align:center; color:red;">Erro ao carregar equipas.</p>'; }
    }

    // Eventos de escuta
    document.getElementById('filtro_encontro').addEventListener('change', (e) => carregarEquipe(e.target.value));

    // Salvar novo membro na equipe
    document.getElementById('formServindo').addEventListener('submit', async (e) => {
        e.preventDefault();
        const encontroId = document.getElementById('filtro_encontro').value;
        if(!encontroId) { alert('Selecione um encontro primeiro!'); return; }

        const fd = new FormData(e.target);
        fd.append('encontro_id', encontroId);

        try {
            const res = await fetch('api/salvar_servindo.php', { method: 'POST', body: fd });
            if(res.ok) {
                e.target.reset();
                toggleForm();
                carregarEquipe(encontroId);
            }
        } catch (err) { alert("Erro ao salvar."); }
    });

    // Inicialização ao carregar a página
    window.onload = () => {
        carregarEncontros();
        carregarFuncoes();
        carregarCasaisMembros();
    };
</script>
</body>
</html>