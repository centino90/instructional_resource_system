<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyIfNoCourseSyllabusNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($course)
    {
        $this->course = $course;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        $date =  date('Y-m-d H:i:s');
        return (new MailMessage)
            ->greeting('Hello! ' . $notifiable->name)
            ->line("{$this->course->code} has no syllabus yet {$date}");
        // ->action('Notification Action', url('/'))
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => "There are no syllabus in {$this->course->title} ({$this->course->code}) yet.",
            'causer' => $this->course->program->users()->instructors()->first(),
            'subjectName' => 'course',
            'subject' => $this->course,
            'program' => $this->course->program,
            'link' => route('course.show', $this->course)
        ];
    }
}
