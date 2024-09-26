<script setup lang="ts">
import { defineProps } from 'vue';

const props = defineProps<{
  yearStats: Record<number, number> | undefined
}>();
</script>
<template>
  <div v-if="yearStats">
    <h6>Year Statistics</h6>
    <table class="table">
      <thead>
      <tr>
        <th>Year</th>
        <th>Count</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="(count, year) in yearStats" :key="year">
        <td>{{ year }}</td>
        <td>{{ count }}</td>
      </tr>
      </tbody>
    </table>
  </div>
  <div v-else>
    <p>No year statistics available</p>
  </div>
</template>
