<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vincular Encontrista - Sistema Paroquial</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>

        <header class="navbar">
        <div class="nav-container">
            <a href="dashboard.html" class="logo"><img src="img/logoParoquia.png" width="160" alt="Logo Paróquia"></a>
            <nav>
                <ul class="nav-links">
                    <li><a href="vivenciando.php">Voltar</a></li>
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
                <h2>Vincular Casal ao Encontro</h2>
                <p>Selecione o encontro, o casal e defina o círculo (cor) de participação.</p>
            </header>

            <form action="api/salvar_encontrista.php" method="POST" class="main-form">
                
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
                        <label>Casal Encontrista</label>
                        <select name="id_casal" id="select_casal" required>
                            <option value="">Carregando casais...</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-section flex-1">
                        <label>Círculo (Cor)</label>
                        <select name="id_circulo" id="select_circulo">
                            <option value="">Carregando círculos...</option>
                        </select>
                    </div>
                </div>

                <div class="form-buttons" style="margin-top: 20px;">
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Confirmar Inscrição</button>
                </div>
            </form>
        </div>
    </main>

    <script>
        async function carregarDropdowns() {
            try {
                // Realiza as 3 chamadas simultâneas para maior velocidade (ADS Practice)
                const [resEncontros, resCasais, resCirculos] = await Promise.all([
                    fetch('api/listar_encontros_api.php'),
                    fetch('api/listar_casais_api.php'),
                    fetch('api/listar_circulos_api.php')
                ]);

                const encontros = await resEncontros.json();
                const casais = await resCasais.json();
                const circulos = await resCirculos.json();

                const selectEnc = document.getElementById('select_encontro');
                const selectCas = document.getElementById('select_casal');
                const selectCir = document.getElementById('select_circulo');

                // 1. Popular Encontros - Ajustado para 'codigo' e 'encontro'
                selectEnc.innerHTML = '<option value="">Escolha o encontro</option>';
                encontros.forEach(e => {
                    const opt = document.createElement('option');
                    opt.value = e.codigo; 
                    opt.textContent = `${e.encontro} (${e.periodo})`;
                    selectEnc.appendChild(opt);
                });

                // 2. Popular Casais - Ajustado para 'codigo', 'ele' e 'ela'
                selectCas.innerHTML = '<option value="">Escolha o casal</option>';
                casais.forEach(c => {
                    const opt = document.createElement('option');
                    opt.value = c.codigo; 
                    opt.textContent = `${c.ele} e ${c.ela}`;
                    selectCas.appendChild(opt);
                });

                // 3. Popular Círculos - Ajustado para 'codigo' e 'circulo'
                selectCir.innerHTML = '<option value="">Sem círculo definido</option>';
                circulos.forEach(ci => {
                    const opt = document.createElement('option');
                    opt.value = ci.codigo; 
                    opt.textContent = ci.circulo; // Ex: VERDE, AZUL...
                    selectCir.appendChild(opt);
                });

            } catch (error) {
                console.error("Erro ao carregar dados:", error);
                alert("Erro ao conectar com o servidor da HostGator. Verifique se as APIs estão na pasta correta.");
            }
        }

        window.onload = carregarDropdowns;
    </script>
</body>
</html>