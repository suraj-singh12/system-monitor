

function createChart(ctx, data, labels, color, type = "side", chartLabel = 'CPU Usage') {
  let additionalDatasetOptions = {};
  let additionalChartOptions = {};
  if(type === "main") {
    additionalDatasetOptions = {
      cubicInterpolationMode: "monotone",
      tension: 0.4,
    }
    additionalChartOptions = {
      responsive: "true",
      plugins: {
        title: {
          display: true,
          text: chartLabel + " Chart",
        },
      },
      interaction: {
        intersect: false,
      },
      scales: {
        x: {
          display: true,
          title: {
            display: true,
          },
        },
        y: {
          display: true,
          title: {
            display: true,
            text: "Load",
          },
          suggestedMin: -1,
          suggestedMax: 1,
        },
      },
    }
  } else {
    additionalChartOptions = {
      scales: {
        x: {
          type: "linear", 
          position: "bottom",
        },
        y: {
          beginAtZero: true,
          suggestedMax: 1,
        },
      },
    }
  }

  
  const chart = new Chart(ctx, {
    type: "line",
    data: {
      labels: labels,
      datasets: [
        {
          label: chartLabel,
          borderColor: color, 
          fill: false,
          data: data,
          ...additionalDatasetOptions
        },
      ],
    },
    options: {
      ...additionalChartOptions
    },
  });
  return chart;
}
function createCpuChart(element, color, type="side") {
  const data = [];
  const labels = [];
  function getCPUFrequency() {
    if ("performance" in window && "now" in performance) {
      const startTime = performance.now();
      setTimeout(() => {
        const endTime = performance.now();
        const cpuFrequency = 1000 / (endTime - startTime);
        data.push(cpuFrequency * Math.random());
        labels.push(labels.length + 1); // Numerical label
        // console.log(`CPU Frequency: ${cpuFrequency} Hz`);
      }, 1000);
    } else {
      // console.log("Performance API not available.");
    }
  }
  const ctx = document.getElementById(element).getContext("2d");
  // const ctx1 = document.getElementById("cpuUsageChart1").getContext("2d");
  // const ctx2 = document.getElementById("cpuUsageChart2").getContext("2d");
  // const ctx3 = document.getElementById("cpuUsageChart3").getContext("2d");
  // const ctx4 = document.getElementById("cpuUsageChart4").getContext("2d");
  // const chart = [createChart(ctx, data, labels, color), createChart(ctx1, data, labels, color), createChart(ctx2, data, labels, color), createChart(ctx3, data, labels, color), createChart(ctx4, data, labels, color)];
  const chart = createChart(ctx, data, labels, color, type);
  function updateChart() {
    // chart.forEach((chart) => chart.update());
      chart.update();
  }
  setInterval(() => {
    getCPUFrequency();
    updateChart();
  }, 1000);
}

function createMemoryChart(element, color, type="side", totalMemory=16) {
  const data = [];
  const labels = [];
  function getMemoryUsage() {
    setTimeout(() => {
      data.push((totalMemory / 2) * Math.random());
      labels.push(labels.length + 1); 
    }, 1000);
  }
  
  const ctx = document.getElementById(element).getContext("2d");
  const chart = createChart(ctx, data, labels, color, type, 'Memory Usage');
  setInterval(() => {
    getMemoryUsage();
    chart.update();
  }, 1000);
}