@extends('layouts.master')

@section('content')
@php
    $articles = $articles ?? [];
    $searchTitle = $searchTitle ?? '';
@endphp
<div class="container mt-5">
    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($message = Session::get('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <h2 class="text-center mb-4">CRUD Interface</h2>

    <form action="{{ route('crud.index') }}" method="get" class="mb-3">
        <div class="input-group">
            <input type="text" name="title" class="form-control" placeholder="Search for an Article" value="{{ $searchTitle }}">
            <button type="submit" class="btn btn-info">Search</button>
        </div>
    </form>

    <a href="{{ route('crud.create') }}" class="btn btn-success mb-3">Create new article</a>

    @if($searchTitle)
        <p class="mt-3">Looking for article titles that contain <strong>{{ $searchTitle }}</strong>.</p>
    @else
        <p class="mt-3 text-muted">No filter provided</p>
    @endif

    <table class="table table-bordered mt-3">
        <thead class="table-light">
            <tr>
                <th scope="col">Article Name</th>
                <th scope="col">Article Content</th>
                <th scope="col">Created At</th>
                <th scope="col">Options</th>
            </tr>
        </thead>
        <tbody>
            @if(count($articles) > 0)
                @foreach($articles as $article)
                    <tr>
                        <td>{{ $article['Title'] ?? '-' }}</td>
                        <td>
                            <div style="max-height: 100px; overflow: hidden;">
                                {!! substr($article['Content'] ?? '', 0, 100) !!}...
                            </div>
                        </td>
                        <td>{{ $article['created_at'] ?? '-' }}</td>
                        <td>
                            <a class="btn btn-success btn-sm" href="{{ route('crud.show', $article['id']) }}">Read</a>
                            <a class="btn btn-warning btn-sm" href="{{ route('crud.edit', $article['id']) }}">Edit</a>
                            <a class="btn btn-danger btn-sm" href="{{ route('crud.delete', $article['id']) }}">Delete</a>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" class="text-center text-muted">No articles found</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
