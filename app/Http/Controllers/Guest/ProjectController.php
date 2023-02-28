<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('project_date', 'DESC')->paginate(15);
        return view('guest.projects.index', compact('projects'));
    }
}
