<?php
require_once 'db.php'; 
date_default_timezone_set('America/Fortaleza');

// Busca o último encontro cadastrado para exibir no cabeçalho
try {
    $stmt = $pdo->query("SELECT encontro, tema, periodo FROM tabela_encontros ORDER BY codigo DESC LIMIT 1");
    $encontro = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao carregar encontro: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Texto Casal Amigo - Impressão</title>
    <style>
        @page { size: A4; margin: 0; }
        body { margin: 0; padding: 0; background-color: #525659; font-family: 'Inter', sans-serif; }

        .folha-a4 {
            width: 210mm;
            height: 297mm;
            margin: 0 auto;
            background-color: white;
            /* Caminho para a imagem que você enviou */
            background-image: url('../img/textoCasalAmigo.png'); 
            background-size: contain;
            background-repeat: no-repeat;
            position: relative;
        }

        /* Posicionamento do cabeçalho dinâmico sobre a imagem */
        .header-dinamico {
            position: absolute;
            top: 185px; /* Ajuste esta altura para alinhar com o espaço em branco da imagem */
            width: 100%;
            text-align: center;
            color: #5f4b26; /* Tom marrom para combinar com sua identidade */
        }

        .header-dinamico h1 {
            margin: 0;
            font-size: 22px;
            text-transform: uppercase;
            color: #81693b;
        }

        .header-dinamico p {
            margin: 3px 0;
            font-size: 14px;
            font-weight: bold;
        }

        @media print {
            body { background: none; }
            .folha-a4 { margin: 0; }
            .no-print { display: none; }
        }

        .no-print {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 25px;
            background: #27ae60;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            z-index: 1000;
        }
    </style>
</head>
<body>

    <button class="no-print" onclick="window.print()">🖨️ IMPRIMIR DOCUMENTO</button>

    <div class="folha-a4">
        <div class="header-dinamico">
            <h1><?php echo htmlspecialchars($encontro['encontro'] ?? 'ENCONTRO DE CASAIS'); ?></h1>
            <p><?php echo htmlspecialchars($encontro['tema'] ?? ''); ?></p>
            <p style="font-weight: normal; font-size: 12px;"><?php echo htmlspecialchars($encontro['periodo'] ?? ''); ?></p>
        </div>
    </div>

</body>
</html>