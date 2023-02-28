<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    protected $customMessages = [
        'title.required' => 'Title field cannot be empty',
        'content.required' => 'Content field cannot be empty',
        'content.min' => 'Content must be at least :min characters',
        'project_date.required' => 'Please select a project date',
        'project_date.date' => 'Project date must be a valid date',
        'image.required' => 'Choose an image',
        'type.required' => 'Select type'
    ];

    public function validationRules()
    {
        return [
            'title' => 'required|unique:projects',
            'content' => 'required|min:10',
            'project_date' => 'required|date',
            'image' => 'required|image|max:300',
            'type_id' => 'required|exists:types,id'
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::orderBy('project_date', 'DESC')->paginate(15);
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.projects.create', ["project" => new Project(), 'types' => Type::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate($this->validationRules(), $this->customMessages);
        $data['author'] = Auth::user()->name;
        $data['slug'] = Str::slug($data['title']);
        $data['image'] = Storage::put('imgs/', $data['image']);
        $newProject = new Project();
        $newProject->fill($data);
        $newProject->save();

        return redirect()->route('admin.projects.index')->with('message', "Project $newProject->title has been created")->with('alert-type', 'info');
    }

    /**
     * Display the specified resource.
     *
     * @param  Project 
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $previousProject = Project::where('project_date', '>', $project->project_date)->orderBy('project_date')->first();
        $nextProject = Project::where('project_date', '<', $project->project_date)->orderBy('project_date', 'DESC')->first();
        return view('admin.projects.show', compact('project', 'previousProject', 'nextProject'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('admin.projects.edit', ['project' => $project, 'types' => Type::all()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $newRules = $this->validationRules();

        $newRules['title'] = [
            'required', Rule::unique('projects')->ignore($project->id),
        ];

        $data = $request->validate($newRules, $this->customMessages);

        if ($request->hasFile('image')) {
            if (!$project->isImageUrl()) {
                Storage::delete($project->image);
            }

            $data['image'] = Storage::put('imgs/', $data['image']);
        }

        $project->update($data);
        return redirect()->route('admin.projects.index', compact('project'))->with('message', "Project $project->title has been edited")->with('alert-type', 'info');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {

        $project->delete();
        return redirect()->route('admin.projects.index')->with('message', "Project $project->title has been deleted")->with('alert-type', 'danger');
    }

    /**
     * Display a listing of trashed resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {

        $projects = Project::onlyTrashed()->get();
        return view('admin.projects.trashed', compact('projects'));
    }

    /**
     *  Restore project data
     * 
     * @param Project $project
     * 
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        Project::where('id', $id)->withTrashed()->restore();
        return redirect()->route('admin.projects.index')->with('message', "Restored successfully")->with('alert-type', 'success');
    }

    /**
     * Force delete book data
     * 
     * @param Book $book
     * 
     * @return \Illuminate\Http\Response
     */
    public function forceDelete(Project $project)
    {
        if (!$project->isImageUrl()) {
            Storage::delete($project->image);
        }

        $project->forceDelete();
        return redirect()->route('admin.projects.index')->with('message', "Project has been deleted permanently")->with('alert-type', 'success');
    }
}
