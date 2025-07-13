<?php

namespace App\Mail;

use App\Models\Order;
use App\Repository\OrderRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Order $order)
    {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('office@playbike.ro', 'Rent a Bike Brasov'),
            subject: __('Confirmare rezervare #:order_id', ['order_id' => $this->order->id]),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $orderRepository = app()->make(OrderRepository::class);

        return new Content(
            markdown: 'mail.order_confirmation',
            with: [
                'order' => $this->order,
                'pickupDate' => $orderRepository->getOrderPickupDate($this->order),
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
