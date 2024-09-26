<script setup lang="ts">
import { defineProps, computed } from 'vue'
import { Line } from 'vue-chartjs'
import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  LineElement,
  PointElement,
  LinearScale,
  CategoryScale
} from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, LineElement, PointElement, LinearScale, CategoryScale)

const props = defineProps<{
  data: Record<string, number>
  label: string

}>()

const lineChartData = computed(() => {
  if (!props.data) return { labels: [], datasets: [] }

  return {
    labels: Object.keys(props.data),
    datasets: [
      {
        label: props.label,
        data: Object.values(props.data),
        borderColor: '#42A5F5',
        backgroundColor: '#42A5F5',
        fill: false
      }
    ]
  }
})
</script>

<template>
  <Line :data="lineChartData" />
</template>
