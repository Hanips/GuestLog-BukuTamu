@if (Auth::user()->role != 'Pengguna' && Auth::user()->role != 'Satpam')
    @extends('adminpage.index')

    @section('title_page', 'Edit Pengguna')

    @section('content')
        <div class="main-content">
            <section class="section">
                <div class="section-header">
                    <h1>Edit Pengguna</h1>
                    <div class="section-header-breadcrumb">
                        <div class="breadcrumb-item active"><a href="{{ url('/admin') }}">Dashboard</a></div>
                        <div class="breadcrumb-item active"><a href="{{ url('/admin/account/user') }}">Data Pengguna</a></div>
                        <div class="breadcrumb-item">Edit Pengguna</div>
                    </div>
                </div>

                <div class="section-body">
                    <h2 class="section-title">Edit Pengguna</h2>
                    <p class="section-lead">Silakan ubah formulir pengguna di bawah ini.</p>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Form Edit Pengguna</h4>
                                </div>
                                <form method="POST" action="{{ route('user.update', $row->id) }}" id="editUserForm" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="name" class="form-label">Nama</label>
                                                    <input class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $row->name) }}" id="name" type="text" placeholder="Nama" required />
                                                    @error('name')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $row->email) }}" id="email" type="text" placeholder="Email" required />
                                                    @error('email')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="role" class="form-label">Role</label>
                                                    <select class="form-control select2 @error('role') is-invalid @enderror" name="role" id="role" required>
                                                        <option value="">-- Pilih Role --</option>
                                                        @foreach ($roles as $role)
                                                            <option value="{{ $role }}" {{ $role == old('role', $row->role) ? 'selected' : '' }}>{{ $role }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('role')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="card-footer text-left">
                                                <button class="btn btn-primary" type="submit">Simpan</button>
                                                <a href="{{ url('/admin/account/user') }}" class="btn btn-danger">Batal</a>
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
                    const editForm = document.getElementById('editUserForm');

                    editForm.addEventListener('submit', async function (event) {
                        event.preventDefault();

                        const formData = new FormData(editForm);
                        const url = editForm.getAttribute('action');
                        const method = editForm.getAttribute('method');
                        
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
                                location.href = '{{ route('user.index') }}';
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            Notiflix.Notify.failure('Terjadi kesalahan dalam mengirim data.', {
                                timeout: 3000
                            });
                        }
                    });
                });
            </script>
        @endpush
    @endsection
@else
    @include('adminpage.access_denied')
@endif
