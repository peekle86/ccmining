<?php

namespace App\Notifications;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ResetPasswordNotification extends Notification
{
  use Queueable;

  public $token;

  public function __construct($token)
  {
    $this->token = $token;
  }

  public function via($notifiable)
  {
    return ['mail'];
  }

  public function toMail($notifiable)
  {
    $set=Setting::first();
   $teme=$set->{'email_'.\App::getLocale()};


    return (new MailMessage)
        ->subject($teme)
        ->line('You are receiving this email because we received a password reset request for your account.')
        ->action('Reset Password', url('password/reset', $this->token))
        ->line('If you did not request a password reset, no further action is required.');
  }
}
