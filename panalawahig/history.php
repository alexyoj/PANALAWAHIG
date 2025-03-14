<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panalawahig</title>
    <link rel="icon" href="img/p-logo-white.svg">
    <link rel="stylesheet" type="text/css" href="history.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" integrity="sha256-46r060N2LrChLLb5zowXQ72/iKKNiw/lAmygmHExk/o=" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        @keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }

        .result-potable, .result-not-potable {
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            width: auto;
            min-width: 120px;
        }

        .result-potable {
            background-color: #28a745;
            animation: none;
        }

        .result-not-potable {
            background-color: #dc3545;
            animation: blink .50s infinite;
        }

        td:last-child {
            text-align: center;
        }

        .fas.fa-exclamation-triangle {
            margin-left: 4px;
            display: inline-block;
            vertical-align: middle;
        }

        .view-graph-btn {
            background-color: #39eff3;
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px;
            transition: background-color 0.3s;
        }

        .view-graph-btn:hover {
            background-color: #7ac5ff;
        }

        td:last-child {
            text-align: center !important;
        }

        th:last-child {
            text-align: center !important;
        }

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-radius: 50%;
            border-top: 3px solid #3498db;
            animation: spin 1s linear infinite;
            margin-right: 10px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .data-timestamp {
            font-size: 0.8em;
            color: #666;
            margin-top: 5px;
        }

        .refresh-button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            margin-left: 10px;
            transition: background-color 0.3s;
        }

        .refresh-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <nav>
        <div class="logo">
            <img src="img/who-logo-black.svg" alt="panalawahig-logo" width="80px" height="40px">
        </div>
        <div class="openMenu"><i class="fa fa-bars"></i></div>
        <ul class="mainMenu">
            <li><a href="index.php">HOME</a></li>
            <li><a href="history.php">HISTORY</a></li>
            <li><a href="blog.php">BLOG</a></li>
            <li><a href="about.php">ABOUT</a></li>
            <li><a href="contact.php">CONTACT US</a></li>
            <div class="closeMenu"><i class="fa fa-times"></i></div>
        </ul>
    </nav>

    <section class="historical-data">
        <h2>LATEST DATA</h2>
        <p><i>Below is the latest data of testing done by the system.</i></p>
        <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 15px;">
            <label for="place" style="margin-right: 10px;"><b>Select a Place: </b></label>
            <select id="place" onchange="updateData()" style="min-width: 200px;">
                <option value="Malagamot">Malagamot, Davao City</option>
                <option value="ACD">ACD, Queen of Peace BLDG</option>
            </select>
            <span id="loading" class="loading" style="display: none; margin-left: 10px;"></span>
            <span id="lastUpdate" class="data-timestamp" style="margin-left: 10px;"></span>
        </div>
        
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>pH Level</th>
                        <th>Turbidity</th>
                        <th>Temperature</th>
                        <th>Total Dissolved Solids (TDS)</th>
                        <th>Result</th>
                    </tr>
                </thead>
                <tbody id="historyTableBody">
                    <!-- Latest data will be populated here -->
                </tbody>
            </table>
        </div>
    </section>

    <div class="comparison-container">
        <div class="table-section">
            <h3>WATER QUALITY STANDARD (PNSDW)</h3>
            <p><i>PNSDW water quality standards are provided below for reference.</i></p>
            <table>
                <thead>
                    <tr>
                        <th>Parameters</th>
                        <th>Measurement / Level</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>pH Level</td>
                        <td>6.5 - 8.5</td>
                    </tr>
                    <tr>
                        <td>Turbidity</td>
                        <td>5 NTU</td>
                    </tr>
                    <tr>
                        <td>Temperature</td>
                        <td>10 - 22°C</td>
                    </tr>
                    <tr>
                        <td>Total Dissolved Solids (TDS)</td>
                        <td>600 mg/L</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="table-section">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
                <h3>PANALAWAHIG TEST RESULT</h3>
                <button class="view-graph-btn" onclick="viewGraph()">
                    <i class="fas fa-chart-line"></i> View Graph
                </button>
            </div>
            <p><i>Latest test results from the selected location.</i></p>
            <table>
                <thead>
                    <tr>
                        <th>Parameters</th>
                        <th>Measurement / Level</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>pH Level</td>
                        <td id="ph-result">--</td>
                    </tr>
                    <tr>
                        <td>Turbidity</td>
                        <td id="turbidity-result">--</td>
                    </tr>
                    <tr>
                        <td>Temperature</td>
                        <td id="temperature-result">--</td>
                    </tr>
                    <tr>
                        <td>Total Dissolved Solids (TDS)</td>
                        <td id="tds-result">--</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <footer style="background-color: #A0DEFF;">
        <div class="container text-center">
            <p class="footer-text">Copyright © 2024 | KAJA</p>
        </div>
    </footer>

    <script>
        const mainMenu = document.querySelector('.mainMenu');
        const closeMenu = document.querySelector('.closeMenu');
        const openMenu = document.querySelector('.openMenu');
        const menu_items = document.querySelectorAll('nav .mainMenu li a');
  
        openMenu.addEventListener('click',show);
        closeMenu.addEventListener('click',close);
  
        menu_items.forEach(item => {
            item.addEventListener('click',function(){
                close();
            })
        })

        function viewGraph() {
            const place = document.getElementById('place').value;
            const channelId = '2624484'; // Your ThingSpeak channel ID
            window.location.href = `graph.php?place=${encodeURIComponent(place)}&channel=${channelId}`;
        }
  
        function show(){
            mainMenu.style.display = 'flex';
            mainMenu.style.top = '0';
        }
        function close(){
            mainMenu.style.top = '-100%';
        }

        function clearData() {
            document.getElementById('historyTableBody').innerHTML = '';
            document.getElementById('ph-result').textContent = '--';
            document.getElementById('turbidity-result').textContent = '--';
            document.getElementById('temperature-result').textContent = '--';
            document.getElementById('tds-result').textContent = '--';
            document.getElementById('lastUpdate').textContent = '';
        }

        function determineWaterQuality(data) {
            if (!data) return { status: "Not Potable", needsTreatment: true };
            
            let isPhOk = data.ph >= 6.5 && data.ph <= 8.5;
            let isTurbidityOk = data.turbidity <= 5;
            let isTempOk = data.temperature >= 10 && data.temperature <= 22;
            let isTdsOk = data.tds <= 600;
            
            let isPotable = isPhOk && isTurbidityOk && isTempOk && isTdsOk;
            
            return {
                status: isPotable ? "Potable" : "Not Potable",
                needsTreatment: !isPotable
            };
        }

        let updateInProgress = false;

        function manualRefresh() {
            if (!updateInProgress) {
                updateData(true);
            }
        }

        function updateData(showLoading = false) {
            if (updateInProgress) return;
            
            updateInProgress = true;
            const placeSelect = document.getElementById('place');
            const selectedPlace = placeSelect.value;
            
            if (showLoading) {
                document.getElementById('loading').style.display = 'inline-block';
            }
            
            if (!selectedPlace) {
                console.error('No place selected');
                updateInProgress = false;
                return;
            }

            fetch('fetch_data.php?averaged=1')
                .then(response => response.json())
                .then(thingspeakData => {
                    if (thingspeakData.success && thingspeakData.data) {
                        const data = thingspeakData.data;
                        
                        // Update comparison table
                        document.getElementById('ph-result').textContent = 
                            data.ph !== null ? `${data.ph.toFixed(1)}` : '--';
                        document.getElementById('turbidity-result').textContent = 
                            data.turbidity !== null ? `${data.turbidity.toFixed(1)} NTU` : '--';
                        document.getElementById('temperature-result').textContent = 
                            data.temperature !== null ? `${data.temperature.toFixed(1)}°C` : '--';
                        document.getElementById('tds-result').textContent = 
                            data.tds !== null ? `${data.tds.toFixed(0)} mg/L` : '--';

                        // Update history table
                        document.getElementById('historyTableBody').innerHTML = ''; // Clear existing rows
                        const row = document.createElement('tr');
                        const currentDate = new Date();
                        const waterQuality = determineWaterQuality(data);

                        row.innerHTML = `
                            <td>${currentDate.toLocaleString()}</td>
                            <td>${data.ph !== null ? data.ph.toFixed(1) : '--'}</td>
                            <td>${data.turbidity !== null ? data.turbidity.toFixed(1) : '--'}</td>
                            <td>${data.temperature !== null ? data.temperature.toFixed(1) + '°C' : '--'}</td>
                            <td>${data.tds !== null ? data.tds.toFixed(0) + ' mg/L' : '--'}</td>
                            <td><span class="${waterQuality.status === 'Potable' ? 'result-potable' : 'result-not-potable'}">
                                ${waterQuality.status === 'Potable' ? 'Potable <i class="fas fa-check"></i>' : 'Need Treatment <i class="fas fa-exclamation-triangle"></i>'} 
                            </span></td>
                        `;
                        
                        document.getElementById('historyTableBody').appendChild(row);
                        document.getElementById('lastUpdate').textContent = `Last updated: ${currentDate.toLocaleString()}`;
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    clearData();
                })
                .finally(() => {
                    updateInProgress = false;
                    document.getElementById('loading').style.display = 'none';
                });
        }

        // Initialize data when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            updateData(true);
            // Auto refresh every 15 seconds
            setInterval(() => updateData(false), 15000);
        });
    </script>
</body>
</html>