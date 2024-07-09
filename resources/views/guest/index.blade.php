@if (Auth::user()->role != 'Pengguna')
    @extends('adminpage.index')

    @section('title_page', 'Data Tamu')

    @section('content')
        <div class="main-content">
            <section class="section">
                <div class="section-header d-flex justify-content-between">
                    <div class="title">
                        <h1>{{ __('Data Tamu') }}</h1>
                    </div>
                    <div class="d-md-flex d-inline">
                        @if (Auth::user()->role != 'Satpam')
                            <button class="btn btn-success mx-2 my-3 my-md-0" data-toggle="modal" data-target="#exportModal">
                                <i class="fas fa-file mx-1"></i> Export Tamu
                            </button>
                        @endif
                        <div class="right-content">
                            <div class="d-flex">
                                <form id="updateYearForm">
                                    @csrf
                                    <div class="current__year d-flex py-lg-0">
                                        <div class="year__active mr-2">
                                            <select class="form-control" name="year_name">
                                                @foreach ($years as $item)
                                                    <option value="{{ $item->year_name }}" {{ $item->year_current == 'selected' ? 'selected' : '' }}>
                                                        Tahun Ajaran: {{ $item->year_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="button-submit">
                                            <button type="button" onclick="updateYear()" class="btn btn-primary h-100">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h2 class="section-title">{{ __('Data Tamu') }}</h2>
                            <p class="section-lead">{{ __('Buat dan ubah data tamu') }}</p>
                        </div>
                        <div>
                            <a href="{{ route('guest.create') }}" class="btn btn-primary mr-2">{{ __('+ Tambah Data') }}</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Tabel Tamu</h4>
                                    <div class="card-header-form">
                                        <form action="{{ route('guest.index') }}" method="GET">
                                            <div class="input-group">
                                                <input type="text" name="search" class="form-control" placeholder="Search" value="{{ request('search') }}">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Instansi</th>
                                                <th>Keperluan</th>
                                                <th>Tanggal</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            @if ($ar_guest->isEmpty())
                                                <tr>
                                                    <td colspan="7" class="text-center">Belum ada tamu pada periode ini</td>
                                                </tr>
                                            @else
                                                @foreach($ar_guest as $guest)
                                                    <tr>
                                                        <td class="p-0 text-center">{{ $loop->iteration + ($ar_guest->currentPage() - 1) * $ar_guest->perPage() }}</td>
                                                        <td>{{ $guest->nama }}</td>
                                                        <td>{{ $guest->instansi }}</td>
                                                        <td>{{ $guest->keperluan }}</td>
                                                        <td>{{ $guest->tgl_kunjungan }}</td>
                                                        <td>
                                                            @if ($guest->status == 'done')
                                                                <div class="badge badge-success">Selesai</div>
                                                            @else
                                                                <div class="badge badge-warning">Berlangsung</div>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="d-flex justify-content-start">
                                                                <div class="text-warning mx-2 cursor-pointer">
                                                                    <a class="btn btn-info btn-sm me-1" href="{{ route('guest.show', $guest->id) }}" title="Detail">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                </div>
                                                                {{-- <a class="btn btn-warning btn-sm me-1" href="{{ route('guest.edit', $guest->id) }}" title="Ubah">
                                                                    <i class="fa fa-edit"></i>
                                                                </a> --}}
                                                                @if (Auth::user()->role != 'Satpam')
                                                                    <div class="text-danger mx-2 cursor-pointer">
                                                                        <button class="btn btn-danger btn-sm delete-button" data-user-id="{{ $guest->id }}" title="Hapus">
                                                                            <i class="fa fa-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mx-3 mt-3 mb-3">
                                        <div>
                                            Menampilkan {{ $ar_guest->firstItem() }} sampai {{ $ar_guest->lastItem() }} dari {{ $ar_guest->total() }} entri
                                        </div>
                                        <div>
                                            {{ $ar_guest->links('vendor.pagination.bootstrap-4') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="exportModal">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Export Tamu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="form-action" method="post" action="{{ route('guest.excel') }}">
                        @csrf
                        <div class="modal-body">
                            <div class="row pt-3 pb-1">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="year_name">Tahun Ajaran</label>
                                        <select class="form-control" name="nama_tahun" id="year_name" required>
                                            <option value=""> -- Pilih Tahun Ajaran -- </option>
                                            @foreach ($years as $item)
                                                <option value="{{ $item->year_name }}">{{ $item->year_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="start_date">Tanggal Mulai</label>
                                        <input type="date" id="start_date" class="form-control" name="start_date" required autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label for="finish_date">Tanggal Selesai</label>
                                        <input type="date" id="finish_date" class="form-control" name="finish_date" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-whitesmoke br">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Export Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @push('scripts')
            <script>
                function updateYear() {
                    const form = document.getElementById('updateYearForm');
                    const formData = new FormData(form);
        
                    fetch('/current-year', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Terjadi kesalahan');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.error) {
                            Notiflix.Notify.failure(data.error, { timeout: 3000 });
                        } else {
                            Notiflix.Notify.success(data.message, { timeout: 3000 });
                            setTimeout(() => {
                                location.reload();
                            }, 3000);
                        }
                    })
                    .catch(error => {
                        Notiflix.Notify.failure('Error: ' + error.message);
                    });
                }
                document.getElementById('form-action').addEventListener('submit', function(event) {
                    event.preventDefault();
                    var startDate = new Date(document.getElementById('start_date').value);
                    var finishDate = new Date(document.getElementById('finish_date').value);
        
                    if (finishDate <= startDate) {
                        Notiflix.Notify.failure('Tanggal selesai harus lebih dari tanggal mulai');
                    } else {
                        event.target.submit();
                    }
                });
                document.addEventListener('DOMContentLoaded', function() {
                    const deleteButtons = document.querySelectorAll('.delete-button');
                    deleteButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            const userId = button.getAttribute('data-user-id');
        
                            Notiflix.Confirm.show('Konfirmasi', 'Apakah Anda yakin ingin menghapus tamu ini?', 'Ya', 'Batal',
                                function() {
                                    fetch(`/admin/guest/${userId}`, {
                                            method: 'DELETE',
                                            headers: {
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            }
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            if (data.success) {
                                                Notiflix.Notify.success('Tamu berhasil dihapus!', {
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
        @endpush        

    @endsection
@else
    @include('adminpage.access_denied')
@endif