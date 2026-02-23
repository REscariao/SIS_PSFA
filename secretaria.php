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
                <div class="icon"><i class="fa-regular fa-calendar-days" style="color: #81693b;"></i></div>
                <h3>Selecionar Encontro</h3>
                <p>Gerencie e selecione os encontros paroquiais ativos.</p>
                <a href="selecionar_encontro.php" class="btn btn-primary">Acessar</a>
            </div>

            <div class="card">
                <div class="icon"><i class="fa-solid fa-address-book" style="color: #81693b;"></i></div>
                <h3>Membros</h3>
                <p>Listagem e gerenciamento de membros da paróquia.</p>
                <a href="membros.php" class="btn btn-primary">Listar</a>
            </div>                

            <div class="card">
                <div class="icon"><i class="fa-solid fa-route" style="color: #81693b;"></i></div>
                <h3>Trajetoria </h3>
                <p>Trajetoria de eventos do Casal, vivenciado e servindo.</p>
                <a href="trajetoria.php" class="btn btn-primary">Abrir</a>
            </div>

            <div class="card">
                <div class="icon"><i class="fa-regular fa-circle" style="color: #81693b;"></i></div>
                <h3>Ciclos</h3>
                <p>Controle de períodos litúrgicos e etapas de formação.</p>
                <a href="ciclos.php" class="btn btn-primary">Ver Ciclos</a>
            </div>

            <div class="card">
                <div class="icon"><i class="fas fa-envelope-open-text" style="color: #81693b;"></i></div>
                <h3>Convites das Equipes</h3>
                <p>Envio e controle de convites para novos colaboradores.</p>
                <a href="convites.php" class="btn btn-primary">Enviar Convites</a>
            </div>

            <div class="card">
                <div class="icon"><i class="fas fa-users" style="color: #81693b;"></i></div>
                <h3>Encontro</h3>
                <p>Gerencie datas, locais e informações dos encontros ativos.</p>
                <a href="encontros.php" class="btn btn-primary">Configurar</a>
            </div>

            <div class="card">
                <div class="icon"><i class="fa-solid fa-heart" style="color: #81693b;"></i></div>
                <h3>Vivenciando</h3>
                <p>Lista e controle dos casais que estão fazendo o encontro.</p>
                <a href="vivenciando.php" class="btn btn-primary">Acessar</a>
            </div>

            <div class="card">
                <div class="icon"><i class="fa-solid fa-tools" style="color: #81693b;"></i></div>
                <h3>Servindo</h3>
                <p>Visualize quem está trabalhando no encontro atual.</p>
                <a href="servindo.php" class="btn btn-primary">Ver Escala</a>
            </div>
        </div>
    </main>

    <footer class="footer">
        <p>&copy; <?php echo date('Y'); ?> - Gestão Paroquial Inteligente | Módulo Secretaria</p>
    </footer>

</body>
</html>