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
      <div class="memory">
        <canvas id="cpuUsageChart1"></canvas>
        <script>
          createCpuChart("cpuUsageChart1", "lightgreen");
        </script>
      </div>
      <div class="hdd">
        <canvas id="cpuUsageChart2"></canvas>
        <script>
          createCpuChart("cpuUsageChart2", "pink");
        </script>
      </div>
      <div class="wifi">
        <canvas id="cpuUsageChart3"></canvas>
        <script>
          createCpuChart("cpuUsageChart3", "grey ");
        </script>
      </div>
      <div class="gpu">
        <canvas id="cpuUsageChart4"></canvas>
        <script>
          createCpuChart("cpuUsageChart4", "cyan");
        </script>
      </div>
      <div class="combine">
        <button onclick="loadInfo('all')" id="combineButton">
          Display All Info
        </button>
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
    </div>
  </div>
</body>

</html>