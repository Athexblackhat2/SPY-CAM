<?php include 'header.php'; ?>

    <style>

    body {
        background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%);
        min-height: 100vh;
        color: #e0e0e0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        display: flex;
        flex-direction: column;
    }

    .container.py-5 {
        flex: 1;
    }

    .content-container {
        padding: 20px 0;
        flex: 1;
    }

    .header {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.9) 0%, rgba(30, 41, 59, 0.9) 100%);
        backdrop-filter: blur(10px);
        color: white;
        padding: 40px 0;
        margin-bottom: 40px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        position: relative;
    }

    .header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, #667eea, #f093fb, #f5576c);
    }

    .card {
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        background: rgba(30, 41, 59, 0.8);
        backdrop-filter: blur(15px);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        margin-bottom: 30px;
    }

    .card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        border-color: rgba(102, 126, 234, 0.3);
    }

    .card-header {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.8) 0%, rgba(30, 41, 59, 0.8) 100%);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding: 20px;
        color: #e2e8f0;
    }

    .card-body {
        padding: 30px;
        background: transparent;
    }

    .card-body.text-center.p-5 {
        padding: 50px !important;
    }

    .footer {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.9) 0%, rgba(30, 41, 59, 0.9) 100%);
        color: #94a3b8;
        padding: 25px 0;
        text-align: center;
        margin-top: auto;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        position: relative;
    }

    .footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.5), transparent);
    }

    .footer a {
        color: #667eea;
        text-decoration: none;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .footer a:hover {
        color: #f093fb;
        text-shadow: 0 0 10px rgba(240, 147, 251, 0.3);
    }

    .display-4 {
        font-size: 3.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, #667eea 0%, #f093fb 50%, #f5576c 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: 0 2px 10px rgba(102, 126, 234, 0.2);
        margin-bottom: 20px;
    }

    .lead {
        font-size: 1.4rem;
        color: #94a3b8;
        margin-bottom: 40px;
    }

    /* Feature cards */
    .h-100.shadow-sm {
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 15px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
    }

    .h-100.shadow-sm:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.4);
        border-color: rgba(102, 126, 234, 0.3);
    }

    .h-100.shadow-sm:nth-child(1) {
        border-top: 3px solid #667eea;
    }

    .h-100.shadow-sm:nth-child(2) {
        border-top: 3px solid #f093fb;
    }

    .h-100.shadow-sm:nth-child(3) {
        border-top: 3px solid #f5576c;
    }

    .text-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .h-100.shadow-sm .card-body {
        padding: 30px;
    }

    .h-100.shadow-sm h3 {
        color: #ffffff;
        font-weight: 600;
        margin: 15px 0;
        font-size: 1.5rem;
    }

    .h-100.shadow-sm .text-muted {
        color: #94a3b8 !important;
        font-size: 1rem;
        line-height: 1.5;
        min-height: 48px;
    }

    .btn-outline-primary {
        background: transparent;
        border: 2px solid #667eea;
        color: #667eea;
        padding: 10px 25px;
        border-radius: 12px;
        font-weight: 500;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        margin-top: 20px;
    }

    .btn-outline-primary:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        border-color: transparent;
    }

    .btn-outline-primary::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }

    .btn-outline-primary:hover::after {
        left: 100%;
    }

    /* Icon styling */
    .fa-3x {
        font-size: 3.5rem;
        margin-bottom: 20px;
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
        width: 10px;
    }

    ::-webkit-scrollbar-track {
        background: rgba(30, 41, 59, 0.5);
    }

    ::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 5px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
    }

    /* Animation for cards */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .h-100.shadow-sm {
        animation: fadeInUp 0.6s ease-out forwards;
        animation-delay: calc(var(--index, 0) * 0.2s);
    }

    /* Loading animation */
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    /* Main card shine effect */
    .card.shadow-sm::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            90deg,
            transparent,
            rgba(255, 255, 255, 0.05),
            transparent
        );
        transition: left 0.7s ease;
        pointer-events: none;
    }

    .card.shadow-sm:hover::after {
        left: 100%;
    }

    /* Feature icons animation */
    .fa-3x {
        transition: all 0.3s ease;
    }

    .h-100.shadow-sm:hover .fa-3x {
        transform: scale(1.2);
        filter: brightness(1.2);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .display-4 {
            font-size: 2.5rem;
        }
        
        .lead {
            font-size: 1.2rem;
        }
        
        .card-body.text-center.p-5 {
            padding: 30px !important;
        }
        
        .fa-3x {
            font-size: 2.5rem;
        }
        
        .h-100.shadow-sm h3 {
            font-size: 1.3rem;
        }
        
        .h-100.shadow-sm .text-muted {
            font-size: 0.9rem;
        }
    }

    /* Welcome message styling */
    .py-5 {
        padding-top: 80px !important;
        padding-bottom: 80px !important;
    }

    /* Additional styling for better visual hierarchy */
    .row.mt-5 {
        margin-top: 60px !important;
    }

    .mb-4 {
        margin-bottom: 30px !important;
    }

    /* Shadow for better depth */
    .shadow-sm {
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2) !important;
    }

    /* Hover effect for main card */
    .card.shadow-sm:hover {
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4) !important;
    }

    /* Gradient background for feature cards on hover */
    .h-100.shadow-sm:hover {
        background: rgba(15, 23, 42, 0.8);
    }

    /* Text shadow for better readability */
    h3, .display-4 {
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    /* Smooth transitions */
    * {
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    /* Body background animation */
    body {
        background-size: 400% 400%;
        animation: gradientBG 15s ease infinite;
    }

    @keyframes gradientBG {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }


    </style>


<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body text-center p-5">
                    <h1 class="display-4 mb-4">SPY-CAM</h1>
                    <p class="lead mb-4">Welcome to the SPY-CAM dashboard.</p>
                    
                    <div class="row mt-5">
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body text-center p-4">
                                    <i class="fas fa-images fa-3x text-primary mb-3"></i>
                                    <h3>Captures</h3>
                                    <p class="text-muted">View and manage captured images</p>
                                    <a href="captures.php" class="btn btn-outline-primary mt-3">View</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body text-center p-4">
                                    <i class="fas fa-network-wired fa-3x text-primary mb-3"></i>
                                    <h3>IP Log Viewer</h3>
                                    <p class="text-muted">Analyze captured IP addresses</p>
                                    <a href="ip_log_viewer.php" class="btn btn-outline-primary mt-3">View</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body text-center p-4">
                                    <i class="fas fa-street-view fa-3x text-primary mb-3"></i>
                                    <h3>Geolocation</h3>
                                    <p class="text-muted">View all geolocation captures</p>
                                    <a href="geolocation.php" class="btn btn-outline-primary mt-3">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
