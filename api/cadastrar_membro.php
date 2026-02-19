<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $foto_ele = null;
        $foto_ela = null;

        // Upload Foto DELE
        if (!empty($_FILES['f_ele']['name'])) {
            $ext = pathinfo($_FILES['f_ele']['name'], PATHINFO_EXTENSION);
            $foto_ele = "ele_" . time() . "_" . uniqid() . "." . $ext;
            move_uploaded_file($_FILES['f_ele']['tmp_name'], "uploads/" . $foto_ele);
        }

        // Upload Foto DELA
        if (!empty($_FILES['f_ela']['name'])) {
            $ext = pathinfo($_FILES['f_ela']['name'], PATHINFO_EXTENSION);
            $foto_ela = "ela_" . time() . "_" . uniqid() . "." . $ext;
            move_uploaded_file($_FILES['f_ela']['tmp_name'], "uploads/" . $foto_ela);
        }

        $sql = "INSERT INTO tabela_membros (
                    Ele, Apelido_dele, Foto_ele, Nascimento_dele, 
                    Ela, Apelido_dela, Foto_ela, Nascimento_dela, 
                    Casamento, End_Rua, Numero, Bairro, Paroquia, 
                    Fone, Email, Ano_ECC, Pastoral, Modalidade, Ativo
                ) VALUES (
                    :ele, :ap_ele, :foto_ele, :nasc_ele, 
                    :ela, :ap_ela, :foto_ela, :nasc_ela, 
                    :casam, :rua, :num, :bairro, :paroquia, 
                    :fone, :email, :ano, :pastoral, :modalidade, 1
                )";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':ele' => $_POST['ele'], ':ap_ele' => $_POST['ap_ele'], ':foto_ele' => $foto_ele, ':nasc_ele' => $_POST['nasc_ele'] ?: null,
            ':ela' => $_POST['ela'], ':ap_ela' => $_POST['ap_ela'], ':foto_ela' => $foto_ela, ':nasc_ela' => $_POST['nasc_ela'] ?: null,
            ':casam' => $_POST['casamento'] ?: null, ':rua' => $_POST['rua'], ':num' => $_POST['num'],
            ':bairro' => $_POST['bairro'], ':paroquia' => $_POST['paroquia'], ':fone' => $_POST['fone'], 
            ':email' => $_POST['email'], ':ano' => $_POST['ano_ecc'], ':pastoral' => $_POST['pastoral'], 
            ':modalidade' => $_POST['modalidade']
        ]);

        header("Location: membros.php?msg=cadastrado");
        exit;
    } catch (PDOException $e) {
        $erro = "Erro ao cadastrar: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Novo Casal - Sistema Paroquial</title>
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
        .form-control { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px; box-sizing: border-box; }
        
        .photo-upload-container { display: flex; align-items: center; gap: 15px; background: #fafafa; padding: 10px; border-radius: 8px; border: 1px dashed #81693b; }
        .btn-save { background: #81693b; color: white; border: none; padding: 12px 30px; border-radius: 6px; cursor: pointer; font-weight: bold; width: 100%; }
        .btn-cancel { background: #eee; color: #666; text-decoration: none; padding: 12px 30px; border-radius: 6px; display: block; text-align: center; margin-top: 10px; }
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
                <h2>Cadastrar Novo Casal</h2>
                <p>Preencha os dados abaixo para adicionar um casal ao ECC.</p>
            </header>

            <?php if (isset($erro)): ?>
                <div style="background: #fee; color: #c33; padding: 15px; border-radius: 6px; margin-bottom: 20px;"><?php echo $erro; ?></div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="form-grid">
                    <div class="section-title">Informações Dele</div>
                    <div class="form-group" style="grid-column: span 2;">
                        <div class="photo-upload-container">
                            <div style="width: 60px; height: 60px; background: #ddd; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px;">👨</div>
                            <div>
                                <label>Foto do Esposo</label>
                                <input type="file" name="f_ele" accept="image/*">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nome Completo (Ele)</label>
                        <input type="text" name="ele" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Apelido (Ele)</label>
                        <input type="text" name="ap_ele" class="form-control">
                    </div>

                    <div class="section-title">Informações Dela</div>
                    <div class="form-group" style="grid-column: span 2;">
                        <div class="photo-upload-container">
                            <div style="width: 60px; height: 60px; background: #ddd; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px;">👩</div>
                            <div>
                                <label>Foto da Esposa</label>
                                <input type="file" name="f_ela" accept="image/*">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nome Completo (Ela)</label>
                        <input type="text" name="ela" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Apelido (Ela)</label>
                        <input type="text" name="ap_ela" class="form-control">
                    </div>

                    <div class="section-title">Localização e Contato</div>
                    <div class="form-group">
                        <label>Paróquia</label>
                        <input type="text" name="paroquia" class="form-control" placeholder="Ex: Santo Antônio">
                    </div>
                    <div class="form-group">
                        <label>Bairro</label>
                        <input type="text" name="bairro" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Rua e Número</label>
                        <div style="display: flex; gap: 5px;">
                            <input type="text" name="rua" placeholder="Rua" style="width: 70%;" class="form-control">
                            <input type="text" name="num" placeholder="Nº" style="width: 30%;" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>WhatsApp / Fone</label>
                        <input type="text" name="fone" class="form-control" placeholder="(83) 9....">
                    </div>

                    <div class="section-title">Dados do ECC</div>
                    <div class="form-group">
                        <label>Ano do ECC</label>
                        <input type="text" name="ano_ecc" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Modalidade</label>
                        <select name="modalidade" class="form-control">
                            <option value="Ficha Original">Ficha Original</option>
                            <option value="Desmembramento">Desmembramento</option>
                            <option value="Tranferencia">Transferência</option>
                        </select>
                    </div>
                </div>

                <div style="margin-top: 30px;">
                    <button type="submit" class="btn-save">✅ Concluir Cadastro</button>
                    <a href="membros.php" class="btn-cancel">Voltar para a Lista</a>
                </div>
            </form>
        </div>
    </main>

</body>
</html>