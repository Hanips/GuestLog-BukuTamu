@if (Auth::user()->role != 'Pengguna')
    @extends('adminpage.index')

    @section('title_page', 'Edit Profil')

    @section('content')
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Edit Profil</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="{{ url('/admin') }}">Dashboard</a></div>
                        <div class="breadcrumb-item active"><a href="{{ url('/admin/profile') }}">Profil</a></div>
                        <div class="breadcrumb-item">Edit Profil</div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <form method="POST" action="{{ route('profile.update', $user->id) }}" id="contactForm" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Name</label>
                                                    <input class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" id="name" type="text" placeholder="Name" required />
                                                    @error('name')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" id="email" type="email" placeholder="Email" required />
                                                    @error('email')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="role" class="form-label">Role</label>
                                                    <select class="form-control select2" name="role" disabled>
                                                        <option value="">{{ $user->role }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div>
                                            <a href="{{ url('/admin/profile/change-password') }}" class="btn btn-warning">Ubah Password</a>
                                        </div>
                                    </div>
                                    <div class="card-footer text-left">
                                        <div>
                                            <button class="btn btn-primary" type="submit">Simpan</button>
                                            <a href="{{ url('/admin/profile') }}" class="btn btn-danger">Batal</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        @push('scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const forms = document.querySelectorAll('form');

                    forms.forEach(form => {
                        form.addEventListener('submit', async function (event) {
                            event.preventDefault();

                            const formData = new FormData(form);
                            const url = form.getAttribute('action');
                            const method = form.getAttribute('method');
                            
                            try {
                                const response = await fetch(url, {
                                    method: method,
                                    body: formData
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
                                    location.href = '{{ route('profile') }}';
                                }
                            } catch (error) {
                                console.error('Error:', error);
                                Notiflix.Notify.failure('Terjadi kesalahan dalam mengirim data.', {
                                    timeout: 3000
                                });
                            }
                        });
                    });
                });
            </script>
        @endpush
    @endsection
@else
    @include('adminpage.access_denied')
@endif
