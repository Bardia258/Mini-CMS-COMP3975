@extends('layouts.master')

@section('content')
    <div class="container mt-5">
        <h1 class="text-center mb-4">Create Article</h1>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Errors:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('crud.store') }}" method="POST" class="card p-4">
            @csrf

            <div class="mb-3">
                <label for="Title" class="form-label">Post Title</label>
                <input type="text" class="form-control @error('Title') is-invalid @enderror" id="Title" name="Title"
                    required value="{{ old('Title') }}">
                @error('Title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="editor" class="form-label">Content</label>
                <!-- Include Quill stylesheet -->
                <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
                <!-- Create the editor container -->
                <div id="editor" style="height: 400px;" class="@error('Content') border border-danger @enderror"></div>
                <input type="hidden" name="Content" id="Content" value="{{ old('Content') }}">
                @error('Content')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-success">Submit</button>
                <a href="{{ route('crud.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <!-- Include the Quill library -->
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script>
        // Initialize Quill editor
        const quill = new Quill('#editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'size': ['small', false, 'large', 'huge'] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    ['link', 'image'],
                    ['clean']
                ]
            }
        });

        // Load old content if available (from form resubmission)
        const oldContent = @json(old('Content'));
        if (oldContent) {
            setTimeout(() => {
                quill.root.innerHTML = oldContent;
            }, 100);
        }

        // Sync Quill content to hidden input before form submission
        const form = document.querySelector('form');
        form.addEventListener('submit', function (e) {
            // Get the HTML content from Quill
            const content = quill.root.innerHTML.trim();
            const contentField = document.getElementById('Content');

            // Check if content is empty (only whitespace/empty divs)
            if (!content || content === '<p><br></p>' || content === '<div><br></div>' || content === '') {
                // Content is optional per validation rules, so we can allow empty
                contentField.value = '';
            } else {
                contentField.value = content;
            }
        });
    </script>
@endsection