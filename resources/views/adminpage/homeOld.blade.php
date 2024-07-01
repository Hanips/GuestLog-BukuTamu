@extends('adminpage.index')

@section('content')
@if (Auth::user()->role != 'Pengguna')
    <div class="main-content">
        <section class="section">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card card-statistic-2">
                        <div class="card-stats">
                            <div class="card-stats-title">Guest Statistics - 
                                <div class="dropdown d-inline">
                                    <a class="font-weight-600 dropdown-toggle" data-toggle="dropdown" href="#" id="guests-month">Current</a>
                                    <ul class="dropdown-menu dropdown-menu-sm">
                                        <li class="dropdown-title">Select Period</li>
                                        <li><a href="#" class="dropdown-item">Today</a></li>
                                        <li><a href="#" class="dropdown-item">This Week</a></li>
                                        <li><a href="#" class="dropdown-item">This Month</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-stats-items">
                                <div class="card-stats-item">
                                    <div class="card-stats-item-count">{{ $totalTamuHariIni }}</div>
                                    <div class="card-stats-item-label">Today</div>
                                </div>
                                <div class="card-stats-item">
                                    <div class="card-stats-item-count">{{ $totalTamuMingguIni }}</div>
                                    <div class="card-stats-item-label">This Week</div>
                                </div>
                                <div class="card-stats-item">
                                    <div class="card-stats-item-count">{{ $totalTamuBulanIni }}</div>
                                    <div class="card-stats-item-label">This Month</div>
                                </div>
                            </div>
                        </div>
                        <div class="card-icon shadow-primary bg-primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Total Guests</h4>
                            </div>
                            <div class="card-body">
                                {{ $totalGuests }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Recent Guests</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Check-in Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tamuTerbaru as $index => $guest)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $guest->nama }}</td>
                                            <td>{{ $guest->created_at->format('d M Y') }}</td>
                                            <td>
                                                <a href="{{ route('guest.show', ['guest' => $guest->id]) }}" class="btn btn-primary">Detail</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@else
    @include('adminpage.access_denied') 
@endif
@endsection
