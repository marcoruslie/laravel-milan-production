// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

var canvasRK2 = document.getElementById("loadingRK2LineChart");
var loadingRK2LineChart = new Chart(canvasRK2, {
  type: 'line',
  data: {
    labels: [periodeReport[0]["week"], periodeReport[1]["week"], periodeReport[2]["week"], periodeReport[3]["week"], periodeReport[4]["week"]],
    datasets: [{
      label: "Target : ",
      lineTension: 0.3,
      backgroundColor: "rgba(0,128,0,0.1)",
      borderColor: "rgba(0,128,0,1)",
      pointRadius: 3, 
      pointBackgroundColor: "rgba(0,128,0,1)",
      pointBorderColor: "rgba(0,128,0,1)",
      pointHoverRadius: 3,
      pointHoverBackgroundColor: "rgba(0,128,0,1)",
      pointHoverBorderColor: "rgba(0,128,0,1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      data: [periodeReport[0]['dayCount']*4887, periodeReport[1]['dayCount']*4887, periodeReport[2]['dayCount']*4887, periodeReport[3]['dayCount']*4887, periodeReport[4]['dayCount']*4887],
    },
    {
      label: "Hasil : ",
      lineTension: 0.3,
      backgroundColor: "rgba(78, 115, 223, 0.05)",
      borderColor: "rgba(78, 115, 223, 1)",
      pointRadius: 3,
      pointBackgroundColor: "rgba(78, 115, 223, 1)",
      pointBorderColor: "rgba(78, 115, 223, 1)",
      pointHoverRadius: 3,
      pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
      pointHoverBorderColor: "rgba(78, 115, 223, 1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      data: [hasilKilnByMachineWeek[0][0]["hasilm2"], hasilKilnByMachineWeek[1][0]["hasilm2"], hasilKilnByMachineWeek[2][0]["hasilm2"], hasilKilnByMachineWeek[3][0]["hasilm2"], hasilKilnByMachineWeek[4][0]["hasilm2"]],
    }],
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 0,
        right: 0,
        top: 0,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          maxTicksLimit: 5,
          padding: 10,
          // Include a dollar sign in the ticks
          callback: function(value, index, values) {
            return '' + number_format(value);
          }
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }],
    },
    legend: {
      display: true
    },
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      intersect: false,
      mode: 'index',
      caretPadding: 10,
      callbacks: {
        label: function(tooltipItem, chart) {
          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
          return datasetLabel + number_format(tooltipItem.yLabel) + ' box';
        }
      }
    }
  }
});

var canvasRK4 = document.getElementById("loadingRK4LineChart");
var loadingRK4LineChart = new Chart(canvasRK4, {
  type: 'line',
  data: {
    labels: [periodeReport[0]["week"], periodeReport[1]["week"], periodeReport[2]["week"], periodeReport[3]["week"], periodeReport[4]["week"]],
    datasets: [{
      label: "Target : ",
      lineTension: 0.3,
      backgroundColor: "rgba(0,128,0,0.1)",
      borderColor: "rgba(0,128,0,1)",
      pointRadius: 3, 
      pointBackgroundColor: "rgba(0,128,0,1)",
      pointBorderColor: "rgba(0,128,0,1)",
      pointHoverRadius: 3,
      pointHoverBackgroundColor: "rgba(0,128,0,1)",
      pointHoverBorderColor: "rgba(0,128,0,1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      data: [periodeReport[0]['dayCount']*6887, periodeReport[1]['dayCount']*6887, periodeReport[2]['dayCount']*6887, periodeReport[3]['dayCount']*6887, periodeReport[4]['dayCount']*6887],
    },
    {
      label: "Hasil : ",
      lineTension: 0.3,
      backgroundColor: "rgba(78, 115, 223, 0.05)",
      borderColor: "rgba(78, 115, 223, 1)",
      pointRadius: 3,
      pointBackgroundColor: "rgba(78, 115, 223, 1)",
      pointBorderColor: "rgba(78, 115, 223, 1)",
      pointHoverRadius: 3,
      pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
      pointHoverBorderColor: "rgba(78, 115, 223, 1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      data: [hasilKilnByMachineWeek[0][0]["hasilm2"], hasilKilnByMachineWeek[1][0]["hasilm2"], hasilKilnByMachineWeek[2][0]["hasilm2"], hasilKilnByMachineWeek[3][0]["hasilm2"], hasilKilnByMachineWeek[4][0]["hasilm2"]],
    }],
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 0,
        right: 0,
        top: 0,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          maxTicksLimit: 5,
          padding: 10,
          // Include a dollar sign in the ticks
          callback: function(value, index, values) {
            return '' + number_format(value);
          }
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }],
    },
    legend: {
      display: true
    },
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      intersect: false,
      mode: 'index',
      caretPadding: 10,
      callbacks: {
        label: function(tooltipItem, chart) {
          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
          return datasetLabel + number_format(tooltipItem.yLabel) + ' box';
        }
      }
    }
  }
});

var canvasRK5 = document.getElementById("loadingRK5LineChart");
var loadingRK5LineChart = new Chart(canvasRK5, {
  type: 'line',
  data: {
    labels: [periodeReport[0]["week"], periodeReport[1]["week"], periodeReport[2]["week"], periodeReport[3]["week"], periodeReport[4]["week"]],
    datasets: [{
      label: "Target : ",
      lineTension: 0.3,
      backgroundColor: "rgba(0,128,0,0.1)",
      borderColor: "rgba(0,128,0,1)",
      pointRadius: 3, 
      pointBackgroundColor: "rgba(0,128,0,1)",
      pointBorderColor: "rgba(0,128,0,1)",
      pointHoverRadius: 3,
      pointHoverBackgroundColor: "rgba(0,128,0,1)",
      pointHoverBorderColor: "rgba(0,128,0,1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      data: [periodeReport[0]['dayCount']*9560, periodeReport[1]['dayCount']*9560, periodeReport[2]['dayCount']*9560, periodeReport[3]['dayCount']*9560, periodeReport[4]['dayCount']*9560],
    },
    {
      label: "Hasil : ",
      lineTension: 0.3,
      backgroundColor: "rgba(78, 115, 223, 0.05)",
      borderColor: "rgba(78, 115, 223, 1)",
      pointRadius: 3,
      pointBackgroundColor: "rgba(78, 115, 223, 1)",
      pointBorderColor: "rgba(78, 115, 223, 1)",
      pointHoverRadius: 3,
      pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
      pointHoverBorderColor: "rgba(78, 115, 223, 1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      data: [hasilKilnByMachineWeek[0][0]["hasilm2"], hasilKilnByMachineWeek[1][0]["hasilm2"], hasilKilnByMachineWeek[2][0]["hasilm2"], hasilKilnByMachineWeek[3][0]["hasilm2"], hasilKilnByMachineWeek[4][0]["hasilm2"]],
    }],
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 0,
        right: 0,
        top: 0,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          maxTicksLimit: 5,
          padding: 10,
          // Include a dollar sign in the ticks
          callback: function(value, index, values) {
            return '' + number_format(value);
          }
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }],
    },
    legend: {
      display: true
    },
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      intersect: false,
      mode: 'index',
      caretPadding: 10,
      callbacks: {
        label: function(tooltipItem, chart) {
          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
          return datasetLabel + number_format(tooltipItem.yLabel) + ' box';
        }
      }
    }
  }
});

var canvasKw1 = document.getElementById("kw1LineChart");
var kw1LineChart = new Chart(canvasKw1, {
  type: 'line',
  data: {
    labels: [periodeReport[0]["week"], periodeReport[1]["week"], periodeReport[2]["week"], periodeReport[3]["week"], periodeReport[4]["week"]],
    datasets: [{
      label: "Target : ",
      lineTension: 0.3,
      backgroundColor: "rgba(0,128,0,0.1)",
      borderColor: "rgba(0,128,0,1)",
      pointRadius: 3, 
      pointBackgroundColor: "rgba(0,128,0,1)",
      pointBorderColor: "rgba(0,128,0,1)",
      pointHoverRadius: 3,
      pointHoverBackgroundColor: "rgba(0,128,0,1)",
      pointHoverBorderColor: "rgba(0,128,0,1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      data: ["70", "70", "70", "70", "70"],
    },
    {
      label: "Hasil : ",
      lineTension: 0.3,
      backgroundColor: "rgba(78, 115, 223, 0.05)",
      borderColor: "rgba(78, 115, 223, 1)",
      pointRadius: 3,
      pointBackgroundColor: "rgba(78, 115, 223, 1)",
      pointBorderColor: "rgba(78, 115, 223, 1)",
      pointHoverRadius: 3,
      pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
      pointHoverBorderColor: "rgba(78, 115, 223, 1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      data: [hasilSortirWeekReport[0][0]["hasilPercentBox"], hasilSortirWeekReport[1][0]["hasilPercentBox"], hasilSortirWeekReport[2][0]["hasilPercentBox"], hasilSortirWeekReport[3][0]["hasilPercentBox"], hasilSortirWeekReport[4][0]["hasilPercentBox"]],
    }],
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 0,
        right: 0,
        top: 0,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          maxTicksLimit: 5,
          padding: 10,
          // Include a dollar sign in the ticks
          callback: function(value, index, values) {
            return '' + number_format(value);
          }
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }],
    },
    legend: {
      display: true
    },
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      intersect: false,
      mode: 'index',
      caretPadding: 10,
      callbacks: {
        label: function(tooltipItem, chart) {
          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
          return datasetLabel + number_format(tooltipItem.yLabel) + ' %';
        }
      }
    }
  }
});

var canvasKw2 = document.getElementById("kw2LineChart");
var kw2LineChart = new Chart(canvasKw2, {
  type: 'line',
  data: {
    labels: [periodeReport[0]["week"], periodeReport[1]["week"], periodeReport[2]["week"], periodeReport[3]["week"], periodeReport[4]["week"]],
    datasets: [{
      label: "Target : ",
      lineTension: 0.3,
      backgroundColor: "rgba(0,128,0,0.1)",
      borderColor: "rgba(0,128,0,1)",
      pointRadius: 3, 
      pointBackgroundColor: "rgba(0,128,0,1)",
      pointBorderColor: "rgba(0,128,0,1)",
      pointHoverRadius: 3,
      pointHoverBackgroundColor: "rgba(0,128,0,1)",
      pointHoverBorderColor: "rgba(0,128,0,1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      data: ["20", "20", "20", "20", "20"],
    },
    {
      label: "Hasil : ",
      lineTension: 0.3,
      backgroundColor: "rgba(78, 115, 223, 0.05)",
      borderColor: "rgba(78, 115, 223, 1)",
      pointRadius: 3,
      pointBackgroundColor: "rgba(78, 115, 223, 1)",
      pointBorderColor: "rgba(78, 115, 223, 1)",
      pointHoverRadius: 3,
      pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
      pointHoverBorderColor: "rgba(78, 115, 223, 1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      data: [hasilSortirWeekReport[0][1]["hasilPercentBox"], hasilSortirWeekReport[1][1]["hasilPercentBox"], hasilSortirWeekReport[2][1]["hasilPercentBox"], hasilSortirWeekReport[3][1]["hasilPercentBox"], hasilSortirWeekReport[4][1]["hasilPercentBox"]],
    }],
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 0,
        right: 0,
        top: 0,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          maxTicksLimit: 5,
          padding: 10,
          // Include a dollar sign in the ticks
          callback: function(value, index, values) {
            return '' + number_format(value);
          }
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }],
    },
    legend: {
      display: true
    },
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      intersect: false,
      mode: 'index',
      caretPadding: 10,
      callbacks: {
        label: function(tooltipItem, chart) {
          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
          return datasetLabel + number_format(tooltipItem.yLabel) + ' %';
        }
      }
    }
  }
});

var canvasKw3 = document.getElementById("kw3LineChart");
var kw3LineChart = new Chart(canvasKw3, {
  type: 'line',
  data: {
    labels: [periodeReport[0]["week"], periodeReport[1]["week"], periodeReport[2]["week"], periodeReport[3]["week"], periodeReport[4]["week"]],
    datasets: [{
      label: "Target : ",
      lineTension: 0.3,
      backgroundColor: "rgba(0,128,0,0.1)",
      borderColor: "rgba(0,128,0,1)",
      pointRadius: 3, 
      pointBackgroundColor: "rgba(0,128,0,1)",
      pointBorderColor: "rgba(0,128,0,1)",
      pointHoverRadius: 3,
      pointHoverBackgroundColor: "rgba(0,128,0,1)",
      pointHoverBorderColor: "rgba(0,128,0,1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      data: ["7", "7", "7", "7", "7"],
    },
    {
      label: "Hasil : ",
      lineTension: 0.3,
      backgroundColor: "rgba(78, 115, 223, 0.05)",
      borderColor: "rgba(78, 115, 223, 1)",
      pointRadius: 3,
      pointBackgroundColor: "rgba(78, 115, 223, 1)",
      pointBorderColor: "rgba(78, 115, 223, 1)",
      pointHoverRadius: 3,
      pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
      pointHoverBorderColor: "rgba(78, 115, 223, 1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      data: [hasilSortirWeekReport[0][2]["hasilPercentBox"], hasilSortirWeekReport[1][2]["hasilPercentBox"], hasilSortirWeekReport[2][2]["hasilPercentBox"], hasilSortirWeekReport[3][2]["hasilPercentBox"], hasilSortirWeekReport[4][2]["hasilPercentBox"]],
    }],
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 0,
        right: 0,
        top: 0,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          maxTicksLimit: 5,
          padding: 10,
          // Include a dollar sign in the ticks
          callback: function(value, index, values) {
            return '' + number_format(value);
          }
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }],
    },
    legend: {
      display: true
    },
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      intersect: false,
      mode: 'index',
      caretPadding: 10,
      callbacks: {
        label: function(tooltipItem, chart) {
          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
          return datasetLabel + number_format(tooltipItem.yLabel) + ' %';
        }
      }
    }
  }
});

var canvasKw4 = document.getElementById("kw4LineChart");
var kw4LineChart = new Chart(canvasKw4, {
  type: 'line',
  data: {
    labels: [periodeReport[0]["week"], periodeReport[1]["week"], periodeReport[2]["week"], periodeReport[3]["week"], periodeReport[4]["week"]],
    datasets: [{
      label: "Target : ",
      lineTension: 0.3,
      backgroundColor: "rgba(0,128,0,0.1)",
      borderColor: "rgba(0,128,0,1)",
      pointRadius: 3, 
      pointBackgroundColor: "rgba(0,128,0,1)",
      pointBorderColor: "rgba(0,128,0,1)",
      pointHoverRadius: 3,
      pointHoverBackgroundColor: "rgba(0,128,0,1)",
      pointHoverBorderColor: "rgba(0,128,0,1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      data: ["3", "3", "3", "3", "3"],
    },
    {
      label: "Hasil : ",
      lineTension: 0.3,
      backgroundColor: "rgba(78, 115, 223, 0.05)",
      borderColor: "rgba(78, 115, 223, 1)",
      pointRadius: 3,
      pointBackgroundColor: "rgba(78, 115, 223, 1)",
      pointBorderColor: "rgba(78, 115, 223, 1)",
      pointHoverRadius: 3,
      pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
      pointHoverBorderColor: "rgba(78, 115, 223, 1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      data: [hasilSortirWeekReport[0][3]["hasilPercentBox"], hasilSortirWeekReport[1][3]["hasilPercentBox"], hasilSortirWeekReport[2][3]["hasilPercentBox"], hasilSortirWeekReport[3][3]["hasilPercentBox"], hasilSortirWeekReport[4][3]["hasilPercentBox"]],
    }],
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 0,
        right: 0,
        top: 0,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          maxTicksLimit: 5,
          padding: 10,
          // Include a dollar sign in the ticks
          callback: function(value, index, values) {
            return '' + number_format(value);
          }
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }],
    },
    legend: {
      display: true
    },
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      intersect: false,
      mode: 'index',
      caretPadding: 10,
      callbacks: {
        label: function(tooltipItem, chart) {
          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
          return datasetLabel + number_format(tooltipItem.yLabel) + ' %';
        }
      }
    }
  }
});

var canvasKw5 = document.getElementById("kw5LineChart");
var kw5LineChart = new Chart(canvasKw5, {
  type: 'line',
  data: {
    labels: [periodeReport[0]["week"], periodeReport[1]["week"], periodeReport[2]["week"], periodeReport[3]["week"], periodeReport[4]["week"]],
    datasets: [{
      label: "Target : ",
      lineTension: 0.3,
      backgroundColor: "rgba(0,128,0,0.1)",
      borderColor: "rgba(0,128,0,1)",
      pointRadius: 3, 
      pointBackgroundColor: "rgba(0,128,0,1)",
      pointBorderColor: "rgba(0,128,0,1)",
      pointHoverRadius: 3,
      pointHoverBackgroundColor: "rgba(0,128,0,1)",
      pointHoverBorderColor: "rgba(0,128,0,1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      data: ["3", "3", "3", "3", "3"],
    },
    {
      label: "Hasil : ",
      lineTension: 0.3,
      backgroundColor: "rgba(78, 115, 223, 0.05)",
      borderColor: "rgba(78, 115, 223, 1)",
      pointRadius: 3,
      pointBackgroundColor: "rgba(78, 115, 223, 1)",
      pointBorderColor: "rgba(78, 115, 223, 1)",
      pointHoverRadius: 3,
      pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
      pointHoverBorderColor: "rgba(78, 115, 223, 1)",
      pointHitRadius: 10,
      pointBorderWidth: 2,
      data: [hasilSortirWeekReport[0][4]["hasilPercentBox"], hasilSortirWeekReport[1][4]["hasilPercentBox"], hasilSortirWeekReport[2][4]["hasilPercentBox"], hasilSortirWeekReport[3][4]["hasilPercentBox"], hasilSortirWeekReport[4][4]["hasilPercentBox"]],
    }],
  },
  options: {
    maintainAspectRatio: false,
    layout: {
      padding: {
        left: 0,
        right: 0,
        top: 0,
        bottom: 0
      }
    },
    scales: {
      xAxes: [{
        time: {
          unit: 'date'
        },
        gridLines: {
          display: false,
          drawBorder: false
        },
        ticks: {
          maxTicksLimit: 7
        }
      }],
      yAxes: [{
        ticks: {
          maxTicksLimit: 5,
          padding: 10,
          // Include a dollar sign in the ticks
          callback: function(value, index, values) {
            return '' + number_format(value);
          }
        },
        gridLines: {
          color: "rgb(234, 236, 244)",
          zeroLineColor: "rgb(234, 236, 244)",
          drawBorder: false,
          borderDash: [2],
          zeroLineBorderDash: [2]
        }
      }],
    },
    legend: {
      display: true
    },
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      titleMarginBottom: 10,
      titleFontColor: '#6e707e',
      titleFontSize: 14,
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      intersect: false,
      mode: 'index',
      caretPadding: 10,
      callbacks: {
        label: function(tooltipItem, chart) {
          var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
          return datasetLabel + number_format(tooltipItem.yLabel) + ' %';
        }
      }
    }
  }
});