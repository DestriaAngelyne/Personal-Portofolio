<?php
namespace App\Http\Controllers;
use App\Models\Education;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SocialLink;
use App\Models\SoftSkill;
use App\Models\Technology;
use Inertia\Inertia;
class ProjectController extends Controller
{
    public function index()
    {
        // 1. Mengambil seluruh data proyek dari database MySQL menggunakan Eloquent ORM
        $projects = Project::all()->map(fn ($project) => [
            'title' => $project->title,
            'description' => $project->description,
            // Kolom 'tags' dikirim apa adanya (nama field ini yang
            // dipakai Home.vue lewat v-for="tech in project.tags").
            'tags' => $project->tags,
            'features' => $project->features,
            // 'image' dikirim supaya Home.vue bisa menampilkan
            // screenshot proyek (fallback icon monitor kalau kosong).
            'image' => $project->image,
        ]);
        // 2. Mengambil data teknologi, lalu dipisah 2 kelompok
        //    sesuai baris marquee di Home.vue (frontend & backend/tools)
        $technologies = Technology::orderBy('order')->get();
        // 3. Mengirim semua data ke komponen Vue 'Home' sebagai 'props'
        return Inertia::render('Home', [
            'projects' => $projects,
            'profile' => Profile::first(),
            'educations' => Education::orderBy('order')->get(),
            'techFrontend' => $technologies->where('category', 'frontend')->values(),
            'techBackend' => $technologies->where('category', 'backend')->values(),
            'softSkills' => SoftSkill::orderBy('order')->get(),
            'socialLinks' => SocialLink::orderBy('order')->get(),
        ]);
    }
}
