@if (Auth::user()->role != 'Pengguna')
    @extends('adminpage.index')

    @section('title_page', 'Detail Tamu')

    @section('content')
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Detail Tamu</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="{{ url('/admin') }}">Dashboard</a></div>
                        <div class="breadcrumb-item"><a href="{{ url('/admin/guest') }}">Data Tamu</a></div>
                        <div class="breadcrumb-item">Detail Tamu</div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Detail Tamu</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="nama" class="form-label">Nama</label>
                                                <input class="form-control" value="{{ $rs->nama }}" id="nama" type="text" placeholder="Nama" disabled />
                                            </div>
                                            <div class="mb-3">
                                                <label for="instansi" class="form-label">Instansi</label>
                                                <input class="form-control" value="{{ $rs->instansi }}" id="instansi" type="text" placeholder="Instansi" disabled />
                                            </div>
                                            <div class="mb-3">
                                                <label for="no_telp" class="form-label">No Telp</label>
                                                <input class="form-control" value="{{ $rs->no_telp }}" id="no_telp" type="text" placeholder="No Telp" disabled />
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input class="form-control" value="{{ $rs->email }}" id="email" type="text" placeholder="Email" disabled />
                                            </div>
                                            <div class="mb-3">
                                                <label for="alamat" class="form-label">Alamat</label>
                                                <input class="form-control" value="{{ $rs->alamat }}" id="alamat" type="text" placeholder="Alamat" disabled />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="keperluan" class="form-label">Keperluan</label>
                                                <input class="form-control" value="{{ $rs->keperluan }}" id="keperluan" type="text" placeholder="Keperluan" disabled />
                                            </div>
                                            <div class="mb-3">
                                                <label for="tgl_kunjungan" class="form-label">Tanggal Kunjungan</label>
                                                <input class="form-control" value="{{ $rs->tgl_kunjungan }}" id="tgl_kunjungan" type="date" disabled />
                                            </div>
                                            <div class="mb-3">
                                                <label for="waktu_masuk" class="form-label">Waktu Masuk & Keluar</label>
                                                <div class="d-flex align-items-center">
                                                    <input class="form-control me-2" value="{{ $rs->waktu_masuk }}" id="waktu_masuk" type="time" disabled />
                                                    <span class="mx-2">-</span>
                                                    <input class="form-control" value="{{ $rs->waktu_keluar }}" id="waktu_keluar" type="time" disabled />
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="user_id" class="form-label">Petugas Penerima</label>
                                                <input class="form-control" value="{{ $rs->user->name }}" id="user_id" type="text" placeholder="Nama User" disabled />
                                            </div>
                                            <div class="form-group mb-3">
                                                <label for="status" class="form-label">Status</label>
                                                <br>
                                                @if ($rs->status == 'done')
                                                    <div class="badge badge-success" style="font-size: 1em; padding: 0.5em 0.7em;">Selesai</div>
                                                @else
                                                    <div class="badge badge-warning" style="font-size: 1em; padding: 0.5em 0.7em;">Berlangsung</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <a href="{{ url('/admin/guest') }}" class="btn btn-primary">Kembali</a>
                                        <a class="btn btn-warning" href="{{ route('guest.edit', $rs->id) }}" title="Ubah">Ubah</a>
                                        <form method="POST" action="{{ route('guest.destroy', $rs->id) }}" style="display: inline;">
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
                </div>
            </section>
        </div>
    @endsection
@else
    @include('adminpage.access_denied')
@endif
