<?php

// function executeCommand($command) {
//     $output = shell_exec($command);
//     return $output;
// }

function getCpuInfo() {
    $cpuInfo = executeCommand('wmic cpu get caption,MaxClockSpeed,NumberOfLogicalProcessors,NumberOfCores');

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
        echo "</table></div>";
    }
}

getCpuInfo();
?>