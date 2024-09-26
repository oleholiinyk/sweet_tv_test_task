<script setup lang="ts">
import { ref, defineProps, defineEmits, watch } from 'vue'
import type { ReportResponse } from '@/types/Responses'
import ChartsTab from '@/components/report/tabs/ChartsTab.vue'

const props = defineProps<{
  modalVisible: boolean,
  reportResult: ReportResponse | null
}>()

const activeTab = ref<number>(0)
const emits = defineEmits(['close'])
const isModalVisible = ref(props.modalVisible)

watch(() => props.modalVisible, (newVal) => {
  isModalVisible.value = newVal
})

const onClose = () => {
  emits('close')
  isModalVisible.value = false
}
</script>

<template>
  <BModal v-model="isModalVisible"
          title="Report Result"
          @hide="onClose"
          :hide-footer="true"
          :hide-overlay="true"
          :no-close-on-backdrop="true"
          size="xl"
  >
    <BTabs v-model="activeTab" class="mb-3">
      <BTab title="Overview" class="mt-4">
        <OverviewTab :reportResult="reportResult" />
      </BTab>
      <BTab title="Charts" class="mt-4">
        <ChartsTab :reportResult="reportResult" />
      </BTab>
      <BTab title="Genre Statistics" class="mt-4">
        <GenreStatisticsTab :genreStats="reportResult?.genre_stats" />
      </BTab>
      <BTab title="Top Keywords" class="mt-4">
        <TopKeywordsTab :topKeywords="reportResult?.top_keywords" />
      </BTab>
      <BTab title="Year Statistics" class="mt-4">
        <YearStatisticsTab :yearStats="reportResult?.movies_by_year" />
      </BTab>
    </BTabs>
  </BModal>
</template>
