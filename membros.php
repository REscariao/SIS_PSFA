<<<<<<< HEAD:membros.php
<?php
require_once 'api/db.php';

try {
    $stmt = $pdo->query("SELECT * FROM tabela_membros WHERE Ativo = 1 ORDER BY ele ASC");
    $membros = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao listar membros: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Membros - Sistema Paroquial</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        .search-container { margin-bottom: 25px; position: relative; }
        .search-container input {
            width: 100%; padding: 15px 20px 15px 45px; border: 2px solid #eee;
            border-radius: 12px; font-size: 1rem; outline: none; transition: 0.3s; box-sizing: border-box;
        }
        .search-container input:focus { border-color: #81693b; box-shadow: 0 4px 12px rgba(129, 105, 59, 0.1); }
        .search-icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #81693b; font-size: 1.2rem; }

        .membros-table { width: 100%; border-collapse: collapse; }
        .membros-table th {
            background: #fafafa; text-align: left; padding: 12px 15px;
            font-size: 0.85rem; color: #777; text-transform: uppercase;
            border-bottom: 2px solid #81693b;
        }
        .membros-table td { padding: 15px; border-bottom: 1px solid #f0f0f0; }
        .apelido-tag { background: #fdf6e3; color: #81693b; padding: 2px 6px; border-radius: 4px; font-size: 0.8rem; font-weight: 700; }

        /* Estilo para diminuir o botão Novo Casal */
        .btnM {
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
        }
        .btn-primaryM { background: #81693b; color: white; }
        .btn-primaryM .btn-smallM {
                width: 50% !important;  
                    padding: 8px 15px !important;
                    font-size: 0.85rem !important;
                    border-radius: 8px !important;
                }

        .pagination-container {
            display: flex; justify-content: center; align-items: center;
            margin-top: 25px; gap: 10px; padding-bottom: 20px;
        }
        .btn-pag {
            padding: 8px 16px; border: 1px solid #ddd; border-radius: 6px;
            background: white; color: #81693b; cursor: pointer; font-weight: 600; transition: 0.3s;
        }
        .btn-pag:hover:not(:disabled) { background: #81693b; color: white; }
        .btn-pag:disabled { color: #ccc; cursor: not-allowed; border-color: #eee; }
        #page-info { font-size: 0.9rem; font-weight: bold; color: #666; }

        .search-hidden { display: none !important; }
        .page-hidden { display: none; }
        .counter-badge { background: #81693b; color: white; padding: 2px 10px; border-radius: 20px; font-size: 0.9rem; }
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
            <header class="form-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <div>
                    <h2>Cadastro de Casais</h2>
                    <p>Total: <span id="reg-count" class="counter-badge"><?php echo count($membros); ?></span></p>
                </div>
                <a href="cadastrar_membro.php" class="btnM btn-primaryM btn-small" style="text-decoration:none;">+ Novo Casal</a>
            </header>

            <div class="search-container">
                <span class="search-icon">🔍</span>
                <input type="text" id="inputBusca" placeholder="Pesquisar em todos os registros...">
            </div>

            <table class="membros-table" id="tabelaMembros">
                <thead>
                    <tr>
                        <th>Casal</th>
                        <th>Apelidos</th>
                        <th>Bairro/Paróquia</th>
                        <th>Pastoral / Ano ECC</th>
                        <th style="text-align: center;">Ações</th>
                    </tr>
                </thead>
                <tbody id="corpoTabela">
                    <?php foreach ($membros as $m): ?>
                    <tr class="membro-row">
                        <td class="col-nome">
                            <strong><?php echo $m['ele']; ?></strong><br>
                            <strong><?php echo $m['ela']; ?></strong>
                        </td>
                        <td class="col-apelido">
                            <span class="apelido-tag"><?php echo $m['apelido_dele'] ?: '-'; ?></span><br>
                            <span class="apelido-tag" style="margin-top:4px; display:inline-block;"><?php echo $m['apelido_dela'] ?: '-'; ?></span>
                        </td>
                        <td class="col-bairro"><?php echo $m['bairro']; ?></td>
                        <td>
                            <strong><?php echo $m['ano_ecc']; ?></strong>
                            <small style="display:block; color:#777;"><?php echo $m['pastoral']; ?></small>
                        </td>
                        <td style="text-align: center;">
                            <a href="editar_membro.php?id=<?php echo $m['codigo']; ?>" style="text-decoration:none; color:#1a237e; font-weight:bold; font-size: 0.85rem;">✏️ Editar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="pagination-container">
                <button id="prevPage" class="btn-pag">Anterior</button>
                <span id="page-info">Página 1 de 1</span>
                <button id="nextPage" class="btn-pag">Próximo</button>
            </div>
        </div>
    </main>

    <script>
        // O script JavaScript permanece exatamente o mesmo
        const rowsPerPage = 15; 
        let currentPage = 1;
        const inputBusca = document.getElementById('inputBusca');
        const rows = Array.from(document.querySelectorAll('.membro-row'));
        const regCount = document.getElementById('reg-count');
        const pageInfo = document.getElementById('page-info');

        function updateTable() {
            const visibleRows = rows.filter(row => !row.classList.contains('search-hidden'));
            const totalVisible = visibleRows.length;
            const totalPages = Math.ceil(totalVisible / rowsPerPage) || 1;
            if (currentPage > totalPages) currentPage = totalPages;
            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            visibleRows.forEach((row, index) => {
                if (index >= start && index < end) {
                    row.classList.remove('page-hidden');
                } else {
                    row.classList.add('page-hidden');
                }
            });
            regCount.textContent = totalVisible;
            pageInfo.textContent = `Página ${currentPage} de ${totalPages}`;
            document.getElementById('prevPage').disabled = currentPage === 1;
            document.getElementById('nextPage').disabled = currentPage === totalPages;
        }

        inputBusca.addEventListener('input', function() {
            const termo = this.value.toLowerCase();
            rows.forEach(row => {
                const texto = row.innerText.toLowerCase();
                if (texto.includes(termo)) {
                    row.classList.remove('search-hidden');
                } else {
                    row.classList.add('search-hidden');
                }
            });
            currentPage = 1; 
            updateTable();
        });

        document.getElementById('prevPage').addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                updateTable();
                window.scrollTo(0, 0);
            }
        });

        document.getElementById('nextPage').addEventListener('click', () => {
            const visibleRows = rows.filter(row => !row.classList.contains('search-hidden'));
            if (currentPage < Math.ceil(visibleRows.length / rowsPerPage)) {
                currentPage++;
                updateTable();
                window.scrollTo(0, 0);
            }
        });

        updateTable();
    </script>
</body>
=======
<?php
require_once 'db.php';

try {
    $stmt = $pdo->query("SELECT * FROM tabela_membros WHERE Ativo = 1 ORDER BY ele ASC");
    $membros = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao listar membros: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Membros - Sistema Paroquial</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        .search-container { margin-bottom: 25px; position: relative; }
        .search-container input {
            width: 100%; padding: 15px 20px 15px 45px; border: 2px solid #eee;
            border-radius: 12px; font-size: 1rem; outline: none; transition: 0.3s; box-sizing: border-box;
        }
        .search-container input:focus { border-color: #81693b; box-shadow: 0 4px 12px rgba(129, 105, 59, 0.1); }
        .search-icon { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: #81693b; font-size: 1.2rem; }

        .membros-table { width: 100%; border-collapse: collapse; }
        .membros-table th {
            background: #fafafa; text-align: left; padding: 12px 15px;
            font-size: 0.85rem; color: #777; text-transform: uppercase;
            border-bottom: 2px solid #81693b;
        }
        .membros-table td { padding: 15px; border-bottom: 1px solid #f0f0f0; }
        .apelido-tag { background: #fdf6e3; color: #81693b; padding: 2px 6px; border-radius: 4px; font-size: 0.8rem; font-weight: 700; }

        /* Estilo para diminuir o botão Novo Casal */
        .btnM {
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
        }
        .btn-primaryM { background: #81693b; color: white; }
        .btn-primaryM .btn-smallM {
                width: 50% !important;  
                    padding: 8px 15px !important;
                    font-size: 0.85rem !important;
                    border-radius: 8px !important;
                }

        .pagination-container {
            display: flex; justify-content: center; align-items: center;
            margin-top: 25px; gap: 10px; padding-bottom: 20px;
        }
        .btn-pag {
            padding: 8px 16px; border: 1px solid #ddd; border-radius: 6px;
            background: white; color: #81693b; cursor: pointer; font-weight: 600; transition: 0.3s;
        }
        .btn-pag:hover:not(:disabled) { background: #81693b; color: white; }
        .btn-pag:disabled { color: #ccc; cursor: not-allowed; border-color: #eee; }
        #page-info { font-size: 0.9rem; font-weight: bold; color: #666; }

        .search-hidden { display: none !important; }
        .page-hidden { display: none; }
        .counter-badge { background: #81693b; color: white; padding: 2px 10px; border-radius: 20px; font-size: 0.9rem; }
    </style>
</head>
<body>

<header class="navbar">
        <div class="nav-container">
            <a href="#" class="logo"><img src="../img/logoParoquia.png" width="270" alt="Logo Paróquia"></a>
            <nav>
                <ul class="nav-links">
                    <li><a href="../secretaria.html">Secretária</a></li>
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
            <header class="form-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <div>
                    <h2>Cadastro de Casais</h2>
                    <p>Total: <span id="reg-count" class="counter-badge"><?php echo count($membros); ?></span></p>
                </div>
                <a href="cadastrar_membro.php" class="btnM btn-primaryM btn-small" style="text-decoration:none;">+ Novo Casal</a>
            </header>

            <div class="search-container">
                <span class="search-icon">🔍</span>
                <input type="text" id="inputBusca" placeholder="Pesquisar em todos os registros...">
            </div>

            <table class="membros-table" id="tabelaMembros">
                <thead>
                    <tr>
                        <th>Casal</th>
                        <th>Apelidos</th>
                        <th>Bairro/Paróquia</th>
                        <th>Pastoral / Ano ECC</th>
                        <th style="text-align: center;">Ações</th>
                    </tr>
                </thead>
                <tbody id="corpoTabela">
                    <?php foreach ($membros as $m): ?>
                    <tr class="membro-row">
                        <td class="col-nome">
                            <strong><?php echo $m['ele']; ?></strong><br>
                            <strong><?php echo $m['ela']; ?></strong>
                        </td>
                        <td class="col-apelido">
                            <span class="apelido-tag"><?php echo $m['apelido_dele'] ?: '-'; ?></span><br>
                            <span class="apelido-tag" style="margin-top:4px; display:inline-block;"><?php echo $m['apelido_dela'] ?: '-'; ?></span>
                        </td>
                        <td class="col-bairro"><?php echo $m['bairro']; ?></td>
                        <td>
                            <strong><?php echo $m['ano_ecc']; ?></strong>
                            <small style="display:block; color:#777;"><?php echo $m['pastoral']; ?></small>
                        </td>
                        <td style="text-align: center;">
                            <a href="editar_membro.php?id=<?php echo $m['codigo']; ?>" style="text-decoration:none; color:#1a237e; font-weight:bold; font-size: 0.85rem;">✏️ Editar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="pagination-container">
                <button id="prevPage" class="btn-pag">Anterior</button>
                <span id="page-info">Página 1 de 1</span>
                <button id="nextPage" class="btn-pag">Próximo</button>
            </div>
        </div>
    </main>

    <script>
        // O script JavaScript permanece exatamente o mesmo
        const rowsPerPage = 15; 
        let currentPage = 1;
        const inputBusca = document.getElementById('inputBusca');
        const rows = Array.from(document.querySelectorAll('.membro-row'));
        const regCount = document.getElementById('reg-count');
        const pageInfo = document.getElementById('page-info');

        function updateTable() {
            const visibleRows = rows.filter(row => !row.classList.contains('search-hidden'));
            const totalVisible = visibleRows.length;
            const totalPages = Math.ceil(totalVisible / rowsPerPage) || 1;
            if (currentPage > totalPages) currentPage = totalPages;
            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            visibleRows.forEach((row, index) => {
                if (index >= start && index < end) {
                    row.classList.remove('page-hidden');
                } else {
                    row.classList.add('page-hidden');
                }
            });
            regCount.textContent = totalVisible;
            pageInfo.textContent = `Página ${currentPage} de ${totalPages}`;
            document.getElementById('prevPage').disabled = currentPage === 1;
            document.getElementById('nextPage').disabled = currentPage === totalPages;
        }

        inputBusca.addEventListener('input', function() {
            const termo = this.value.toLowerCase();
            rows.forEach(row => {
                const texto = row.innerText.toLowerCase();
                if (texto.includes(termo)) {
                    row.classList.remove('search-hidden');
                } else {
                    row.classList.add('search-hidden');
                }
            });
            currentPage = 1; 
            updateTable();
        });

        document.getElementById('prevPage').addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                updateTable();
                window.scrollTo(0, 0);
            }
        });

        document.getElementById('nextPage').addEventListener('click', () => {
            const visibleRows = rows.filter(row => !row.classList.contains('search-hidden'));
            if (currentPage < Math.ceil(visibleRows.length / rowsPerPage)) {
                currentPage++;
                updateTable();
                window.scrollTo(0, 0);
            }
        });

        updateTable();
    </script>
</body>
>>>>>>> 83776864ccebc41a8f0430e1d4a061408e652141:api/membros.php
</html>