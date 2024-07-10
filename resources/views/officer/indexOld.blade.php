@if (Auth::user()->role != 'Pengguna')
    @extends('adminpage.index')

    @section('title_page', 'Data Petugas')

    @section('content')
        @push('styles')
            <link rel="stylesheet" href="{{ asset('adminpage/modules/datatables/datatables.min.css') }}">
        @endpush
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
                        @if (Auth::user()->role != 'Satpam')
                            <div>
                                <a href="{{ route('officer.create') }}" class="btn btn-primary mr-2">{{ __('+ Tambah Data') }}</a>
                                <a href="{{ route('officer.excel') }}" class="btn btn-success"><i class="fas fa-file mx-1"></i> Export Petugas</a>
                            </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>{{ __('Tabel Petugas') }}</h4>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table id="table-officer" class="table table-striped">
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
                                                @if ($ar_officer->isEmpty())
                                                    <tr>
                                                        <td colspan="5" class="text-center">Belum ada data petugas</td>
                                                    </tr>
                                                @else
                                                    @php
                                                        $no = 1;
                                                    @endphp
                                                    @foreach($ar_officer as $officer)
                                                        <tr>
                                                            <td>{{ $no++ }}</td>
                                                            <td>{{ $officer->name }}</td>
                                                            <td>{{ $officer->email }}</td>
                                                            <td><div class="badge badge-info">{{ $officer->role }}</div></td>
                                                            <td>
                                                                <div class="d-flex justify-content-start">
                                                                    <div class="text-warning mx-2 cursor-pointer">
                                                                        <a class="btn btn-info btn-sm me-1" href="{{ route('officer.show', $officer->id) }}" title="Detail">
                                                                            <i class="fa fa-eye"></i>
                                                                        </a>
                                                                    </div>
                                                                    @if (Auth::user()->role != 'Satpam')
                                                                        <div class="text-danger mx-2 cursor-pointer">
                                                                            <button class="btn btn-danger btn-sm delete-button" data-user-id="{{ $officer->id }}" title="Hapus">
                                                                                <i class="fa fa-trash"></i>
                                                                            </button>
                                                                        </div>
                                                                    @endif
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
                                                location.reload();
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

            <script src="{{ asset('adminpage/modules/datatables/datatables.min.js') }}"></script>
            <script src="{{ asset('adminpage/js/page/modules-datatables.js') }}"></script>

            <script>
                $('#table-officer').dataTable();
            </script>
        @endpush
    @endsection
@else
    @include('adminpage.access_denied')
@endif
