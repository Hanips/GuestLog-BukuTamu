@extends('adminpage.index')

@section('title_page', 'Year List')

@section('content')
@if (Auth::user()->role != 'Pengguna' && Auth::user()->role != 'Satpam')
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>{{ __('Tahun Aktif') }}</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item">{{ __('Dashboard') }}</div>
                        <div class="breadcrumb-item">{{ __('General Setting') }}</div>
                        <div class="breadcrumb-item active">{{ __('Tahun Aktif') }}</div>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center pb-3">
                    <div class="title-content">
                        <h2 class="section-title">{{ __('Tahun Pembelajaran Aktif') }}</h2>
                        <p class="section-lead">
                            {{ __('Pilih dan Tambah Data Tahun Pembelajaran Aktif') }}
                        </p>
                    </div>
                    <div class="action-content">
                        <button class="btn btn-primary" data-toggle="modal"
                            data-target="#exampleModal">{{ __('+ Tambah Data') }}</button>
                    </div>
                </div>
                <div class="row">
                    @foreach ($years as $year)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="card @if ($year->year_status == 'active') card-success @else card-danger @endif">
                                @if ($year->year_status != 'active')
                                    <div class="card-body cursor-pointer card-body-off" data-card-id="{{ $year->id }}">
                                        <p>Tahun Pelajaran {{ $year->year_name }}</p>
                                    </div>
                                    <div class="card-footer d-flex justify-content-between">
                                        <button class="btn btn-success activate-year" data-card-id="{{ $year->id }}">
                                            {{ __('Aktifkan') }}
                                        </button>
                                        <button class="btn btn-danger delete-year" data-card-id="{{ $year->id }}">
                                            {{ __('Hapus') }}
                                        </button>
                                    </div>
                                @else
                                    <div class="card-body cursor-pointer card-body-off" data-card-id="{{ $year->id }}">
                                        <b>Tahun Pelajaran {{ $year->year_name }}</b>
                                    </div>
                                    <div class="card-footer d-grid gap-2 mx-auto">
                                        <button class="btn btn-success disabled" data-card-id="{{ $year->id }}">
                                            {{ __('Aktif') }}
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="exampleModal">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Tahun</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="yearForm" action="{{ route('storeYear') }}" method="POST">
                    @csrf <!-- Tambahkan CSRF token -->
                    <div class="modal-body">
                        <div class="row pt-3 pb-1">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="year_name">Nama Tahun Pelajaran</label>
                                    <input type="text" id="year_name" class="form-control" name="year_name"
                                        placeholder="2022/2023" required autofocus>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const yearForm = document.getElementById('yearForm');
                yearForm.addEventListener('submit', async function(event) {
                    event.preventDefault();
                    const formData = new FormData(yearForm);
                    const yearData = {};
                    formData.forEach((value, key) => {
                        yearData[key] = value;
                    });

                    console.log('Form data:', yearData);

                    try {
                        const response = await fetch('{{ route('storeYear') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify(yearData)
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
                            location.href = '{{ route('year.index') }}'; // Redirect to the desired page
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        Notiflix.Notify.failure('Terjadi kesalahan dalam mengirim data.', {
                            timeout: 3000
                        });
                    }
                });

                const deleteButtons = document.querySelectorAll('.delete-year');
                deleteButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const cardId = button.dataset.cardId;

                        Notiflix.Confirm.show('Konfirmasi', 'Apakah Anda yakin ingin menghapus data ini?', 'Ya',
                            'Batal',
                            function() {
                                fetch(`/setting/year/delete/${cardId}`, {
                                        method: 'DELETE',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        }
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        Notiflix.Notify.success("Data tahun berhasil dihapus!", {
                                            timeout: 3000
                                        });
                                        location.reload();
                                    })
                                    .catch(error => {
                                        Notiflix.Notify.failure('Error:', error);
                                    });
                            });
                    });
                });

                document.querySelectorAll('.activate-year').forEach(button => {
                    button.addEventListener('click', function() {
                        const cardId = this.dataset.cardId;
                        Notiflix.Confirm.show(
                            'Konfirmasi',
                            'Apakah Anda yakin ingin mengaktifkan tahun ajaran ini?',
                            'Ya',
                            'Batal',
                            async function() {
                                console.log(`Activating year with ID: ${cardId}`);
                                try {
                                    const response = await fetch(`/admin/setting/year/update/${cardId}`, {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            'Content-Type': 'application/json'
                                        }
                                    });

                                    const data = await response.json();

                                    if (!response.ok) {
                                        console.error('Update error:', data);
                                        Notiflix.Notify.failure('Error: ' + (data.message || 'Terjadi kesalahan'), {
                                            timeout: 3000
                                        });
                                    } else {
                                        console.log('Update response:', data);
                                        Notiflix.Notify.success(data.message, {
                                            timeout: 3000
                                        });
                                    }
                                } catch (error) {
                                    console.error('Error:', error);
                                    Notiflix.Notify.failure('Terjadi kesalahan dalam mengaktifkan tahun ajaran.', {
                                        timeout: 3000
                                    });
                                }
                            }
                        );
                    });
                });
            });

        </script>
    @endpush
@else
    @include('adminpage.access_denied')
@endif
@endsection