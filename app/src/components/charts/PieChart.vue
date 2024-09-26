<script setup lang="ts">
import { defineProps, computed } from 'vue'
import { Pie } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, ArcElement } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, ArcElement)

const props = defineProps<{
  data: Record<string, number>
  label: string
}>()

const pieChartData = computed(() => {
  if (!props.data) return { labels: [], datasets: [] }

  return {
    labels: Object.keys(props.data),
    datasets: [
      {
        label: props.label,
        data: Object.values(props.data),
        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#FF9F40', '#4BC0C0']
      }
    ]
  }
})
</script>

<template>
  <Pie :data="pieChartData" />
</template>
