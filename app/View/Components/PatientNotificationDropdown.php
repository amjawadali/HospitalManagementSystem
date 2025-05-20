<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class PatientNotificationDropdown extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }


 public function render(): View
    {
        // Only get notifications if user is authenticated
        $unreadNotifications = Auth::user()->patient->unreadNotifications
            ? Auth::user()->patient->unreadNotifications
            : collect(); // empty collection if not logged in

         return view('components.patient-notification-dropdown', [
            'unreadNotifications' => $unreadNotifications,
        ]);
    }

}
