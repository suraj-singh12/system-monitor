<?php

    $wifiInfo = executeCommand('netsh wlan show interfaces');
    echo "<div class='info-container'>";
    echo "<h1>WiFi</h1>";

    $lines = explode("\n", $wifiInfo);
    echo "<div class='info-box'>";
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
    echo "</div></div>";
?>