@if (Auth::user()->role != 'Pengguna' && Auth::user()->role != 'Satpam')
    @extends('adminpage.index')

    @section('title_page', 'Detail Pengguna')

    @section('content')
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Detail Pengguna</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="{{ url('/admin') }}">Dashboard</a></div>
                        <div class="breadcrumb-item"><a href="{{ url('/admin/account/user') }}">Manajemen Pengguna</a></div>
                        <div class="breadcrumb-item">Detail Pengguna</div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Detail Pengguna</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Nama Pengguna</label>
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
                                            <a href="{{ url('/admin/account/user') }}" class="btn btn-primary">Kembali</a>
                                            <a class="btn btn-warning" href="{{ route('user.edit', $rs->id) }}" title="Ubah">Ubah</a>
                                            <button class="btn btn-danger delete-button" data-user-id="{{ $rs->id }}" title="Hapus">Hapus</button>
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

                            Notiflix.Confirm.show('Konfirmasi', 'Apakah Anda yakin ingin menghapus pengguna ini?', 'Ya', 'Batal',
                                function() {
                                    fetch(`/admin/account/user/${userId}`, {
                                            method: 'DELETE',
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            }
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {
                                                Notiflix.Notify.success('Pengguna berhasil dihapus!', {
                                                    timeout: 3000
                                                });
                                                location.href = '{{ route('user.index') }}';
                                            } else {
                                                Notiflix.Notify.failure(data.message, {
                                                    timeout: 3000
                                                });
                                            }
                                        })
                                        .catch(error => {
                                            Notiflix.Notify.failure('Terjadi kesalahan saat menghapus pengguna.', {
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
