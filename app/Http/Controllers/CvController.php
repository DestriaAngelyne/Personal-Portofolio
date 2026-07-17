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

        $photoBase64 = $this->getResizedPhotoBase64($profile);

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

    /**
     * Resize foto profil ke ukuran kecil (max 300x300) sebelum di-convert
     * ke base64. Ini penting untuk mencegah bug dompdf yang menghasilkan
     * halaman kosong ekstra ketika gambar sumber beresolusi besar.
     */
    private function getResizedPhotoBase64(?Profile $profile): ?string
    {
        if (!$profile || !$profile->photo_path || !Storage::disk('public')->exists($profile->photo_path)) {
            return null;
        }

        $imageData = Storage::disk('public')->get($profile->photo_path);
        $sourceImage = @imagecreatefromstring($imageData);

        if (!$sourceImage) {
            // Fallback: kalau gagal diproses GD, pakai gambar asli apa adanya
            $mimeType = Storage::disk('public')->mimeType($profile->photo_path);
            return 'data:' . $mimeType . ';base64,' . base64_encode($imageData);
        }

        $maxSize = 300;
        $origWidth = imagesx($sourceImage);
        $origHeight = imagesy($sourceImage);

        $ratio = min($maxSize / $origWidth, $maxSize / $origHeight, 1);
        $newWidth = (int) ($origWidth * $ratio);
        $newHeight = (int) ($origHeight * $ratio);

        $resized = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($resized, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

        ob_start();
        imagejpeg($resized, null, 85);
        $resizedData = ob_get_clean();

        imagedestroy($sourceImage);
        imagedestroy($resized);

        return 'data:image/jpeg;base64,' . base64_encode($resizedData);
    }
}
