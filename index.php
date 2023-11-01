<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>System Monitor</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>

  <!-- for charts -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="./create_charts.js"></script>

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Belleza&family=Playfair+Display&display=swap');
    * {
      text-align: center;
    }

    .container {
      margin-top: 1.5rem;
      display: inline-block;
      font-family: 'Belleza', sans-serif;
      font-family: 'Playfair Display', serif;
      /* border: 1px solid black; */
    }

    .sidebar {
      float: left;
      width: 20%;
      position: -webkit-sticky;
      /* Safari */
      position: sticky;
      top: 1rem;
      /* border: 1px solid black; */
    }

    .sidebar>div:hover {
      background-color: rgb(227, 225, 225);
    }

    .sidebar>div {
      /* box-shadow: rgba(6, 24, 44, 0.4) 0px 0px 0px 2px, rgba(6, 24, 44, 0.65) 0px 4px 6px -1px, rgba(255, 255, 255, 0.08) 0px 1px 0px inset; */
      /* box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset; */
      /* box-shadow: rgba(0, 0, 0, 0.4) 0px 30px 90px; */
      box-shadow: rgba(0, 0, 0, 0.15) 2.4px 2.4px 3.2px;
      /* box-shadow: rgba(0, 0, 0, 0.07) 0px 1px 1px, rgba(0, 0, 0, 0.07) 0px 2px 2px, rgba(0, 0, 0, 0.07) 0px 4px 4px, rgba(0, 0, 0, 0.07) 0px 8px 8px, rgba(0, 0, 0, 0.07) 0px 16px 16px; */
      /* box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 1px 3px 1px; */
      border-radius: 0.5rem;
      border: 1px solid grey;
      margin-bottom: 0.5rem;
    }

    .main {
      float: right;
      width: 70%;
      border: 1px solid black;
    }

    #cpu,
    #all {
      display: none;
    }

    button {
      border: 0;
      background-color: transparent;
    }

    .heading {
      text-align: center;
    }
  </style>

  <script>
    let prevType = null;
    function loadInfo(ofType) {
      console.log('type : ', ofType)
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
    <h1>System Monitor [OS: Win Based x64] </h1>
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