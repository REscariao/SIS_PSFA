<?php
// gerar_crachas_servindo.php
require_once 'db.php'; 

$id_encontro = $_GET['encontro'] ?? null;

// Busca automática do último se não houver ID
if (!$id_encontro) {
    $stmt = $pdo->query("SELECT codigo FROM tabela_encontros ORDER BY codigo DESC LIMIT 1");
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    $id_encontro = $res['codigo'] ?? null;
}

if (!$id_encontro) die("Erro: Nenhum encontro encontrado.");

try {
    // Busca dados do encontro
    $stmtEnc = $pdo->prepare("SELECT encontro, periodo FROM tabela_encontros WHERE codigo = ?");
    $stmtEnc->execute([$id_encontro]);
    $encontro = $stmtEnc->fetch(PDO::FETCH_ASSOC);

    // Busca os membros da equipe de trabalho (Ele e Ela separadamente para gerar crachás individuais)
    $sql = "SELECT m.ele, m.ela, m.apelido_dele, m.apelido_dela, tet.Equipe 
            FROM tabela_equipes_trabalho tet
            JOIN tabela_membros m ON tet.Cod_Membros = m.codigo
            WHERE tet.Cod_Encontro = ?
            ORDER BY tet.Equipe, m.ele ASC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id_encontro]);
    $equipe = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Transformar a lista para que cada pessoa seja um item individual no loop
    $individuais = [];
    foreach ($equipe as $casal) {
        // Dados para o Marido
        $individuais[] = [
            'nome' => $casal['ele'],
            'apelido' => $casal['apelido_dele'] ?: explode(' ', $casal['ele'])[0],
            'equipe' => $casal['Equipe']
        ];
        // Dados para a Esposa
        $individuais[] = [
            'nome' => $casal['ela'],
            'apelido' => $casal['apelido_dela'] ?: explode(' ', $casal['ela'])[0],
            'equipe' => $casal['Equipe']
        ];
    }

} catch (PDOException $e) {
    die("Erro ao buscar dados: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Crachás Servindo - ECC</title>
    <style>
        /* Baseado no modelo do gerar_crachas.php */
        body { background-color: #525659; margin: 0; padding: 0; font-family: 'Inter', sans-serif; }
        
        .area-impressao { display: flex; flex-direction: column; align-items: center; padding: 20px 0; }

        .folha-a4 {
            width: 210mm;
            height: 297mm;
            background: white;
            display: grid;
            grid-template-columns: repeat(2, 98mm); 
            grid-template-rows: repeat(4, 65mm);   
            gap: 4mm;
            padding: 10mm 5mm;
            justify-content: center;
            box-sizing: border-box;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
            margin-bottom: 20px;
            page-break-after: always;
            overflow: hidden;
        }

        .cracha { width: 98mm; height: 65mm; display: flex; align-items: center; justify-content: center; position: relative; 
    background-image: url("data:image/svg+xml,%3csvg width='100%25' height='100%25' xmlns='http://www.w3.org/2000/svg'%3e%3crect width='100%25' height='100%25' fill='none' stroke='%2381693b' stroke-width='1' stroke-dasharray='10%2c 15' stroke-dashoffset='0' stroke-linecap='square'/%3e%3c/svg%3e");
    }
        
        .cont { 
            border: 1mm solid #81693b; /* Cor dourada solicitada */
            padding: 3mm; 
            width: 88mm; 
            height: 55mm; 
            display: flex; 
            flex-direction: column; 
            justify-content: space-between; 
            box-sizing: border-box; 
            background-color: #ffffff; /* Fundo branco solicitado */
        }

        .topo { display: flex; align-items: center; height: 18mm; position: relative; }
        .logo-ecc { width: 17mm; height: auto; margin-right: 5px; }
        
        .titulo-encontro { flex-grow: 1; text-align: center; color: #81693b; }
        .titulo-encontro h2 { margin: 0; font-size: 11px; text-transform: uppercase; }
        .titulo-encontro p { margin: 2px 0; font-size: 9px; font-weight: bold; }
        
        hr { position: absolute; bottom: 0; left: 30%; width: 63%; border: none; border-top: 0.7mm solid #81693b; margin: 0; }
        
        .corpo { color: #333; flex-grow: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; border-bottom: 0.5mm solid #81693b; }
        .apelido-txt { font-size: 26px; font-weight: bold; text-align: center; text-transform: uppercase; color: #000; margin-bottom: 2px; }
        .nome-txt { font-size: 10px; color: #666; text-transform: uppercase; }
        
        .rodape { padding-top: 4px; text-align: center; font-weight: bold; font-size: 12px; color: #81693b; text-transform: uppercase; }

        @media print {
            @page { size: A4; margin: 0; }
            body { background: none; }
            .area-impressao { padding: 0; }
            .folha-a4 { box-shadow: none; margin: 0; }
            .cracha { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .btn-print-float { display: none !important; }
        }

        .btn-print-float { 
            position: fixed; bottom: 30px; right: 30px; 
            background: #27ae60; color: white; border: none; 
            padding: 15px 25px; border-radius: 50px; font-weight: bold; 
            cursor: pointer; z-index: 1000; box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>

    <button class="btn-print-float" onclick="window.print()">🖨️ Imprimir Crachás</button>

    <main class="area-impressao">
        <?php if (count($individuais) > 0): ?>
            <div class="folha-a4">
            <?php foreach ($individuais as $i => $pessoa): 
                // Abre nova folha se já preencheu 8 espaços
                if ($i > 0 && $i % 8 == 0): ?>
                    </div><div class="folha-a4">
                <?php endif; ?>

                <div class="cracha">
                    <div class="cont">
                        <div class="topo">
                            <img src="../img/logo_preta.png" class="logo-ecc">
                            <div class="titulo-encontro">
                                <h2><?php echo htmlspecialchars($encontro['encontro']); ?></h2>
                                <p><?php echo htmlspecialchars($encontro['periodo']); ?></p>
                            </div>
                            <hr>
                        </div>
                        <div class="corpo">
                            <div class="apelido-txt"><?php echo htmlspecialchars($pessoa['apelido']); ?></div>
                            <div class="nome-txt"><?php echo htmlspecialchars($pessoa['nome']); ?></div>
                        </div>
                        <div class="rodape"><?php echo htmlspecialchars($pessoa['equipe']); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
            </div> 
        <?php else: ?>
            <div style="background:white; padding: 50px; border-radius: 10px; text-align: center;">
                <h2>Nenhuma equipe escalada para este encontro.</h2>
            </div>
        <?php endif; ?>
    </main>

</body>
</html>