<li class="dropdown dropdown-list-toggle">
    <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg">
        <i data-feather="bell" class="bell"></i>
        @if ($unreadNotifications->count())
            <span class="badge badge-danger badge-notification">{{ $unreadNotifications->count() }}</span>
        @endif
    </a>

    <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
        <div class="dropdown-header">
            Notifications
            <div class="float-right">
                <a href="#">Mark All As Read</a>
            </div>
        </div>

        <div class="dropdown-list-content dropdown-list-icons">
            @forelse($unreadNotifications as $notification)
                <a href="#" class="dropdown-item dropdown-item-unread">
                    <span class="dropdown-item-icon bg-primary text-white">
                        <i class="fas fa-calendar-check"></i>
                    </span>
                    <span class="dropdown-item-desc">
                        {{ $notification->data['message'] ?? 'You have a new notification.' }}
                        <span class="time">{{ $notification->created_at->diffForHumans() }}</span>
                    </span>
                </a>
            @empty
                <span class="dropdown-item text-center">No new notifications</span>
            @endforelse
        </div>

        <div class="dropdown-footer text-center">
            <a href="#">View All <i class="fas fa-chevron-right"></i></a>
        </div>
    </div>
</li>
