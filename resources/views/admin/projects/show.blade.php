@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="card mb-3 mt-5 shadow-lg">
            <div class="card-header text-center">
                <h3 class="card-title">{{ $project->title }}</h3>
            </div>
            <div class="card-body d-flex flex-column justify-content-center align-items-center">
                <div class="card-image py-4">
                    @if ($project->isImageUrl())
                        <img src="{{ $project->image }}" alt="{{ $project->title }}" alt="{{ $project->title }}"
                            class="img-fluid">
                    @else
                        <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}" class="img-fluid">
                    @endif
                </div>
                <p class="card-text text-center fw-bold">{{ $project->content }}</p>
                <ul class="list-unstyled text-center mb-4">
                    <li class="text-muted"> {{ $project->slug }}</li>
                    <li class="text-muted">Type: {{ $project->type->name }}</li>
                    <li class="text-muted">Author: {{ $project->author }}</li>
                    <li class="text-muted">Posted on: {{ $project->project_date }}</li>
                </ul>
                <div class="actions d-flex justify-content-between w-100">
                    @if (isset($previousProject))
                        <a href="{{ route('admin.projects.show', $previousProject->slug) }}" class="btn btn-primary"><i
                                class="fa-solid fa-arrow-left"></i></a>
                    @else
                        <a href="" class="btn btn-primary disabled"><i class="fa-solid fa-arrow-left"></i></a>
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
                        <a href="{{ route('admin.projects.show', $nextProject->slug) }}" class="btn btn-primary"><i
                                class="fa-solid fa-arrow-right"></i></a>
                    @else
                        <a href="" class="btn btn-primary disabled"><i class="fa-solid fa-arrow-right"></i></a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
