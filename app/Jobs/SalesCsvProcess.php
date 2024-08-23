<?php

namespace App\Jobs;

use App\Models\Sale;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SalesCsvProcess implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    protected $data;
    protected $header;
    public function __construct($data, $header)
    {
        //
        $this->data = $data;
        $this->header = $header;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        
            foreach ($this->data as $sale) {
                $saleData = array_combine($this->header, $sale);
                Sale::create($saleData);
            }

            
    }
}
