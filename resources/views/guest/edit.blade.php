@if (Auth::user()->role != 'Pengguna' && Auth::user()->role != 'Satpam')
    @extends('adminpage.index')

    @section('title_page', 'Edit Tamu')

    @section('content')
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Edit Tamu</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="{{ url('/admin') }}">Dashboard</a></div>
                        <div class="breadcrumb-item"><a href="{{ url('/admin/guest') }}">Data Tamu</a></div>
                        <div class="breadcrumb-item">Edit Tamu</div>
                    </div>
                </div>

                <div class="section-body">
                    <h2 class="section-title">Edit Tamu</h2>
                    <p class="section-lead">Silakan ubah formulir tamu di bawah ini.</p>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Form Ubah Tamu</h4>
                                </div>
                                <form method="POST" action="{{ route('guest.update', $row->id) }}" id="contactForm" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="nama" class="form-label">Nama</label>
                                                    <input class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ $row->nama }}" id="nama" type="text" placeholder="Nama" required />
                                                    @error('nama')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="instansi" class="form-label">Instansi</label>
                                                    <input class="form-control @error('instansi') is-invalid @enderror" name="instansi" value="{{ $row->instansi }}" id="instansi" type="text" placeholder="Instansi" required />
                                                    @error('instansi')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="no_telp" class="form-label">No Telp</label>
                                                    <input class="form-control @error('no_telp') is-invalid @enderror" name="no_telp" value="{{ $row->no_telp }}" id="no_telp" type="text" placeholder="No Telp" required />
                                                    @error('no_telp')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $row->email }}" id="email" type="text" placeholder="Email" required />
                                                    @error('email')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="alamat" class="form-label">Alamat</label>
                                                    <input class="form-control @error('alamat') is-invalid @enderror" name="alamat" value="{{ $row->alamat }}" id="alamat" type="text" placeholder="Alamat" required />
                                                    @error('alamat')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="keperluan" class="form-label">Keperluan</label>
                                                    <input class="form-control @error('keperluan') is-invalid @enderror" name="keperluan" value="{{ $row->keperluan }}" id="keperluan" type="text" placeholder="Keperluan" required />
                                                    @error('keperluan')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="tgl_kunjungan" class="form-label">Tanggal Kunjungan</label>
                                                    <input class="form-control @error('tgl_kunjungan') is-invalid @enderror" name="tgl_kunjungan" value="{{ $row->tgl_kunjungan }}" id="tgl_kunjungan" type="date" required />
                                                    @error('tgl_kunjungan')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="waktu_masuk" class="form-label">Waktu Masuk & Keluar</label>
                                                    <div class="d-flex align-items-center">
                                                        <input class="form-control @error('waktu_masuk') is-invalid @enderror me-2" name="waktu_masuk" value="{{ $row->waktu_masuk }}" id="waktu_masuk" type="time" required />
                                                        <span class="mx-2">-</span>
                                                        <input class="form-control @error('waktu_keluar') is-invalid @enderror" name="waktu_keluar" value="{{ $row->waktu_keluar }}" id="waktu_keluar" type="time" required />
                                                    </div>
                                                    @error('waktu_masuk')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                    @error('waktu_keluar')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="user_id" class="form-label">Petugas Penerima</label>
                                                    <select class="form-control select2" name="user_id">
                                                        <option>{{ __('-- Pilih Petugas --') }}</option>
                                                        @foreach ($ar_user as $u)
                                                            <option value="{{ $u->id }}" {{ $u->id == $row->user_id ? 'selected' : '' }}>{{ $u->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <input type="hidden" name="year_id" value="{{ $row->year_id }}">
                                                <div class="form-group mb-3">
                                                    <label for="status" class="form-label">Status</label>
                                                    <div class="d-flex align-items-center">
                                                        <div class="form-check me-3">
                                                            <input class="form-check-input" type="radio" name="status" id="statusOngoing" value="ongoing" {{ $row->status == 'ongoing' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="statusOngoing">Ongoing</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="status" id="statusDone" value="done" {{ $row->status == 'done' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="statusDone">Done</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- <div class="form-group mb-3">
                                                    <label for="status" class="form-label">Status</label>
                                                    <div class="d-flex align-items-center">
                                                        <input type="hidden" name="status" value="ongoing">
                                                        <input type="checkbox" name="status" data-toggle="switch" data-on-text="Done" data-off-text="Ongoing" data-on-color="success" data-off-color="warning" {{ $row->status == 'done' ? 'checked' : '' }}>
                                                    </div>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button class="btn btn-primary" type="submit">Simpan</button>
                                        <a href="{{ url('/admin/guest') }}" class="btn btn-danger">Batal</a>
                                    </div>
                                </form>
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
