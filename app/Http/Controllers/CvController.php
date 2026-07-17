<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Education;
use App\Models\Project;
use App\Models\Technology;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class CvController extends Controller
{
    public function download()
    {
        $profile = Profile::first();
        $educations = Education::orderBy('order')->get();

        $projects = Project::where('featured', true)->get();
        if ($projects->isEmpty()) {
            $projects = Project::latest()->take(3)->get();
        }

        $technologies = Technology::orderBy('category')
            ->orderBy('order')
            ->get()
            ->groupBy('category');

        // Convert foto profil ke base64 supaya dompdf bisa render
        $photoBase64 = null;
        if ($profile && $profile->photo_path && Storage::disk('public')->exists($profile->photo_path)) {
            $imageData = Storage::disk('public')->get($profile->photo_path);
            $mimeType = Storage::disk('public')->mimeType($profile->photo_path);
            $photoBase64 = 'data:' . $mimeType . ';base64,' . base64_encode($imageData);
        }

        $pdf = Pdf::loadView('cv.template', compact(
            'profile',
            'educations',
            'projects',
            'technologies',
            'photoBase64'
        ))->setPaper('a4', 'portrait');

        $fileName = 'CV_' . str_replace(' ', '_', $profile->name ?? 'CV') . '.pdf';

        return $pdf->download($fileName);
    }
}
