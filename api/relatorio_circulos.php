<?php
require_once '../db.php';
$id_encontro = $_GET['encontro'];

$sql = "SELECT C.Circulo as cor_nome, M.Ele, M.Ela, M.Apelido_dele, M.Apelido_dela, M.Fone
        FROM Tabela_Encontristas TE
        JOIN Tabela_Membros M ON TE.Cod_Membros = M.Codigo
        JOIN Tabela_Cor_Circulos C ON TE.Cod_Circulo = C.Codigo
        WHERE TE.Cod_Encontro = ? 
        ORDER BY C.Circulo, M.Ele";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id_encontro]);
$dados = $stmt->fetchAll(PDO::FETCH_GROUP); // Agrupa por cor_nome
?>
<?php foreach($dados as $cor => $casais): ?>
    <h2 style="background: #eee; padding: 10px;">Círculo: <?php echo $cor; ?></h2>
    <ul>
        <?php foreach($casais as $casal): ?>
            <li><?php echo $casal['ele_nome']; ?> & <?php echo $casal['ela_nome']; ?> (<?php echo $casal['Fone']; ?>)</li>
        <?php endforeach; ?>
    </ul>
<?php endforeach; ?>