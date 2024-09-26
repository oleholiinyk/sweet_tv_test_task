<script setup lang="ts">
import { computed, defineProps } from 'vue';

const props = defineProps<{
  topKeywords: Record<string, number> | undefined
}>();

const formattedKeywords = computed(() => {
  return Object.entries(props.topKeywords || {}).filter(([keyword]) => keyword.length >= 5).slice(0, 15);
});
</script>

<template>
  <div v-if="topKeywords">
    <h6>Top Keywords (length >= 5)</h6>
    <table class="table">
      <thead>
      <tr>
        <th>Keyword</th>
        <th>Count</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="([keyword, count]) in formattedKeywords" :key="keyword">
        <td>{{ keyword }}</td>
        <td>{{ count }}</td>
      </tr>
      </tbody>
    </table>
  </div>
  <div v-else>
    <p>No keywords available</p>
  </div>
</template>
