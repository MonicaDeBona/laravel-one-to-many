@extends('layouts.admin')

@section('content')
    <div class="container">
        <a href="{{ route('admin.projects.trashed') }}" class="btn btn-sm btn-primary">
            Trashed
        </a>
        @if (session('message'))
            <div class="alert alert-{{ session('alert-type') }}">
                {{ session('message') }}
            </div>
        @endif
        <table class="table table-striped table-bordered table-hover mt-5">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#ID</th>
                    <th scope="col">Title</th>
                    <th scope="col">Author</th>
                    <th scope="col">Project date</th>
                    <th scope="col">
                        <a href="{{ route('admin.projects.create') }}" class="btn btn-sm btn-primary">
                            Create new post
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr>
                        <td>
                            {{ $project->id }}
                        </td>
                        <td>
                            {{ $project->title }}
                        </td>
                        <td>
                            {{ $project->author }}
                        </td>
                        <td>
                            {{ $project->project_date }}
                        </td>
                        <td>
                            <a href="{{ route('admin.projects.show', $project->slug) }}"
                                class="btn btn-sm btn-primary">Show</a>
                            <a href="{{ route('admin.projects.edit', $project->slug) }}"
                                class="btn btn-sm btn-success">Edit</a>
                            <form action="{{ route('admin.projects.destroy', $project->slug) }}" method="POST"
                                class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $projects->links() }}
    </div>
@endsection
