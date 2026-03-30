@extends('layouts.master')

@section('content')
<div class="container mt-5">
    <div class="card border-danger">
        <div class="card-body">
            <h2 class="card-title mb-4 text-danger">Delete Article</h2>

            <div class="alert alert-warning" role="alert">
                <strong>Warning!</strong> This action cannot be undone. Please confirm you want to delete this article.
            </div>

            <div class="mb-3">
                <strong>ID:</strong>
                <p>{{ $article['id'] ?? '-' }}</p>
            </div>

            <div class="mb-3">
                <strong>Title:</strong>
                <p>{{ $article['Title'] ?? '-' }}</p>
            </div>

            <div class="mb-3">
                <strong>Content:</strong>
                <div class="border p-3 bg-light" style="max-height: 200px; overflow: auto;">
                    {!! substr($article['Content'] ?? '', 0, 500) !!}
                </div>
            </div>

            <div class="mb-3">
                <strong>Created At:</strong>
                <p>{{ $article['created_at'] ?? '-' }}</p>
            </div>

            <div class="mt-4">
                <form action="{{ route('crud.destroy', $article['id']) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure? This cannot be undone!')">
                        Delete Article
                    </button>
                </form>
                <a href="{{ route('crud.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </div>
</div>
@endsection
