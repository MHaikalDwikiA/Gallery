@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="mb-5 justify-content-end">
            <a href="{{ route('photo.create') }}" class="btn btn-primary rounded-5">
                <i class="fa fa-plus"></i> Tambah Foto Baru
            </a>
        </div>

        <x-alert />

        <div class="row">
            @foreach ($photos as $photo)
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3>{{ $photo->title }}</h3>
                            <div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('photo.edit', $photo->id) }}">Edit</a></li>
                                    <li>
                                        <form action="{{ route('photo.destroy', $photo->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item">
                                                Hapus
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            {{ $photo->description }}
                        </div>
                        <div>
                            <img src="{{ asset('storage/' . $photo->path) }}" draggable="false"
                                class="object-fit-cover img-fluid">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
