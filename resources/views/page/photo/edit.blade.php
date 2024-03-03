@extends('layouts.app')

@section('content')
    <div class="container">

        <x-alert />

        <div class="card mt-auto">
            <div class="card-body">
                <form action="{{ route('photo.update', $photo->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Pilih Album</label>
                        <select name="album_id" class="form-control">
                            @if ($albums->isEmpty())
                                <option disabled selected>Anda belum memiliki album</option>
                            @else
                                @foreach ($albums as $album)
                                    <option value="{{ $album->id }}"
                                        {{ old('album_id', $photo->album_id) == $album->id ? 'selected' : '' }}>
                                        {{ $album->title }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('album_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Judul</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                            value="{{ old('title', $photo->title) }}">
                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="description" cols="5" rows="5"
                            class="form-control @error('description') is-invalid @enderror">{{ old('description', $photo->description) }}</textarea>
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="card-footer text-end">
                        <a class="btn btn-secondary" href="{{ route('home') }}">Kembali</a>
                        <button class="btn btn-primary" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
