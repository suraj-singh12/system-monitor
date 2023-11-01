<?php
// function executeCommand($command) {
//     $output = shell_exec($command);
//     return $output;
// }

function getBasicInfo() {
    $osInfo = executeCommand('ver');
    $kernelInfo = [
        executeCommand('systeminfo | findstr /B /C:"OS Name"'),
        executeCommand('systeminfo | findstr /B /C:"OS Version"')
    ];
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
    echo "</div></div>";
}

getBasicInfo();
?>