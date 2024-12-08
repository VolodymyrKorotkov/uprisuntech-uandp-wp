document.addEventListener("DOMContentLoaded", function () {

  if(document.getElementById('myChart')){
    var ctx = document.getElementById('myChart').getContext('2d');

    var gradient = ctx.createLinearGradient(0, 0, 0, 500);
    gradient.addColorStop(0, 'rgba(42, 89, 189, 0.2)'); // колір на початку (0%)
    gradient.addColorStop(0.9555, 'rgba(42, 89, 189, 0.0001)'); // колір на 95.55%
    var chart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Січ', 'Лют', 'Бер', 'Кві', 'Трав', 'Черв', 'Лип', 'Серп', 'Вер', 'Жовт', 'Лист', 'Груд'], // Ваші мітки осі X
        datasets: [{
            label: 'Споживання, генерація (кВт·год)',
            backgroundColor: 'rgba(0, 123, 255, 0.5)', // колір заповнення області
            borderColor: '#89A9FF', // колір лінії
            data: [560, 626, 632, 638, 630, 646, 624, 628, 630, 642, 640, 684, ],
            pointRadius: 0,
            fill: '-1' // це забезпечує заповнення області під лінією
          },
          {
            label: 'Економія (%)',
            backgroundColor: gradient,
            borderColor: '#2A59BD',
            data: [0, 50, 66, 76, 76, 86, 84, 108, 156, 156, 186, 256],
            pointRadius: 0,
            fill: '-1'
          }
        ]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'К-ть енергії',
              font: {
                weight: 'bold' // робимо текст жирним
              }
            },
          },
          x: {
            grid: {
              drawOnChartArea: false, // це відключає вертикальні лінії
            },
            title: {
              display: true,
              text: 'Місяць',
              font: {
                weight: 'bold' // робимо текст жирним
              }
            },
          }
        }
      }
    });
  
  
  }
 
  if(document.getElementById('myChartEn')){
    var ctx = document.getElementById('myChartEn').getContext('2d');

    var gradient = ctx.createLinearGradient(0, 0, 0, 500);
    gradient.addColorStop(0, 'rgba(42, 89, 189, 0.2)'); // колір на початку (0%)
    gradient.addColorStop(0.9555, 'rgba(42, 89, 189, 0.0001)'); // колір на 95.55%
    var chart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'], // Ваші мітки осі X
        datasets: [{
            label: 'Consumption, generation (kWh)',
            backgroundColor: 'rgba(0, 123, 255, 0.5)', // колір заповнення області
            borderColor: '#89A9FF', // колір лінії
            data: [560, 626, 632, 638, 630, 646, 624, 628, 630, 642, 640, 684, ],
            pointRadius: 0,
            fill: '-1' // це забезпечує заповнення області під лінією
          },
          {
            label: 'Savings (%)',
            backgroundColor: gradient,
            borderColor: '#2A59BD',
            data: [0, 50, 66, 76, 76, 86, 84, 108, 156, 156, 186, 256],
            pointRadius: 0,
            fill: '-1'
          }
        ]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'Amount of energy',
              font: {
                weight: 'bold' // робимо текст жирним
              }
            },
          },
          x: {
            grid: {
              drawOnChartArea: false, // це відключає вертикальні лінії
            },
            title: {
              display: true,
              text: 'Month',
              font: {
                weight: 'bold' // робимо текст жирним
              }
            },
          }
        }
      }
    });
  
  }



})