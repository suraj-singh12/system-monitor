<?php

function memoryInfo() {
    $memoryInfo = executeCommand('wmic memorychip get capacity');
    $memoryInfo = explode("\n", trim($memoryInfo));
    $totalMemory = 0;

    foreach($memoryInfo as $memory) {
        $totalMemory += (float)trim($memory);
    }
    $memoryInfo = $totalMemory / (1024 * 1024 * 1024);
    echo "<div class='info-box'>";
    echo "<h2>Primary Memory</h2>";
    echo "<p id='totalRam'>" . $memoryInfo . " GB </p>";
    echo "</div>";
}

memoryInfo();
?>
