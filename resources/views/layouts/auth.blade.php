<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> @yield('title') — Pousada </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1a2942 0%, #2d4a7a 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-card {
            width: 100%;
            max-width: 420px;
            border: none;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .3);
        }

        .auth-header {
            background: linear-gradient(135deg, #1a2942, #2d4a7a);
            border-radius: 16px 16px 0 0;
            padding: 2rem;
            text-align: center;
            color: #fff;
        }

        .auth-header .logo-icon {
            font-size: 2.5rem;
            color: #e8a838;
        }

        .auth-header h1 {
            font-size: 1.4rem;
            margin: .5rem 0 .2rem;
        }

        .auth-header small {
            color: rgba(255, 255, 255, .6);
            font-size: .82rem;
        }

        .auth-body {
            padding: 2rem;
        }

        .btn-primary {
            background: #1a2942;
            border-color: #1a2942;
        }

        .btn-primary:hover {
            background: #243656;
            border-color: #243656;
        }
    </style>
</head>

<body>
    <div class="auth-card card">
        <div class="auth-header">
            <div class="logo-icon"> <i class="bi bi-house-heart-fill"> </i> </div>
            <h1> Pousada </h1>
            <small> Sistema de Gerenciamento </small>
        </div>
        <div class="auth-body">
            @yield('content')
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"> </script>
</body>

</html>