<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $photos = Photo::all();
        return view('page.photo.index', compact('photos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $albums = Auth::user()->albums;

        return view('page.photo.create', compact('albums'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'album_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'path' => 'required|image|mimes:jpeg,png,jpg,gif',
        ], [
            'album_id.required' => 'Album harus dipilih!',
            'title.required' => 'Judul harus diisi!',
            'description.required' => 'Deskripsi harus diisi!',
            'path.required' => 'Dokumen harus diisi!',
            'path.image' => 'File harus berupa gambar',
            'path.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
        ]);

        $photo = new Photo();
        $photo->user_id = Auth::user()->id;
        $photo->album_id = $request->album_id;
        $photo->title = $request->title;
        $photo->description = $request->description;

        if ($request->hasFile('path')) {
            $imagePath = Storage::disk('public')->put('images/', $request->file('path'));

            if (!Storage::disk('public')->exists($imagePath)) {
                return back()->withInput()->withError('Gagal menyimpan foto, silahkan coba kembali!');
            }

            $photo->path = $imagePath;
        }

        $photo->save();

        return redirect()->route('home');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $photo = Photo::find($id);
        abort_if(!$photo, 400, 'Foto tidak ditemukan!');

        $albums = auth()->user()->albums;

        return view('page.photo.edit', compact('photo', 'albums'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $photo = Photo::find($id);
        abort_if(!$photo, 400, 'Foto tidak ditemukan!');

        $request->validate([
            'album_id' => 'required',
            'title' => 'required',
            'description' => 'required',
        ], [
            'album_id.required' => 'Album harus dipilih!',
            'title.required' => 'Judul harus diisi!',
            'description.required' => 'Deskripsi harus diisi!',
            'path.required' => 'Dokumen harus diisi!',
            'path.image' => 'File harus berupa gambar',
            'path.mimes' => 'Format gambar harus jpeg, png, jpg, atau gif',
        ]);

        $photo->user_id = Auth::user()->id;
        $photo->album_id = $request->album_id;
        $photo->title = $request->title;
        $photo->description = $request->description;

        $photo->save();

        return redirect()->route('home');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $photo = Photo::find($id);
        abort_if(!$photo, 400, 'Foto tidak ditemukan!');

        $photo->delete();

        return redirect()->route('home');
    }
}
