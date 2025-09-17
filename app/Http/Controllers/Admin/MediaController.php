<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaFile;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index()
    {
        $mediaFiles = MediaFile::with('website.user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.media.index', compact('mediaFiles'));
    }

    public function show(MediaFile $mediaFile)
    {
        $mediaFile->load('website.user');
        // TODO: Crear vista admin.media.show
        return view('admin.media.show', compact('mediaFile'));
    }

    public function edit(MediaFile $mediaFile)
    {
        // TODO: Crear vista admin.media.edit
        return view('admin.media.edit', compact('mediaFile'));
    }

    public function update(Request $request, MediaFile $mediaFile)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'alt_text' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
        ]);

        $mediaFile->update([
            'name' => $request->name,
            'alt_text' => $request->alt_text,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.media.index')
            ->with('success', 'Archivo multimedia actualizado exitosamente');
    }

    public function destroy(MediaFile $mediaFile)
    {
        // Eliminar archivo físico si existe
        if ($mediaFile->file_path && file_exists(public_path($mediaFile->file_path))) {
            unlink(public_path($mediaFile->file_path));
        }

        $mediaFile->delete();

        return redirect()->route('admin.media.index')
            ->with('success', 'Archivo multimedia eliminado exitosamente');
    }

    public function toggleStatus(MediaFile $mediaFile)
    {
        $mediaFile->update(['is_active' => !$mediaFile->is_active]);

        $status = $mediaFile->is_active ? 'activado' : 'desactivado';
        return redirect()->route('admin.media.index')
            ->with('success', "Archivo multimedia {$status} exitosamente");
    }

    public function getFileUrl(MediaFile $mediaFile)
    {
        return response()->json([
            'url' => asset($mediaFile->file_path)
        ]);
    }
}
