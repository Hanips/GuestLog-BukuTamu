@if (Auth::user()->role != 'Pengguna')
    @extends('adminpage.index')

    @section('title_page', 'Data Petugas')

    @section('content')
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Data Petugas</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="{{ url('/admin') }}">Dashboard</a></div>
                        <div class="breadcrumb-item">Data Petugas</div>
                    </div>
                </div>
                <div class="section-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h2 class="section-title">Data Petugas</h2>
                            <p class="section-lead">Buat dan ubah data petugas</p>
                        </div>
                        <div>
                            <a href="{{ route('officer.create') }}" class="btn btn-primary mr-2">{{ __('+ Tambah Data') }}</a>
                            <a href="{{-- route('guest.excel') --}}" class="btn btn-success"><i class="fas fa-file mx-1"></i> Export Petugas</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Tabel Petugas</h4>
                                    <div class="card-header-form">
                                        <form>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Search">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
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
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach($ar_officer as $officer)
                                                <tr>
                                                    <td class="p-0 text-center">{{ $no }}</td>
                                                    <td>{{ $officer->name }}</td>
                                                    <td>{{ $officer->email }}</td>
                                                    <td>
                                                        @if ($officer->role != 'Pengguna')
                                                            <div class="badge badge-success">{{ $officer->role }}</div>
                                                        @else
                                                            <div class="badge badge-danger">Pengguna</div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a class="btn btn-info btn-sm me-1" href="{{ route('officer.show', $officer->id) }}" title="Detail">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            {{-- <a class="btn btn-warning btn-sm me-1" href="{{ route('officer.edit', $officer->id) }}" title="Ubah">
                                                                <i class="fa fa-edit"></i>
                                                            </a> --}}
                                                            <form method="POST" action="{{ route('officer.destroy', $officer->id) }}" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-danger btn-sm" type="submit" title="Hapus" name="proses" value="hapus" onclick="return confirm('Anda Yakin Data Dihapus?')">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                                <input type="hidden" name="idx" value=""/>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @php $no++ @endphp
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    @endsection
@else
    @include('adminpage.access_denied')
@endif
