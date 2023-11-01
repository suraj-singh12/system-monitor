<?php
// Function to execute a shell command and return the output
function executeCommand($command) {
    $output = shell_exec($command);
    return $output;
}

// Function to display system information
function displaySystemInfo() {
    $osInfo = executeCommand('ver');
    $kernelInfo = [
        executeCommand('systeminfo | findstr /B /C:"OS Name"'),
        executeCommand('systeminfo | findstr /B /C:"OS Version"')
    ];
    $cpuInfo = executeCommand('wmic cpu get caption,MaxClockSpeed,NumberOfLogicalProcessors,NumberOfCores');
    
    $memoryInfo = executeCommand('wmic memorychip get capacity');
    $memoryInfo = explode("\n", trim($memoryInfo));
    $totalMemory = 0;
    foreach($memoryInfo as $memory) {
        $totalMemory += (float)trim($memory);
    }
    $memoryInfo = $totalMemory / (1024 * 1024 * 1024);
    $diskInfo = executeCommand('wmic logicaldisk get caption');
    $diskSpaceInfo = executeCommand('wmic logicaldisk get size,freespace');
    $gpuInfo = executeCommand('wmic path win32_videocontroller get caption,AdapterRAM,AdapterDACType,VideoProcessor');
    $batteryInfo = executeCommand('wmic path Win32_Battery get EstimatedChargeRemaining,Caption');
    $wifiInfo = executeCommand('netsh wlan show interfaces');

    $diskInfoArray = explode("\n", trim($diskInfo));
    $diskSpaceInfoArray = explode("\n", trim($diskSpaceInfo));

    echo "<div class='info-container'>";
    echo "<h1>System Information</h1>";

    echo "<div class='info-box'>";
    echo "<h2>Operating System</h2>";
    echo "<p>" . $osInfo . "</p>";
    echo "</div>";

    echo "<div class='info-box'>";
    echo "<h2>Kernel</h2>";
    echo "<p>" . $kernelInfo[0] . "</p>";
    echo "<p>" . $kernelInfo[1] . "</p>";
    echo "</div>";

    echo "<div class='info-box'>";
    echo "<h2>CPU</h2>";
    echo "<table>";
    echo "<tr><th>CPU</th><th>Max Clock Speed (MHz)</th><th>Number of Cores</th><th>Number of Logical Processors</th></tr>";

    $cpuInfoArray = explode("\n", trim($cpuInfo));
    for ($i = 1; $i < count($cpuInfoArray); $i++) {
        $cpuData = explode("  ", trim($cpuInfoArray[$i]));
        $cpu = "";
        $maxSpeed = 0;
        $numberOfCores = 0;
        $numberOfLogicalProcessors = 0;
        foreach($cpuData as $key => $value) {
            if ($value) {
                if($cpu === "") $cpu = $value;
                else if($maxSpeed === 0) $maxSpeed = $value;
                else if($numberOfCores === 0) $numberOfCores = $value;
                else if($numberOfLogicalProcessors === 0) $numberOfLogicalProcessors = $value;
            }
        }
        echo "<tr><td>" . $cpu . "</td><td>" . $maxSpeed . "</td><td>" . $numberOfCores . "</td><td>" . $numberOfLogicalProcessors . "</td></tr>";
    }

    echo "</table>";
    echo "</div>";

    echo "<div class='info-box'>";
    echo "<h2>Memory</h2>";
    echo "<p>" . $memoryInfo . " GB </p>";
    echo "</div>";

    echo "<div class='info-box'>";
    echo "<h2>Disk Space</h2>";
    echo "<table>";
    echo "<tr><th>Drive</th><th>Total Space (GB)</th><th>Free Space (GB)</th></tr>";

    for ($i = 1; $i < count($diskInfoArray); $i++) {
        $diskData = explode("  ", trim($diskInfoArray[$i]));
        $diskSpaceData = explode("  ", trim($diskSpaceInfoArray[$i]));
        if($diskSpaceData[1] == "") {
            $diskSpaceData[1] = $diskSpaceData[2];
        }
        $totalSpaceGB = round((float)$diskSpaceData[1] / (1024 * 1024 * 1024), 2);
        $freeSpaceGB = round((float)$diskSpaceData[0] / (1024 * 1024 * 1024), 2);
        echo "<tr><td>" . $diskData[0] . "</td><td>" . $totalSpaceGB . "</td><td>" . $freeSpaceGB . "</td></tr>";
    }

    echo "</table>";
    echo "</div>";

    echo "<div class='info-box'>";
    echo "<h2>GPU</h2>";
    echo "<table>";
    echo "<tr><th>GPU</th><th>Adapter RAM (MB)</th><th>Adapter DAC Type</th><th>Video Processor</th></tr>";

    $gpuInfoArray = explode("\n", trim($gpuInfo));
    for ($i = 1; $i < count($gpuInfoArray); $i++) {
        $gpuData = explode("  ", trim($gpuInfoArray[$i]));
        $adapterRAMMB = round((float)$gpuData[1] / (1024 * 1024), 2);
        echo "<tr><td>" . $gpuData[0] . "</td><td>" . $adapterRAMMB . "</td><td>" . $gpuData[2] . "</td><td>" . $gpuData[3] . "</td></tr>";
    }

    echo "</table>";
    echo "</div>";

    echo "<div class='info-box'>";
    echo "<h2>WiFi</h2>";
    echo "<pre>" . $wifiInfo . "</pre>";
    echo "</div>";

    echo "<div class='info-box'>";
    echo "<h2>Battery</h2>";
    echo "<p>" . $batteryInfo . "</p>";
    echo "</div>";

    echo "</div>";
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

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        pre {
            white-space: pre-wrap;
        }
        .plot {
            background-color: #f0f0f0;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid black;
            text-align: center;
            text-decoration: none;
            color: black;
        }
        header {
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
        }
    </style>
</head>
<body>
    <div class="info-container">
        <header>
            <h1 class="heading">System Information</h1>
            <a href="./graph.php" class="plot">Plot Now</a>
        </header>
        <?php displaySystemInfo(); ?>
    </div>
</body>
</html>

