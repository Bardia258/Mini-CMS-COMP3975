import { useEffect, useState } from 'react'
import './App.css'

type Article = {
  id: number
  Title: string
  Content: string
  created_at?: string
}

const API_URL = 'http://localhost:8000/api/articles'

function formatDate(dateValue?: string) {
  if (!dateValue) {
    return 'Date unavailable'
  }

  return new Intl.DateTimeFormat('en-US', {
    month: 'long',
    day: 'numeric',
    year: 'numeric',
  }).format(new Date(dateValue))
}

function App() {
  const [articles, setArticles] = useState<Article[]>([])
  const [isLoading, setIsLoading] = useState(true)
  const [error, setError] = useState('')
  const [sortOrder, setSortOrder] = useState<'latest' | 'oldest'>('latest')

  useEffect(() => {
    const controller = new AbortController()

    async function loadArticles() {
      try {
        setIsLoading(true)
        setError('')

        const response = await fetch(API_URL, {
          signal: controller.signal,
        })

        if (!response.ok) {
          throw new Error('Unable to load articles.')
        }

        const data: Article[] = await response.json()
        setArticles(data)
      } catch (fetchError) {
        if (fetchError instanceof DOMException && fetchError.name === 'AbortError') {
          return
        }

        setError('The article feed could not be loaded. Confirm the Laravel backend is running on port 8000.')
      } finally {
        setIsLoading(false)
      }
    }

    void loadArticles()

    return () => controller.abort()
  }, [])

  const sortedArticles = [...articles].sort((left, right) => {
    const leftTime = left.created_at ? new Date(left.created_at).getTime() : 0
    const rightTime = right.created_at ? new Date(right.created_at).getTime() : 0

    return sortOrder === 'latest' ? rightTime - leftTime : leftTime - rightTime
  })

  return (
    <div className="page-shell">
      <main className="content">
        {isLoading ? (
          <section className="status-card" aria-busy="true">
            <p className="status-card__eyebrow">Loading</p>
            <h2>Fetching articles from the backend.</h2>
            <p>The page will populate once the API responds.</p>
          </section>
        ) : null}

        {!isLoading && error ? (
          <section className="status-card status-card--error">
            <p className="status-card__eyebrow">Connection issue</p>
            <h2>Articles are unavailable right now.</h2>
            <p>{error}</p>
          </section>
        ) : null}

        {!isLoading && !error && articles.length > 0 ? (
          <>
            <section className="page-header">
              <h1>Articles: {articles.length}</h1>

              <label className="sort-control">
                <span>Sort by</span>
                <select
                  value={sortOrder}
                  onChange={(event) => setSortOrder(event.target.value as 'latest' | 'oldest')}
                >
                  <option value="latest">Latest first</option>
                  <option value="oldest">Oldest first</option>
                </select>
              </label>
            </section>

            <section className="article-grid">
              {sortedArticles.map((article) => (
                <article key={article.id} className="article-card">
                  <div className="article-card__header">
                    <span className="article-card__date">{formatDate(article.created_at)}</span>
                    <h2>{article.Title}</h2>
                  </div>

                  <div
                    className="article-content"
                    dangerouslySetInnerHTML={{ __html: article.Content }}
                  />
                </article>
              ))}
            </section>
          </>
        ) : null}

        {!isLoading && !error && articles.length === 0 ? (
          <section className="status-card">
            <p className="status-card__eyebrow">No content</p>
            <h2>No articles have been published yet.</h2>
            <p>Seed the database or create articles from the Laravel admin site.</p>
          </section>
        ) : null}
      </main>
    </div>
  )
}

export default App
