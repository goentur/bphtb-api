<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-BPHTB Kota Pekalongan</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <!-- Google Fonts (Inter) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            color: #1e293b;
            min-height: 100vh;
        }

        /* Card Style */
        .card-clean {
            border: none;
            border-radius: 1.5rem;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
        }

        /* 1. Floating Icon Container */
        .icon-wrapper {
            width: 100px;
            height: 100px;
            background: #eff6ff;
            color: #2563eb;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            position: relative;
            animation: float 3.5s ease-in-out infinite;
        }

        /* 2. Rotating Gear inside Icon */
        .gear-icon {
            animation: spin 10s linear infinite;
            display: inline-block;
        }

        /* 3. Pulsing Progress Bar */
        .progress-pulse {
            animation: pulse-glow 2s infinite alternate;
        }

        /* Keyframe Animations */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-12px); }
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @keyframes pulse-glow {
            0% { opacity: 0.7; }
            100% { opacity: 1; box-shadow: 0 0 12px rgba(37, 99, 235, 0.4); }
        }

        /* 4. Fade-in Staggered Effect */
        .fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
            opacity: 0;
        }

        .delay-1 { animation-delay: 0.15s; }
        .delay-2 { animation-delay: 0.3s; }
        .delay-3 { animation-delay: 0.45s; }
        .delay-4 { animation-delay: 0.6s; }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center p-3">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                
                <!-- Main Card Wrapper -->
                <div class="card card-clean p-4 p-sm-5 text-center">
                    
                    <!-- Floating Animated Icon -->
                    <div class="mb-4 fade-in-up delay-1">
                        <div class="icon-wrapper shadow-sm">
                            <i class="bi bi-gear-wide-connected display-4 gear-icon"></i>
                        </div>
                    </div>

                    <!-- Title -->
                    <h1 class="h3 fw-bold mb-3 fade-in-up delay-2">Under Maintenance</h1>

                    <!-- Short Friendly Description -->
                    <p class="text-secondary mb-4 fs-6 fade-in-up delay-2">
                        Kami sedang melakukan peningkatan sistem. Kami akan segera kembali online!
                    </p>

                    <!-- Action Buttons -->
                    <div class="d-flex flex-column flex-sm-row gap-2 justify-content-center fade-in-up delay-4">
                        <button onclick="window.location.reload()" class="btn btn-primary px-4 py-2 rounded-3 fw-medium">
                            <i class="bi bi-arrow-clockwise me-1"></i> Muat Ulang
                        </button>
                    </div>

                </div>

                <!-- Minimalist Footer -->
                <div class="text-center mt-4 fade-in-up delay-4">
                    <p class="small text-muted mb-0">&copy; {{ date('Y') }} BPKAD Kota Pekalongan.</p>
                </div>

            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/bootstrap.bundle.min.js"></script>
</body>
</html>