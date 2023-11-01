function getCPUFrequency(dataPoints, labels) {
  if ("performance" in window && "now" in performance) {
    const startTime = performance.now();
    setTimeout(() => {
      const endTime = performance.now();
      const cpuFrequency = 1000 / (endTime - startTime);
      console.log(`CPU Frequency: ${cpuFrequency} Hz`);
      dataPoints.push(cpuFrequency * Math.random());
      labels.push(labels.length + 1); // Numerical label
    }, 2000);
  } else return Math.random();
}

function createChart(chartOf = "CPU") {
  const DATA_COUNT = 10;
  const labels = [];
  const dataPoints = [];

  for (let i = 0; i <= DATA_COUNT; ++i) {
    labels.push(i.toString());
    dataPoints.push(Math.random());
  }

  setInterval(() => {
    if (chartOf == "CPU") getCPUFrequency(dataPoints, labels);
  }, 1000);

  const data = {
    labels: labels,
    datasets: [
      {
        label: "CPU Usage",
        data: dataPoints,
        borderColor: "lightgreen",
        fill: false,
        cubicInterpolationMode: "monotone",
        tension: 0.4,
      },
    ],
  };
  const ctx = document.getElementById("cpuUsageChart").getContext("2d");

  const config = {
    type: "line",
    data: data,
    options: {
      responsive: "true",
      plugins: {
        title: {
          display: true,
          text: "CPU Usage Chart",
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
    },
  };

  let chart = new Chart(ctx, config);
  const updateInterval = setInterval(() => {
    chart.update();
  }, 1000);
}
