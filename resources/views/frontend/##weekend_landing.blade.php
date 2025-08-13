<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    @include("frontend.layout.inc_header")
    <?php $pageName="weekend";?>
</head>

<body>
    @include("frontend.layout.inc_topmenu")
    <section id="weekendpage" class="wrapperPages">
        <div class="container-fluid g-0 overflow-hidden">
            <div class="row">
                <div class="col">
                    <div class="bannereach-left">
                        <img src="{{asset(@$data->img_banner)}}" alt="">
                        <div class="bannercaption">
                            <h1>ทัวร์{{@$data->holiday}}</h1>
                            {!! $data->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="socialshare">
                <span>แชร์</span>
                <ul>
                    @php
                        $contact = App\Models\Backend\ContactModel::find(1);
                        $urlSharer = url("weekend-landing/".$calen_id."/".$slug);
                        $lineUrl = "https://social-plugins.line.me/lineit/share?url=".$urlSharer;
                        $facebookUrl = "https://www.facebook.com/sharer.php?u=".$urlSharer;
                        $twitterUrl = "https://twitter.com/intent/tweet?url={$urlSharer}";
                    @endphp
                        <li><a href="{{url($lineUrl)}}" target="_blank">
                                            <img src="{{asset('frontend/images/line_share.svg')}}" alt="">
                        </a></li>
                         <li><a href="{{url($facebookUrl)}}" target="_blank">
                                            <img src="{{asset('frontend/images/facebook_share.svg')}}" alt="">
                            </a></li>
                        <li><a href="{{url($twitterUrl)}}" target="_blank">
                                <img src="{{asset('frontend/images/twitter_share.svg')}}" alt="">
                        </a></li>
                </ul>
            </div>
            <div class="row mt-5">
                <div class="col contentde">
                    {!! $data->detail !!}
                </div>
            </div>
        </div>
        <div class="calendarDate mt-5 mb-5">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="titletopic text-center">
                            @php
                                $start_date = \App\Helpers\Helper::DayMonthYearthai($data->start_date);
                                $end_date = \App\Helpers\Helper::DayMonthYearthai($data->end_date);

                                $start = \Carbon\Carbon::createFromFormat('Y-m-d', $data->start_date);
                                $end = \Carbon\Carbon::createFromFormat('Y-m-d', $data->end_date);

                                $period_date = \Carbon\CarbonPeriod::create($start, $end);
                               
                            @endphp
                            <h2>ปฏิทิน{{@$data->holiday}} {{@$start_date}} - {{@$end_date}}</h2>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col-lg-8 offset-lg-2">
                        <div class="weekslider owl-carousel owl-theme">
                            @foreach($period_date as $per_date)
                            <div class="item">
                                <div class="datecalendarshow text-center">
                                    <span class="month">{{ \App\Helpers\Helper::Monththai($per_date->format('Y-m-d')) }} </span>
                                    <h2> {{ @$per_date->format('d') }} </h2>
                                    <span class="day">วัน{{ \App\Helpers\Helper::Daythai($per_date->format('Y-m-d')) }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hotcountry_weekend">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="titletopic text-center">
                            <h2>ทัวร์{{@$data->holiday}} เส้นทางยอดนิยม</h2>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <?php  
                        $re_country = array();
                        $tour_id = array();
                        $country = array();
                        foreach($row as $k => $pe){
                            $find_tour = App\Models\Backend\TourModel::find($k);
                            $re_country = array_merge($re_country,json_decode($find_tour->country_id,true));
                            $tour_id[] = $k;
                            // dd($pe['tour']->id,$tour_id);
                        }
                
                        $re_country = array_unique($re_country);
                        foreach ($re_country as $re) {
                            $country[] = App\Models\Backend\CountryModel::where('id',$re)->where('deleted_at',null)->get(); 
                        }
                    ?>
                    @if($country)
                        @foreach($country as  $coun)
                            @foreach ($coun as $c)
                            @php
                                $total_tour = App\Models\Backend\TourModel::whereIn('id',$tour_id)->where('country_id','like','%"'.$c->id.'"%')->where('status','on')->where('deleted_at',null)->count(); 
                            @endphp
                                <div class="col-4 col-lg-2">
                                    <div class="groupsFlag">
                                        <div class="flagCir mb-2">
                                            <a href="{{url('weekend-landing/'.$calen_id.'/'.$c->id)}}"><img src="{{asset($c->img_icon)}}" alt=""></a>
                                        </div>
                                        <a href="{{url('weekend-landing/'.$calen_id.'/'.$c->id)}}"> ทัวร์{{$c->country_name_th}} {{@$data->holiday}}</a> <br>
                                        <span>{{$total_tour}} รายการ</span>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
       
        
        <div class="reccommend_week mt-4">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="titletopic text-center">
                            <h2>โปรแกรมทัวร์{{@$data->holiday}}แนะนำ</h2>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    <div class="col">
                        <div class="recweekslide owl-carousel owl-theme">
                        @php
                            $month = ['','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
                        @endphp
                        
                        @foreach($period as $pre)
                            <?php 

                                $country_re = App\Models\Backend\CountryModel::whereIn('id',json_decode($pre['tour']->country_id,true))->get();
                                $airline_re = \App\Models\Backend\TravelTypeModel::find($pre['tour']->airline_id);
                            ?>
                            
                            @if(count($pre['recomand']) > 0)
                                <div class="item">
                                    <div class="showvertiGroup">
                                        <div class="boxwhiteshd hoverstyle">
                                            <figure>
                                                <a href="{{url('tour/'.$pre['tour']->slug)}}">
                                                    <img src="{{asset($pre['tour']->image)}}" alt="">
                                                </a>
                                            </figure>
                                           
                                            {{-- <div class="tagontop">
                                                <li class="bgor"><a href="{{url('tour/'.$pre['tour']->slug)}}">{{$pre['tour']->num_day}}</a> </li>
                                                <li class="bgblue"><a href="{{url('tour/'.$pre['tour']->slug)}}"><i class="fi fi-rr-marker"></i>
                                                        ทัวร์ @foreach($country_re as $coun) {{$coun->country_name_th}} @endforeach</a> </li>
                                                <li>สายการบิน <a href="{{url('tour/'.$pre['tour']->slug)}}"> <img src="{{asset(@$airline_re->image)}}" alt=""></a>
                                                </li>
                                            </div> --}}
                                            <div class="contenttourshw">
                                                <div class="codeandhotel">
                                                    <li>รหัสทัวร์ : <span class="bluetext">@if(@$pre['tour']->code1_check) {{@$pre['tour']->code1}} @else {{@$pre['tour']->code}} @endif</span> </li>
                                                    <li class="rating">โรงแรม
                                                        @if($pre['tour']->rating > 0)
                                                                <a href="javascript:void(0);" onclick="Check_filter({{$pre['tour']->rating}},'rating')">
                                                                    @for($i=1; $i <= @$pre['tour']->rating; $i++)
                                                                    <i class="bi bi-star-fill"></i>
                                                                    @endfor
                                                                </a>
                                                            @else
                                                            <a href="javascript:void(0);" onclick="Check_filter(0,'rating')">
                                                        @endif
                                                    </li>
                                                </div>
                                                <hr>
                                                <div class="locationnewd mb-2 mt-2">
                                                    <li> <a> <i class="fi fi-rr-marker"></i> @foreach($country_re as $coun){{$coun->country_name_th?$coun->country_name_th:$coun->country_name_en}}@endforeach</a></li>
                                                    <li class="datetour"><a>{{$pre['tour']->num_day}}</a> </li>
                                                    <li class="airlines"> 
                                                        สายการบิน <img src="{{asset(@$airline_re->image)}}" alt=""> 
                                                    </li>
                                                </div>
                                                <h3><a href="{{url('tour/'.$pre['tour']->slug)}}"> {{ @$pre['tour']->name }}</a></h3>
                                                <div class="listperiod">
                                                    @foreach ($pre['recomand'] as $pe)
                                                    <li><span class="month">{{$month[date('n',strtotime($pe[0]->start_date))]}}</span>
                                                        @php $toEnd = count($pe);  @endphp
                                                        @foreach($pe as $key => $p)
                                                            {{date('d',strtotime($p->start_date))}} - {{date('d',strtotime($p->end_date))}} @if(0 !== --$toEnd)/@endif
                                                        @endforeach
                                                    </li><br>
                                                    @endforeach
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-7">
                                                        <div class="pricegroup">
                                                            @if($pre['tour']->special_price > 0)
                                                                @php $tv_price = $pre['tour']->price - $pre['tour']->special_price; @endphp
                                                                <span class="originalprice">ปกติ {{ number_format($pre['tour']->price,0) }} </span><br>
                                                                เริ่ม<span class="saleprice"> {{ number_format(@$tv_price,0) }} บาท</span>
                                                            @else
                                                                เริ่ม<span class="saleprice"> {{ number_format($pre['tour']->price,0) }} บาท</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 ps-0">
                                                        <a href="{{url('tour/'.$pre['tour']->slug)}}" class="btn-main-og morebtnog">รายละเอียด</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-3 mt-lg-5">
                <div class="col-lg-4 col-xl-3">
                    <div class="row">
                        <div class="col-5 col-lg-12">
                            {{-- @include("frontend.layout.inc_sidefilter") --}}
                            <section id="sortfilter">
                                <form action="" method="POST" enctype="multipart/form-data"  id="searchForm">
                                    @csrf
                                <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                                    <div class="boxfilter">
                                        <div class="row">
                                            <div class="col-8 col-lg-9">
                                                <div class="titletopic">
                                                    <h2>ตัวกรองที่เลือก</h2>
                                                </div>
                                                <div class="filtermenu">
                                                    <ul id="show_select">
                                                        
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-4 col-lg-3 text-end">
                                                <a href="javascript:void(0)" onclick="window.location.reload()" class="refreshde" >ล้างค่า</a>
                                            </div>
                                        </div>
                                    </div>
                                <div class="boxfilter mt-3">
                                        @php
                                            $data_type = ['country' => array(),'city' => array(),'day' => array(),'price' => array(),'airline' => array(),'rating' => array()];
                                        @endphp
                                        @if(isset($filter['country']) && count($filter['country']) > 0)
                                        <div class="titletopic">
                                            <h2>ประเทศ</h2>
                                        </div>
                                        <div class="filtermenu">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="ชื่อประเทศ" name="country_search" id="country_search"  aria-label="air"
                                                    aria-describedby="button-addon2">
                                                <button class="btn btn-outline-secondary" type="button" id="button-addon2" onclick="Search_country()"><i
                                                        class="fi fi-rr-search"></i></button>
                                            </div>
                                            <ul id="show_country">
                                                @php
                                                    $check_country = array();
                                                    $country_num = array();
                                                    $country = array();
                                                    $tour_id = array();
                                                    foreach ($filter['country'] as $id => $f_country) {
                                                        $country = array_merge($country,json_decode($f_country,true));
                                                        $tour_id[] = $id;
                                                    }
                                                    $country = array_unique($country);
                                                    foreach ($country as $re) {
                                                        $data_country[] = App\Models\Backend\CountryModel::where('id',$re)->get(); 
                                                    }
                                                @endphp
                                                @if(isset($data_country))
                                                    @foreach ($data_country as $n => $coun)
                                                        @if($n <= 9)
                                                            @foreach ($coun as  $c)
                                                                @php
                                                                    $data_type['country'][] = $c;
                                                                    $total_tour = App\Models\Backend\TourModel::whereIn('id',$tour_id)->where('country_id','like','%"'.$c->id.'"%')/* ->where('status','on')->where('deleted_at',null) */;
                                                                    // ราคาถูกสุด
                                                                    if($orderby_data == 1){
                                                                        $total_tour = $total_tour->orderby('price','asc');
                                                                    }
                                                                    // ยอดวิวเยอะสุด
                                                                    if($orderby_data == 2){
                                                                        $total_tour = $total_tour->orderby('tour_views','desc');
                                                                    }
                                                                    //ลดราคา
                                                                    if($orderby_data == 3){
                                                                        $total_tour = $total_tour->where('special_price','>',0)->orderby('special_price','desc');
                                                                    }
                                                                    //มีโปรโมชั่น
                                                                    if($orderby_data == 4){
                                                                        $check_period = array();
                                                                        $check_p = App\Models\Backend\TourPeriodModel::whereNotNull('promotion_id')->whereDate('pro_start_date','<=',date('Y-m-d'))->whereDate('pro_end_date','>=',date('Y-m-d'))->get(['tour_id']);
                                                                        foreach($check_p  as $check){
                                                                            $check_period[] = $check->tour_id;
                                                                        }
                                                                        if(count($check_period)){
                                                                            $total_tour = $total_tour->whereIn('id',$check_period)/* ->where('promotion2','Y') */;
                                                                        }  
                                                                    }
                                                                    $total_tour = $total_tour->count(); 
                                                                    $check_country[] = $c->id;
                                                                    $country_num[$c->id] = $total_tour;
                                                                @endphp
                                                                    <li><label class="check-container"> {{$c->country_name_th?$c->country_name_th:$c->country_name_en}}
                                                                        {{-- <input type="checkbox" @if($c->id == $slug) checked @endif name="country" id="country{{$c->id}}" onclick="UncheckdCountry({{$c->id}})" value="{{$c->id}}"> --}}
                                                                        <input type="checkbox" @if($c->id == $slug) checked @endif name="country" id="country{{$c->id}}" onclick="Check_filter({{$c->id}},'country')" value="{{$c->id}}">
                                                                        <span class="checkmark"></span>
                                                                        <div class="count">({{$total_tour}})</div>
                                                                    </label></li>
                                                            @endforeach
                                                        @elseif($n > 9) 
                                                            <div id="morecountry" class="collapse">
                                                                @foreach ($coun as $c)
                                                                    @php
                                                                        $data_type['country'][] = $c;
                                                                        $total_tour = App\Models\Backend\TourModel::whereIn('id',$tour_id)->where('country_id','like','%"'.$c->id.'"%')/* ->where('status','on')->where('deleted_at',null) */;
                                                                        // ราคาถูกสุด
                                                                        if($orderby_data == 1){
                                                                            $total_tour = $total_tour->orderby('price','asc');
                                                                        }
                                                                        // ยอดวิวเยอะสุด
                                                                        if($orderby_data == 2){
                                                                            $total_tour = $total_tour->orderby('tour_views','desc');
                                                                        }
                                                                        //ลดราคา
                                                                        if($orderby_data == 3){
                                                                            $total_tour = $total_tour->where('special_price','>',0)->orderby('special_price','desc');
                                                                        }
                                                                        //มีโปรโมชั่น
                                                                        if($orderby_data == 4){
                                                                            $check_period = array();
                                                                            $check_p = App\Models\Backend\TourPeriodModel::whereNotNull('promotion_id')->whereDate('pro_start_date','<=',date('Y-m-d'))->whereDate('pro_end_date','>=',date('Y-m-d'))->get(['tour_id']);
                                                                            foreach($check_p  as $check){
                                                                                $check_period[] = $check->tour_id;
                                                                            }
                                                                            if(count($check_period)){
                                                                                $total_tour = $total_tour->whereIn('id',$check_period)/* ->where('promotion2','Y') */;
                                                                            }  
                                                                        }
                                                                        $total_tour = $total_tour->count(); 
                                                                        $check_country[] = $c->id;
                                                                        $country_num[$c->id] = $total_tour;
                                                                    @endphp
                                                                    <li><label class="check-container"> {{$c->country_name_th?$c->country_name_th:$c->country_name_en}}
                                                                        <input type="checkbox" name="country" id="country{{$c->id}}" onclick="Check_filter({{$c->id}},'country')" value="{{$c->id}}">
                                                                        <span class="checkmark"></span>
                                                                        <div class="count">({{$total_tour}})</div>
                                                                    </label></li> 
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                    @if(count($data_country) > 9)<a data-bs-toggle="collapse" data-bs-target="#morecountry" class="seemore"> ดูเพิ่มเติม</a> @endif
                                                @endif
                                            </ul>
                                        </div>
                                        <input type="hidden" id="country_data" value="{{ json_encode($check_country) }}">
                                        <input type="hidden" id="country_num" value="{{ json_encode($country_num) }}">
                                        <hr>
                                        @endif
                                        @if(isset($filter['city']) && count($filter['city']) > 0)
                                        <div class="titletopic">
                                            <h2>เมือง</h2>
                                        </div>
                                        <div class="filtermenu">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="ชื่อเมือง" name="city_search" id="city_search"  aria-label="air"
                                                    aria-describedby="button-addon2">
                                                <button class="btn btn-outline-secondary" type="button" id="button-addon2" onclick="Search_city()"><i
                                                        class="fi fi-rr-search"></i></button>
                                            </div>
                                            <ul id="show_city">
                                                @php
                                                    $check_city = array();
                                                    $city_num = array();
                                                    $city = array();
                                                    $t_id = array();
                                                    foreach ($filter['city'] as $id => $f_city) {
                                                        $city = array_merge($city,json_decode($f_city,true));
                                                        $t_id[] = $id;
                                                    }
                                                    $city = array_unique($city);
                                                    foreach ($city as $re) {
                                                        $data_city[] = App\Models\Backend\CityModel::where('id',$re)->get(); 
                                                    }
                                                    // dd($filter['city']);
                                                @endphp
                                                @if(isset($data_city))
                                                    @foreach ($data_city as $n => $coun)
                                                        @if($n <= 9)
                                                            @foreach ($coun as  $c)
                                                                @php
                                                                    $data_type['city'][] = $c;
                                                                    $tour = App\Models\Backend\TourModel::whereIn('id',$t_id)->where('city_id','like','%"'.$c->id.'"%')/* ->where('status','on')->where('deleted_at',null) */;
                                                                        // ราคาถูกสุด
                                                                        if($orderby_data == 1){
                                                                            $tour = $tour->orderby('price','asc');
                                                                        }
                                                                        // ยอดวิวเยอะสุด
                                                                        if($orderby_data == 2){
                                                                            $tour = $tour->orderby('tour_views','desc');
                                                                        }
                                                                        //ลดราคา
                                                                        if($orderby_data == 3){
                                                                            $tour = $tour->where('special_price','>',0)->orderby('special_price','desc');
                                                                        }
                                                                        //มีโปรโมชั่น
                                                                        if($orderby_data == 4){
                                                                            $check_period = array();
                                                                            $check_p = App\Models\Backend\TourPeriodModel::whereNotNull('promotion_id')->whereDate('pro_start_date','<=',date('Y-m-d'))->whereDate('pro_end_date','>=',date('Y-m-d'))->get(['tour_id']);
                                                                            foreach($check_p  as $check){
                                                                                $check_period[] = $check->tour_id;
                                                                            }
                                                                            if(count($check_period)){
                                                                                $tour = $tour->whereIn('id',$check_period)/* ->where('promotion2','Y') */;
                                                                            }  
                                                                        }
                                                                    $tour = $tour->count(); 
                                                                    $check_city[] = $c->id;
                                                                    $city_num[$c->id] = $tour;
                                                                @endphp
                                                                    <li><label class="check-container"> {{$c->city_name_th?$c->city_name_th:$c->city_name_en}}
                                                                        {{-- <input type="checkbox" name="city" id="city{{$c->id}}" onclick="UncheckdCity({{$c->id}})" value="{{$c->id}}"> --}}
                                                                        <input type="checkbox" name="city" id="city{{$c->id}}" onclick="Check_filter({{$c->id}},'city')" value="{{$c->id}}">
                                                                        <span class="checkmark"></span>
                                                                        <div class="count">({{$tour}}) </div>
                                                                    </label></li>
                                                            @endforeach
                                                        @elseif($n > 9)  
                                                            <div id="moreprovince" class="collapse">
                                                                @foreach ($coun as $c)
                                                                    @php
                                                                        $data_type['city'][] = $c;
                                                                        $tour = App\Models\Backend\TourModel::whereIn('id',$t_id)->where('city_id','like','%"'.$c->id.'"%')/* ->where('status','on')->where('deleted_at',null) */;
                                                                        // ราคาถูกสุด
                                                                        if($orderby_data == 1){
                                                                            $tour = $tour->orderby('price','asc');
                                                                        }
                                                                        // ยอดวิวเยอะสุด
                                                                        if($orderby_data == 2){
                                                                            $tour = $tour->orderby('tour_views','desc');
                                                                        }
                                                                        //ลดราคา
                                                                        if($orderby_data == 3){
                                                                            $tour = $tour->where('special_price','>',0)->orderby('special_price','desc');
                                                                        }
                                                                        //มีโปรโมชั่น
                                                                        if($orderby_data == 4){
                                                                            $check_period = array();
                                                                            $check_p = App\Models\Backend\TourPeriodModel::whereNotNull('promotion_id')->whereDate('pro_start_date','<=',date('Y-m-d'))->whereDate('pro_end_date','>=',date('Y-m-d'))->get(['tour_id']);
                                                                            foreach($check_p  as $check){
                                                                                $check_period[] = $check->tour_id;
                                                                            }
                                                                            if(count($check_period)){
                                                                                $tour = $tour->whereIn('id',$check_period)/* ->where('promotion2','Y') */;
                                                                            }  
                                                                        }
                                                                        $tour = $tour->count(); 
                                                                        $check_city[] = $c->id;
                                                                        $city_num[$c->id] = $tour;
                                                                    @endphp
                                                                    <li><label class="check-container">  {{$c->city_name_th?$c->city_name_th:$c->city_name_en}}
                                                                        <input type="checkbox" name="city" id="city{{$c->id}}" onclick="Check_filter({{$c->id}},'city')" value="{{$c->id}}">
                                                                        <span class="checkmark"></span>
                                                                        <div class="count">({{$tour}})</div>
                                                                    </label></li>
                                                                @endforeach
                                                            </div>     
                                                        @endif
                                                    @endforeach
                                                    @if(count($data_city) > 9)<a data-bs-toggle="collapse" data-bs-target="#moreprovince" class="seemore"> ดูเพิ่มเติม</a> @endif
                                                @endif
                                            </ul>
                                        </div>
                                        <input type="hidden" id="city_data" value="{{ json_encode($check_city) }}">
                                        <input type="hidden" id="city_num" value="{{ json_encode($city_num) }}">
                                        <hr>
                                        @endif
                                        <input type="hidden" class="form-control" id="calen_id" name="calen_id" value="{{$calen_id}}">
                                        <input type="hidden" class="form-control" id="start_date" name="start_date" value="{{$data->start_date}}">
                                        <input type="hidden" class="form-control" id="end_date" name="end_date" value="{{$data->end_date}}">
                                        <input type="hidden" class="form-control" id="slug" name="slug" value="{{$slug}}">
                                        <input type="hidden" name="orderby_data" id="orderby_data" value="{{@$orderby_data}}">
                                        @if($filter)
                                            <div class="titletopic">
                                                <h2>ช่วงราคา</h2>
                                            </div>
                                            <div class="filtermenu">
                                                <ul id="show_total">
                                                <li><label class="check-container"> ทั้งหมด
                                                        <input type="checkbox"  id="price7"  onclick="UncheckdPrice(7)"  >
                                                        <span class="checkmark"></span>
                                                        <div class="count">({{$num_price}})</div>
                                                </label></li> 
                                                </ul>
                                                <ul id="show_price">
                                                @if(isset($filter['price'][0]))
                                                    @php
                                                        $data_type['price'][] = 1;
                                                    @endphp
                                                    <li><label class="check-container"> ต่ำกว่า 10,000
                                                            {{-- <input type="checkbox" name="price[]" id="price1" onclick="UncheckdPrice(1)" value="1" > --}}
                                                            <input type="checkbox" name="price[]" id="price1" onclick="Check_filter(1,'price')" value="1" >
                                                            <span class="checkmark"></span>
                                                            <div class="count">({{count($filter['price'][0])}})</div>
                                                        </label></li>
                                                    @endif
                                                    @if(isset($filter['price'][1]))
                                                    @php
                                                        $data_type['price'][] = 2;
                                                    @endphp
                                                    <li><label class="check-container"> 10,001-20,000
                                                            {{-- <input type="checkbox" name="price[]" id="price2" onclick="UncheckdPrice(2)" value="2"> --}}
                                                            <input type="checkbox" name="price[]" id="price2" onclick="Check_filter(2,'price')" value="2">
                                                            <span class="checkmark"></span>
                                                            <div class="count">({{count($filter['price'][1])}})</div>
                                                        </label></li>
                                                    @endif
                                                    @if(isset($filter['price'][2]))
                                                    @php
                                                        $data_type['price'][] = 3;
                                                    @endphp
                                                    <li><label class="check-container"> 20,001-30,000
                                                            {{-- <input type="checkbox" name="price[]" id="price3" onclick="UncheckdPrice(3)" value="3"> --}}
                                                            <input type="checkbox" name="price[]" id="price3" onclick="Check_filter(3,'price')" value="3">
                                                            <span class="checkmark"></span>
                                                            <div class="count">({{count($filter['price'][2])}})</div>
                                                        </label></li>
                                                    @endif
                                                    @if(isset($filter['price'][3]))   
                                                    @php
                                                        $data_type['price'][] = 4;
                                                    @endphp 
                                                    <li><label class="check-container"> 30,001-50,000
                                                            {{-- <input type="checkbox" name="price" id="price4" onclick="UncheckdPrice(4)" value="4"> --}}
                                                            <input type="checkbox" name="price[]" id="price4" onclick="Check_filter(4,'price')" value="4">
                                                            <span class="checkmark" ></span>
                                                            <div class="count">({{count($filter['price'][3])}})</div>
                                                        </label></li>
                                                    @endif
                                                    @if(isset($filter['price'][4]))
                                                    @php
                                                        $data_type['price'][] = 5;
                                                    @endphp
                                                    <li><label class="check-container"> 50,001-80,000
                                                            {{-- <input type="checkbox" name="price" id="price5" onclick="UncheckdPrice(5)" value="5"> --}}
                                                            <input type="checkbox" name="price[]" id="price5" onclick="Check_filter(5,'price')" value="5">
                                                            <span class="checkmark"></span>
                                                            <div class="count">({{count($filter['price'][4])}})</div>
                                                        </label></li>
                                                    @endif
                                                    @if(isset($filter['price'][5]))
                                                    @php
                                                        $data_type['price'][] = 6;
                                                    @endphp
                                                    <li><label class="check-container"> 80,001 ขึ้นไป
                                                            {{-- <input type="checkbox" name="price" id="price6" onclick="UncheckdPrice(6)" value="6"> --}}
                                                            <input type="checkbox" name="price[]" id="price6" onclick="Check_filter(6,'price')" value="6">
                                                            <span class="checkmark"></span>
                                                            <div class="count">({{count($filter['price'][5])}})</div>
                                                        </label></li>
                                                    @endif
                                                </ul>
                                            </div>
                                            <hr>
                                        @endif
                                        @if(isset($filter['day']) && count($filter['day']) > 0)
                                        <div class="titletopic">
                                            <h2>เลือกจำนวนวัน</h2>
                                        </div>
                                        <div class="filtermenu">
                                            <ul id="show_day">
                                                @foreach ($filter['day'] as $day => $num)
                                                    @php
                                                        $data_type['day'][] = $day;
                                                    @endphp
                                                    {{-- @if($day <= 3) --}}
                                                    <li>
                                                        <label class="check-container"> {{$day}} วัน
                                                            {{-- <input type="checkbox" name="day" id="day{{$day}}" onclick="UncheckdDay({{$day}})" value="{{$day}}"> --}}
                                                            <input type="checkbox" name="day" id="day{{$day}}" onclick="Check_filter({{$day}},'day')" value="{{$day}}">
                                                            <span class="checkmark"></span>
                                                            <div class="count">({{count($num)}})</div>
                                                        </label>
                                                    </li>
                                                    {{-- @endif --}}
                                                @endforeach
                                                {{-- <div id="moreprd" class="collapse">
                                                    @foreach ($filter['day'] as $day => $num)
                                                        @if($day > 3)
                                                        <li>
                                                            <label class="check-container"> {{$day}} วัน
                                                                <input type="checkbox" name="day" id="day{{$day}}" onclick="UncheckdDay({{$day}})" value="{{$day}}">
                                                                <span class="checkmark"></span>
                                                                <div class="count">({{count($num)}})</div>
                                                            </label>
                                                        </li>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                @if(count($filter['day']) > 3)<a data-bs-toggle="collapse" data-bs-target="#moreprd" class="seemore"> ดูเพิ่มเติม</a>@endif --}}
                                            </ul>
                                        </div>
                                        <hr>
                                        @endif
                                        @if(isset($filter['airline']) && count($filter['airline']) > 0)
                                        <div class="titletopic">
                                            <h2>สายการบิน</h2>
                                        </div>
                                        <div class="filtermenu">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="ชื่อสายการบิน" name="search_airline" id="search_airline"  aria-label="air"
                                                    aria-describedby="button-addon2">
                                                <button class="btn btn-outline-secondary" type="button" id="button-addon2" onclick="Search_airline()"><i
                                                        class="fi fi-rr-search"></i></button>
                                            </div>
                                            @php
                                                $airline_id = array();
                                                $airline_num = array();
                                            @endphp
                                            <ul id="show_air">
                                                @php
                                                    $check_airline = 0;
                                                @endphp
                                                @foreach ($filter['airline'] as $air => $num)
                                                @php
                                                     $airline = App\Models\Backend\TravelTypeModel::find($air);
                                                     $data_type['airline'][] = $airline;
                                                     $airline_id[] = $air;
                                                     $airline_num[$airline->id] = count($num);
                                                @endphp
                                                    @if($check_airline <= 9)
                                                    <li><label class="check-container">@if($airline->image)<img src="{{asset($airline->image)}}" alt="">@endif {{$airline->travel_name}}
                                                            {{-- <input type="checkbox" name="airline" id="airline{{$airline->id}}" onclick="UncheckdAirline({{$airline->id}})" value="{{$airline->id}}"> --}}
                                                            <input type="checkbox" name="airline" id="airline{{$airline->id}}" onclick="Check_filter({{$airline->id}},'airline')" value="{{$airline->id}}">
                                                            <span class="checkmark"></span>
                                                            <div class="count">({{count($num)}})</div>
                                                        </label></li>
                                                    @php
                                                        $check_airline++;
                                                        if(count($airline_id) > 9){
                                                            break;
                                                        }
                                                    @endphp
                                                    @endif
                                                @endforeach
                                                    <div id="moreair" class="collapse">
                                                        @foreach ($filter['airline'] as $air => $num)
                                                            @if($check_airline > 9 && !in_array($air,$airline_id))
                                                            @php
                                                                $airline = App\Models\Backend\TravelTypeModel::find($air);
                                                                $data_type['airline'][] = $airline;
                                                                $airline_id[] = $air;
                                                                $airline_num[$airline->id] = count($num);
                                                            @endphp
                                                            <li><label class="check-container">@if($airline->image)<img src="{{asset($airline->image)}}" alt="">@endif {{$airline->travel_name}}
                                                                <input type="checkbox" name="airline" id="airline{{$airline->id}}" onclick="Check_filter({{$airline->id}},'airline')" value="{{$airline->id}}">
                                                                <span class="checkmark"></span>
                                                                <div class="count">({{count($num)}})</div>
                                                            </label></li>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                    @if(count($airline_id) > 9)<a data-bs-toggle="collapse" data-bs-target="#moreair" class="seemore"> ดูเพิ่มเติม</a>  @endif
                                            </ul>
                                            <input type="hidden" id="airline_num" value="{{ json_encode($airline_num) }}" >
                                            <input type="hidden" id="airline_id" value="{{ json_encode($airline_id) }}" >
                                        </div>
                                        <hr>
                                        @endif
                                        @if($filter)
                                            <div class="titletopic">
                                                <h2>ระดับดาวที่พัก</h2>
                                            </div>
                                            <div class="filtermenu">
                                                <ul id="show_rating">
                                                    @if(isset($filter['rating'][0]))
                                                    @php
                                                         $data_type['rating'][] = 5;
                                                    @endphp
                                                    <li><label class="check-container">
                                                            <div class="rating">
                                                                <i class="bi bi-star-fill"></i> <i class="bi bi-star-fill"></i> 
                                                                <i class="bi bi-star-fill"></i> <i class="bi bi-star-fill"></i> 
                                                                <i class="bi bi-star-fill"></i>
                                                            </div>
                                                            {{-- <input type="checkbox" name="rating" id="rating6" onclick="UncheckdRating(6)" value="5"> --}}
                                                            <input type="checkbox" name="rating" id="rating5" onclick="Check_filter(5,'rating')" value="5">
                                                            <span class="checkmark"></span>
                                                            <div class="count">({{count($filter['rating'][0])}})</div>
                                                        </label></li>
                                                    @endif
                                                    @if(isset($filter['rating'][1]))
                                                    @php
                                                         $data_type['rating'][] = 4;
                                                    @endphp
                                                    <li><label class="check-container">
                                                            <div class="rating">
                                                                <i class="bi bi-star-fill"></i> <i class="bi bi-star-fill"></i> <i
                                                                    class="bi bi-star-fill"></i> <i class="bi bi-star-fill"></i>
                                                            </div>
                                                            {{-- <input type="checkbox" name="rating" id="rating5" onclick="UncheckdRating(5,'rating')" value="5"> --}}
                                                            <input type="checkbox" name="rating" id="rating4" onclick="Check_filter(4,'rating')" value="4">
                                                            <span class="checkmark"></span>
                                                            <div class="count">({{count($filter['rating'][1])}})</div>
                                                        </label></li>
                                                    @endif
                                                    @if(isset($filter['rating'][2]))
                                                    @php
                                                         $data_type['rating'][] = 3;
                                                    @endphp
                                                    <li><label class="check-container">
                                                            <div class="rating">
                                                                <i class="bi bi-star-fill"></i> <i class="bi bi-star-fill"></i> <i
                                                                    class="bi bi-star-fill"></i>
                                                            </div>
                                                            {{-- <input type="checkbox" name="rating" id="rating4" onclick="UncheckdRating(4)" value="3"> --}}
                                                            <input type="checkbox" name="rating" id="rating3" onclick="Check_filter(3,'rating')" value="3">
                                                            <span class="checkmark"></span>
                                                            <div class="count">({{count($filter['rating'][2])}})</div>
                                                        </label></li>
                                                    @endif
                                                    @if(isset($filter['rating'][3]))
                                                    @php
                                                         $data_type['rating'][] = 2;
                                                    @endphp
                                                    <li><label class="check-container">
                                                            <div class="rating">
                                                                <i class="bi bi-star-fill"></i> <i class="bi bi-star-fill"></i> 
                                                            </div>
                                                            <input type="checkbox" name="rating" id="rating2" onclick="Check_filter(2,'rating')" value="2">
                                                            {{-- <input type="checkbox" name="rating" id="rating3" onclick="UncheckdRating(3)" value="2"> --}}
                                                            <span class="checkmark"></span>
                                                            <div class="count">({{count($filter['rating'][3])}})</div>
                                                        </label></li>
                                                    @endif
                                                    @if(isset($filter['rating'][4]))
                                                    @php
                                                         $data_type['rating'][] = 1;
                                                    @endphp
                                                    <li><label class="check-container">
                                                            <div class="rating">
                                                                <i class="bi bi-star-fill"></i> 
                                                            </div>
                                                            {{-- <input type="checkbox" name="rating" id="rating2" onclick="UncheckdRating(2)" value="1"> --}}
                                                            <input type="checkbox" name="rating" id="rating1" onclick="Check_filter(1,'rating')" value="1">
                                                            <span class="checkmark"></span>
                                                            <div class="count">({{count($filter['rating'][4])}})</div>
                                                        </label></li>
                                                    @endif
                                                    @if(isset($filter['rating'][5]))
                                                    @php
                                                         $data_type['rating'][] = 0;
                                                    @endphp
                                                    <li><label class="check-container"> ไม่มีระดับดาวที่พัก
                                                            <input type="checkbox" name="rating" id="rating0" onclick="Check_filter(0,'rating')" value="0">
                                                            <span class="checkmark"></span>
                                                            <div class="count">({{count($filter['rating'][5])}})</div>
                                                        </label></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
                                    <button class="btn btnfilter" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"
                                        aria-controls="offcanvasBottom">ตัวกรอง</button>
                                    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom"
                                        aria-labelledby="offcanvasBottomLabel">
                                        <div class="offcanvas-header">
                                            <h5 class="offcanvas-title" id="offcanvasBottomLabel">ตัวกรองที่เลือก <a href="javascript:void(0)" onclick="window.location.reload()" class="refreshde" >ล้างค่า</a> </h5>
                                            
                                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                        </div>
                                        <ul id="show_select_mb"></ul>
                                        <div class="offcanvas-body small">
                                            <div class="boxfilter">
                                                @if(isset($filter['country']) && count($filter['country']) > 0)
                                                <div class="titletopic">
                                                    <h2>ประเทศ</h2>
                                                </div>
                                                <div class="filtermenu">
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" placeholder="ชื่อประเทศ" name="country_search" id="country_search"  aria-label="air"
                                                            aria-describedby="button-addon2">
                                                        <button class="btn btn-outline-secondary" type="button" id="button-addon2" onclick="Search_country()"><i
                                                                class="fi fi-rr-search"></i></button>
                                                    </div>
                                                    <ul id="show_country_mb">
                                                        @php
                                                            $check_country_mb = array();
                                                            $country_num_mb  = array();
                                                            $country_mb = array();
                                                            $tour_id_mb = array();
                                                            foreach ($filter['country'] as $id => $f_country) {
                                                                $country_mb = array_merge($country_mb,json_decode($f_country,true));
                                                                $tour_id_mb[] = $id;
                                                            }
                                                            $country_mb = array_unique($country_mb);
                                                            foreach ($country_mb as $re) {
                                                                $data_country_mb[] = App\Models\Backend\CountryModel::where('id',$re)->get(); 
                                                            }
                                                         
                                                        @endphp
                                                        @if(isset($data_country_mb))
                                                            @foreach ($data_country_mb as $n => $coun)
                                                                @if($n <= 9)
                                                                    @foreach ($coun as  $c)
                                                                        @php
                                                                            $total_tour_mb = App\Models\Backend\TourModel::whereIn('id',$tour_id_mb)->where('country_id','like','%"'.$c->id.'"%')/* ->where('status','on')->where('deleted_at',null) */;
                                                                            // ราคาถูกสุด
                                                                            if($orderby_data == 1){
                                                                                $total_tour_mb = $total_tour_mb->orderby('price','asc');
                                                                            }
                                                                            // ยอดวิวเยอะสุด
                                                                            if($orderby_data == 2){
                                                                                $total_tour_mb = $total_tour_mb->orderby('tour_views','desc');
                                                                            }
                                                                            //ลดราคา
                                                                            if($orderby_data == 3){
                                                                                $total_tour_mb = $total_tour_mb->where('special_price','>',0)->orderby('special_price','desc');
                                                                            }
                                                                            //มีโปรโมชั่น
                                                                            if($orderby_data == 4){
                                                                                $check_period = array();
                                                                                $check_p = App\Models\Backend\TourPeriodModel::whereNotNull('promotion_id')->whereDate('pro_start_date','<=',date('Y-m-d'))->whereDate('pro_end_date','>=',date('Y-m-d'))->get(['tour_id']);
                                                                                foreach($check_p  as $check){
                                                                                    $check_period[] = $check->tour_id;
                                                                                }
                                                                                if(count($check_period)){
                                                                                    $total_tour_mb = $total_tour_mb->whereIn('id',$check_period)/* ->where('promotion2','Y') */;
                                                                                }  
                                                                            }
                                                                            $total_tour_mb = $total_tour_mb->count(); 
                                                                            $check_country_mb[] = $c->id;
                                                                            $country_num_mb[$c->id] = $total_tour_mb;
                                                                        @endphp
                                                                        <li><label class="check-container"> {{$c->country_name_th?$c->country_name_th:$c->country_name_en}}
                                                                                <input type="checkbox" @if($c->id == $slug) checked @endif name="country" id="country_mb{{$c->id}}" onclick="Check_filter({{$c->id}},'country')" value="{{$c->id}}">
                                                                                <span class="checkmark"></span>
                                                                                <div class="count">({{$total_tour_mb}})</div>
                                                                            </label></li>
                                                                    @endforeach
                                                                @elseif($n > 9) 
                                                                    <div id="morecountry" class="collapse">
                                                                        @foreach ($coun as $c)
                                                                            @php
                                                                               $total_tour_mb = App\Models\Backend\TourModel::whereIn('id',$tour_id_mb)->where('country_id','like','%"'.$c->id.'"%')/* ->where('status','on')->where('deleted_at',null) */;
                                                                                // ราคาถูกสุด
                                                                                if($orderby_data == 1){
                                                                                    $total_tour_mb = $total_tour_mb->orderby('price','asc');
                                                                                }
                                                                                // ยอดวิวเยอะสุด
                                                                                if($orderby_data == 2){
                                                                                    $total_tour_mb = $total_tour_mb->orderby('tour_views','desc');
                                                                                }
                                                                                //ลดราคา
                                                                                if($orderby_data == 3){
                                                                                    $total_tour_mb = $total_tour_mb->where('special_price','>',0)->orderby('special_price','desc');
                                                                                }
                                                                                //มีโปรโมชั่น
                                                                                if($orderby_data == 4){
                                                                                    $check_period = array();
                                                                                    $check_p = App\Models\Backend\TourPeriodModel::whereNotNull('promotion_id')->whereDate('pro_start_date','<=',date('Y-m-d'))->whereDate('pro_end_date','>=',date('Y-m-d'))->get(['tour_id']);
                                                                                    foreach($check_p  as $check){
                                                                                        $check_period[] = $check->tour_id;
                                                                                    }
                                                                                    if(count($check_period)){
                                                                                        $total_tour_mb = $total_tour_mb->whereIn('id',$check_period)/* ->where('promotion2','Y') */;
                                                                                    }  
                                                                                }
                                                                                $total_tour_mb = $total_tour_mb->count(); 
                                                                                $check_country_mb[] = $c->id;
                                                                                $country_num_mb[$c->id] = $total_tour_mb;
                                                                            @endphp
                                                                            <li><label class="check-container"> {{$c->country_name_th?$c->country_name_th:$c->country_name_en}}
                                                                                <input type="checkbox" name="country" id="country_mb{{$c->id}}" onclick="Check_filter({{$c->id}},'country')" value="{{$c->id}}">
                                                                                <span class="checkmark"></span>
                                                                                <div class="count">({{$total_tour_mb}})</div>
                                                                            </label></li> 
                                                                        @endforeach
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                            @if(count($data_country_mb) > 9)<a data-bs-toggle="collapse" data-bs-target="#morecountry" class="seemore"> ดูเพิ่มเติม</a> @endif
                                                        @endif
                                                    </ul>
                                                </div>
                                                @endif
                                                @if(isset($filter['city']) && count($filter['city']) > 0)
                                                <div class="titletopic">
                                                    <h2>เมือง</h2>
                                                </div>
                                                <div class="filtermenu">
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" placeholder="ชื่อเมือง" name="city_search" id="city_search"  aria-label="air"
                                                            aria-describedby="button-addon2">
                                                        <button class="btn btn-outline-secondary" type="button" id="button-addon2" onclick="Search_city()"><i
                                                                class="fi fi-rr-search"></i></button>
                                                    </div>
                                                    <ul id="show_city_mb">
                                                        @php
                                                            $check_city_mb = array();
                                                            $city_num_mb = array();
                                                            $city_mb = array();
                                                            $t_id_mb = array();
                                                            foreach ($filter['city'] as $id => $f_city) {
                                                                $city_mb = array_merge($city_mb,json_decode($f_city,true));
                                                                $t_id_mb[] = $id;
                                                            }
                                                            $city_mb = array_unique($city_mb);
                                                            foreach ($city_mb as $re) {
                                                                $data_city_mb[] = App\Models\Backend\CityModel::where('id',$re)->get(); 
                                                            }
                                                            // dd($filter['city']);
                                                        @endphp
                                                        @if(isset($data_city_mb))
                                                            @foreach ($data_city_mb as $n => $coun)
                                                                @if($n <= 9)
                                                                    @foreach ($coun as  $c)
                                                                        @php
                                                                            $tour = App\Models\Backend\TourModel::whereIn('id',$t_id_mb)->where('city_id','like','%"'.$c->id.'"%')/* ->where('status','on')->where('deleted_at',null) */;
                                                                                // ราคาถูกสุด
                                                                                if($orderby_data == 1){
                                                                                    $tour = $tour->orderby('price','asc');
                                                                                }
                                                                                // ยอดวิวเยอะสุด
                                                                                if($orderby_data == 2){
                                                                                    $tour = $tour->orderby('tour_views','desc');
                                                                                }
                                                                                //ลดราคา
                                                                                if($orderby_data == 3){
                                                                                    $tour = $tour->where('special_price','>',0)->orderby('special_price','desc');
                                                                                }
                                                                                //มีโปรโมชั่น
                                                                                if($orderby_data == 4){
                                                                                    $check_period = array();
                                                                                    $check_p = App\Models\Backend\TourPeriodModel::whereNotNull('promotion_id')->whereDate('pro_start_date','<=',date('Y-m-d'))->whereDate('pro_end_date','>=',date('Y-m-d'))->get(['tour_id']);
                                                                                    foreach($check_p  as $check){
                                                                                        $check_period[] = $check->tour_id;
                                                                                    }
                                                                                    if(count($check_period)){
                                                                                        $tour = $tour->whereIn('id',$check_period)/* ->where('promotion2','Y') */;
                                                                                    }  
                                                                                }
                                                                            $tour = $tour->count(); 
                                                                            $check_city_mb[] = $c->id;
                                                                            $city_num_mb[$c->id] = $tour;
                                                                        @endphp
                                                                        <li><label class="check-container"> {{$c->city_name_th?$c->city_name_th:$c->city_name_en}}
                                                                                <input type="checkbox" name="city" id="city_mb{{$c->id}}" onclick="Check_filter({{$c->id}},'city')" value="{{$c->id}}">
                                                                                <span class="checkmark"></span>
                                                                                <div class="count">({{$tour}}) </div>
                                                                            </label></li>
                                                                    @endforeach
                                                                @elseif($n > 9)  
                                                                    <div id="moreprovince" class="collapse">
                                                                        @foreach ($coun as $c)
                                                                            @php
                                                                                $tour = App\Models\Backend\TourModel::whereIn('id',$t_id_mb)->where('city_id','like','%"'.$c->id.'"%')/* ->where('status','on')->where('deleted_at',null) */;
                                                                                // ราคาถูกสุด
                                                                                if($orderby_data == 1){
                                                                                    $tour = $tour->orderby('price','asc');
                                                                                }
                                                                                // ยอดวิวเยอะสุด
                                                                                if($orderby_data == 2){
                                                                                    $tour = $tour->orderby('tour_views','desc');
                                                                                }
                                                                                //ลดราคา
                                                                                if($orderby_data == 3){
                                                                                    $tour = $tour->where('special_price','>',0)->orderby('special_price','desc');
                                                                                }
                                                                                //มีโปรโมชั่น
                                                                                if($orderby_data == 4){
                                                                                    $check_period = array();
                                                                                    $check_p = App\Models\Backend\TourPeriodModel::whereNotNull('promotion_id')->whereDate('pro_start_date','<=',date('Y-m-d'))->whereDate('pro_end_date','>=',date('Y-m-d'))->get(['tour_id']);
                                                                                    foreach($check_p  as $check){
                                                                                        $check_period[] = $check->tour_id;
                                                                                    }
                                                                                    if(count($check_period)){
                                                                                        $tour = $tour->whereIn('id',$check_period)/* ->where('promotion2','Y') */;
                                                                                    }  
                                                                                }
                                                                                $tour = $tour->count(); 
                                                                                $check_city_mb[] = $c->id;
                                                                                $city_num_mb[$c->id] = $tour;
                                                                            @endphp
                                                                            <li><label class="check-container">  {{$c->city_name_th?$c->city_name_th:$c->city_name_en}}
                                                                                <input type="checkbox" name="city" id="city_mb{{$c->id}}" onclick="Check_filter({{$c->id}},'city')" value="{{$c->id}}">
                                                                                <span class="checkmark"></span>
                                                                                <div class="count">({{$tour}})</div>
                                                                            </label></li>
                                                                        @endforeach
                                                                    </div>     
                                                                @endif
                                                            @endforeach
                                                            @if(count($data_city_mb) > 9)<a data-bs-toggle="collapse" data-bs-target="#moreprovince" class="seemore"> ดูเพิ่มเติม</a> @endif
                                                        @endif
                                                    </ul>
                                                </div>
                                                <hr>
                                                @endif
                                                @if($filter)
                                                    <div class="titletopic">
                                                        <h2>ช่วงราคา</h2>
                                                    </div>
                                                    <div class="filtermenu">
                                                        <ul id="show_total_mb">
                                                            <li><label class="check-container" id="price_mb7"  onclick="UncheckdPrice(7)"> ทั้งหมด
                                                                    <input type="checkbox">
                                                                    <span class="checkmark"></span>
                                                                    <div class="count">({{$num_price}})</div>
                                                                </label></li>
                                                            </ul>
                                                            <ul id="show_price_mb">
                                                                @if(isset($filter['price'][0]))
                                                                <li><label class="check-container"> ต่ำกว่า 10,000
                                                                        <input type="checkbox" name="price[]" id="price_mb1" onclick="Check_filter(1,'price')" value="1" >
                                                                        <span class="checkmark"></span>
                                                                        <div class="count">({{count($filter['price'][0])}})</div>
                                                                    </label></li>
                                                                @endif
                                                                @if(isset($filter['price'][1]))
                                                                <li><label class="check-container"> 10,001-20,000
                                                                        <input type="checkbox" name="price[]" id="price_mb2" onclick="Check_filter(2,'price')" value="2">
                                                                        <span class="checkmark"></span>
                                                                        <div class="count">({{count($filter['price'][1])}})</div>
                                                                    </label></li>
                                                                @endif
                                                                @if(isset($filter['price'][2]))
                                                                <li><label class="check-container"> 20,001-30,000
                                                                        <input type="checkbox" name="price[]" id="price_mb3" onclick="Check_filter(3,'price')" value="3">
                                                                        <span class="checkmark"></span>
                                                                        <div class="count">({{count($filter['price'][2])}})</div>
                                                                    </label></li>
                                                                @endif
                                                                @if(isset($filter['price'][3]))   
                                                                <li><label class="check-container"> 30,001-50,000
                                                                        <input type="checkbox" name="price[]" id="price_mb4" onclick="Check_filter(4,'price')" value="4">
                                                                        <span class="checkmark" ></span>
                                                                        <div class="count">({{count($filter['price'][3])}})</div>
                                                                    </label></li>
                                                                @endif
                                                                @if(isset($filter['price'][4]))
                                                                <li><label class="check-container"> 50,001-80,000
                                                                        <input type="checkbox" name="price[]" id="price_mb5" onclick="Check_filter(5,'price')" value="5">
                                                                        <span class="checkmark"></span>
                                                                        <div class="count">({{count($filter['price'][4])}})</div>
                                                                    </label></li>
                                                                @endif
                                                                @if(isset($filter['price'][5]))
                                                                <li><label class="check-container"> 80,001 ขึ้นไป
                                                                        <input type="checkbox" name="price[]" id="price_mb6" onclick="Check_filter(6,'price')" value="6">
                                                                        <span class="checkmark"></span>
                                                                        <div class="count">({{count($filter['price'][5])}})</div>
                                                                    </label></li>
                                                                @endif
                                                            </ul>
                                                    </div>
                                                <hr>
                                                @endif
                                               
                                                @if(isset($filter['day']) && count($filter['day']) > 0)
                                                <div class="titletopic">
                                                    <h2>เลือกจำนวนวัน</h2>
                                                </div>
                                                <div class="filtermenu">
                                                    <ul id="show_day_mb">
                                                        @foreach ($filter['day'] as $day => $num)
                                                            <li>
                                                                <label class="check-container"> {{$day}} วัน
                                                                    <input type="checkbox" name="day" id="day_mb{{$day}}" onclick="Check_filter({{$day}},'day')" value="{{$day}}">
                                                                    <span class="checkmark"></span>
                                                                    <div class="count">({{count($num)}})</div>
                                                                </label>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <hr>
                                                @endif
                                                @if(isset($filter['airline']) && count($filter['airline']) > 0)
                                                <div class="titletopic">
                                                    <h2>สายการบิน</h2>
                                                </div>
                                                <div class="filtermenu">
                                                    <div class="input-group mb-3">
                                                        <input type="text" class="form-control" placeholder="ชื่อสายการบิน" name="search_airline" id="search_airline"  aria-label="air"
                                                            aria-describedby="button-addon2">
                                                        <button class="btn btn-outline-secondary" type="button" id="button-addon2" onclick="Search_airline()"><i
                                                                class="fi fi-rr-search"></i></button>
                                                    </div>
                                                    @php
                                                        $airline_id_mb = array();
                                                    @endphp
                                                    <ul id="show_air_mb">
                                                    @php
                                                        $check_airline_mb = 0;
                                                    @endphp
                                                    @foreach ($filter['airline'] as $air => $num)
                                                    @php
                                                         $airline_mb = App\Models\Backend\TravelTypeModel::find($air);
                                                         $airline_id_mb[] = $air;
                                                    @endphp
                                                     @if($check_airline_mb <= 9)
                                                        <li><label class="check-container">@if($airline_mb->image)<img src="{{asset($airline_mb->image)}}" alt="">@endif {{$airline_mb->travel_name}}
                                                                <input type="checkbox" name="airline" id="airline_mb{{$airline_mb->id}}" onclick="Check_filter({{$airline_mb->id}},'airline')" value="{{$airline_mb->id}}">
                                                                <span class="checkmark"></span>
                                                                <div class="count">({{count($num)}})</div>
                                                            </label></li>
                                                        @php
                                                            $check_airline_mb++;
                                                            if(count($airline_id_mb) > 9){
                                                                break;
                                                            }
                                                        @endphp
                                                        @endif
                                                    @endforeach
                                                    <div id="moreair" class="collapse">
                                                        @foreach ($filter['airline'] as $air => $num)
                                                            @if($check_airline_mb > 9 && !in_array($air,$airline_id_mb))
                                                            @php
                                                                $airline_mb = App\Models\Backend\TravelTypeModel::find($air);
                                                                $airline_id_mb[] = $air;
                                                            @endphp
                                                            <li><label class="check-container">@if($airline_mb->image)<img src="{{asset($airline_mb->image)}}" alt="">@endif {{$airline_mb->travel_name}}
                                                                <input type="checkbox" name="airline" id="airline_mb{{$airline_mb->id}}" onclick="Check_filter({{$airline_mb->id}},'airline')" value="{{$airline_mb->id}}">
                                                                <span class="checkmark"></span>
                                                                <div class="count">({{count($num)}})</div>
                                                            </label></li>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                    @if(count($airline_id_mb) > 9)<a data-bs-toggle="collapse" data-bs-target="#moreair" class="seemore"> ดูเพิ่มเติม</a>  @endif
                                                </ul>
                                                </div>
                                                <hr>
                                                @endif
                                                @if($filter)
                                                    <div class="titletopic">
                                                        <h2>ระดับดาวที่พัก</h2>
                                                    </div>
                                                    <div class="filtermenu">
                                                        <ul id="show_rating_mb">
                                                            @if(isset($filter['rating'][0]))
                                                            <li><label class="check-container">
                                                                    <div class="rating">
                                                                        <i class="bi bi-star-fill"></i> <i class="bi bi-star-fill"></i> 
                                                                        <i class="bi bi-star-fill"></i> <i class="bi bi-star-fill"></i> 
                                                                        <i class="bi bi-star-fill"></i>
                                                                    </div>
                                                                    <input type="checkbox" name="rating" id="rating_mb5" onclick="Check_filter(5,'rating')" value="5">
                                                                    <span class="checkmark"></span>
                                                                    <div class="count">({{count($filter['rating'][0])}})</div>
                                                                </label></li>
                                                            @endif
                                                            @if(isset($filter['rating'][1]))
                                                            <li><label class="check-container">
                                                                    <div class="rating">
                                                                        <i class="bi bi-star-fill"></i> <i class="bi bi-star-fill"></i> <i
                                                                            class="bi bi-star-fill"></i> <i class="bi bi-star-fill"></i>
                                                                    </div>
                                                                    <input type="checkbox" name="rating" id="rating_mb4" onclick="Check_filter(4,'rating')" value="4">
                                                                    <span class="checkmark"></span>
                                                                    <div class="count">({{count($filter['rating'][1])}})</div>
                                                                </label></li>
                                                            @endif
                                                            @if(isset($filter['rating'][2]))
                                                            <li><label class="check-container">
                                                                    <div class="rating">
                                                                        <i class="bi bi-star-fill"></i> <i class="bi bi-star-fill"></i> <i
                                                                            class="bi bi-star-fill"></i>
                                                                    </div>
                                                                    <input type="checkbox" name="rating" id="rating_mb3" onclick="Check_filter(3,'rating')" value="3">
                                                                    <span class="checkmark"></span>
                                                                    <div class="count">({{count($filter['rating'][2])}})</div>
                                                                </label></li>
                                                            @endif
                                                            @if(isset($filter['rating'][3]))
                                                            <li><label class="check-container">
                                                                    <div class="rating">
                                                                        <i class="bi bi-star-fill"></i> <i class="bi bi-star-fill"></i> 
                                                                    </div>
                                                                    <input type="checkbox" name="rating" id="rating_mb2" onclick="Check_filter(2,'rating')" value="2">
                                                                    <span class="checkmark"></span>
                                                                    <div class="count">({{count($filter['rating'][3])}})</div>
                                                                </label></li>
                                                            @endif
                                                            @if(isset($filter['rating'][4]))
                                                            <li><label class="check-container">
                                                                    <div class="rating">
                                                                        <i class="bi bi-star-fill"></i> 
                                                                    </div>
                                                                    <input type="checkbox" name="rating" id="rating_mb1" onclick="Check_filter(1,'rating')" value="1">
                                                                    <span class="checkmark"></span>
                                                                    <div class="count">({{count($filter['rating'][4])}})</div>
                                                                </label></li>
                                                            @endif
                                                            @if(isset($filter['rating'][5]))
                                                            <li><label class="check-container"> ไม่มีระดับดาวที่พัก
                                                                    <input type="checkbox" name="rating" id="rating_mb0" onclick="Check_filter(0,'rating')" value="0">
                                                                    <span class="checkmark"></span>
                                                                    <div class="count">({{count($filter['rating'][5])}})</div>
                                                                </label></li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                            <a href="javascript:void(0);" class="btn btnonmb" data-bs-dismiss="offcanvas" aria-label="Close">แสดงผลการกรอง</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            </section>
                        </div>
                        <div class="col-5 ps-0">
                            <div class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
                                <select class="form-select" aria-label="Default select example" name="orderby_data" onchange="OrderByData(this.value)">
                                    <option value="" >เรียงตาม </option>
                                    <option value="1" @if($orderby_data == 1) selected @endif>ราคาถูกที่สุด</option>
                                    <option value="2" @if($orderby_data == 2) selected @endif>ดูมากที่สุด</option>
                                    <option value="3" @if($orderby_data == 3) selected @endif>ลดราคา</option>
                                    <option value="4" @if($orderby_data == 4) selected @endif>มีโปรโมชั่น</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-2 g-0">
                            <div class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
                                <div id="btnContainer">
                                    <button class="btn active" onclick="gridView()">
                                        <i class="bi bi-view-list list_img imgactive"></i>
                                        <i class="bi bi-view-list list_img  imgnonactive" style="color:#f15a22;"></i>
                                    </button>
                                    <button class="btn" onclick="listView()">
                                        <i class="bi bi-list-task grid_img imgnonactive" style="color:#f15a22;"></i>
                                        <i class="bi bi-list-task grid_img imgactive"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
                    <div class="boxfilter" >
                        <div class="row" id="show_box_mb" >
                            <div class="col-8 col-lg-9">
                                <div class="titletopic">
                                    <h2>ตัวกรองที่เลือก</h2>
                                </div>
                                <div class="filtermenu">
                                    <ul id="show_select_mb_all"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-xl-9">
                    <div class="row mt-3 mt-lg-0">
                        <div class="col-12 col-lg-7 col-xl-8">
                            <div class="titletopic">
                                <h1>ทัวร์{{@$data->holiday}}</h1>
                                <p id="show_count">พบ {{count($period)}} รายการ</p>
                            </div>
                        </div>
                        <div class="col-lg-5 col-xl-4 text-end">
                            <div class="row">
                                <div class="col-lg-8 col-xl-8">
                                    <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                                        <select class="form-select" aria-label="Default select example" name="orderby_data" onchange="OrderByData(this.value)">
                                            <option value="" >เรียงตาม </option>
                                            <option value="1" @if($orderby_data == 1) selected @endif>ราคาถูกที่สุด</option>
                                            <option value="2" @if($orderby_data == 2) selected @endif>ดูมากที่สุด</option>
                                            <option value="3" @if($orderby_data == 3) selected @endif>ลดราคา</option>
                                            <option value="4" @if($orderby_data == 4) selected @endif>มีโปรโมชั่น</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xl-4">
                                    <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                                        <div id="btnContainer">
                                            <button class="btn active" onclick="gridView()">
                                                <i class="bi bi-view-list list_img imgactive"></i>
                                                <i class="bi bi-view-list list_img  imgnonactive"
                                                    style="color:#f15a22;"></i>
                                            </button>
                                            <button class="btn" onclick="listView()">
                                                <i class="bi bi-list-task grid_img imgnonactive"
                                                    style="color:#f15a22;"></i>
                                                <i class="bi bi-list-task grid_img imgactive"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="table-grid">
                                <div class="row">
                                    @php
                                        $allSoldOut = array();
                                        $checkSold = false;
                                    @endphp     
                                    <div class="col" id="show_search">
                                    @foreach($period as $pre)
                                        <?php 
                                            $country = App\Models\Backend\CountryModel::whereIn('id',json_decode($pre['tour']->country_id,true))->get();
                                            // $city = App\Models\Backend\CityModel::whereIn('id',json_decode($pre['tour']->city_id,true))->get();
                                            // $province = App\Models\Backend\ProvinceModel::whereIn('id',json_decode($pre['tour']->province_id,true))->get();
                                            // $district = App\Models\Backend\DistrictModel::whereIn('id',json_decode($pre['tour']->district_id,true))->get();
                                            $airline = \App\Models\Backend\TravelTypeModel::find($pre['tour']->airline_id);
                                            $type = \App\Models\Backend\TourTypeModel::find(@$pre['tour']->type_id);
                                            foreach ($pre['period'] as $p){ 
                                                $checkSold = false;
                                                if($p->count == 0 && $p->status_period == 3){
                                                    $allSoldOut[$p->tour_id][] = $p->id;
                                                }  
                                                if(isset($allSoldOut[$pre['tour']->id])){
                                                    if(count($pre['period']) == count($allSoldOut[$pre['tour']->id])){
                                                        $checkSold = true;
                                                    } 
                                                }
                                            
                                            }
                                        ?>
                                        @if($pre['tour'] && count($pre['period']) > 0)
                                            <div class="boxwhiteshd">
                                                <div class="toursmainshowGroup  hoverstyle">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-xl-3 pe-0">
                                                            <div class="covertourimg">
                                                                <figure>
                                                                    <a href="{{url('tour/'.$pre['tour']->slug)}}"><img
                                                                            src="{{ asset(@$pre['tour']->image) }}" alt=""></a>
                                                                </figure>
                                                                <div
                                                                    class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
                                                                    <a href="javascript:void(0);" class="tagicbest"  name="type_data" onclick="OrderByType({{@$pre['tour']->type_id}})"></a>
                                                                </div>
                                                                @if($pre['tour']->special_price > 0)
                                                                    <div class="saleonpicbox">
                                                                         <span> ลดราคาพิเศษ</span> <br>
                                                                        {{number_format($pre['tour']->special_price,0)}} บาท  
                                                                    </div>
                                                                @endif
                                                                @if(@$checkSold)
                                                                <div class="soldfilter">
                                                                    <div class="soldop">
                                                                        <span class="bigSold">SOLD OUT </span> <br>
                                                                        <span class="textsold"> ว้า! หมดแล้ว คุณตัดสินใจช้าไป</span> <br>
                                                                        <a href="{{url('tour/'.$pre['tour']->slug)}}" target="_blank" class="btn btn-second mt-3"><i class="fi fi-rr-search"></i> หาโปรแกรมทัวร์ใกล้เคียง</a>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                                <div class="priceonpic">
                                                                    @if($pre['tour']->special_price > 0)
                                                                    @php $price = $pre['tour']->price - $pre['tour']->special_price; @endphp
                                                                        <span class="originalprice">ปกติ {{ number_format($pre['tour']->price,0) }} </span><br>
                                                                        เริ่ม<span class="saleprice"> {{ number_format(@$price,0) }} บาท</span>
                                                                    @else
                                                                        <span class="saleprice"> {{ number_format($pre['tour']->price,0) }} บาท</span>
                                                                    @endif
                                                                </div>
                                                                <div class="addwishlist">
                                                                    <a href="javascript:void(0);" class="wishlist" data-tour-id="{{ $pre['tour']->id }}"><i class="bi bi-heart-fill" id="likeButton" {{-- onclick="likedTour({{@$pre['tour']->id}})" --}}></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-xl-9">
                                                            <div class="codeandhotel Cropscroll mt-1">
                                                                <li class="bgwhite"><a href="{{ url('oversea/'.@$country[0]->slug)}}"><i class="fi fi-rr-marker" style="color:#f15a22;"></i> @foreach ($country as $coun) {{$coun->country_name_th?$coun->country_name_th:$coun->country_name_en}} @endforeach </a></li>
                                                                <li>รหัสทัวร์ : <span class="bluetext">@if(@$pre['tour']->code1_check) {{@$pre['tour']->code1}} @else {{@$pre['tour']->code}} @endif</span> </li>
                                                                <li class="rating">โรงแรม 
                                                                    @if($pre['tour']->rating > 0)
                                                                        <a href="javascript:void(0);" onclick="Check_filter({{$pre['tour']->rating}},'rating')">
                                                                            @for($i=1; $i <= @$pre['tour']->rating; $i++)
                                                                            <i class="bi bi-star-fill"></i>
                                                                            @endfor
                                                                        </a>
                                                                    @else
                                                                        <a href="javascript:void(0);" onclick="Check_filter(0,'rating')">
                                                                    @endif
                                                                </li>
                                                                <li>สายการบิน <a href="javascript:void(0);" onclick="Check_filter({{@$airline->id}},'airline')"><img
                                                                            src="{{asset(@$airline->image)}}" alt=""></a>
                                                                </li>
                                                                <li>
                                                                    <div
                                                                        class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                                                                        <a href="javascript:void(0);" class="tagicbest"  name="type_data" onclick="OrderByType({{@$pre['tour']->type_id}})"></a>
                                                                    </div>
                                                                </li>
                                                                <li class="bgor">ระยะเวลา <a href="javascript:void(0);" onclick="Check_filter({{$pre['period'][0]->day}},'day')">{{$pre['tour']->num_day}}</a></li>
                                                            </div>

                                                            <div class="nameTop">
                                                                <h3> <a href="{{url('tour/'.$pre['tour']->slug)}}">{{ $pre['tour']->name }} </a>
                                                                </h3>
                                                            </div>
                                                            <div class="pricegroup text-end">
                                                                @if($pre['tour']->special_price > 0)
                                                                @php $price = $pre['tour']->price - $pre['tour']->special_price; @endphp
                                                                    <span class="originalprice">ปกติ {{ number_format($pre['tour']->price,0) }} </span><br>
                                                                    เริ่ม<span class="saleprice"> {{ number_format(@$price,0) }} บาท</span>
                                                                @else
                                                                    เริ่ม<span class="saleprice"> {{ number_format($pre['tour']->price,0) }} บาท</span>
                                                                @endif
                                                            </div>
                                                            @if($pre['tour']->description)
                                                            <div class="highlighttag">
                                                                <span><i class="fi fi-rr-tags"></i> </span> {{ @$pre['tour']->description }}
                                                            </div>
                                                            @endif
                                                                @php
                                                                    $count_hilight = 0;
                                                                    if($pre['tour']->travel){
                                                                        $count_hilight++;
                                                                    }
                                                                    if($pre['tour']->shop){
                                                                        $count_hilight++;
                                                                    }
                                                                    if($pre['tour']->eat){
                                                                        $count_hilight++;
                                                                    }
                                                                    if($pre['tour']->special){
                                                                        $count_hilight++;
                                                                    }
                                                                    if($pre['tour']->stay){
                                                                        $count_hilight++;
                                                                    }
                                                                @endphp
                                                            @if($count_hilight > 0)
                                                                <div class="hilight mt-2">
                                                                    <div class="readMore">
                                                                        <div class="readMoreWrapper">
                                                                            <div class="readMoreText2">
                                                                            
                                                                            @if($pre['tour']->travel)
                                                                                <li>
                                                                                    <div class="iconle"><span><i class="bi bi-camera-fill"></i></span></div>
                                                                                    <div class="topiccenter"><b>เที่ยว</b></div>
                                                                                    <div class="details"> {{ @$pre['tour']->travel }}</div>
                                                                                </li>
                                                                            @endif
                                                                            @if($pre['tour']->shop)
                                                                                <li><div class="iconle"><span><i class="bi bi-bag-fill"></i></span></div>
                                                                                    <div class="topiccenter"><b>ช้อป </b></div>
                                                                                    <div class="details"> {{ @$pre['tour']->shop }}</div>
                                                                                </li>
                                                                            @endif
                                                                            @if($pre['tour']->eat)
                                                                                <li>
                                                                                    <div class="iconle"><span><svg
                                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                                width="22" height="22"
                                                                                                fill="currentColor"
                                                                                                class="bi bi-cup-hot-fill"
                                                                                                viewBox="0 0 16 16">
                                                                                                <path fill-rule="evenodd"
                                                                                                    d="M.5 6a.5.5 0 0 0-.488.608l1.652 7.434A2.5 2.5 0 0 0 4.104 16h5.792a2.5 2.5 0 0 0 2.44-1.958l.131-.59a3 3 0 0 0 1.3-5.854l.221-.99A.5.5 0 0 0 13.5 6H.5ZM13 12.5a2.01 2.01 0 0 1-.316-.025l.867-3.898A2.001 2.001 0 0 1 13 12.5Z" />
                                                                                                <path
                                                                                                    d="m4.4.8-.003.004-.014.019a4.167 4.167 0 0 0-.204.31 2.327 2.327 0 0 0-.141.267c-.026.06-.034.092-.037.103v.004a.593.593 0 0 0 .091.248c.075.133.178.272.308.445l.01.012c.118.158.26.347.37.543.112.2.22.455.22.745 0 .188-.065.368-.119.494a3.31 3.31 0 0 1-.202.388 5.444 5.444 0 0 1-.253.382l-.018.025-.005.008-.002.002A.5.5 0 0 1 3.6 4.2l.003-.004.014-.019a4.149 4.149 0 0 0 .204-.31 2.06 2.06 0 0 0 .141-.267c.026-.06.034-.092.037-.103a.593.593 0 0 0-.09-.252A4.334 4.334 0 0 0 3.6 2.8l-.01-.012a5.099 5.099 0 0 1-.37-.543A1.53 1.53 0 0 1 3 1.5c0-.188.065-.368.119-.494.059-.138.134-.274.202-.388a5.446 5.446 0 0 1 .253-.382l.025-.035A.5.5 0 0 1 4.4.8Zm3 0-.003.004-.014.019a4.167 4.167 0 0 0-.204.31 2.327 2.327 0 0 0-.141.267c-.026.06-.034.092-.037.103v.004a.593.593 0 0 0 .091.248c.075.133.178.272.308.445l.01.012c.118.158.26.347.37.543.112.2.22.455.22.745 0 .188-.065.368-.119.494a3.31 3.31 0 0 1-.202.388 5.444 5.444 0 0 1-.253.382l-.018.025-.005.008-.002.002A.5.5 0 0 1 6.6 4.2l.003-.004.014-.019a4.149 4.149 0 0 0 .204-.31 2.06 2.06 0 0 0 .141-.267c.026-.06.034-.092.037-.103a.593.593 0 0 0-.09-.252A4.334 4.334 0 0 0 6.6 2.8l-.01-.012a5.099 5.099 0 0 1-.37-.543A1.53 1.53 0 0 1 6 1.5c0-.188.065-.368.119-.494.059-.138.134-.274.202-.388a5.446 5.446 0 0 1 .253-.382l.025-.035A.5.5 0 0 1 7.4.8Zm3 0-.003.004-.014.019a4.077 4.077 0 0 0-.204.31 2.337 2.337 0 0 0-.141.267c-.026.06-.034.092-.037.103v.004a.593.593 0 0 0 .091.248c.075.133.178.272.308.445l.01.012c.118.158.26.347.37.543.112.2.22.455.22.745 0 .188-.065.368-.119.494a3.198 3.198 0 0 1-.202.388 5.385 5.385 0 0 1-.252.382l-.019.025-.005.008-.002.002A.5.5 0 0 1 9.6 4.2l.003-.004.014-.019a4.149 4.149 0 0 0 .204-.31 2.06 2.06 0 0 0 .141-.267c.026-.06.034-.092.037-.103a.593.593 0 0 0-.09-.252A4.334 4.334 0 0 0 9.6 2.8l-.01-.012a5.099 5.099 0 0 1-.37-.543A1.53 1.53 0 0 1 9 1.5c0-.188.065-.368.119-.494.059-.138.134-.274.202-.388a5.446 5.446 0 0 1 .253-.382l.025-.035A.5.5 0 0 1 10.4.8Z" />
                                                                                            </svg></span> </div>
                                                                                    <div class="topiccenter"><b>กิน </b></div>
                                                                                    <div class="details">
                                                                                        {{ @$pre['tour']->eat }}  </div>
                                                                                </li>
                                                                            @endif
                                                                            @if($pre['tour']->special)
                                                                                <li>
                                                                                    <div class="iconle"><span><i
                                                                                                class="bi bi-bookmark-heart-fill"></i></span>
                                                                                    </div>
                                                                                    <div class="topiccenter"><b>พิเศษ </b></div>
                                                                                    <div class="details">
                                                                                        {{ @$pre['tour']->special }}</div>
                                                                                </li>
                                                                            @endif
                                                                            @if($pre['tour']->stay)
                                                                                <li>
                                                                                    <div class="iconle"><span><svg
                                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                                width="22" height="22"
                                                                                                fill="currentColor"
                                                                                                class="bi bi-buildings-fill"
                                                                                                viewBox="0 0 16 16">
                                                                                                <path
                                                                                                    d="M15 .5a.5.5 0 0 0-.724-.447l-8 4A.5.5 0 0 0 6 4.5v3.14L.342 9.526A.5.5 0 0 0 0 10v5.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V14h1v1.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5V.5ZM2 11h1v1H2v-1Zm2 0h1v1H4v-1Zm-1 2v1H2v-1h1Zm1 0h1v1H4v-1Zm9-10v1h-1V3h1ZM8 5h1v1H8V5Zm1 2v1H8V7h1ZM8 9h1v1H8V9Zm2 0h1v1h-1V9Zm-1 2v1H8v-1h1Zm1 0h1v1h-1v-1Zm3-2v1h-1V9h1Zm-1 2h1v1h-1v-1Zm-2-4h1v1h-1V7Zm3 0v1h-1V7h1Zm-2-2v1h-1V5h1Zm1 0h1v1h-1V5Z" />
                                                                                            </svg></span> </div>
                                                                                    <div class="topiccenter"><b>พัก </b></div>
                                                                                    <div class="details">
                                                                                        {{ @$pre['tour']->stay }}</div>
                                                                                </li>
                                                                            @endif
                                                                            </div>
                                                                            <div class="readMoreGradient"></div>
                                                                        </div>
                                                                        <a class="readMoreBtn2"></a>
                                                                        <span class="readLessBtnText"
                                                                            style="display: none;">Read Less</span>
                                                                        <span class="readMoreBtnText"
                                                                            style="display: none;">Read More </span>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    @if(!$checkSold)
                                                    <div class="periodtime">
                                                        <div class="readMore">
                                                            <div class="readMoreWrapper">
                                                                <div class="readMoreText">
                                                                    <div class="listperiod_moredetails">
                                                                        @php
                                                                            $sold_tour = array();
                                                                        @endphp
                                                                        {{-- @foreach ($pre['period'] as $p) --}}
                                                                            <div class="tagmonth">
                                                                                <span class="month">{{$month[date('n',strtotime($pre['period'][0]->start_date))]}}</span>
                                                                            </div>
                                                                            <div class="splgroup">
                                                                                @foreach ($pre['period'] as $p)
                                                                                @php
                                                                                    if($p->count == 0 && $p->status_period == 3){
                                                                                        $sold_tour[] = $p->id;
                                                                                    }
                                                                                    $calen_start = strtotime($data->start_date);
                                                                                    $calen_end = strtotime($data->end_date);
                                                                                    $calendar = ceil(($calen_end - $calen_start)/86400);
                                                                                    $arrayDate = array();
                                                                                    $arrayDate[] = date('Y-m-d',$calen_start); 
                                                                                    for($x = 1; $x < $calendar; $x++){
                                                                                        $arrayDate[] = date('Y-m-d',($calen_start+(86400*$x)));
                                                                                    }
                                                                                   
                                                                                    $arrayDate[] = date('Y-m-d',$calen_end); // ช่วงวันหยุดของปฏิทิน
                                                                                @endphp
                                                                                <li>
                                                                                <?php 
                                                                                    $start = strtotime($p->start_date);
                                                                                    ${'holliday'.$p->id} = 0;
                                                                                        while ($start <= strtotime($p->end_date)) {
                                                                                            if(in_array(date('Y-m-d',$start),$arrayDate) || date('N',$start) >= 6){
                                                                                                if($p->count <= 10){

                                                                                                }else{
                                                                                                    ${'holliday'.$p->id}++;
                                                                                                }
                                                                                            }
                                                                                            $start = $start + 86400;
                                                                                        }
                                                                                    ?>
                                                                                     <a @if(${'holliday'.$p->id} > 0) data-tooltip="{{ ${'holliday'.$p->id} }} วัน" @endif id="staydate{{$p->id}}" class="staydate">
                                                                                        <?php 
                                                                                            $start = strtotime($p->start_date); 
                                                                                            $chk_price = true;
                                                                                            while ($start <= strtotime($p->end_date)) { 
                                                                                                if(in_array(date('Y-m-d',$start),$arrayDate) || date('N',$start) >= 6){
                                                                                                    $chk_price = false;
                                                                                                    echo $p->count <= 10 ? '<span class="fulltext">*</span>' : '<span class="staydate">-</span>';
                                                                                                    if($p->count <= 10){
                                                                                                        break;
                                                                                                    }
                                                                                                }
                                                                                                $start = $start + 86400;
                                                                                            }
                                                                                            if($chk_price){
                                                                                                if($p->special_price1 && $p->special_price1 > 0){
                                                                                                    $price = $p->price1 - $p->special_price1;
                                                                                                }else{
                                                                                                    $price = $p->price1;
                                                                                                }
                                                                                                echo '<span class="saleperiod">'.number_format($price,0).'฿ </span>';
                                                                                            }
                                                                                      
                                                                                    ?>
                                                                                     </a>
                                                                                     <br>
                                                                                     {{date('d',strtotime($p->start_date))}} - {{date('d',strtotime($p->end_date))}}
                                                                                </li>
                                                                                @endforeach
                                                                            </div>
                                                                            <hr>
                                                                            {{-- @endforeach --}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="readMoreGradient"></div>
                                                            </div>
                                                            @if(count($pre['period']) > 1)
                                                            <a class="readMoreBtn"></a>
                                                            <span class="readLessBtnText" style="display: none;">Read
                                                                Less</span>
                                                            <span class="readMoreBtnText" style="display: none;">Read
                                                                More</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="remainsFull">
                                                        <li>* ใกล้เต็ม</li>
                                                        <li><span class="noshowpad">-</span>
                                                            <span class="showpad">-</span> จำนวนวันหยุด</li>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-9">
                                                            @if(count($sold_tour))
                                                                <div class="fullperiod">
                                                                    <h6 class="pb-2">พีเรียดที่เต็มแล้ว ({{count($sold_tour)}})</h6>
                                                                    @foreach ($pre['period'] as $sold)
                                                                        <span class="monthsold">{{$month[date('n',strtotime($pre['period'][0]->start_date))]}}</span>
                                                                        @if($sold->count == 0 && $sold->status_period == 3)
                                                                        {{-- @foreach($sold as $so) --}}
                                                                            <li>{{date('d',strtotime($sold->start_date))}} - {{date('d',strtotime($sold->end_date))}} </li>
                                                                        {{-- @endforeach --}}
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-3 text-md-end">
                                                            <a href="{{url('tour/'.$pre['tour']->slug)}}" class="btn-main-og  morebtnog">รายละเอียด</a>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="table-list">
                                <div class="showtourontable  table-responsive-xl">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>โปรแกรม</th>
                                                <th>เมนูย่อย</th>
                                                <th>จำนวนวัน</th>
                                                <th>ช่วงเดือน</th>
                                                <th>สายการบิน</th>
                                                <th>ราคา</th>
                                                <th>โรงแรม</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="show_search_view">
                                            @foreach($period as $pre)
                                                <?php 
                                                    $country_list = App\Models\Backend\CountryModel::whereIn('id',json_decode($pre['tour']->country_id,true))->get();
                                                    $airline_list = \App\Models\Backend\TravelTypeModel::find($pre['tour']->airline_id);
                                                    $type_list = \App\Models\Backend\TourTypeModel::find(@$pre['tour']->type_id);
                                                ?>
                                                @if($pre['tour'])
                                                    <tr>
                                                        <td>
                                                            <div class="row">
                                                                <div class="col-5 col-lg-4">
                                                                    <a href="{{url('tour/'.$pre['tour']->slug)}}">
                                                                        <img src="{{ asset(@$pre['tour']->image) }}" class="img-fluid" alt=""></a>
                                                                </div>
                                                                <div class="col-7 col-lg-8 titlenametab">
                                                                    <h3><a href="{{url('tour/'.$pre['tour']->slug)}}"> {{ $pre['tour']->name }} </a>
                                                                    </h3>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><a href="{{ url('oversea/'.@$country_list[0]->slug)}}">@foreach ($country_list as $coun) {{$coun->country_name_th?$coun->country_name_th:$coun->country_name_en}} @endforeach</a> </td>
                                                        <td> <a href="javascript:void(0);" onclick="Check_filter({{$pre['period'][0]->day}},'day')">{{$pre['tour']->num_day}}</a> </td>
                                                        <td><a href="{{url('tour/'.$pre['tour']->slug)}}">{{$month[date('n',strtotime($pre['period'][0]->start_date))]}}</a></td>
                                                        <td><a href="javascript:void(0);" onclick="Check_filter({{@$airline_list->id}},'airline')"><img src="{{asset(@$airline_list->image)}}" alt=""></a> </td>
                                                        <td>
                                                            @if($pre['tour']->special_price > 0)
                                                            @php $price = $pre['tour']->price - $pre['tour']->special_price; @endphp
                                                                เริ่ม {{ number_format(@$price,0) }} บาท
                                                            @else
                                                                เริ่ม {{ number_format($pre['tour']->price,0) }} บาท
                                                            @endif
                                                        </td>
                                                        <td>
                                                                <div class="rating">
                                                                    @if($pre['tour']->rating > 0)
                                                                        <a href="javascript:void(0);" onclick="Check_filter({{$pre['tour']->rating}},'rating')">
                                                                            @for($i=1; $i <= @$pre['tour']->rating; $i++)
                                                                            <i class="bi bi-star-fill"></i>
                                                                            @endfor
                                                                        </a>
                                                                    @else
                                                                        <a href="javascript:void(0);" onclick="Check_filter(0,'rating')">
                                                                    @endif
                                                                </div>
                                                        </td>
                                                        <td> <a href="javascript:void(0);" class="tagicbest"  name="type_data" onclick="OrderByType({{@$pre['tour']->type_id}})"></a>
                                                        </td>
                                                        <td> <a href="{{url('tour/'.$pre['tour']->slug)}}" class="link"> <i class="bi bi-chevron-right"></i></a></td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
    @include("frontend.layout.inc_footer")
    <?php 

        echo '<script>';
        echo 'var data_type = '. json_encode($data_type) .';';
        echo 'var find_airline = '. json_encode($airline_data) .';';
        echo '</script>';
    ?>
    <script>
        var active_day = '';
        var active_price = '';
        var active_country = '';
        var active_city = '';
        var active_airline = '';
        var active_rating = '';
        var before = new Array();
        var type_data = {
            country: new Array(),
            city: new Array(),
            price: new Array(),
            airline: new Array(),
            rating: new Array(),
            day: new Array(),
        };
        var length_price = ['','ต่ำกว่า 10,000','10,001-20,000','20,001-30,000','30,001-50,000','50,001-80,000','80,001 ขึ้นไป'];
        
        function SelectFilter(){
            var text = '';
            var text_mb = '';
            var check_list = {
                country : 'country',
                city : 'city',
                day : 'day',
                airline : 'airline',
                rating : 'rating',
                price : 'price',

            };
            for(let x in type_data){
                if(type_data[x].length){
                    if(x == 'country'){
                        for(let y in type_data[x]){
                            let go = data_type[x].find(z=>z.id == type_data[x][y]);
                            let name_country = go.country_name_th?go.country_name_th:go.country_name_en;
                            // text += "<li onclick='document.getElementById(`"+check_list[x]+type_data[x][y]+"`).click()'><label class='check-container'>"+data_type[x].find(z=>z.id == type_data[x][y]).country_name_th+"  <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";  
                            text += "<li onclick='document.getElementById(`"+check_list[x]+type_data[x][y]+"`).click()'><label class='check-container'>"+name_country+"  <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";   
                            text_mb += "<li onclick='document.getElementById(`country_mb"+type_data[x][y]+"`).click()'><label class='check-container'>"+name_country+"  <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";                 
                        }
                    }
                    if(x == 'price'){
                        for(let y in type_data[x]){
                            text += "<li onclick='document.getElementById(`"+check_list[x]+type_data[x][y]+"`).click()'><label class='check-container'>"+length_price[type_data[x][y]]+"  <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>"; 
                            text_mb += "<li onclick='document.getElementById(`price_mb"+type_data[x][y]+"`).click()'><label class='check-container'>"+length_price[type_data[x][y]]+"  <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";           
                        }
                    }
                    if(x == 'city'){
                        for(let y in type_data[x]){
                            let go = data_type[x].find(z=>z.id == type_data[x][y]);
                            let name_city = go.city_name_th?go.city_name_th:go.city_name_en;
                            text += "<li onclick='document.getElementById(`"+check_list[x]+type_data[x][y]+"`).click()'><label class='check-container'>"+name_city+"  <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";  
                            text_mb += "<li onclick='document.getElementById(`city_mb"+type_data[x][y]+"`).click()'><label class='check-container'>"+name_city+"  <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";          
                        }
                    }
                    if(x == 'day'){
                        for(let y in type_data[x]){
                            text += "<li onclick='document.getElementById(`"+check_list[x]+type_data[x][y]+"`).click()'><label class='check-container'>"+type_data[x][y]+" วัน  <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";  
                            text_mb += "<li onclick='document.getElementById(`day_mb"+type_data[x][y]+"`).click()'><label class='check-container'>"+type_data[x][y]+" วัน  <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";          
                        }
                    }
                    if(x == 'airline'){
                        for(let y in type_data[x]){
                            text += "<li onclick='document.getElementById(`"+check_list[x]+type_data[x][y]+"`).click()'><label class='check-container'>"+data_type[x].find(z=>z.id == type_data[x][y]).travel_name+"  <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";    
                            text_mb += "<li onclick='document.getElementById(`airline_mb"+type_data[x][y]+"`).click()'><label class='check-container'>"+data_type[x].find(z=>z.id == type_data[x][y]).travel_name+"  <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";        
                        }
                    }
                    if(x == 'rating'){
                        for(let y in type_data[x]){
                            text += "<li onclick='document.getElementById(`"+check_list[x]+type_data[x][y]+"`).click()'><label class='check-container'>";
                            text_mb += "<li onclick='document.getElementById(`rating_mb"+type_data[x][y]+"`).click()'><label class='check-container'>";
                                // for(n=1;n<=type_data[x][y];n++){
                            //     text += '<i class="bi bi-star-fill"></i>';
                            // }  
                            if(type_data[x][y] != 0){
                                 text += type_data[x][y]+' ดาว';
                                 text_mb += type_data[x][y]+' ดาว';
                            }else{
                                 text += 'ไม่มีระดับดาวที่พัก';
                                 text_mb += 'ไม่มีระดับดาวที่พัก';
                            }   
                            text += " <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";  
                            text_mb += " <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";    
                        }
                    }
                  
                }
            }
            document.getElementById('show_select').innerHTML = text;
            document.getElementById('show_select_mb').innerHTML = text_mb;
            document.getElementById('show_select_mb_all').innerHTML = text_mb;
        }
        async function Check_filter(value,type){
            if(type_data[type].includes(value)){
                var index = type_data[type].indexOf(value);
                type_data[type].splice(index,1);
            }else{
                type_data[type].push(value);
            }
            if(type_data['price'].length != data_type['price'].length){
                document.getElementById('price7').checked = false;
                document.getElementById('price_mb7').checked = false;
            }else{
                document.getElementById('price7').checked = true;
                document.getElementById('price_mb7').checked = true;
            }
            SelectFilter();
            let payload = {
                data:type_data,
                _token: '{{csrf_token()}}',
                id:document.getElementById('calen_id').value,
                slug:document.getElementById('slug').value,
                orderby:document.getElementById('orderby_data').value,
            }
            Swal.fire({
                title: "Now loading",
                timerProgressBar: true,
                didOpen: () => {
                        Swal.showLoading();
                },
            });
            await $.ajax({
                type: 'POST',
                url: '{{url("/data-filter")}}',
                data: payload,
                success: function (data) {
                    console.log(data)
                    document.getElementById('show_search').innerHTML = data.tour_list;
                    document.getElementById('show_search_view').innerHTML = data.tour_grid;
                    document.getElementById('show_count').innerHTML = "พบ "+data.count_pe+" รายการ";
                    var country_select = '';
                    var country_select_mb = '';
                    for(let i in data.filter.country){
                        let num_tour = 0;
                        for(let y in data.period){
                            if(data.period[y].country_id.includes(data.filter.country[i])){
                                num_tour++;
                            }
                        }
                        if(i <= 9){
                            let go = data_type.country.find(z=>z.id == data.filter.country[i]);
                            let check = type_data.country.includes(data.filter.country[i]*1)?'checked':'';
                            let name_country = go.country_name_th?go.country_name_th:go.country_name_en;
                            country_select = country_select+'<li><label class="check-container">'+name_country;
                            country_select = country_select+'<input type="checkbox" name="country" id="country'+go.id+'" onclick="Check_filter('+go.id+',`country`)" value="'+go.id+'" '+check+'>';
                            country_select = country_select+'<span class="checkmark"></span><div class="count">('+num_tour+')</div></label></li>';

                            country_select_mb = country_select_mb+'<li><label class="check-container">'+name_country;
                            country_select_mb = country_select_mb+'<input type="checkbox" name="country" id="country_mb'+go.id+'" onclick="Check_filter('+go.id+',`country`)" value="'+go.id+'" '+check+'>';
                            country_select_mb = country_select_mb+'<span class="checkmark"></span><div class="count">('+num_tour+')</div></label></li>';
                        }else{
                            let go = data_type.country.find(z=>z.id == data.filter.country[i]);
                            let check = type_data.country.includes(data.filter.country[i]*1)?'checked':'';
                            let name_country = go.country_name_th?go.country_name_th:go.country_name_en;
                            country_select = country_select+'<div id="morecountry" class="collapse">';
                            country_select = country_select+'<li><label class="check-container">'+name_country;
                            country_select = country_select+'<input type="checkbox" name="country" id="country'+go.id+'" onclick="Check_filter('+go.id+',`country`)" value="'+go.id+'" '+check+'>';
                            country_select = country_select+'<span class="checkmark"></span><div class="count">('+num_tour+')</div></label></li>';
                            country_select = country_select+'</div>'

                            country_select_mb = country_select_mb+'<div id="morecountry" class="collapse">';
                            country_select_mb = country_select_mb+'<li><label class="check-container">'+name_country;
                            country_select_mb = country_select_mb+'<input type="checkbox" name="country" id="country_mb'+go.id+'" onclick="Check_filter('+go.id+',`country`)" value="'+go.id+'" '+check+'>';
                            country_select_mb = country_select_mb+'<span class="checkmark"></span><div class="count">('+num_tour+')</div></label></li>';
                            country_select_mb = country_select_mb+'</div>'
                        }  
                    }
                    if(data.filter.country.length > 9){ 
                        country_select = country_select+'<a data-bs-toggle="collapse" data-bs-target="#morecountry" class="seemore"> ดูเพิ่มเติม</a>';
                        country_select_mb = country_select_mb+'<a data-bs-toggle="collapse" data-bs-target="#morecountry" class="seemore"> ดูเพิ่มเติม</a>';
                    }
                    document.getElementById('show_country').innerHTML = country_select;
                    document.getElementById('show_country_mb').innerHTML = country_select_mb;
                    var price_select = '';
                    var price_select_mb = '';
                    var price_count = 0;
                    for(let p in data.filter.price){
                        let check = type_data.price.includes(p*1)?'checked':'';
                        price_select = price_select+'<li><label class="check-container">'+length_price[p];
                        price_select = price_select+'<input type="checkbox" name="price" id="price'+p+'" onclick="Check_filter('+p+',`price`)" value="'+p+'" '+check+'>';
                        price_select = price_select+'<span class="checkmark"></span><div class="count">('+data.filter.price[p].length+')</div></label></li>';
                        price_count++;

                        price_select_mb = price_select_mb+'<li><label class="check-container">'+length_price[p];
                        price_select_mb = price_select_mb+'<input type="checkbox" name="price" id="price_mb'+p+'" onclick="Check_filter('+p+',`price`)" value="'+p+'" '+check+'>';
                        price_select_mb = price_select_mb+'<span class="checkmark"></span><div class="count">('+data.filter.price[p].length+')</div></label></li>';
                    }
                    document.getElementById('show_price').innerHTML = price_select;  
                    document.getElementById('show_price_mb').innerHTML = price_select_mb;  
                    if(price_count > 1){
                        $('#show_total').show();  
                        $('#show_total_mb').show(); 
                    }else{
                        $('#show_total').hide();  
                        $('#show_total_mb').hide(); 
                    }
                    var day_select = '';
                    var day_select_mb = '';
                    for(let d in data.filter.day){
                        let check = type_data.day.includes(d*1)?'checked':'';
                        day_select = day_select+'<li><label class="check-container">'+d+' วัน';
                        day_select = day_select+'<input type="checkbox" name="day" id="day'+d+'" onclick="Check_filter('+d+',`day`)" value="'+d+'" '+check+'>';
                        day_select = day_select+'<span class="checkmark"></span><div class="count">('+data.filter.day[d].length+')</div></label></li>';
                       
                        day_select_mb = day_select_mb+'<li><label class="check-container">'+d+' วัน';
                        day_select_mb = day_select_mb+'<input type="checkbox" name="day" id="day_mb'+d+'" onclick="Check_filter('+d+',`day`)" value="'+d+'" '+check+'>';
                        day_select_mb = day_select_mb+'<span class="checkmark"></span><div class="count">('+data.filter.day[d].length+')</div></label></li>';
                    }
                    document.getElementById('show_day').innerHTML = day_select; 
                    document.getElementById('show_day_mb').innerHTML = day_select_mb; 
                    var city_select = '';
                    var city_select_mb = '';
                    for(let c in data.filter.city){
                        let num_tour = 0;
                        for(let y in data.period){
                            if(data.period[y].city_id.includes(data.filter.city[c])){
                                num_tour++;
                            }
                        }
                        if(c <= 9){
                            let go = data_type.city.find(z=>z.id == data.filter.city[c]);
                            let check = type_data.city.includes(data.filter.city[c]*1)?'checked':'';
                            let name_city = go.city_name_th?go.city_name_th:go.city_name_en;
                            city_select = city_select+'<li><label class="check-container">'+name_city ;
                            city_select = city_select+'<input type="checkbox" name="city" id="city'+go.id+'" onclick="Check_filter('+go.id+',`city`)" value="'+go.id+'" '+check+'>';
                            city_select = city_select+'<span class="checkmark"></span><div class="count">('+num_tour+')</div></label></li>';
                            
                            city_select_mb = city_select_mb+'<li><label class="check-container">'+name_city ;
                            city_select_mb = city_select_mb+'<input type="checkbox" name="city" id="city_mb'+go.id+'" onclick="Check_filter('+go.id+',`city`)" value="'+go.id+'" '+check+'>';
                            city_select_mb = city_select_mb+'<span class="checkmark"></span><div class="count">('+num_tour+')</div></label></li>';
                        }else{
                            let go = data_type.city.find(z=>z.id == data.filter.city[c]);
                            let check = type_data.city.includes(data.filter.city[c]*1)?'checked':'';
                            let name_city = go.city_name_th?go.city_name_th:go.city_name_en;
                            city_select = city_select+'<div id="moreprovince" class="collapse">';
                            city_select = city_select+'<li><label class="check-container">'+name_city ;
                            city_select = city_select+'<input type="checkbox" name="city" id="city'+go.id+'" onclick="Check_filter('+go.id+',`city`)" value="'+go.id+'" '+check+'>';
                            city_select = city_select+'<span class="checkmark"></span><div class="count">('+num_tour+')</div></label></li>';
                            city_select = city_select+'</div>'

                            city_select_mb = city_select_mb+'<div id="moreprovince" class="collapse">';
                            city_select_mb = city_select_mb+'<li><label class="check-container">'+name_city ;
                            city_select_mb = city_select_mb+'<input type="checkbox" name="city" id="city_mb'+go.id+'" onclick="Check_filter('+go.id+',`city`)" value="'+go.id+'" '+check+'>';
                            city_select_mb = city_select_mb+'<span class="checkmark"></span><div class="count">('+num_tour+')</div></label></li>';
                            city_select_mb = city_select_mb+'</div>'
                        }
                      
                    }
                    if(data.filter.city.length > 9){ 
                        city_select = city_select+'<a data-bs-toggle="collapse" data-bs-target="#moreprovince" class="seemore"> ดูเพิ่มเติม</a>';
                        city_select_mb = city_select_mb+'<a data-bs-toggle="collapse" data-bs-target="#moreprovince" class="seemore"> ดูเพิ่มเติม</a>';
                    }
                    document.getElementById('show_city').innerHTML = city_select;
                    document.getElementById('show_city_mb').innerHTML = city_select_mb;
                    var airline_select = '';
                    var airline_select_mb = '';
                    var airline_count = 0;
                    for(let a in data.filter.airline){
                        if(a){
                            airline_count++
                        }
                        if(airline_count <= 10){
                            let go = data_type.airline.find(z=>z.id == a);
                            let check = type_data.airline.includes(a*1)?'checked':'';
                            airline_select = airline_select+'<li><label class="check-container">';
                            if(go.image){
                                airline_select = airline_select+'<img src="/'+go.image+'" alt=""> '+go.travel_name;
                            }else{
                                airline_select = airline_select+go.travel_name;
                            }
                            airline_select = airline_select+'<input type="checkbox" name="airline" id="airline'+a+'" onclick="Check_filter('+a+',`airline`)" value="'+a+'" '+check+'>';
                            airline_select = airline_select+'<span class="checkmark"></span><div class="count">('+data.filter.airline[a].length+')</div></label></li>';
                        
                            airline_select_mb = airline_select_mb+'<li><label class="check-container">';
                            if(go.image){
                                airline_select_mb = airline_select_mb+'<img src="/'+go.image+'" alt=""> '+go.travel_name;
                            }else{
                                airline_select_mb = airline_select_mb+go.travel_name;
                            }
                            airline_select_mb = airline_select_mb+'<input type="checkbox" name="airline" id="airline_mb'+a+'" onclick="Check_filter('+a+',`airline`)" value="'+a+'" '+check+'>';
                            airline_select_mb = airline_select_mb+'<span class="checkmark"></span><div class="count">('+data.filter.airline[a].length+')</div></label></li>';
                        }else{
                            let go = data_type.airline.find(z=>z.id == a);
                            let check = type_data.airline.includes(a*1)?'checked':'';
                            airline_select = airline_select+'<div id="moreair" class="collapse"><li><label class="check-container">';
                            if(go.image){
                                airline_select = airline_select+'<img src="/'+go.image+'" alt=""> '+go.travel_name;
                            }else{
                                airline_select = airline_select+go.travel_name;
                            }
                            airline_select = airline_select+'<input type="checkbox" name="airline" id="airline'+a+'" onclick="Check_filter('+a+',`airline`)" value="'+a+'" '+check+'>';
                            airline_select = airline_select+'<span class="checkmark"></span><div class="count">('+data.filter.airline[a].length+')</div></label></li></div>';
                        
                            airline_select_mb = airline_select_mb+'<div id="moreair" class="collapse"><li><label class="check-container">';
                            if(go.image){
                                airline_select_mb = airline_select_mb+'<img src="/'+go.image+'" alt=""> '+go.travel_name;
                            }else{
                                airline_select_mb = airline_select_mb+go.travel_name;
                            }
                            airline_select_mb = airline_select_mb+'<input type="checkbox" name="airline" id="airline_mb'+a+'" onclick="Check_filter('+a+',`airline`)" value="'+a+'" '+check+'>';
                            airline_select_mb = airline_select_mb+'<span class="checkmark"></span><div class="count">('+data.filter.airline[a].length+')</div></label></li></div>';
                        }      
                    }
                    if(airline_count > 10){
                            airline_select = airline_select+'<a data-bs-toggle="collapse" data-bs-target="#moreair" class="seemore"> ดูเพิ่มเติม</a>';
                            airline_select_mb = airline_select_mb+'<a data-bs-toggle="collapse" data-bs-target="#moreair" class="seemore"> ดูเพิ่มเติม</a>';
                    } 
                    document.getElementById('show_air').innerHTML = airline_select; 
                    document.getElementById('show_air_mb').innerHTML = airline_select_mb; 

                    var rating_select = '';
                    var rating_select_mb = '';
                    for(let r in data.filter.rating){
                        let check = type_data.rating.includes(r*1)?'checked':'';
                        rating_select = rating_select+'<li><label class="check-container"><div class="rating">';
                        if(r*1 == 0){
                            rating_select = rating_select+'ไม่มีระดับดาวที่พัก';
                        }else{
                            for(n=1;n<=r*1;n++){
                                rating_select = rating_select+'<i class="bi bi-star-fill"></i>';
                            }     
                        }                         
                        rating_select = rating_select+'</div><input type="checkbox" name="rating" id="rating'+r*1+'" onclick="Check_filter('+r*1+',`rating`)" value="'+r*1+'" '+check+'>';
                        rating_select = rating_select+'<span class="checkmark"></span><div class="count">('+data.filter.rating[r].length+')</div></label></li>';
                       
                        rating_select_mb = rating_select_mb+'<li><label class="check-container"><div class="rating">';
                        if(r*1 == 0){
                            rating_select_mb = rating_select_mb+'ไม่มีระดับดาวที่พัก';
                        }else{
                            for(n=1;n<=r*1;n++){
                                rating_select_mb = rating_select_mb+'<i class="bi bi-star-fill"></i>';
                            }     
                        }                         
                        rating_select_mb = rating_select_mb+'</div><input type="checkbox" name="rating" id="rating_mb'+r*1+'" onclick="Check_filter('+r*1+',`rating`)" value="'+r*1+'" '+check+'>';
                        rating_select_mb = rating_select_mb+'<span class="checkmark"></span><div class="count">('+data.filter.rating[r].length+')</div></label></li>';
                    }
                    document.getElementById('show_rating').innerHTML = rating_select; 
                    document.getElementById('show_rating_mb').innerHTML = rating_select_mb; 

                    Swal.close();
                }
            });
            readMore();
        }

        function UncheckdDay (tid){
            if(active_day){
                 $('#day'+active_day).prop('checked', false);
            }
            active_day = active_day==tid?null:tid ;
            Send_search();
        }
        
        async function UncheckdPrice (tid){
           
            if(tid == 7){
                if(document.getElementById('price'+tid).checked || document.getElementById('price_mb'+tid).checked){
                    type_data['price'] = new Array();
                    for(x=1;x<7;x++){
                        if( document.getElementById('price'+x) || document.getElementById('price_mb'+x)){
                            document.getElementById('price'+x).checked = true;
                            document.getElementById('price_mb'+x).checked = true;
                            // before.push(x);
                            type_data['price'].push(x);
                        }
                        
                    }
                }else{
                    type_data['price'] = new Array();
                    for(x=1;x<7;x++){
                        if(document.getElementById('price'+x) || document.getElementById('price_mb'+x)){
                            document.getElementById('price'+x).checked = false;
                            document.getElementById('price_mb'+x).checked = false;
                        }
                        
                    }
                }
            }else{
                if(document.getElementById('price'+tid).checked == true || document.getElementById('price_mb'+tid).checked == true){
                    type_data['price'].push(tid);
                }else{
                    var index = type_data['price'].indexOf(tid);
                    type_data['price'].splice(index,1);
                }
            }
            SelectFilter();
            // await Send_price(type_data['price']);
            Send_search();
            // if(active_price){
            //     $('#price'+active_price).prop('checked', false);
            // }
            // active_price = active_price==tid?null:tid ;
            // Send_search();
        }
    
        function UncheckdCountry (tid){
            if(active_country){
                 $('#country'+active_country).prop('checked', false);
            }
            active_country = active_country==tid?null:tid ;
            Send_search();
        }
        function UncheckdCity (tid){
            if(active_city){
                 $('#city'+active_city).prop('checked', false);
            }
            active_city = active_city==tid?null:tid ;
            Send_search();
        }
        function UncheckdAirline (tid){
            if(active_airline){
                 $('#airline'+active_airline).prop('checked', false);
            }
            active_airline = active_airline==tid?null:tid ;
            Send_search();
        }
        function UncheckdRating (tid){
            if(active_rating){
                 $('#rating'+active_rating).prop('checked', false);
            }
            active_rating = active_rating==tid?null:tid ;
            Send_search();
        }
        
        async function Send_search(){
                var form = $('#searchForm')[0];
                var data = new FormData(form);
                await $.ajax({
                    type: 'POST',
                    url: '{{url("/search-weekend")}}',
                    data: data,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (datas) {
                        document.getElementById('show_count').innerHTML = "พบ "+datas.period+" รายการ";
                        document.getElementById('show_search').innerHTML = datas.data;
                    }
                });
                readMore();
                return false;
        }
        function readMore(){
            var $readMore = "ดูช่วงเวลาเพิ่มเติม ";
            var $readLess = "ย่อข้อความ";
            $(".readMoreBtn").text($readMore);
            $('.readMoreBtn').click(function () {
                var $this = $(this);
                console.log($readMore);
                $this.text($readMore);
                if ($this.data('expanded') == "yes") {
                    $this.data('expanded', "no");
                    $this.text($readMore);
                    $this.parent().find('.readMoreText').animate({
                        maxHeight: '120px'
                    });
                } else {
                    $this.data('expanded', "yes");
                    $this.parent().find('.readMoreText').css({
                        maxHeight: 'none'
                    });
                    $this.text($readLess);

                }
            });

            var $readMore2 = "<i class=\"fi fi-rr-angle-small-down\"></i>";
            var $readLess2 = "<i class=\"fi fi-rr-angle-small-up\"></i>";
            $(".readMoreBtn2").html($readMore2);
            $('.readMoreBtn2').click(function () {
                var $this = $(this);
                console.log($readMore2);
                $this.html($readMore2);
                if ($this.data('expanded') == "yes") {
                    $this.data('expanded', "no");
                    $this.html($readMore2);
                    $this.parent().find('.readMoreText2').animate({
                        height: '50px'
                    });
                } else {
                    $this.data('expanded', "yes");
                    $this.parent().find('.readMoreText2').css({
                        height: 'auto'
                    });
                    $this.html($readLess2);

                }
            });
        }
        function Search_airline(){
            var air_value = document.getElementById('search_airline').value;
            if(air_value != ''){
                var air_id = document.getElementById('airline_id').value;
                var air_num = document.getElementById('airline_num').value;
                    $.ajax({
                    type: 'POST',
                    url: '{{url("/search-airline")}}',
                    data:  {
                        _token: '{{csrf_token()}}',
                        text:air_value,
                        id:air_id,
                        num:air_num,
                    },
                    success: function (datas) {
                        if(datas){
                            document.getElementById('show_air').innerHTML = datas;
                        }else{
                            document.getElementById('show_air').innerHTML = "<center><strong class='text-danger'>ไม่พบผลการค้นหา</strong></center>";
                            // document.getElementById('search_airline').value = null ;
                        }
                    }
                });
            }else{
                window.location.reload();
            }
        }
        function Search_country(){
            var country_value = document.getElementById('country_search').value;
            if(country_value != ''){
                var country_id = document.getElementById('country_data').value;
                var country_num = document.getElementById('country_num').value;
                    $.ajax({
                    type: 'POST',
                    url: '{{url("/search-country")}}',
                    data:  {
                        _token: '{{csrf_token()}}',
                        text:country_value,
                        id:country_id,
                        num:country_num,
                    },
                    success: function (datas) {
                        if(datas){
                            document.getElementById('show_country').innerHTML = datas;
                            document.getElementById('show_country_mb').innerHTML = datas;
                        }else{
                            document.getElementById('show_country').innerHTML = "<center><strong class='text-danger'>ไม่พบผลการค้นหา</strong></center>";
                            document.getElementById('show_country_mb').innerHTML = "<center><strong class='text-danger'>ไม่พบผลการค้นหา</strong></center>";
                        }
                    }
                });
            }else{
                window.location.reload();
            }
        }
        function Search_city(){
            var city_value = document.getElementById('city_search').value;
            if(city_value != ''){
                var city_id = document.getElementById('city_data').value;
                var city_num = document.getElementById('city_num').value;
                    $.ajax({
                    type: 'POST',
                    url: '{{url("/search-city")}}',
                    data:  {
                        _token: '{{csrf_token()}}',
                        text:city_value,
                        id:city_id,
                        num:city_num,
                    },
                    success: function (datas) {
                        if(datas){
                            document.getElementById('show_city').innerHTML = datas;
                            document.getElementById('show_city_mb').innerHTML = datas;
                        }else{
                            document.getElementById('show_city').innerHTML = "<center><strong class='text-danger'>ไม่พบผลการค้นหา</strong></center>";
                            document.getElementById('show_city_mb').innerHTML = "<center><strong class='text-danger'>ไม่พบผลการค้นหา</strong></center>";
                        }
                    }
                });
            }else{
                window.location.reload();
            }
        }
        async function Send_price(p){
                $.ajax({
                    type: 'GET',
                    url: '{{url("/search-price")}}',
                    data: {
                        price: p,
                        start_date:document.getElementById('start_date').value,
                        end_date:document.getElementById('end_date').value,
                        calen_id:document.getElementById('calen_id').value,
                        slug:document.getElementById('slug').value,
                    },
                    success: function (data) {
                        document.getElementById('show_day').innerHTML = data;
                    }
                });
                // var form = $('#searchForm')[0];
                // var data = new FormData(form);
                // await $.ajax({
                //     type: 'POST',
                //     url: '{{url("/search-price")}}',
                //     data: p,
                //     processData: false,
                //     contentType: false,
                //     cache: false,
                //     success: function (datas) {
                //         // document.getElementById('show_count').innerHTML = "พบ "+datas.period+" รายการ";
                //         document.getElementById('show_day').innerHTML = datas;
                //     }
                // });
                return false;
        }
        function OrderByData(id) {
            if(id != null){
                $.ajax({
                    type: 'GET',
                    url: '{{url("/weekend-landing")}}/{{$calen_id}}/{{$slug}}?orderby='+id,
                    success: function (data) {
                        var newUrl = '{{url("/weekend-landing")}}/{{$calen_id}}/{{$slug}}?orderby='+id; 
                        window.location.replace(newUrl);
                    }
                });
            }else{
                window.location.reload();
            }
            
        }
        function OrderByType(id) {
            if(id != null){
                $.ajax({
                    type: 'GET',
                    url: '{{url("/weekend-landing")}}/{{$calen_id}}/{{$slug}}?type='+id,
                    success: function (data) {
                        var newUrl = '{{url("/weekend-landing")}}/{{$calen_id}}/{{$slug}}?type='+id; 
                        window.location.replace(newUrl);
                    }
                });
            }else{
                window.location.reload();
            }
            
        }
    </script>
    <script>
        $(document).ready(function () {
            $('.weekslider').owlCarousel({
                loop: false,
                item: 1,
                margin: 20,
                slideBy: 1,
                autoplay: false,
                smartSpeed: 2000,
                nav: true,
                navText: ['<img src="{{asset('frontend/images/arrowRight.svg')}}">', '<img src="{{asset('frontend/images/arrowLeft.svg')}}">'],
                navClass: ['owl-prev', 'owl-next'],
                dots: false,
                responsive: {
                    0: {
                        items: 2,
                        margin: 10,
                        nav: false,


                    },
                    600: {
                        items: 3,
                        margin: 10,
                        nav: false,

                    },
                    1024: {
                        items: 4,
                        slideBy: 1
                    },
                    1200: {
                        items: 6,
                        slideBy: 1
                    }
                }
            })
            $('.recweekslide').owlCarousel({
                loop: false,
                item: 1,
                margin: 20,
                slideBy: 1,
                autoplay: false,
                smartSpeed: 2000,
                nav: true,
                navText: ['<img src="{{asset('frontend/images/arrowRight.svg')}}">', '<img src="{{asset('frontend/images/arrowLeft.svg')}}">'],
                navClass: ['owl-prev', 'owl-next'],
                dots: false,
                responsive: {
                    0: {
                        items: 1,
                        margin: 10,
                        nav: false,


                    },
                    600: {
                        items: 2,
                        margin: 10,
                        nav: false,

                    },
                    1024: {
                        items: 3,
                        slideBy: 1
                    },
                    1200: {
                        items: 4,
                        slideBy: 1
                    }
                }
            })



        });
    </script>
    
</body>

</html>