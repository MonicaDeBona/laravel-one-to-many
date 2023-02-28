@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="card mb-3 mt-5">
            <div class="card-header text-center">
                <h5 class="card-title">{{ $project->title }}</h5>
            </div>
            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                <div class="card-image">
                    @if ($project->isImageUrl())
                        <img src="{{ $project->image }}" alt="{{ $project->title }}" class="img-fluid">
                    @else
                        <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}" class="img-fluid">
                    @endif
                </div>
                <p class="card-text text-center">{{ $project->content }}</p>
                <hr>
                <p class="card-text text-center">
                    <small class="text-muted">{{ $project->slug }}</small><br>
                    <small class="text-muted">Type: {{ $project->type->name }}</small><br>
                    <small class="text-muted">Author: {{ $project->author }}</small><br>
                    <small class="text-muted">Posted on: {{ $project->project_date }}</small>

                </p>
                <div class="actions d-flex justify-content-between w-100">
                    @if (isset($previousProject))
                        <a href="{{ route('admin.projects.show', $previousProject->slug) }}"
                            class="btn btn-primary">Previous</a>
                    @else
                        <a href="" class="btn btn-primary disabled">Previous</a>
                    @endif
                    <div class="main-actions">
                        <a href="{{ route('admin.projects.edit', $project->slug) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('admin.projects.destroy', $project->slug) }}" method="POST"
                            class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-md btn-danger">Delete</button>
                        </form>
                    </div>
                    @if (isset($nextProject))
                        <a href="{{ route('admin.projects.show', $nextProject->slug) }}" class="btn btn-primary">Next</a>
                    @else
                        <a href="" class="btn btn-primary disabled">Next</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
