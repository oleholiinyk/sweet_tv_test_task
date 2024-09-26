<script setup lang="ts">
import { defineProps } from 'vue';
import type { ReportResponse } from '@/types/Responses'

const props = defineProps<{
  reportResult: ReportResponse | null
}>();
</script>

<template>
  <div v-if="reportResult">
    <table class="table">
      <thead>
      <tr>
        <th>Statistic</th>
        <th>Value</th>
      </tr>
      </thead>
      <tbody>
      <tr>
        <td>Total Movies</td>
        <td>{{ reportResult.movies_count }}</td>
      </tr>
      <tr>
        <td>Total Countries</td>
        <td>
          <ul>
            <li v-for="(count, country) in reportResult.movies_by_country" :key="country">
              {{ country }}: {{ count }}
            </li>
          </ul>
        </td>
      </tr>
      <tr>
        <td>Average Actors per Movie</td>
        <td>{{ reportResult.average_actors_count.toFixed() }}</td>
      </tr>
      <tr>
        <td>Movies Available by Viewing Option</td>
        <td>
          <ul>
            <li v-for="(count, option) in reportResult.viewing_options_movies_count" :key="option">
              {{ option }}: {{ count }}
            </li>
          </ul>
        </td>
      </tr>
      </tbody>
    </table>
  </div>
  <div v-else>
    <p>No report available</p>
  </div>
</template>
