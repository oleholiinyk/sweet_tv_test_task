export interface ReportResponse {
  id: number;
  max_result: number;
  start_index: number;
  movies_count: number;
  average_actors_count: number;
  genre_stats: Record<string, number>;
  movies_by_country: Record<string, number>;
  movies_by_year: Record<number, number>;
  top_keywords: Record<string, number>;
  viewing_options_movies_count: Record<string, number>;
}
