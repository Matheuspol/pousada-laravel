<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Pousada — Bem-vindo </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
   
   <style>
        body {
            margin: 0;
            padding: 0;
        }

        .hero {
            min-height: 100vh;
            background: linear-gradient(135deg, #1a2942 0%, #2d4a7a 60%, #1a3a5c 100%);
            display: flex;
            flex-direction: column;
        }

        .hero-nav {
            padding: 1.25rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand {
            color: #e8a838;
            font-weight: 700;
            font-size: 1.2rem;
        }

        .brand i {
            margin-right: .4rem;
        }

        .hero-body {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem 1rem;
        }

        .hero-content {
            text-align: center;
            max-width: 620px;
        }

        .hero-icon {
            font-size: 5rem;
            color: #e8a838;
        }

        h1 {
            color: #fff;
            font-size: 2.6rem;
            font-weight: 700;
            margin: 1rem 0 .5rem;
        }

        .subtitle {
            color: rgba(255, 255, 255, .7);
            font-size: 1.1rem;
            margin-bottom: 2.5rem;
        }

        .btn-accent {
            background: #e8a838;
            border: none;
            color: #1a2942;
            font-weight: 600;
            padding: .75rem 2rem;
            border-radius: 8px;
            font-size: 1rem;
            transition: opacity .2s;
        }

        .btn-accent:hover {
            opacity: .9;
            background: #fff;
        }

        .btn-outline-light {
            padding: .75rem 2rem;
            border-radius: 8px;
            font-size: 1rem;
        }

        .features {
            background: #fff;
            padding: 4rem 1rem;
        }

        .feature-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            background: #eef2ff;
            color: #1a2942;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>

    <div class="hero">
        <nav class="hero-nav">
            <span class="brand"><i class="bi bi-house-heart-fill"></i> Pousada </span>
        </nav>

        <div class="hero-body">
            <div class="hero-content">
                <div class="hero-icon"> <i class="bi bi-house-heart-fill"></i> </div>
                <h1> Sistema de Gerenciamento de Pousada </h1>
                <p class="subtitle"> Digitalize e otimize a operação da sua pousada — reservas, hóspedes, quartos e equipe em um só lugar. </p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="{{ route('register') }}" class="btn btn-accent">
                        <i class="bi bi-rocket-takeoff me-1"></i> Começar agora
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-outline-light">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Já tenho conta
                    </a>
                </div>
            </div>
        </div>
    </div>

    <section class="features">
        <div class="container">
            <h2 class="text-center fw-bold mb-1" style="color:#1a2942"> Tudo que você precisa </h2>
            <p class="text-center text-muted mb-5"> Módulos completos para a gestão do seu negócio </p>
            <div class="row g-4 text-center">
                <div class="col-md-4">
                    <div class="feature-icon mx-auto"> <i class="bi bi-calendar-check"></i> </div>
                    <h5 class="fw-semibold"> Reservas </h5>
                    <p class="text-muted small"> Controle completo do ciclo de reservas, check-in e check-out com cálculo automático de valores. </p>
                </div>
                <div class="col-md-4">
                    <div class="feature-icon mx-auto"> <i class="bi bi-door-closed"></i> </div>
                    <h5 class="fw-semibold"> Quartos </h5>
                    <p class="text-muted small"> Gestão de quartos por categoria, com controle de status: disponível, ocupado ou em manutenção. </p>
                </div>
                <div class="col-md-4">
                    <div class="feature-icon mx-auto"> <i class="bi bi-people"></i> </div>
                    <h5 class="fw-semibold"> Hóspedes & Equipe </h5>
                    <p class="text-muted small"> Cadastro de hóspedes e funcionários com histórico de reservas e controle de acesso. </p>
                </div>
            </div>
        </div>
    </section>

    <footer class="text-center py-3 bg-light text-muted small">
        &copy; {{ date('Y') }} Sistema de Gerenciamento de Pousada — Desenvolvido em Laravel
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>