@if (Auth::user()->role != 'Pengguna')
    @extends('adminpage.index')

    @section('title_page', 'Detail Petugas')

    @section('content')
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Detail Petugas</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="{{ url('/admin') }}">Dashboard</a></div>
                        <div class="breadcrumb-item"><a href="{{ url('/admin/officer') }}">Data Petugas</a></div>
                        <div class="breadcrumb-item">Detail Petugas</div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Detail Petugas</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Nama Petugas</label>
                                                <input class="form-control" value="{{ $rs->name }}" id="name" type="text" disabled />
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input class="form-control" value="{{ $rs->email }}" id="email" type="text" disabled />
                                            </div>
                                            <div class="mb-3">
                                                <label for="role" class="form-label">Role</label>
                                                <input class="form-control" value="{{ $rs->role }}" id="role" type="text" disabled />
                                            </div>
                                            <div class="mb-3">
                                                <label for="created_at" class="form-label">Dibuat</label>
                                                <input class="form-control" value="{{ $rs->created_at->format('d M Y') }}" id="created_at" type="text" disabled />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <a href="{{ url('/admin/officer') }}" class="btn btn-primary">Kembali</a>
                                    <a class="btn btn-warning" href="{{ route('officer.edit', $rs->id) }}" title="Ubah">Ubah</a>
                                    <form method="POST" action="{{ route('officer.destroy', $rs->id) }}" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit" title="Hapus" name="proses" value="hapus" onclick="return confirm('Anda Yakin Data Dihapus?')">Hapus</button>
                                        <input type="hidden" name="idx" value=""/>
                                    </form>
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
