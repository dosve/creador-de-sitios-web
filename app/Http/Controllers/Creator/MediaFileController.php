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
    
    public function index(Request $request)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('view', $website);
        
        $mediaFiles = $website->mediaFiles()->latest()->get();
        
        return view('creator.media.index', compact('mediaFiles', 'website'));
    }

    public function store(Request $request)
    {
        try {
            $website = Website::find(session('selected_website_id'));
            
            if (!$website) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se ha seleccionado ningún sitio web'
                ], 403);
            }
            
            $this->authorize('update', $website);
            
            // Validar que haya archivos
            if (!$request->hasFile('files')) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se han seleccionado archivos para subir'
                ], 422);
            }
            
            $request->validate([
                'files' => 'required|array',
                'files.*' => 'required|file|max:10240', // 10MB max
            ]);

            $uploadedFiles = [];

            foreach ($request->file('files') as $file) {
                // Guardar el archivo
                $path = $file->store('media/' . $website->id, 'public');
                
                if (!$path) {
                    throw new \Exception('Error al guardar el archivo en el servidor');
                }
                
                // Determinar el tipo de archivo
                $mimeType = $file->getMimeType();
                $fileType = 'other';
                if (str_starts_with($mimeType, 'image/')) {
                    $fileType = 'image';
                } elseif (str_starts_with($mimeType, 'video/')) {
                    $fileType = 'video';
                } elseif (str_starts_with($mimeType, 'audio/')) {
                    $fileType = 'audio';
                } elseif (in_array($mimeType, ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])) {
                    $fileType = 'document';
                }
                
                // Crear el registro en la base de datos
                $mediaFile = $website->mediaFiles()->create([
                    'original_name' => $file->getClientOriginalName(),
                    'filename' => $file->getClientOriginalName(),
                    'file_path' => $path,
                    'file_url' => url('storage/' . $path),
                    'file_size' => $file->getSize(),
                    'mime_type' => $mimeType,
                    'file_type' => $fileType,
                    'alt_text' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                ]);

                $uploadedFiles[] = $mediaFile;
            }

            return response()->json([
                'success' => true,
                'message' => 'Archivos subidos exitosamente',
                'files' => $uploadedFiles
            ]);
            
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'No tienes permisos para realizar esta acción'
            ], 403);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación: ' . implode(', ', $e->validator->errors()->all())
            ], 422);
            
        } catch (\Exception $e) {
            \Log::error('Error al subir archivos multimedia', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'website_id' => session('selected_website_id')
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Error al subir archivos: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Request $request, MediaFile $mediaFile)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return redirect()->route('creator.select-website');
        }
        
        $this->authorize('update', $website);
        
        // Delete file from storage
        Storage::disk('public')->delete($mediaFile->file_path);
        
        // Delete record from database
        $mediaFile->delete();

        return redirect()->route('creator.media.index')
            ->with('success', 'Archivo eliminado exitosamente');
    }

    public function getFileUrl(Request $request, MediaFile $mediaFile)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return response()->json(['error' => 'No website selected'], 403);
        }
        
        $this->authorize('view', $website);
        
        return response()->json([
            'url' => Storage::disk('public')->url($mediaFile->file_path)
        ]);
    }

    public function apiList(Request $request)
    {
        $website = Website::find(session('selected_website_id'));
        
        if (!$website) {
            return response()->json(['error' => 'No website selected'], 403);
        }
        
        $this->authorize('view', $website);
        
        $mediaFiles = $website->mediaFiles()
            ->where('file_type', 'image')
            ->latest()
            ->get()
            ->map(function($file) {
                return [
                    'id' => $file->id,
                    'filename' => $file->filename,
                    'url' => $file->file_url,
                    'alt_text' => $file->alt_text,
                ];
            });
        
        return response()->json([
            'success' => true,
            'files' => $mediaFiles
        ]);
    }
}
