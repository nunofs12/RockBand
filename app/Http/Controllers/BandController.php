<?php

namespace App\Http\Controllers;

use App\Models\Band;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BandController extends Controller
{
    // Listar todas as bandas e contar os álbuns através da relação.
    public function index()
    {
        $bands = Band::withCount('albums')->orderBy('name_of_band')->get();

        return view('bands.allbands', compact('bands'));
    }

    // Abrir a tabela de álbuns da banda escolhida.
    public function show(Band $band)
    {
        $band->load(['albums' => fn ($query) => $query->orderBy('release_date')]);

        return view('bands.showband', compact('band'));
    }

    public function create()
    {
        return view('bands.addband');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_of_band' => 'required|string|max:100|unique:bands,name_of_band',
            'photo_of_band' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $photo = null;
        if ($request->hasFile('photo_of_band')) {
            $photo = $this->saveImage($request->file('photo_of_band'));
        }

        Band::create([
            'name_of_band' => $request->name_of_band,
            'photo_of_band' => $photo,
            'number_of_albuns' => 0,
        ]);

        return redirect()->route('bands.all')->with('message', 'Banda adicionada com sucesso!');
    }

    public function edit(Band $band)
    {
        return view('bands.editband', compact('band'));
    }

    public function update(Request $request, Band $band)
    {
        $request->validate([
            'name_of_band' => 'required|string|max:100|unique:bands,name_of_band,'.$band->id,
            'photo_of_band' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $data = ['name_of_band' => $request->name_of_band];

        if ($request->hasFile('photo_of_band')) {
            $oldPhoto = $band->photo_of_band;
            $data['photo_of_band'] = $this->saveImage($request->file('photo_of_band'));
            $this->deleteUploadedImage($oldPhoto);
        }

        $band->update($data);

        return redirect()->route('bands.all')->with('message', 'Banda atualizada com sucesso!');
    }

    public function destroy(Band $band)
    {
        // Apagar os álbuns primeiro, para funcionar também com a migração original.
        foreach ($band->albums as $album) {
            $this->deleteUploadedImage($album->album_cover, 'albums');
            $album->delete();
        }

        $this->deleteUploadedImage($band->photo_of_band);
        $band->delete();

        if (request()->is('api/*')) {
            return response()->json('Banda apagada com sucesso!');
        }

        return redirect()->route('bands.all')->with('message', 'Banda apagada com sucesso!');
    }

    private function saveImage($file): string
    {
        $folder = public_path('images/uploads/bands');
        File::ensureDirectoryExists($folder);
        $filename = Str::uuid().'.'.$file->extension();
        $file->move($folder, $filename);

        return 'images/uploads/bands/'.$filename;
    }

    private function deleteUploadedImage(?string $path, string $type = 'bands'): void
    {
        // Não apagar as imagens originais incluídas no projeto.
        if ($path && str_starts_with($path, 'images/uploads/'.$type.'/')) {
            File::delete(public_path($path));
        }
    }
}
