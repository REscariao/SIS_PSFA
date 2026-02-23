<<<<<<< HEAD:selecionar_encontro.php
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Encontro - Sistema Paroquial</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
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
        <div class="form-card">
            <header class="form-header">
                <h2>Registrar Novo Encontro</h2>
                <p>Preencha as informações básicas do evento paroquial.</p>
            </header>

            <form action="api/salvar_encontro.php" method="POST" class="main-form">
                
                <div class="form-row">
                    <div class="form-section flex-3">
                        <label>Nome do Encontro / Evento</label>
                        <input type="text" name="encontro_nome" placeholder="Ex: 15º Encontro de Casais com Cristo (ECC)" required>
                    </div>
                    
                </div>

                <hr class="form-divider">

                <div class="form-row">
                    <div class="form-section flex-1">
                        <label>Período do Encontro</label>
                        <input type="text" name="periodo" placeholder="Ex: 24, 25 e 26 de Abril de 2026" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-section flex-3">
                        <label>Tema do Encontro</label>
                        <input type="text" name="local" placeholder="Ex: Centro Pastoral, Salão Paroquial...">
                    </div>
                </div>

                <div class="form-section">
                    <label>Observações Importantes</label>
                    <textarea name="obs" rows="4" placeholder="Algum detalhe específico sobre este encontro?"></textarea>
                </div>

                <div class="form-buttons">
                    <button type="reset" class="btn btn-outline">Limpar Tudo</button>
                    <button type="submit" class="btn btn-primary">Finalizar Cadastro</button>
                </div>
            </form>
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
    <title>Cadastro de Encontro - Sistema Paroquial</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
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
        <div class="form-card">
            <header class="form-header">
                <h2>Registrar Novo Encontro</h2>
                <p>Preencha as informações básicas do evento paroquial.</p>
            </header>

            <form action="api/salvar_encontro.php" method="POST" class="main-form">
                
                <div class="form-row">
                    <div class="form-section flex-3">
                        <label>Nome do Encontro / Evento</label>
                        <input type="text" name="encontro_nome" placeholder="Ex: 15º Encontro de Casais com Cristo (ECC)" required>
                    </div>
                    
                </div>

                <hr class="form-divider">

                <div class="form-row">
                    <div class="form-section flex-1">
                        <label>Período do Encontro</label>
                        <input type="text" name="periodo" placeholder="Ex: 24, 25 e 26 de Abril de 2026" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-section flex-3">
                        <label>Tema do Encontro</label>
                        <input type="text" name="local" placeholder="Ex: Centro Pastoral, Salão Paroquial...">
                    </div>
                </div>

                <div class="form-section">
                    <label>Observações Importantes</label>
                    <textarea name="obs" rows="4" placeholder="Algum detalhe específico sobre este encontro?"></textarea>
                </div>

                <div class="form-buttons">
                    <button type="reset" class="btn btn-outline">Limpar Tudo</button>
                    <button type="submit" class="btn btn-primary">Finalizar Cadastro</button>
                </div>
            </form>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; 2026 - Gestão Paroquial Inteligente | ECC Patos-PB</p>
    </footer>

</body>
>>>>>>> 83776864ccebc41a8f0430e1d4a061408e652141:selecionar_encontro.html
</html>