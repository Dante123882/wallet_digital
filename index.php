<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <!-- Fondo animado -->
    <div class="gradient-bg"></div>
    <div class="particles" id="particles"></div>

    <div class="container">
        <!-- Header -->
        <header>
            <div class="logo">💳 Dantewallet</div>
            <div class="nav-buttons">
                <a href="login.php" class="btn btn-login">Iniciar Sesión</a>
                <a href="crear_cuenta.php" class="btn btn-primary">Registrarse</a>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-content">
                <h1>Tu Billetera Digital del Futuro</h1>
                <p>Gestiona tus finanzas de forma segura, rápida y moderna. La próxima generación de pagos digitales está aquí.</p>
                
                <div class="cta-buttons">
                    <a href="crear_cuenta.php" class="btn btn-primary btn-cta">Comenzar Ahora</a>
                    <a href="#features" class="btn btn-login btn-cta">Ver Características</a>
                </div>

                <div class="stats">
                    <div class="stat-item">
                        <div class="stat-number">50K+</div>
                        <div class="stat-label">Usuarios Activos</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">99.9%</div>
                        <div class="stat-label">Uptime</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">$5M+</div>
                        <div class="stat-label">Transacciones</div>
                    </div>
                </div>
            </div>

            <!-- Tarjeta 3D Corregida -->
            <div class="card-3d">
                <div class="card-inner">
                    <!-- Cara Frontal -->
                    <div class="wallet-card">
                        <div class="card-chip"></div>
                        <div class="card-number">4532 **** **** 8901</div>
                        <div class="card-info">
                            <div>
                                <div style="font-size: 11px; opacity: 0.7;">TITULAR</div>
                                <div style="font-weight: 600;">Dante Rodriguez</div>
                            </div>
                            <div>
                                <div style="font-size: 11px; opacity: 0.7;">VÁLIDO</div>
                                <div style="font-weight: 600;">12/28</div>
                            </div>
                        </div>
                    </div>

                    <!-- Cara Trasera -->
                    <div class="wallet-card-back">
                        <div class="magnetic-strip"></div>
                        <div class="card-logo">Dantewallet</div>
                        <div class="card-tagline">Seguridad y confianza en cada transacción</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features" id="features">
            <h2 class="section-title">Características Principales</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🔒</div>
                    <h3 class="feature-title">Seguridad Total</h3>
                    <p class="feature-desc">Protección de nivel bancario con encriptación de extremo a extremo y autenticación de dos factores.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">⚡</div>
                    <h3 class="feature-title">Transacciones Instantáneas</h3>
                    <p class="feature-desc">Envía y recibe dinero al instante, sin esperas ni complicaciones innecesarias.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h3 class="feature-title">Análisis Inteligente</h3>
                    <p class="feature-desc">Visualiza tus gastos y obtén insights personalizados para mejorar tu salud financiera.</p>
                </div>
            </div>
        </section>
    </div>

    <script>
        // Generar partículas mejoradas
        const particles = document.getElementById('particles');
        for(let i = 0; i < 80; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.width = (Math.random() * 3 + 2) + 'px';
            particle.style.height = particle.style.width;
            particle.style.animationDuration = (Math.random() * 4 + 3) + 's';
            particle.style.animationDelay = Math.random() * 8 + 's';
            particles.appendChild(particle);
        }
    </script>
</body>
</html>