<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AppointmentApprovalNotification extends Notification
{
    // Removed: use Illuminate\Bus\Queueable;
    // Removed: implements ShouldQueue
    // Removed: use Queueable;

    protected $status;
    protected $appointmentId;

    public function __construct($status, $appointmentId)
    {
        $this->status = $status;
        $this->appointmentId = $appointmentId;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $statusMessage = $this->status === 'approved'
            ? 'Your appointment has been approved.'
            : 'Your appointment has been rejected.';

        return (new MailMessage)
            ->subject('Appointment Status Updated')
            ->line($statusMessage)
            ->action('View Appointment', url('/appointments/' . $this->appointmentId))
            ->line('Thank you for using our application!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->status === 'approved'
                ? 'Your appointment was approved.'
                : 'Your appointment was rejected.',
            'appointment_id' => $this->appointmentId,
            'status' => $this->status,
        ];
    }
}
