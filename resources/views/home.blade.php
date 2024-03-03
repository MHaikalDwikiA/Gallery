@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            @auth
                <div class="mb-3">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        {{ 'Selamat Datang ' . auth()->user()->name . ' !!' }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endauth

            <x-alert />

            @auth
                <div class="mb-3">
                    <a href="{{ route('photo.create') }}" class="btn btn-primary rounded-5">
                        <i class="fa fa-plus"></i> Unggah Foto
                    </a>
                </div>
            @endauth

            @if (!$photos || $photos->isEmpty())
                <h3 class="d-flex justify-content-center align-items-center vh-100">Foto Tidak Ada</h3>
            @else
                @foreach ($photos as $photo)
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <p class="fw-bold">{{ $photo->user->name }} <span>
                                            <small>{{ $photo->created_at->diffForHumans() }}</small></span>
                                        <br>
                                        <small>{{ \Carbon\Carbon::parse($photo->created_at)->format('d F Y') }}</small>
                                    </p>
                                </div>

                                @if ($photo->user_id == auth()->id())
                                    <div class="dropdown">
                                        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item"
                                                    href="{{ route('photo.edit', $photo->id) }}">Edit</a>
                                            </li>
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
                                @endif
                            </div>

                            <div class="card-body">
                                <a href="{{ asset('storage/' . $photo->path) }}" target="_blank"><img
                                        src="{{ asset('storage/' . $photo->path) }}" draggable="false"
                                        class="object-fit-cover img-fluid" style="height: 400px; width: 100%"></a>
                                <hr class="my-3">
                                <h5 class="card-title mt-3">{{ $photo->title }}</h5>
                                <p class="card-text">{{ $photo->description }}</p>
                            </div>

                            <div class="card-footer">
                                @auth
                                    <div class="d-flex">
                                        <form action="{{ route('like.like', $photo->id) }}" method="post">
                                            @csrf
                                            <button type="submit" class="btn">
                                                <i class="fa fa-heart"></i> {{ $photo->likes->count() }} Disukai
                                            </button>
                                        </form>
                                        <button class="btn" data-bs-toggle="collapse"
                                            data-bs-target="#commentSection{{ $photo->id }}" aria-expanded="false"
                                            aria-controls="commentSection{{ $photo->id }}">
                                            <i class="fa fa-comment"></i> {{ $photo->comments->count() }} Komentar
                                        </button>
                                    </div>
                                @else
                                    <div class="d-flex">
                                        <a href="{{ route('login') }}" class="btn">
                                            <i class="fa fa-heart"></i> {{ $photo->likes->count() }} Disukai
                                        </a>
                                        <a href="{{ route('login') }}" class="btn">
                                            <i class="fa fa-comment"></i> {{ $photo->comments->count() }} Komentar
                                        </a>
                                    </div>
                                @endauth
                            </div>

                            <div class="collapse" id="commentSection{{ $photo->id }}">
                                <div class="card-body">
                                    <form action="{{ route('comment.store', $photo->id) }}" method="post">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Tambah Komentar</label>
                                            <textarea class="form-control" id="description" name="description"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Kirim</button>
                                    </form>

                                    <div class="mt-2">
                                        <div class="card-body">
                                            @foreach ($photo->comments as $comment)
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h5>{{ $comment->user->name }} <span
                                                                style="font-size: 15px;">({{ \Carbon\Carbon::parse($comment->created_at)->format('d-m-Y') }})</span>
                                                        </h5>
                                                        <p>"{{ $comment->description }}"</p>
                                                    </div>
                                                    <div class="ml-auto">
                                                        @if ($photo->user_id == auth()->id() || $comment->user_id == auth()->id())
                                                            <form action="{{ route('comment.destroy', $comment->id) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm">
                                                                    Delete
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                                <hr>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
    </div>
@endsection
