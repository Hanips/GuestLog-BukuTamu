@if (Auth::user()->role != 'Pengguna')

    @extends('adminpage.index')

    @section('title_page', 'Ubah Password')

    @section('content')
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Ubah Password</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="{{ url('/admin') }}">Dashboard</a></div>
                        <div class="breadcrumb-item active"><a href="{{ url('/admin/profile') }}">Profil</a></div>
                        <div class="breadcrumb-item">Ubah Password</div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <form method="POST" action="{{ route('profile.updatePassword') }}" id="changePasswordForm">
                                    @csrf
                                    @method('PUT')
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="current_password" class="form-label">Password Saat Ini</label>
                                                    <input class="form-control @error('current_password') is-invalid @enderror" name="current_password" id="current_password" type="password" required />
                                                    @error('current_password')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="new_password" class="form-label">Password Baru</label>
                                                    <input class="form-control @error('new_password') is-invalid @enderror" name="new_password" id="new_password" type="password" required />
                                                    @error('new_password')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="new_password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                                    <input class="form-control @error('new_password_confirmation') is-invalid @enderror" name="new_password_confirmation" id="new_password_confirmation" type="password" required />
                                                    @error('new_password_confirmation')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="card-footer text-left">
                                                <button class="btn btn-primary" type="submit">Ubah Password</button>
                                                <a href="{{ route('profile.edit') }}" class="btn btn-danger">Batal</a>
                                            </div>
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
