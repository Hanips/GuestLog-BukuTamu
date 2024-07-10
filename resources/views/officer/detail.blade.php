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
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Detail Petugas</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
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
                                        <div class="card-footer text-left">
                                            <a href="{{ url('/admin/officer') }}" class="btn btn-primary">Kembali</a>
                                            @if (Auth::user()->role != 'Satpam')
                                                <a class="btn btn-warning" href="{{ route('officer.edit', $rs->id) }}" title="Ubah">Ubah</a>
                                                <button class="btn btn-danger delete-button" data-user-id="{{ $rs->id }}" title="Hapus">Hapus</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const deleteButtons = document.querySelectorAll('.delete-button');
                    deleteButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            const userId = button.getAttribute('data-user-id');

                            Notiflix.Confirm.show('Konfirmasi', 'Apakah Anda yakin ingin menghapus petugas ini?', 'Ya', 'Batal',
                                function() {
                                    fetch(`/admin/officer/${userId}`, {
                                            method: 'DELETE',
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            }
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {
                                                Notiflix.Notify.success('Petugas berhasil dihapus!', {
                                                    timeout: 3000
                                                });
                                                location.href = '{{ route('officer.index') }}';
                                            } else {
                                                Notiflix.Notify.failure(data.message, {
                                                    timeout: 3000
                                                });
                                            }
                                        })
                                        .catch(error => {
                                            Notiflix.Notify.failure('Terjadi kesalahan saat menghapus petugas.', {
                                                timeout: 3000
                                            });
                                        });
                                });
                        });
                    });
                });
            </script>
        @endpush
    @endsection
@else
    @include('adminpage.access_denied')
@endif
