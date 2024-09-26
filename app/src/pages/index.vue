<script setup lang="ts">
import { ref } from 'vue'
import { useToast } from 'vue-toastification'
import { useMoviesFeedStore } from '@/stores/useMoviesFeedStore'
import type { BFormProps } from 'bootstrap-vue-next'
import type { ReportResponse } from '@/types/Responses'
import ReportResultModal from '@/components/report/ReportResultModal.vue'

const modalVisible = ref(false)
const refBForm = ref<BFormProps>()
const dataForm = ref<ReportForm>({
  max_result: null,
  start_index: null
})

const storage = useMoviesFeedStore()
const toast = useToast()

const reportResult = ref<ReportResponse | null>(null)

const onFormSubmit = async () => {
  if (dataForm) {
    try {
      reportResult.value = await storage.generateReport(dataForm.value);
      toast.success('Report generated successfully');
      modalVisible.value = true;
    } catch (error: any) {
      const errorMessage = error.response?.data?.message || 'An error occurred while generating the report';
      toast.error(errorMessage);
    }
  } else {
    toast.error('Form is not valid');
  }
}
</script>
<template>
  <BContainer class="d-flex flex-column align-items-center">
    <BCard class="mb-5 w-50">
      <h4 class="text-center mb-1">Movie Feed Report Generation</h4>
    </BCard>
    <BCard class="w-50">
      <BForm ref="refBForm" @submit.prevent="onFormSubmit">
        <BFormGroup
          id="input-group-1"
          label="Max Result"
          label-for="input-1"
        >
          <BFormInput
            id="input-1"
            v-model="dataForm.max_result"
            type="number"
            placeholder="Enter max result"
          />
        </BFormGroup>

        <BFormGroup id="input-group-2" label="Start Index" label-for="input-2">
          <BFormInput
            id="input-2"
            v-model="dataForm.start_index"
            type="number"
            placeholder="Enter start index"
            required
          />
        </BFormGroup>

        <BButton class="mt-4 w-100" type="submit" variant="primary">Generate</BButton>
      </BForm>
    </BCard>
  </BContainer>
  <ReportResultModal
    :modalVisible="modalVisible"
    :reportResult="reportResult"
    @close="modalVisible = false"
  />
</template>
