

function createChart(ctx, data, labels, color, type = "line") {
  const chart = new Chart(ctx, {
    type: type,
    data: {
      labels: labels,
      datasets: [
        {
          label: "CPU Usage",
          borderColor: color, 
          fill: false,
          data: data,
        },
      ],
    },
    options: {
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
    },
  });
  return chart;
}
function createCpuChart(element, color) {
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
  const chart = createChart(ctx, data, labels, color);
  function updateChart() {
    // chart.forEach((chart) => chart.update());
      chart.update();
  }
  setInterval(() => {
    getCPUFrequency();
    updateChart();
  }, 1000);
}