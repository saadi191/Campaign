<template>
  <Bar id="my-chart-id" :options="chartOptions" :data="chartData" />
</template>

<script>
import { Bar } from 'vue-chartjs';
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
  Chart,
} from 'chart.js';
import 'chartjs-plugin-datalabels';
import ChartJSPluginDatalabels from 'chartjs-plugin-datalabels';
import { onMounted, onUnmounted, ref, watch } from 'vue';

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  BarElement,
  CategoryScale,
  LinearScale,
  ChartJSPluginDatalabels,
);

export default {
  name: 'LocChart',
  components: { Bar },
  props: ['data', 'width', 'height'],
  data() {
    return {
      chartData: {
        labels: this.data.labels || [],
        datasets: [
          {
            data: this.data.datasets || [],
            backgroundColor: ['indigo', 'blue', 'green'],
          },
        ],
      },
      chartOptions: {
        responsive: true,
        barPercentage: 1,
        scales: {
          y: {
            beginAtZero: false,
          },
        },
        plugins: {
          legend: {
            display: false,
          },
          datalabels: {
            display: false,
          },
          // datalabels: {
          //   color: 'black',
          //   position: 'top',
          //   anchor: 'start',
          //   align: 'end',
          //   offset: -4,
          //   formatter: function (value, context) {
          //     const label = context.chart.data.labels[context.dataIndex];
          //     return `${value} Participants from ${label}`;
          //   },
          // },
        },
      },
    };
  },
};
</script>
