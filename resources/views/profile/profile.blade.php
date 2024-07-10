@if (Auth::user()->role != 'Pengguna')
    @extends('adminpage.index')

    @section('title_page', 'Profile')

    @section('content')
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Profil</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="{{ url('/admin') }}">Dashboard</a></div>
                        <div class="breadcrumb-item">Profil</div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
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
                                    </div>
                                </div>
                                <div class="card-footer text-left">
                                    <a class="btn btn-primary" href="{{ route('profile.edit', $rs->id) }}" title="Ubah">Ubah Profil</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    @endsection
@else
    @include('adminpage.access_denied')
@endif
