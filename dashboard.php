<?php
// 1. Inicia a sessão para verificar se o usuário está logado
session_start();

// 2. Proteção: Se não existir a sessão do usuário, redireciona para o login
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Paroquial - Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Ajustes finos de layout que podem não estar no seu style.css */
        .navbar-custom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 5%;
            background-color: #fff; /* Ajuste conforme sua cor de fundo */
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
            font-family: 'Inter', sans-serif;
        }
        .logout-btnlogout-btn {
            background-color: #836a3b;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            transition: background 0.3s;
        }
        .logout-btnlogout-btn:hover {
            background-color: #503400;
        }
    </style>
</head>
<body>

    <header class="navbar-custom">
        <div class="logo">
            <a href="dashboard.php">
                <img src="img/logoParoquia.png" width="220" alt="Logo Paróquia">
            </a>
        </div>

        <div class="user-info">
            <span class="text-gray-700">Bem-vindo, <strong><?php echo $_SESSION['usuario_nome']; ?></strong></span>
            <a href="api/logout.php" class="logout-btnlogout-btn">Sair</a>
        </div>
    </header>

    <main class="content" style="padding: 40px 5%;">
        <div class="card-container">
            <div class="card">
                <h3>Secretaria</h3>
                <p>Gestão de batismos, dízimos e cadastros gerais.</p>
                <a href="secretaria.php" class="btn btn-primary">Acessar</a>
            </div>

            <div class="card">
                <h3>Liturgia</h3>
                <p>Escalas de missas e horários de vigília.</p>
                <a href="liturgia.php" class="btn btn-secondary">Ver Escalas</a>
            </div>
        </div>
    </main>

    <footer class="footer" style="text-align: center; padding: 20px 0; margin-top: 50px;">
        <p>&copy; <?php echo date('Y'); ?> - Gestão Paroquial Inteligente</p>
    </footer>

</body>
</html>