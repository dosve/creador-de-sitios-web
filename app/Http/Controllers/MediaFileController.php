<?php

namespace App\Http\Controllers;

use App\Models\Website;
use App\Models\MediaFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class MediaFileController extends Controller
{
    public function index(Website $website)
    {
        $this->authorize('view', $website);
        
        $fileType = request('type', 'all');
        $search = request('search');
        
        $query = $website->mediaFiles()->latest();
        
        if ($fileType !== 'all') {
            $query->where('file_type', $fileType);
        }
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('original_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $mediaFiles = $query->paginate(20);
        
        $stats = [
            'total' => $website->mediaFiles()->count(),
            'images' => $website->mediaFiles()->images()->count(),
            'documents' => $website->mediaFiles()->documents()->count(),
            'videos' => $website->mediaFiles()->videos()->count(),
            'audios' => $website->mediaFiles()->audios()->count(),
        ];
        
        return view('creator.media.index', compact('website', 'mediaFiles', 'stats', 'fileType', 'search'));
    }

    public function store(Request $request, Website $website)
    {
        $this->authorize('update', $website);
        
        $request->validate([
            'files.*' => 'required|file|max:10240', // 10MB máximo
            'alt_text' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $uploadedFiles = [];
        
        foreach ($request->file('files') as $file) {
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $filename = Str::uuid() . '.' . $extension;
            $fileType = $this->getFileType($file->getMimeType());
            
            // Crear directorio por tipo de archivo
            $directory = "websites/{$website->id}/{$fileType}";
            $filePath = $file->storeAs($directory, $filename, 'public');
            
            $mediaData = [
                'website_id' => $website->id,
                'original_name' => $originalName,
                'filename' => $filename,
                'file_path' => $filePath,
                'file_url' => Storage::url($filePath),
                'mime_type' => $file->getMimeType(),
                'file_type' => $fileType,
                'file_size' => $file->getSize(),
                'alt_text' => $request->alt_text,
                'description' => $request->description,
                'is_public' => true,
            ];
            
            // Para imágenes, obtener dimensiones
            if ($fileType === 'image') {
                try {
                    $image = Image::make($file);
                    $mediaData['width'] = $image->width();
                    $mediaData['height'] = $image->height();
                } catch (\Exception $e) {
                    // Si no se puede procesar la imagen, continuar sin dimensiones
                }
            }
            
            $mediaFile = MediaFile::create($mediaData);
            $uploadedFiles[] = $mediaFile;
        }
        
        return response()->json([
            'success' => true,
            'message' => count($uploadedFiles) . ' archivo(s) subido(s) exitosamente',
            'files' => $uploadedFiles
        ]);
    }

    public function show(Website $website, MediaFile $mediaFile)
    {
        $this->authorize('view', $website);
        $this->authorize('view', $mediaFile);
        
        return view('creator.media.show', compact('website', 'mediaFile'));
    }

    public function update(Request $request, Website $website, MediaFile $mediaFile)
    {
        $this->authorize('update', $website);
        $this->authorize('update', $mediaFile);
        
        $request->validate([
            'alt_text' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'is_public' => 'boolean',
        ]);
        
        $mediaFile->update([
            'alt_text' => $request->alt_text,
            'description' => $request->description,
            'is_public' => $request->boolean('is_public'),
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Archivo actualizado exitosamente'
        ]);
    }

    public function destroy(Website $website, MediaFile $mediaFile)
    {
        $this->authorize('update', $website);
        $this->authorize('delete', $mediaFile);
        
        $mediaFile->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Archivo eliminado exitosamente'
        ]);
    }

    public function getFileUrl(Website $website, MediaFile $mediaFile)
    {
        $this->authorize('view', $website);
        $this->authorize('view', $mediaFile);
        
        return response()->json([
            'url' => $mediaFile->file_url,
            'filename' => $mediaFile->original_name
        ]);
    }

    private function getFileType($mimeType)
    {
        $imageTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];
        $videoTypes = ['video/mp4', 'video/webm', 'video/ogg', 'video/avi', 'video/mov'];
        $audioTypes = ['audio/mp3', 'audio/wav', 'audio/ogg', 'audio/mpeg'];
        $documentTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'text/plain',
            'text/csv'
        ];
        
        if (in_array($mimeType, $imageTypes)) {
            return 'image';
        } elseif (in_array($mimeType, $videoTypes)) {
            return 'video';
        } elseif (in_array($mimeType, $audioTypes)) {
            return 'audio';
        } elseif (in_array($mimeType, $documentTypes)) {
            return 'document';
        } else {
            return 'other';
        }
    }
}
