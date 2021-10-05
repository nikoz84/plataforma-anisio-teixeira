<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Services\Analytics as ReportPat;
use App\Models\User;
use App\Models\Users\AdminUser;
//use App\Services\GoogleAnalytics as ServicesGoogleAnalytics;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade as PDF;
use App\Facades\GoogleAnalyticsFacade as GoogleAnalytics;

class SendReportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reporte das últimas postagens por mês';

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
        //$carbon = Carbon::now();

        //dd($carbon->year);

        $request = new Request([
            'limit' => 100
        ]);

        $relatorios = new ReportPat($request);



        //dd($relatorios->postsPerMonth());

        $pdf = PDF::loadView(
            'relatorios.pdf-tipo-conteudo-x-mes',
            [
                'relatorio_tipo' => $relatorios->perTypeOfMidia(),
                'relatorio_mes' => $relatorios->postsPerMonth(),
                'relatorio_canal' => $relatorios->postsPerCanal(),
                'relatorio_pages' => GoogleAnalytics::getReportMostVisited(),
                'relatorio_browsers' => GoogleAnalytics::getReportBrowsers(),
                'relatorio_visitors' => GoogleAnalytics::getReportVisitors()
            ]
        )->setOptions([
            'isRemoteEnabled' => true,
            'setPapper' => 'a4'
        ]);

        $pdf->save(storage_path('app/reports/report.pdf'));

        //$users = AdminUser::get();





        //$users = User::with(['role'])->where('')

        //new ReportPat()
        /*
        $analyticsData = Analytics::performQuery(
            Period::years(1),
            'ga:pageviews',
            [
                //'metrics' => 'ga:pagePath, ga:pageTitle, ga:pageviews',
                'dimensions' => 'ga:pagePath,ga:pageTitle', //'ga:yearMonth, ga:city',
                'sort' => '-ga:pageviews',
                'max-results' => '20',
            ]
        );
        */

        //dd($analyticsData);


        dd('opk');
    }
}
