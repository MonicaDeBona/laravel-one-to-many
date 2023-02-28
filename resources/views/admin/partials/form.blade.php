<form action="{{ route($routeName, $project) }}" enctype="multipart/form-data" method="POST" class="p-5 needs-validation"
    novalidate>
    @csrf
    @method($method)
    @if ($errors->any())
        <div class="alert alert-danger">
            <h6>We were unable to process your submission due to errors. Please review and try again.</h6>
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            <h2 class="text-center mb-2">Create new project</h2>
        </div>
        <div class="card-body">
            <h5 class="mb-4">
                Author: <span class="fw-semibold">{{ Auth::user()->name }} </span>
            </h5>
            <div class="form-outline mb-3">
                <label for="project_type" class="form-label">Project type</label>
                <select class="form-control @error('type_id') is-invalid @enderror" id="project_type" name="type_id">
                    <option value="">-- Select project type --</option>
                    @foreach ($types as $type)
                        <option value="{{ $type->id }}"
                            {{ old('type_id', $project->type_id) == $type->id ? 'selected' : '' }}>{{ $type->name }}
                        </option>
                    @endforeach
                </select>
                @error('type_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-outline w-25 mb-3">
                <label for="project_title" class="form-label">Project title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                    placeholder="Insert project's title" name="title" value="{{ old('title', $project->title) }}"
                    required>
                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-outline w-25 mb-3">
                <label for="project_image" class="form-label">Project image</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                    placeholder="Insert project's image" name="image" value="{{ old('image', $project->image) }}"
                    required>
                @error('image')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3 w-25">
                <label for="project_date" class="form-label">Project date</label>
                <input type="date" class="form-control @error('project_date') is-invalid @enderror" id="project_date"
                    name="project_date" value="{{ old('project_date', $project->project_date) }}">
                @error('project_date')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="form-outline mb-3">
                <label for="project_content" class="form-label">Project content</label>
                <textarea class="form-control @error('content') is-invalid @enderror" minlength="10" id="project_content" rows="10"
                    name="content">{{ old('content', $project->content) }}</textarea>
                @error('content')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.projects.index') }}" class="btn btn-dark"><i
                    class="fa-solid fa-arrow-left"></i></a>
            <button type="submit" class="btn btn-success"><i class="fa-solid fa-save"></i></button>
        </div>
    </div>
</form>
