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
     * Crop foto profil jadi persegi (1:1) dengan GD sebelum di-resize dan
     * dikonversi ke base64. Ini menggantikan versi lama yang cuma resize
     * proporsional (preserve aspect ratio) tanpa pernah crop ke persegi --
     * itu sebabnya dulu fotonya selalu geser saat dipaksa masuk lingkaran
     * di CSS (dompdf tidak crop-to-square dengan benar via object-fit).
     *
     * $verticalBias: 0.5 = crop benar-benar di tengah (default, paling
     * aman/generik untuk berbagai jenis foto). Ubah ke 0.35-0.4 HANYA
     * kalau kamu sudah cek beberapa sample foto dan memang konsisten
     * wajah agak ke atas -- ini heuristik, bukan face detection asli.
     */
    private function getResizedPhotoBase64(?Profile $profile, float $verticalBias = 0.5): ?string
    {
        if (!$profile || !$profile->photo_path || !Storage::disk('public')->exists($profile->photo_path)) {
            return null;
        }

        $imageData = Storage::disk('public')->get($profile->photo_path);

        if (!extension_loaded('gd')) {
            $mimeType = Storage::disk('public')->mimeType($profile->photo_path) ?: 'image/jpeg';
            return 'data:' . $mimeType . ';base64,' . base64_encode($imageData);
        }

        $sourceImage = @imagecreatefromstring($imageData);

        if (!$sourceImage) {
            $mimeType = Storage::disk('public')->mimeType($profile->photo_path) ?: 'image/jpeg';
            return 'data:' . $mimeType . ';base64,' . base64_encode($imageData);
        }

        $origWidth = imagesx($sourceImage);
        $origHeight = imagesy($sourceImage);

        // 1. Sisi persegi terbesar yang muat di dalam gambar sumber
        $squareSide = min($origWidth, $origHeight);

        // 2. Titik potong: horizontal selalu tengah, vertikal pakai bias
        $srcX = (int) (($origWidth - $squareSide) / 2);
        $srcY = (int) (($origHeight - $squareSide) * $verticalBias);
        $srcY = max(0, min($srcY, $origHeight - $squareSide));

        // 3. Crop ke persegi (masih resolusi asli)
        $cropped = imagecreatetruecolor($squareSide, $squareSide);
        imagecopy($cropped, $sourceImage, 0, 0, $srcX, $srcY, $squareSide, $squareSide);

        // 4. Resize persegi itu ke ukuran final (max 300x300)
        $maxSize = 300;
        $finalSize = min($maxSize, $squareSide);
        $resized = imagecreatetruecolor($finalSize, $finalSize);
        imagecopyresampled(
            $resized, $cropped,
            0, 0, 0, 0,
            $finalSize, $finalSize,
            $squareSide, $squareSide
        );

        ob_start();
        imagejpeg($resized, null, 85);
        $resizedData = ob_get_clean();

        imagedestroy($sourceImage);
        imagedestroy($cropped);
        imagedestroy($resized);

        return 'data:image/jpeg;base64,' . base64_encode($resizedData);
    }
}
