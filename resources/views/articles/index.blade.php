@extends('layout.app')

@section('title', 'Articles')

@section('content')
<div class="container mt-5">
    <!-- Error Alerts -->
    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Page Title and Create Button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">Articles</h1>
        @if(auth()->check())
        <a href="#" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#postArticleModal">Create New
            Article</a>
        @endif
    </div>

    <!-- Articles Grid -->
    <div class="row">
        @forelse($articles as $article)
        <div class="col-md-4 mb-4 d-flex">
            <div class="card shadow-sm flex-fill">
                <div class="card-body">
                    <h5 class="card-title">{{ $article->title }}</h5>
                    <p class="card-text text-muted">{{ Str::limit($article->content, 100) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <a href="#" class="btn btn-info btn-sm me-2" data-bs-toggle="modal"
                                data-bs-target="#viewArticleModal-{{ $article->id }}">View</a>
                            @if(auth()->check())
                            <a href="#" class="btn btn-warning btn-sm me-2" data-bs-toggle="modal"
                                data-bs-target="#editArticleModal-{{ $article->id }}">Edit</a>
                            @endif

                        </div>
                        @if(auth()->check())
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                            data-bs-target="#deleteArticleModal-{{ $article->id }}">Delete</button>
                        @endif
                    </div>
                </div>
                <div class="card-footer text-muted">
                    Posted by {{ $article->author }} on {{ $article->created_at->format('F d, Y') }}
                </div>
            </div>
        </div>

        <!-- View Article Modal -->
        <div class="modal fade" id="viewArticleModal-{{ $article->id }}" tabindex="-1"
            aria-labelledby="viewArticleModalLabel-{{ $article->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-break" id="viewArticleModalLabel-{{ $article->id }}">{{ $article->title }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-break">{{ $article->content }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit article modal -->
        <div class="modal fade" id="editArticleModal-{{ $article->id }}" tabindex="-1"
            aria-labelledby="editArticleModalLabel-{{ $article->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-break" id="editArticleModalLabel-{{ $article->id }}">Edit Article:
                            {{ $article->title }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('articles.update', $article->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="title-{{ $article->id }}" class="form-label">Title</label>
                                <input type="text" class="form-control" id="title-{{ $article->id }}" name="title"
                                    value="{{ $article->title }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="content-{{ $article->id }}" class="form-label">Content</label>
                                <textarea class="form-control" id="content-{{ $article->id }}" name="content" rows="5"
                                    required>{{ $article->content }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="author-{{ $article->id }}" class="form-label">Author</label>
                                <input type="text" class="form-control" id="author-{{ $article->id }}" name="author"
                                    value="{{ $article->author }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Article</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Article Modal -->
        <div class="modal fade" id="deleteArticleModal-{{ $article->id }}" tabindex="-1"
            aria-labelledby="deleteArticleModalLabel-{{ $article->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-break" id="deleteArticleModalLabel-{{ $article->id }}">Delete Article</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this article titled "{{ $article->title }}"?
                    </div>
                    <div class="modal-footer">
                        <form action="{{ route('articles.destroy', $article->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="alert alert-info" role="alert">
            No articles found. Click "Create New Article" to add one!
        </div>
        @endforelse
    </div>

    <!-- Pagination Links -->
    <div class="d-flex justify-content-center mt-4">
        {{ $articles->links('pagination.pagination') }}
    </div>

    <!-- Include the Article Modal for Creating Articles -->
    <x-article-modal />

</div>
@endsection