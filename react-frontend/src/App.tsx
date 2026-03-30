import { useEffect, useState } from 'react'
import './App.css'

function App() {
  const [articles, setArticles] = useState([])
  const [refetch, setRefetch] = useState(false)

  useEffect(() => {
    fetch("http://localhost:8000/api/articles")
      .then((data) => data.json())
      .then(data => {
        setArticles(data);
      });
  }, [refetch]);

  return (
    <div className="container" style={{ maxWidth: '900px', margin: '0 auto', padding: '20px' }}>
      {articles.map(item => (
        <div
          key={item.id}
          style={{
            border: '1px solid #ddd',
            borderRadius: '8px',
            marginBottom: '20px',
            overflow: 'hidden',
            boxShadow: '0 2px 4px rgba(0,0,0,0.1)'
          }}
        >
          {/* Header with Title and Date */}
          <div style={{ backgroundColor: '#f5f5f5', padding: '15px', borderBottom: '1px solid #ddd' }}>
            <div style={{ display: 'flex', justifyContent: 'space-between', gap: '15px' }}>
              <h2 style={{ margin: '0', fontSize: '24px', color: '#555' }}>{item.Title}</h2>
              <p style={{ margin: '0', fontSize: '14px', color: '#333', whiteSpace: 'nowrap' }}>
                {item.created_at ? new Date(item.created_at).toLocaleDateString() : 'Date unavailable'}
              </p>
            </div>
          </div>

          {/* Content */}
          <div
            style={{
              padding: '20px',
              lineHeight: '1.6',
              color: '#444'
            }}
            dangerouslySetInnerHTML={{ __html: item.Content }}
          />
        </div>
      ))}
    </div>
  )
}

export default App
