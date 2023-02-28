@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="card-header py-5">
            <div class="row">
                <div class="col-6">
                    <h2>Recycled bin</h2>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-condensed table-striped">
                <thead>
                    <tr>
                        <th scope="col">#ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Author</th>
                        <th scope="col">Project date</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($projects as $project)
                        <tr>
                            <th>{{ $project->id }}</th>
                            <td>{{ $project->title }}</td>
                            <td>{{ $project->author }}</td>
                            <td>{{ $project->project_date }}</td>
                            <td class="text-end">
                                <form class="d-inline" action="{{ route('admin.projects.restore', $project->id) }}"
                                    method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success" title="restore">Restore</button>
                                </form>
                                <form class="d-inline" action="{{ route('admin.projects.force-delete', $project->slug) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="delete">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <h2>
                            No items
                        </h2>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
