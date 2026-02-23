<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Montar Equipe de Trabalho</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
        <header class="navbar">
        <div class="nav-container">
            <a href="dashboard.html" class="logo"><img src="img/logoParoquia.png" width="160" alt="Logo Paróquia"></a>
            <nav>
                <ul class="nav-links">
                    <li><a href="equipe-trabalho.php">Voltar</a></li>
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
        <div class="form-card">
            <header class="form-header">
                <h2>Escalar Casal para Equipe</h2>
                <p>Selecione o encontro, o casal e a função que irão desempenhar.</p>
            </header>

            <form action="api/salvar_equipe.php" method="POST" class="main-form">
                <div class="form-row">
                    <div class="form-section flex-1">
                        <label>Selecione o Encontro</label>
                        <select name="id_encontro" id="select_encontro" required>
                            <option value="">Carregando encontros...</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-section flex-1">
                        <label>Selecione o Casal</label>
                        <select name="id_casal" id="select_casal" required>
                            <option value="">Carregando casais...</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-section flex-1">
                        <label>Nome da Equipe</label>
                        <select name="nome_equipe" required>
                            <option value="">Selecione uma equipe</option>
                            <option value="Coordenador Geral">Coordenador Geral</option>
                            <option value="Sala">Sala</option>
                            <option value="Compras">Compras</option>
                            <option value="Café e minimercado">Café e minimercado</option>
                            <option value="Ordem e Limpeza">Ordem e Limpeza</option>
                            <option value="Acolhida">Acolhida</option>
                            <option value="Secretaria">Secretária</option>
                            <option value="Cozinha">Cozinha</option>
                            <option value="Liturgia e vigilia">Liturgia e vigília</option>
                            <option value="Visitação">Visitação</option>
                            <option value="Círculos">Círculos</option>
                        </select>
                    </div>
                    <div class="form-section flex-1">
                        <label>Função / Cargo</label>
                        <select name="funcao" required> 
                            <option value="">Selecione uma função</option>
                            <option value="Coordenador">Coordenador</option>
                            <option value="Membro">Membro</option>
                        </select>
                    </div>
                </div>

                <div class="form-buttons">
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Salvar na Equipe</button>
                </div>
            </form>
        </div>
    </main>

    <script>
        async function carregarDados() {
            try {
                // 1. Carregar Encontros
                const resEncontros = await fetch('api/listar_encontros_api.php');
                const encontros = await resEncontros.json();
                const selectEnc = document.getElementById('select_encontro');
                
                selectEnc.innerHTML = '<option value="">Escolha um encontro</option>';
                encontros.forEach(e => {
                    const option = document.createElement('option');
                    // Ajustado para as colunas minúsculas do seu SQL: codigo, encontro, periodo
                    option.value = e.codigo; 
                    option.textContent = `${e.encontro} (${e.periodo})`;
                    selectEnc.appendChild(option);
                });

                // 2. Carregar Casais
                const resCasais = await fetch('api/listar_casais_api.php');
                const casais = await resCasais.json();
                const selectCas = document.getElementById('select_casal');
                
                selectCas.innerHTML = '<option value="">Escolha um casal</option>';
                casais.forEach(c => {
                    const option = document.createElement('option');
                    // Ajustado para as colunas minúsculas: codigo, ele, ela
                    option.value = c.codigo; 
                    option.textContent = `${c.ele} & ${c.ela}`;
                    selectCas.appendChild(option);
                });

            } catch (error) {
                console.error("Erro ao carregar dados:", error);
                document.getElementById('select_encontro').innerHTML = '<option>Erro ao carregar</option>';
                document.getElementById('select_casal').innerHTML = '<option>Erro ao carregar</option>';
            }
        }

        carregarDados();
    </script>
</body>
</html>