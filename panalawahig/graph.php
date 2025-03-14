<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Water Quality Graph</title>
    <link rel="icon" href="img/p-logo-white.svg">
    <link rel="stylesheet" type="text/css" href="history.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>

    <style>
        .loading-spinner {
            display: none;
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-radius: 50%;
            border-top: 5px solid #A0DEFF;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .error-message {
            color: #dc3545;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            display: none;
        }

        .success-message {
            color: #28a745;
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
            display: none;
        }

        .chart-container {
            margin: 20px auto;
            padding: 20px;
            width: 80%;
            max-width: 800px;
            height: 500px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .export-buttons {
            margin: 20px;
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .chart-toggles {
            margin: 15px 0;
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .chart-toggle-btn {
            padding: 5px 15px;
            border: 1px solid #A0DEFF;
            background: white;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .chart-toggle-btn.active {
            background: #A0DEFF;
            color: white;
        }

        .btn-csv {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
            color: white !important;
        }

        .btn-pdf {
            background-color: #dc3545 !important;
            border-color: #dc3545 !important;
            color: white !important;
        }

        .back-btn {
            margin: 20px;
            padding: 8px 16px;
            background-color: #A0DEFF;
            border: none;
            border-radius: 4px;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s;
        }
    </style>
</head>
<body>
    <button class="back-btn" onclick="window.location.href='history.php'">
        <i class="fas fa-arrow-left"></i> Back to History
    </button>

    <div class="loading-spinner" id="loadingSpinner"></div>
    <div class="error-message" id="errorMessage"></div>
    <div class="success-message" id="successMessage"></div>

    <div class="chart-toggles">
        <button class="chart-toggle-btn active" onclick="toggleChart('line')">Line Chart</button>
        <button class="chart-toggle-btn" onclick="toggleChart('bar')">Bar Chart</button>
    </div>

    <div class="chart-container">
        <canvas id="waterQualityChart"></canvas>
    </div>

    <div class="export-buttons">
        <button onclick="exportToCSV()" class="btn btn-csv">Export to CSV</button>
        <button onclick="exportToPDF()" class="btn btn-pdf">Export to PDF</button>
    </div>

    <script>
        let chart = null;
        let currentChartType = 'line';
        let latestData = [];

        function showLoading() {
            document.getElementById('loadingSpinner').style.display = 'block';
        }

        function hideLoading() {
            document.getElementById('loadingSpinner').style.display = 'none';
        }

        function showError(message) {
            const errorDiv = document.getElementById('errorMessage');
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';
            setTimeout(() => {
                errorDiv.style.display = 'none';
            }, 5000);
        }

        function showSuccess(message) {
            const successDiv = document.getElementById('successMessage');
            successDiv.textContent = message;
            successDiv.style.display = 'block';
            setTimeout(() => {
                successDiv.style.display = 'none';
            }, 3000);
        }

        function determineWaterQuality(data) {
            let isPhOk = data.ph >= 6.5 && data.ph <= 8.5;
            let isTurbidityOk = data.turbidity <= 5;
            let isTempOk = data.temperature >= 10 && data.temperature <= 22;
            let isTdsOk = data.tds <= 600;
            return (isPhOk && isTurbidityOk && isTempOk && isTdsOk) ? "Potable" : "Not Potable";
        }

        function updateChart(data) {
            const ctx = document.getElementById('waterQualityChart').getContext('2d');
            const timestamps = data.map(d => new Date(d.timestamp).toLocaleTimeString());
            
            const datasets = [
                {
                    label: 'Temperature (°C)',
                    data: data.map(d => d.temperature),
                    borderColor: '#ff6384',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                },
                {
                    label: 'pH Level',
                    data: data.map(d => d.ph),
                    borderColor: '#36a2eb',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                },
                {
                    label: 'Turbidity (NTU)',
                    data: data.map(d => d.turbidity),
                    borderColor: '#ffce56',
                    backgroundColor: 'rgba(255, 206, 86, 0.2)',
                },
                {
                    label: 'TDS (mg/L)',
                    data: data.map(d => d.tds),
                    borderColor: '#4bc0c0',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                }
            ];

            if (chart) {
                chart.destroy();
            }

            chart = new Chart(ctx, {
                type: currentChartType,
                data: {
                    labels: timestamps,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        function toggleChart(type) {
            currentChartType = type;
            document.querySelectorAll('.chart-toggle-btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');
            if (latestData.length > 0) {
                updateChart(latestData);
            }
        }

        function exportToCSV() {
            if (latestData.length === 0) {
                showError('No data available to export');
                return;
            }

            try {
                const headers = ['Date,pH Level,Turbidity,Temperature,TDS,Result\n'];
                const rows = latestData.map(data => {
                    return [
                        new Date(data.timestamp).toLocaleString(),
                        data.ph?.toFixed(1) || '',
                        data.turbidity?.toFixed(1) || '',
                        data.temperature?.toFixed(1) || '',
                        data.tds?.toFixed(0) || '',
                        determineWaterQuality(data)
                    ].join(',');
                });

                const csvContent = "data:text/csv;charset=utf-8," + headers + rows.join('\n');
                const encodedUri = encodeURI(csvContent);
                const link = document.createElement('a');
                link.setAttribute('href', encodedUri);
                link.setAttribute('download', `water_quality_data_${new Date().toLocaleString().replace(/[/:]/g, '-')}.csv`);
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
                
                showSuccess('CSV file downloaded successfully');
            } catch (error) {
                showError('Failed to export CSV: ' + error.message);
            }
        }

        function exportToPDF() {
            if (latestData.length === 0) {
                showError('No data available to export');
                return;
            }

            try {
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF();
                const place = new URLSearchParams(window.location.search).get('place');

                doc.setFontSize(16);
                doc.setTextColor(220, 53, 69);
                doc.text('Panalawahig Water Quality Report', 15, 15);

                doc.setFontSize(12);
                doc.setTextColor(0, 0, 0);
                doc.text(`Location: ${place || 'Not specified'}`, 15, 25);
                doc.text(`Report Generated: ${new Date().toLocaleString()}`, 15, 32);

                const tableRows = latestData.map(data => [
                    new Date(data.timestamp).toLocaleString(),
                    data.ph?.toFixed(1) || '--',
                    data.turbidity?.toFixed(1) || '--',
                    `${data.temperature?.toFixed(1) || '--'}°C`,
                    `${data.tds?.toFixed(0) || '--'} mg/L`,
                    determineWaterQuality(data)
                ]);

                doc.autoTable({
                    head: [['Date', 'pH Level', 'Turbidity', 'Temperature', 'TDS', 'Result']],
                    body: tableRows,
                    startY: 40,
                    styles: { fontSize: 8, cellPadding: 2 },
                    headStyles: { fillColor: [220, 53, 69], textColor: 255 },
                    alternateRowStyles: { fillColor: [245, 245, 245] }
                });

                doc.text('PNSDW Water Quality Standards', 15, doc.autoTable.previous.finalY + 10);
                doc.autoTable({
                    head: [['Parameter', 'Standard Range']],
                    body: [
                        ['pH Level', '6.5 - 8.5'],
                        ['Turbidity', '≤ 5 NTU'],
                        ['Temperature', '10 - 22°C'],
                        ['TDS', '≤ 600 mg/L']
                    ],
                    startY: doc.autoTable.previous.finalY + 15,
                    styles: { fontSize: 8 },
                    headStyles: { fillColor: [220, 53, 69] }
                });

                doc.save(`water_quality_report_${new Date().toLocaleString().replace(/[/:]/g, '-')}.pdf`);
                showSuccess('PDF file downloaded successfully');
            } catch (error) {
                showError('Failed to export PDF: ' + error.message);
                console.error(error);
            }
        }

        async function fetchData() {
            showLoading();
            const place = new URLSearchParams(window.location.search).get('place');
            const channelId = new URLSearchParams(window.location.search).get('channel') || '2624484';
            
            if (!place) {
                hideLoading();
                showError('No place selected');
                return;
            }

            try {
                // First try ThingSpeak
                const thingSpeakResponse = await fetch(`https://api.thingspeak.com/channels/${channelId}/feeds.json?results=50`);
                const thingSpeakData = await thingSpeakResponse.json();

                if (thingSpeakData.feeds && thingSpeakData.feeds.length > 0) {
                    // Transform ThingSpeak data
                    const transformedData = thingSpeakData.feeds.map(feed => ({
                        timestamp: new Date(feed.created_at),
                        temperature: parseFloat(feed.field1) || 0,
                        ph: parseFloat(feed.field2) || 0,
                        turbidity: parseFloat(feed.field3) || 0,
                        tds: parseFloat(feed.field4) || 0
                    }));

                    latestData = transformedData;
                    updateChart(transformedData);
                    hideLoading();
                    return;
                }

                // If ThingSpeak fails, fall back to local data
                const localResponse = await fetch(`fetch_data.php?place=${encodeURIComponent(place)}`);
                const result = await localResponse.json();
                
                if (result.error) {
                    showError(result.error);
                    return;
                }

                if (!result.success || !result.data || result.data.length === 0) {
                    showError('No data available');
                    return;
                }

                latestData = result.data;
                updateChart(result.data);
            } catch (error) {
                console.error('Error fetching data:', error);
                showError('Failed to fetch data: ' + error.message);
            } finally {
                hideLoading();
            }
        }

        // Initial load and periodic updates
        fetchData();
        setInterval(fetchData, 30000);
    </script>
</body>
</html>