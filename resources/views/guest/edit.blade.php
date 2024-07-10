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
                                                    <label for="NIP" class="form-label">NIP</label>
                                                    <input class="form-control @error('NIP') is-invalid @enderror" name="NIP" value="{{ $row->NIP }}" id="NIP" type="text" placeholder="NIP" required />
                                                    @error('NIP')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="jabatan" class="form-label">Jabatan</label>
                                                    <input class="form-control @error('jabatan') is-invalid @enderror" name="jabatan" value="{{ $row->jabatan }}" id="jabatan" type="text" placeholder="Jabatan" required />
                                                    @error('jabatan')
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
                                                    <label for="tgl_kunjungan" class="form-label">Tanggal Kunjungan</label>
                                                    <input class="form-control @error('tgl_kunjungan') is-invalid @enderror" name="tgl_kunjungan" value="{{ $row->tgl_kunjungan->format('Y-m-d') }}" id="tgl_kunjungan" type="date" required />
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
                                                    <label for="saran" class="form-label">Saran</label>
                                                    <input class="form-control @error('saran') is-invalid @enderror" name="saran" value="{{ $row->saran }}" id="saran" type="text" placeholder="Saran" required />
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
                                                            <option value="{{ $u->id }}" {{ $u->id == $row->user_id ? 'selected' : '' }}>{{ $u->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <input type="hidden" name="year_id" value="{{ $row->year_id }}">
                                                <div class="form-group mb-3">
                                                    <label for="status" class="form-label">Status</label>
                                                    <div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="status" id="statusOngoing" value="ongoing" {{ $row->status == 'ongoing' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="statusOngoing">Ongoing</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="radio" name="status" id="statusDone" value="done" {{ $row->status == 'done' ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="statusDone">Done</label>
                                                        </div>
                                                    </div>
                                                </div>                                               
                                                <div class="mb-3">
                                                    <label for="signature" class="form-label">Tanda Tangan</label>
                                                    <div id="signature-container">
                                                        <img id="current-signature-img" src="{{ asset('storage/signatures/' . $row->signature) }}" alt="Current Signature" style="max-width: 100%; border: 2px solid #000;">
                                                        <canvas id="signature-canvas" style="border: 2px solid #000; display: none;"></canvas>
                                                    </div>
                                                    <div class="mt-3">
                                                        <button type="button" class="btn btn-warning btn-sm" id="change-signature-btn" onclick="showCanvas()">Ganti Tanda Tangan</button>
                                                        <button type="button" class="btn btn-secondary btn-sm" id="clear-signature-btn" onclick="clearSignature()" style="display: none;">Hapus</button>
                                                        <button type="button" class="btn btn-danger btn-sm" id="cancel-signature-btn" onclick="cancelSignature()" style="display: none;">Batal</button>
                                                        <input type="hidden" name="signature" id="signature">
                                                        <input type="hidden" name="current_signature" value="{{ $row->signature }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer text-left">
                                                <button class="btn btn-primary" type="submit">Simpan</button>
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

        @push('scripts')
        <script>
            var signaturePad = new SignaturePad(document.getElementById('signature-canvas'));
            var currentSignatureImg = document.getElementById('current-signature-img');
            var signatureCanvas = document.getElementById('signature-canvas');
            var changeSignatureBtn = document.getElementById('change-signature-btn');
            var clearSignatureBtn = document.getElementById('clear-signature-btn');
            var cancelSignatureBtn = document.getElementById('cancel-signature-btn');

            function showCanvas() {
                currentSignatureImg.style.display = 'none';
                signatureCanvas.style.display = 'block';
                changeSignatureBtn.style.display = 'none';
                clearSignatureBtn.style.display = 'inline-block';
                cancelSignatureBtn.style.display = 'inline-block';
            }

            function clearSignature() {
                signaturePad.clear();
                document.getElementById('signature').value = '';
            }

            function cancelSignature() {
                signaturePad.clear();
                signatureCanvas.style.display = 'none';
                currentSignatureImg.style.display = 'block';
                changeSignatureBtn.style.display = 'inline-block';
                clearSignatureBtn.style.display = 'none';
                cancelSignatureBtn.style.display = 'none';
            }

            document.getElementById('contactForm').addEventListener('submit', function(event) {
                if (!signaturePad.isEmpty()) {
                    document.getElementById('signature').value = signaturePad.toDataURL('image/png');
                } else {
                    document.getElementById('signature').value = '';
                }
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