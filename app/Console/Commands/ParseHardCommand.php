<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\HardwareItem;
use App\Models\HardwareType;
use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\DomCrawler\Crawler;

class ParseHardCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:hard';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $api_url = "https://proxy6.net/api/6ba5c42add-2abba51cb5-bbd3277f56/getproxy?state=active";

    protected $data = array();
    protected $settings;

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
        $this->settings = Setting::whereActive(1)->first();
        $algo = HardwareType::where('pars', 1)->get('algoritm');

        foreach ($algo as $key => $value) {
            $this->getByAlgoritm($value);
        }

        // $this->updateAll();
        //$hard = HardwareItem::first();

        //$hard = HardwareItem::where('updated_at', '<=', Carbon::now()->subHours(6)->toDateTimeString())->first();
        //$hard = HardwareItem::where('available', 1)->where('updated_at', '<=', Carbon::now()->subMinutes(3)->toDateTimeString())->get();
        // dd($hard);
        // foreach ($hard as $key => $value) {
        //     if( $value ) {
        //         try {
        //             $this->getContentOnHash($value);
        //         } catch (\Throwable $th) {
        //             //dump($th);
        //         }
        //     }
        // }


        return Command::SUCCESS;
    }

    protected function getByAlgoritm($algo)
    {
        if( $this->settings->proxy ) {
            $response_api = Http::get( $this->api_url );
            if( isset($response_api->list) ) {
                $rand_key = array_rand($response_api->list, 1);

                $proxy = $response_api->list[$rand_key];

                $response = Http::withOptions([
                    'proxy' => $proxy->type . '://' . $proxy->user . ':' . $proxy->pass . '@' . $proxy->host . ':' . $proxy->port
                ])->get('https://www.asicminervalue.com/');
            } else {
                $response = Http::get('https://www.asicminervalue.com/');
            }
        } else {
            $response = Http::get('https://www.asicminervalue.com/');
        }

        $content = $response->body();

        $crawler = new Crawler($content);
        //$crawler->addHtmlContent($content);
        //dd($crawler->filter('#datatable_profitability')->filter('tr'));

        $crawler->filter('#datatable_profitability tbody tr')->each(function (Crawler $node) use ($response, $algo) {

            $data = $this->getData($node);
            //dump($data);
            if( $data !== null ) {

                if( strtolower($algo->algoritm) == strtolower($data['algo']) ) {
                    // if (! Cache::has($data['url']) ) {
                    //     //$response = Http::get('https://www.asicminervalue.com/efficiency/'. strtolower($algo));
                    //     //Cache::put($data['url'], $response->body(), now()->addMinutes(1));
                    //     //dump('----------CACHE UPDATED------------');

                    // }
                    $this->createOrUpdate($data);
                }
                // if (! Cache::has($data['url']) ) {
                //     //$response = Http::get('https://www.asicminervalue.com/efficiency/'. strtolower($algo));
                //     Cache::put($data['url'], $response->body(), now()->addMinutes(1));
                //     dump('----------CACHE UPDATED------------');

                // }
                // $this->createOrUpdate($data);
            }


        });

    }

    // private function getDataHtml($content)
    // {
    //     $crawler = new Crawler( $content );

    //     $table = $crawler->filter('table#datatable_profitability')->filter('tr')->each(function($element) {
    //         $data = $this->dataRet($element);
    //         return $data;
    //         //dump($data);
    //         //$data = $this->dataRet($element);
    //     });
    //     // foreach ($table->filter('tr') as $key => $row) {
    //     //     //$data = $this->getData();
    //     //     $data = $this->dataRet($row->filter('td'));
    //     //     dump($data);
    //     //     //$this->createOrUpdate($data);
    //     // }
    //     // return [
    //     //     'model' => $node->filter('td')->eq(0)->attr('data-search'),
    //     //     'url' => $node->filter('td')->eq(0)->filter('a')->attr('href'),
    //     //     'hashrate' => $node->filter('td')->eq(2)->attr('data-sort'),
    //     //     'power' => $node->filter('td')->eq(3)->attr('data-sort'),
    //     //     'algo' => $node->filter('td')->eq(4)->attr('data-sort'),
    //     //     'profitability' => $node->filter('td')->eq(5)->attr('data-sort'),
    //     //     'efficiency' => $node->filter('td')->eq(6)->attr('data-sort'),
    //     // ];
    // }

    // private function dataRet( $node)
    // {
    //     return [
    //             'model' => $node->filter('td')->eq(0)->attr('data-search'),
    //             'url' => $node->filter('td')->eq(0)->filter('a')->attr('href'),
    //             'hashrate' => $node->filter('td')->eq(2)->attr('data-sort'),
    //             'power' => $node->filter('td')->eq(3)->attr('data-sort'),
    //             'algo' => $node->filter('td')->eq(4)->attr('data-sort'),
    //             'profitability' => $node->filter('td')->eq(5)->attr('data-sort'),
    //             'efficiency' => $node->filter('td')->eq(6)->attr('data-sort'),
    //         ];
    // }

    private function getContentOnHash($hard)
    {
        if( $this->settings->proxy ) {
            $response_api = Http::get( $this->api_url );
            if( $response_api->list ) {
                $rand_key = array_rand($response_api->list, 1);

                $proxy = $response_api->list[$rand_key];

                $response = Http::withOptions([
                    'proxy' => $proxy->type . '://' . $proxy->user . ':' . $proxy->pass . '@' . $proxy->host . ':' . $proxy->port
                ])->get('https://www.asicminervalue.com'.$hard->url);
            } else {
                $response = Http::get('https://www.asicminervalue.com'.$hard->url);
            }
        } else {
            $response = Http::get('https://www.asicminervalue.com'.$hard->url);
        }

        $content = $response->body();

        $crawler = new Crawler( $content );

        $container = $crawler->filter('body > .container')->first();

        $h2 = $container->filter('h2');

        $this->data['script'] = $crawler->filter('script')->last()->outerHtml();
        $h2->each(function (Crawler $node, $i) {
            $this->getTitleData($node);
        });

        $hard->description = $this->data['desc'];
        $hard->script = $this->data['script'];
        $hard->coins = $this->data['coins'];
        $hard->specification = $this->data['spec'];
        if( ! $hard->photo ) {
            if( $this->data['image'] ) {
                $hard->addMediaFromUrl( $this->data['image'] )->toMediaCollection('photo');
            }
        }
        $hard->save();

        // $data_table_tbody = $crawler->filter('#datatable_profitability tbody')->first();
        // $tr = $data_table_tbody->filter('tr');

        // $tr->each(function (Crawler $node, $i) {
        //     $this->store( $this->getData($node) );
        // });
    }

    private function getTitleData($node)
    {
        switch ($node->text()) {
            case 'Description':
                $this->data['desc'] = $node->nextAll()->text();
                $this->data['image'] = $node->closest('.col-sm-6')->filter('.image-wrap img')->image()->getUri();
                break;
            case 'Specifications':
                $this->data['spec'] = $node->nextAll()->outerHtml();
                break;
            case 'Minable coins':
                $this->data['coins'] = $node->nextAll()->outerHtml();
                break;
            default:
                # code...
                break;
        }
        // return [
        //     'model' => $node->filter('td')->eq(0)->attr('data-search'),
        //     'url' => $node->filter('td')->eq(0)->filter('a')->attr('href'),
        //     'hashrate' => $node->filter('td')->eq(2)->attr('data-sort'),
        //     'power' => $node->filter('td')->eq(3)->attr('data-sort'),
        //     'algo' => $node->filter('td')->eq(4)->attr('data-sort'),
        //     'profitability' => $node->filter('td')->eq(5)->attr('data-sort'),
        //     'efficiency' => $node->filter('td')->eq(6)->attr('data-sort'),
        // ];
    }

    private function getData($node)
    {
        $hiden_x = $node->filter('td')->eq(6)->filter('.rentability')->children()->attr('class');
        //dd($hiden_x);
        if( $hiden_x == 'hidden-xs' ) {
            $content = $node->filter('td')->eq(6)->filter('.rentability > div[data-toggle="tooltip"]')->attr('title');
            $crawler = new Crawler( $content );
            //dump($node->filter('td')->eq(0)->attr('data-search'));
            //dump($node->filter('td')->first());
            //dump($node->filter('td')->eq(6)->attr('data-sort'));
            return [
                'model' => $node->filter('td')->eq(0)->attr('data-search'),
                'url' => $node->filter('td')->eq(0)->filter('a')->attr('href'),
                'hashrate' => $node->filter('td')->eq(2)->attr('data-sort'),
                'power' => $node->filter('td')->eq(3)->attr('data-sort'),
                'algo' => $node->filter('td')->eq(5)->attr('data-sort'),
                'profitability' => floatval( substr( $crawler->filter('font[color=green]')->text(), 1 ) ),
                //'efficiency' => $node->filter('td')->eq(6)->attr('data-sort'),
            ];
        }
        return null;
    }

    // private function updateAll() {

    //     $response = Http::get('https://www.asicminervalue.com');



    //     $content = $response->body();

    //     $crawler = new Crawler( $content );

    //     $crawler->filter('#datatable_profitability tbody')->filter('tr')->each(function (Crawler $node, $i) {

    //         $data = $this->getData($node);
    //         if (! Cache::has($data['url']) ) {
    //             $response = Http::get('https://www.asicminervalue.com');
    //             Cache::put($data['url'], $response->body(), now()->addMinutes(1));
    //             dump('----------CACHE UPDATED------------');

    //         }


    //         $this->createOrUpdate($data);
    //     });

    //     //$profit_tr = $dtable_profit->filter('tr');

    //     // $profit_tr->each(function (Crawler $node, $i) {
    //     //     //dump($node);
    //     //     $data = $this->getData($node);
    //     //     // if (! Cache::has($data['url']) ) {
    //     //     //     $response = Http::get('https://www.asicminervalue.com');
    //     //     //     Cache::put($data['url'], $response->body(), now()->addMinutes(360));
    //     //     //     dump('----------CACHE UPDATED------------');
    //     //     // }

    //     //     //$this->createOrUpdate($data);
    //     // });



    // }

    private function createOrUpdate($data)
    {
        //dump($data);
        // $c1 = HardwareItem::where([
        //     'url' => $data['url']
        // ])->withTrashed()->get()->count();
        // $c2 = HardwareItem::where([
        //     'url' => $data['url']
        // ])->get()->count();
        // dump($c1, $c2);
        $hard = HardwareItem::where([
            'url' => $data['url']
        ])->first(); //where('available', 1)->where('updated_at', '<=', Carbon::now()->subHours(3)->toDateTimeString())->first();
            //dd($data,$hard);
        if( $hard ) {
            $hard->profitability = $data['profitability'];
            $hard->save();

            //$all = HardwareItem::all();

            // foreach ($all as $key => $value) {
            //     $value->profitability = $data['profitability'];
            //     $value->save();
            // }

        } else {

            $type = HardwareType::where('algoritm', strtoupper($data['algo']))->first();

            if( !$type ) {
                $type = HardwareType::create([
                    'algoritm' => strtoupper($data['algo']),
                    'name' => $data['algo']?? ''
                ]);
            }


            try {
                $hard = HardwareItem::create([
                    'model' => $data['model'],
                    'url' => $data['url'],
                    'hashrate' => $data['hashrate'],
                    'power' => $data['power'],
                    'profitability' => $data['profitability'],
                    'algoritm_id' => $type->id,
                    'price' => 0
                ]);
                $this->getContentOnHash($hard);

            } catch (\Throwable $th) {
                //throw $th;
            }


            //$all = HardwareItem::all();

            // foreach ($all as $key => $value) {
            //     $value->profitability = $data['profitability'];
            //     $value->save();
            // }


        }

    }
}
