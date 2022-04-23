<?php

namespace App\Http\Controllers;

use App\Disease;
use App\Resident;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatisticsController extends Controller
{
    public function index () {
        $current_user = User::find(Auth::user()->id);

        $diseases = Disease::where('is_active', 1)->get();
        $disease_id = 0;
        $injected = '';

        if ($current_user->can('viewAny', User::class)) {
            $residents = Resident::where('is_active', 1)->get();
        } else {
            $residents = Resident::where([['is_active', '=', 1], ['ward_id', '=', $current_user->belongsToRole->ward_id]])->get();
        }

        if (!empty(request()->query('disease'))) {
            $disease_id = request()->query('disease');

            $query = Resident::selectRaw('residents.id, floor(datediff (now(), residents.date_of_birth)/365) as age')
            ->join('injections', 'injections.resident_id', '=', 'residents.id')
            ->join('packs', 'packs.id', '=', 'injections.pack_id')
            ->join('vaccines', 'vaccines.id', '=', 'packs.vaccine_id')
            ->join('vaccine_disease', 'vaccines.id', '=', 'vaccine_disease.vaccine_id')
            ->where([['vaccine_disease.disease_id', '=', $disease_id], ['residents.is_active', '=', 1]]);

            if (!$current_user->can('viewAny', User::class)) {
                $query->where([['residents.ward_id', '=', $current_user->belongsToRole->ward_id]]);
            }

            $injected = $query->get();
        }

        $injected_count = (empty($injected)) ? 0 : $injected->count();

        $not_injected = $residents->count() - $injected_count;

        $html_statistic1 = "['Đã tiêm', ".$injected_count."], ['Chưa tiêm', ".$not_injected."]";

        $age_65 = 0;
        $age_18_65 = 0;
        $age_12_17 = 0;
        $age_5_11 = 0;
        $check = 0;

        if ($injected_count > 0) {
            foreach ($injected as $item) {
                if ($item->age >= 65) {
                    $age_65++;
                    $check++;
                }

                if ($item->age < 65 && $item->age >= 18) {
                    $age_18_65++;
                    $check++;
                }

                if ($item->age < 18 && $item->age >= 12) {
                    $age_12_17++;
                    $check++;
                }

                if ($item->age < 12 && $item->age >= 5) {
                    $age_5_11++;
                    $check++;
                }
            }
        }

        if ($check != 0) {
            $html_statistic2 = "['Trên 65 tuổi', ".$age_65."], ['Từ 18 đến 64 tuổi', ".$age_18_65."], ['Từ 12 đến 17 tuổi', ".$age_12_17."], ['Từ 5 đến 11 tuổi', ".$age_5_11."]";
        } else {
            $html_statistic2 = "['Chưa chọn dịch bệnh', 10]";
        }
        
        return view ("admin.statistic.index", [
            'diseases' => $diseases,
            'disease' => $disease_id,
            'html_statistic1' => $html_statistic1,
            'html_statistic2' => $html_statistic2,
        ]);
    }
}
