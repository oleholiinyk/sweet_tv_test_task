<script setup lang="ts">
import { defineProps } from 'vue'
import type { ReportResponse } from '@/types/Responses'

const props = defineProps<{
  reportResult: ReportResponse | null
}>()
</script>

<template>
  <div v-if="reportResult">
    <div class="chart-container">
      <div class="chart">
        <h3 class="chart-title">Film Availability by Country</h3>
        <PieChart :data="reportResult.movies_by_country" label="Available Films" />
      </div>
      <div class="chart">
        <h3 class="chart-title">Movie Production Year Statistics</h3>
        <LineChart :data="reportResult.movies_by_year" label="Number of Films" />
      </div>
    </div>
  </div>
  <div v-else>
    <p>No charts available</p>
  </div>
</template>


<style scoped>
.chart-container {
  display: flex;
  justify-content: space-between; /* Distribute space between charts */
  flex-wrap: wrap; /* Allow charts to wrap on smaller screens */
  margin: 20px; /* Add margin for spacing */
}

.chart {
  flex: 1;
  min-width: 300px;
  margin: 10px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  padding: 10px;
  border-radius: 8px;
  background-color: #fff;
}

.chart-title {
  margin-bottom: 15px;
}
</style>
