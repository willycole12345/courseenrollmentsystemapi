<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\Course;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class ProcessCommentNotification extends Notification implements ShouldQueue
{
    use  Queueable;

    /**
     * Create a new notification instance.
     */
public $user;
public $mailData;
    public function __construct(User $user,$mailData)
    {
         
        $this->user = $user;
        $this->mailData = $mailData;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
     $coursetitle = Course::where('id',$this->mailData['course'])->first();
       return (new MailMessage)
            ->line('Hi '. $this->user->name)
            ->line('This Comment has been added to '. $coursetitle->title)
            ->line('"'.$this->mailData['message'].'"')
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
