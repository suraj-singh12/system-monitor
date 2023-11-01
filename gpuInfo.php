<?php 
    $gpuInfo = executeCommand('wmic path win32_videocontroller get caption,AdapterRAM,AdapterDACType,VideoProcessor');
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
?>