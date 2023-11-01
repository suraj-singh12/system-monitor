<?php
// Function to execute a shell command and return the output
function executeCommand($command) {
    $output = shell_exec($command);
    return $output;
}

// Function to create a bar chart
function createBarChart($chartData, $chartTitle, $chartCanvasId, $chartLabel) {
    echo "<div class='info-box'>";
    echo "<h2>$chartTitle</h2>";
    echo "<canvas id='$chartCanvasId' width='400' height='200'></canvas>";
    echo "</div>";

    // Create a JavaScript array from PHP data
    echo "<script>";
    echo "var chartData = " . json_encode($chartData) . ";";
    echo "var chartLabel = " . json_encode($chartLabel) . ";";
    echo "var ctx = document.getElementById('$chartCanvasId').getContext('2d');";
    echo "var myChart = new Chart(ctx, {";
    echo "    type: 'bar',";
    echo "    data: {";
    echo "        labels: chartLabel,";
    echo "        datasets: [{";
    echo "            label: '$chartTitle',";
    echo "            data: chartData,";
    echo "            backgroundColor: 'rgba(75, 192, 192, 0.2)',";
    echo "            borderColor: 'rgba(75, 192, 192, 1)',";
    echo "            borderWidth: 1";
    echo "        }]";
    echo "    },";
    echo "    options: {";
    echo "        scales: {";
    echo "            y: {";
    echo "                beginAtZero: true";
    echo "            }";
    echo "        }";
    echo "    }";
    echo "});";
    echo "</script>";
}

// Function to display real-time CPU frequency of each core
function displayCPUFrequency() {
    $cpuInfo = executeCommand('wmic cpu get CurrentClockSpeed');
    $cpuInfoArray = explode("\n", trim($cpuInfo));
    $cpuCoreFrequencies = [];

    for ($i = 1; $i < count($cpuInfoArray); $i++) {
        $cpuCoreFrequency = intval(trim($cpuInfoArray[$i]));
        $cpuCoreFrequencies[] = $cpuCoreFrequency;
    }

    $chartTitle = "CPU Frequency (MHz)";
    $chartCanvasId = "cpu-frequency-chart";
    $chartLabel = range(1, count($cpuCoreFrequencies));

    createBarChart($cpuCoreFrequencies, $chartTitle, $chartCanvasId, $chartLabel);
}

// Function to display real-time current disk usage
function displayDiskUsage() {
    $diskInfo = executeCommand('wmic logicaldisk get size,freespace');
    $diskInfoArray = explode("\n", trim($diskInfo));
    $diskUsageData = [];

    for ($i = 1; $i < count($diskInfoArray); $i++) {
        $diskData = explode("  ", trim($diskInfoArray[$i]));
        $freeSpace = (float)($diskData[0]); // now in KB
        $totalSpace = 0; // now in KB
        if($diskData[1] != "") {
            $totalSpace = (float)($diskData[1]); // now in KB
        } else {
            $totalSpace = (float)($diskData[2]); // now in KB
        }
        $usedSpace = $totalSpace - $freeSpace;
        $usedSpaceGB = round($usedSpace / (1024 * 1024 * 1024));
        $diskUsageData[] = $usedSpaceGB;
    }

    $chartTitle = "Disk Usage (GB)";
    $chartCanvasId = "disk-usage-chart";
    $chartLabel = range(1, count($diskUsageData));

    createBarChart($diskUsageData, $chartTitle, $chartCanvasId, $chartLabel);
}

// Function to display real-time RAM consumption
function displayRAMUsage() {
    $memoryInfo = executeCommand('wmic memorychip get capacity');
    $memoryInfoArray = explode("\n", trim($memoryInfo));
    $totalMemory = 0;
    forEach($memoryInfoArray as $memory) {
        $totalMemory += (float)trim($memory);
    }
    $totalMemory = round($totalMemory / 1024);      // now in KB
    $memoryInfo = executeCommand('wmic OS get FreePhysicalMemory,TotalVisibleMemorySize');
    $memoryInfoArray = explode("\n", trim($memoryInfo));
    $freeMemory = (float)trim($memoryInfoArray[1]);
    $usedMemory = $totalMemory - $freeMemory;
    $freeMemoryGB = round($freeMemory / (1024 * 1024), 2);
    $usedMemoryGB = round($usedMemory / (1024 * 1024), 2);
    
    $chartTitle = "RAM Usage (GB)";
    $chartCanvasId = "ram-usage-chart";
    $chartLabel = ["Free RAM (GB)", "Used RAM (GB)"];
    $chartData = [$freeMemoryGB, $usedMemoryGB];

    createBarChart($chartData, $chartTitle, $chartCanvasId, $chartLabel);
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>System Info</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .info-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        .info-box {
            background-color: #f0f0f0;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 18px;
            margin: 0;
        }

        p {
            font-size: 16px;
            margin: 0;
        }

        canvas {
            display: block;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="info-container">
        <h1>System Information</h1>

        <!-- CPU Frequency Chart -->
        <?php displayCPUFrequency(); ?>

        <!-- Disk Usage Chart -->
        <?php displayDiskUsage(); ?>

        <!-- RAM Usage Chart -->
        <?php displayRAMUsage(); ?>
    </div>
</body>
</html>
