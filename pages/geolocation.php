<?php
include 'header.php';
// Credenciais do Azure Maps
$AZURE_MAPS_KEY = 'PRIMARY-KEY';
$AZURE_MAPS_CLIENT_ID = 'CLIENT-ID';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Azure Maps CSS -->
    <link rel="stylesheet" href="https://atlas.microsoft.com/sdk/javascript/mapcontrol/3/atlas.min.css" type="text/css">
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%);
            display: flex;
            flex-direction: column;
            color: #e0e0e0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.95) 0%, rgba(30, 41, 59, 0.95) 100%);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.3);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .navbar-brand {
            color: white;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 2px 10px rgba(102, 126, 234, 0.3);
        }

        .content-container {
            display: flex;
            flex: 1;
            margin-top: 20px;
            overflow: hidden;
            gap: 20px;
            padding: 0 20px;
        }

        #map {
            flex: 1;
            height: 100%;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.4);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar {
            width: 450px;
            background: rgba(30, 41, 59, 0.8);
            backdrop-filter: blur(15px);
            padding: 25px;
            overflow-y: auto;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            display: flex;
            flex-direction: column;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .locations-container {
            flex: 1;
            overflow-y: auto;
            margin-bottom: 20px;
        }

        /* Custom scrollbar */
        .locations-container::-webkit-scrollbar {
            width: 8px;
        }

        .locations-container::-webkit-scrollbar-track {
            background: rgba(15, 23, 42, 0.5);
            border-radius: 10px;
        }

        .locations-container::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
        }

        .sidebar-footer {
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-export {
            width: 100%;
            background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 12px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
        }

        .btn-export:hover {
            background: linear-gradient(135deg, #66BB6A 0%, #388E3C 100%);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(76, 175, 80, 0.4);
        }

        .btn-export i {
            margin-right: 10px;
            font-size: 1.1rem;
        }

        .location-card {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255, 255, 255, 0.05);
            position: relative;
            overflow: hidden;
        }

        .location-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(102, 126, 234, 0.5), transparent);
        }

        .location-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
            border-color: rgba(102, 126, 234, 0.3);
        }

        .location-card.active {
            border-left: 4px solid #667eea;
            background: rgba(15, 23, 42, 0.8);
        }

        .location-time {
            font-size: 0.85rem;
            color: #94a3b8;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .location-time i {
            color: #667eea;
        }

        .location-coords {
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
            font-size: 0.95rem;
            margin-bottom: 15px;
            color: #e2e8f0;
            background: rgba(0, 0, 0, 0.2);
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .location-coords i {
            color: #f093fb;
        }

        .location-details {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 5px 0;
        }

        .detail-label {
            font-weight: 600;
            color: #94a3b8;
            font-size: 0.85rem;
        }

        .detail-value {
            text-align: right;
            color: #e2e8f0;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .btn-refresh {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
            z-index: 1000;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            font-size: 1.2rem;
        }

        .btn-refresh:hover {
            transform: rotate(180deg) scale(1.1);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.6);
        }

        .no-data {
            text-align: center;
            padding: 60px 20px;
            color: #94a3b8;
        }

        .no-data i {
            font-size: 3.5rem;
            margin-bottom: 20px;
            opacity: 0.7;
            color: #667eea;
        }
        
        .no-data h5 {
            color: #e2e8f0;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        /* Card actions row */
        .card-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            gap: 10px;
        }
        
        .btn-view {
            flex: 1;
            background: linear-gradient(135deg, #4CAF50 0%, #2E7D32 100%);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 10px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
        }
        
        .btn-view:hover {
            background: linear-gradient(135deg, #66BB6A 0%, #388E3C 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.3);
        }
        
        .btn-locate {
            flex: 1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 10px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
        }
        
        .btn-locate:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
        
        /* Toast notification */
        .toast-container {
            position: fixed;
            top: 30px;
            right: 30px;
            z-index: 1050;
        }
        
        .toast {
            background: rgba(30, 41, 59, 0.95);
            backdrop-filter: blur(10px);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        }
        
        /* Modal styles */
        .modal-content {
            background: rgba(30, 41, 59, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 20px 50px rgba(0,0,0,0.4);
            color: #e0e0e0;
        }
        
        /* Estilo para aumentar a largura do modal */
        #wideModal {
            max-width: 800px;
            width: 100%;
        }
        
        @media (max-width: 850px) {
            #wideModal {
                max-width: 95%;
            }
        }
        
        .modal-header {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.9) 0%, rgba(30, 41, 59, 0.9) 100%);
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1.5rem 2rem;
        }
        
        .modal-title {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 600;
        }
        
        .modal-body {
            padding: 2rem;
        }
        
        .modal-footer {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1.5rem 2rem;
            background: rgba(15, 23, 42, 0.5);
        }
        
        .detail-table {
            width: 100%;
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
        }
        
        .detail-table td {
            padding: 15px 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .detail-table tr:last-child td {
            border-bottom: none;
        }
        
        .detail-table tr:hover td {
            background: rgba(255, 255, 255, 0.02);
            border-radius: 8px;
        }
        
        .detail-name {
            font-weight: 600;
            color: #94a3b8;
            width: 35%;
            font-size: 0.9rem;
        }
        
        .detail-value {
            color: #e2e8f0;
            font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
            font-size: 0.9rem;
        }
        
        .map-preview {
            width: 100%;
            height: 350px; /* Aumentado para aproveitar o espaço extra */
            margin-top: 30px;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        @media (max-width: 768px) {
            .content-container {
                flex-direction: column;
                padding: 10px;
            }

            .sidebar {
                width: 100%;
                height: 300px;
                border-radius: 15px;
            }

            #map {
                height: calc(100% - 320px);
                border-radius: 15px;
            }
            
            .btn-refresh {
                bottom: 20px;
                right: 20px;
                width: 50px;
                height: 50px;
                font-size: 1rem;
            }
        }

        .footer {
            background: linear-gradient(135deg, rgba(15, 23, 42, 0.9) 0%, rgba(30, 41, 59, 0.9) 100%);
            color: #94a3b8;
            padding: 20px 0;
            text-align: center;
            margin-top: 30px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
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

        .modal-content {
            border-radius: 15px;
            overflow: hidden;
        }

        .modal-body {
            padding: 0;
        }

        .modal-img {
            width: 100%;
        }

        .modal-footer {
            justify-content: space-between;
        }
        
        /* Estilos para o popup do Azure Maps */
        .popup-content {
            padding: 15px;
            max-width: 500px;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: rgba(30, 41, 59, 0.95);
            backdrop-filter: blur(10px);
            color: #e0e0e0;
            border-radius: 12px;
        }

        .popup-content h4 {
            margin-top: 0;
            margin-bottom: 12px;
            font-size: 16px;
            font-weight: 600;
            color: #e2e8f0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 10px;
        }

        .popup-content p {
            margin: 8px 0;
            font-size: 14px;
            line-height: 1.5;
            color: #94a3b8;
        }

        .popup-content strong {
            font-weight: 600;
            color: #e2e8f0;
            min-width: 100px;
            display: inline-block;
        }

        /* Ajustes para o popup do Azure Maps */
        .atlas-popup .atlas-popup-content {
            padding: 0 !important;
            background-color: transparent;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
        }

        .atlas-popup .atlas-popup-tip {
            background-color: rgba(30, 41, 59, 0.95);
        }

        .atlas-popup-close {
            color: #94a3b8;
            font-size: 18px;
            top: 12px;
            right: 12px;
            background: rgba(0, 0, 0, 0.2);
            border-radius: 50%;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .atlas-popup-close:hover {
            color: #e2e8f0;
            background: rgba(0, 0, 0, 0.4);
        }
        
        /* Global scrollbar styling */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(15, 23, 42, 0.3);
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }
        
        /* Animation for location cards */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .location-card {
            animation: slideIn 0.3s ease-out forwards;
            animation-delay: calc(var(--index) * 0.05s);
        }
    </style>

</head>
    <div class="content-container">
        <div class="sidebar">
            <div class="locations-container" id="locationsList">
                <!-- Location entries will be inserted here -->
                <div class="no-data" id="noDataMessage">
                    <i class="bi bi-geo-alt"></i>
                    <h5>No Location Data</h5>
                    <p>No geolocation data has been captured yet.</p>
                </div>
            </div>
            
            <!-- Export button in sidebar footer -->
            <div class="sidebar-footer">
                <button id="exportBtn" class="btn-export">
                    <i class="bi bi-file-earmark-arrow-down"></i> Export to CSV
                </button>
            </div>
        </div>
        <div id="map"></div>
    </div>

    <!-- Location Details Modal -->
    <div class="modal fade" id="locationModal" tabindex="-1" aria-labelledby="locationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" id="wideModal">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="locationModalLabel">Location Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="detail-table">
                        <tr>
                            <td class="detail-name">Timestamp</td>
                            <td class="detail-value" id="modal-timestamp">-</td>
                        </tr>
                        <tr>
                            <td class="detail-name">IP Address</td>
                            <td class="detail-value" id="modal-ip">-</td>
                        </tr>
                        <tr>
                            <td class="detail-name">Latitude</td>
                            <td class="detail-value" id="modal-latitude">-</td>
                        </tr>
                        <tr>
                            <td class="detail-name">Longitude</td>
                            <td class="detail-value" id="modal-longitude">-</td>
                        </tr>
                        <tr>
                            <td class="detail-name">Accuracy</td>
                            <td class="detail-value" id="modal-accuracy">-</td>
                        </tr>
                        <tr>
                            <td class="detail-name">Device Type</td>
                            <td class="detail-value" id="modal-device">-</td>
                        </tr>
                        <tr>
                            <td class="detail-name">Platform</td>
                            <td class="detail-value" id="modal-platform">-</td>
                        </tr>
                        <tr>
                            <td class="detail-name">Browser</td>
                            <td class="detail-value" id="modal-browser">-</td>
                        </tr>
                        <tr>
                            <td class="detail-name">Language</td>
                            <td class="detail-value" id="modal-language">-</td>
                        </tr>
                        <tr>
                            <td class="detail-name">Screen Resolution</td>
                            <td class="detail-value" id="modal-resolution">-</td>
                        </tr>
                    </table>
                    
                    <div class="map-preview" id="modal-map-preview"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast container for notifications -->
    <div class="toast-container"></div>

    <button class="btn-refresh" id="refreshBtn" title="Refresh Data">
        <i class="bi bi-arrow-clockwise"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Azure Maps SDK -->
    <script src="https://atlas.microsoft.com/sdk/javascript/mapcontrol/3/atlas.min.js"></script>

    <script>
        // Azure Maps credentials
        const AZURE_MAPS_KEY = '<?php echo $AZURE_MAPS_KEY; ?>';
        const AZURE_MAPS_CLIENT_ID = '<?php echo $AZURE_MAPS_CLIENT_ID; ?>';

        // Array to store location data
        let locationData = [];
        let map;
        let datasource;
        let popup;
        let markers = [];
        let modalMap; // Map for the modal preview

        // Function to load geolocation data
        function loadGeolocationData() {
            $.ajax({
                url: 'get_geolocation_data.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.success && data.locations.length > 0) {
                        locationData = data.locations;
                        renderLocationsList();
                        if (map) {
                            renderMapMarkers();
                        }
                        $('#noDataMessage').hide();
                        $('#exportBtn').prop('disabled', false);
                    } else {
                        $('#locationsList').html('');
                        $('#noDataMessage').show();
                        $('#exportBtn').prop('disabled', true);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error loading geolocation data:', error);
                    $('#locationsList').html(`
                        <div class="no-data">
                            <i class="bi bi-exclamation-triangle"></i>
                            <h5>Error Loading Data</h5>
                            <p>Could not load geolocation data. Please try again later.</p>
                        </div>
                    `);
                    $('#exportBtn').prop('disabled', true);
                }
            });
        }

        // Function to render the locations list
        function renderLocationsList() {
            const container = $('#locationsList');
            container.html('');

            locationData.forEach((location, index) => {
                const date = new Date(location.timestamp);
                const formattedDate = date.toLocaleDateString() + ' ' + date.toLocaleTimeString();

                const card = $(`
                    <div class="location-card" data-index="${index}">
                        <div class="location-time">${formattedDate}</div>
                        <div class="location-coords">
                            <i class="bi bi-geo-alt-fill me-1"></i>
                            ${parseFloat(location.latitude).toFixed(6)}, ${parseFloat(location.longitude).toFixed(6)}
                        </div>
                        <div class="location-details">
                            <div class="detail-item">
                                <span class="detail-label">IP Address:</span>
                                <span class="detail-value">${location.ip}</span>
                            </div>
                            <div class="detail-item">
                                <span class="detail-label">Device:</span>
                                <span class="detail-value">${location.deviceType}</span>
                            </div>
                        </div>
                        <div class="card-actions">
                            <button class="btn-locate" data-index="${index}">
                                <i class="bi bi-geo-alt me-1"></i> Locate
                            </button>
                            <button class="btn-view" data-index="${index}">
                                <i class="bi bi-eye me-1"></i> View Details
                            </button>
                        </div>
                    </div>
                `);

                // Set up locate button
                card.find('.btn-locate').on('click', function(e) {
                    e.stopPropagation();
                    const idx = $(this).data('index');
                    highlightLocation(idx);
                });
                
                // Set up view details button
                card.find('.btn-view').on('click', function(e) {
                    e.stopPropagation();
                    const idx = $(this).data('index');
                    showLocationDetails(idx);
                });

                container.append(card);
            });
        }

        // Function to highlight a location on the map
        function highlightLocation(index) {
            $('.location-card').removeClass('active');
            $(`.location-card[data-index="${index}"]`).addClass('active');

            const location = locationData[index];
            
            // Center the map on the location
            map.setCamera({
                center: [parseFloat(location.longitude), parseFloat(location.latitude)],
                zoom: 15
            });

            // Show popup for this location
            if (popup) {
                const date = new Date(location.timestamp);
                const formattedDate = date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
                
                popup.setOptions({
                    position: [parseFloat(location.longitude), parseFloat(location.latitude)],
                    content: `
                        <div class="popup-content">
                            <p><strong>Date/Time:</strong> ${formattedDate}</p>
                            <p><strong>IP Address:</strong> ${location.ip}</p>
                            <p><strong>Device:</strong> ${location.deviceType}</p>
                            <p><strong>Coordinates:</strong> ${location.latitude}, ${location.longitude}</p>
                        </div>
                    `
                });
                
                popup.open(map);
            }
        }
        
        // Function to show location details in modal
        function showLocationDetails(index) {
            const location = locationData[index];
            const date = new Date(location.timestamp);
            const formattedDate = date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
            
            // Fill modal with location details
            $('#modal-timestamp').text(formattedDate);
            $('#modal-ip').text(location.ip || '-');
            $('#modal-latitude').text(parseFloat(location.latitude).toFixed(6));
            $('#modal-longitude').text(parseFloat(location.longitude).toFixed(6));
            $('#modal-accuracy').text((location.accuracy || '-') + (location.accuracy ? ' meters' : ''));
            $('#modal-device').text(location.deviceType || '-');
            $('#modal-platform').text(location.platform || '-');
            $('#modal-browser').text(location.browser ? location.browser.substring(0, 100) + '...' : '-');
            $('#modal-language').text(location.language || '-');
            $('#modal-resolution').text(location.screenResolution || '-');
            
            // Show the modal
            const locationModal = new bootstrap.Modal(document.getElementById('locationModal'));
            locationModal.show();
            
            // Initialize the mini map in the modal after it's shown
            $('#locationModal').on('shown.bs.modal', function() {
                initModalMap(location.latitude, location.longitude);
            });
        }
        
        // Function to initialize the mini map in the modal
        function initModalMap(lat, lng) {
            if (modalMap) {
                modalMap.dispose();
            }
            
            // Initialize the Azure Maps in the modal
            modalMap = new atlas.Map('modal-map-preview', {
                center: [parseFloat(lng), parseFloat(lat)],
                zoom: 14,
                language: 'en-US',
                authOptions: {
                    authType: 'subscriptionKey',
                    subscriptionKey: AZURE_MAPS_KEY
                },
                style: 'road',
                showFeedbackLink: false,
                showLogo: false
            });

            modalMap.events.add('ready', function() {
                // Add a marker at the location
                const dataSource = new atlas.source.DataSource();
                modalMap.sources.add(dataSource);

                // Add the marker
                dataSource.add(new atlas.data.Feature(
                    new atlas.data.Point([parseFloat(lng), parseFloat(lat)])
                ));

                // Add a layer for rendering point data as symbols
                modalMap.layers.add(new atlas.layer.SymbolLayer(dataSource, null, {
                    iconOptions: {
                        image: 'marker-red',
                        anchor: 'center',
                        size: 0.8
                    }
                }));
            });
        }

        // Function to initialize the main map
        function initializeMap() {
            // Initialize the Azure Maps
            map = new atlas.Map('map', {
                center: [0, 0],
                zoom: 2,
                language: 'en-US',
                authOptions: {
                    authType: 'subscriptionKey',
                    subscriptionKey: AZURE_MAPS_KEY
                },
                style: 'road'
            });

            // Wait until the map resources are ready
            map.events.add('ready', function() {
                // Create a data source and add it to the map
                datasource = new atlas.source.DataSource();
                map.sources.add(datasource);

                // Create a symbol layer to render point data
                const symbolLayer = new atlas.layer.SymbolLayer(datasource, null, {
                    iconOptions: {
                        image: 'marker-red',
                        anchor: 'center',
                        allowOverlap: true
                    }
                });
                
                map.layers.add(symbolLayer);

                // Create a popup but leave it closed
                popup = new atlas.Popup({
                    pixelOffset: [0, -30],
                    closeButton: true
                });

                // Add click event to the symbol layer
                map.events.add('click', symbolLayer, function(e) {
                    // Check if a feature was clicked
                    if (e.shapes && e.shapes.length > 0) {
                        const properties = e.shapes[0].getProperties();
                        if (properties && properties.index !== undefined) {
                            highlightLocation(properties.index);
                        }
                    }
                });

                // Render markers if we have data
                if (locationData.length > 0) {
                    renderMapMarkers();
                }
            });
        }

        // Function to render markers on the map
        function renderMapMarkers() {
            if (!map || !datasource) return;
            
            // Clear existing data
            datasource.clear();
            
            // If we have locations, center the map on the most recent one
            if (locationData.length > 0) {
                const mostRecent = locationData[0];
                map.setCamera({
                    center: [parseFloat(mostRecent.longitude), parseFloat(mostRecent.latitude)],
                    zoom: 12
                });
            }

            // Add points for each location
            locationData.forEach((location, index) => {
                // Create a point feature
                const point = new atlas.data.Feature(
                    new atlas.data.Point([parseFloat(location.longitude), parseFloat(location.latitude)]),
                    {
                        title: `Location ${index + 1}`,
                        description: new Date(location.timestamp).toLocaleDateString(),
                        index: index // Store the index for reference
                    }
                );
                
                // Add the point to the datasource
                datasource.add(point);
            });
        }
        
        // Function to export data to CSV
        function exportToCSV() {
            if (locationData.length === 0) {
                showToast('No Data', 'There is no geolocation data to export.', 'warning');
                return;
            }
            
            $.ajax({
                url: 'export_geolocation.php',
                type: 'GET',
                success: function(response) {
                    if (response.success) {
                        // Create a download link
                        const link = document.createElement('a');
                        link.href = response.file;
                        link.download = 'report_geolocation.csv';
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                        
                        showToast('Export Successful', 'Geolocation data has been exported to CSV.', 'success');
                    } else {
                        showToast('Export Failed', response.message, 'danger');
                    }
                },
                error: function() {
                    showToast('Export Failed', 'An error occurred while exporting the data.', 'danger');
                }
            });
        }
        
        // Function to show toast notification
        function showToast(title, message, type) {
            const toastContainer = $('.toast-container');
            
            const toast = $(`
                <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="5000">
                    <div class="toast-header bg-${type} text-white">
                        <strong class="me-auto">${title}</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                    <div class="toast-body">
                        ${message}
                    </div>
                </div>
            `);
            
            toastContainer.append(toast);
            
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();
            
            // Remove toast after it's hidden
            toast.on('hidden.bs.toast', function() {
                toast.remove();
            });
        }

        // Initialize on document ready
        $(document).ready(function() {
            // Initialize the map
            initializeMap();
            
            // Load geolocation data
            loadGeolocationData();

            // Set up refresh button
            $('#refreshBtn').on('click', function() {
                loadGeolocationData();
            });
            
            // Set up export button
            $('#exportBtn').on('click', function() {
                exportToCSV();
            });
            
            // Clean up modal map when modal is hidden
            $('#locationModal').on('hidden.bs.modal', function() {
                if (modalMap) {
                    modalMap.dispose();
                    modalMap = null;
                }
            });
        });
    </script>
</body>
</html>
