<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Mobile Money</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: #f8f9fa;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: #ffffff;
            border-bottom: none;
            padding-top: 2rem;
            font-weight: bold;
            font-size: 1.5rem;
            color: #0d6efd;
        }
        .btn-primary {
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            background-color: #0d6efd;
            border: none;
            transition: 0.3s;
        }
        .btn-primary:hover {
            background-color: #0b5ed7;
            transform: translateY(-2px);
        }
        .input-group-text {
            background-color: #f1f3f5;
            border-right: none;
            color: #6c757d;
        }
        .form-control {
            border-left: none;
            padding: 12px;
            background-color: #f1f3f5;
        }
        .form-control:focus {
            background-color: #fff;
            box-shadow: none;
            border-color: #dee2e6;
        }
        .brand-icon {
            font-size: 3rem;
            color: #0d6efd;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5 col-lg-4">
            
            <div class="text-center mb-4">
                <div class="brand-icon">
                    <i class="fas fa-wallet"></i> </div>
                <h2 class="h4 fw-bold">JHNI - Mobile money</h2>
                <p class="text-muted small">Gestion des comptes & transactions Mobile</p>
            </div>

            <div class="card">
                <div class="card-header text-center text-uppercase">
                    Connexion
                </div>
                <div class="card-body p-4">

                    <?php if(session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger d-flex align-items-center" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <div><?= session()->getFlashdata('error') ?></div>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="/login">
                        
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Téléphone ou Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" name="email" class="form-control" placeholder="Ex: @mail.com" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold">Mot de passe</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-3">
                            <i class="fas fa-sign-in-alt me-2"></i> Accéder au compte
                        </button>

                        <div class="text-center">
                            <a href="#" class="text-decoration-none small text-muted">Mot de passe oublié ?</a>
                        </div>
                    </form>
                </div>
            </div>
            
            <p class="text-center mt-4 text-muted small">
                &copy; 2026 Loharano Sécurisé par SSL.
            </p>
        </div>
    </div>
</div>

</body>
</html>