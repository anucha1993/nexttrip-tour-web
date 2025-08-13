<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    @include("frontend.layout.inc_header")
    <!-- Datepicker-->
    {{-- <script src="{{asset('frontend/js/datepicker.js')}}"></script>
    <script src="{{asset('frontend/js/daterangepicker.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('frontend/css/daterangepicker.css')}}"/> --}}
    {{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> --}}
</head>

<body>
    @include("frontend.layout.inc_topmenu")
    <section id="homepage" class="wrapperPages">
        <div class=" bannerhomepage owl-carousel owl-theme">
            @foreach($slide as $s)
                <div class="item">
                    <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                        <img src="{{asset($s->img)}}" alt="">
                    </div>
                    <div class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
                        <img src="{{asset($s->img_mobile)}}" alt="">
                    </div>
                    <div class="captionbanner">
                        {!! $s->detail !!}
                    </div>
                </div>
            @endforeach
        </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="searchtripfull">
                        <h2>ไปเที่ยวที่ไหนดี?</h2>
                        <form action="{{url('search-tour')}}" method="POST" enctype="multipart/form-data"  id="searchForm">
                            @csrf
                            <div class="input-group formcountry mb-3">
                                <span class="input-group-text" id="basic-addon1"><i class="fi fi-rr-search"></i></span>
                                <input type="text" class="form-control" placeholder="ประเทศ, เมือง, สถานที่ท่องเที่ยว"
                                    aria-label="country" aria-describedby="basic-addon1" name="search_data" id="search_data" onkeyup="SearchData()" onfocusout="HideSearch()"  onfocus="$('#search_famus').show();$('#livesearch').show()">
                               
                            </div>
                                <div id="livesearch" ></div>
                                <div id="search_famus" class="searchexpbox"></div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-12 col-lg-12">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar"></i></span>
                                                    <input type="text" class="form-control" name="daterange" id="hide_date_select" value="{{date('m/d/Y')}} - {{date('m/d/Y',strtotime('+1 day'))}}" />
                                                    <input type="hidden" name="start_date" id="start_date" {{-- value="{{date('Y-m-d')}}" --}} />
                                                    <input type="hidden" name="end_date" id="end_date" {{-- value="{{date('Y-m-d',strtotime('+1 day'))}}" --}} />
                                                    <div class="form-control"  style="height:68px;" id="show_date_calen" onclick="show_datepicker()" >
                                                        {{-- <input type="text" id="show_date_select" /><br>
                                                        <input type="text" id="show_day_select" /> --}}
                                                    </div>
                                                    <div class="form-control" style="height:68px;" id="show_end_calen" onclick="show_datepicker()" ></div>
                                                </div>
                                                
                                            </div>
                                            {{-- <div class="col-6 col-lg-6">
                                                <div class="input-group mb-3">
                                                    <input class="form-control" type="date" name="end_date" />
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <select class="form-select" name="price" aria-label="Default select example">
                                                    <option value="" selected>ช่วงราคา</option>
                                                    <option value="1">ต่ำกว่า10,000</option>
                                                    <option value="2">10,001-20,000</option>
                                                    <option value="3">20,001-30,000</option>
                                                    <option value="4">30,001-50,000</option>
                                                    <option value="5">50,001-80,000</option>
                                                    <option value="5">80,001 ขึ้นไป</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" name="code_tour" placeholder="รหัสทัวร์">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="row">
                                        <div class="col-6 col-lg-3">
                                            <input class="form-control" type="date" name="start_date" />
                                        </div>
                                        <div class="col-6 col-lg-3">
                                            <input class="form-control" type="date" name="end_date" />
                                        </div>
                                        <div class="col-6 col-lg-6">
                                            <select class="form-control"  aria-label="ช่วงราคา" name="price">
                                                <option value="">ช่วงราคา</option>
                                                <option value="1">ต่ำกว่า 10,000</option>
                                                <option value="2">10,001-20,000</option>
                                                <option value="3">20,001-30,000</option>
                                                <option value="4">30,001-50,000</option>
                                                <option value="5">50,001-80,000</option>
                                                <option value="6">80,001 ขึ้นไป</option>
                                            </select>
                                        </div>
                                        <div class="col-6 col-lg-6">
                                            <input type="text" class="form-control" placeholder="รหัสทัวร์" name="tour_code">
                                        </div>
                                </div> --}}
                            <button type="submit" class="btn btn-submit-search ">ค้นหาทัวร์</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
       
        <div class="container">
            <section class="promotionhome">
                <div class="row  mb-4">
                    <div class="col">
                        <div class="titletopic text-center">
                            <h2>บริษัททัวร์ในประเทศ ทัวร์ต่างประเทศ ชั้นนำของไทย </h2>
                            <p>นำเสนอโปรโมชั่นยอดฮิต</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="promotionslide owl-carousel owl-theme" id="promotionslide">
                            @foreach($ads as $ad)
                                <div class="item">
                                    <div class="hoverstyle">
                                        <figure>
                                            <a href="{{$ad->link}}" target="_blank"><img src="{{asset($ad->img)}}" class="img-fluid" alt=""></a>
                                        </figure>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
            <section class="hotcountry">
                <div class="row mt-3">
                    <div class="col">
                        <div class="titletopic text-center">
                            <h2>ประเทศยอดนิยม</h2>
                            <p>ประเทศยอดฮิตที่คุณต้องไปกับเรา</p>
                        </div>
                    </div>
                </div>
                <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                    <div class="row">
                        <div class="col">
                            <div id="carousel">
                                <ul class="flip-items">
                                    @foreach(@$country as $co)
                                    @php
                                        $tour_count = App\Models\Backend\TourModel::where('country_id','like','%"'.@$co->id.'"%')->count();
                                    @endphp
                                    <li>
                                        <a href="{{url('oversea/'.$co->slug)}}">
                                            @if($co->img_banner)
                                                <img src="{{asset(@$co->img_banner)}}">
                                            @else
                                                <img src="{{asset('frontend/images/country.webp')}}">
                                            @endif
                                            <div class="contents">
                                                <h3>ทัวร์ประเทศ{{@$co->country_name_th}}</h3>
                                                <span>{{@$tour_count}} โปรแกรมทัวร์</span>
                                            </div>
                                            <div class="textbotp">
                                                <p>{!! @$co->description !!}</p>
                                            </div>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
                    <div class="row">
                        <div class="col">
                            <div class="countryslider owl-carousel owl-theme">
                                @foreach(@$country as $co)
                                @php
                                    $tour_count = App\Models\Backend\TourModel::where('country_id','like','%"'.@$co->id.'"%')->count();
                                @endphp
                                <div class="item">
                                    <div class="groupctib hoverstyle">
                                        <figure>
                                            <a href="{{url('oversea/'.$co->slug)}}">
                                                @if($co->img_banner)
                                                    <img src="{{asset(@$co->img_banner)}}">
                                                @else
                                                    <img src="{{asset('frontend/images/country.webp')}}">
                                                @endif
                                            </a>
                                        </figure>
                                        <div class="contents">
                                            <h3>ทัวร์ประเทศ{{@$co->country_name_th}}</h3>
                                            <span>{{@$tour_count}} โปรแกรมทัวร์</span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="tourlist">
                <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                    <div class="row mt-5 mb-4">
                        <div class="col">
                            <div class="titletopic text-center">
                                <h2>เลือกทัวร์ที่ใช่ในสไตล์คุณ</h2>
                            </div>
                        </div>
                    </div>
                    @php
                        $month = ['','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
                        // $tour = App\Models\Backend\TourModel::where(['status'=>'on','deleted_at'=>null])->orderby('price','asc')->get();
                        $tour_type = App\Models\Backend\TourTypeModel::where(['status'=>'on','deleted_at'=>null])->orderby('id','asc')->get();
                        $tour_price = App\Models\Backend\TourModel::where(['tb_tour.status'=>'on','tb_tour.deleted_at'=>null])
                        ->where('tb_tour.special_price','>',0)
                        ->leftjoin('tb_tour_period','tb_tour.id','=','tb_tour_period.tour_id')
                        ->where('tb_tour_period.status_display', 'on')
                        ->where('tb_tour_period.count','>',0)
                        ->whereDate('tb_tour_period.start_date','>=',now())
                        ->whereNull('tb_tour_period.deleted_at')
                        ->where('tb_tour_period.status_period','!=',3)
                        ->orderby('tb_tour_period.start_date','asc')
                        ->groupBy('tb_tour_period.tour_id')
                        ->select('tb_tour.*')
                        ->orderby('tb_tour.special_price','desc')
                        ->limit(4)
                        ->get();
                    @endphp
                    <div class="row mt-5">
                        <div class="col">
                            <div class="listtourid select-display-slide">
                                <li rel="1" class="active">
                                    <a href="javascript:void(0)">
                                        ทัวร์สนใจมากที่สุด </a>
                                </li>
                                @foreach ($tour_type as $tt)
                                <li rel="type{{$tt->id}}">
                                    <a href="javascript:void(0)">
                                        {{$tt->type_name}} </a>
                                </li>
                                @endforeach
                                <li rel="4">
                                    <a href="javascript:void(0)">
                                        ทัวร์ที่ลดราคา</a>
                                </li>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col">
                            <div class="display-slide" rel="1" style="display:block;">
                                <div class="row">
                                    @foreach ($tour_views as $tv)
                                    @php
                                        $tv_country = \App\Models\Backend\CountryModel::whereIn('id',json_decode(@$tv->country_id,true))->first();
                                        $tv_airline = \App\Models\Backend\TravelTypeModel::find(@$tv->airline_id);
                                        $tv_period_all = \App\Models\Backend\TourPeriodModel::where(['tour_id'=>@$tv->id,'status_display'=>'on'])->whereDate('start_date','>=',now())->whereNull('deleted_at')->orderby('start_date','asc')->get();
                                        $tv_period = $tv_period_all->groupby('group_date');
                                        // $tv_period = \App\Models\Backend\TourPeriodModel::where(['tour_id'=>@$tv->id])->whereDate('start_date','>=',now())->whereNull('deleted_at')->orderby('start_date','asc')->get()->groupby('group_date');

                                        $allSoldOut = $tv_period_all->every(function ($tv_period_all) {
                                            return $tv_period_all->status_period == 3; // เช็คถ้าทุก Period เป็น sold out
                                        });
                                    @endphp
                                    <div class="col-lg-4 col-xl-3">
                                        <div class="showvertiGroup">
                                            <div class="boxwhiteshd hoverstyle">
                                                <figure>
                                                    <a href="{{url('tour/'.$tv->slug)}}" target="_blank">
                                                        <img src="{{ asset(@$tv->image) }}" alt="">
                                                    </a>
                                                </figure>
                                                @if(@$tv->special_price > 0)
                                                <div class="saleonpicbox">
                                                    <span> ลดราคาพิเศษ</span> <br>
                                                    {{ number_format($tv->special_price,0) }} บาท <br>
                                                    <span>เหลือเริ่ม</span> <br>
                                                    {{ number_format($tv->price - $tv->special_price,0) }}
                                                </div>
                                                @endif
                                                {{-- <div class="tagontop">
                                                    <li class="bgor"><a>{{$tv->num_day}}</a> </li>
                                                    <li class="bgblue"><a><i class="fi fi-rr-marker"></i>
                                                        {{@$tv_country->country_name_th}}</a> </li>
                                                    <li>
                                                        สายการบิน <img src="{{asset(@$tv_airline->image)}}" alt="">
                                                    </li>
                                                </div> --}}
                                                <div class="contenttourshw">
                                                    <div class="codeandhotel">
                                                        <li>รหัสทัวร์ : <span class="bluetext">@if(@$tv->code1_check) {{@$tv->code1}} @else {{@$tv->code}} @endif</span> </li>
                                                        <li class="rating">โรงแรม
                                                            @for($i=1; $i <= @$tv->rating; $i++)
                                                                <i class="bi bi-star-fill"></i>
                                                            @endfor
                                                        </li>

                                                    </div>
                                                    <hr>
                                                    <div class="locationnewd mb-2 mt-2">
                                                        <li> <a> <i class="fi fi-rr-marker"></i> {{@$tv_country->country_name_th}}</a></li>
                                                        <li class="datetour"><a>{{$tv->num_day}}</a> </li>
                                                        <li class="airlines"> 
                                                            สายการบิน <img src="{{asset(@$tv_airline->image)}}" alt=""> 
                                                        </li>
                                                    </div>
                                                    <h3><a href="{{url('tour/'.$tv->slug)}}" target="_blank"> {{$tv->name}}</a></h3>
                                                    <div class="listperiod">
                                                        @foreach($tv_period as $tve)
                                                        <li><span class="month">{{$month[date('n',strtotime($tve[0]->start_date))]}}</span>
                                                            @php $toEnd = count($tve);  @endphp
                                                            @foreach($tve as $key => $p)
                                                                {{date('d',strtotime($p->start_date))}} - {{date('d',strtotime($p->end_date))}} @if(0 !== --$toEnd)/@endif
                                                            @endforeach
                                                        </li><br>
                                                        @endforeach
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-lg-7">
                                                            <div class="pricegroup">
                                                                @if($tv->special_price > 0)
                                                                @php $tv_price = $tv->price - $tv->special_price; @endphp
                                                                    <span class="originalprice">ปกติ {{ number_format($tv->price,0) }} </span><br>
                                                                    เริ่ม<span class="saleprice"> {{ number_format(@$tv_price,0) }} บาท</span>
                                                                @else
                                                                    <span class="saleprice"> {{ number_format($tv->price,0) }} บาท</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5 ps-0">
                                                            <a href="{{url('tour/'.$tv->slug)}}" target="_blank" class="btn-main-og morebtnog">รายละเอียด</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @foreach ($tour_type as $tt)
                            <div class="display-slide" rel="type{{$tt->id}}">
                                @php
                                    $tours = App\Models\Backend\TourModel::where(['type_id'=>$tt->id,'status'=>'on','deleted_at'=>null])->orderby('price','asc')->limit(4)->get();
                                @endphp
                                <div class="row">
                                    @foreach ($tours as $tour)
                                    @php
                                        $tour_country = \App\Models\Backend\CountryModel::whereIn('id',json_decode(@$tour->country_id,true))->first();
                                        $tour_airline = \App\Models\Backend\TravelTypeModel::find(@$tour->airline_id);
                                        $tour_period_all = \App\Models\Backend\TourPeriodModel::where(['tour_id'=>@$tour->id,'status_display'=>'on'])->whereDate('start_date','>=',now())->whereNull('deleted_at')->orderby('start_date','asc')->get();
                                        $tour_period = $tour_period_all->groupby('group_date');

                                        $allSoldOut = $tour_period_all->every(function ($tour_period_all) {
                                            return $tour_period_all->status_period == 3; // เช็คถ้าทุก Period เป็น sold out
                                        });
                                    @endphp
                                    <div class="col-lg-4 col-xl-3">
                                        <div class="showvertiGroup">
                                            <div class="boxwhiteshd hoverstyle">
                                                <figure>
                                                    <a href="{{url('tour/'.$tour->slug)}}" target="_blank">
                                                        <img src="{{ asset(@$tour->image) }}" alt="">
                                                    </a>
                                                </figure>
                                                <div class="icontaglabll">
                                                    <img src="{{asset($tt->image)}}" class="img-fluid" alt="">
                                                </div>
                                                {{-- <div class="tagontop">
                                                    <li class="bgor"><a>{{$tour->num_day}}</a> </li>
                                                    <li class="bgblue"><a><i class="fi fi-rr-marker"></i>
                                                        {{@$tour_country->country_name_th}}</a> </li>
                                                    <li>
                                                        สายการบิน <img src="{{asset(@$tour_airline->image)}}" alt="">
                                                    </li>
                                                </div> --}}
                                                <div class="contenttourshw">
                                                    <div class="codeandhotel">
                                                        <li>รหัสทัวร์ : <span class="bluetext">@if(@$tour->code1_check) {{@$tour->code1}} @else {{@$tour->code}} @endif</span> </li>
                                                        <li class="rating">โรงแรม
                                                            @for($i=1; $i <= @$tour->rating; $i++)
                                                                <i class="bi bi-star-fill"></i>
                                                            @endfor
                                                        </li>

                                                    </div>
                                                    <hr>
                                                    <div class="locationnewd mb-2 mt-2">
                                                        <li> <a> <i class="fi fi-rr-marker"></i> {{@$tour_country->country_name_th}}</a></li>
                                                        <li class="datetour"><a>{{$tour->num_day}}</a> </li>
                                                        <li class="airlines"> 
                                                            สายการบิน <img src="{{asset(@$tour_airline->image)}}" alt=""> 
                                                        </li>
                                                    </div>
                                                    <h3><a href="{{url('tour/'.$tour->slug)}}" target="_blank"> {{$tour->name}}</a></h3>
                                                    <div class="listperiod">
                                                        @foreach($tour_period as $tpe)
                                                        <li><span class="month">{{$month[date('n',strtotime($tpe[0]->start_date))]}}</span>
                                                            @php $toEnd = count($tpe);  @endphp
                                                            @foreach($tpe as $key => $p)
                                                                {{date('d',strtotime($p->start_date))}} - {{date('d',strtotime($p->end_date))}} @if(0 !== --$toEnd)/@endif
                                                            @endforeach
                                                        </li>
                                                        @endforeach
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-lg-7">
                                                            <div class="pricegroup">
                                                                @if($tour->special_price > 0)
                                                                @php $t_price = $tour->price - $tour->special_price; @endphp
                                                                    <span class="originalprice">ปกติ {{ number_format($tour->price,0) }} </span><br>
                                                                    เริ่ม<span class="saleprice"> {{ number_format(@$t_price,0) }} บาท</span>
                                                                @else
                                                                    <span class="saleprice"> {{ number_format(@$tour->price,0) }} บาท</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5 ps-0">
                                                            <a href="{{url('tour/'.$tour->slug)}}" target="_blank" class="btn-main-og morebtnog">รายละเอียด</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endforeach
                            <div class="display-slide" rel="4">
                                <div class="row">
                                    @foreach ($tour_price as $tp)
                                    @php
                                        $tp_country = \App\Models\Backend\CountryModel::whereIn('id',json_decode(@$tp->country_id,true))->first();
                                        $tp_airline = \App\Models\Backend\TravelTypeModel::find(@$tp->airline_id);
                                        $tp_period_all = \App\Models\Backend\TourPeriodModel::where(['tour_id'=>@$tp->id,'status_display'=>'on'])->whereDate('start_date','>=',now())->whereNull('deleted_at')->orderby('start_date','asc')->get();
                                        $tp_period = $tp_period_all->groupby('group_date');

                                        $allSoldOut = $tp_period_all->every(function ($tp_period_all) {
                                            return $tp_period_all->status_period == 3; // เช็คถ้าทุก Period เป็น sold out
                                        });
                                    @endphp
                                    <div class="col-lg-4 col-xl-3">
                                        <div class="showvertiGroup">
                                            <div class="boxwhiteshd hoverstyle">
                                                <figure>
                                                    <a href="{{url('tour/'.$tp->slug)}}" target="_blank">
                                                        <img src="{{asset($tp->image)}}" alt="">
                                                    </a>
                                                </figure>
                                                @if(@$tp->special_price > 0)
                                                <div class="saleonpicbox">
                                                    <span> ลดราคาพิเศษ</span> <br>
                                                    {{ number_format($tp->special_price,0) }} บาท <br>
                                                    <span>เหลือเริ่ม</span> <br>
                                                    {{ number_format($tp->price - $tp->special_price,0) }}
                                                </div>
                                                @endif
                                                {{-- <div class="tagontop">
                                                    <li class="bgor"><a>{{$tp->num_day}}</a> </li>
                                                    <li class="bgblue"><a><i class="fi fi-rr-marker"></i>
                                                        {{@$tp_country->country_name_th}}</a> </li>
                                                    <li>
                                                        สายการบิน <img src="{{asset(@$tp_airline->image)}}" alt="">
                                                    </li>
                                                </div> --}}
                                                <div class="contenttourshw">
                                                    <div class="codeandhotel">
                                                        <li>รหัสทัวร์ : <span class="bluetext">@if(@$tp->code1_check) {{@$tp->code1}} @else {{@$tp->code}} @endif</span> </li>
                                                        <li class="rating">โรงแรม
                                                            @for($i=1; $i <= @$tp->rating; $i++)
                                                                <i class="bi bi-star-fill"></i>
                                                            @endfor
                                                        </li>

                                                    </div>
                                                    <hr>
                                                    <div class="locationnewd mb-2 mt-2">
                                                        <li> <a> <i class="fi fi-rr-marker"></i> {{@$tp_country->country_name_th}}</a></li>
                                                        <li class="datetour"><a>{{$tp->num_day}}</a> </li>
                                                        <li class="airlines"> 
                                                            สายการบิน <img src="{{asset(@$tp_airline->image)}}" alt=""> 
                                                        </li>
                                                    </div>
                                                    <h3><a href="{{url('tour/'.$tp->slug)}}" target="_blank"> {{$tp->name}}</a></h3>
                                                    <div class="listperiod">
                                                        @foreach($tp_period as $tpe)
                                                        <li><span class="month">{{$month[date('n',strtotime($tpe[0]->start_date))]}}</span>
                                                            @php $toEnd = count($tpe);  @endphp
                                                            @foreach($tpe as $key => $p)
                                                                {{date('d',strtotime($p->start_date))}} - {{date('d',strtotime($p->end_date))}} @if(0 !== --$toEnd)/@endif
                                                            @endforeach
                                                        </li>
                                                        @endforeach
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-lg-7">
                                                            <div class="pricegroup">
                                                                @if($tp->special_price > 0)
                                                                @php $tp_price = $tp->price - $tp->special_price; @endphp
                                                                    <span class="originalprice">ปกติ {{ number_format($tp->price,0) }} </span><br>
                                                                    เริ่ม<span class="saleprice"> {{ number_format(@$tp_price,0) }} บาท</span>
                                                                @else
                                                                    <span class="saleprice"> {{ number_format($tp->price,0) }} บาท</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5 ps-0">
                                                            <a href="{{url('tour/'.$tp->slug)}}" target="_blank" class="btn-main-og morebtnog">รายละเอียด</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
                    <div class="row mt-3 mb-3">
                        <div class="col">
                            <div class="titletopic">
                                <h2>ทัวร์สนใจมากที่สุด</h2>
                            </div>
                        </div>
                    </div>
                    <div class="Cropscroll pb-2">
                        @foreach ($tour_views as $tv)
                        @php
                            $tv_country = \App\Models\Backend\CountryModel::whereIn('id',json_decode(@$tv->country_id,true))->first();
                            $tv_airline = \App\Models\Backend\TravelTypeModel::find(@$tv->airline_id);
                            $tv_period_all = \App\Models\Backend\TourPeriodModel::where(['tour_id'=>@$tv->id,'status_display'=>'on'])->whereDate('start_date','>=',now())->whereNull('deleted_at')->orderby('start_date','asc')->get();
                            $tv_period = $tv_period_all->groupby('group_date');
                            // $tv_period = \App\Models\Backend\TourPeriodModel::where(['tour_id'=>@$tv->id])->whereDate('start_date','>=',now())->whereNull('deleted_at')->orderby('start_date','asc')->get()->groupby('group_date');

                            $allSoldOut = $tv_period_all->every(function ($tv_period_all) {
                                return $tv_period_all->status_period == 3; // เช็คถ้าทุก Period เป็น sold out
                            });
                        @endphp
                        <div class="showhoriMB">
                            <div class="hoverstyle">
                                <div class="row">
                                    <div class="col-5 pe-0">
                                        <div class="imagestourid">
                                            <figure>
                                                <a href="{{url('tour/'.$tv->slug)}}" target="_blank">
                                                    <img src="{{ asset(@$tv->image) }}" class="img-fluid" alt="">
                                                </a>
                                            </figure>
                                            @if(@$tv->special_price > 0)
                                            <div class="saleonpicbox">
                                                <span> ลดพิเศษ</span> <br>
                                                {{ number_format($tv->special_price,0) }} บาท
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-7 ps-2">
                                        <div class="contenttourshw">
                                            <div class="codeandhotel">
                                                <li>รหัสทัวร์ : <span class="bluetext">@if(@$tv->code1_check) {{@$tv->code1}} @else {{@$tv->code}} @endif</span>
                                                </li>
                                            </div>
                                            <hr>
                                            <div class="namemb"><a href="{{url('tour/'.$tv->slug)}}" target="_blank" class="namess"> {{$tv->name}}</a></div>
                                            <div class="listindetail_mb">
                                                <li><a>{{$tv->num_day}}</a></li>
                                                <li>
                                                   <a><img src="{{asset(@$tv_airline->image)}}" alt=""></a>
                                                </li>
                                                <li class="ratingid">
                                                    @for($i=1; $i <= @$tv->rating; $i++)
                                                        <i class="bi bi-star-fill"></i>
                                                    @endfor
                                                </li>
                                            </div>
                                            <hr>
                                            <div class="listperiodmbs3">
                                                @if($tv->special_price > 0)
                                                @php $tv_price = $tv->price - $tv->special_price; @endphp
                                                    <span>เริ่มต้น {{ number_format(@$tv_price,0) }} บาท</span>
                                                @else
                                                    <span>เริ่มต้น {{ number_format($tv->price,0) }} บาท</span>
                                                @endif
                                                {{-- พ.ค. <span>เริ่มต้น 18,900</span>  --}}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <hr>
                    @foreach ($tour_type as $tt)
                    <div class="row mt-3 mb-3">
                        <div class="col">
                            <div class="titletopic">
                                <h2>{{$tt->type_name}}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="Cropscroll pb-2">
                        @php
                            $tours = App\Models\Backend\TourModel::where(['type_id'=>$tt->id,'status'=>'on','deleted_at'=>null])->orderby('price','asc')->limit(4)->get();
                        @endphp
                        @foreach ($tours as $tour)
                        @php
                            $tour_country = \App\Models\Backend\CountryModel::whereIn('id',json_decode(@$tour->country_id,true))->first();
                            $tour_airline = \App\Models\Backend\TravelTypeModel::find(@$tour->airline_id);
                            $tour_period_all = \App\Models\Backend\TourPeriodModel::where(['tour_id'=>@$tour->id,'status_display'=>'on'])->whereDate('start_date','>=',now())->whereNull('deleted_at')->orderby('start_date','asc')->get();
                            $tour_period = $tour_period_all->groupby('group_date');

                            $allSoldOut = $tour_period_all->every(function ($tour_period_all) {
                                return $tour_period_all->status_period == 3; // เช็คถ้าทุก Period เป็น sold out
                            });
                        @endphp
                        <div class="showhoriMB">
                            <div class="hoverstyle">
                                <div class="row">
                                    <div class="col-5 pe-0">
                                        <div class="imagestourid">
                                            <figure>
                                                <a href="{{url('tour/'.$tour->slug)}}" target="_blank">
                                                    <img src="{{ asset(@$tour->image) }}" class="img-fluid" alt="">
                                                </a>
                                            </figure>
                                            <div class="icontaglabll">
                                                <img src="{{asset($tt->image)}}" class="img-fluid" alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-7 ps-2">
                                        <div class="contenttourshw">
                                            <div class="codeandhotel">
                                                <li>รหัสทัวร์ : <span class="bluetext">@if(@$tour->code1_check) {{@$tour->code1}} @else {{@$tour->code}} @endif</span>
                                                </li>
                                            </div>
                                            <hr>
                                            <div class="namemb"><a href="{{url('tour/'.$tour->slug)}}" target="_blank" class="namess"> {{$tour->name}}</a></div>
                                            <div class="listindetail_mb">
                                                <li><a>{{$tour->num_day}}</a></li>
                                                <li> 
                                                    <a><img src="{{asset(@$tour_airline->image)}}" alt=""></a>
                                                </li>
                                                <li class="ratingid">
                                                    @for($i=1; $i <= @$tour->rating; $i++)
                                                        <i class="bi bi-star-fill"></i>
                                                    @endfor
                                                </li>
                                            </div>
                                            <hr>
                                            <div class="listperiodmbs3">
                                                @if($tour->special_price > 0)
                                                @php $t_price = $tour->price - $tour->special_price; @endphp
                                                    <span>เริ่มต้น {{ number_format(@$t_price,0) }} บาท</span>
                                                @else
                                                    <span>เริ่มต้น {{ number_format(@$tour->price,0) }} บาท</span>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <hr>
                    @endforeach
                    <div class="row mt-3 mb-3">
                        <div class="col">
                            <div class="titletopic">
                                <h2>ทัวร์ที่ลดราคา</h2>
                            </div>
                        </div>
                    </div>
                    <div class="Cropscroll pb-2">
                        @foreach ($tour_price as $tp)
                        @php
                            $tp_country = \App\Models\Backend\CountryModel::whereIn('id',json_decode(@$tp->country_id,true))->first();
                            $tp_airline = \App\Models\Backend\TravelTypeModel::find(@$tp->airline_id);
                            $tp_period_all = \App\Models\Backend\TourPeriodModel::where(['tour_id'=>@$tp->id,'status_display'=>'on'])->whereDate('start_date','>=',now())->whereNull('deleted_at')->orderby('start_date','asc')->get();
                            $tp_period = $tp_period_all->groupby('group_date');

                            $allSoldOut = $tp_period_all->every(function ($tp_period_all) {
                                return $tp_period_all->status_period == 3; // เช็คถ้าทุก Period เป็น sold out
                            });
                        @endphp
                        <div class="showhoriMB">
                            <div class="hoverstyle">
                                <div class="row">
                                    <div class="col-5 pe-0">
                                        <div class="imagestourid">
                                            <figure>
                                                <a href="{{url('tour/'.$tp->slug)}}" target="_blank">
                                                    <img src="{{asset($tp->image)}}" class="img-fluid" alt="">
                                                </a>
                                            </figure>
                                            <div class="saleonpicbox">
                                                <span> ลดพิเศษ</span> <br>
                                                {{ number_format($tp->special_price,0) }} บาท
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-7 ps-2">
                                        <div class="contenttourshw">
                                            <div class="codeandhotel">
                                                <li>รหัสทัวร์ : <span class="bluetext">@if(@$tp->code1_check) {{@$tp->code1}} @else {{@$tp->code}} @endif</span>
                                                </li>
                                            </div>
                                            <hr>
                                            <div class="namemb"><a href="{{url('tour/'.$tp->slug)}}" target="_blank" class="namess"> {{$tp->name}}</a></div>
                                            <div class="listindetail_mb">
                                                <li><a>{{$tp->num_day}}</a></li>
                                                <li> 
                                                    <a><img src="{{asset(@$tp_airline->image)}}" alt=""></a>
                                                </li>
                                                <li class="ratingid">
                                                    @for($i=1; $i <= @$tp->rating; $i++)
                                                        <i class="bi bi-star-fill"></i>
                                                    @endfor
                                                </li>
                                            </div>
                                            <hr>
                                            <div class="listperiodmbs3">
                                                @if($tp->special_price > 0)
                                                @php $tp_price = $tp->price - $tp->special_price; @endphp
                                                    <span>เริ่มต้น {{ number_format(@$tp_price,0) }} บาท</span>
                                                @else
                                                    <span>เริ่มต้น {{ number_format($tp->price,0) }} บาท</span>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <hr>
                </div>
            </section>
            {{-- <section class="weekend">
                <div class="row mt-5 mb-4">
                    <div class="col">
                        <div class="titletopic text-center">
                            <h2>ทัวร์แนะนำตามช่วงวันหยุด</h2>
                        </div>
                    </div>
                </div>
                @php $calendar = \App\Models\Backend\CalendarModel::whereDate('end_date','>=',date('Y-m-d'))->where(['status'=>'on','deleted_at'=>null])->orderBy('start_date','asc')->get(); @endphp   
                <div class="row">
                    <div class="col">
                        <div class="promotionslide owl-theme owl-carousel" id="calendarslide">
                            @foreach($calendar as $ca)
                            @php
                                $count_calendar = 0;
                                $period_calendar = \App\Models\Backend\TourPeriodModel::leftjoin('tb_tour','tb_tour_period.tour_id','=','tb_tour.id')
                                    ->whereDate('tb_tour_period.start_date','>=',$ca->start_date)
                                    ->whereDate('tb_tour_period.start_date','<=',$ca->end_date)
                                    ->where('tb_tour.status','on')
                                    ->where('tb_tour_period.status_display','on')
                                    ->select('tb_tour.status','tb_tour_period.start_date','tb_tour_period.status_display','tb_tour_period.tour_id')
                                    ->orderby('tb_tour_period.start_date','asc')
                                    ->get()
                                    ->groupBy('tour_id');
                                    $count_calendar = $count_calendar + count($period_calendar);
                                    // dd($period);
                                
                            @endphp
                            @if($count_calendar > 0)
                                <div class="hoverstyle weekendbox">
                                    <figure>
                                        <a href="{{url('weekend-landing/'.$ca->id)}}"><img src="{{asset($ca->img_cover)}}" class="img-fluid" alt=""></a>
                                    </figure>
                                    <a href="{{url('weekend-landing/'.$ca->id)}}">
                                        <div class="weekendcaption">
                                            <span>ทัวร์วันหยุดยาวของไทย</span>
                                            <h3>ทัวร์{{$ca->holiday}}</h3>
                                            <div class="qtyweek">{{ $count_calendar}} โปรแกรมทัวร์</div>
                                        </div>
                                    </a>
                                </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </section> --}}
            <div class="row mt-5 mb-3">
                <div class="col">
                    <center><a href="{{url('search-tour')}}" class="btn btn-submit">ดูทัวร์ทั้งหมด</a></center>
                </div>
            </div>
            <section class="reviewhome">
                <div class="row mt-5 mb-4">
                    <div class="col">
                        <div class="titletopic text-center">
                            <h2>ผลงานจัดทัวร์คุณภาพ บางส่วน จากลูกค้าที่ให้ความไว้วางใจจากเรา</h2>
                        </div>
                    </div>
                </div>
                <!-- pc -->
                <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                    <div class="row mt-5">
                        @if(isset($review[0]))
                        <?php $coun1 = App\Models\Backend\CountryModel::whereIn('id',json_decode($review[0]->country_id,true))->get();?>
                        <div class="col-lg-6">
                            <div class="clindex">
                                <div class="hoverstyle">
                                    <figure>
                                        <a href="{{url('clients-review/0/0')}}"><img src="{{asset($review[0]->img)}} " class="img-fluid" alt=""></a>
                                    </figure>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="clssgroup hoverstyle">
                                <h3>{{$review[0]->title}}</h3>
                                <p>{!! $review[0]->detail !!}</p>
                                <div class="tagcat02 mt-3">
                                    @foreach ($coun1 as $c)
                                    <li>
                                        <a href="{{url('clients-review/'.$c->id.'/0')}}">#{{$c->country_name_th}}</a> 
                                    </li>
                                    @endforeach
                                </div>
                                <hr>
                                <div class="groupshowname">
                                    <div class="clleft">
                                        <div class="clientpic">
                                            <img src="{{asset($review[0]->profile)}}" alt="">
                                        </div>
                                    </div>
                                    <div class="clientname">
                                        <span class="orgtext">{{$review[0]->name}}</span>
                                        <br>
                                        ทริป{{$review[0]->trip}}</div>
                                </div>
                            </div>
                            @endif
                            @if(isset($review[1]))
                            <?php  $coun2 = App\Models\Backend\CountryModel::whereIn('id',json_decode($review[1]->country_id,true))->get(); ?>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="hoverstyle">
                                        <figure>
                                            <a href="{{url('clients-review/0/0')}}"><img src="{{asset($review[1]->img)}}" class="img-fluid" alt=""></a>
                                        </figure>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="clssgroup hoverstyle">
                                        <h3>{{$review[1]->title}}</h3>
                                        <p>{!! $review[1]->detail !!}</p>
                                        <div class="tagcat02 mt-3">
                                            @foreach ($coun2 as $c)
                                                <li>
                                                    <a href="{{url('clients-review/'.$c->id.'/0')}}">#{{$c->country_name_th}}</a> 
                                                </li>
                                            @endforeach
                                        </div>
                                        <hr>
                                        <div class="groupshowname">
                                            <div class="clleft">
                                                <div class="clientpic">
                                                    <img src="{{asset($review[1]->profile)}}" alt="">
                                                </div>
                                            </div>
                                            <div class="clientname">
                                                <span class="orgtext">{{$review[1]->name}}</span>
                                                <br>
                                                ทริป{{$review[1]->trip}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-6">
                            <div class="row">
                                @if(isset($review[2]))
                                <?php  $coun3 = App\Models\Backend\CountryModel::whereIn('id',json_decode($review[2]->country_id,true))->get();  ?>
                                <div class="col-lg-6">
                                    <div class="clssgroup hoverstyle">
                                        <h3>{{$review[2]->title}}</h3>
                                        <p>{!! $review[2]->detail !!}</p>

                                        <div class="tagcat02 mt-3">
                                            @foreach ($coun3 as $c)
                                                <li>
                                                    <a href="{{url('clients-review/'.$c->id.'/0')}}">#{{$c->country_name_th}}</a> 
                                                </li>
                                            @endforeach
                                        </div>
                                        <hr>
                                        <div class="groupshowname">
                                            <div class="clleft">
                                                <div class="clientpic">
                                                    <img src="{{asset($review[2]->profile)}}" alt="">
                                                </div>
                                            </div>
                                            <div class="clientname">
                                                <span class="orgtext">{{$review[2]->name}}</span>
                                                <br>
                                                ทริป{{$review[2]->trip}}</div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-lg-6">
                                    <div class="clindex">
                                        <div class="hoverstyle">
                                            <figure>
                                                <a href="{{url('clients-review/0/0')}}"><img src="{{asset($review[2]->img)}}" class="img-fluid"
                                                        alt=""></a>
                                            </figure>
                                        </div>
                                    </div>
                                    @endif
                                    @if(isset($review[3]))
                                    <?php  $coun4 = App\Models\Backend\CountryModel::whereIn('id',json_decode($review[3]->country_id,true))->get(); ?>
                                    <div class="clssgroup hoverstyle">
                                        <h3>{{$review[3]->title}}</h3>
                                        <p>{!! $review[3]->detail !!}</p>
                                        <div class="tagcat02 mt-3">
                                            @foreach ($coun4 as $c)
                                                <li>
                                                    <a href="{{url('clients-review/'.$c->id.'/0')}}">#{{$c->country_name_th}}</a> 
                                                </li>
                                            @endforeach
                                        </div>
                                        <hr>
                                        <div class="groupshowname">
                                            <div class="clleft">
                                                <div class="clientpic">
                                                    <img src="{{asset($review[3]->profile)}}" alt="">
                                                </div>
                                            </div>
                                            <div class="clientname">
                                                <span class="orgtext">{{$review[3]->name}}</span>
                                                <br>
                                                ทริป{{$review[3]->trip}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="clindex">
                                <div class="hoverstyle">
                                    <figure>
                                        <a href="{{url('clients-review/0/0')}}"><img src="{{asset($review[3]->img)}}" class="img-fluid" alt=""></a>
                                    </figure>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="row mt-4">
                        @if(isset($review[4]))
                        <?php   $coun5 = App\Models\Backend\CountryModel::whereIn('id',json_decode($review[4]->country_id,true))->get();?>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="clssgroup hoverstyle">
                                        <h3>{{$review[4]->title}}</h3>
                                        <p>{!! $review[4]->detail !!}</p>

                                        <div class="tagcat02 mt-3">
                                            @foreach ($coun5 as $c)
                                                <li>
                                                    <a href="{{url('clients-review/'.$c->id.'/0')}}">#{{$c->country_name_th}}</a> 
                                                </li>
                                            @endforeach
                                        </div>
                                        <hr>
                                        <div class="groupshowname">
                                            <div class="clleft">
                                                <div class="clientpic">
                                                    <img src="{{asset($review[4]->profile)}}" alt="">
                                                </div>
                                            </div>
                                            <div class="clientname">
                                                <span class="orgtext">{{$review[4]->name}}</span>
                                                <br>
                                                ทริป{{$review[4]->trip}}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="clindex">
                                        <div class="hoverstyle">
                                            <figure>
                                                <a href="0"><img src="{{asset($review[4]->img)}}" class="img-fluid"
                                                        alt=""></a>
                                            </figure>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @if(isset($review[5]))
                        <?php  $coun6 = App\Models\Backend\CountryModel::whereIn('id',json_decode($review[5]->country_id,true))->get();   ?>
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6">

                                    <div class="clindex">
                                        <div class="hoverstyle">
                                            <figure>
                                                <a href="{{url('clients-review/0/0')}}"><img src="{{asset($review[5]->img)}}" class="img-fluid"
                                                        alt=""></a>
                                            </figure>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="clssgroup hoverstyle">
                                        <h3>{{$review[5]->title}}</h3>
                                        <p>{!! $review[5]->detail !!}</p>

                                        <div class="tagcat02 mt-3">
                                            @foreach ($coun6 as $c)
                                                <li>
                                                    <a href="{{url('clients-review/'.$c->id.'/0')}}">#{{$c->country_name_th}}</a> 
                                                </li>
                                            @endforeach
                                        </div>
                                        <hr>
                                        <div class="groupshowname">
                                            <div class="clleft">
                                                <div class="clientpic">
                                                    <img src="{{asset($review[5]->profile)}}" alt="">
                                                </div>
                                            </div>
                                            <div class="clientname">
                                                <span class="orgtext">{{$review[5]->name}}</span>
                                                <br>
                                                ทริป{{$review[5]->trip}}</div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                <!-- mb -->
                <div class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
                    <div class="row">
                        @foreach($review as $re)
                        <?php $coun_mb = App\Models\Backend\CountryModel::whereIn('id',json_decode($re->country_id,true))->get();?>
                        <div class="col-6">
                            <div class="clindex">
                                <div class="hoverstyle">
                                    <figure>
                                        <a href="{{url('clients-review/0/0')}}"><img src="{{asset($re->img)}}" class="img-fluid" alt=""></a>
                                    </figure>
                                </div>
                            </div>
                            <div class="clssgroup hoverstyle">
                                <h3>{{$re->title}}</h3>
                                <p>{!! $re->detail !!}</p>

                                <div class="tagcat02 mt-3">
                                    @foreach ($coun_mb as $c)
                                    <li>
                                        <a href="{{url('clients-review/'.$c->id.'/0')}}">#{{$c->country_name_th}}</a> 
                                    </li>
                                    @endforeach
                                </div>
                                <hr>
                                <div class="groupshowname">
                                    <div class="clleft">
                                        <div class="clientpic">
                                            <img src="{{asset($re->profile)}}" alt="">
                                        </div>
                                    </div>
                                    <div class="clientname">
                                        <span class="orgtext">{{$re->name}}</span>
                                        <br>
                                        ทริป{{$re->trip}}</div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="row mt-5 mb-3">
                    <div class="col">
                        <center> <a href="{{url('clients-review/0/0')}}" class="btn btn-submit">ดูรีวิวทั้งหมด</a></center>

                    </div>
                </div>

            </section>
            <section class="logoclients">
                <div class="row mt-5 mb-4">
                    <div class="col">
                        <div class="titletopic text-center">
                            <h2>ลูกค้าที่ไว้วางใจเรา Next Trip Holiday</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="clientslide owl-carousel owl-theme">
                            @foreach($customer as $cus)
                            <div class="item">
                                <div class="clientbordd hoverstyle">
                                    <figure>
                                        <a href="{{url('clients-detail/'.$cus->id)}}"><img src="{{asset($cus->logo)}}" class="img-fluid" alt=""></a>
                                    </figure>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <section class="whyus mt-5 " style=" background-image: url({{$footer->img}});">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 offset-lg-6">
                        <div class="whycontent">
                            {!! $footer->title !!}
                            <div class="row mt-4">
                                @foreach ($footer_list as $f)
                                <div class="col-6 col-lg-6 mt-3 mb-3">
                                    <div class="ic">
                                        <img src="{{asset($f->img)}}" alt="">
                                    </div>
                                    <h4>{{$f->title}}</h4>
                                    <p>{{$f->detail}}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
    @include("frontend.layout.inc_footer")
    
    <?php 
        echo '<script>';
        echo "var country = $data_country;";
        echo "var city = $data_city;";
        echo "var country_famus = $country_famus;";
        echo "var keyword_famus = $keyword_famus;";
        echo "var province = $data_province;";
        echo "var amupur = $data_amupur;";
        echo '</script>';
    ?>
    @include("frontend.layout.search-data")
    <script>
        var day = ['วันอาทิตย์','วันจันทร์','วันอังคาร','วันพุธ','วันพฤหัสบดี','วันศุกร์','วันเสาร์'];
        var month = ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
        var check_after = new Date();
        var check_befor = new Date(check_after.valueOf()+86400000);
        // let test = day[check_after.getDay()]+'ที่ '+check_after.getDate()+' '+month[check_after.getMonth()]+' '+(check_after.getFullYear()*1+543)+' | '+day[check_befor.getDay()]+'ที่ '+check_befor.getDate()+' '+month[check_befor.getMonth()]+' '+(check_befor.getFullYear()*1+543);
        // document.getElementById('show_date_select').value = test;
        var strat_show = check_after.getDate()+'  '+month[check_after.getMonth()]+'  '+(check_after.getFullYear()*1+543);
        var start_day_show = day[check_after.getDay()];
        var end_show = check_befor.getDate()+'  '+month[check_befor.getMonth()]+'  '+(check_befor.getFullYear()*1+543);
        var end_day_show = day[check_befor.getDay()];
        var text_s_show = '';
            text_s_show += "<span style='color:gray'>"+strat_show+"</span><br>";
            text_s_show += "<span style='font-size:0.8rem;padding:3px 2px;display:block;color:gray;'>"+start_day_show+"</span>";
        var text_e_show = '';
            text_e_show += "<span style='color:gray'>"+end_show+"</span><br>";
            text_e_show += "<span style='font-size:0.8rem;padding:3px 2px;display:block;color:gray;'>"+end_day_show+"</span>";
    
        document.getElementById('show_date_calen').innerHTML = text_s_show;
        document.getElementById('show_end_calen').innerHTML = text_e_show;
        $('#hide_date_select').hide();
    
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left',
                minDate: "{{date('m/d/Y')}}"
            }, function(start, end, label) {
                document.getElementById('start_date').value = start.format('YYYY-MM-DD');
                document.getElementById('end_date').value = end.format('YYYY-MM-DD');
                let y = new Date(start);
                let x = new Date(end);
                let s_show = y.getDate()+'  '+month[y.getMonth()]+'  '+(y.getFullYear()*1+543);
                let e_show = x.getDate()+'  '+month[x.getMonth()]+'  '+(x.getFullYear()*1+543);
                let s_day = day[y.getDay()];
                let e_day = day[x.getDay()];
                // document.getElementById('show_date_select').value = test;
                var text_start = '';
                    text_start += s_show+"<br>";
                    text_start += "<span style='font-size:0.8rem;padding:3px 2px;display:block;'>"+s_day+"</span>";
                var text_end = '';
                    text_end += e_show+"<br>";
                    text_end += "<span style='font-size:0.8rem;padding:3px 2px;display:block;'>"+e_day+"</span>";
    
                document.getElementById('show_date_calen').innerHTML = text_start;
                document.getElementById('show_end_calen').innerHTML = text_end;
    
                $('#show_date_calen').show();
                $('#show_end_calen').show();
                $('#hide_date_select').hide();
            });
            $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
                document.getElementById('start_date').value = null;
                document.getElementById('end_date').value = null;
    
                let y = new Date("{{date('m/d/Y')}}");
                let x = new Date("{{date('m/d/Y',strtotime('+1 day'))}}");
                let s_show = y.getDate()+'  '+month[y.getMonth()]+'  '+(y.getFullYear()*1+543);
                let e_show = x.getDate()+'  '+month[x.getMonth()]+'  '+(x.getFullYear()*1+543);
                let s_day = day[y.getDay()];
                let e_day = day[x.getDay()];
                
                var text_start1 = '';
                    text_start1 += "<span style='color:gray'>"+s_show+"</span<br>";
                    text_start1 += "<span style='font-size:0.8rem;padding:3px 2px;display:block;color:gray;'>"+s_day+"</span>";
                var text_end2 = '';
                    text_end2 += "<span style='color:gray'>"+e_show+"<br>";
                    text_end2 += "<span style='font-size:0.8rem;padding:3px 2px;display:block;color:gray;'>"+e_day+"</span</span>";
                document.getElementById('show_date_calen').innerHTML = text_start1;
                document.getElementById('show_end_calen').innerHTML = text_end2;
    
                $('#show_date_calen').show();
                $('#show_end_calen').show();
                $('#hide_date_select').hide();
                
            });
            $('input[name="daterange"]').on('hide.daterangepicker', function(ev, picker) {
                $('#show_date_calen').show();
                $('#show_end_calen').show();
                $('#hide_date_select').hide();
            });
        });
        function show_datepicker() {
            $('#show_date_calen').hide();
            $('#show_end_calen').hide();
            $('#hide_date_select').show();
            document.getElementById("hide_date_select").click();
        }
        
    </script>
    <script>
        $(document).ready(function () {
            var time_ads = "{{$status->time_ads}}"*Number(1000);
            var time_slide = "{{$status->time_slide}}"*Number(1000);
            var status_ads = false ;
            var status_slide = false ;
            var time_calendar = "{{$status->time_calendar}}"*Number(1000);
            var time_cus = "{{$status->time_cus}}"*Number(1000);
            var status_calendar = false ;
            var status_cus = false ;
            if("{{$status->status_ads}}" == 'on'){
                status_ads = true;
            }
            if("{{$status->status_slide}}" == 'on'){
                status_slide  = true;
            }
            if("{{$status->status_calendar}}" == 'on'){
                status_calendar = true;
            }
            if("{{$status->status_cus}}" == 'on'){
                status_cus  = true;
            }
            $('.bannerhomepage').owlCarousel({
                loop: true,
                item: 1,
                nav: true,
                navText: ['<img src="{{asset('frontend/images/arBn_left.svg')}}">', '<img src="{{asset('frontend/images/arBn_right.svg')}}">'],
                navClass: ['owl-prev', 'owl-next'],
                slideBy: 1,
                autoplay: status_slide,
                animateOut: 'fadeOut',
                // autoplayTimeout: 4000,
                autoplayTimeout: time_slide,
                autoplayHoverPause: true,
                smartSpeed: time_slide,
                dots: false,
                responsive: {
                    0: {
                        items: 1,


                    },
                    600: {
                        items: 1,
                        slideBy: 1,
                        nav: false,

                    },
                    1024: {
                        items: 1,
                        slideBy: 1
                    },
                    1200: {
                        items: 1,
                        slideBy: 1
                    }
                }
            })
            $('#promotionslide').owlCarousel({
                loop: true,
                autoplay:status_ads,
                smartSpeed: time_ads,
                nav: true,
                navText: ['<img src="{{asset('frontend/images/arrowRight.svg')}}">', '<img src="{{asset('frontend/images/arrowLeft.svg')}}">'],
                navClass: ['owl-prev', 'owl-next'],
                dots: true,
                margin: 10,
                responsive: {
                    0: {
                        items: 2,


                    },
                    600: {
                        items: 2,
                        slideBy: 1,
                        nav: false,

                    },
                    1024: {
                        items: 2,
                        slideBy: 1
                    },
                    1200: {
                        items: 3,
                        slideBy: 1
                    }
                }
            })
            $('#calendarslide').owlCarousel({
                loop: true,
                autoplay:status_calendar,
                smartSpeed: time_calendar,
                nav: true,
                navText: ['<img src="{{asset('frontend/images/arrowRight.svg')}}">', '<img src="{{asset('frontend/images/arrowLeft.svg')}}">'],
                navClass: ['owl-prev', 'owl-next'],
                dots: true,
                margin: 10,
                responsive: {
                    0: {
                        items: 2,


                    },
                    600: {
                        items: 2,
                        slideBy: 1,
                        nav: false,

                    },
                    1024: {
                        items: 2,
                        slideBy: 1
                    },
                    1200: {
                        items: 3,
                        slideBy: 1
                    }
                }
            })
            $('.countryslider').owlCarousel({
                loop: true,
                autoplay: false,
                smartSpeed: 2000,
                nav: true,
                navText: ['<img src="{{asset('frontend/images/arrowRight.svg')}}">', '<img src="{{asset('frontend/images/arrowLeft.svg')}}">'],
                navClass: ['owl-prev', 'owl-next'],
                dots: true,
                margin: 10,
                responsive: {
                    0: {
                        items: 2,


                    },
                    600: {
                        items: 2,
                        slideBy: 1,
                        nav: false,

                    },
                    1024: {
                        items: 2,
                        slideBy: 1
                    },
                    1200: {
                        items: 3,
                        slideBy: 1
                    }
                }
            })
            $('.clientslide').owlCarousel({
                loop: true,
                autoplay: status_cus,
                smartSpeed: time_cus,
                dots: true,
                nav: true,
                navText: ['<img src="{{asset('frontend/images/arrowRight.svg')}}">', '<img src="{{asset('frontend/images/arrowLeft.svg')}}">'],
                navClass: ['owl-prev', 'owl-next'],
                margin: 10,
                responsive: {
                    0: {
                        items: 2,


                    },
                    600: {
                        items: 2,
                        slideBy: 1,
                        nav: false,

                    },
                    1024: {
                        items: 4,
                        slideBy: 1
                    },
                    1200: {
                        items: 5,
                        slideBy: 1
                    }
                }
            })

        });

        var owl = $('.screenshot_slider').owlCarousel({
            loop: true,
            responsiveClass: true,
            nav: true,
            margin: 0,
            autoplayTimeout: 4000,
            smartSpeed: 400,
            center: true,
            navText: ['&#8592;', '&#8594;'],
            responsive: {
                0: {
                    items: 1,
                },
                600: {
                    items: 5
                },
                1200: {
                    items: 5
                }
            }
        });

        /****************************/

        jQuery(document.documentElement).keydown(function (event) {

            // var owl = jQuery("#carousel");

            // handle cursor keys
            if (event.keyCode == 37) {
                // go left
                owl.trigger('prev.owl.carousel', [400]);
                //owl.trigger('owl.prev');
            } else if (event.keyCode == 39) {
                // go right
                owl.trigger('next.owl.carousel', [400]);
                //owl.trigger('owl.next');
            }

        });
    </script>
    <script>
        $(document).ready(function () {

            var weekday = new Array(7);
            weekday[0] = "อาทิตย์";
            weekday[1] = "จันทร์";
            weekday[2] = "อังคาร";
            weekday[3] = "พุธ";
            weekday[4] = "พฤหัสบดี";
            weekday[5] = "ศุกร์";
            weekday[6] = "เสาร์";

            $(function () {
                $('.datepicker').datepicker({
                    setDate: new Date(),
                    dateFormat: 'dd MM yy',
                    showButtonPanel: false,
                    changeMonth: false,
                    changeYear: false,
                    /*showOn: "button",
                     buttonImage: "images/calendar.gif",
                     buttonImageOnly: true,
                     minDate: '+1D',
                     maxDate: '+3M',*/
                    inline: true,
                    onSelect: function (dateText, inst) {
                        var date = $(this).datepicker('getDate');
                        var dayOfWeek = weekday[date.getUTCDay()];
                        // dayOfWeek is then a string containing the day of the week
                        if ($(this).parent().find(".dp_dayOfWeek")) {
                            $(this).parent().find(".dp_dayOfWeek").remove();
                        }
                        $(this).parent().append("<span class='dp_dayOfWeek'>" + dayOfWeek +
                            "</span>");
                    },
                });

                var lastDate = new Date();
                lastDate.setDate(lastDate.getDate()); //any date you want
                $("input[name='date_start']").datepicker('setDate', lastDate);

                var dayOfWeek = weekday[lastDate.getUTCDay()];
                // dayOfWeek is then a string containing the day of the week
                if ($("input[name='date_start']").parent().find(".dp_dayOfWeek")) {
                    $("input[name='date_start']").parent().find(".dp_dayOfWeek").remove();
                }
                $("input[name='date_start']").parent().append("<span class='dp_dayOfWeek'>" +
                    dayOfWeek + "</span>");

                lastDate.setDate(lastDate.getDate() + 1); //any date you want
                $("input[name='date_end']").datepicker('setDate', lastDate);
                var dayOfWeek = weekday[lastDate.getUTCDay()];
                // dayOfWeek is then a string containing the day of the week
                if ($("input[name='date_end']").parent().find(".dp_dayOfWeek")) {
                    $("input[name='date_end']").parent().find(".dp_dayOfWeek").remove();
                }
                $("input[name='date_end']").parent().append("<span class='dp_dayOfWeek'>" + dayOfWeek +
                    "</span>");

            });
            $.datepicker.regional['es'] = {
                closeText: 'Cerrar',
                prevText: '<Ant',
                nextText: 'Sig>',
                currentText: 'Hoy',
                monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม',
                    'สิงหาคม',
                    'กันยายน', 'ตุลาคม', 'พฤษจิกายน', 'ธันวาคม'
                ],
                monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct',
                    'Nov', 'Dec'
                ],
                dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Sathurday'],
                dayNamesShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thr', 'Fri', 'Sat'],
                dayNamesMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                weekHeader: 'Sm',
                dateFormat: 'dd/mm/yy',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''
            };
            $.datepicker.setDefaults($.datepicker.regional['es']);
        });
    </script>
   
    <script>
        $("#carousel").flipster({
            style: 'flat',
            spacing: -0.4,
            nav: true,
            buttons: true,
        });
    </script>


</body>

</html>