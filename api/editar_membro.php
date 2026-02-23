<<<<<<< HEAD
<?php
require_once 'db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: membros.php");
    exit;
}

// 1. Busca os dados atuais do membro - Ajustado para letras minúsculas
try {
    $stmt = $pdo->prepare("SELECT * FROM tabela_membros WHERE codigo = ?");
    $stmt->execute([$id]);
    $m = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$m) die("Membro não encontrado.");
} catch (PDOException $e) {
    die("Erro ao carregar dados: " . $e->getMessage());
}

// 2. Processa a atualização quando o formulário é enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Mantém as fotos atuais caso não sejam enviadas novas - Ajustado para minúsculas
        $foto_ele = $m['foto_ele'];
        $foto_ela = $m['foto_ela'];

        // Upload Foto DELE
        if (!empty($_FILES['f_ele']['name'])) {
            $ext = pathinfo($_FILES['f_ele']['name'], PATHINFO_EXTENSION);
            $novo_nome = "ele_" . $id . "_" . time() . "." . $ext;
            if (move_uploaded_file($_FILES['f_ele']['tmp_name'], "../uploads/" . $novo_nome)) {
                $foto_ele = $novo_nome;
            }
        }

        // Upload Foto DELA
        if (!empty($_FILES['f_ela']['name'])) {
            $ext = pathinfo($_FILES['f_ela']['name'], PATHINFO_EXTENSION);
            $novo_nome = "ela_" . $id . "_" . time() . "." . $ext;
            if (move_uploaded_file($_FILES['f_ela']['tmp_name'], "../uploads/" . $novo_nome)) {
                $foto_ela = $novo_nome;
            }
        }

        // SQL baseada na tabela e colunas em minúsculo
        // Corrigido 'aasamento' para 'casamento' conforme estrutura do banco
        $sql = "UPDATE tabela_membros SET 
                ele = :ele, apelido_dele = :ap_ele, foto_ele = :foto_ele, nascimento_dele = :nasc_ele,
                ela = :ela, apelido_dela = :ap_ela, foto_ela = :foto_ela, nascimento_dela = :nasc_ela,
                casamento = :casam, end_rua = :rua, numero = :num, bairro = :bairro, paroquia = :paroquia,
                fone = :fone, email = :email, ano_ecc = :ano, pastoral = :pastoral, 
                modalidade = :modalidade
                WHERE codigo = :id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':ele' => $_POST['ele'], ':ap_ele' => $_POST['ap_ele'], ':foto_ele' => $foto_ele, ':nasc_ele' => $_POST['nasc_ele'] ?: null,
            ':ela' => $_POST['ela'], ':ap_ela' => $_POST['ap_ela'], ':foto_ela' => $foto_ela, ':nasc_ela' => $_POST['nasc_ela'] ?: null,
            ':casam' => $_POST['casamento'] ?: null, ':rua' => $_POST['rua'], ':num' => $_POST['num'],
            ':bairro' => $_POST['bairro'], ':paroquia' => $_POST['paroquia'], ':fone' => $_POST['fone'], 
            ':email' => $_POST['email'], ':ano' => $_POST['ano_ecc'], ':pastoral' => $_POST['pastoral'], 
            ':modalidade' => $_POST['modalidade'], ':id' => $id
        ]);

        header("Location: membros.php?msg=sucesso");
        exit;
    } catch (PDOException $e) {
        $erro = "Erro ao atualizar: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Casal - Sistema Paroquial</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .section-title { 
            grid-column: span 2; border-bottom: 2px solid #81693b; 
            color: #81693b; padding-bottom: 5px; margin-top: 20px; font-weight: bold;
        }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; color: #555; font-size: 0.9rem; }
        .form-control { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        .photo-container { display: flex; align-items: center; gap: 15px; background: #f9f9f9; padding: 10px; border-radius: 8px; border: 1px dashed #ccc; }
        .photo-preview { width: 70px; height: 70px; border-radius: 50%; object-fit: cover; border: 2px solid #81693b; background: #eee; }
        .btn-save { background: #81693b; color: white; border: none; padding: 12px 30px; border-radius: 6px; cursor: pointer; font-weight: bold; }
        .btn-cancel { background: #eee; color: #666; text-decoration: none; padding: 12px 30px; border-radius: 6px; display: inline-block; }
    </style>
</head>
<body>

    <header class="navbar">
        <div class="nav-container">
            <a href="index.html" class="logo">⛪ Minha<span>Paróquia</span></a>
        </div>
    </header>

    <main class="content">
        <div class="form-card full-width">
            <header class="form-header">
                <h2>Editar Cadastro do Casal</h2>
                <p>Atualize as informações de <strong><?php echo htmlspecialchars($m['ele']); ?> & <?php echo htmlspecialchars($m['ela']); ?></strong></p>
            </header>

            <form method="POST" enctype="multipart/form-data"> 
                <div class="form-grid">
                    <div class="section-title">Informações Dele</div>
                    <div class="form-group" style="grid-column: span 2;">
                        <div class="photo-container">
                            <img src="<?php echo $m['foto_ele'] ? '../uploads/'.$m['foto_ele'] : '../img/avatar_m.jpg'; ?>" class="photo-preview">
                            <div>
                                <label>Alterar Foto Dele</label>
                                <input type="file" name="f_ele" accept="image/*">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nome Completo (Ele)</label>
                        <input type="text" name="ele" class="form-control" value="<?php echo htmlspecialchars($m['ele']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Apelido (Ele)</label>
                        <input type="text" name="ap_ele" class="form-control" value="<?php echo htmlspecialchars($m['apelido_dele']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Data de Nascimento (Ele)</label>
                        <input type="date" name="nasc_ele" class="form-control" value="<?php echo $m['nascimento_dele']; ?>">
                    </div>

                    <div class="section-title">Informações Dela</div>
                    <div class="form-group" style="grid-column: span 2;">
                        <div class="photo-container">
                            <img src="<?php echo $m['foto_ela'] ? '../uploads/'.$m['foto_ela'] : '../img/avatar_f.png'; ?>" class="photo-preview">
                            <div>
                                <label>Alterar Foto Dela</label>
                                <input type="file" name="f_ela" accept="image/*">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nome Completo (Ela)</label>
                        <input type="text" name="ela" class="form-control" value="<?php echo htmlspecialchars($m['ela']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Apelido (Ela)</label>
                        <input type="text" name="ap_ela" class="form-control" value="<?php echo htmlspecialchars($m['apelido_dela']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Data de Nascimento (Ela)</label>
                        <input type="date" name="nasc_ela" class="form-control" value="<?php echo $m['nascimento_dela']; ?>">
                    </div>

                    <div class="section-title">Endereço e Contato</div>
                    <div class="form-group">
                        <label>Rua</label>
                        <input type="text" name="rua" class="form-control" value="<?php echo htmlspecialchars($m['end_rua']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Número / Bairro</label>
                        <div style="display: flex; gap: 10px;">
                            <input type="text" name="num" placeholder="Nº" style="width: 30%;" class="form-control" value="<?php echo htmlspecialchars($m['numero']); ?>">
                            <input type="text" name="bairro" placeholder="Bairro" style="width: 70%;" class="form-control" value="<?php echo htmlspecialchars($m['bairro']); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Paróquia</label>
                        <input type="text" name="paroquia" class="form-control" value="<?php echo htmlspecialchars($m['paroquia'] ?? ''); ?>" placeholder="Nome da Paróquia">
                    </div>
                    <div class="form-group">
                        <label>Telefone / WhatsApp</label>
                        <input type="text" name="fone" class="form-control" value="<?php echo htmlspecialchars($m['fone']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($m['email']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Data de Casamento</label>
                        <input type="date" name="casamento" class="form-control" value="<?php echo $m['casamento']; ?>">
                    </div>

                    <div class="section-title">Informações do ECC</div>
                    <div class="form-group">
                        <label>Ano do ECC</label>
                        <input type="text" name="ano_ecc" class="form-control" value="<?php echo htmlspecialchars($m['ano_ecc']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Pastoral</label>
                        <input type="text" name="pastoral" class="form-control" value="<?php echo htmlspecialchars($m['pastoral']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Modalidade</label>
                        <select name="modalidade" class="form-control">
                            <option value="Desmembramento" <?php echo ($m['modalidade'] == 'Desmembramento') ? 'selected' : ''; ?>>Desmembramento</option>
                            <option value="Tranferencia" <?php echo ($m['modalidade'] == 'Tranferencia') ? 'selected' : ''; ?>>Transferência</option>
                        </select>
                    </div>
                </div>

                <div style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px;">
                    <button type="submit" class="btn-save">💾 Salvar Alterações</button>
                    <a href="membros.php" class="btn-cancel">Cancelar</a>
                </div>
            </form>
        </div>
    </main>

</body>
=======
<?php
require_once 'db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: membros.php");
    exit;
}

// 1. Busca os dados atuais do membro - Ajustado para letras minúsculas
try {
    $stmt = $pdo->prepare("SELECT * FROM tabela_membros WHERE codigo = ?");
    $stmt->execute([$id]);
    $m = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$m) die("Membro não encontrado.");
} catch (PDOException $e) {
    die("Erro ao carregar dados: " . $e->getMessage());
}

// 2. Processa a atualização quando o formulário é enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Mantém as fotos atuais caso não sejam enviadas novas - Ajustado para minúsculas
        $foto_ele = $m['foto_ele'];
        $foto_ela = $m['foto_ela'];

        // Upload Foto DELE
        if (!empty($_FILES['f_ele']['name'])) {
            $ext = pathinfo($_FILES['f_ele']['name'], PATHINFO_EXTENSION);
            $novo_nome = "ele_" . $id . "_" . time() . "." . $ext;
            if (move_uploaded_file($_FILES['f_ele']['tmp_name'], "../uploads/" . $novo_nome)) {
                $foto_ele = $novo_nome;
            }
        }

        // Upload Foto DELA
        if (!empty($_FILES['f_ela']['name'])) {
            $ext = pathinfo($_FILES['f_ela']['name'], PATHINFO_EXTENSION);
            $novo_nome = "ela_" . $id . "_" . time() . "." . $ext;
            if (move_uploaded_file($_FILES['f_ela']['tmp_name'], "../uploads/" . $novo_nome)) {
                $foto_ela = $novo_nome;
            }
        }

        // SQL baseada na tabela e colunas em minúsculo
        // Corrigido 'aasamento' para 'casamento' conforme estrutura do banco
        $sql = "UPDATE tabela_membros SET 
                ele = :ele, apelido_dele = :ap_ele, foto_ele = :foto_ele, nascimento_dele = :nasc_ele,
                ela = :ela, apelido_dela = :ap_ela, foto_ela = :foto_ela, nascimento_dela = :nasc_ela,
                casamento = :casam, end_rua = :rua, numero = :num, bairro = :bairro, paroquia = :paroquia,
                fone = :fone, email = :email, ano_ecc = :ano, pastoral = :pastoral, 
                modalidade = :modalidade
                WHERE codigo = :id";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':ele' => $_POST['ele'], ':ap_ele' => $_POST['ap_ele'], ':foto_ele' => $foto_ele, ':nasc_ele' => $_POST['nasc_ele'] ?: null,
            ':ela' => $_POST['ela'], ':ap_ela' => $_POST['ap_ela'], ':foto_ela' => $foto_ela, ':nasc_ela' => $_POST['nasc_ela'] ?: null,
            ':casam' => $_POST['casamento'] ?: null, ':rua' => $_POST['rua'], ':num' => $_POST['num'],
            ':bairro' => $_POST['bairro'], ':paroquia' => $_POST['paroquia'], ':fone' => $_POST['fone'], 
            ':email' => $_POST['email'], ':ano' => $_POST['ano_ecc'], ':pastoral' => $_POST['pastoral'], 
            ':modalidade' => $_POST['modalidade'], ':id' => $id
        ]);

        header("Location: membros.php?msg=sucesso");
        exit;
    } catch (PDOException $e) {
        $erro = "Erro ao atualizar: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Casal - Sistema Paroquial</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .section-title { 
            grid-column: span 2; border-bottom: 2px solid #81693b; 
            color: #81693b; padding-bottom: 5px; margin-top: 20px; font-weight: bold;
        }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 600; color: #555; font-size: 0.9rem; }
        .form-control { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        .photo-container { display: flex; align-items: center; gap: 15px; background: #f9f9f9; padding: 10px; border-radius: 8px; border: 1px dashed #ccc; }
        .photo-preview { width: 70px; height: 70px; border-radius: 50%; object-fit: cover; border: 2px solid #81693b; background: #eee; }
        .btn-save { background: #81693b; color: white; border: none; padding: 12px 30px; border-radius: 6px; cursor: pointer; font-weight: bold; }
        .btn-cancel { background: #eee; color: #666; text-decoration: none; padding: 12px 30px; border-radius: 6px; display: inline-block; }
    </style>
</head>
<body>

    <header class="navbar">
        <div class="nav-container">
            <a href="index.html" class="logo">⛪ Minha<span>Paróquia</span></a>
        </div>
    </header>

    <main class="content">
        <div class="form-card full-width">
            <header class="form-header">
                <h2>Editar Cadastro do Casal</h2>
                <p>Atualize as informações de <strong><?php echo htmlspecialchars($m['ele']); ?> & <?php echo htmlspecialchars($m['ela']); ?></strong></p>
            </header>

            <form method="POST" enctype="multipart/form-data"> 
                <div class="form-grid">
                    <div class="section-title">Informações Dele</div>
                    <div class="form-group" style="grid-column: span 2;">
                        <div class="photo-container">
                            <img src="<?php echo $m['foto_ele'] ? '../uploads/'.$m['foto_ele'] : '../img/avatar_m.jpg'; ?>" class="photo-preview">
                            <div>
                                <label>Alterar Foto Dele</label>
                                <input type="file" name="f_ele" accept="image/*">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nome Completo (Ele)</label>
                        <input type="text" name="ele" class="form-control" value="<?php echo htmlspecialchars($m['ele']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Apelido (Ele)</label>
                        <input type="text" name="ap_ele" class="form-control" value="<?php echo htmlspecialchars($m['apelido_dele']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Data de Nascimento (Ele)</label>
                        <input type="date" name="nasc_ele" class="form-control" value="<?php echo $m['nascimento_dele']; ?>">
                    </div>

                    <div class="section-title">Informações Dela</div>
                    <div class="form-group" style="grid-column: span 2;">
                        <div class="photo-container">
                            <img src="<?php echo $m['foto_ela'] ? '../uploads/'.$m['foto_ela'] : '../img/avatar_f.png'; ?>" class="photo-preview">
                            <div>
                                <label>Alterar Foto Dela</label>
                                <input type="file" name="f_ela" accept="image/*">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nome Completo (Ela)</label>
                        <input type="text" name="ela" class="form-control" value="<?php echo htmlspecialchars($m['ela']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Apelido (Ela)</label>
                        <input type="text" name="ap_ela" class="form-control" value="<?php echo htmlspecialchars($m['apelido_dela']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Data de Nascimento (Ela)</label>
                        <input type="date" name="nasc_ela" class="form-control" value="<?php echo $m['nascimento_dela']; ?>">
                    </div>

                    <div class="section-title">Endereço e Contato</div>
                    <div class="form-group">
                        <label>Rua</label>
                        <input type="text" name="rua" class="form-control" value="<?php echo htmlspecialchars($m['end_rua']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Número / Bairro</label>
                        <div style="display: flex; gap: 10px;">
                            <input type="text" name="num" placeholder="Nº" style="width: 30%;" class="form-control" value="<?php echo htmlspecialchars($m['numero']); ?>">
                            <input type="text" name="bairro" placeholder="Bairro" style="width: 70%;" class="form-control" value="<?php echo htmlspecialchars($m['bairro']); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Paróquia</label>
                        <input type="text" name="paroquia" class="form-control" value="<?php echo htmlspecialchars($m['paroquia'] ?? ''); ?>" placeholder="Nome da Paróquia">
                    </div>
                    <div class="form-group">
                        <label>Telefone / WhatsApp</label>
                        <input type="text" name="fone" class="form-control" value="<?php echo htmlspecialchars($m['fone']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($m['email']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Data de Casamento</label>
                        <input type="date" name="casamento" class="form-control" value="<?php echo $m['casamento']; ?>">
                    </div>

                    <div class="section-title">Informações do ECC</div>
                    <div class="form-group">
                        <label>Ano do ECC</label>
                        <input type="text" name="ano_ecc" class="form-control" value="<?php echo htmlspecialchars($m['ano_ecc']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Pastoral</label>
                        <input type="text" name="pastoral" class="form-control" value="<?php echo htmlspecialchars($m['pastoral']); ?>">
                    </div>
                    <div class="form-group">
                        <label>Modalidade</label>
                        <select name="modalidade" class="form-control">
                            <option value="Desmembramento" <?php echo ($m['modalidade'] == 'Desmembramento') ? 'selected' : ''; ?>>Desmembramento</option>
                            <option value="Tranferencia" <?php echo ($m['modalidade'] == 'Tranferencia') ? 'selected' : ''; ?>>Transferência</option>
                        </select>
                    </div>
                </div>

                <div style="margin-top: 30px; border-top: 1px solid #eee; padding-top: 20px;">
                    <button type="submit" class="btn-save">💾 Salvar Alterações</button>
                    <a href="membros.php" class="btn-cancel">Cancelar</a>
                </div>
            </form>
        </div>
    </main>

</body>
>>>>>>> 83776864ccebc41a8f0430e1d4a061408e652141
</html>