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
                        <button class="btn btn-success mx-2 my-3 my-md-0" data-toggle="modal" data-target="#exportModal">
                            <i class="fas fa-file mx-1"></i> Export Tamu
                        </button>
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
                            {{-- <a href="{{ route('guest.excel') }}" class="btn btn-success">Excel</a> --}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>{{ __('Tabel Tamu') }}</h4>
                                    <div class="card-header-form">
                                        <form>
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Search">
                                                <div class="input-group-btn">
                                                    <button class="btn btn-primary"><i class="fas fa-search"></i></button>
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
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach($ar_guest as $guest)
                                                <tr>
                                                    <td class="p-0 text-center">{{ $no }}</td>
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
                                                        <div class="btn-group">
                                                            <a class="btn btn-info btn-sm me-1" href="{{ route('guest.show', $guest->id) }}" title="Detail">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            {{-- <a class="btn btn-warning btn-sm me-1" href="{{ route('guest.edit', $guest->id) }}" title="Ubah">
                                                                <i class="fa fa-edit"></i>
                                                            </a> --}}
                                                            <form method="POST" action="{{ route('guest.destroy', $guest->id) }}" style="display: inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="btn btn-danger btn-sm" type="submit" title="Hapus" name="proses" value="hapus" onclick="return confirm('Anda Yakin Data Dihapus?')">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                                <input type="hidden" name="idx" value=""/>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @php $no++ @endphp
                                            @endforeach
                                        </table>
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
                        <h5 class="modal-title">Export Realisasi Dana</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="form-action" method="post" action="{{-- route('exportRealisasi') --}}">
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
                                        <label for="year_name">Tanggal Mulai</label>
                                        <input type="date" id="start_date" class="form-control" name="start_date" required autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label for="year_name">Tanggal Selesai</label>
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
                        Notiflix.Notify.failure(data.error, { timeout: 1000 });
                    } else {
                        Notiflix.Notify.success(data.message, { timeout: 1000 });
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    }
                })
                .catch(error => {
                    Notiflix.Notify.failure('Error: ' + error.message);
                });
            }
        </script>

        @push('scripts')
            <script src="https://cdnjs.cloudflare.com/ajax/libs/notiflix/2.7.0/notiflix.min.js"></script>
            <script>
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
            </script>
        @endpush

    @endsection
@else
    @include('adminpage.access_denied')
@endif
