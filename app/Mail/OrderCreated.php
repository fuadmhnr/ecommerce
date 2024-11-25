<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    protected string $firstName;
    protected string $lastName;
    protected string $status;
    protected ?int $orderId;
    protected array $items;


    public function __construct(string $firstName, string $lastName, string $status, ?int $orderId, array $items)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->status = $status;
        $this->orderId = $orderId;
        $this->items = $items;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Created',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.order-created',
            with: [
                'firstName' => $this->firstName,
                'lastName' => $this->lastName,
                'status' => $this->status,
                'orderNumber' => $this->orderId,
                'items' => $this->items,
                'orderUrl' => url("/orders/{$this->orderId}"),
                'invoiceUrl' => url("/orders/{$this->orderId}/invoice"),
                'companyName' => 'Ecommerce',  // You can make this dynamic if needed
                'updateUrl' => url("/orders/{$this->orderId}/update"),
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
