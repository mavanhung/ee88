<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\Functions;

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
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env('EE88_URL').'/server/lottery/drawResult?lottery_id=47&page=1&limit=10&date=',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Cookie: PHPSESSID=gb9kip2ef8gdtu4lceuvrkcoth; think_var=en'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        dd(json_decode($response)->data->list[0]->issue);

        return 0;
    }
}
