<?php
session_start();

// Segurança: Se não houver sessão, volta para o login
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
    <title>Dashboard - SIS_PSFA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 font-[Inter]">

    <nav class="bg-blue-900 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 shadow-sm">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-2">
                    <span class="text-xl font-bold tracking-wider">SIS_PSFA</span>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-sm border-r pr-4 border-blue-700">Olá, <strong><?php echo $_SESSION['usuario_nome']; ?></strong></span>
                    <a href="logout.php" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-sm transition">Sair</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Painel de Controlo</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500 uppercase font-bold">Casais Cadastrados</p>
                <p class="text-3xl font-black text-blue-900">124</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500 uppercase font-bold">Círculos Ativos</p>
                <p class="text-3xl font-black text-green-600">12</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <p class="text-sm text-gray-500 uppercase font-bold">Próximo Encontro</p>
                <p class="text-xl font-bold text-gray-800">15 de Março</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                <h2 class="font-bold text-gray-700">Ações Rápidas</h2>
            </div>
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="cadastrar_casal.php" class="p-4 border rounded-lg hover:bg-blue-50 hover:border-blue-200 transition text-center">
                    <span class="block text-2xl mb-1">👥</span>
                    <span class="text-sm font-medium text-gray-600">Novo Casal</span>
                </a>
                <a href="lista_chamada.php" class="p-4 border rounded-lg hover:bg-blue-50 hover:border-blue-200 transition text-center">
                    <span class="block text-2xl mb-1">📋</span>
                    <span class="text-sm font-medium text-gray-600">Lista de Presença</span>
                </a>
                <a href="financeiro.php" class="p-4 border rounded-lg hover:bg-blue-50 hover:border-blue-200 transition text-center">
                    <span class="block text-2xl mb-1">💰</span>
                    <span class="text-sm font-medium text-gray-600">Financeiro</span>
                </a>
                <a href="configuracoes.php" class="p-4 border rounded-lg hover:bg-blue-50 hover:border-blue-200 transition text-center">
                    <span class="block text-2xl mb-1">⚙️</span>
                    <span class="text-sm font-medium text-gray-600">Configurações</span>
                </a>
            </div>
        </div>
    </div>

</body>
</html>