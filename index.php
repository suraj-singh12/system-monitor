<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>System Monitor</title>
  <!-- bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
  <!-- bootstrap icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <!-- for charts -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="./create_charts.js"></script>
  <!-- css -->
  <link rel="stylesheet" href="./style.css" />

  <script>
    let prevType = "simple";
    function loadInfo(ofType) {
      // console.log('type : ', ofType, 'prevType: ', prevType);
      document.getElementById(ofType).style.display = "inline-block";
      if (prevType && prevType !== ofType) {
        document.getElementById(prevType).style.display = "none";
      }
      prevType = ofType;
    }
  </script>
  <?php
    function executeCommand($command) {
      $output = shell_exec($command);
      return $output;
    }
    include('./php_charts.php');
  ?>
</head>

<body>
  <div class="container heading">
    <h1 onclick="loadInfo('simple')">System Monitor [OS: Win Based x64] </h1>
  </div>

  <div class="container">

    <div class="sidebar">
      <div class="cpu" onclick="loadInfo('cpu')">
        <canvas id="cpuUsageChart"></canvas>
        <script>
          createCpuChart("cpuUsageChart", "orange");
        </script>
      </div>
      
      <div class="memory" onclick="loadInfo('ramMemory')">
        <canvas id="primaryMemoryChart"></canvas>
        <script>
          createMemoryChart("primaryMemoryChart", "lightgreen");
        </script>
      </div>
      
      <div class="hdd" onclick="loadInfo('hddMemory')">
        <!-- <canvas id="hddUsageChart"></canvas>
        <script>
          createHddMemoryChart("hddUsageChart", "pink");
        </script> -->
        <?php displayDiskUsage("disk-usage-chart");   ?>
      </div>

      <div class="gpu" onclick="loadInfo('gpu')">
        <canvas id="gpuUsageChart"></canvas>
        <script>
          createGpuChart("gpuUsageChart", "cyan");
        </script>
      </div>
      
      <div class="wifi" onclick="loadInfo('wireless')">
          <i class="bi bi-wifi"></i>
      </div>
      
      
      <div class="combine" onclick="loadInfo('all')">
          <i class="bi bi-info-square"></i>
      </div>
    </div>

    <div class="main">
      
      <div id="all">
        <?php include('./systemVitals.php'); ?>
      </div>
      
      <div id="simple" style="width: 100%">
        <?php include('./basicInfo.php'); ?>
      </div>
      
      <div id="cpu">
        <canvas id="createCpuMainChart"></canvas>
        <script>
          createCpuChart('createCpuMainChart', 'orange');
          </script>
        <?php include('./cpuInfo.php'); ?>
      </div>

      <div id="ramMemory" style="width: 100%">
        <canvas id="createRamMemoryChart"></canvas>
        <script>
          createMemoryChart("createRamMemoryChart", "lightgreen", "main");
        </script>
        <?php include('./memoryInfo.php'); ?>
      </div>

      <div id="hddMemory" style="width: 100%">
        <!-- <canvas id="createhddMemoryChart"></canvas>
        <script>
          createHddMemoryChart("createhddMemoryChart", "pink", "main");
        </script> -->
        <?php 
          displayDiskUsage("disk-usage-chart2");   
          include('./diskInfo.php');
        ?>
      </div>

      <div id="gpu">
        <canvas id="createGpuMainChart"></canvas>
        <script>
          createGpuChart("createGpuMainChart", "cyan", "main");
        </script>
        <?php include("./gpuInfo.php"); ?>
      </div>

      <div id="wireless" style="text-align: center; width: 90%">
        <?php include('./wirelessInfo.php'); ?>
      </div>

    </div>
  </div>
</body>

</html>