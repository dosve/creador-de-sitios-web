<?php

namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Website;
use App\Models\MediaFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MediaFileController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request, Website $website)
    {
        $this->authorize('view', $website);
        
        $mediaFiles = $website->mediaFiles()->latest()->get();
        
        return view('creator.media.index', compact('website', 'mediaFiles'));
    }

    public function store(Request $request, Website $website)
    {
        $this->authorize('update', $website);
        
        $request->validate([
            'files.*' => 'required|file|max:10240', // 10MB max
        ]);

        $uploadedFiles = [];

        foreach ($request->file('files') as $file) {
            $path = $file->store('media/' . $website->id, 'public');
            
            $mediaFile = $website->mediaFiles()->create([
                'filename' => $file->getClientOriginalName(),
                'file_path' => $path,
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'alt_text' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
            ]);

            $uploadedFiles[] = $mediaFile;
        }

        return response()->json([
            'success' => true,
            'message' => 'Archivos subidos exitosamente',
            'files' => $uploadedFiles
        ]);
    }

    public function destroy(Request $request, Website $website, MediaFile $mediaFile)
    {
        $this->authorize('update', $website);
        
        // Delete file from storage
        Storage::disk('public')->delete($mediaFile->file_path);
        
        // Delete record from database
        $mediaFile->delete();

        return redirect()->route('creator.media.index', $website)
            ->with('success', 'Archivo eliminado exitosamente');
    }

    public function getFileUrl(Request $request, Website $website, MediaFile $mediaFile)
    {
        $this->authorize('view', $website);
        
        return response()->json([
            'url' => Storage::disk('public')->url($mediaFile->file_path)
        ]);
    }
}
