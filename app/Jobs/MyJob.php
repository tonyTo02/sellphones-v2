<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $timeout = 300; //seconds
    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }
    /**
     * Chỉ định thời điểm job hết hạn (sau 5 phút).
     *
     * @return \DateTime
     */
    public function retryUntil()
    {
        // Job sẽ hết hạn sau 5 phút kể từ khi được dispatch
        return now()->addMinutes(5);
    }

    /**
     * Xử lý khi job thất bại.
     *
     * @param Exception $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        // Thực hiện logic khi job thất bại, ví dụ ghi log hoặc gửi thông báo
        // Job sẽ bị xóa sau khi thất bại nếu cấu hình thế này
        $this->delete();
    }
}
