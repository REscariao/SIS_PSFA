<?php
require_once 'db.php'; 

$id_encontro = $_GET['encontro'] ?? null;

if (!$id_encontro) {
    $stmt = $pdo->query("SELECT encontro, tema, periodo FROM tabela_encontros ORDER BY codigo DESC LIMIT 1");
    $encontro = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    $stmt = $pdo->prepare("SELECT encontro, tema, periodo FROM tabela_encontros WHERE codigo = ?");
    $stmt->execute([$id_encontro]);
    $encontro = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (!$encontro) die("Encontro não encontrado.");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Capas Livro de Canto - ECC</title>
    <style>
        @page { size: A4 landscape; margin: 0; }
        body { background-color: #525659; margin: 0; padding: 0; font-family: 'Inter', sans-serif; }
        
        .area-impressao { display: flex; justify-content: center; padding: 20px 0; }

        .folha-a4 {
            width: 297mm;
            height: 210mm;
            background: white;
            background-image: url('../img/capaLivroCanto.png');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            position: relative;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
        }

        /* Estrutura Base */
        .lado {
            position: absolute;
            top: 0;
            width: 50%;
            height: 100%;
        }
        .info-dinamica {
            position: absolute;
            width: 100%;
            text-align: center;
            color: #000;
            text-transform: uppercase;
        }

        /* --- AJUSTES LADO ESQUERDO --- */
        .esquerdo { left: 0; }
        
        .esquerdo .encontro-topo {
            top: 7%; /* Ajuste a altura do nome do encontro aqui */
            left: 6%; /* Ajuste fino lateral se necessário */
            font-size: 18pt;
            font-weight: bold;
        }
        
        .esquerdo .paroquia-base {
            bottom: 4%; /* Ajuste a altura da paróquia aqui */
            left: 5%;
            font-size: 10pt;
            font-weight: bold;
        }

        /* --- AJUSTES LADO DIREITO --- */
        .direito { right: 0; }
        
        .direito .encontro-topo {
            top: 7%; /* Ajuste a altura do nome do encontro aqui */
            right: 0%; /* Ajuste fino lateral se necessário */
            font-size: 18pt;
            font-weight: bold;
        }
        
        .direito .paroquia-base {
            bottom: 4%; /* Ajuste a altura da paróquia aqui */
            right: 0%;
            font-size: 10pt;
            font-weight: bold;
        }

        /* Estilo comum para a data */
        .periodo-data {
            font-size: 11pt;
            font-weight: normal;
            margin-top: 5px;
            text-transform: none; /* Mantém a data em formato normal */
        }

        @media print {
            body { background: none; }
            .area-impressao { padding: 0; }
            .folha-a4 { box-shadow: none; margin: 0; }
            .no-print { display: none; }
        }

        .btn-print { 
            position: fixed; top: 20px; right: 20px; 
            background: #27ae60; color: white; border: none; 
            padding: 15px 25px; border-radius: 5px; font-weight: bold; 
            cursor: pointer; z-index: 1000; 
        }
    </style>
</head>
<body>

    <button class="btn-print no-print" onclick="window.print()">🖨️ Imprimir Capas</button>

    <main class="area-impressao">
        <div class="folha-a4">
            
            <div class="lado esquerdo">
                <div class="info-dinamica encontro-topo">
                    <?php echo htmlspecialchars($encontro['encontro']); ?>
                </div>
                <div class="info-dinamica paroquia-base">
                    PARÓQUIA SÃO FRANCISCO DE ASSIS<br>
                    PATOS-PB
                    <div class="periodo-data"><?php echo htmlspecialchars($encontro['periodo']); ?></div>
                </div>
            </div>

            <div class="lado direito">
                <div class="info-dinamica encontro-topo">
                    <?php echo htmlspecialchars($encontro['encontro']); ?>
                </div>
                <div class="info-dinamica paroquia-base">
                    PARÓQUIA SÃO FRANCISCO DE ASSIS<br>
                    PATOS-PB
                    <div class="periodo-data"><?php echo htmlspecialchars($encontro['periodo']); ?></div>
                </div>
            </div>

        </div>
    </main>

</body>
</html>