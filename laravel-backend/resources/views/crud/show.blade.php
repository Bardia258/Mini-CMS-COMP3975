@extends('layouts.master')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title mb-4">Article Details</h2>

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
                <div class="border p-3 bg-light">
                    {!! $article['Content'] ?? '-' !!}
                </div>
            </div>

            <div class="mb-3">
                <strong>Created At:</strong>
                <p>{{ $article['created_at'] ?? '-' }}</p>
            </div>

            <div class="mt-4">
                <a href="{{ route('crud.index') }}" class="btn btn-primary">Return Home</a>
                <a href="{{ route('crud.edit', $article['id']) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('crud.delete', $article['id']) }}" class="btn btn-danger">Delete</a>
            </div>
        </div>
    </div>
</div>
@endsection
