@if (Auth::user()->role != 'Pengguna')
    @extends('adminpage.index')

    @section('title_page', 'Dashboard')
    
    @section('content')
    <div class="main-wrapper main-wrapper-1">
        <div class="navbar-bg"></div>

        <!-- Main Content -->
        <div class="main-content">
            <section class="section">
                <div class="section-header d-flex justify-content-between">
                    <div class="title">
                        <h1>{{ __('Dashboard') }}</h1>
                    </div>
                    <div class="d-md-flex d-inline">
                        <div class="right-content">
                            <div class="d-flex">
                                <form id="updateYearForm">
                                    @csrf
                                    <div class="current__year d-flex py-lg-0">
                                        <div class="year__active mr-2">
                                            <select class="form-control" name="year_name">
                                                @foreach ($years as $item)
                                                    <option value="{{ $item->year_name }}"
                                                        {{ $item->year_current == 'selected' ? 'selected' : '' }}>
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
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="bg-primary">
                                <div class="py-1"></div>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Tamu Hari Ini</h4>
                                </div>
                                <div class="card-body py-2">
                                    <h5>
                                        {{ $totalGuestsToday }}
                                    </h5>
                                </div>
                                <div class="py-2"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="bg-primary">
                                <div class="py-1"></div>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Tamu Bulan Ini</h4>
                                </div>
                                <div class="card-body py-2">
                                    <h5>
                                        {{ $totalGuestsMonth }}
                                    </h5>
                                </div>
                                <div class="py-2"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="bg-primary">
                                <div class="py-1"></div>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Tamu Tahun Ajaran Ini</h4>
                                </div>
                                <div class="card-body py-2">
                                    <h5>
                                        {{ $totalGuestsPeriod }}
                                    </h5>
                                </div>
                                <div class="py-2"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <div class="card">
                            <div class="card-header">
                                <h4>Tamu Terbaru</h4>
                                <div class="card-header-action">
                                    @if ($recentGuest->isNotEmpty())
                                        <a href="{{ url('/admin/guest') }}" class="btn btn-primary">
                                            View More <i class="fas fa-chevron-right"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped">
                                        @if ($recentGuest->isEmpty())
                                            <p class="text-center">Belum ada tamu pada periode ini</p>
                                        @else
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Name</th>
                                                    <th>Tanggal</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($recentGuest as $index => $guest)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $guest->nama }}</td>
                                                    <td>{{ $guest->tgl_kunjungan }}</td>
                                                    <td>
                                                        @if ($guest->status == 'done')
                                                            <div class="badge badge-success">Selesai</div>
                                                        @else
                                                            <div class="badge badge-warning">Berlangsung</div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('guest.show', ['guest' => $guest->id]) }}" class="btn btn-primary">Detail</a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
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
    
    @endsection
@else
    @include('adminpage.access_denied')
@endif

