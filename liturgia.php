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
    <title>Secretaria - Sistema Paroquial</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Ajuste para o layout da navbar conforme solicitado */
        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .user-welcome {
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            color: #333;
            margin-right: 15px;
        }
        .nav-links {
            display: flex;
            align-items: center;
            list-style: none;
            gap: 20px;
        }
        .btn-logout {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1.2rem;
            transition: transform 0.2s;
        }
        .btn-logout:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body>

    <header class="navbar">
        <div class="nav-container">
            <a href="dashboard.php" class="logo">
                <img src="img/logoParoquia.png" width="160" alt="Logo Paróquia">
            </a>
            
            <nav>
                <ul class="nav-links">
                    <li class="user-welcome">
                        Bem-vindo, <strong><?php echo $_SESSION['usuario_nome']; ?></strong>
                    </li>
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
        <div class="card-container">
            
            <div class="card">
                <div class="icon"><i class="fa-solid fa-address-book" style="color: #81693b;"></i></div>
                <h3>Lista dos casais Encontristas</h3>
                <p>Listagem dos casais que participam do encontro atual.</p>
                <a href="api/lista_encontristas.php" class="btn btn-primary">Listar</a>
            </div>                

            <div class="card">
                <div class="icon"><i class="fa-solid fa-cross" style="color: #81693b;"></i></div>
                <h3>Vigília</h3>
                <p>Imprima a vigília.</p>
                <a href="vigilia.php" class="btn btn-primary">Abrir</a>
            </div>

            <div class="card">
                <div class="icon"><i class="fa-solid fa-cross" style="color: #81693b;"></i></div>
                <h3>Vigília Sábado - Encerramento</h3>
                <p>Imprima a vigília do sábado de encerramento do encontro atual.</p>
                <a href="#" class="btn btn-primary">Abrir</a>
            </div>

            <div class="card">
                <div class="icon"><i class="fa-solid fa-cross" style="color: #81693b;"></i></div>
                <h3>Vigília Domingo - Abertura</h3>
                <p>Imprima a vigília do domingo de abertura do encontro atual.</p>
                <a href="#" class="btn btn-primary">Abrir</a>
            </div>

            <div class="card">
                <div class="icon"><i class="fa-solid fa-cross" style="color: #81693b;"></i></div>
                <h3>Vigília Domingo - Encerramento</h3>
                <p>Imprima a vigília do domingo de encerramento do encontro atual.</p>
                <a href="#" class="btn btn-primary">Abrir</a>
            </div>

        </div>
    </main>

    <footer class="footer">
        <p>&copy; <?php echo date('Y'); ?> - Gestão Paroquial Inteligente | Módulo Secretaria</p>
    </footer>

</body>
</html>