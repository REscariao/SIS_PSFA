<?php
session_start();

// Se o utilizador já estiver logado, redireciona direto para o dashboard
if (isset($_SESSION['usuario_id'])) {
    header("Location: dashboard.php");
    exit;
}

$erro = isset($_GET['erro']) ? $_GET['erro'] : '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIS_PSFA - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4">

    <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-blue-900 p-8 text-center">
            <img src="img/logoParoquiaBranca.png" alt="Logo da Paróquia" class="mx-auto mb-4 w-60 auto">
        </div>

        <div class="p-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Bem-vindo</h2>
            <p class="text-gray-500 mb-6 text-sm">Introduza as suas credenciais para aceder ao sistema.</p>

            <?php if ($erro == 'dados_invalidos'): ?>
                <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200 text-red-600 text-sm">
                    E-mail ou palavra-passe incorretos. Tente novamente.
                </div>
            <?php endif; ?>

            <form action="api/auth.php" method="POST" class="space-y-5">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail</label>
                    <input type="email" name="email" id="email" required 
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                        placeholder="exemplo@igreja.com">
                </div>

                <div>
                    <div class="flex justify-between mb-1">
                        <label for="senha" class="text-sm font-medium text-gray-700">Palavra-passe</label>
                        <a href="#" class="text-xs text-blue-600 hover:underline text-right">Esqueceu-se da senha?</a>
                    </div>
                    <input type="password" name="senha" id="senha" required 
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                        placeholder="••••••••">
                </div>

                <button type="submit" 
                    class="w-full bg-blue-900 hover:bg-blue-800 text-white font-bold py-3 rounded-xl shadow-lg transition-all transform hover:-translate-y-0.5 active:scale-95">
                    Aceder ao Painel
                </button>
            </form>
        </div>

        <div class="bg-gray-50 p-4 border-t border-gray-100 text-center text-xs text-gray-400">
            &copy; <?php echo date('Y'); ?> - Sistema de Pastoreio. <br> Sistema Gestão Paroquial
            
        </div>
    </div>

</body>
</html>