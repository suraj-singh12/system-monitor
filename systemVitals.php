<?php
// Function to execute a shell command and return the output
// function executeCommand($command) {
//     $output = shell_exec($command);
//     return $output;
// }

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
    
    $lines = explode("\n", $wifiInfo);
    echo '<table>';
    foreach ($lines as $line) {
        $parts = explode(':', $line, 2);
        $key = trim($parts[0]);
        $value = trim(isset($parts[1]) ? $parts[1] : '');

        if ($key !== '') {
            echo '<tr>';
            echo '<td>' . $key . '</td>';
            echo '<td>' . $value . '</td>';
            echo '</tr>';
        }
    }
    echo '</table>';
    echo "</div>";

    echo "</div>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>System Info</title>
    <link rel="stylesheet" href="./common.css">
</head>
<body>
    <?php displaySystemInfo(); ?>   
</body>
</html>

