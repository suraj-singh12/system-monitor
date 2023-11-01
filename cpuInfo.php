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
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .info-box {
            background-color: #f0f0f0;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }
        h2 {
            font-size: 18px;
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

    </style>
</head>
<body>
    <?php getCpuInfo(); ?>
</body>
</html>