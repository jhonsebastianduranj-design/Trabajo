<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? $config['app']['name']) ?></title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
<header class="main-header">
    <h1>IPS ALMA VIDA</h1>
    <?php if (isset($_SESSION['user_id'])): ?>
        <nav>
            <a href="/patients">Pacientes</a>
            <a href="/patients/create">Nuevo</a>
            <a href="/logout">Cerrar sesión</a>
        </nav>
    <?php endif; ?>
</header>
<main class="container">
    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert error"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert success"><?= htmlspecialchars($_SESSION['success']) ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>
