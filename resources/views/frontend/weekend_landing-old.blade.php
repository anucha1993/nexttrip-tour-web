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
                    <li><a href="#">
                            <img src="{{asset('frontend/images/line_share.svg')}}" alt="">
                        </a></li>
                    <li><a href="#">
                            <img src="{{asset('frontend/images/facebook_share.svg')}}" alt="">
                        </a></li>
                    <li><a href="#">
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
                            $country[] = App\Models\Backend\CountryModel::where('id',$re)->get(); 
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
                                            <a href="{{url('weekend-landing/'.$id.'/'.$c->id)}}"><img src="{{asset($c->img_icon)}}" alt=""></a>
                                        </div>
                                        <a href="{{url('weekend-landing/'.$id.'/'.$c->id)}}"> ทัวร์{{$c->country_name_th}}{{@$data->holiday}}</a> <br>
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
                            
                            @if($pre['tour'])
                                <div class="item">
                                    <div class="showvertiGroup">
                                        <div class="boxwhiteshd hoverstyle">
                                            <figure>
                                                <a href="{{url('tour/'.$pre['tour']->slug)}}">
                                                    <img src="{{asset($pre['tour']->image)}}" alt="">
                                                </a>
                                            </figure>
                                           
                                            <div class="tagontop">
                                                <li class="bgor"><a href="{{url('tour/'.$pre['tour']->slug)}}">{{$pre['tour']->num_day}}</a> </li>
                                                <li class="bgblue"><a href="{{url('tour/'.$pre['tour']->slug)}}"><i class="fi fi-rr-marker"></i>
                                                        ทัวร์ @foreach($country_re as $coun) {{$coun->country_name_th}} @endforeach</a> </li>
                                                <li>สายการบิน <a href="{{url('tour/'.$pre['tour']->slug)}}"> <img src="{{asset(@$airline_re->image)}}" alt=""></a>
                                                </li>
                                            </div>
                                            <div class="contenttourshw">
                                                <div class="codeandhotel">
                                                    <li>รหัสทัวร์ : <span class="bluetext">@if(@$pre['tour']->code1_check) {{@$pre['tour']->code1}} @else {{@$pre['tour']->code}} @endif</span> </li>
                                                    <li class="rating">โรงแรม<a href="{{url('tour/'.$pre['tour']->slug)}}">
                                                        @for($i=1; $i <= @$pre['tour']->rating; $i++)
                                                            <i class="bi bi-star-fill"></i>
                                                        @endfor
                                                        </a>
                                                    </li>

                                                </div>
                                                <hr>
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
                            @include("frontend.layout.inc_sidefilter")
                        </div>
                        <div class="col-5 ps-0">
                            <div class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
                                <select class="form-select" aria-label="Default select example">
                                    <option selected>เรียงตาม </option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
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
                <div class="col-lg-8 col-xl-9">
                    <div class="row mt-3 mt-lg-0">
                        <div class="col-12 col-lg-7 col-xl-8">
                            <div class="titletopic">
                                <h1>ทัวร์{{@$data->holiday}}</h1>
                                <p>พบ {{count($period)}} รายการ</p>
                            </div>
                        </div>
                        <div class="col-lg-5 col-xl-4 text-end">
                            <div class="row">
                                <div class="col-lg-8 col-xl-8">
                                    <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                                        <select class="form-select" aria-label="Default select example">
                                            <option selected>เรียงตาม </option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
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
                                    <div class="col">
                                    @foreach($period as $pre)
                                        <?php 
                                            $country = App\Models\Backend\CountryModel::whereIn('id',json_decode($pre['tour']->country_id,true))->get();
                                            // $city = App\Models\Backend\CityModel::whereIn('id',json_decode($pre['tour']->city_id,true))->get();
                                            // $province = App\Models\Backend\ProvinceModel::whereIn('id',json_decode($pre['tour']->province_id,true))->get();
                                            // $district = App\Models\Backend\DistrictModel::whereIn('id',json_decode($pre['tour']->district_id,true))->get();
                                            $airline = \App\Models\Backend\TravelTypeModel::find($pre['tour']->airline_id);
                                            $type = \App\Models\Backend\TourTypeModel::find(@$pre['tour']->type_id);
                                        
                                        ?>
                                        @if($pre['tour'])
                                            <div class="boxwhiteshd">
                                                <div class="toursmainshowGroup  hoverstyle">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-xl-4 pe-0">
                                                            <div class="covertourimg">
                                                                <figure>
                                                                    <a href="{{url('tour/'.$pre['tour']->slug)}}"><img
                                                                            src="{{ asset(@$pre['tour']->image) }}" alt=""></a>
                                                                </figure>
                                                                <div
                                                                    class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
                                                                    <a href="{{url('tour/'.$pre['tour']->slug)}}" class="tagicbest"><img
                                                                            src="{{asset(@$type->image)}}"
                                                                            class="img-fluid" alt=""></a>
                                                                </div>
                                                                @if($pre['tour']->special_price)
                                                                    <div class="saleonpicbox">
                                                                         <span> ลดราคาพิเศษ</span> <br>
                                                                        {{number_format($pre['tour']->special_price,0)}} บาท  
                                                                    </div>
                                                                @endif
                                                                <div class="tagontop">
                                                                    <li class="bgor"><a href="{{url('tour/'.$pre['tour']->slug)}}">{{$pre['tour']->num_day}}</a> </li>
                                                                    <li class="bgwhite"><a href="{{url('tour/'.$pre['tour']->slug)}}"><i
                                                                                class="fi fi-rr-marker"></i>
                                                                            ทัวร์ @foreach ($country as $coun) {{$coun->country_name_th}} @endforeach</a></li>
                                                                </div>
                                                                {{-- <div class="pricegroup">
                                                                    @if($pre['tour']->special_price)
                                                                    @php $price = $pre['tour']->price - $pre['tour']->special_price; @endphp
                                                                        <span class="originalprice">ปกติ {{ number_format($pre['tour']->price,0) }} </span><br>
                                                                        เริ่ม<span class="saleprice"> {{ number_format(@$price,0) }} บาท</span>
                                                                    @else
                                                                        <span class="saleprice"> {{ number_format($pre['tour']->price,0) }} บาท</span>
                                                                    @endif
                                                                </div> --}}
                                                                <div class="addwishlist">
                                                                    <a href="javascript:void(0);"><i class="bi bi-heart-fill" id="likeButton" onclick="likedTour({{@$pre['tour']->id}})"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 col-xl-8">
                                                            <div class="codeandhotel Cropscroll mt-1">
                                                                <li>รหัสทัวร์ : <span class="bluetext">@if(@$pre['tour']->code1_check) {{@$pre['tour']->code1}} @else {{@$pre['tour']->code}} @endif</span> </li>
                                                                <li class="rating">โรงแรม <a href="{{url('tour/'.$pre['tour']->slug)}}">
                                                                    @for($i=1; $i <= $pre['tour']->rating; $i++)
                                                                        <i class="bi bi-star-fill"></i>
                                                                    @endfor
                                                                    </a>
                                                                </li>
                                                                <li><a href="{{url('tour/'.$pre['tour']->slug)}}">สายการบิน <img
                                                                            src="{{asset(@$airline->image)}}" alt=""></a>
                                                                </li>
                                                                <li>
                                                                    <div
                                                                        class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                                                                        <a href="{{url('tour/'.$pre['tour']->slug)}}" class="tagicbest"><img
                                                                                src="{{asset(@$type->image)}}"
                                                                                class="img-fluid" alt=""></a>
                                                                    </div>
                                                                </li>
                                                            </div>

                                                            <div class="nameTop">
                                                                <h3> <a href="{{url('tour/'.$pre['tour']->slug)}}">{{ $pre['tour']->name }} </a>
                                                                </h3>
                                                            </div>
                                                            <div class="pricegroup text-end">
                                                                @if($pre['tour']->special_price)
                                                                @php $price = $pre['tour']->price - $pre['tour']->special_price; @endphp
                                                                    <span class="originalprice">ปกติ {{ number_format($pre['tour']->price,0) }} </span><br>
                                                                    เริ่ม<span class="saleprice"> {{ number_format(@$price,0) }} บาท</span>
                                                                @else
                                                                    เริ่ม<span class="saleprice"> {{ number_format($pre['tour']->price,0) }} บาท</span>
                                                                @endif
                                                            </div>
                                                            <div class="highlighttag">
                                                                <span><i class="fi fi-rr-tags"></i> </span> {{ @$pre['tour']->description }}
                                                            </div>
                                                            <div class="hilight mt-2">
                                                                <div class="readMore">
                                                                    <div class="readMoreWrapper">
                                                                        <div class="readMoreText2">
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
                                                        </div>
                                                    </div>
                                                    <div class="periodtime">
                                                        <div class="readMore">
                                                            <div class="readMoreWrapper">
                                                                <div class="readMoreText">
                                                                    <div class="listperiod_moredetails">
                                                                        {{-- @foreach ($pre['period'] as $p) --}}
                                                                            <div class="tagmonth">
                                                                                <span class="month">{{$month[date('n',strtotime($pre['period'][0]->start_date))]}}</span>
                                                                            </div>
                                                                            <div class="splgroup">
                                                                                @foreach ($pre['period'] as $p)
                                                                                @php
                                                                                   
                                                                                    $calen_start = strtotime($data->start_date);
                                                                                    $calen_end = strtotime($data->end_date);
                                                                                    $calendar = ceil(($calen_end - $calen_start)/86400);
                                                                                    $arrayDate = array();
                                                                                    $arrayDate[] = date('Y-m-d',$calen_start); 
                                                                                    for($x = 1; $x < $calendar; $x++){
                                                                                        $arrayDate[] = date('Y-m-d',($calen_start+(86400*$x)));
                                                                                    }
                                                                                   
                                                                                    $arrayDate[] = date('Y-m-d',$calen_end); // ช่วงวันหยุดของปฏิทิน

                                                                                    $sum_end = strtotime($p->end_date);
                                                                                    $sum_start = strtotime($p->start_date);
                                                                                    $arr = array();
                                                                                    $arr[] = date('Y-m-d',$sum_start); 
                                                                                    $sum_day = ceil(($sum_end - $sum_start)/86400) ;

                                                                                    if(in_array($p->start_date,$arrayDate)){
                                                                                        for($i = 1; $i < $sum_day; $i++){
                                                                                            $arr[] = date('Y-m-d',($sum_start+(86400*$i)));
                                                                                        }
                                                                                        
                                                                                    }
                                                                                    $arr[] = date('Y-m-d',$sum_end);
                                                                                    // dd(count($arr));

                                                                                   
                                                                                @endphp
                                                                                <li>
                                                                                    @if($p->status_period != 3)
                                                                                        @if($p->count <= 5) 
                                                                                            <span class="fulltext"> * </span><br>
                                                                                        @elseif($arrayDate != null) 
                                                                                        <a href="{{url('tour/'.$p->slug)}}" data-tooltip="{{ count($arr) }} วัน"
                                                                                            class="staydate">
                                                                                            <?php 
                                                                                            if($arrayDate != null){
                                                                                                $start = strtotime($p->start_date); // แปลง start_date เป็นตัวเลข
                                                                                                while ($start <= strtotime($p->end_date)) { // จับคู่กับวันหยุดแล้วใส่จุด
                                                                                                    if(in_array(date('Y-m-d',$start),$arrayDate)){
                                                                                                        echo '-';
                                                                                                    }
                                                                                                    $start = $start + 86400;
                                                                                                }
                                                                                            }
                                                                                        ?>
                                                                                        </a>
                                                                                        <br>
                                                                                        @else
                                                                                            <span class="saleperiod">
                                                                                                @if($p->special_price1) 
                                                                                                    {{number_format($p->price1 - $p->special_price1)}}฿  
                                                                                                @else
                                                                                                    {{number_format($p->price1)}}฿ 
                                                                                                @endif 
                                                                                            </span> <br>
                                                                                        @endif
                                                                                    {{date('d',strtotime($p->start_date))}} - {{date('d',strtotime($p->end_date))}}
                                                                                @endif
                                                                                </li>
                                                                                @endforeach
                                                                            </div>
                                                                            <hr>
                                                                            {{-- @endforeach --}}
                                                                        </div>
                                                                    </div>
                                                                    <div class="readMoreGradient"></div>
                                                            </div>
                                                            <a class="readMoreBtn"></a>
                                                            <span class="readLessBtnText" style="display: none;">Read
                                                                Less</span>
                                                            <span class="readMoreBtnText" style="display: none;">Read
                                                                More</span>
                                                        </div>
                                                    </div>
                                                    <div class="remainsFull">
                                                        <li>* ใกล้เต็ม</li>
                                                        <li><span class="noshowpad">-</span>
                                                            <span class="showpad">-</span> จำนวนวันหยุด</li>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-9">
                                                            @if($pre['soldout'])
                                                                <div class="fullperiod">
                                                                    <h6 class="pb-2">ทัวร์ที่เต็มแล้ว ({{count($pre['soldout'])}})</h6>
                                                                    @foreach ($pre['soldout'] as $sold)
                                                                        <span class="monthsold">{{$month[date('n',strtotime($sold[0]->start_date))]}}</span>
                                                                        @foreach($sold as $so)
                                                                            <li>{{date('d',strtotime($so->start_date))}} - {{date('d',strtotime($so->end_date))}} </li>
                                                                        @endforeach
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="col-md-3 text-md-end">
                                                            <a href="{{url('tour/'.$pre['tour']->slug)}}" class="btn-main-og  morebtnog">รายละเอียด</a>
                                                        </div>
                                                    </div>
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
                                        <tbody>
                                            <?php for ($i = 1; $i <= 12; $i++) { ?>
                                            <tr>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-5 col-lg-4">
                                                            <a href="#"><img src="images/cover_pe.webp"
                                                                    class="img-fluid" alt=""></a>
                                                        </div>
                                                        <div class="col-7 col-lg-8 titlenametab">
                                                            <h3><a href="#"> TAIWAN ไต้หวัน ซุปตาร์...KAOHSIUNG รักใสใส
                                                                    หัวใจอาร์ตๆ1111111</a>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><a href="#">โตเกียว</a> </td>
                                                <td><a href="#">5 วัน 3 คืน</a> </td>
                                                <td><a href="#"> กันยายน-ตุลาคม</a></td>
                                                <td><a href="#"><img src="images/airasia-logo 3.svg" alt=""></a> </td>
                                                <td> เริ่ม 21,888 บาท </td>
                                                <td>
                                                    <a href="#">
                                                        <div class="rating"><i class="bi bi-star-fill"></i> <i
                                                                class="bi bi-star-fill"></i> <i
                                                                class="bi bi-star-fill"></i>
                                                            <i class="bi bi-star-fill"></i> <i
                                                                class="bi bi-star-fill"></i>
                                                        </div>
                                                    </a>
                                                </td>
                                                <td> <a href="#" class="tagicbest"><img src="images/label/bestprice.png"
                                                            class="img-fluid" alt=""></a></td>

                                                <td> <a href="tour_detail.php1" class="link"><i
                                                            class="bi bi-chevron-right"></i></a></td>
                                            </tr>
                                            <?php } ?>
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
    <script>
        window.onload = function() {
            setInitialLikedStatus();
        };

        const likedTours = JSON.parse(localStorage.getItem('likedTours')) || [];

        function setInitialLikedStatus() {
            const heartIcons = document.querySelectorAll('.wishlist');
            
            heartIcons.forEach(icon => {
                const tourId = parseInt(icon.getAttribute('data-tour-id'));
                if (likedTours.includes(tourId)) {
                    icon.classList.add('active');
                }
            });
        }

        function likedTour(tourId) {
            const index = likedTours.indexOf(tourId);

            if (index === -1) {
                likedTours.push(tourId);
            } else {
                likedTours.splice(index, 1);
            }

            // บันทึก likedTours ใน local storage
            localStorage.setItem('likedTours', JSON.stringify(likedTours));

            // อัปเดตสถานะของไอคอนถูกใจ
            const heartIcon = document.querySelector(`[data-tour-id="${tourId}"]`);
            if (likedTours.includes(tourId)) {
                heartIcon.classList.add('active');
                toastr.success("ได้เพิ่มทัวร์ในรายการที่ต้องการสำเร็จแล้ว");
            } else {
                heartIcon.classList.remove('active');
                toastr.error("ลบรายการทัวร์ที่ต้องการสำเร็จแล้ว");
            }

            const likedCountElement = document.getElementById('numberwishls');
            // แสดงจำนวนที่ถูกใจใน header
            likedCountElement.textContent = `${likedTours.length}`;
        }

    </script>
</body>

</html>