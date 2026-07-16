<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SocialLink;
use App\Models\SoftSkill;
use App\Models\Technology;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        $technologies = Technology::orderBy('order')->get();

        return Inertia::render('Home', [
            'profile' => Profile::first(),
            'educations' => Education::orderBy('order')->get(),
            'techFrontend' => $technologies->where('category', 'frontend')->values(),
            'techBackend' => $technologies->where('category', 'backend')->values(),

            'projects' => Project::orderBy('id')->get()->map(fn ($project) => [
                'title' => $project->title,
                'description' => $project->description,
                'tags' => $project->tags,
                'features' => $project->features,
                'image' => $project->image,
            ]),

            'softSkills' => SoftSkill::orderBy('order')->get(),
            'socialLinks' => SocialLink::orderBy('order')->get(),
        ]);
    }
}
