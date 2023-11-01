<?php
// Function to execute a shell command and return the output
// function executeCommand($command) {
//     $output = shell_exec($command);
//     return $output;
// }

// Function to create a bar chart
function createBarChart($chartData, $chartTitle, $chartCanvasId, $chartLabel) {
    echo "<div class='info-box'>";
    // echo "<h2>$chartTitle</h2>";
    echo "<canvas id='$chartCanvasId'></canvas>";
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
function displayDiskUsage($canvasId = "disk-usage-chart", $title = "Disk Usage (GB)") {
    $diskInfo = executeCommand('wmic logicaldisk get caption');
    $diskSpaceInfo = executeCommand('wmic logicaldisk get size,freespace');
    $diskInfoArray = explode("\n", trim($diskInfo));
    $diskSpaceInfoArray = explode("\n", trim($diskSpaceInfo));
    $diskUsageData = [];

    for ($i = 1; $i < count($diskInfoArray); $i++) {
        $diskData = explode("  ", trim($diskInfoArray[$i]));
        $diskSpaceData = explode("  ", trim($diskSpaceInfoArray[$i]));
        if ($diskSpaceData[1] == "") {
            $diskSpaceData[1] = $diskSpaceData[2];
        }
        $totalSpaceGB = round((float) $diskSpaceData[1] / (1024 * 1024 * 1024), 2);
        $freeSpaceGB = round((float) $diskSpaceData[0] / (1024 * 1024 * 1024), 2);
        array_push($diskUsageData, $totalSpaceGB - $freeSpaceGB);
    }
    
    $chartTitle = $title;
    $chartCanvasId = $canvasId;
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
