<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Imprimir Crachás - Servindo</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Estilos específicos para impressão */
        @media print {
            .navbar, .btn-primary, .filtro-print { display: none; }
            body { background: white; }
            .content { padding: 0; }
            .cracha-card { break-inside: avoid; margin-bottom: 10px; }
        }

        .cracha-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 20px;
        }

        .cracha-card {
            border: 2px solid #c5a059;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            background: white;
            position: relative;
            min-height: 180px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .cracha-card h2 { font-size: 1.4rem; color: #1f2937; margin-bottom: 5px; }
        .cracha-card .equipe { font-weight: 700; color: #81693b; text-transform: uppercase; font-size: 0.9rem; }
        .cracha-card .cargo { font-size: 0.8rem; color: #6b7280; margin-top: 5px; }
        .paroquia-tag { font-size: 0.7rem; color: #9ca3af; margin-top: 15px; border-top: 1px solid #eee; padding-top: 5px; }
    </style>
</head>
<body>
    <header class="navbar">
        <div class="nav-container">
            <a href="dashboard.html" class="logo">⛪ Minha<span>Paróquia</span></a>
            <button onclick="window.print()" class="btn btn-primary" style="width: auto; padding: 10px 20px;">
                <i class="fas fa-print"></i> Imprimir Crachás
            </button>
        </div>
    </header>

    <main class="content">
        <div class="form-card full-width">
            <div class="filtro-print" style="margin-bottom: 30px;">
                <label>Selecione o Encontro para gerar os crachás:</label>
                <select id="filtro_encontro" class="form-select" style="margin-top: 10px;">
                    <option value="">Carregando encontros...</option>
                </select>
            </div>

            <div id="area-crachas" class="cracha-grid">
                </div>
        </div>
    </main>

    <script>
        async function carregarEncontros() {
            const res = await fetch('api/listar_encontros_api.php');
            const dados = await res.json();
            const select = document.getElementById('filtro_encontro');
            select.innerHTML = '<option value="">Selecione...</option>';
            dados.forEach(e => {
                const opt = document.createElement('option');
                opt.value = e.codigo;
                opt.textContent = `${e.tema} (${e.periodo})`;
                select.appendChild(opt);
            });
        }

        async function gerarCrachas(id) {
            if(!id) return;
            const res = await fetch(`api/listar_servindo.php?encontro_id=${id}`);
            const membros = await res.json();
            const container = document.getElementById('area-crachas');
            container.innerHTML = '';

            membros.forEach(m => {
                container.innerHTML += `
                    <div class="cracha-card">
                        <div class="equipe">${m.funcao_equipe}</div>
                        <h2>${m.nome_casal}</h2>
                        <div class="cargo">${m.cargo}</div>
                        <div class="paroquia-tag">ECC Santo Antônio - Patos-PB</div>
                    </div>
                `;
            });
        }

        document.getElementById('filtro_encontro').addEventListener('change', (e) => gerarCrachas(e.target.value));
        window.onload = carregarEncontros;
    </script>
</body>
</html>