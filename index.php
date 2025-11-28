<?php
declare(strict_types=1);
session_start();

$credenciais = [
    'email' => 'admin@example.com',
    'senha' => 'senha123',
];

$erro = null;

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if ($email === $credenciais['email'] && $senha === $credenciais['senha']) {
        $_SESSION['usuario'] = $email;
    } else {
        $erro = 'Usuario ou senha invalidos.';
    }
}

$logado = isset($_SESSION['usuario']);
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login PHP + Bootstrap</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-light">
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <?php if ($logado): ?>
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h1 class="h4 mb-3">Bem-vindo</h1>
                        <p class="text-muted mb-4">Voce entrou como <strong><?php echo htmlspecialchars($_SESSION['usuario'], ENT_QUOTES, 'UTF-8'); ?></strong>.</p>
                        <a class="btn btn-outline-danger" href="?logout=1">Sair</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h1 class="h4 mb-3">Login</h1>
                        <form method="post" novalidate>
                            <div class="mb-3">
                                <label for="email" class="form-label">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="senha" class="form-label">Senha</label>
                                <input type="password" class="form-control" id="senha" name="senha" required>
                            </div>
                            <?php if ($erro !== null): ?>
                                <div class="alert alert-danger py-2 mb-3"><?php echo htmlspecialchars($erro, ENT_QUOTES, 'UTF-8'); ?></div>
                            <?php endif; ?>
                            <button type="submit" class="btn btn-primary w-100">Entrar</button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
