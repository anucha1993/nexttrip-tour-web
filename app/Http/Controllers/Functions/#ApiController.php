<?php
namespace App\Http\Controllers\Functions;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use ReallySimpleJWT\Token;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Webpanel\LogsController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Intervention\Image\ImageManagerStatic as Image;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\DB;

use App\Models\Backend\TourModel;
use App\Models\Backend\TourGroupModel;
use App\Models\Backend\TourTypeModel;
use App\Models\Backend\TourDetailModel;
use App\Models\Backend\TourPeriodModel;

use App\Models\Backend\LandmassModel;
use App\Models\Backend\CountryModel;
use App\Models\Backend\CityModel;
use App\Models\Backend\ProvinceModel;
use App\Models\Backend\DistrictModel;
use App\Models\Backend\TravelTypeModel;
use App\Models\Backend\PromotionModel;
use App\Models\Backend\TourGalleryModel;

class ApiController extends Controller
{
    public function package_tour(){
        
        // echo ini_get('allow_url_fopen');

        $this->zego_api();
        $this->bestconsortium_api();
        $this->ttn_api();

        date_default_timezone_set("Asia/Bangkok");
        $data['datetime'] = date('Y-m-d H:i:s');
        DB::table('tb_cronjob')->insert($data);

    }

    // $this->probooking_api();
    // $this->checkingroup_api();
    // $this->superbholiday_api();

    public function zego_api(){

        try {
            \DB::beginTransaction();
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                "auth-token" => "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJfaWQiOiI2NDkxYTQ5ODFmM2RkMDJlMTQwNTAxNjciLCJpYXQiOjE2ODczMTU0OTh9.2WqkXy-a4DVktevsWrH0U_v9BRcvDnJg2-QNkzgNVfU",
            ])
            ->get('https://www.zegoapi.com/v1.1/Lists/ProgramTour');
            $callback = $response->json();

            if(count($callback) > 0){
                $tour = array();
                $tour_api_id = array();
                $period = array();
                $period_api_id = array();
                foreach($callback as $call){
                    // if($call['programtour_id'] == 968){
                        
                    $data = TourModel::where(['api_id'=>$call['programtour_id'], 'api_type'=>'zego'])->whereNull('deleted_at')->first();

                    $allow_img = ['png', 'jpeg', 'jpg','webp'];

                    if($data == null){
                        $data = new TourModel;

                        $code_tour = IdGenerator::generate([
                            'table' => 'tb_tour', 
                            'field' => 'code', 
                            'length' => 10, 
                            'prefix' =>'NT'.date('ym'),
                            'reset_on_prefix_change' => true 
                        ]);

                        $data->code = $code_tour;

                        if($call['Country']){
                            $country = CountryModel::where('country_name_en', 'like', '%'.$call['Country'].'%')->whereNull('deleted_at')->first();
                            $arr = array();
                            if($country){
                                $arr[] = "$country->id";
                                $data->country_id = json_encode($arr);
                            }else{
                                $data->country_id = "[]";
                            }
                        }

                        if($call['Airline']){
                            $airline = TravelTypeModel::where('code',$call['Airline'])->whereNull('deleted_at')->first();
                            if($airline){
                                $data->airline_id = $airline->id;
                            }
                        }

                        if ($call['UrlImage']) {
    
                            $path = $call['UrlImage'];
                            $filename = basename($path);
    
                            $lg = Image::make($path);
                            $ext = explode("/", $lg->mime());
                            $lg->resize(600, 600)->stream();
                            // $lg->resize(784, 522)->stream();
                            
                            $new = 'upload/tour/zegoapi/' . $filename;
                            // $new = 'upload/tour/zegoapi/' . date('dmY-Hism') . '.' . $ext[1];
                            
                            if (in_array($ext[1], $allow_img)) {
                                Storage::disk('public')->put($new, $lg);
                                $data->image = $new;
                            }
                        }

                        $data->image_check_change = 2; // 1 ไม่ดึงรูปจาก Api , 2 ดึงรูปจาก Api
                        $data->name = $call['ProductName'];
                        $data->rating = $call['HotelStar'];
                        $data->description = str_replace("\n","",$call['Highlight']);

                    }else{
                        if($data->country_check_change == null){
                            if($call['Country']){
                                $country = CountryModel::where('country_name_en', 'like', '%'.$call['Country'].'%')->whereNull('deleted_at')->first();
                                $arr = array();
                                if($country){
                                    $arr[] = "$country->id";
                                    $data->country_id = json_encode($arr);
                                }else{
                                    $data->country_id = "[]";
                                }
                            }
                        }

                        if($data->airline_check_change == null){
                            if($call['Airline']){
                                $airline = TravelTypeModel::where('code',$call['Airline'])->whereNull('deleted_at')->first();
                                if($airline){
                                    $data->airline_id = $airline->id;
                                }
                            }
                        }

                        if($data->name_check_change == null){
                            $data->name = $call['ProductName'];
                        }

                        if($data->description_check_change == null){
                            $data->description = str_replace("\n","",$call['Highlight']);
                        }

                        if($data->image_check_change == 2){
                            if ($call['UrlImage']) {

                                if ($data->image != null) {
                                    Storage::disk('public')->delete($data->image);
                                }
        
                                $path = $call['UrlImage'];
                                $filename = basename($path);
        
                                $lg = Image::make($path);
                                $ext = explode("/", $lg->mime());
                                $lg->resize(600, 600)->stream();
                                
                                $new = 'upload/tour/zegoapi/' . $filename;
                                
                                if (in_array($ext[1], $allow_img)) {
                                    Storage::disk('public')->put($new, $lg);
                                    $data->image = $new;
                                }
    
                            }
                        }

                    }

                    $data->api_id = $call['programtour_id'];
                    $data->code1 = $call['ProductCode'];

                    // จัดการ wholesale_id ให้เป็น zego
                    $data->group_id = 3;
                    $data->wholesale_id = 3;

                    $allow_word = ['doc', 'docx'];
                    $allow_pdf = ['pdf'];

                    // if ($call['FileWord']) {
                    //     $url = $call['FileWord'];

                    //     $response = Http::get($url);

                    //     if ($response->successful()) {

                    //         if ($data->word_file != null) {
                    //             Storage::disk('public')->delete($data->word_file);
                    //         }
    
                    //         $filename = basename($url);
                    //         $ext = explode(".", $filename);
                    //         $new = 'upload/tour/word_file/zegoapi/' . $filename;
    
                    //         if (in_array($ext[1], $allow_word)) {
                    //             Storage::disk('public')->put($new, $response->body());
                    //             $data->word_file = $new;
                    //         }
                    //     }
                    // }

                    if ($call['FilePDF']) {
                        $url = $call['FilePDF'];

                        $response = Http::get($url);

                        if ($response->successful()) {

                            if ($data->pdf_file != null) {
                                Storage::disk('public')->delete($data->pdf_file);
                            }
    
                            $filename = basename($url);
                            $ext = explode(".", $filename);
                            $new = 'upload/tour/pdf_file/zegoapi/' . $filename;
    
                            if (in_array($ext[1], $allow_pdf)) {
                                Storage::disk('public')->put($new, $response->body());
                                $data->pdf_file = $new;
                            }
                        }
                    }

                    $data->data_type = 2; // 1 system , 2 api
                    $data->api_type = "zego";

                    if($data->save()){

                        $tour[] = $data->id;
                        $tour_api_id[] = $data->api_id;
                        
                        if($call['Periods']){
                            $max = array();
                            $cal1 = 0;
                            $cal2 = 0;
                            $cal3 = 0;
                            $cal4 = 0;
                            foreach($call['Periods'] as $pe){

                                // มาปรับแก้ให้สวย ๆ ได้อีก // ตอนนี้ต้องเช็ค $data->id ด้วยเผื่อ period_api_id ชนกันเพราะยิงหลาย api
                                $data3 = TourPeriodModel::where(['tour_id'=>$data->id, 'period_api_id'=>$pe['PeriodID'], 'api_type'=>'zego'])->whereNull('deleted_at')->first();

                                $price1 = $pe['Price_Twin']; // ผู้ใหญ่พักคู่
                                $price2 = $pe['Price_Single']; //ผู้ใหญ่พักเดี่ยว
                                $price3 = $pe['Price_Child']; // เด็กมีเตียง
                                $price4 = $pe['Price_ChildNB']; // เด็กไม่มีเตียง


                                if($data3 == null){
                                    $data3 = new TourPeriodModel;
                                    $data3->price1 = $price1;
                                    $data3->price2 = $price2;
                                    $data3->price3 = $price3;
                                    $data3->price4 = $price4;
                                }else{
                                    if($data3->price1 != $price1){
                                        $cal = $data3->price1 - $price1;
                                        if($cal > 0){
                                            $data3->old_price1 = $data3->price1;
                                            $data3->price1 = $price1;
                                            if($cal < $price1){
                                                $data3->special_price1 = $cal;
                                            }else{
                                                $data3->special_price1 = 0;
                                            }
                                            // $cal1 = ($cal / $price1) * 100;
                                            if (isset($price1) && $price1 != 0) {
                                                $cal1 = ($cal / $price1) * 100;
                                            } else {
                                                $cal1 = 0;
                                            }
                                            
                                        }else{
                                            $data3->old_price1 = 0.00;
                                            $data3->price1 = $price1;
                                            $data3->special_price1 = 0.00;
                                            $cal1 = 0;
                                        }
                                    }

                                    // ราคาผู้ใหญ่ พักเดี่ยว ไม่ต้องคำนวณเปอเซ็นต์ส่วนลด
                                    $data3->old_price2 = 0.00;
                                    $data3->price2 = $price2;
                                    $data3->special_price2 = 0.00;
                                    $cal2 = 0;

                                    // if($data3->price2 != $price2){
                                    //     $cal = $data3->price2 - $price2;
                                    //     if($cal > 0){
                                    //         $data3->old_price2 = $data3->price2;
                                    //         $data3->price2 = $price2;
                                    //         $data3->special_price2 = $cal;
                                    //         $total = $price1 + $price2; // เอายอด ผู้ใหญ่ พักคู่ บวก พักเดี่ยว
                                    //         // $cal2 = ($cal / $total) * 100;
                                    //         if (isset($price2) && $price2 != 0) {
                                    //             $cal2 = ($cal / $price2) * 100;
                                    //         } else {
                                    //             $cal2 = 0;
                                    //         }
                                    //     }else{
                                    //         $data3->old_price2 = 0.00;
                                    //         $data3->price2 = $price2;
                                    //         $data3->special_price2 = 0.00;
                                    //         $cal2 = 0;
                                    //     }
                                    // }

                                    if($data3->price3 != $price3){
                                        $cal = $data3->price3 - $price3;
                                        if($cal > 0){
                                            $data3->old_price3 = $data3->price3;
                                            $data3->price3 = $price3;
                                            $data3->special_price3 = $cal;
                                            if($cal < $price3){
                                                $data3->special_price3 = $cal;
                                            }else{
                                                $data3->special_price3 = 0;
                                            }
                                            // $cal3 = ($cal / $price3) * 100;
                                            if (isset($price3) && $price3 != 0) {
                                                $cal3 = ($cal / $price3) * 100;
                                            } else {
                                                $cal3 = 0;
                                            }
                                        }else{
                                            $data3->old_price3 = 0.00;
                                            $data3->price3 = $price3;
                                            $data3->special_price3 = 0.00;
                                            $cal3 = 0;
                                        }
                                    }

                                    if($data3->price4 != $price4){
                                        $cal = $data3->price4 - $price4;
                                        if($cal > 0){
                                            $data3->old_price4 = $data3->price4;
                                            $data3->price4 = $price4;
                                            $data3->special_price4 = $cal;
                                            if($cal < $price4){
                                                $data3->special_price4 = $cal;
                                            }else{
                                                $data3->special_price4 = 0;
                                            }
                                            // $cal4 = ($cal / $price4) * 100;
                                            if (isset($price4) && $price4 != 0) {
                                                $cal4 = ($cal / $price4) * 100;
                                            } else {
                                                $cal4 = 0;
                                            }
                                        }else{
                                            $data3->old_price4 = 0.00;
                                            $data3->price4 = $price4;
                                            $data3->special_price4 = 0.00;
                                            $cal4 = 0;
                                        }
                                    }
                                }

                                $data3->tour_id = $data->id;
                                $data3->period_api_id = $pe['PeriodID'];
                                $data3->group_date = date('mY',strtotime($pe['PeriodStartDate']));
                                $data3->start_date = $pe['PeriodStartDate'];
                                $data3->end_date = $pe['PeriodEndDate'];
                                $data3->day = $pe['Day'];
                                $data3->night = $pe['Night'];
                                $data3->group = $pe['Groupsize'];
                                $data3->count = $pe['Seat'];

                                if($pe['Status'] == "Book"){
                                    $data3->status_period = 1;
                                }else if($pe['Status'] == "Waitlist"){
                                    $data3->status_period = 2;
                                }else if($pe['Status'] == "Close group" || $pe['Status'] == "Soldout"){
                                    $data3->status_period = 3;
                                }
                                $data3->api_type = "zego";

                                if($data3->save()){
                                    $period[] = $data3->id;
                                    $period_api_id[] = $data3->period_api_id;
                                }
                                
                                $calmax = max($cal1, $cal2, $cal3, $cal4);
                                array_push($max, $calmax);
                            }

                            // บันทึกจำนวนวัน และ ราคาเข้าไป tb_tour
                            $data4 = TourPeriodModel::where(['tour_id'=>$data->id, 'api_type'=>'zego'])->whereNull('deleted_at')->orderby('start_date','asc')->first(); // asc
                            if($data4){
                                $num_day = "";
                                if($data4->day && $data4->night){
                                    $num_day = $data4->day.' วัน '.$data4->night.' คืน';
                                }
                                $price = $data4->price1;
                                $special_price = $data4->special_price1;
                                // if($data4->special_price1 > 0){
                                //     $special_price = $price - $data4->special_price1;
                                // }else{
                                //     $special_price = 0.00;
                                // }

                                if($special_price && $special_price > 0){
                                    $net_price = $price - $special_price;
                                }else{
                                    $net_price = $price;
                                }

                                if($net_price && $net_price > 0){
                                    if($net_price <= 10000 ){
                                        $price_group = 1;
                                    }else if($net_price  > 10000 && $net_price <= 20000  ){
                                        $price_group = 2;
                                    }else if($net_price  > 20000 && $net_price <= 30000  ){
                                        $price_group = 3;
                                    }
                                    else if($net_price  > 30000 && $net_price <= 50000  ){
                                        $price_group = 4;
                                    }
                                    else if($net_price  > 50000 && $net_price <= 80000  ){
                                        $price_group = 5;
                                    }else if($net_price  > 80000  ){
                                        $price_group = 6;
                                    }
                                }else{
                                    $price_group = 0;
                                }
                                TourModel::where(['id'=>$data->id, 'api_type'=>'zego'])->update(['num_day'=> $num_day,'price'=> $price,'price_group' => $price_group,'special_price'=> $special_price]);
                            }

                            $maxCheck = max($max);
                            if($maxCheck > 0 && $maxCheck >= 30){
                                TourModel::where(['id'=>$data->id, 'api_type'=>'zego'])->update(['promotion1'=>'Y','promotion2'=>'N']); // เป็นโปรไฟไหม้
                            }elseif($maxCheck > 0 && $maxCheck < 30){
                                TourModel::where(['id'=>$data->id, 'api_type'=>'zego'])->update(['promotion1'=>'N','promotion2'=>'Y']); // เป็นโปรธรรมดา
                            }else{
                                TourModel::where(['id'=>$data->id, 'api_type'=>'zego'])->update(['promotion1'=>'N','promotion2'=>'N']); // ไม่เป็นโปรโมชั่น
                            }

                        }

                        \DB::commit();
                    }else{
                        \DB::rollback();
                    }

                    // } // endif $call['programtour_id']
                    
                } // end foreach
                
                // ลบข้อมูลทัวร์ และ Period
                TourModel::whereNotIn('id',$tour)->whereNotIn('api_id',$tour_api_id)->where('api_type','zego')->update(['deleted_at'=>date('Y-m-d H:i:s')]);
                TourModel::whereIn('id',$tour)->whereIn('api_id',$tour_api_id)->where('api_type','zego')->update(['deleted_at'=>null]);
                TourPeriodModel::whereNotIn('id',$period)->whereNotIn('period_api_id',$period_api_id)->where('api_type','zego')->update(['deleted_at'=>date('Y-m-d H:i:s')]);
                TourPeriodModel::whereIn('id',$period)->whereIn('period_api_id',$period_api_id)->where('api_type','zego')->update(['deleted_at'=>null]);
                
            }

        } catch (\Exception $e) {
            \DB::rollback();
            // dd($e->getLine(),$e->getMessage());
            $error_log = $e->getMessage();
            $error_line = $e->getLine();
            $type_log = 'backend';
            $error_url = url()->current();
            $log_id = LogsController::save_logbackend($type_log, $error_log, $error_line, $error_url);

            // return view("$this->prefix.alert.alert", [
            //     'url' => $error_url,
            //     'title' => "เกิดข้อผิดพลาดทางโปรแกรม",
            //     'text' => "กรุณาแจ้งรหัส Code : $log_id ให้ทางผู้พัฒนาโปรแกรม ",
            //     'icon' => 'error'
            // ]);
        }
    }

    public function bestconsortium_api(){ // status_period ลูกค้าแจ้งมาให้เอง

        try {
            \DB::beginTransaction();
            // $dateGo = '2023-10-28';
            // $dateGo = '2023-10-29';
            // $day = \Carbon\Carbon::parse($dateGo)->diffInDays(\Carbon\Carbon::parse($dateBack));
            // $night = $day-1;

            // dd($day,$night);
            
            $response = Http::withHeaders([
                "Content-Type" => "application/json; charset=UTF-8",
            ])
            ->get('https://api.best-consortium.com/v1/series/country');
            $callback1 = $response->json();

            if(count($callback1) > 0){
                $tour = array();
                $tour_api_id = array();
                $period = array();
                $period_api_id = array();
                foreach($callback1 as $call1){
                    $response = Http::withHeaders([
                        "Content-Type" => "application/json; charset=UTF-8",
                    ])
                    ->get('https://api.best-consortium.com/v1/series/'.$call1['id']);
                    $callback2 = $response->json(); 

                    foreach($callback2 as $call2){
                                
                        $data = TourModel::where(['api_id'=>$call2['id'], 'api_type'=>'best'])->whereNull('deleted_at')->first();

                        $allow_img = ['png', 'jpeg', 'jpg','webp'];

                        if($data == null){
                            $data = new TourModel;

                            $code_tour = IdGenerator::generate([
                                'table' => 'tb_tour', 
                                'field' => 'code', 
                                'length' => 10, 
                                'prefix' =>'NT'.date('ym'),
                                'reset_on_prefix_change' => true 
                            ]);

                            $data->code = $code_tour;

                            if($call1['nameEng']){
                                $country = CountryModel::where('country_name_en', 'like', '%'.$call1['nameEng'].'%')->whereNull('deleted_at')->first();
                                $arr = array();
                                if($country){
                                    $arr[] = "$country->id";
                                    $data->country_id = json_encode($arr);
                                }else{
                                    $data->country_id = "[]";
                                }
                            }

                            if($call2['airline']){
                                $airline = TravelTypeModel::where('code',$call2['airline'])->whereNull('deleted_at')->first();
                                if($airline){
                                    $data->airline_id = $airline->id;
                                }
                            }

                            if ($call2['bannerSq']) {
        
                                $path = $call2['bannerSq'];
                                $filename = basename($path);
        
                                $lg = Image::make($path);
                                $ext = explode("/", $lg->mime());
                                $lg->resize(600, 600)->stream();
                                
                                $new = 'upload/tour/bestapi/' . $filename;
                                
                                if (in_array($ext[1], $allow_img)) {
                                    Storage::disk('public')->put($new, $lg);
                                    $data->image = $new;
                                }
                            }

                            $data->image_check_change = 2; // 1 ไม่ดึงรูปจาก Api , 2 ดึงรูปจาก Api
                            $data->name = $call2['name'];
                            // $data->description = str_replace("\n","",$call2['Highlight']); // ไม่มี

                        }else{
                            if($data->country_check_change == null){
                                if($call1['nameEng']){
                                    $country = CountryModel::where('country_name_en', 'like', '%'.$call1['nameEng'].'%')->whereNull('deleted_at')->first();
                                    $arr = array();
                                    if($country){
                                        $arr[] = "$country->id";
                                        $data->country_id = json_encode($arr);
                                    }else{
                                        $data->country_id = "[]";
                                    }
                                }
                            }

                            if($data->airline_check_change == null){
                                if($call2['airline']){
                                    $airline = TravelTypeModel::where('code',$call2['airline'])->whereNull('deleted_at')->first();
                                    if($airline){
                                        $data->airline_id = $airline->id;
                                    }
                                }
                            }

                            if($data->name_check_change == null){
                                $data->name = $call2['name'];
                            }

                            // if($data->description_check_change == null){ // ไม่มี
                            //     $data->description = str_replace("\n","",$call2['Highlight']);
                            // }

                            if($data->image_check_change == 2){
                                if ($call2['bannerSq']) {

                                    if ($data->image != null) {
                                        Storage::disk('public')->delete($data->image);
                                    }
            
                                    $path = $call2['bannerSq'];
                                    $filename = basename($path);
            
                                    $lg = Image::make($path);
                                    $ext = explode("/", $lg->mime());
                                    $lg->resize(600, 600)->stream();
                                    
                                    $new = 'upload/tour/bestapi/' . $filename;
                                    
                                    if (in_array($ext[1], $allow_img)) {
                                        Storage::disk('public')->put($new, $lg);
                                        $data->image = $new;
                                    }
        
                                }
                            }

                        }

                        $data->api_id = $call2['id'];
                        $data->code1 = $call2['code'];
                        // $data->rating = $call2['HotelStar']; // ไม่มี

                        // จัดการ wholesale_id ให้เป็น best
                        $data->group_id = 3;
                        $data->wholesale_id = 11;

                        $allow_word = ['doc', 'docx'];
                        $allow_pdf = ['pdf'];

                        // if ($call2['fileDoc']) {
                        //     $url = $call2['fileDoc'];

                        //     $response = Http::get($url);

                        //     if ($response->successful()) {

                        //         if ($data->word_file != null) {
                        //             Storage::disk('public')->delete($data->word_file);
                        //         }
        
                        //         $filename = basename($url);
                        //         $ext = explode(".", $filename);
                        //         $new = 'upload/tour/word_file/bestapi/' . $filename;
        
                        //         if (in_array($ext[1], $allow_word)) {
                        //             Storage::disk('public')->put($new, $response->body());
                        //             $data->word_file = $new;
                        //         }
                        //     }
                        // }

                        if ($call2['filePdf']) {
                            $url = $call2['filePdf'];
    
                            $headers = get_headers($url, 1);
    
                            if (isset($headers['Content-Type']) && strpos($headers['Content-Type'], 'application/pdf') !== false) {
    
                                $response = Http::get($url);
    
                                if ($response->successful()) {

                                    if ($data->pdf_file != null) {
                                        Storage::disk('public')->delete($data->pdf_file);
                                    }
    
                                    $filename = basename($url);
                                    $ext = explode(".", $filename);
                                    $new = 'upload/tour/pdf_file/bestapi/' . $filename .'.pdf';
    
                                    Storage::disk('public')->put($new, $response->body());
                                    $data->pdf_file = $new;
                                }
                            }
                        }

                        $data->data_type = 2; // 1 system , 2 api
                        $data->api_type = "best";

                        if($data->save()){

                            $tour[] = $data->id;
                            $tour_api_id[] = $data->api_id;
                            
                            if($call2['period']){
                                $max = array();
                                $cal1 = 0;
                                $cal2 = 0;
                                $cal3 = 0;
                                $cal4 = 0;
                                foreach($call2['period'] as $pe){

                                    $data3 = TourPeriodModel::where(['tour_id'=>$data->id, 'period_api_id'=>$pe['pid'], 'api_type'=>'best'])->whereNull('deleted_at')->first();

                                    $price1 = $pe['adultPrice']; // ผู้ใหญ่พักคู่
                                    $price2 = $pe['singlePrice']; //ผู้ใหญ่พักเดี่ยว
                                    $price3 = $pe['childWbPrice']; // เด็กมีเตียง
                                    $price4 = $pe['childNbPrice']; // เด็กไม่มีเตียง


                                    if($data3 == null){
                                        $data3 = new TourPeriodModel;
                                        $data3->price1 = $price1;
                                        $data3->price2 = $price2;
                                        $data3->price3 = $price3;
                                        $data3->price4 = $price4;
                                    }else{
                                        if($data3->price1 != $price1){
                                            $cal = $data3->price1 - $price1;
                                            if($cal > 0){
                                                $data3->old_price1 = $data3->price1;
                                                $data3->price1 = $price1;
                                                if($cal < $price1){
                                                    $data3->special_price1 = $cal;
                                                }else{
                                                    $data3->special_price1 = 0;
                                                }
                                                if (isset($price1) && $price1 != 0) {
                                                    $cal1 = ($cal / $price1) * 100;
                                                } else {
                                                    $cal1 = 0;
                                                }
                                                
                                            }else{
                                                $data3->old_price1 = 0.00;
                                                $data3->price1 = $price1;
                                                $data3->special_price1 = 0.00;
                                                $cal1 = 0;
                                            }
                                        }

                                        // ราคาผู้ใหญ่ พักเดี่ยว ไม่ต้องคำนวณเปอเซ็นต์ส่วนลด
                                        $data3->old_price2 = 0.00;
                                        $data3->price2 = $price2;
                                        $data3->special_price2 = 0.00;
                                        $cal2 = 0;

                                        if($data3->price3 != $price3){
                                            $cal = $data3->price3 - $price3;
                                            if($cal > 0){
                                                $data3->old_price3 = $data3->price3;
                                                $data3->price3 = $price3;
                                                $data3->special_price3 = $cal;
                                                if($cal < $price3){
                                                    $data3->special_price3 = $cal;
                                                }else{
                                                    $data3->special_price3 = 0;
                                                }
                                                if (isset($price3) && $price3 != 0) {
                                                    $cal3 = ($cal / $price3) * 100;
                                                } else {
                                                    $cal3 = 0;
                                                }
                                            }else{
                                                $data3->old_price3 = 0.00;
                                                $data3->price3 = $price3;
                                                $data3->special_price3 = 0.00;
                                                $cal3 = 0;
                                            }
                                        }

                                        if($data3->price4 != $price4){
                                            $cal = $data3->price4 - $price4;
                                            if($cal > 0){
                                                $data3->old_price4 = $data3->price4;
                                                $data3->price4 = $price4;
                                                $data3->special_price4 = $cal;
                                                if($cal < $price4){
                                                    $data3->special_price4 = $cal;
                                                }else{
                                                    $data3->special_price4 = 0;
                                                }
                                                if (isset($price4) && $price4 != 0) {
                                                    $cal4 = ($cal / $price4) * 100;
                                                } else {
                                                    $cal4 = 0;
                                                }
                                            }else{
                                                $data3->old_price4 = 0.00;
                                                $data3->price4 = $price4;
                                                $data3->special_price4 = 0.00;
                                                $cal4 = 0;
                                            }
                                        }
                                    }

                                    $data3->tour_id = $data->id;
                                    $data3->period_api_id = $pe['pid'];

                                    if($pe['dateGo']){
                                        $go = explode('/',$pe['dateGo']);
                                        $dayGo = $go[1];
                                        $monthGo = $go[0];
                                        $yearGo = $go[2];
                                        $dateGo = "$yearGo-$monthGo-$dayGo";
                                    }else{
                                        $dateGo = "";
                                    }
                                    
                                    if($pe['dateBack']){
                                        $back = explode('/',$pe['dateBack']);
                                        $dayBack = $back[1];
                                        $monthBack = $back[0];
                                        $yearBack = $back[2];
                                        $dateBack = "$yearBack-$monthBack-$dayBack";
                                    }else{
                                        $dateBack = "";
                                    }

                                    if($dateGo || $dateBack){
                                        $day = \Carbon\Carbon::parse($dateGo)->diffInDays(\Carbon\Carbon::parse($dateBack));
                                        $night = $day-1;
                                    }else{
                                        $day = 0;
                                        $night = 0;
                                    }
                                    
                                    $data3->group_date = date('mY',strtotime($dateGo));
                                    $data3->start_date = $dateGo;
                                    $data3->end_date = $dateBack;
                                    $data3->day = $day;
                                    $data3->night = $night;
                                    $data3->group = $pe['groupSize'];
                                    if($pe['avbl'] == "เต็ม"){
                                        $data3->count = 0;
                                    }else{
                                        $data3->count = $pe['avbl'];
                                    }

                                    if($pe['avbl'] == "เต็ม" || $pe['avbl'] == "ปิดกรุ๊ป"){
                                        $data3->status_period = 3;
                                    }else if($pe['avbl'] == "รอชำระ" || $pe['avbl'] == "W/L"){
                                        $data3->status_period = 2;
                                    }else{
                                        $data3->status_period = 1;
                                    }
                                    $data3->api_type = "best";

                                    if($data3->save()){
                                        $period[] = $data3->id;
                                        $period_api_id[] = $data3->period_api_id;
                                    }
                                    
                                    $calmax = max($cal1, $cal2, $cal3, $cal4);
                                    array_push($max, $calmax);
                                }

                                // บันทึกจำนวนวัน และ ราคาเข้าไป tb_tour
                                $data4 = TourPeriodModel::where(['tour_id'=>$data->id, 'api_type'=>'best'])->whereNull('deleted_at')->orderby('start_date','asc')->first(); // asc
                                if($data4){
                                    $num_day = "";
                                    if($data4->day && $data4->night){
                                        $num_day = $data4->day.' วัน '.$data4->night.' คืน';
                                    }
                                    $price = $data4->price1;
                                    $special_price = $data4->special_price1;
                                    if($special_price && $special_price > 0){
                                        $net_price = $price - $special_price;
                                    }else{
                                        $net_price = $price;
                                    }
    
                                    if($net_price && $net_price > 0){
                                        if($net_price <= 10000 ){
                                            $price_group = 1;
                                        }else if($net_price  > 10000 && $net_price <= 20000  ){
                                            $price_group = 2;
                                        }else if($net_price  > 20000 && $net_price <= 30000  ){
                                            $price_group = 3;
                                        }
                                        else if($net_price  > 30000 && $net_price <= 50000  ){
                                            $price_group = 4;
                                        }
                                        else if($net_price  > 50000 && $net_price <= 80000  ){
                                            $price_group = 5;
                                        }else if($net_price  > 80000  ){
                                            $price_group = 6;
                                        }
                                    }else{
                                        $price_group = 0;
                                    }
                                    TourModel::where(['id'=>$data->id, 'api_type'=>'best'])->update(['num_day'=> $num_day,'price'=> $price,'price_group'=> $price_group,'special_price'=> $special_price]);
                                }

                                $maxCheck = max($max);
                                if($maxCheck > 0 && $maxCheck >= 30){
                                    TourModel::where(['id'=>$data->id, 'api_type'=>'best'])->update(['promotion1'=>'Y','promotion2'=>'N']); // เป็นโปรไฟไหม้
                                }elseif($maxCheck > 0 && $maxCheck < 30){
                                    TourModel::where(['id'=>$data->id, 'api_type'=>'best'])->update(['promotion1'=>'N','promotion2'=>'Y']); // เป็นโปรธรรมดา
                                }else{
                                    TourModel::where(['id'=>$data->id, 'api_type'=>'best'])->update(['promotion1'=>'N','promotion2'=>'N']); // ไม่เป็นโปรโมชั่น
                                }

                            }

                            \DB::commit();
                        }else{
                            \DB::rollback();
                        }
                    } // end foreach call2 ทัวร์รายประเทศ
                } // end foreach call1 ประเทศ

                // ลบข้อมูลทัวร์ และ Period
                TourModel::whereNotIn('id',$tour)->whereNotIn('api_id',$tour_api_id)->where('api_type','best')->update(['deleted_at'=>date('Y-m-d H:i:s')]);
                TourModel::whereIn('id',$tour)->whereIn('api_id',$tour_api_id)->where('api_type','best')->update(['deleted_at'=>null]);
                TourPeriodModel::whereNotIn('id',$period)->whereNotIn('period_api_id',$period_api_id)->where('api_type','best')->update(['deleted_at'=>date('Y-m-d H:i:s')]);
                TourPeriodModel::whereIn('id',$period)->whereIn('period_api_id',$period_api_id)->where('api_type','best')->update(['deleted_at'=>null]);
                
            }

        } catch (\Exception $e) {
            \DB::rollback();
            $error_log = $e->getMessage();
            $error_line = $e->getLine();
            $type_log = 'backend';
            $error_url = url()->current();
            $log_id = LogsController::save_logbackend($type_log, $error_log, $error_line, $error_url);

            // return view("$this->prefix.alert.alert", [
            //     'url' => $error_url,
            //     'title' => "เกิดข้อผิดพลาดทางโปรแกรม",
            //     'text' => "กรุณาแจ้งรหัส Code : $log_id ให้ทางผู้พัฒนาโปรแกรม ",
            //     'icon' => 'error'
            // ]);
        }
    }

    public function ttn_api(){ // status_period ยังคลุมเครือ ได้มาแค่ Yes No จำนวนเหลือ 0 แต่สถานะมา Yes
        try {
            \DB::beginTransaction();
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
            ])
            ->get('https://online.ttnconnect.com/api/program');
            $callback = $response->json();

            if(count($callback) > 0){
                $tour = array();
                $tour_api_id = array();
                $period = array();
                $period_api_id = array();
                foreach($callback as $call){
                        
                    $data = TourModel::where(['api_id'=>$call['P_ID'], 'api_type'=>'ttn'])->whereNull('deleted_at')->first();

                    $allow_img = ['png', 'jpeg', 'jpg','webp'];

                    if($data == null){
                        $data = new TourModel;

                        $code_tour = IdGenerator::generate([
                            'table' => 'tb_tour', 
                            'field' => 'code', 
                            'length' => 10, 
                            'prefix' =>'NT'.date('ym'),
                            'reset_on_prefix_change' => true 
                        ]);

                        $data->code = $code_tour;

                        // ได้เป็นเมืองของญี่ปุ่น
                        $country = CountryModel::where('country_name_en', 'like', '%JAPAN%')->whereNull('deleted_at')->first();
                        $arr = array();
                        if($country){
                            $arr[] = "$country->id";
                            $data->country_id = json_encode($arr);
                        }else{
                            $data->country_id = "[]";
                        }

                        $city = CityModel::where('city_name_en', 'like', '%'.$call['P_LOCATION'].'%')->whereNull('deleted_at')->first();
                        $arr_ci = array();
                        if($city){
                            $arr_ci[] = "$city->id";
                            $data->city_id = json_encode($arr_ci);
                        }else{
                            $data->city_id = "[]";
                        }

                        if($call['P_AIRLINE']){
                            $airline = TravelTypeModel::where('code',$call['P_AIRLINE'])->whereNull('deleted_at')->first();
                            if($airline){
                                $data->airline_id = $airline->id;
                            }
                        }

                        if ($call['banner_url']) {
    
                            $path = $call['banner_url'];
                            $filename = basename($path);
    
                            $lg = Image::make($path);
                            $ext = explode("/", $lg->mime());
                            $lg->resize(600, 600)->stream();
                            
                            $new = 'upload/tour/ttnapi/' . $filename;
                            
                            if (in_array($ext[1], $allow_img)) {
                                Storage::disk('public')->put($new, $lg);
                                $data->image = $new;
                            }
                        }

                        $data->image_check_change = 2; // 1 ไม่ดึงรูปจาก Api , 2 ดึงรูปจาก Api
                        $data->name = $call['P_NAME'];
                        // $data->description = str_replace("\n","",$call['Highlight']); ไม่มี

                    }else{
                        if($data->country_check_change == null){
                            $country = CountryModel::where('country_name_en', 'like', '%JAPAN%')->whereNull('deleted_at')->first();
                            $arr = array();
                            if($country){
                                $arr[] = "$country->id";
                                $data->country_id = json_encode($arr);
                            }else{
                                $data->country_id = "[]";
                            }

                            $city = CityModel::where('city_name_en', 'like', '%'.$call['P_LOCATION'].'%')->whereNull('deleted_at')->first();
                            $arr_ci = array();
                            if($city){
                                $arr_ci[] = "$city->id";
                                $data->city_id = json_encode($arr_ci);
                            }else{
                                $data->city_id = "[]";
                            }
                        }

                        if($data->airline_check_change == null){
                            if($call['P_AIRLINE']){
                                $airline = TravelTypeModel::where('code',$call['P_AIRLINE'])->whereNull('deleted_at')->first();
                                if($airline){
                                    $data->airline_id = $airline->id;
                                }
                            }
                        }

                        if($data->name_check_change == null){
                            $data->name = $call['P_NAME'];
                        }

                        // if($data->description_check_change == null){
                        //     $data->description = str_replace("\n","",$call['Highlight']); ไม่มี
                        // }

                        if($data->image_check_change == 2){
                            if ($call['banner_url']) {

                                if ($data->image != null) {
                                    Storage::disk('public')->delete($data->image);
                                }
        
                                $path = $call['banner_url'];
                                $filename = basename($path);
        
                                $lg = Image::make($path);
                                $ext = explode("/", $lg->mime());
                                $lg->resize(600, 600)->stream();
                                
                                $new = 'upload/tour/ttnapi/' . $filename;
                                
                                if (in_array($ext[1], $allow_img)) {
                                    Storage::disk('public')->put($new, $lg);
                                    $data->image = $new;
                                }
    
                            }
                        }

                    }

                    $data->api_id = $call['P_ID'];
                    $data->code1 = $call['P_CODE'];
                    // $data->rating = $call['HotelStar']; ไม่มี

                    // จัดการ wholesale_id ให้เป็น ttn
                    $data->group_id = 3;
                    $data->wholesale_id = 10;

                    $allow_word = ['doc', 'docx'];
                    $allow_pdf = ['pdf'];

                    if ($call['file_url']) {
                        $explode_url = explode('url=',$call['file_url']);
                        $url = $explode_url[1];
                        // $url = $call['file_url'];

                        $response = Http::get($url);

                        if ($response->successful()) {

                            if ($data->word_file != null) {
                                Storage::disk('public')->delete($data->word_file);
                            }
    
                            $filename = basename($url);
                            $ext = explode(".", $filename);
                            $new = 'upload/tour/word_file/ttnapi/' . $filename;
    
                            if (in_array($ext[1], $allow_word)) {
                                // Storage::disk('public')->put($new, $response->body());
                                $data->word_file = $new;
                            }
                        }
                    }

                    // ไม่มี
                    // if ($call['FilePDF']) {
                    //     $url = $call['FilePDF'];

                    //     $response = Http::get($url);

                    //     if ($response->successful()) {

                    //         if ($data->pdf_file != null) {
                    //             Storage::disk('public')->delete($data->pdf_file);
                    //         }
    
                    //         $filename = basename($url);
                    //         $ext = explode(".", $filename);
                    //         $new = 'upload/tour/pdf_file/ttnapi/' . $filename;
    
                    //         if (in_array($ext[1], $allow_pdf)) {
                    //             Storage::disk('public')->put($new, $response->body());
                    //             $data->pdf_file = $new;
                    //         }
                    //     }
                    // }

                    $data->data_type = 2; // 1 system , 2 api
                    $data->api_type = "ttn";

                    if($data->save()){

                        $tour[] = $data->id;
                        $tour_api_id[] = $data->api_id;
                        
                        if($call['period']){
                            $max = array();
                            $cal1 = 0;
                            $cal2 = 0;
                            $cal3 = 0;
                            $cal4 = 0;
                            foreach($call['period'] as $pe){

                                // มาปรับแก้ให้สวย ๆ ได้อีก // ตอนนี้ต้องเช็ค $data->id ด้วยเผื่อ period_api_id ชนกันเพราะยิงหลาย api
                                $data3 = TourPeriodModel::where(['tour_id'=>$data->id, 'period_api_id'=>$pe['P_ID'], 'api_type'=>'ttn'])->whereNull('deleted_at')->first();

                                $price1 = $pe['P_ADULT']; // ผู้ใหญ่พักคู่
                                $price2 = $pe['P_SINGLE']; //ผู้ใหญ่พักเดี่ยว
                                // $price3 = $pe['Price_Child']; // เด็กมีเตียง ไม่มี
                                // $price4 = $pe['Price_ChildNB']; // เด็กไม่มีเตียง ไม่มี


                                if($data3 == null){
                                    $data3 = new TourPeriodModel;
                                    $data3->price1 = $price1;
                                    $data3->price2 = $price2;
                                    // $data3->price3 = $price3;
                                    // $data3->price4 = $price4;
                                }else{
                                    if($data3->price1 != $price1){
                                        $cal = $data3->price1 - $price1;
                                        if($cal > 0){
                                            $data3->old_price1 = $data3->price1;
                                            $data3->price1 = $price1;
                                            if($cal < $price1){
                                                $data3->special_price1 = $cal;
                                            }else{
                                                $data3->special_price1 = 0;
                                            }
                                            if (isset($price1) && $price1 != 0) {
                                                $cal1 = ($cal / $price1) * 100;
                                            } else {
                                                $cal1 = 0;
                                            }
                                            
                                        }else{
                                            $data3->old_price1 = 0.00;
                                            $data3->price1 = $price1;
                                            $data3->special_price1 = 0.00;
                                            $cal1 = 0;
                                        }
                                    }

                                    // ราคาผู้ใหญ่ พักเดี่ยว ไม่ต้องคำนวณเปอเซ็นต์ส่วนลด
                                    $data3->old_price2 = 0.00;
                                    $data3->price2 = $price2;
                                    $data3->special_price2 = 0.00;
                                    $cal2 = 0;
                                }

                                $data3->tour_id = $data->id;
                                $data3->period_api_id = $pe['P_ID'];
                                $data3->group_date = date('mY',strtotime($pe['P_DUE_START']));
                                $data3->start_date = $pe['P_DUE_START'];
                                $data3->end_date = $pe['P_DUE_END'];
                                $data3->day = $call['P_DAY']; // เอามาจากอันหลัก
                                $data3->night = $call['P_NIGHT']; // เอามาจากอันหลัก
                                $data3->group = $pe['P_VOLUME'];
                                $data3->count = $pe['available'];

                                if($pe['status'] == "Yes"){
                                    $data3->status_period = 1;
                                }else if($pe['status'] == "No"){
                                    $data3->status_period = 3;
                                }
                                $data3->api_type = "ttn";

                                if($data3->save()){
                                    $period[] = $data3->id;
                                    $period_api_id[] = $data3->period_api_id;
                                }
                                
                                $calmax = max($cal1, $cal2);
                                // $calmax = max($cal1, $cal2, $cal3, $cal4);
                                array_push($max, $calmax);
                            }

                            // บันทึกจำนวนวัน และ ราคาเข้าไป tb_tour
                            $data4 = TourPeriodModel::where(['tour_id'=>$data->id, 'api_type'=>'ttn'])->whereNull('deleted_at')->orderby('start_date','asc')->first(); // asc
                            if($data4){
                                $num_day = "";
                                if($data4->day && $data4->night){
                                    $num_day = $data4->day.' วัน '.$data4->night.' คืน';
                                }
                                $price = $data4->price1;
                                $special_price = $data4->special_price1;
                                if($special_price && $special_price > 0){
                                    $net_price = $price - $special_price;
                                }else{
                                    $net_price = $price;
                                }

                                if($net_price && $net_price > 0){
                                    if($net_price <= 10000 ){
                                        $price_group = 1;
                                    }else if($net_price  > 10000 && $net_price <= 20000  ){
                                        $price_group = 2;
                                    }else if($net_price  > 20000 && $net_price <= 30000  ){
                                        $price_group = 3;
                                    }
                                    else if($net_price  > 30000 && $net_price <= 50000  ){
                                        $price_group = 4;
                                    }
                                    else if($net_price  > 50000 && $net_price <= 80000  ){
                                        $price_group = 5;
                                    }else if($net_price  > 80000  ){
                                        $price_group = 6;
                                    }
                                }else{
                                    $price_group = 0;
                                }
                                TourModel::where(['id'=>$data->id, 'api_type'=>'ttn'])->update(['num_day'=> $num_day,'price'=> $price,'price_group'=> $price_group,'special_price'=> $special_price]);
                            }

                            $maxCheck = max($max);
                            if($maxCheck > 0 && $maxCheck >= 30){
                                TourModel::where(['id'=>$data->id, 'api_type'=>'ttn'])->update(['promotion1'=>'Y','promotion2'=>'N']); // เป็นโปรไฟไหม้
                            }elseif($maxCheck > 0 && $maxCheck < 30){
                                TourModel::where(['id'=>$data->id, 'api_type'=>'ttn'])->update(['promotion1'=>'N','promotion2'=>'Y']); // เป็นโปรธรรมดา
                            }else{
                                TourModel::where(['id'=>$data->id, 'api_type'=>'ttn'])->update(['promotion1'=>'N','promotion2'=>'N']); // ไม่เป็นโปรโมชั่น
                            }

                        }

                        \DB::commit();
                    }else{
                        \DB::rollback();
                    }
                    
                } // end foreach
                
                // ลบข้อมูลทัวร์ และ Period
                TourModel::whereNotIn('id',$tour)->whereNotIn('api_id',$tour_api_id)->where('api_type','ttn')->update(['deleted_at'=>date('Y-m-d H:i:s')]);
                TourModel::whereIn('id',$tour)->whereIn('api_id',$tour_api_id)->where('api_type','ttn')->update(['deleted_at'=>null]);
                TourPeriodModel::whereNotIn('id',$period)->whereNotIn('period_api_id',$period_api_id)->where('api_type','ttn')->update(['deleted_at'=>date('Y-m-d H:i:s')]);
                TourPeriodModel::whereIn('id',$period)->whereIn('period_api_id',$period_api_id)->where('api_type','ttn')->update(['deleted_at'=>null]);
                
            }

        } catch (\Exception $e) {
            \DB::rollback();
            $error_log = $e->getMessage();
            $error_line = $e->getLine();
            $type_log = 'backend';
            $error_url = url()->current();
            $log_id = LogsController::save_logbackend($type_log, $error_log, $error_line, $error_url);

            // return view("$this->prefix.alert.alert", [
            //     'url' => $error_url,
            //     'title' => "เกิดข้อผิดพลาดทางโปรแกรม",
            //     'text' => "กรุณาแจ้งรหัส Code : $log_id ให้ทางผู้พัฒนาโปรแกรม ",
            //     'icon' => 'error'
            // ]);
        }
    }

    public function probooking_api(){ // ยังไม่เสร็จ
        try {
            \DB::beginTransaction();
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                "API-Key" => "jDOpBMVdyFxbZpvPrzB7ySuxFEuONNFTQEBBoQ7Y",
            ])
            // ->get('https://api.probookingcenter.com/api/tours/series');
            ->get('https://api.probookingcenter.com/api/tours/period?search=PHK00095-SL');
            $callback = $response->json();
            dd($callback);

            if(count($callback) > 0){
                $tour = array();
                $tour_api_id = array();
                $period = array();
                $period_api_id = array();
                foreach($callback as $call){
                        
                    $data = TourModel::where(['api_id'=>$call['P_ID'], 'api_type'=>'ttn'])->whereNull('deleted_at')->first();

                    $allow_img = ['png', 'jpeg', 'jpg','webp'];

                    if($data == null){
                        $data = new TourModel;

                        $code_tour = IdGenerator::generate([
                            'table' => 'tb_tour', 
                            'field' => 'code', 
                            'length' => 10, 
                            'prefix' =>'NT'.date('ym'),
                            'reset_on_prefix_change' => true 
                        ]);

                        $data->code = $code_tour;

                        // ได้เป็นเมืองของญี่ปุ่น
                        $country = CountryModel::where('country_name_en', 'like', '%JAPAN%')->whereNull('deleted_at')->first();
                        $arr = array();
                        if($country){
                            $arr[] = "$country->id";
                            $data->country_id = json_encode($arr);
                        }else{
                            $data->country_id = "[]";
                        }

                        if ($call['banner_url']) {
    
                            $path = $call['banner_url'];
                            $filename = basename($path);
    
                            $lg = Image::make($path);
                            $ext = explode("/", $lg->mime());
                            $lg->resize(600, 600)->stream();
                            
                            $new = 'upload/tour/ttnapi/' . $filename;
                            
                            if (in_array($ext[1], $allow_img)) {
                                // Storage::disk('public')->put($new, $lg);
                                $data->image = $new;
                            }
                        }

                        $data->image_check_change = 2; // 1 ไม่ดึงรูปจาก Api , 2 ดึงรูปจาก Api
                        $data->name = $call['P_NAME'];
                        // $data->description = str_replace("\n","",$call['Highlight']); ไม่มี

                    }else{
                        if($data->country_check_change == null){
                            $country = CountryModel::where('country_name_en', 'like', '%JAPAN%')->whereNull('deleted_at')->first();
                            $arr = array();
                            if($country){
                                $arr[] = "$country->id";
                                $data->country_id = json_encode($arr);
                            }else{
                                $data->country_id = "[]";
                            }
                        }

                        if($data->name_check_change == null){
                            $data->name = $call['P_NAME'];
                        }

                        // if($data->description_check_change == null){
                        //     $data->description = str_replace("\n","",$call['Highlight']); ไม่มี
                        // }

                        if($data->image_check_change == 2){
                            if ($call['banner_url']) {

                                if ($data->image != null) {
                                    Storage::disk('public')->delete($data->image);
                                }
        
                                $path = $call['banner_url'];
                                $filename = basename($path);
        
                                $lg = Image::make($path);
                                $ext = explode("/", $lg->mime());
                                $lg->resize(600, 600)->stream();
                                
                                $new = 'upload/tour/ttnapi/' . $filename;
                                
                                if (in_array($ext[1], $allow_img)) {
                                    // Storage::disk('public')->put($new, $lg);
                                    $data->image = $new;
                                }
    
                            }
                        }

                    }

                    $data->api_id = $call['P_ID'];
                    $data->code1 = $call['P_CODE'];
                    // $data->rating = $call['HotelStar']; ไม่มี

                    // จัดการ wholesale_id ให้เป็น ttn
                    $data->group_id = 3;
                    $data->wholesale_id = 5;

                    if($call['P_AIRLINE']){
                        $airline = TravelTypeModel::where('code',$call['P_AIRLINE'])->whereNull('deleted_at')->first();
                        if($airline){
                            $data->airline_id = $airline->id;
                        }
                    }

                    $allow_word = ['doc', 'docx'];
                    $allow_pdf = ['pdf'];

                    // if ($call['file_url']) {
                    //     $explode_url = explode('url=',$call['file_url']);
                    //     $url = $explode_url[1];
                    //     // $url = $call['file_url'];

                    //     $response = Http::get($url);

                    //     if ($response->successful()) {

                    //         if ($data->word_file != null) {
                    //             Storage::disk('public')->delete($data->word_file);
                    //         }
    
                    //         $filename = basename($url);
                    //         $ext = explode(".", $filename);
                    //         $new = 'upload/tour/word_file/ttnapi/' . $filename;
    
                    //         if (in_array($ext[1], $allow_word)) {
                    //             // Storage::disk('public')->put($new, $response->body());
                    //             $data->word_file = $new;
                    //         }
                    //     }
                    // }

                    // ไม่มี
                    // if ($call['FilePDF']) {
                    //     $url = $call['FilePDF'];

                    //     $response = Http::get($url);

                    //     if ($response->successful()) {

                    //         if ($data->pdf_file != null) {
                    //             Storage::disk('public')->delete($data->pdf_file);
                    //         }
    
                    //         $filename = basename($url);
                    //         $ext = explode(".", $filename);
                    //         $new = 'upload/tour/pdf_file/ttnapi/' . $filename;
    
                    //         if (in_array($ext[1], $allow_pdf)) {
                    //             Storage::disk('public')->put($new, $response->body());
                    //             $data->pdf_file = $new;
                    //         }
                    //     }
                    // }

                    $data->data_type = 2; // 1 system , 2 api
                    $data->api_type = "ttn";

                    dd($call['period'],$data);

                    if($data->save()){

                        $tour[] = $data->id;
                        $tour_api_id[] = $data->api_id;
                        
                        if($call['period']){
                            $max = array();
                            $cal1 = 0;
                            $cal2 = 0;
                            $cal3 = 0;
                            $cal4 = 0;
                            foreach($call['period'] as $pe){

                                // มาปรับแก้ให้สวย ๆ ได้อีก // ตอนนี้ต้องเช็ค $data->id ด้วยเผื่อ period_api_id ชนกันเพราะยิงหลาย api
                                $data3 = TourPeriodModel::where(['tour_id'=>$data->id, 'period_api_id'=>$pe['P_ID'], 'api_type'=>'ttn'])->whereNull('deleted_at')->first();

                                $price1 = $pe['P_ADULT']; // ผู้ใหญ่พักคู่
                                $price2 = $pe['P_SINGLE']; //ผู้ใหญ่พักเดี่ยว
                                // $price3 = $pe['Price_Child']; // เด็กมีเตียง ไม่มี
                                // $price4 = $pe['Price_ChildNB']; // เด็กไม่มีเตียง ไม่มี


                                if($data3 == null){
                                    $data3 = new TourPeriodModel;
                                    $data3->price1 = $price1;
                                    $data3->price2 = $price2;
                                    // $data3->price3 = $price3;
                                    // $data3->price4 = $price4;
                                }else{
                                    if($data3->price1 != $price1){
                                        $cal = $data3->price1 - $price1;
                                        if($cal > 0){
                                            $data3->old_price1 = $data3->price1;
                                            $data3->price1 = $price1;
                                            if($cal < $price1){
                                                $data3->special_price1 = $cal;
                                            }else{
                                                $data3->special_price1 = 0;
                                            }
                                            if (isset($price1) && $price1 != 0) {
                                                $cal1 = ($cal / $price1) * 100;
                                            } else {
                                                $cal1 = 0;
                                            }
                                            
                                        }else{
                                            $data3->old_price1 = 0.00;
                                            $data3->price1 = $price1;
                                            $data3->special_price1 = 0.00;
                                            $cal1 = 0;
                                        }
                                    }

                                    // ราคาผู้ใหญ่ พักเดี่ยว ไม่ต้องคำนวณเปอเซ็นต์ส่วนลด
                                    $data3->old_price2 = 0.00;
                                    $data3->price2 = $price2;
                                    $data3->special_price2 = 0.00;
                                    $cal2 = 0;

                                    // if($data3->price3 != $price3){
                                    //     $cal = $data3->price3 - $price3;
                                    //     if($cal > 0){
                                    //         $data3->old_price3 = $data3->price3;
                                    //         $data3->price3 = $price3;
                                    //         $data3->special_price3 = $cal;
                                    //         if($cal < $price3){
                                    //             $data3->special_price3 = $cal;
                                    //         }else{
                                    //             $data3->special_price3 = 0;
                                    //         }
                                    //         // $cal3 = ($cal / $price3) * 100;
                                    //         if (isset($price3) && $price3 != 0) {
                                    //             $cal3 = ($cal / $price3) * 100;
                                    //         } else {
                                    //             $cal3 = 0;
                                    //         }
                                    //     }else{
                                    //         $data3->old_price3 = 0.00;
                                    //         $data3->price3 = $price3;
                                    //         $data3->special_price3 = 0.00;
                                    //         $cal3 = 0;
                                    //     }
                                    // }

                                    // if($data3->price4 != $price4){
                                    //     $cal = $data3->price4 - $price4;
                                    //     if($cal > 0){
                                    //         $data3->old_price4 = $data3->price4;
                                    //         $data3->price4 = $price4;
                                    //         $data3->special_price4 = $cal;
                                    //         if($cal < $price4){
                                    //             $data3->special_price4 = $cal;
                                    //         }else{
                                    //             $data3->special_price4 = 0;
                                    //         }
                                    //         // $cal4 = ($cal / $price4) * 100;
                                    //         if (isset($price4) && $price4 != 0) {
                                    //             $cal4 = ($cal / $price4) * 100;
                                    //         } else {
                                    //             $cal4 = 0;
                                    //         }
                                    //     }else{
                                    //         $data3->old_price4 = 0.00;
                                    //         $data3->price4 = $price4;
                                    //         $data3->special_price4 = 0.00;
                                    //         $cal4 = 0;
                                    //     }
                                    // }
                                }

                                $data3->tour_id = $data->id;
                                $data3->period_api_id = $pe['P_ID'];
                                $data3->group_date = date('mY',strtotime($pe['P_DUE_START']));
                                $data3->start_date = $pe['P_DUE_START'];
                                $data3->end_date = $pe['P_DUE_END'];
                                $data3->day = $call['P_DAY']; // เอามาจากอันหลัก
                                $data3->night = $call['Night']; // เอามาจากอันหลัก
                                $data3->group = $pe['P_VOLUME'];
                                $data3->count = $pe['available'];

                                if($pe['status'] == "Yes"){
                                    $data3->status_period = 1;
                                }else if($pe['status'] == "No"){
                                    $data3->status_period = 3;
                                }
                                $data3->api_type = "ttn";

                                if($data3->save()){
                                    $period[] = $data3->id;
                                    $period_api_id[] = $data3->period_api_id;
                                }
                                
                                $calmax = max($cal1, $cal2);
                                // $calmax = max($cal1, $cal2, $cal3, $cal4);
                                array_push($max, $calmax);
                            }

                            // บันทึกจำนวนวัน และ ราคาเข้าไป tb_tour
                            $data4 = TourPeriodModel::where(['tour_id'=>$data->id, 'api_type'=>'ttn'])->whereNull('deleted_at')->orderby('start_date','asc')->first(); // asc
                            if($data4){
                                $num_day = "";
                                if($data4->day && $data4->night){
                                    $num_day = $data4->day.' วัน '.$data4->night.' คืน';
                                }
                                $price = $data4->price1;
                                $special_price = $data4->special_price1;
                                if($special_price && $special_price > 0){
                                    $net_price = $price - $special_price;
                                }else{
                                    $net_price = $price;
                                }

                                if($net_price && $net_price > 0){
                                    if($net_price <= 10000 ){
                                        $price_group = 1;
                                    }else if($net_price  > 10000 && $net_price <= 20000  ){
                                        $price_group = 2;
                                    }else if($net_price  > 20000 && $net_price <= 30000  ){
                                        $price_group = 3;
                                    }
                                    else if($net_price  > 30000 && $net_price <= 50000  ){
                                        $price_group = 4;
                                    }
                                    else if($net_price  > 50000 && $net_price <= 80000  ){
                                        $price_group = 5;
                                    }else if($net_price  > 80000  ){
                                        $price_group = 6;
                                    }
                                }else{
                                    $price_group = 0;
                                }
                                TourModel::where(['id'=>$data->id, 'api_type'=>'ttn'])->update(['num_day'=> $num_day,'price'=> $price,'price_group'=> $price_group,'special_price'=> $special_price]);
                            }

                            $maxCheck = max($max);
                            if($maxCheck > 0 && $maxCheck >= 30){
                                TourModel::where(['id'=>$data->id, 'api_type'=>'ttn'])->update(['promotion1'=>'Y','promotion2'=>'N']); // เป็นโปรไฟไหม้
                            }elseif($maxCheck > 0 && $maxCheck < 30){
                                TourModel::where(['id'=>$data->id, 'api_type'=>'ttn'])->update(['promotion1'=>'N','promotion2'=>'Y']); // เป็นโปรธรรมดา
                            }else{
                                TourModel::where(['id'=>$data->id, 'api_type'=>'ttn'])->update(['promotion1'=>'N','promotion2'=>'N']); // ไม่เป็นโปรโมชั่น
                            }

                        }

                        \DB::commit();
                    }else{
                        \DB::rollback();
                    }
                    
                } // end foreach
                
                // ลบข้อมูลทัวร์ และ Period
                TourModel::whereNotIn('id',$tour)->whereNotIn('api_id',$tour_api_id)->where('api_type','ttn')->update(['deleted_at'=>date('Y-m-d H:i:s')]);
                TourModel::whereIn('id',$tour)->whereIn('api_id',$tour_api_id)->where('api_type','ttn')->update(['deleted_at'=>null]);
                TourPeriodModel::whereNotIn('id',$period)->whereNotIn('period_api_id',$period_api_id)->where('api_type','ttn')->update(['deleted_at'=>date('Y-m-d H:i:s')]);
                TourPeriodModel::whereIn('id',$period)->whereIn('period_api_id',$period_api_id)->where('api_type','ttn')->update(['deleted_at'=>null]);
                
            }

        } catch (\Exception $e) {
            DB::rollback();
            $error_log = $e->getMessage();
            $error_line = $e->getLine();
            $type_log = 'backend';
            $error_url = url()->current();
            $log_id = LogsController::save_logbackend($type_log, $error_log, $error_line, $error_url);

            // return view("$this->prefix.alert.alert", [
            //     'url' => $error_url,
            //     'title' => "เกิดข้อผิดพลาดทางโปรแกรม",
            //     'text' => "กรุณาแจ้งรหัส Code : $log_id ให้ทางผู้พัฒนาโปรแกรม ",
            //     'icon' => 'error'
            // ]);
        }
    }

    public function checkingroup_api(){
        try {
            \DB::beginTransaction();
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
            ])
            ->get('https://checkingroups.com/apiweb.php?id=1');
            $callback = $response->json();
            dd($callback);

            if(count($callback) > 0){
                $tour = array();
                $tour_api_id = array();
                $period = array();
                $period_api_id = array();
                foreach($callback as $call){
                        
                    $data = TourModel::where(['api_id'=>$call['mainid'], 'api_type'=>'checkingroup'])->whereNull('deleted_at')->first();

                    $allow_img = ['png', 'jpeg', 'jpg','webp'];

                    if($data == null){
                        $data = new TourModel;

                        $code_tour = IdGenerator::generate([
                            'table' => 'tb_tour', 
                            'field' => 'code', 
                            'length' => 10, 
                            'prefix' =>'NT'.date('ym'),
                            'reset_on_prefix_change' => true 
                        ]);

                        $data->code = $code_tour;

                        // ได้เป็นเมืองของญี่ปุ่น
                        $country = CountryModel::where('country_name_en', 'like', '%JAPAN%')->whereNull('deleted_at')->first();
                        $arr = array();
                        if($country){
                            $arr[] = "$country->id";
                            $data->country_id = json_encode($arr);
                        }else{
                            $data->country_id = "[]";
                        }

                        if ($call['banner_url']) {
    
                            $path = $call['banner_url'];
                            $filename = basename($path);
    
                            $lg = Image::make($path);
                            $ext = explode("/", $lg->mime());
                            $lg->resize(600, 600)->stream();
                            
                            $new = 'upload/tour/checkingroupapi/' . $filename;
                            
                            if (in_array($ext[1], $allow_img)) {
                                // Storage::disk('public')->put($new, $lg);
                                $data->image = $new;
                            }
                        }

                        $data->image_check_change = 2; // 1 ไม่ดึงรูปจาก Api , 2 ดึงรูปจาก Api
                        $data->name = $call['P_NAME'];
                        // $data->description = str_replace("\n","",$call['Highlight']); ไม่มี

                    }else{
                        if($data->country_check_change == null){
                            $country = CountryModel::where('country_name_en', 'like', '%JAPAN%')->whereNull('deleted_at')->first();
                            $arr = array();
                            if($country){
                                $arr[] = "$country->id";
                                $data->country_id = json_encode($arr);
                            }else{
                                $data->country_id = "[]";
                            }
                        }

                        if($data->name_check_change == null){
                            $data->name = $call['P_NAME'];
                        }

                        // if($data->description_check_change == null){
                        //     $data->description = str_replace("\n","",$call['Highlight']); ไม่มี
                        // }

                        if($data->image_check_change == 2){
                            if ($call['banner_url']) {

                                if ($data->image != null) {
                                    Storage::disk('public')->delete($data->image);
                                }
        
                                $path = $call['banner_url'];
                                $filename = basename($path);
        
                                $lg = Image::make($path);
                                $ext = explode("/", $lg->mime());
                                $lg->resize(600, 600)->stream();
                                
                                $new = 'upload/tour/checkingroupapi/' . $filename;
                                
                                if (in_array($ext[1], $allow_img)) {
                                    Storage::disk('public')->put($new, $lg);
                                    $data->image = $new;
                                }
    
                            }
                        }

                    }

                    $data->api_id = $call['P_ID'];
                    $data->code1 = $call['P_CODE'];
                    // $data->rating = $call['HotelStar']; ไม่มี

                    // จัดการ wholesale_id ให้เป็น ttn
                    $data->group_id = 3;
                    $data->wholesale_id = 5;

                    if($call['P_AIRLINE']){
                        $airline = TravelTypeModel::where('code',$call['P_AIRLINE'])->whereNull('deleted_at')->first();
                        if($airline){
                            $data->airline_id = $airline->id;
                        }
                    }

                    $allow_word = ['doc', 'docx'];
                    $allow_pdf = ['pdf'];

                    // if ($call['file_url']) {
                    //     $explode_url = explode('url=',$call['file_url']);
                    //     $url = $explode_url[1];
                    //     // $url = $call['file_url'];

                    //     $response = Http::get($url);

                    //     if ($response->successful()) {

                    //         if ($data->word_file != null) {
                    //             Storage::disk('public')->delete($data->word_file);
                    //         }
    
                    //         $filename = basename($url);
                    //         $ext = explode(".", $filename);
                    //         $new = 'upload/tour/word_file/checkingroupapi/' . $filename;
    
                    //         if (in_array($ext[1], $allow_word)) {
                    //             // Storage::disk('public')->put($new, $response->body());
                    //             $data->word_file = $new;
                    //         }
                    //     }
                    // }

                    // ไม่มี
                    // if ($call['FilePDF']) {
                    //     $url = $call['FilePDF'];

                    //     $response = Http::get($url);

                    //     if ($response->successful()) {

                    //         if ($data->pdf_file != null) {
                    //             Storage::disk('public')->delete($data->pdf_file);
                    //         }
    
                    //         $filename = basename($url);
                    //         $ext = explode(".", $filename);
                    //         $new = 'upload/tour/pdf_file/checkingroupapi/' . $filename;
    
                    //         if (in_array($ext[1], $allow_pdf)) {
                    //             Storage::disk('public')->put($new, $response->body());
                    //             $data->pdf_file = $new;
                    //         }
                    //     }
                    // }

                    $data->data_type = 2; // 1 system , 2 api
                    $data->api_type = "checkingroup";

                    dd(1);

                    if($data->save()){

                        $tour[] = $data->id;
                        $tour_api_id[] = $data->api_id;
                        
                        if($call['period']){
                            $max = array();
                            $cal1 = 0;
                            $cal2 = 0;
                            $cal3 = 0;
                            $cal4 = 0;
                            foreach($call['period'] as $pe){

                                // มาปรับแก้ให้สวย ๆ ได้อีก // ตอนนี้ต้องเช็ค $data->id ด้วยเผื่อ period_api_id ชนกันเพราะยิงหลาย api
                                $data3 = TourPeriodModel::where(['tour_id'=>$data->id, 'period_api_id'=>$pe['P_ID'], 'api_type'=>'ttn'])->whereNull('deleted_at')->first();

                                $price1 = $pe['P_ADULT']; // ผู้ใหญ่พักคู่
                                $price2 = $pe['P_SINGLE']; //ผู้ใหญ่พักเดี่ยว
                                // $price3 = $pe['Price_Child']; // เด็กมีเตียง ไม่มี
                                // $price4 = $pe['Price_ChildNB']; // เด็กไม่มีเตียง ไม่มี


                                if($data3 == null){
                                    $data3 = new TourPeriodModel;
                                    $data3->price1 = $price1;
                                    $data3->price2 = $price2;
                                    // $data3->price3 = $price3;
                                    // $data3->price4 = $price4;
                                }else{
                                    if($data3->price1 != $price1){
                                        $cal = $data3->price1 - $price1;
                                        if($cal > 0){
                                            $data3->old_price1 = $data3->price1;
                                            $data3->price1 = $price1;
                                            if($cal < $price1){
                                                $data3->special_price1 = $cal;
                                            }else{
                                                $data3->special_price1 = 0;
                                            }
                                            if (isset($price1) && $price1 != 0) {
                                                $cal1 = ($cal / $price1) * 100;
                                            } else {
                                                $cal1 = 0;
                                            }
                                            
                                        }else{
                                            $data3->old_price1 = 0.00;
                                            $data3->price1 = $price1;
                                            $data3->special_price1 = 0.00;
                                            $cal1 = 0;
                                        }
                                    }

                                    // ราคาผู้ใหญ่ พักเดี่ยว ไม่ต้องคำนวณเปอเซ็นต์ส่วนลด
                                    $data3->old_price2 = 0.00;
                                    $data3->price2 = $price2;
                                    $data3->special_price2 = 0.00;
                                    $cal2 = 0;

                                    // if($data3->price3 != $price3){
                                    //     $cal = $data3->price3 - $price3;
                                    //     if($cal > 0){
                                    //         $data3->old_price3 = $data3->price3;
                                    //         $data3->price3 = $price3;
                                    //         $data3->special_price3 = $cal;
                                    //         if($cal < $price3){
                                    //             $data3->special_price3 = $cal;
                                    //         }else{
                                    //             $data3->special_price3 = 0;
                                    //         }
                                    //         // $cal3 = ($cal / $price3) * 100;
                                    //         if (isset($price3) && $price3 != 0) {
                                    //             $cal3 = ($cal / $price3) * 100;
                                    //         } else {
                                    //             $cal3 = 0;
                                    //         }
                                    //     }else{
                                    //         $data3->old_price3 = 0.00;
                                    //         $data3->price3 = $price3;
                                    //         $data3->special_price3 = 0.00;
                                    //         $cal3 = 0;
                                    //     }
                                    // }

                                    // if($data3->price4 != $price4){
                                    //     $cal = $data3->price4 - $price4;
                                    //     if($cal > 0){
                                    //         $data3->old_price4 = $data3->price4;
                                    //         $data3->price4 = $price4;
                                    //         $data3->special_price4 = $cal;
                                    //         if($cal < $price4){
                                    //             $data3->special_price4 = $cal;
                                    //         }else{
                                    //             $data3->special_price4 = 0;
                                    //         }
                                    //         // $cal4 = ($cal / $price4) * 100;
                                    //         if (isset($price4) && $price4 != 0) {
                                    //             $cal4 = ($cal / $price4) * 100;
                                    //         } else {
                                    //             $cal4 = 0;
                                    //         }
                                    //     }else{
                                    //         $data3->old_price4 = 0.00;
                                    //         $data3->price4 = $price4;
                                    //         $data3->special_price4 = 0.00;
                                    //         $cal4 = 0;
                                    //     }
                                    // }
                                }

                                $data3->tour_id = $data->id;
                                $data3->period_api_id = $pe['P_ID'];
                                $data3->group_date = date('mY',strtotime($pe['P_DUE_START']));
                                $data3->start_date = $pe['P_DUE_START'];
                                $data3->end_date = $pe['P_DUE_END'];
                                $data3->day = $call['P_DAY']; // เอามาจากอันหลัก
                                $data3->night = $call['Night']; // เอามาจากอันหลัก
                                $data3->group = $pe['P_VOLUME'];
                                $data3->count = $pe['available'];

                                if($pe['status'] == "Yes"){
                                    $data3->status_period = 1;
                                }else if($pe['status'] == "No"){
                                    $data3->status_period = 3;
                                }
                                $data3->api_type = "ttn";

                                if($data3->save()){
                                    $period[] = $data3->id;
                                    $period_api_id[] = $data3->period_api_id;
                                }
                                
                                $calmax = max($cal1, $cal2);
                                // $calmax = max($cal1, $cal2, $cal3, $cal4);
                                array_push($max, $calmax);
                            }

                            // บันทึกจำนวนวัน และ ราคาเข้าไป tb_tour
                            $data4 = TourPeriodModel::where(['tour_id'=>$data->id, 'api_type'=>'ttn'])->whereNull('deleted_at')->orderby('start_date','asc')->first(); // asc
                            if($data4){
                                $num_day = "";
                                if($data4->day && $data4->night){
                                    $num_day = $data4->day.' วัน '.$data4->night.' คืน';
                                }
                                $price = $data4->price1;
                                $special_price = $data4->special_price1;
                                if($special_price && $special_price > 0){
                                    $net_price = $price - $special_price;
                                }else{
                                    $net_price = $price;
                                }

                                if($net_price && $net_price > 0){
                                    if($net_price <= 10000 ){
                                        $price_group = 1;
                                    }else if($net_price  > 10000 && $net_price <= 20000  ){
                                        $price_group = 2;
                                    }else if($net_price  > 20000 && $net_price <= 30000  ){
                                        $price_group = 3;
                                    }
                                    else if($net_price  > 30000 && $net_price <= 50000  ){
                                        $price_group = 4;
                                    }
                                    else if($net_price  > 50000 && $net_price <= 80000  ){
                                        $price_group = 5;
                                    }else if($net_price  > 80000  ){
                                        $price_group = 6;
                                    }
                                }else{
                                    $price_group = 0;
                                }
                                // TourModel::where(['id'=>$data->id, 'api_type'=>'ttn'])->update(['num_day'=> $num_day,'price'=> $price,'price_group'=> $price_group,'special_price'=> $special_price]);
                            }

                            // $maxCheck = max($max);
                            // if($maxCheck > 0 && $maxCheck >= 30){
                            //     TourModel::where(['id'=>$data->id, 'api_type'=>'ttn'])->update(['promotion1'=>'Y','promotion2'=>'N']); // เป็นโปรไฟไหม้
                            // }elseif($maxCheck > 0 && $maxCheck < 30){
                            //     TourModel::where(['id'=>$data->id, 'api_type'=>'ttn'])->update(['promotion1'=>'N','promotion2'=>'Y']); // เป็นโปรธรรมดา
                            // }else{
                            //     TourModel::where(['id'=>$data->id, 'api_type'=>'ttn'])->update(['promotion1'=>'N','promotion2'=>'N']); // ไม่เป็นโปรโมชั่น
                            // }

                        }

                        \DB::commit();
                    }else{
                        \DB::rollback();
                    }
                    
                } // end foreach
                
                // ลบข้อมูลทัวร์ และ Period
                // TourModel::whereNotIn('id',$tour)->whereNotIn('api_id',$tour_api_id)->where('api_type','ttn')->update(['deleted_at'=>date('Y-m-d H:i:s')]);
                // TourModel::whereIn('id',$tour)->whereIn('api_id',$tour_api_id)->where('api_type','ttn')->update(['deleted_at'=>null]);
                // TourPeriodModel::whereNotIn('id',$period)->whereNotIn('period_api_id',$period_api_id)->where('api_type','ttn')->update(['deleted_at'=>date('Y-m-d H:i:s')]);
                // TourPeriodModel::whereIn('id',$period)->whereIn('period_api_id',$period_api_id)->where('api_type','ttn')->update(['deleted_at'=>null]);
                
            }

        } catch (\Exception $e) {
            DB::rollback();
            $error_log = $e->getMessage();
            $error_line = $e->getLine();
            $type_log = 'backend';
            $error_url = url()->current();
            $log_id = LogsController::save_logbackend($type_log, $error_log, $error_line, $error_url);
        }
    }

    public function superbholiday_api(){
        try {
            \DB::beginTransaction();
            $response = Http::withHeaders([
                "Content-Type" => "application/json",
            ])
            ->get('https://checkingroups.com/apiweb.php?id=1');
            $callback = $response->json();
            dd($callback);

            if(count($callback) > 0){
                $tour = array();
                $tour_api_id = array();
                $period = array();
                $period_api_id = array();
                foreach($callback as $call){
                        
                    $data = TourModel::where(['api_id'=>$call['mainid'], 'api_type'=>'checkingroup'])->whereNull('deleted_at')->first();

                    $allow_img = ['png', 'jpeg', 'jpg','webp'];

                    if($data == null){
                        $data = new TourModel;

                        $code_tour = IdGenerator::generate([
                            'table' => 'tb_tour', 
                            'field' => 'code', 
                            'length' => 10, 
                            'prefix' =>'NT'.date('ym'),
                            'reset_on_prefix_change' => true 
                        ]);

                        $data->code = $code_tour;

                        // ได้เป็นเมืองของญี่ปุ่น
                        $country = CountryModel::where('country_name_en', 'like', '%JAPAN%')->whereNull('deleted_at')->first();
                        $arr = array();
                        if($country){
                            $arr[] = "$country->id";
                            $data->country_id = json_encode($arr);
                        }else{
                            $data->country_id = "[]";
                        }

                        if ($call['banner_url']) {
    
                            $path = $call['banner_url'];
                            $filename = basename($path);
    
                            $lg = Image::make($path);
                            $ext = explode("/", $lg->mime());
                            $lg->resize(600, 600)->stream();
                            
                            $new = 'upload/tour/checkingroupapi/' . $filename;
                            
                            if (in_array($ext[1], $allow_img)) {
                                // Storage::disk('public')->put($new, $lg);
                                $data->image = $new;
                            }
                        }

                        $data->image_check_change = 2; // 1 ไม่ดึงรูปจาก Api , 2 ดึงรูปจาก Api
                        $data->name = $call['P_NAME'];
                        // $data->description = str_replace("\n","",$call['Highlight']); ไม่มี

                    }else{
                        if($data->country_check_change == null){
                            $country = CountryModel::where('country_name_en', 'like', '%JAPAN%')->whereNull('deleted_at')->first();
                            $arr = array();
                            if($country){
                                $arr[] = "$country->id";
                                $data->country_id = json_encode($arr);
                            }else{
                                $data->country_id = "[]";
                            }
                        }

                        if($data->name_check_change == null){
                            $data->name = $call['P_NAME'];
                        }

                        // if($data->description_check_change == null){
                        //     $data->description = str_replace("\n","",$call['Highlight']); ไม่มี
                        // }

                        if($data->image_check_change == 2){
                            if ($call['banner_url']) {

                                if ($data->image != null) {
                                    Storage::disk('public')->delete($data->image);
                                }
        
                                $path = $call['banner_url'];
                                $filename = basename($path);
        
                                $lg = Image::make($path);
                                $ext = explode("/", $lg->mime());
                                $lg->resize(600, 600)->stream();
                                
                                $new = 'upload/tour/checkingroupapi/' . $filename;
                                
                                if (in_array($ext[1], $allow_img)) {
                                    Storage::disk('public')->put($new, $lg);
                                    $data->image = $new;
                                }
    
                            }
                        }

                    }

                    $data->api_id = $call['P_ID'];
                    $data->code1 = $call['P_CODE'];
                    // $data->rating = $call['HotelStar']; ไม่มี

                    // จัดการ wholesale_id ให้เป็น ttn
                    $data->group_id = 3;
                    $data->wholesale_id = 5;

                    if($call['P_AIRLINE']){
                        $airline = TravelTypeModel::where('code',$call['P_AIRLINE'])->whereNull('deleted_at')->first();
                        if($airline){
                            $data->airline_id = $airline->id;
                        }
                    }

                    $allow_word = ['doc', 'docx'];
                    $allow_pdf = ['pdf'];

                    // if ($call['file_url']) {
                    //     $explode_url = explode('url=',$call['file_url']);
                    //     $url = $explode_url[1];
                    //     // $url = $call['file_url'];

                    //     $response = Http::get($url);

                    //     if ($response->successful()) {

                    //         if ($data->word_file != null) {
                    //             Storage::disk('public')->delete($data->word_file);
                    //         }
    
                    //         $filename = basename($url);
                    //         $ext = explode(".", $filename);
                    //         $new = 'upload/tour/word_file/checkingroupapi/' . $filename;
    
                    //         if (in_array($ext[1], $allow_word)) {
                    //             // Storage::disk('public')->put($new, $response->body());
                    //             $data->word_file = $new;
                    //         }
                    //     }
                    // }

                    // ไม่มี
                    // if ($call['FilePDF']) {
                    //     $url = $call['FilePDF'];

                    //     $response = Http::get($url);

                    //     if ($response->successful()) {

                    //         if ($data->pdf_file != null) {
                    //             Storage::disk('public')->delete($data->pdf_file);
                    //         }
    
                    //         $filename = basename($url);
                    //         $ext = explode(".", $filename);
                    //         $new = 'upload/tour/pdf_file/checkingroupapi/' . $filename;
    
                    //         if (in_array($ext[1], $allow_pdf)) {
                    //             Storage::disk('public')->put($new, $response->body());
                    //             $data->pdf_file = $new;
                    //         }
                    //     }
                    // }

                    $data->data_type = 2; // 1 system , 2 api
                    $data->api_type = "checkingroup";

                    dd(1);

                    if($data->save()){

                        $tour[] = $data->id;
                        $tour_api_id[] = $data->api_id;
                        
                        if($call['period']){
                            $max = array();
                            $cal1 = 0;
                            $cal2 = 0;
                            $cal3 = 0;
                            $cal4 = 0;
                            foreach($call['period'] as $pe){

                                // มาปรับแก้ให้สวย ๆ ได้อีก // ตอนนี้ต้องเช็ค $data->id ด้วยเผื่อ period_api_id ชนกันเพราะยิงหลาย api
                                $data3 = TourPeriodModel::where(['tour_id'=>$data->id, 'period_api_id'=>$pe['P_ID'], 'api_type'=>'ttn'])->whereNull('deleted_at')->first();

                                $price1 = $pe['P_ADULT']; // ผู้ใหญ่พักคู่
                                $price2 = $pe['P_SINGLE']; //ผู้ใหญ่พักเดี่ยว
                                // $price3 = $pe['Price_Child']; // เด็กมีเตียง ไม่มี
                                // $price4 = $pe['Price_ChildNB']; // เด็กไม่มีเตียง ไม่มี


                                if($data3 == null){
                                    $data3 = new TourPeriodModel;
                                    $data3->price1 = $price1;
                                    $data3->price2 = $price2;
                                    // $data3->price3 = $price3;
                                    // $data3->price4 = $price4;
                                }else{
                                    if($data3->price1 != $price1){
                                        $cal = $data3->price1 - $price1;
                                        if($cal > 0){
                                            $data3->old_price1 = $data3->price1;
                                            $data3->price1 = $price1;
                                            if($cal < $price1){
                                                $data3->special_price1 = $cal;
                                            }else{
                                                $data3->special_price1 = 0;
                                            }
                                            if (isset($price1) && $price1 != 0) {
                                                $cal1 = ($cal / $price1) * 100;
                                            } else {
                                                $cal1 = 0;
                                            }
                                            
                                        }else{
                                            $data3->old_price1 = 0.00;
                                            $data3->price1 = $price1;
                                            $data3->special_price1 = 0.00;
                                            $cal1 = 0;
                                        }
                                    }

                                    // ราคาผู้ใหญ่ พักเดี่ยว ไม่ต้องคำนวณเปอเซ็นต์ส่วนลด
                                    $data3->old_price2 = 0.00;
                                    $data3->price2 = $price2;
                                    $data3->special_price2 = 0.00;
                                    $cal2 = 0;

                                    // if($data3->price3 != $price3){
                                    //     $cal = $data3->price3 - $price3;
                                    //     if($cal > 0){
                                    //         $data3->old_price3 = $data3->price3;
                                    //         $data3->price3 = $price3;
                                    //         $data3->special_price3 = $cal;
                                    //         if($cal < $price3){
                                    //             $data3->special_price3 = $cal;
                                    //         }else{
                                    //             $data3->special_price3 = 0;
                                    //         }
                                    //         // $cal3 = ($cal / $price3) * 100;
                                    //         if (isset($price3) && $price3 != 0) {
                                    //             $cal3 = ($cal / $price3) * 100;
                                    //         } else {
                                    //             $cal3 = 0;
                                    //         }
                                    //     }else{
                                    //         $data3->old_price3 = 0.00;
                                    //         $data3->price3 = $price3;
                                    //         $data3->special_price3 = 0.00;
                                    //         $cal3 = 0;
                                    //     }
                                    // }

                                    // if($data3->price4 != $price4){
                                    //     $cal = $data3->price4 - $price4;
                                    //     if($cal > 0){
                                    //         $data3->old_price4 = $data3->price4;
                                    //         $data3->price4 = $price4;
                                    //         $data3->special_price4 = $cal;
                                    //         if($cal < $price4){
                                    //             $data3->special_price4 = $cal;
                                    //         }else{
                                    //             $data3->special_price4 = 0;
                                    //         }
                                    //         // $cal4 = ($cal / $price4) * 100;
                                    //         if (isset($price4) && $price4 != 0) {
                                    //             $cal4 = ($cal / $price4) * 100;
                                    //         } else {
                                    //             $cal4 = 0;
                                    //         }
                                    //     }else{
                                    //         $data3->old_price4 = 0.00;
                                    //         $data3->price4 = $price4;
                                    //         $data3->special_price4 = 0.00;
                                    //         $cal4 = 0;
                                    //     }
                                    // }
                                }

                                $data3->tour_id = $data->id;
                                $data3->period_api_id = $pe['P_ID'];
                                $data3->group_date = date('mY',strtotime($pe['P_DUE_START']));
                                $data3->start_date = $pe['P_DUE_START'];
                                $data3->end_date = $pe['P_DUE_END'];
                                $data3->day = $call['P_DAY']; // เอามาจากอันหลัก
                                $data3->night = $call['Night']; // เอามาจากอันหลัก
                                $data3->group = $pe['P_VOLUME'];
                                $data3->count = $pe['available'];

                                if($pe['status'] == "Yes"){
                                    $data3->status_period = 1;
                                }else if($pe['status'] == "No"){
                                    $data3->status_period = 3;
                                }
                                $data3->api_type = "ttn";

                                if($data3->save()){
                                    $period[] = $data3->id;
                                    $period_api_id[] = $data3->period_api_id;
                                }
                                
                                $calmax = max($cal1, $cal2);
                                // $calmax = max($cal1, $cal2, $cal3, $cal4);
                                array_push($max, $calmax);
                            }

                            // บันทึกจำนวนวัน และ ราคาเข้าไป tb_tour
                            $data4 = TourPeriodModel::where(['tour_id'=>$data->id, 'api_type'=>'ttn'])->whereNull('deleted_at')->orderby('start_date','asc')->first(); // asc
                            if($data4){
                                $num_day = "";
                                if($data4->day && $data4->night){
                                    $num_day = $data4->day.' วัน '.$data4->night.' คืน';
                                }
                                $price = $data4->price1;
                                $special_price = $data4->special_price1;
                                if($special_price && $special_price > 0){
                                    $net_price = $price - $special_price;
                                }else{
                                    $net_price = $price;
                                }

                                if($net_price && $net_price > 0){
                                    if($net_price <= 10000 ){
                                        $price_group = 1;
                                    }else if($net_price  > 10000 && $net_price <= 20000  ){
                                        $price_group = 2;
                                    }else if($net_price  > 20000 && $net_price <= 30000  ){
                                        $price_group = 3;
                                    }
                                    else if($net_price  > 30000 && $net_price <= 50000  ){
                                        $price_group = 4;
                                    }
                                    else if($net_price  > 50000 && $net_price <= 80000  ){
                                        $price_group = 5;
                                    }else if($net_price  > 80000  ){
                                        $price_group = 6;
                                    }
                                }else{
                                    $price_group = 0;
                                }
                                // TourModel::where(['id'=>$data->id, 'api_type'=>'ttn'])->update(['num_day'=> $num_day,'price'=> $price,'price_group'=> $price_group,'special_price'=> $special_price]);
                            }

                            // $maxCheck = max($max);
                            // if($maxCheck > 0 && $maxCheck >= 30){
                            //     TourModel::where(['id'=>$data->id, 'api_type'=>'ttn'])->update(['promotion1'=>'Y','promotion2'=>'N']); // เป็นโปรไฟไหม้
                            // }elseif($maxCheck > 0 && $maxCheck < 30){
                            //     TourModel::where(['id'=>$data->id, 'api_type'=>'ttn'])->update(['promotion1'=>'N','promotion2'=>'Y']); // เป็นโปรธรรมดา
                            // }else{
                            //     TourModel::where(['id'=>$data->id, 'api_type'=>'ttn'])->update(['promotion1'=>'N','promotion2'=>'N']); // ไม่เป็นโปรโมชั่น
                            // }

                        }

                        \DB::commit();
                    }else{
                        \DB::rollback();
                    }
                    
                } // end foreach
                
                // ลบข้อมูลทัวร์ และ Period
                // TourModel::whereNotIn('id',$tour)->whereNotIn('api_id',$tour_api_id)->where('api_type','ttn')->update(['deleted_at'=>date('Y-m-d H:i:s')]);
                // TourModel::whereIn('id',$tour)->whereIn('api_id',$tour_api_id)->where('api_type','ttn')->update(['deleted_at'=>null]);
                // TourPeriodModel::whereNotIn('id',$period)->whereNotIn('period_api_id',$period_api_id)->where('api_type','ttn')->update(['deleted_at'=>date('Y-m-d H:i:s')]);
                // TourPeriodModel::whereIn('id',$period)->whereIn('period_api_id',$period_api_id)->where('api_type','ttn')->update(['deleted_at'=>null]);
                
            }

        } catch (\Exception $e) {
            DB::rollback();
            $error_log = $e->getMessage();
            $error_line = $e->getLine();
            $type_log = 'backend';
            $error_url = url()->current();
            $log_id = LogsController::save_logbackend($type_log, $error_log, $error_line, $error_url);
        }
    }
}
