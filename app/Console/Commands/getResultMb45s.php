<?php

namespace App\Console\Commands;

use App\Helpers\Functions;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class getResultMb45s extends Command
{
    use Functions;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:mb45s';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'get result mb45s';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            // $userInfo = $this->getInfoUser();
            // $userBankList = $this->getUserBankList();
            // $listResultMb45s = $this->getListResultMb45s(1,5);
            $this->sendNotificationTelegram('45s');
            return 0;
        } catch (\Throwable $th) {
            $message = "Có lỗi xảy ra: " . $th->getMessage() . ", dòng: " . $th->getLine() . ", file: " . $th->getFile();
            $this->sendNotificationTelegram($message);
            Log::error("Có lỗi xảy ra: {$th->getMessage()}, dòng: {$th->getLine()}, file: {$th->getFile()}");
        }
    }
}
