import { defineStore } from 'pinia'
import axiosIns from '@axios'
import type { ReportResponse } from '@/types/Responses'

export const useMoviesFeedStore = defineStore('reportStore', {
  actions: {
    async generateReport(data: ReportForm): Promise<ReportResponse> {
      return (await axiosIns.post('/movies/feed/reports/generate', data)).data
    }
  }
})
