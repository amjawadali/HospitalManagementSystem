<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class NotificationDropdown extends Component
{
    public function render(): View
    {
        // Only get notifications if user is authenticated
        $unreadNotifications = Auth::user()->doctor->unreadNotifications
            ? Auth::user()->doctor->unreadNotifications
            : collect(); // empty collection if not logged in

        return view('components.notification-dropdown', [
            'unreadNotifications' => $unreadNotifications,
        ]);
    }
}
