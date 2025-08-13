<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    @include("frontend.layout.inc_header")
    <?php $pageName="inthai"; ?>
</head>

<body>
    @include("frontend.layout.inc_topmenu")
    <section id="protourpage" class="wrapperPages">
        <div class="container-fluid g-0 overflow-hidden">
            <div class="row">
                <div class="col">
                    <div class="bannereach">
                        @if(@$prov->banner)
                            <img src="{{asset(@$prov->banner)}}" alt="">
                        @else
                            <img src="{{asset('frontend/images/banner_thai.webp')}}" alt="">
                        @endif
                        <div class="bannercaption">
                            {!! $prov->banner_detail !!}
                        </div>
                        @php
                            $district = \App\Models\Backend\DistrictModel::where(['province_id'=>$prov->id,'status'=>'on','deleted_at'=>null])->orderby('id','asc')->get();
                        @endphp
                        @if(isset($filter['city']) && count($filter['city']) > 0)
                        @php
                            $city = array();
                            $t_id = array();
                            foreach ($filter['city'] as $id => $f_city) {
                                $city = array_merge($city,json_decode($f_city,true));
                                $t_id[] = $id;
                            }
                            $city = array_unique($city);
                            foreach ($city as $re) {
                                $data_city[] = App\Models\Backend\AmupurModel::where('id',$re)->get(); 
                            }
                        @endphp
                            @if(isset($data_city))
                                <div class="categoryslidegroup">
                                    <div class="categoryslide_list owl-carousel owl-theme">
                                        @foreach ($data_city as $n => $coun)
                                            @foreach ($coun as $c)
                                                <div class="item">
                                                    <a href="javascript:void(0);" onclick="Check_filter({{$c->id}},'city')">
                                                        <div class="catss">
                                                            ทัวร์{{$c->name_th?$c->name_th:$c->name_en}}
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="socialshare">
                @php
                    $urlSharer = url()->current();
                    $lineUrl = "https://social-plugins.line.me/lineit/share?url=".$urlSharer;
                    $facebookUrl = "https://www.facebook.com/sharer.php?u=".$urlSharer;
                    $twitterUrl = "https://twitter.com/intent/tweet?url={$urlSharer}";
                @endphp
                <span>แชร์</span>
                <ul>
                    <li><a href="{{url($lineUrl)}}" target="_blank">
                            <img src="{{asset('frontend/images/line_share.svg')}}" alt="">
                        </a></li>
                    <li><a href="{{url($facebookUrl)}}" target="_blank">
                            <img src="{{asset('frontend/images/facebook_share.svg')}}" alt="">
                        </a></li>
                    <li><a href="{{url($twitterUrl)}}" target="_blank" id="shareFB">
                            <img src="{{asset('frontend/images/twitter_share.svg')}}" alt="">
                        </a></li>
                    <li class="copylink"><a href="javascript:void(0);" id="copyButton"><i class="fi fi-rr-link-alt"></i></a></li>
                </ul>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <div class="pageontop_sl">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">หน้าหลัก </a></li>

                                <li class="breadcrumb-item active" aria-current="page">ทัวร์{{@$prov->name_th}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-lg-4 col-xl-3">
                    <div class="row">
                        <div class="col-5 col-lg-12">
                            @include("frontend.layout.inc_sidefilter_inthai")
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
                                    <ul id="show_select_date_mb_all"></ul>
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
                                <h1>ทัวร์{{@$prov->name_th}}</h1>
                                <p id="show_count">พบ {{@$data->total()}} รายการ</p>
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
                                    <div class="col" id="show_search">
                                        @php
                                            $month = ['','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
                                            $period_tooltip = array(); // เอาไอดี period มาใช้ในการทำ title tooltip
                                        @endphp
                                        @foreach($data as $k => $dat)
                                        @php
                                            $type = \App\Models\Backend\TourTypeModel::find(@$dat->type_id);
                                            $airline = \App\Models\Backend\TravelTypeModel::find($dat->airline_id);
                                            $period_all = \App\Models\Backend\TourPeriodModel::where(['tour_id'=>@$dat->id,'status_display'=>'on'])->whereDate('start_date','>=',now())->orderby('start_date','asc')->whereNull('deleted_at')->get();
                                            $period = $period_all->groupby('group_date');

                                            $allSoldOut = $period_all->every(function ($period_all) {
                                                return $period_all->status_period == 3; // เช็คถ้าทุก Period เป็น sold out
                                            });

                                            // $period = \App\Models\Backend\TourPeriodModel::where(['tour_id'=>$dat->id])->where('start_date','>=',date('Y-m-d'))->whereNull('deleted_at')->orderby('start_date','asc')->get()->groupby('group_date');
                                        @endphp
                                        <div class="boxwhiteshd">
                                            <div class="toursmainshowGroup  hoverstyle">
                                                <div class="row">
                                                    <div class="col-lg-12 col-xl-3 pe-xl-0">
                                                        <div class="covertourimg">
                                                            <figure>
                                                                <a href="{{url('tour/'.$dat->slug)}}" target="_blank"><img src="{{ asset(@$dat->image) }}" alt=""></a>
                                                            </figure>
                                                            <div class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
                                                                <a class="tagicbest"><img src="{{asset(@$type->image)}}" class="img-fluid" alt=""></a>
                                                            </div>
                                                            @if(@$dat->special_price > 0)
                                                            <div class="saleonpicbox">
                                                                <span> ลดราคาพิเศษ</span> <br>
                                                                {{ number_format($dat->special_price,0) }} บาท
                                                            </div>
                                                            @endif
                                                            @if(@$allSoldOut)
                                                            <div class="soldfilter">
                                                                <div class="soldop">
                                                                    <span class="bigSold">SOLD OUT </span> <br>
                                                                    <span class="textsold"> ว้า! หมดแล้ว คุณตัดสินใจช้าไป</span> <br>
                                                                    <a href="{{url('tour/'.$dat->slug)}}" target="_blank" class="btn btn-second mt-3"><i class="fi fi-rr-search"></i> หาโปรแกรมทัวร์ใกล้เคียง</a>
                                                                </div>
                                                            </div>
                                                            @endif
                                                            {{-- <div class="tagontop">
                                                                <li class="bgor"><a>{{$dat->num_day}}</a> </li>
                                                                <li class="bgwhite"><i class="fi fi-rr-marker"></i> {{@$prov->name_th}}</li>
                                                            </div> --}}
                                                            <div class="priceonpic">
                                                                @if($dat->special_price > 0)
                                                                @php $price = $dat->price - $dat->special_price; @endphp
                                                                    <span class="originalprice">ปกติ {{ number_format($dat->price,0) }} </span><br>
                                                                    เริ่ม<span class="saleprice"> {{ number_format(@$price,0) }} บาท</span>
                                                                @else
                                                                    <span class="saleprice"> {{ number_format($dat->price,0) }} บาท</span>
                                                                @endif
                                                            </div>
                                                            <div class="addwishlist">
                                                                <a href="javascript:void(0);" class="wishlist" data-tour-id="{{ $dat->id }}"><i class="bi bi-heart-fill" id="likeButton" onclick="likedTour({{@$dat->id}})"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-xl-9">
                                                        <div class="codeandhotel Cropscroll mt-1">
                                                            <li class="bgwhite"><i class="fi fi-rr-marker" style="color:#f15a22;"></i> {{@$prov->name_th}}</li>
                                                            <li>รหัสทัวร์ : <span class="bluetext">@if(@$dat->code1_check) {{@$dat->code1}} @else {{@$dat->code}} @endif</span> </li>
                                                            <li class="rating" >โรงแรม 
                                                                @if($dat->rating > 0)
                                                                    <a href="javascript:void(0);" onclick="Check_filter({{$dat->rating}},'rating')">
                                                                        @for($i=1; $i <= @$dat->rating; $i++)
                                                                        <i class="bi bi-star-fill"></i>
                                                                        @endfor
                                                                    </a>
                                                                @else
                                                                    <a href="javascript:void(0);" onclick="Check_filter(0,'rating')">
                                                                @endif
                                                            </li>
                                                            <li>
                                                                สายการบิน <a href="javascript:void(0);" onclick="Check_filter({{@$airline->id}},'airline')"><img src="{{asset(@$airline->image)}}" alt=""></a>
                                                            </li>
                                                            <li>
                                                                <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                                                                    <a href="javascript:void(0);" class="tagicbest"  name="type_data" onclick="OrderByType({{@$dat->type_id}})"><img src="{{asset(@$type->image)}}" class="img-fluid" alt=""> </a>
                                                                </div>
                                                            </li>
                                                            @php
                                                                $numday = 0;
                                                                foreach($period as $k => $pe){
                                                                    $numday = $pe[0]->day;
                                                                }
                                                            @endphp
                                                            <li class="bgor">ระยะเวลา <a href="javascript:void(0);" onclick="Check_filter({{$numday}},'day')">{{$dat->num_day}}</a> </li>
                                                        </div>

                                                        <div class="nameTop">
                                                            <h3> <a href="{{url('tour/'.$dat->slug)}}" target="_blank">{{ @$dat->name }}</a></h3>
                                                        </div>
                                                        <div class="pricegroup text-end">
                                                            @if($dat->special_price > 0)
                                                            @php $price = $dat->price - $dat->special_price; @endphp
                                                                <span class="originalprice">ปกติ {{ number_format($dat->price,0) }} </span><br>
                                                                เริ่ม<span class="saleprice"> {{ number_format(@$price,0) }} บาท</span>
                                                            @else
                                                                <span class="saleprice"> {{ number_format($dat->price,0) }} บาท</span>
                                                            @endif
                                                        </div>
                                                        @if(@$dat->description)
                                                        <div class="highlighttag">
                                                            <span><i class="fi fi-rr-tags"></i> </span> {{ @$dat->description }}
                                                        </div>
                                                        @endif
                                                        @php
                                                            $count_hilight = 0;
                                                            if($dat->travel){
                                                                $count_hilight++;
                                                            }
                                                            if($dat->shop){
                                                                $count_hilight++;
                                                            }
                                                            if($dat->eat){
                                                                $count_hilight++;
                                                            }
                                                            if($dat->special){
                                                                $count_hilight++;
                                                            }
                                                            if($dat->stay){
                                                                $count_hilight++;
                                                            }
                                                        @endphp
                                                        @if($count_hilight > 0)
                                                            <div class="hilight mt-2">
                                                                <div class="readMore">
                                                                    <div class="readMoreWrapper">
                                                                        <div class="readMoreText2">
                                                                            @if($dat->travel)
                                                                            <li>
                                                                                <div class="iconle"><span><i
                                                                                            class="bi bi-camera-fill"></i></span>
                                                                                </div>
                                                                                <div class="topiccenter"><b>เที่ยว</b></div>
                                                                                <div class="details">
                                                                                    {{ @$dat->travel }}
                                                                                </div>
                                                                            </li>
                                                                            @endif
                                                                            @if($dat->shop)
                                                                            <li>
                                                                                <div class="iconle"><span><i
                                                                                            class="bi bi-bag-fill"></i></span>
                                                                                </div>
                                                                                <div class="topiccenter"><b>ช้อป </b></div>
                                                                                <div class="details">
                                                                                    {{ @$dat->shop }}
                                                                                </div>
                                                                            </li>
                                                                            @endif
                                                                            @if($dat->eat)
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
                                                                                    {{ @$dat->eat }} 
                                                                                </div>
                                                                            </li>
                                                                            @endif
                                                                            @if($dat->special)
                                                                            <li>
                                                                                <div class="iconle"><span><i class="bi bi-bookmark-heart-fill" id="likeButton"></i></span>
                                                                                </div>
                                                                                <div class="topiccenter"><b>พิเศษ </b></div>
                                                                                <div class="details">
                                                                                    {{ @$dat->special }}
                                                                                </div>
                                                                            </li>
                                                                            @endif
                                                                            @if($dat->stay)
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
                                                                                    {{ @$dat->stay }}
                                                                                </div>
                                                                            </li>
                                                                            @endif
                                                                        </div>
                                                                        <div class="readMoreGradient"></div>
                                                                    </div>
                                                                    @if($count_hilight > 0)
                                                                    <a class="readMoreBtn2"></a>
                                                                    <span class="readLessBtnText"
                                                                        style="display: none;">Read Less</span>
                                                                    <span class="readMoreBtnText"
                                                                        style="display: none;">Read More </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                @if(@!$allSoldOut)
                                                <div class="periodtime">
                                                    <div class="readMore">
                                                        <div class="readMoreWrapper">
                                                            <div class="readMoreText">
                                                                <div class="listperiod_moredetails">
                                                                    @php
                                                                        $sold_tour = array();
                                                                    @endphp
                                                                    @foreach($period as $k => $pe)
                                                                        <div class="tagmonth">
                                                                            <span class="month">{{$month[date('n',strtotime($pe[0]->start_date))]}}</span>
                                                                        </div>
                                                                        <div class="splgroup">
                                                                            @foreach($pe as $p)
                                                                            @php
                                                                                if($p->count == 0 && $p->status_period == 3){
                                                                                    $sold_tour[] = $p->id;
                                                                                }
                                                                            @endphp
                                                                            <li>
                                                                                <?php 
                                                                                    $start = strtotime($p->start_date);
                                                                                    ${'holliday'.$p->id} = 0;
                                                                                    while ($start <= strtotime($p->end_date)) {
                                                                                        if(in_array(date('Y-m-d',$start),$arr) || date('N',$start) >= 6){
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
                                                                                        // if($arr != null){
                                                                                            $start = strtotime($p->start_date); // แปลง start_date เป็นตัวเลข
                                                                                            $chk_price = true;
                                                                                            // ${'holliday'.$p->id} = 0; // นับจำนวนวันหยุด
                                                                                            while ($start <= strtotime($p->end_date)) { // จับคู่กับวันหยุดแล้วใส่ขีด
                                                                                                if(in_array(date('Y-m-d',$start),$arr) || date('N',$start) >= 6){
                                                                                                    $chk_price = false;
                                                                                                    // if($p->count <= 10){
                                                                                                    //     echo '<span class="fulltext">*</span>';
                                                                                                    // }else{
                                                                                                    //     $period_tooltip[] = $p->id;  // เอาไอดี period มาใช้ในการทำ title tooltip
                                                                                                    //     ${'holliday'.$p->id}++; // บวกวันหยุดไปเรื่อย ๆ
                                                                                                    //     echo '<span class="staydate">-</span>';
                                                                                                    // }
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
                                                                                        // }
                                                                                    ?>
                                                                                    {{-- <input type="hidden" id="holliday-{{$p->id}}" value="{{ ${'holliday'.$p->id} }}"> --}}
                                                                                </a>
                                                                                <br>
                                                                                {{date('d',strtotime($p->start_date))}} - {{date('d',strtotime($p->end_date))}}
                                                                            </li>
                                                                            @endforeach
                                                                        </div>
                                                                        <hr>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                            <div class="readMoreGradient"></div>
                                                        </div>
                                                        @if(count($period) > 1)
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
                                                <div class="row mb-2">
                                                    <div class="col-md-9">
                                                        <div class="fullperiod">
                                                            @if(count($sold_tour))
                                                            <h6>พีเรียดที่เต็มแล้ว ({{count($sold_tour)}})</h6>
                                                            @foreach($period as $k => $pe)
                                                                {{-- @if($pe[0]->count == 0)
                                                                    <span class="monthsold">{{$month[date('n',strtotime($pe[0]->start_date))]}}</span>
                                                                @endif --}}
                                                                @foreach($pe as $p)
                                                                    @if($p->count == 0 && $p->status_period == 3)
                                                                        <span class="monthsold">{{$month[date('n',strtotime($pe[0]->start_date))]}}</span>
                                                                        <li>{{date('d',strtotime($p->start_date))}} - {{date('d',strtotime($p->end_date))}}</li>
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 text-md-end">
                                                        <a href="{{url('tour/'.$dat->slug)}}" target="_blank" class="btn-main-og  morebtnog">รายละเอียด</a>
                                                    </div>
                                                </div>
                                                @endif
                                                <br>
                                            </div>
                                        </div>
                                        @endforeach
                                        <div class="row mt-4 mb-4">
                                            <div class="col">
                                                <div class="pagination_bot">
                                                    <nav class="pagination-container">
                                                        <div class="pagination">
                                                            @php 
                                                                $page = $data->currentPage();
                                                                $total_page = $data->lastPage();
                                                                $older = $page+1;    
                                                                $newer = $page-1;  
                                                                $start_page = max(1, $page - 2);
                                                                $end_page = min($total_page, $start_page + 19);
                                                            @endphp
                                                            @if($page != $newer && $page != 1)
                                                                <a class="pagination-newer" href="?page={{$newer}}"><i class="fas fa-angle-left"></i></a>
                                                            @endif
                                                            @if($total_page > 1)
                                                                <?php for($i=$start_page; $i<= $end_page; $i++){ ?> 
                                                                    <span class="pagination-inner">
                                                                        <a class="<?php if($i == $page) { echo 'pagination-active';}?>"  href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                                                    </span>
                                                                <?php } ?>
                                                            @endif
                                                            @if($page != $older && $page != $total_page)
                                                                <a class="pagination-older" href="?page={{$older}}"><i class="fas fa-angle-right"></i></a>
                                                            @endif
                                                        </div>
                                                    </nav>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            {{-- grid view --}}
                            <div class="table-list">
                                <div class="showtourontable  table-responsive-xl">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>โปรแกรม</th>
                                                <th>เมนูย่อย</th>
                                                <th>จำนวนวัน</th>
                                                {{-- <th>ช่วงเดือน</th> --}}
                                                <th>สายการบิน</th>
                                                <th>ราคา</th>
                                                <th>โรงแรม</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="show_grid">
                                            @foreach(@$data as $k => $dat)
                                            @php
                                                $type = \App\Models\Backend\TourTypeModel::find(@$dat->type_id);
                                                $airline = \App\Models\Backend\TravelTypeModel::find(@$dat->airline_id);
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="row">
                                                        <div class="col-5 col-lg-4">
                                                            <a href="{{url('tour/'.$dat->slug)}}" target="_blank"><img src="{{asset(@$dat->image)}}" class="img-fluid" alt=""></a>
                                                        </div>
                                                        <div class="col-7 col-lg-8 titlenametab">
                                                            <h3><a href="{{url('tour/'.$dat->slug)}}" target="_blank"> {{@$dat->name}}</a></h3>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><a href="{{ url('inthai/'.@$prov->slug)}}">{{@$prov->name_th}}</a> </td>
                                                <td><a href="javascript:void(0);" onclick="Check_filter({{$numday}},'day')">{{@$dat->num_day}}</a> </td>
                                                {{-- <td><a href="{{url('tour/'.$dat->slug)}}">{{$month[date('n',strtotime($pre['period'][0]->start_date))]}}</a></td> --}}
                                                <td><a href="javascript:void(0);" onclick="Check_filter({{@$airline->id}},'airline')"><img src="{{asset(@$airline->image)}}" alt=""></a> </td>
                                                <td>
                                                    @if($dat->special_price > 0)
                                                    @php $price = $dat->price - $dat->special_price; @endphp
                                                        เริ่ม {{ number_format(@$price,0) }} บาท
                                                    @else
                                                        เริ่ม {{ number_format($dat->price,0) }} บาท
                                                    @endif 
                                                </td>
                                                <td>
                                                   
                                                        <div class="rating">
                                                            @if($dat->rating > 0)
                                                                <a href="javascript:void(0);" onclick="Check_filter({{$dat->rating}},'rating')">
                                                                    @for($i=1; $i <= @$dat->rating; $i++)
                                                                    <i class="bi bi-star-fill"></i>
                                                                    @endfor
                                                                </a>
                                                            @else
                                                                <a href="javascript:void(0);" onclick="Check_filter(0,'rating')">
                                                            @endif
                                                        </div>
                                                   
                                                </td>
                                                <td> <a href="javascript:void(0);" class="tagicbest"  name="type_data" onclick="OrderByType({{@$dat->type_id}})"><img src="{{asset(@$type->image)}}" class="img-fluid" alt=""></a></td>

                                                <td> <a href="{{ url('tour/'.@$dat->slug)}}" target="_blank" class="link"><i class="bi bi-chevron-right"></i></a></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- end grid view --}}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @include("frontend.layout.inc_footer")
    @include("frontend.layout.filter_inthai")
  
    <script>
        function OrderByData(id) {
            if(id != null){
                $.ajax({
                    type: 'GET',
                    url: '{{url("/inthai")}}/{{$main_slug}}?orderby='+id,
                    success: function (data) {
                        var newUrl = '{{url("/inthai")}}/{{$main_slug}}?orderby='+id; 
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
                    url: '{{url("/inthai")}}/{{$main_slug}}?type='+id,
                    success: function (data) {
                        var newUrl = '{{url("/inthai")}}/{{$main_slug}}?type='+id; 
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
            $('.categoryslide_list').owlCarousel({
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
                        margin: 0,
                        nav: false,


                    },
                    600: {
                        items: 3,
                        margin: 0,
                        nav: false,

                    },
                    1024: {
                        items: 4,
                        slideBy: 1
                    },
                    1200: {
                        items: 7,
                        slideBy: 1
                    }
                }
            })

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
                const likedCountElement = document.getElementById('numberwishls');
                const likedCountElementM = document.getElementById('numberwishlsM');

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

                    // แสดงจำนวนที่ถูกใจใน header
                    likedCountElement.textContent = `${likedTours.length}`;
                    likedCountElementM.textContent = `${likedTours.length}`;
                } else {
                    heartIcon.classList.remove('active');
                    toastr.error("ลบรายการทัวร์ที่ต้องการสำเร็จแล้ว");

                    // แสดงจำนวนที่ถูกใจใน header
                    likedCountElement.textContent = `${likedTours.length}`;
                    likedCountElementM.textContent = `${likedTours.length}`;
                }
            }

        });

        // เอาจำนวนวันหยุดไปใส่ไว้ใน data tooltip
        // var period = <?php echo json_encode($period_tooltip); ?>;
        // period.forEach(function(pt) {
        //     var element = document.getElementById('staydate' + pt);
        //     var hol_count = document.getElementById('holliday-' + pt).value;
        //     if (element) {
        //         element.setAttribute('data-tooltip', hol_count + ' วัน');
        //     }
        // });

        document.addEventListener("DOMContentLoaded", function() {
            var copyButton = document.getElementById('copyButton');

            copyButton.addEventListener('click', function() {

                var input = document.createElement('input');
                input.value = '{{ url()->current() }}';

                document.body.appendChild(input);

                // เลือกข้อความใน input
                input.select();
                input.setSelectionRange(0, 99999); /* For mobile devices */
                
                // คัดลอกข้อความ
                document.execCommand('copy');

                document.body.removeChild(input);

                alert('URL ถูกคัดลอกแล้ว: ' + input.value);
            });
        });
    </script>


</body>

</html>