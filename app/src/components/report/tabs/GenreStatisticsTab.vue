<script setup lang="ts">
import { computed, defineProps } from 'vue'
import { sort } from '@/utils'

const props = defineProps<{
  genreStats: Record<string, number> | undefined
}>()

const sortedGenres = computed(() => sort(props.genreStats))
</script>

<template>
  <div v-if="genreStats">
    <h6>Genre Statistics</h6>
    <table class="table">
      <thead>
      <tr>
        <th>Genre</th>
        <th>Count</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="([genre, count]) in sortedGenres" :key="genre">
        <td>{{ genre }}</td>
        <td>{{ count }}</td>
      </tr>
      </tbody>
    </table>
  </div>
  <div v-else>
    <p>No genre statistics available</p>
  </div>
</template>
