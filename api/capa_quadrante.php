<?php
require_once 'db.php';

date_default_timezone_set('America/Fortaleza');

try {
    // Se não vier ID pela URL, busca o último encontro cadastrado pelo Código
    $id_encontro = $_GET['encontro'] ?? null;

    if ($id_encontro) {
        $stmt = $pdo->prepare("SELECT * FROM tabela_encontros WHERE Codigo = ?");
        $stmt->execute([$id_encontro]);
    } else {
        // Busca o último evento baseado no maior Código
        $stmt = $pdo->query("SELECT * FROM tabela_encontros ORDER BY Codigo DESC LIMIT 1");
    }

    $encontro = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$encontro) die("Nenhum encontro encontrado no sistema.");

    // Prepara as variáveis para o layout
    $partes = explode(' ', $encontro['encontro']);
    $numero = $partes[0] . ' - E.C.C.';
    $periodo = $encontro['periodo'];

} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Capa de Quadrante - <?php echo $encontro['Encontro']; ?></title>
    <style>
        @page { 
            size: A4; 
            margin: 0; 
        }
        
        body { 
            margin: 0; 
            padding: 0; 
            background-color: #525659;
        }

        .folha-a4 {
            width: 210mm;
            height: 297mm;
            position: relative;
            margin: 0 auto;
            background-color: white;
            overflow: hidden;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        /* Imagem de fundo como elemento HTML para garantir a impressão */
        .fundo-quadrante {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            object-fit: fill;
        }

        /* Camada de conteúdo por cima da imagem */
        .conteudo-sobreposto {
            position: relative;
            z-index: 2;
            width: 100%;
            height: 100%;
        }

        .numero-encontro {
            position: absolute;
            top: 155px; 
            width: 100%;
            text-align: center;
            /* Se a imagem estiver deslocada, ajuste o margin-left abaixo */
            margin-left: 30px; 
            font-family: "Times New Roman", serif;
            font-size: 65px;
            font-weight: bold;
            color: #81693b; 
            text-transform: uppercase;
        }

        .periodo-realizacao {
            position: absolute;
            bottom: 180px;
            width: 100%;
            text-align: center;
            margin-left: 30px; 
            font-family: "Times New Roman", serif;
            font-size: 24px;
            font-weight: bold;
            color: #81693b;
        }

        @media print {
            body { background: none; }
            .folha-a4 { margin: 0; box-shadow: none; }
            .no-print { display: none; }
        }

        .no-print {
            position: fixed; top: 15px; right: 15px; padding: 12px 25px;
            background: #27ae60; color: white; border: none; border-radius: 5px;
            cursor: pointer; font-weight: bold; z-index: 100;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>

    <button class="no-print" onclick="window.print()">🖨️ IMPRIMIR CAPA (A4)</button>

    <div class="folha-a4">
        <img src="../img/quadrante.png" class="fundo-quadrante" alt="Fundo">

        <div class="conteudo-sobreposto">
            <div class="numero-encontro">
                <?php echo $numero; ?>
            </div>

            <div class="periodo-realizacao">
                <?php echo $periodo; ?>
            </div>
        </div>
    </div>

</body>
</html> 