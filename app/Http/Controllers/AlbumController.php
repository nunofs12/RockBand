<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Band;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AlbumController extends Controller
{
    public function create(Band $band)
    {
        return view('albums.addalbum', compact('band'));
    }

    public function store(Request $request, Band $band)
    {
        $request->validate([
            'album_name' => 'required|string|max:150',
            'release_year' => 'required|integer|between:1900,2100',
            'record_lable' => 'nullable|string|max:150',
            'album_cover' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $cover = null;
        if ($request->hasFile('album_cover')) {
            $cover = $this->saveImage($request->file('album_cover'));
        }

        $band->albums()->create([
            'album_name' => $request->album_name,
            'album_cover' => $cover,
            // A tabela original usa DATE; sem dia/mês fornecido guardamos 01/01.
            'release_date' => $request->release_year.'-01-01',
            'record_lable' => $request->record_lable,
        ]);

        $band->update(['number_of_albuns' => $band->albums()->count()]);

        return redirect()->route('bands.show', $band)->with('message', 'Álbum adicionado com sucesso!');
    }

    public function edit(Album $album)
    {
        $band = $album->band;

        return view('albums.editalbum', compact('album', 'band'));
    }

    public function update(Request $request, Album $album)
    {
        $request->validate([
            'album_name' => 'required|string|max:150',
            'release_year' => 'required|integer|between:1900,2100',
            'record_lable' => 'nullable|string|max:150',
            'album_cover' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $data = [
            'album_name' => $request->album_name,
            'release_date' => $request->release_year.'-01-01',
            'record_lable' => $request->record_lable,
        ];

        if ($request->hasFile('album_cover')) {
            $oldCover = $album->album_cover;
            $data['album_cover'] = $this->saveImage($request->file('album_cover'));
            $this->deleteUploadedImage($oldCover);
        }

        $album->update($data);

        return redirect()->route('bands.show', $album->band_id)->with('message', 'Álbum atualizado com sucesso!');
    }

    public function destroy(Album $album)
    {
        $band = $album->band;
        $this->deleteUploadedImage($album->album_cover);
        $album->delete();
        $band->update(['number_of_albuns' => $band->albums()->count()]);

        if (request()->is('api/*')) {
            return response()->json('Álbum apagado com sucesso!');
        }

        return redirect()->route('bands.show', $band)->with('message', 'Álbum apagado com sucesso!');
    }

    private function saveImage($file): string
    {
        $folder = public_path('images/uploads/albums');
        File::ensureDirectoryExists($folder);
        $filename = Str::uuid().'.'.$file->extension();
        $file->move($folder, $filename);

        return 'images/uploads/albums/'.$filename;
    }

    private function deleteUploadedImage(?string $path): void
    {
        if ($path && str_starts_with($path, 'images/uploads/albums/')) {
            File::delete(public_path($path));
        }
    }
}
