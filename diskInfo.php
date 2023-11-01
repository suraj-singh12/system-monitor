<?php
    // function executeCommand($command) {
    //     $output = shell_exec($command);
    //     return $output;
    // }
    $diskInfo = executeCommand('wmic logicaldisk get caption');
    $diskSpaceInfo = executeCommand('wmic logicaldisk get size,freespace');
    $diskInfoArray = explode("\n", trim($diskInfo));
    $diskSpaceInfoArray = explode("\n", trim($diskSpaceInfo));

    echo "<div class='info-box'>";
    echo "<h2>Disk Space</h2>";
    echo "<table>";
    echo "<tr><th>Drive</th><th>Total Space (GB)</th><th>Used Space (GB)</th><th>Free Space (GB)</th></tr>";
    
    for ($i = 1; $i < count($diskInfoArray); $i++) {
        $diskData = explode("  ", trim($diskInfoArray[$i]));
        $diskSpaceData = explode("  ", trim($diskSpaceInfoArray[$i]));
        if ($diskSpaceData[1] == "") {
            $diskSpaceData[1] = $diskSpaceData[2];
        }
        $totalSpaceGB = round((float) $diskSpaceData[1] / (1024 * 1024 * 1024), 2);
        $freeSpaceGB = round((float) $diskSpaceData[0] / (1024 * 1024 * 1024), 2);
        echo "<tr><td>" . $diskData[0] . "</td><td>" . $totalSpaceGB . "</td><td>" . ($totalSpaceGB - $freeSpaceGB) . "</td><td>" . $freeSpaceGB . "</td></tr>";
    }

    echo "</table>";
    echo "</div>";
?>