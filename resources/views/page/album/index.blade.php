@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="mb-5 justify-content-end">
            <a href="{{ route('album.create') }}" class="btn btn-primary rounded-5">
                <i class="fa fa-plus"></i> Tambah Album Baru
            </a>
        </div>

        <x-alert />

        <div class="row">
            @foreach ($albums as $album)
                <div class="col-md-6">
                    <div class="card mb-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h3>{{ $album->title }}</h3>
                            <div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                    aria-expanded="false"></button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('album.edit', $album->id) }}">Edit</a></li>
                                    <li>
                                        <form action="{{ route('album.destroy', $album->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item">Hapus</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="card-body">
                            <div id="carouselExampleAutoplaying{{ $album->id }}" class="carousel slide"
                                data-bs-ride="carousel" data-bs-interval="5000">
                                <div class="carousel-inner">
                                    @if ($album->photo()->exists())
                                        @foreach ($album->photo as $photo)
                                            <div class="carousel-item @if ($loop->first) active @endif">
                                                <img src="{{ asset('storage/' . $photo->path) }}" draggable="false"
                                                    class="object-fit-cover img-fluid">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <button class="carousel-control-prev" type="button"
                                    data-bs-target="#carouselExampleAutoplaying{{ $album->id }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button"
                                    data-bs-target="#carouselExampleAutoplaying{{ $album->id }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                        <div class="card-footer">
                            {{ $album->description }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


    </div>
@endsection
