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
                <h2>Aniversariantes</h2>
                <p>Gere a lista do aniversariantes do ECC. </p>
            </header>
            <div class="grid-encontro" style="align-items: center; justify-items: center; display: flex; flex-wrap: wrap; text-align: center; padding-left: 10%;">
                <a href="api/aniversariantes_servindo.php" target="_blank" class="btn-encontro">
                    <div class="icon">🎂</div>
                    <span>Aniversariantes Servindo</span>
                </a>
                
                <a href="api/aniversariantes_encontrista.php" target="_blank" class="btn-encontro">
                    <div class="icon">🎂</div>
                    <span>Aniversariantes Vivenciando</span>
                </a>
            </div>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; 2026 - Gestão Paroquial Inteligente | ECC Patos-PB</p>
    </footer>

</body>
</html>