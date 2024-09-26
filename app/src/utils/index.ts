import { SortOrder } from '@/enums/SortOrder'

export const isNullOrUndefined = (value: unknown): value is undefined | null => {
  return value === null || value === undefined
}

export const isEmptyArray = (arr: unknown): boolean => {
  return Array.isArray(arr) && arr.length === 0
}

export function sort(
  data: Record<string, number> | undefined,
  sortOrder: SortOrder = SortOrder.Desc
): Array<[string, number]> {
  if (!data) return []

  const genreArray = Object.entries(data)

  genreArray.sort((a, b) => {
    return sortOrder === SortOrder.Asc ? a[1] - b[1] : b[1] - a[1];
  })

  return genreArray
}
