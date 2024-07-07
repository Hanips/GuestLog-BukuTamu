@if (Auth::user()->role != 'Pengguna')
@extends('adminpage.index')

@section('title_page', 'Tambah Tamu')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Tambah Tamu</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ url('/admin') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ url('/admin/guest') }}">Data Tamu</a></div>
                    <div class="breadcrumb-item">Tambah Tamu</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Tambah Tamu</h2>
                <p class="section-lead">Silakan isi formulir tamu di bawah ini.</p>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Form Tambah Tamu</h4>
                            </div>
                            <form method="POST" action="{{ route('guest.store') }}" id="contactForm" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="nama" class="form-label">Nama</label>
                                                <input class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') }}" id="nama" type="text" placeholder="Nama" required />
                                                @error('nama')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="instansi" class="form-label">Instansi</label>
                                                <input class="form-control @error('instansi') is-invalid @enderror" name="instansi" value="{{ old('instansi') }}" id="instansi" type="text" placeholder="Instansi" required />
                                                @error('instansi')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="no_telp" class="form-label">No Telp</label>
                                                <input class="form-control @error('no_telp') is-invalid @enderror" name="no_telp" value="{{ old('no_telp') }}" id="no_telp" type="text" placeholder="No Telp" required />
                                                @error('no_telp')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email</label>
                                                <input class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" id="email" type="text" placeholder="Email" required />
                                                @error('email')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="alamat" class="form-label">Alamat</label>
                                                <input class="form-control @error('alamat') is-invalid @enderror" name="alamat" value="{{ old('alamat') }}" id="alamat" type="text" placeholder="Alamat" required />
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
                                                <input class="form-control @error('keperluan') is-invalid @enderror" name="keperluan" value="{{ old('keperluan') }}" id="keperluan" type="text" placeholder="Keperluan" required />
                                                @error('keperluan')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="tgl_kunjungan" class="form-label">Tanggal Kunjungan</label>
                                                <input class="form-control @error('tgl_kunjungan') is-invalid @enderror" name="tgl_kunjungan" value="{{ old('tgl_kunjungan') }}" id="tgl_kunjungan" type="date" required />
                                                @error('tgl_kunjungan')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label for="waktu_masuk" class="form-label">Waktu Masuk & Waktu Keluar</label>
                                                <div class="d-flex align-items-center">
                                                    <input class="form-control @error('waktu_masuk') is-invalid @enderror me-2" name="waktu_masuk" value="{{ old('waktu_masuk') }}" id="waktu_masuk" type="time" required />
                                                    <span class="mx-2">-</span>
                                                    <input class="form-control @error('waktu_keluar') is-invalid @enderror" name="waktu_keluar" value="{{ old('waktu_keluar') }}" id="waktu_keluar" type="time" required />
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
                                                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="signature">TTD Tamu</label>
                                                <canvas id="signature-pad" width="400" height="200" style="border: 1px solid #000;"></canvas>
                                                <button type="button" id="clear">Clear</button>
                                                <textarea id="signatureInput" name="signature" style="display: none;"></textarea>
                                            </div>
                                            <input type="hidden" name="year_id" value="{{ $activeYear->id }}">
                                            <input type="hidden" name="status" id="status" value="">
                                        </div>
                                        <div class="card-footer text-center">
                                            <button class="btn btn-primary" type="submit" onclick="checkStatus()">Simpan</button>
                                            <a href="{{ url('/admin/guest') }}" class="btn btn-danger">Batal</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.5.3/signature_pad.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var canvas = document.getElementById('signature-pad');
            var signaturePad = new SignaturePad(canvas);

            var clearButton = document.getElementById('clear');
            clearButton.addEventListener('click', function () {
                signaturePad.clear();
            });

            var form = document.querySelector('form');
            form.addEventListener('submit', function (event) {
                // Cek apakah SignaturePad kosong
                if (signaturePad.isEmpty()) {
                    alert('Silakan tanda tangani terlebih dahulu.');
                    event.preventDefault();
                    return;
                }

                // Mengambil data tanda tangan dari SignaturePad
                var signatureData = signaturePad.toDataURL();
                console.log('Signature Data:', signatureData); // Debugging

                // Menyimpan data tanda tangan di dalam textarea dengan ID 'signatureInput'
                document.getElementById('signatureInput').value = signatureData;
            });
        });

    
        function checkStatus() {
            const tglKunjungan = document.getElementById('tgl_kunjungan').value;
            const waktuKeluar = document.getElementById('waktu_keluar').value;
            const status = document.getElementById('status');
            const currentDateTime = new Date();
            const visitDateTime = new Date(`${tglKunjungan}T${waktuKeluar}`);
    
            if (visitDateTime <= currentDateTime) {
                status.value = 'done';
            } else {
                status.value = 'ongoing';
            }
    
            // Debug console.log
            console.log('Status:', status.value);
        }
    </script>
    
@endsection
@else
    @include('adminpage.access_denied')
@endif
