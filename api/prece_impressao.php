<?php
// Caso queira tornar dinâmico futuramente, pode manter a conexão
// require_once 'db.php'; 
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Impressão de Prece - ECC</title>
    <style>
        /* 1. CONFIGURAÇÃO DA FOLHA A4 */
        @page { 
            size: A4; 
            margin: 0; 
        }
        
        body { 
            margin: 0; 
            padding: 0; 
            background-color: #525659; /* Fundo para destaque no monitor */
        }

        /* Container que simula a folha física */
        .folha-a4 {
            width: 210mm;
            height: 297mm;
            position: relative;
            margin: 0 auto;
            background-color: white;
            overflow: hidden;
            /* Força a impressão de cores/imagens de fundo */
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        /* Imagem da Prece como fundo total */
        .img-prece {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain; /* Mantém a proporção da arte original */
            z-index: 1;
        }

        /* 2. REGRAS DE IMPRESSÃO */
        @media print {
            body { background: none; }
            .folha-a4 { margin: 0; box-shadow: none; width: 100%; }
            .no-print { display: none; }
        }

        /* Botão flutuante para facilitar a ação */
        .no-print {
            position: fixed; 
            top: 20px; 
            right: 20px; 
            padding: 15px 30px;
            background: #27ae60; 
            color: white; 
            border: none; 
            border-radius: 5px;
            cursor: pointer; 
            font-weight: bold; 
            z-index: 1000;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            font-family: sans-serif;
        }
        .no-print:hover { background: #219150; }
    </style>
</head>
<body>

    <button class="no-print" onclick="window.print()">🖨️ IMPRIMIR PRECE (A4)</button>

    <div class="folha-a4">
        <img src="../img/prece.png" class="img-prece" alt="Prece Só Deus Pode">
    </div>

</body>
</html>