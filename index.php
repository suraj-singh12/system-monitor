<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
      ></script>

      <!-- for charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="./create_side_charts.js"></script>
    
    <style>
      * {
        text-align: center;
      }
      .container {
        margin-top: 2rem;
        /* border: 1px solid black; */
      }
      .sidebar {
        display: inline-block;
        width: 20%;
        border: 1px solid black;
      }
      .main {
        display: inline-block;
        width: 70%;
        border: 1px solid black;
      }
    </style>

    <script>
      function loadInfo(ofType) {
        if(ofType === 'cpu') {
          document.getElementById('cpu').textContent = 
          console.log('loading php')
        }
        else document.getElementById('cpu').innerHTML = "";
      }
    </script>
  </head>
  <body>
    <div class="container">
      <div class="sidebar">
        <div class="cpu" onclick="loadInfo('cpu')">
          <canvas id="cpuUsageChart"></canvas>
          <script>
            createCpuChart('cpuUsageChart','orange');
          </script>
        </div>
        <div class="memory">
            <canvas id="cpuUsageChart1"></canvas>
          <script>
            createCpuChart('cpuUsageChart1','lightgreen');
          </script>
        </div>
        <div class="hdd">
            <canvas id="cpuUsageChart2"></canvas>
          <script>
            createCpuChart('cpuUsageChart2','pink');
          </script>
        </div>
        <div class="wifi">
            <canvas id="cpuUsageChart3"></canvas>
          <script>
            createCpuChart('cpuUsageChart3','grey ');
          </script>
        </div>
        <div class="gpu">
            <canvas id="cpuUsageChart4"></canvas>
          <script>
            createCpuChart('cpuUsageChart4','cyan');
          </script>
        </div>
      </div>
      <div class="main">
        <div class="cpu" id="cpu">
          <?php include('./systemVitals.php'); ?>
        </div>
      </div>
    </div>
  </body>
</html>
