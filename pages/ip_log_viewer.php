<!DOCTYPE html>
<?php include 'header.php'; ?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPY-CAM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    
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
    
    .card {
        border-radius: 15px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
        box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        background: rgba(30, 41, 59, 0.7);
        backdrop-filter: blur(10px);
        margin-bottom: 30px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .card:hover {
        box-shadow: 0 15px 40px rgba(0,0,0,0.4);
        border-color: rgba(102, 126, 234, 0.3);
        transform: translateY(-2px);
    }
    
    .card-header {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.8) 0%, rgba(30, 41, 59, 0.8) 100%);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding: 20px;
        color: #e2e8f0;
    }
    
    .card-body {
        padding: 25px;
        background: transparent;
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
    
    .loading {
        text-align: center;
        padding: 80px;
        font-size: 1.3rem;
        color: #94a3b8;
    }
    
    .no-data {
        text-align: center;
        padding: 80px;
        font-size: 1.3rem;
        color: #94a3b8;
    }
    
    .search-box {
        margin-bottom: 25px;
        padding: 25px;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .table-responsive {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    table.dataTable {
        margin-top: 0 !important;
        margin-bottom: 0 !important;
        background: rgba(15, 23, 42, 0.8);
        color: #e0e0e0;
    }
    
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_processing,
    .dataTables_wrapper .dataTables_paginate {
        padding: 20px;
        color: #94a3b8;
        background: rgba(15, 23, 42, 0.6);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        margin: 10px 0;
    }
    
    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select {
        background: rgba(30, 41, 59, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #e0e0e0;
        border-radius: 8px;
        padding: 8px 15px;
    }
    
    .dataTables_wrapper .dataTables_filter input:focus,
    .dataTables_wrapper .dataTables_length select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
    }
    
    .ip-cell {
        font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
        font-weight: 600;
    }
    
    .date-cell {
        white-space: nowrap;
    }
    
    .badge-private {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    
    .badge-public {
        background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }
    
    .btn-refresh {
        background: linear-gradient(135deg, #17a2b8 0%, #0d6efd 100%);
        color: white;
        border: none;
        transition: all 0.3s ease;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 500;
    }
    
    .btn-refresh:hover {
        background: linear-gradient(135deg, #0d6efd 0%, #17a2b8 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(13, 110, 253, 0.3);
        color: white;
    }
    
    .btn-export {
        background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%);
        color: white;
        border: none;
        transition: all 0.3s ease;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 500;
    }
    
    .btn-export:hover {
        background: linear-gradient(135deg, #2E7D32 0%, #4CAF50 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
        color: white;
    }
    
    .btn-secondary {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 500;
    }
    
    .btn-secondary:hover {
        background: linear-gradient(135deg, #495057 0%, #6c757d 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(108, 117, 125, 0.3);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 500;
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }
    
    .stats-card {
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .stats-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.4);
        border-color: rgba(102, 126, 234, 0.3);
    }
    
    .stats-icon {
        font-size: 3rem;
        opacity: 0.9;
        margin-bottom: 15px;
    }
    
    .stats-number {
        font-size: 2.2rem;
        font-weight: 700;
        color: #ffffff;
        margin-bottom: 5px;
    }
    
    .stats-text {
        font-size: 0.95rem;
        color: #94a3b8;
        font-weight: 500;
    }
    
    /* Custom colors for different IP types */
    .ip-local {
        color: #f093fb;
    }
    
    .ip-public {
        color: #4CAF50;
    }
    
    /* Toast notifications */
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
    
    /* Table styling */
    #ip-log-table {
        width: 100% !important;
    }
    
    #ip-log-table thead th {
        background: rgba(15, 23, 42, 0.8);
        color: #e2e8f0;
        border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        padding: 15px;
        font-weight: 600;
    }
    
    #ip-log-table tbody tr {
        background: rgba(15, 23, 42, 0.6);
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        transition: all 0.3s ease;
    }
    
    #ip-log-table tbody tr:hover {
        background: rgba(30, 41, 59, 0.8);
        transform: translateX(5px);
    }
    
    #ip-log-table tbody td {
        padding: 15px;
        color: #e0e0e0;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
    }
    
    /* Pagination styling */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        background: rgba(30, 41, 59, 0.8) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        color: #e0e0e0 !important;
        margin: 0 3px;
        border-radius: 8px !important;
        transition: all 0.3s ease !important;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        color: white !important;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        color: white !important;
        border: none !important;
    }
    
    /* Form controls */
    .form-label {
        color: #e2e8f0;
        font-weight: 500;
        margin-bottom: 8px;
    }
    
    .form-control, .form-select {
        background: rgba(15, 23, 42, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #e0e0e0;
        border-radius: 10px;
        padding: 10px 15px;
    }
    
    .form-control:focus, .form-select:focus {
        background: rgba(15, 23, 42, 0.9);
        border-color: #667eea;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        color: #ffffff;
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
    
    /* Loading animation */
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    
    .loading i {
        animation: float 2s ease-in-out infinite;
        color: #667eea;
    }
    
    /* Stats cards specific colors */
    .text-primary .stats-icon {
        color: #667eea;
    }
    
    .text-success .stats-icon {
        color: #4CAF50;
    }
    
    .text-info .stats-icon {
        color: #17a2b8;
    }
    
    .text-warning .stats-icon {
        color: #ffb347;
    }
    
    /* Stats card borders */
    .stats-card:nth-child(1) {
        border-top: 3px solid #667eea;
    }
    
    .stats-card:nth-child(2) {
        border-top: 3px solid #4CAF50;
    }
    
    .stats-card:nth-child(3) {
        border-top: 3px solid #17a2b8;
    }
    
    .stats-card:nth-child(4) {
        border-top: 3px solid #ffb347;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .header h1 {
            font-size: 2.2rem;
        }
        
        .stats-number {
            font-size: 1.8rem;
        }
        
        .stats-icon {
            font-size: 2.5rem;
        }
        
        .card-body {
            padding: 20px;
        }
        
        .btn {
            padding: 8px 16px;
            font-size: 0.9rem;
        }
    }
    
    /* Animation for stats cards */
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
    
    .stats-card {
        animation: fadeInUp 0.5s ease-out forwards;
        animation-delay: calc(var(--index, 0) * 0.1s);
    }
    
    /* Success toast gradient */
    .toast.bg-success {
        background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%) !important;
    }
    
    /* Danger toast gradient */
    .toast.bg-danger {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%) !important;
    }
    
    /* Info toast gradient */
    .toast.bg-info {
        background: linear-gradient(135deg, #17a2b8 0%, #0d6efd 100%) !important;
    }
    
    /* Warning toast gradient */
    .toast.bg-warning {
        background: linear-gradient(135deg, #ffb347 0%, #ffcc33 100%) !important;
    }
    
    /* Table sorting arrows */
    .dataTables_wrapper .dataTables_sortable .sorting:after,
    .dataTables_wrapper .dataTables_sortable .sorting_asc:after,
    .dataTables_wrapper .dataTables_sortable .sorting_desc:after {
        color: #667eea;
    }


    </style>
</head>
<body>
    <!-- Header -->
    <div class="header text-center">
        <div class="container"><br>
            <h1><i class="fas fa-network-wired me-2"></i>IP Log Viewer</h1>
            <p>View and search captured IP addresses from the log file</p>
        </div>
    </div>
    
    <div class="container content-container">
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card stats-card text-center h-100">
                    <div class="card-body">
                        <div class="stats-icon text-primary">
                            <i class="fas fa-eye"></i>
                        </div>
                        <div class="stats-number" id="total-records">0</div>
                        <div class="stats-text">Total Records</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card stats-card text-center h-100">
                    <div class="card-body">
                        <div class="stats-icon text-success">
                            <i class="fas fa-globe"></i>
                        </div>
                        <div class="stats-number" id="unique-ips">0</div>
                        <div class="stats-text">Unique IP Addresses</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card stats-card text-center h-100">
                    <div class="card-body">
                        <div class="stats-icon text-info">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div class="stats-number" id="unique-dates">0</div>
                        <div class="stats-text">Unique Dates</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card stats-card text-center h-100">
                    <div class="card-body">
                        <div class="stats-icon text-warning">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div id="last-update">Never</div>
                        <div class="stats-text">Last Updated</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Advanced Search Card -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-search me-2"></i>Advanced Search</h5>
                <div>
                    <button id="btn-refresh" class="btn btn-refresh btn-sm me-2">
                        <i class="fas fa-sync-alt me-1"></i> Refresh Data
                    </button>
                    <button id="btn-export" class="btn btn-export btn-sm">
                        <i class="fas fa-file-export me-1"></i> Export CSV
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="date-filter" class="form-label">Date Filter</label>
                        <input type="date" class="form-control" id="date-filter">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="ip-filter" class="form-label">IP Address</label>
                        <input type="text" class="form-control" id="ip-filter" placeholder="e.g. 192.168.0.1">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="ip-type" class="form-label">IP Type</label>
                        <select class="form-select" id="ip-type">
                            <option value="all">All Types</option>
                            <option value="public">Public IPs</option>
                            <option value="private">Private IPs</option>
                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button id="btn-clear-filters" class="btn btn-secondary me-2">
                        <i class="fas fa-eraser me-1"></i> Clear Filters
                    </button>
                    <button id="btn-apply-filters" class="btn btn-primary">
                        <i class="fas fa-filter me-1"></i> Apply Filters
                    </button>
                </div>
            </div>
        </div>
        
        <!-- Data Table Card -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="fas fa-table me-2"></i>IP Log Data</h5>
            </div>
            <div class="card-body">
                <!-- Loading indicator -->
                <div id="loading" class="loading">
                    <i class="fas fa-spinner fa-spin me-2"></i> Loading log data...
                </div>
                
                <!-- No data message -->
                <div id="no-data" class="no-data" style="display: none;">
                    <i class="fas fa-exclamation-circle me-2"></i> No log data found.
                </div>
                
                <!-- Data table -->
                <div id="data-table-container" style="display: none;">
                    <div class="table-responsive">
                        <table id="ip-log-table" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>IP Address</th>
                                    <th>Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Table data will be inserted here by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <a href="https://github.com/Athexhacker/SPY-CAM" >
                <i class="fab fa-github me-2"></i>github.com/Athexhacker/SPY-CAM
            </a>
        </div>
    </footer>
    
    <!-- Toast notifications -->
    <div class="toast-container"></div>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize variables
            let ipLogData = [];
            let dataTable;
            
            // Load log data
            loadLogData();
            
            // Set up event listeners
            $('#btn-refresh').click(function() {
                loadLogData();
            });
            
            $('#btn-export').click(function() {
                exportToCSV();
            });
            
            $('#btn-apply-filters').click(function() {
                applyFilters();
            });
            
            $('#btn-clear-filters').click(function() {
                clearFilters();
            });
            
            // Function to load log data
            function loadLogData() {
                // Show loading indicator
                $('#loading').show();
                $('#data-table-container').hide();
                $('#no-data').hide();
                
                // Fetch log data from the server
                fetch('get_ip_log.php')
                    .then(response => response.json())
                    .then(data => {
                        // Hide loading indicator
                        $('#loading').hide();
                        
                        if (data.success && data.entries.length > 0) {
                            // Store the data
                            ipLogData = data.entries;
                            
                            // Update statistics
                            updateStatistics(ipLogData);
                            
                            // Render the data table
                            renderDataTable(ipLogData);
                            
                            // Show the data table
                            $('#data-table-container').show();
                        } else {
                            // Show no data message
                            $('#no-data').show();
                        }
                    })
                    .catch(error => {
                        console.error('Error loading log data:', error);
                        $('#loading').hide();
                        $('#no-data').show();
                        $('#no-data').html(`
                            <i class="fas fa-exclamation-triangle me-2"></i> 
                            Error loading log data. Please check if the get_ip_log.php file is configured correctly.
                        `);
                        showToast('Error', 'Failed to load log data. See console for details.', 'danger');
                    });
            }
            
            // Function to render the data table
            function renderDataTable(data) {
                // Destroy existing DataTable if it exists
                if (dataTable) {
                    dataTable.destroy();
                }
                
                // Clear the table body
                const tableBody = $('#ip-log-table tbody');
                tableBody.empty();
                
                // Add rows to the table
                data.forEach((entry, index) => {
                    const [date, time, ip] = parseLogEntry(entry);
                    const ipType = isPrivateIP(ip) ? 'Private' : 'Public';
                    const ipClass = isPrivateIP(ip) ? 'ip-local' : 'ip-public';
                    const badgeClass = isPrivateIP(ip) ? 'badge-private' : 'badge-public';
                    
                    tableBody.append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td class="date-cell">${date}</td>
                            <td>${time}</td>
                            <td class="ip-cell ${ipClass}">${ip}</td>
                            <td><span class="ip-cell ${badgeClass}">${ipType}</span></td>
                        </tr>
                    `);
                });
                
                // Initialize DataTable
                dataTable = $('#ip-log-table').DataTable({
                    responsive: true,
                    order: [[1, 'desc'], [2, 'desc']], // Sort by date and time descending
                    pageLength: 10,
                    lengthMenu: [10, 25, 50, 100],
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Quick search...",
                        lengthMenu: "Show _MENU_ entries per page",
                        info: "Showing _START_ to _END_ of _TOTAL_ entries",
                        infoEmpty: "Showing 0 to 0 of 0 entries",
                        infoFiltered: "(filtered from _MAX_ total entries)"
                    }
                });
            }
            
            // Function to update statistics
            function updateStatistics(data) {
                // Calculate total records
                const totalRecords = data.length;
                $('#total-records').text(totalRecords);
                
                // Calculate unique IPs
                const uniqueIPs = new Set(data.map(entry => {
                    const [, , ip] = parseLogEntry(entry);
                    return ip;
                })).size;
                $('#unique-ips').text(uniqueIPs);
                
                // Calculate unique dates
                const uniqueDates = new Set(data.map(entry => {
                    const [date] = parseLogEntry(entry);
                    return date;
                })).size;
                $('#unique-dates').text(uniqueDates);
                
                // Update last updated time
                const now = new Date();
                const formattedTime = now.toLocaleTimeString();
                $('#last-update').html(`<span class="stats-number">${formattedTime}</span>`);
            }
            
            // Function to parse a log entry
            function parseLogEntry(entry) {
                // Expected format: "2025-05-22 08:50:07 - 177.68.91.210"
                const match = entry.match(/^(\d{4}-\d{2}-\d{2}) (\d{2}:\d{2}:\d{2}) - (.+)$/);
                if (match) {
                    return [match[1], match[2], match[3]];
                }
                return ['Unknown', 'Unknown', 'Unknown'];
            }
            
            // Function to check if an IP is private
            function isPrivateIP(ip) {
                // Check for localhost
                if (ip === '127.0.0.1' || ip === 'localhost') {
                    return true;
                }
                
                // Check for private IP ranges
                const parts = ip.split('.');
                if (parts.length !== 4) {
                    return false;
                }
                
                const a = parseInt(parts[0], 10);
                const b = parseInt(parts[1], 10);
                const c = parseInt(parts[2], 10);
                
                // Check for private IP ranges
                // 10.0.0.0 - 10.255.255.255
                if (a === 10) {
                    return true;
                }
                
                // 172.16.0.0 - 172.31.255.255
                if (a === 172 && b >= 16 && b <= 31) {
                    return true;
                }
                
                // 192.168.0.0 - 192.168.255.255
                if (a === 192 && b === 168) {
                    return true;
                }
                
                return false;
            }
            
            // Function to apply filters
            function applyFilters() {
                const dateFilter = $('#date-filter').val();
                const ipFilter = $('#ip-filter').val().trim().toLowerCase();
                const ipTypeFilter = $('#ip-type').val();
                
                // Filter the data
                let filteredData = ipLogData.filter(entry => {
                    const [date, , ip] = parseLogEntry(entry);
                    
                    // Apply date filter
                    if (dateFilter && date !== dateFilter) {
                        return false;
                    }
                    
                    // Apply IP filter
                    if (ipFilter && !ip.toLowerCase().includes(ipFilter)) {
                        return false;
                    }
                    
                    // Apply IP type filter
                    if (ipTypeFilter !== 'all') {
                        const isPrivate = isPrivateIP(ip);
                        if (ipTypeFilter === 'public' && isPrivate) {
                            return false;
                        }
                        if (ipTypeFilter === 'private' && !isPrivate) {
                            return false;
                        }
                    }
                    
                    return true;
                });
                
                // Update the data table with filtered data
                renderDataTable(filteredData);
                
                // Show toast notification
                const count = filteredData.length;
                showToast('Filter Applied', `Showing ${count} ${count === 1 ? 'result' : 'results'} matching your criteria.`, 'info');
            }
            
            // Function to clear filters
            function clearFilters() {
                $('#date-filter').val('');
                $('#ip-filter').val('');
                $('#ip-type').val('all');
                
                // Reset the data table to show all data
                renderDataTable(ipLogData);
                
                // Show toast notification
                showToast('Filters Cleared', 'Showing all log entries.', 'info');
            }
            
            // Function to export data to CSV
            function exportToCSV() {
                // Get the current filtered data from the DataTable
                const data = dataTable.rows().data();
                const csvContent = [];
                
                // Add CSV header
                csvContent.push('Index,Date,Time,IP Address,Type');
                
                // Add data rows
                for (let i = 0; i < data.length; i++) {
                    const rowData = data[i];
                    const csvRow = [
                        rowData[0], // Index
                        rowData[1], // Date
                        rowData[2], // Time
                        rowData[3].replace(/<[^>]*>/g, ''), // IP Address (remove HTML)
                        rowData[4].replace(/<[^>]*>/g, '') // Type (remove HTML)
                    ];
                    csvContent.push(csvRow.join(','));
                }
                
                // Create CSV file
                const csvString = csvContent.join('\n');
                const blob = new Blob([csvString], { type: 'text/csv;charset=utf-8;' });
                const url = URL.createObjectURL(blob);
                
                // Create download link
                const link = document.createElement('a');
                link.href = url;
                link.setAttribute('download', `ip_log_export_${new Date().toISOString().slice(0, 10)}.csv`);
                document.body.appendChild(link);
                
                // Trigger download
                link.click();
                
                // Clean up
                document.body.removeChild(link);
                
                // Show toast notification
                showToast('Export Complete', 'CSV file has been downloaded.', 'success');
            }
            
            // Function to show toast notifications
            function showToast(title, message, type) {
                const toastContainer = document.querySelector('.toast-container');
                
                const toastEl = document.createElement('div');
                toastEl.className = `toast align-items-center text-white bg-${type} border-0`;
                toastEl.setAttribute('role', 'alert');
                toastEl.setAttribute('aria-live', 'assertive');
                toastEl.setAttribute('aria-atomic', 'true');
                
                toastEl.innerHTML = `
                    <div class="d-flex">
                        <div class="toast-body">
                            <strong>${title}:</strong> ${message}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                `;
                
                toastContainer.appendChild(toastEl);
                
                const toast = new bootstrap.Toast(toastEl, {
                    autohide: true,
                    delay: 5000
                });
                
                toast.show();
                
                // Remove the toast element after it's hidden
                toastEl.addEventListener('hidden.bs.toast', function() {
                    toastContainer.removeChild(toastEl);
                });
            }
        });
    </script>
</body>
</html>
