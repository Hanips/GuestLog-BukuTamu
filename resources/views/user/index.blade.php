@extends('adminpage.index')

@section('title_page', 'Manajemen Pengguna')

@section('content')
@if (Auth::user()->role != 'Pengguna' && Auth::user()->role != 'Satpam')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Manajemen Pengguna</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ url('/admin') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Manajemen Pengguna</div>
                </div>
            </div>
            <div class="section-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h2 class="section-title">Manajemen Pengguna</h2>
                        <p class="section-lead">Buat dan ubah data pengguna</p>
                    </div>
                    <div>
                        <a href="{{ route('user.create') }}" class="btn btn-primary mr-2">{{ __('+ Tambah Data') }}</a>
                        <a href="{{ route('user.excel') }}" class="btn btn-success"><i class="fas fa-file mx-1"></i> Export Pengguna</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Tabel Pengguna</h4>
                                <div class="card-header-form">
                                    <form action="{{ route('user.index') }}" method="GET">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control" placeholder="Search" value="{{ request('search') }}">
                                            <div class="input-group-btn">
                                                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                        @if ($ar_user->isEmpty())
                                            <tr>
                                                <td colspan="5" class="text-center">Belum ada data pengguna</td>
                                            </tr>
                                        @else
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach($ar_user as $user)
                                                <tr>
                                                    <td class="p-0 text-center">{{ $no }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>
                                                        @if ($user->role == 'Administrator' || $user->role == 'Staff')
                                                            <div class="badge badge-success">{{ $user->role }}</div>
                                                        @elseif ($user->role == 'Satpam')
                                                            <div class="badge badge-info">{{ $user->role }}</div>
                                                        @elseif ($user->role == 'Pengguna')
                                                            <div class="badge badge-danger">{{ $user->role }}</div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="d-flex justify-content-start">
                                                            <div class="text-warning mx-2 cursor-pointer">
                                                                <a class="btn btn-info btn-sm me-1" href="{{ route('user.show', $user->id) }}" title="Detail">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            </div>
                                                            <div class="text-danger mx-2 cursor-pointer">
                                                                <form method="POST" action="{{ route('user.destroy', $user->id) }}" style="display: inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="btn btn-danger btn-sm" type="submit" title="Hapus" name="proses" value="hapus" onclick="return confirm('Anda Yakin data Dihapus?')">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                    <input type="hidden" name="idx" value=""/>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @php $no++ @endphp
                                            @endforeach
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@else
    @include('adminpage.access_denied')
@endif
@endsection