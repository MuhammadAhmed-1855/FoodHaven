<?php

namespace App\Http\Controllers\ThirdParty\GoogleAuthentication;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Analytics\Analytics;
use Spatie\Analytics\Period;

class AnalysisController extends Controller
{
    public function analysis()
    {
        $users = User::all();
        $analyticsData = Analytics::fetchVisitorsAndPageViews(Period::days(7));
        echo $analyticsData;
    }
}

?>