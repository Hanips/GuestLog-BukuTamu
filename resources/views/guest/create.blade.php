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
                                                    <label for="NIP" class="form-label">NIP</label>
                                                    <input class="form-control @error('NIP') is-invalid @enderror" name="NIP" value="{{ old('NIP') }}" id="NIP" type="text" placeholder="NIP" required />
                                                    @error('NIP')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="jabatan" class="form-label">Jabatan</label>
                                                    <input class="form-control @error('jabatan') is-invalid @enderror" name="jabatan" value="{{ old('jabatan') }}" id="jabatan" type="text" placeholder="Jabatan" required />
                                                    @error('jabatan')
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
                                                    <label for="saran" class="form-label">Saran</label>
                                                    <input class="form-control @error('saran') is-invalid @enderror" name="saran" value="{{ old('saran') }}" id="saran" type="text" placeholder="Saran" required />
                                                    @error('saran')
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
                                                <div class="mb-3">
                                                    <label for="signature" class="form-label">Tanda Tangan</label>
                                                    <div id="signature-pad" class="signature-pad">
                                                        <canvas style="border: 2px solid #000;"></canvas>
                                                        <br>
                                                        <button type="button" class="btn btn-secondary btn-sm" onclick="clearSignature()">Hapus</button>
                                                        <input type="hidden" name="signature" id="signature">
                                                    </div>
                                                </div>
                                                <input type="hidden" name="year_id" value="{{ $activeYear->id }}">
                                                <input type="hidden" name="status" id="status" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button class="btn btn-primary" type="submit" onclick="checkStatus()">Simpan</button>
                                        <a href="{{ url('/admin/guest') }}" class="btn btn-danger">Batal</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        @push('scripts')
        <script>
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
            }

            var canvas = document.querySelector("canvas");
            var signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(255, 255, 255)'
            });

            function clearSignature() {
                signaturePad.clear();
            }

            document.getElementById('contactForm').addEventListener('submit', function () {
                document.getElementById('signature').value = signaturePad.toDataURL();
            });

            document.addEventListener('DOMContentLoaded', function () {
                const forms = document.querySelectorAll('form');

                forms.forEach(form => {
                    form.addEventListener('submit', async function (event) {
                        event.preventDefault();

                        const formData = new FormData(form);
                        const url = form.getAttribute('action');
                        const method = form.getAttribute('method');

                        try {
                            const response = await fetch(url, {
                                method: method,
                                body: formData
                            });

                            const responseData = await response.json();

                            if (!response.ok) {
                                console.error('Error response:', responseData);
                                Notiflix.Notify.failure('Error: ' + (responseData.message || 'Terjadi kesalahan'), {
                                    timeout: 3000
                                });
                            } else {
                                console.log('Success response:', responseData); 
                                Notiflix.Notify.success(responseData.message, {
                                    timeout: 3000
                                });
                                location.href = '{{ route('guest.index') }}';
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            Notiflix.Notify.failure('Terjadi kesalahan dalam mengirim data.', {
                                timeout: 3000
                            });
                        }
                    });
                });
            });
        </script>
        @endpush

    @endsection
@else
    @include('adminpage.access_denied')
@endif
