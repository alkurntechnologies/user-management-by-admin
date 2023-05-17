<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class newContactEnquiry extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $admin;
    public $details;

    public function __construct($admin,$details)
    {
        $this->admin = $admin;
        $this->details = $details;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {        

        return (new MailMessage)
            ->greeting('Hello, ' . ucfirst($this->admin->first_name) . ' ' . ucfirst($this->admin->last_name))
            ->subject(env('APP_NAME').' - New Enquiry')
            ->line("There is a new enquiry at ".env('APP_NAME').". The details are as below:")
            ->line('Name: '.$this->details['name'])
            ->line('Email: '.$this->details['email'])
            ->line('Subject: '.$this->details['subject'])
            ->line('Message: '.$this->details['message'])
            ->line('Thank you for using our website!');

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
            "message"=>"A new contact enquiry has been submitted. Please check your email.",
            'url' => ''
        ];
    }
}
