<div class="navbar-bg"></div>
@props(['notifications'])
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">
        @if (Auth::user()->role != 'Satpam')
            <li class="dropdown dropdown-list-toggle">
                <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg {{ $notifications->contains('notification_status', 0) ? 'beep' : '' }}">
                    <i class="far fa-bell"></i>
                </a>
                <div class="dropdown-menu dropdown-list dropdown-menu-right">
                    <div class="dropdown-header">Notifications
                        <div class="float-right">
                            <a href="#" id="markAllAsRead">Mark All As Read</a>
                        </div>
                    </div>
                    <div class="dropdown-list-content dropdown-list-icons" id="notifications-container">
                        @forelse ($notifications as $notification)
                            @if ($notification->notification_status == 1)
                                <a href="#" class="dropdown-item notif-read">
                                    <div class="dropdown-item-icon bg-info text-white" data-card-id="{{ $notification->id }}">
                                        <i class="fas fa-bell"></i>
                                    </div>
                                    <div class="dropdown-item-desc">
                                        {{ $notification->notification_content }}
                                        <div class="time">
                                            {{ Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                        </div>
                                    </div>
                                </a>
                            @elseif ($notification->notification_status == 0)
                                <a href="#" class="dropdown-item dropdown-item-unread notif-read" data-card-id="{{ $notification->id }}">
                                    <div class="dropdown-item-icon bg-info text-white">
                                        <i class="fas fa-bell"></i>
                                    </div>
                                    <div class="dropdown-item-desc">
                                        {{ $notification->notification_content }}
                                        <div class="time">
                                            {{ Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                        </div>
                                    </div>
                                </a>
                            @endif
                        @empty
                            <p class="text-center pt-4">Belum Ada Notifikasi</p>
                        @endforelse
                    </div>
                    <div class="dropdown-footer text-center">
                        <a href="{{ url('/admin/notifications') }}">View All <i class="fas fa-chevron-right"></i></a>
                    </div>
                </div>
            </li>
        @endif
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset('adminpage/img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">
                    Hi, {{ Auth::user()->name }}
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">Logged in</div>
                <a href="{{ url('/admin/profile') }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item has-icon text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>{{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const markAllAsReadButton = document.getElementById('markAllAsRead');

        markAllAsReadButton.addEventListener('click', function(event) {
            event.preventDefault();

            fetch('{{ route('storeNotification') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                Notiflix.Notify.success('All notifications marked as read.', {
                    timeout: 3000
                });

                location.reload();
            })
            .catch(error => {
                Notiflix.Notify.failure('Error:', error);
            });
        });

        const updateNotif = document.querySelectorAll('.notif-read');

        updateNotif.forEach(button => {
            button.addEventListener('click', function() {
                const cardId = button.dataset.cardId;

                fetch(`/readnotif/${cardId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    Notiflix.Notify.success("Data Berhasil Diperbarui", {
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
</script>
