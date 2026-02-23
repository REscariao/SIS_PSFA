<<<<<<< HEAD:encontros.php
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão do Encontro - Sistema Paroquial</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        .grid-encontro {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .btn-encontro {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 25px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 12px;
            text-decoration: none;
            color: #333;
            transition: all 0.3s ease;
            text-align: center;
        }
        .btn-encontro:hover {
            transform: translateY(-5px);
            border-color: #1a237e;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .btn-encontro .icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }
        .btn-encontro span {
            font-weight: 600;
            font-size: 1.1rem;
        }
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
                <h2>Documentação do Encontro</h2>
                <p>Gere os relatórios e documentos oficiais para o ECC.</p>
            </header>

            <div class="grid-encontro">
                <a href="api/capa_quadrante.php" target="_blank" class="btn-encontro">
                    <div class="icon">📘</div>
                    <span>Capa Quadrante</span>
                </a>

                  <a href="api/gerar_crachas.php" target="_blank" class="btn-encontro">
                    <div class="icon">🪪</div>
                    <span>Crachás Encontristas</span>
                </a>

                <a href="api/relacao_encontristas.php" target="_blank" class="btn-encontro">
                    <div class="icon">📋</div>
                    <span>Relação de Encontristas</span>
                </a>

                <a href="api/gerar_lista_presenca.php" target="_blank" class="btn-encontro">
                    <div class="icon">✍️</div>
                    <span>Lista de Presença</span>
                </a>

                <a href="aniversariantes.php" class="btn-encontro">
                    <div class="icon">🎂</div>
                    <span>Aniversários</span>
                </a>

                <a href="api/prece_impressao.php" target="_blank" class="btn-encontro">
                    <div class="icon">🙏</div>
                    <span>Prece</span>
                </a>

                <a href="api/gerar_cruz.php" target="_blank" class="btn-encontro">
                    <div class="icon">✝️</div>
                    <span>Cruz</span>
                </a>

                <a href="api/gera_vela.php" target="_blank" class="btn-encontro">
                    <div class="icon">🕯️</div>
                    <span>Velas</span>
                </a>
                
                <a href="api/gera_coracoes.php" target="_blank" class="btn-encontro">
                    <div class="icon">💕</div>
                    <span>Corações</span>
                </a>

                <a href="api/gerar_capas_canto.php" target="_blank" class="btn-encontro">
                    <div class="icon">📘</div>
                    <span>Capa Livro de Canto</span>
                </a>                

                <a href="download/LivroCasalApresentador.docx" download="Capa_Livro_Casal_Apresentador.docx" class="btn-encontro">
                    <div class="icon">📘</div>
                    <span><strong style="font-weight: 900;">Livro casal apresentador</strong></span>
                    <span style="color:#ccc">Tem que editar no word os nomes dos casais</span>
                </a>
            </div>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; 2026 - Gestão Paroquial Inteligente | ECC Patos-PB</p>
    </footer>

</body>
=======
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão do Encontro - Sistema Paroquial</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        .grid-encontro {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .btn-encontro {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 25px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 12px;
            text-decoration: none;
            color: #333;
            transition: all 0.3s ease;
            text-align: center;
        }
        .btn-encontro:hover {
            transform: translateY(-5px);
            border-color: #1a237e;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .btn-encontro .icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }
        .btn-encontro span {
            font-weight: 600;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>


<header class="navbar">
        <div class="nav-container">
            <a href="dashboard.html" class="logo"><img src="img/logoParoquia.png" width="270" alt="Logo Paróquia"></a>
            <nav>
                <ul class="nav-links">
                    <li><a href="secretaria.html">Secretária</a></li>
                    <li><a href="#"></a></li>
                    <li>
                    <a href="logout.php" class="btn-logout" title="Sair">
                        <i class="fa-solid fa-power-off" style="color: #81693b;"></i>
                    </a>    
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="content">
        <div class="form-card full-width">
            <header class="form-header">
                <h2>Documentação do Encontro</h2>
                <p>Gere os relatórios e documentos oficiais para o ECC.</p>
            </header>

            <div class="grid-encontro">
                <a href="api/capa_quadrante.php" target="_blank" class="btn-encontro">
                    <div class="icon">📘</div>
                    <span>Capa Quadrante</span>
                </a>

                  <a href="api/gerar_crachas.php" target="_blank" class="btn-encontro">
                    <div class="icon">🪪</div>
                    <span>Crachás Encontristas</span>
                </a>

                <a href="api/relacao_encontristas.php" target="_blank" class="btn-encontro">
                    <div class="icon">📋</div>
                    <span>Relação de Encontristas</span>
                </a>

                <a href="api/gerar_lista_presenca.php" target="_blank" class="btn-encontro">
                    <div class="icon">✍️</div>
                    <span>Lista de Presença</span>
                </a>

                <a href="#" class="btn-encontro">
                    <div class="icon">🎂</div>
                    <span>Aniversários</span>
                </a>

                <a href="api/prece_impressao.php" target="_blank" class="btn-encontro">
                    <div class="icon">🙏</div>
                    <span>Prece</span>
                </a>

                <a href="api/gerar_cruz.php" target="_blank" class="btn-encontro">
                    <div class="icon">✝️</div>
                    <span>Cruz</span>
                </a>

                <a href="api/gera_vela.php" target="_blank" class="btn-encontro">
                    <div class="icon">🕯️</div>
                    <span>Velas</span>
                </a>
            </div>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; 2026 - Gestão Paroquial Inteligente | ECC Patos-PB</p>
    </footer>

</body>
>>>>>>> 83776864ccebc41a8f0430e1d4a061408e652141:encontros.html
</html>