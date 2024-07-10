@if (Auth::user()->role != 'Pengguna' && Auth::user()->role != 'Satpam')
    @extends('adminpage.index')

    @section('title_page', 'Manajemen Pengguna')

    @section('content')
        @push('styles')
            <link rel="stylesheet" href="{{ asset('adminpage/modules/datatables/datatables.min.css') }}">
        @endpush
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
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ __('Tabel Pengguna') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="datatables">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($ar_user->isEmpty())
                                            <tr>
                                                <td colspan="5" class="text-center">Belum ada data pengguna</td>
                                            </tr>
                                        @else
                                            @foreach($ar_user as $user)
                                                <tr>
                                                    <td class="p-0 text-center">{{ $loop->iteration }}</td>
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
                                                            <div class="text-warning mx-2 cursor-pointer">
                                                                <a class="btn btn-warning btn-sm me-1" href="{{ route('user.edit', $user->id) }}" title="Ubah">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                            </div>
                                                            <div class="text-danger mx-2 cursor-pointer">
                                                                <button class="btn btn-danger btn-sm delete-button" data-user-id="{{ $user->id }}" title="Hapus">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
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
                                                location.reload();
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

            <script src="{{ asset('adminpage/modules/datatables/datatables.min.js') }}"></script>
            <script src="{{ asset('adminpage/js/page/modules-datatables.js') }}"></script>

            <script>
                $('#datatables').dataTable();
            </script>
        @endpush
    
    @endsection

@else
    @include('adminpage.access_denied')
@endif
