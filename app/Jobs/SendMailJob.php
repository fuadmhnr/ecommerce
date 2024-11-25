<?php

namespace App\Jobs;

use App\Mail\OrderCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailJob implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    protected string $firstName;
    protected string $lastName;
    protected string $email;
    protected ?int $orderId;
    protected ?string $status;
    protected array $items;

    /**
     * Create a new job instance.
     */
    public function __construct(
        string $firstName,
        string $lastName,
        string $email,
        ?int $orderId = null,
        ?string $status = null,
        array $items = []
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->orderId = $orderId;
        $this->status = $status;
        $this->items = $items;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->email)->send(new OrderCreated(
            $this->firstName,
            $this->lastName,
            $this->status,
            $this->orderId,
            $this->items
        ));
    }
}
