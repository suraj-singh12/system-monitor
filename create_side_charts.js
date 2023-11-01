
function createChart(ctx, data, labels, type = "line") {
  const chart = new Chart(ctx, {
    type: type,
    data: {
      labels: labels,
      datasets: [
        {
          label: "CPU Usage",
          borderColor: "rgba(75, 192, 192, 1)",
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
        },
      },
    },
  });
  return chart;
}
function createCpuChart() {
  const data = [];
  const labels = [];
  function getCPUFrequency() {
    if ("performance" in window && "now" in performance) {
      const startTime = performance.now();
      setTimeout(() => {
        const endTime = performance.now();
        const cpuFrequency = 1000 / (endTime - startTime);
        data.push(cpuFrequency);
        labels.push(labels.length + 1); // Numerical label
        console.log(`CPU Frequency: ${cpuFrequency} Hz`);
      }, 1000);
    } else {
      console.log("Performance API not available.");
    }
  }
  const ctx = document.getElementById("cpuUsageChart").getContext("2d");
  const ctx1 = document.getElementById("cpuUsageChart1").getContext("2d");
  const ctx2 = document.getElementById("cpuUsageChart2").getContext("2d");
  const ctx3 = document.getElementById("cpuUsageChart3").getContext("2d");
  const ctx4 = document.getElementById("cpuUsageChart4").getContext("2d");
  const chart = [createChart(ctx, data, labels), createChart(ctx1, data, labels), createChart(ctx2, data, labels), createChart(ctx3, data, labels), createChart(ctx4, data, labels)];
  function updateChart() {
    chart.forEach((chart) => chart.update());
      // chart.update();
  }
  setInterval(() => {
    getCPUFrequency();
    updateChart();
  }, 1000);
}