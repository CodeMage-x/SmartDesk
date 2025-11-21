<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartDesk - Professional IT Helpdesk Solution</title>
    <meta name="description" content="SmartDesk - Your complete IT helpdesk solution for efficient ticket management and expert support.">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { 
            --cyan-primary: #0dcaf0; 
            --cyan-dark: #17a2b8; 
            --cyan-light: #9eeaf9; 
        }
        
        .bg-gradient-cyan {
            background: linear-gradient(135deg, var(--cyan-dark), var(--cyan-primary));
        }
        
        .bg-cyan {
            background-color: var(--cyan-primary) !important;
        }
        
        .text-cyan {
            color: var(--cyan-primary) !important;
        }
        
        .btn-cyan {
            background-color: var(--cyan-primary);
            border-color: var(--cyan-primary);
            color: #fff;
        }
        
        .btn-cyan:hover {
            background-color: var(--cyan-dark);
            border-color: var(--cyan-dark);
            color: #fff;
        }
        
        .min-vh-75 {
            min-height: 75vh;
        }
        
        .hero-section {
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            pointer-events: none;
        }
        
        .feature-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
        }
        
        .step-number {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
            font-weight: bold;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .hero-buttons .btn {
            min-width: 200px;
        }
        
        @media (max-width: 768px) {
            .hero-buttons .btn {
                display: block;
                margin: 0.5rem 0;
                min-width: auto;
            }
            
            .display-4 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand text-cyan" href="{{ route('home') }}">
                <i class="fas fa-headset me-2"></i>SmartDesk
            </a>
            
            <div class="navbar-nav ms-auto">
                <a href="{{ route('login') }}" class="btn btn-outline-light">
                    <i class="fas fa-sign-in-alt me-2"></i>Login
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main style="padding-top: 76px;">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-cyan">SmartDesk</h6>
                    <p class="mb-0">Professional IT Helpdesk Solution</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">&copy; {{ date('Y') }} SmartDesk. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>