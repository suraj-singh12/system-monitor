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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Basic Info</title>
    <!-- <style>
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            margin: 0;
        }
        .info-container {
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        
    </style> -->
</head>
<body>
    <?php getBasicInfo(); ?>
</body>
</html>