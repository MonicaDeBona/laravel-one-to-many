@extends('layouts.admin')

@section('content')
    <div class="container">
        @include('admin.partials.form', ['method' => 'PUT', 'routeName' => 'admin.projects.update'])
    </div>
@endsection
