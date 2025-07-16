<?php

namespace App\Mail;

use App\Models\Order;
use App\Repository\OrderRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewReservation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('contact@rentabikebrasov.ro', 'Rent a Bike Brasov'),
            subject: __('Rezervare noua'),
        );
    }

    public function content(): Content
    {
        $orderRepository = app()->make(OrderRepository::class);

        return new Content(
            markdown: 'mail.new_rezervation',
            with: [
                'order' => $this->order,
                'pickupDate' => $orderRepository->getOrderPickupDate($this->order),
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
