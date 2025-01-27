<template>
  <div id="LineChart">
    <canvas id="myChart"></canvas>
  </div>
</template>

<script>
export default {
  name:"LineChart",
  props:['labels', 'values'],
  data(){
    return{
      ctx:null,
      myChart:null,
    }
  },
  methods: {
    drawChart(data) {
      this.canvas = document.getElementById('myChart');
      this.ctx = this.canvas.getContext('2d');
      this.myChart = new Chart(this.ctx, {
        type: 'line',
        data: {
          labels: data["labels"],
          datasets: [{
            data: data["values"],
            backgroundColor: 'rgb(45, 168, 216)',
            borderColor: 'rgb(45, 168, 216)',
            borderWidth: 3,
            tension: 0.4
          }]
        },
        options: {
          responsive: true,
          plugins : {
            legend: {
              display: false
            }
          }
        }
      });
    }
  },
  mounted() {
    this.drawChart({"labels":this.labels,"values":this.values})
  },
}
</script>