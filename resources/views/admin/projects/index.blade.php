@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="col-md-4 d-flex justify-content-end">
            <a href="{{ route('admin.projects.trashed') }}" class="btn btn-sm btn-primary me-auto">
                <i class="fa-solid fa-trash"></i>
            </a>
        </div>
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
                    <th scope="col" class="text-center">
                        <a href="{{ route('admin.projects.create') }}" class="btn btn-sm btn-primary">
                            <i class="fa-solid fa-plus"></i>
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($projects as $project)
                    <tr>
                        <td>{{ $project->id }}</td>
                        <td>{{ $project->title }}</td>
                        <td>{{ $project->author }}</td>
                        <td>{{ $project->project_date }}</td>
                        <td class="text-center">
                            <a href="{{ route('admin.projects.show', $project->slug) }}" class="btn btn-sm btn-primary"><i
                                    class="fa-solid fa-eye"></i></a>
                            <a href="{{ route('admin.projects.edit', $project->slug) }}" class="btn btn-sm btn-success"><i
                                    class="fa-solid fa-pen-to-square"></i></a>
                            <form action="{{ route('admin.projects.destroy', $project->slug) }}" method="POST"
                                class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $projects->links() }}
    </div>
@endsection
