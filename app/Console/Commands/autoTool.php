<?php

namespace App\Console\Commands;

use App\Helpers\Functions;
use App\Constants\DefineCode;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Log;

class autoTool extends Command
{
    use Functions;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:auto-tool';

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
            // $userInfo = $this->getInfoUser(DefineCode::COOKIE);
            // $userBankList = $this->getUserBankList(DefineCode::COOKIE);
            // $result = $this->getResult(DefineCode::MB45S_LOTTERY_ID);
            // $listResultMb45s = $this->getListResult(DefineCode::MB45S_LOTTERY_ID);
            // $this->combatMb45s(DefineCode::PLAY_ODD);

            // $number4 = $result['data']['open_numbers_formatted'][3];
            // $number5 = $result['data']['open_numbers_formatted'][4];
            // if($number4 == '0' && $number5 == '0') {
            //     dd('in');
            // }
            // dd($number4, $number5);

            $this->start();

            return 0;
        } catch (\Throwable $th) {
            $message = "Có lỗi xảy ra: " . $th->getMessage() . ", dòng: " . $th->getLine() . ", file: " . $th->getFile();
            $this->sendNotificationTelegram($message);
            Log::error("Có lỗi xảy ra: {$th->getMessage()}, dòng: {$th->getLine()}, file: {$th->getFile()}");
        }
    }
}
