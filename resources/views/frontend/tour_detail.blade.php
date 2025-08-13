<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    @include("frontend.layout.inc_header")
    <?php $pageName="oversea"; ?>
</head>

<body>
    @include("frontend.layout.inc_topmenu")
    <section id="tourdetailspage" class="wrapperPages">
        <div class="socialshare">
            <span>แชร์</span>
            <ul>
                @php  
                    $urlSharer = url("tour/".$detail_slug);
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
                <input type="hidden" value="{{$urlSharer}}" id="myInput">
                <li class="copylink"><i class="fi fi-rr-link-alt" onclick="myFunction()"></i></li>
            </ul>
        </div>
        <div class="container">
            @php
                $airline = App\Models\Backend\TravelTypeModel::find(@$data->airline_id);
                $tag = App\Models\Backend\TagContentModel::whereIn('id',json_decode(@$data->tag_id,true))->get();
                $country_sel = App\Models\Backend\CountryModel::whereIn('id',json_decode(@$data->country_id,true))->first();
                $city_sel = App\Models\Backend\CityModel::whereIn('id',json_decode(@$data->city_id,true))->get();
                $province_sel = App\Models\Backend\ProvinceModel::whereIn('id',json_decode(@$data->province_id,true))->first();
                $district_sel = App\Models\Backend\DistrictModel::whereIn('id',json_decode(@$data->district_id,true))->get();

                $tour_gallery = App\Models\Backend\TourGalleryModel::where('tour_id',$data->id)->get();
            @endphp
            <div class="row mt-5">
                <div class="col">
                    <div class="pageontop_sl">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">หน้าหลัก </a></li>
                                @if(json_decode($data->country_id))
                                    <li class="breadcrumb-item"><a href="{{url('/search-tour')}}">ทัวร์ต่างประเทศ </a></li>
                                    <li class="breadcrumb-item"><a href="{{ url('/oversea/'.@$country_sel->slug) }}"> ทัวร์{{@$country_sel->country_name_th}} </a></li>
                                @else
                                <li class="breadcrumb-item"><a href="javascript:void(0);">ทัวร์ในประเทศ </a></li>
                                <li class="breadcrumb-item"><a href="{{ url('/inthai/'.@$province_sel->slug) }}"> ทัวร์{{@$province_sel->name_th}} </a></li>
                                @endif
                                <li class="breadcrumb-item active" aria-current="page">{{ @$data->name }}
                                    {{ @$data->num_day }}</li>
                                {{-- สายการบิน {{$airline->travel_name }}
                                </li> --}}
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="titletopic mt-2">
                                <h1>{{ @$data->name }}
                                    <br>
                                    {{ @$data->num_day }}</h1>
                                    {{-- {{ @$data->num_day }} สายการบินแอร์เอเชียเอ๊กซ์</h1> --}}
                                <div class="tagcat03 mt-3 Cropscroll">
                                    @if(@$data->pdf_file)
                                        <li><a href="{{ asset($data->pdf_file) }}"><i class="bi bi-file-earmark-pdf-fill"></i> ดาวน์โหลดโปรแกรมทัวร์ PDF</a></li>
                                    @endif
                                    @if(@$data->word_file)
                                        <li><a href="{{ asset($data->word_file) }}"><i class="bi bi-file-earmark-word-fill"></i> ดาวน์โหลดโปรแกรมทัวร์ Word</a></li>
                                    @endif
                                </div>
                            </div>
                            <div class="tagcat03 mt-3 Cropscroll">
                                @foreach($tag as $t)
                                    <li><a href="{{url('/search-tour')}}?tag={{$t->id}}" {{-- onclick="Filter_tag({{$t->id}})" --}}>#{{ @$t->tag }}</a></li>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-lg-2">
                            <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                                <div class="logoborder">
                                    <a href="javascript:void(0);"><img src="{{asset(@$airline->image)}}" class="img-fluid" alt=""></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @php
                        $contact = \App\Models\Backend\ContactModel::find(1);
                        $month = ['','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
                        $month_th = json_encode($month);
        
                        $period_all = \App\Models\Backend\TourPeriodModel::where(['tour_id'=>@$data->id,'status_display'=>'on'])->whereDate('start_date','>=',now())->orderby('start_date','asc')->whereNull('deleted_at')->get();
                        $period_all_encode = json_encode($period_all);

                        $allSoldOut = $period_all->every(function ($period) {
                            return $period->status_period == 3;
                        });
        
                        $period_date = \App\Models\Backend\TourPeriodModel::where(['tour_id'=>@$data->id,'status_display'=>'on'])->whereDate('start_date','>=',now())->orderby('start_date','asc')->whereNull('deleted_at')->get()->groupby('group_date');
                        $period_date = json_encode($period_date);
                        $period_date = json_decode($period_date,true);
                        $period_date = array_values($period_date);

                        $cityIds = json_decode($data->city_id);
                        $provinceIds = json_decode($data->province_id);
                        
                        if($cityIds || $provinceIds){
                            $tour_nearby = App\Models\Backend\TourModel::whereNull('deleted_at')
                            ->where('status','on')
                            ->where('id','!=',$data->id)
                            ->where(function ($query) use ($cityIds,$provinceIds) {
                                foreach ($cityIds as $cityId) {
                                    $query->orWhereJsonContains('city_id', $cityId);
                                }
                                foreach ($provinceIds as $provinceId) {
                                    $query->orWhereJsonContains('province_id', $provinceId);
                                }
                            })
                            ->orderBy('id','desc')
                            ->limit(8)
                            ->get();
                        }else{
                            $tour_nearby = null;
                        }
                    @endphp
                    {{-- sold out --}}
                    @if(@$allSoldOut)
                    <div class="soldoutgroup mt-5">
                        <div class="row">
                            <div class="col text-center">
                                <h2>Sold Out</h2>
                                <h3>หมดเวลาแล้ว คุณตัดสินใจช้าไป!!</h3>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col text-center">
                                <h5><i class="fi fi-rr-ticket-airline"></i> โปรแกรมทัวร์ใกล้เคียง</h5>
                            </div>
                        </div>
                        <div class="row mt-3">
                            @if($tour_nearby)
                            @foreach($tour_nearby as $tn)
                                @php
                                    $tn_country = \App\Models\Backend\CountryModel::whereIn('id',json_decode(@$tn->country_id,true))->first();
                                    $tn_airline = \App\Models\Backend\TravelTypeModel::find(@$tn->airline_id);
                                    $tn_period = \App\Models\Backend\TourPeriodModel::where(['tour_id'=>@$tn->id,'status_display'=>'on'])->whereDate('start_date','>=',now())->where('count','>',0)->orderby('start_date','asc')->whereNull('deleted_at')->get()->groupby('group_date');
                                @endphp
                                <div class="col-12 col-lg-3  @if(count($tn_period) == 0)d-none @endif">
                                    <div class="showvertiGroup">
                                        <div class="boxwhiteshd hoverstyle">
                                            <figure>
                                                <a href="{{url('tour/'.@$tn->slug)}}">
                                                    <img src="{{ asset(@$tn->image) }}" alt="">
                                                </a>
                                            </figure>
                                            {{-- <div class="tagontop">
                                                <li class="bgor"><a>{{@$tn->num_day}}</a> </li>
                                                <li class="bgblue"><a><i class="fi fi-rr-marker"></i>{{@$tn_country->country_name_th}}</a>
                                                </li>
                                                <li>
                                                    สายการบิน <img src="{{asset(@$tn_airline->image)}}" alt="">
                                                </li>
                                            </div> --}}
                                            <div class="contenttourshw">
                                                <div class="codeandhotel">
                                                    <li>รหัสทัวร์ : <span class="bluetext">@if(@$tn->code1_check) {{@$tn->code1}} @else {{@$tn->code}} @endif</span> </li>
                                                    <li class="rating">โรงแรม 
                                                        @for($i=1; $i <= @$tn->rating; $i++)
                                                            <i class="bi bi-star-fill"></i>
                                                        @endfor
                                                    </li>
                                                </div>
                                                <hr>
                                                <div class="locationnewd mb-2 mt-2">
                                                    <li> <a> <i class="fi fi-rr-marker"></i> {{@$tn_country->country_name_th}}</a></li>
                                                    <li class="datetour"><a>{{$tn->num_day}}</a> </li>
                                                    <li class="airlines"> 
                                                        สายการบิน <img src="{{asset(@$tn_airline->image)}}" alt=""> 
                                                    </li>
                                                </div>
                                                <h3> <a href="{{url('tour/'.@$tn->slug)}}"> {{@$tn->name}}</a>
                                                </h3>
                                                <div class="listperiod">
                                                    @foreach($tn_period as $tpe)
                                                    <li>
                                                        <span class="month">{{$month[date('n',strtotime($tpe[0]->start_date))]}}</span>
                                                        @php $toEnd = count($tpe);  @endphp
                                                        @foreach($tpe as $key => $p)
                                                            {{date('d',strtotime($p->start_date))}} - {{date('d',strtotime($p->end_date))}} @if(0 !== --$toEnd)/@endif
                                                        @endforeach
                                                    </li><br>
                                                    @endforeach
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-lg-7">
                                                        <div class="pricegroup">
                                                            @if($tn->special_price > 0)
                                                            @php $tn_price = $tn->price - $tn->special_price; @endphp
                                                                <span class="originalprice">ปกติ {{ number_format($tn->price,0) }} </span><br>
                                                                เริ่ม<span class="saleprice"> {{ number_format(@$tn_price,0) }} บาท</span>
                                                            @else
                                                                <span class="saleprice"> {{ number_format($tn->price,0) }} บาท</span>
                                                            @endif
                                                        </div>

                                                    </div>
                                                    <div class="col-lg-5 ps-0">
                                                        <a href="{{url('tour/'.@$tn->slug)}}" class="btn-main-og morebtnog">รายละเอียด</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @endif
                        </div>
                        <div class="row mt-4 text-center">
                            <div class="col">
                                <p>หากคุณสนใจสามารถติดต่อสอบถามโดยตรงได้ที่</p>
                                <h4>{{@$contact->hotline}}</h4>
                                <span class="ors">หรือ</span> <br>
                                <a href="{{url('https://line.me/ti/p/'.@$contact->line_id)}}" target="_blank">
                                    <img src="{{asset('frontend/images/line_share.svg')}}" alt="">
                                </a>
                                <a href="{{@$contact->link_fb}}" target="_blank">
                                    <img src="{{asset('frontend/images/facebook_share.svg')}}" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                    {{-- end sold out --}}
                    <div class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
                        @php
                            if($data->special_price > 0){
                                $price = $data->price - $data->special_price;
                            }else{
                                $price = $data->price;
                            }
                        @endphp
                        <div class="listinlinedetails">
                            <li><span class="textonssd">ราคาเริ่มต้น </span> <br> {{ number_format($price,0) }}</li>
                            <li><span class="textonssd">รหัสทัวร์ </span> <br> @if(@$data->code1_check) {{@$data->code1}} @else {{@$data->code}} @endif</li>
                            <li><span class="textonssd">ระยะเวลา </span> <br> {{ @$data->num_day }}</li>
                            {{-- <li> <a href="#"><img src="{{asset('frontend/images/logo_air.svg')}}" class="img-fluid" alt=""></a></li> --}}
                            <li><span class="textonssd">สายการบิน </span> <br> <a href="javascript:void(0);"><img src="{{asset(@$airline->image)}}" class="img-fluid" alt=""></a></li>
                            <li class="rating"> <span class="textonssd">โรงแรม </span> <br>
                                @for($i=1; $i <= @$data->rating; $i++)
                                    <i class="bi bi-star-fill"></i>
                                @endfor
                            </li>
                        </div>
                    </div>
                    <div class="row mt-1 mt-lg-3">
                        <div class="col-lg-8">
                            <div class="slide_product mt-3 mt-md-0">
                                <div id="big" class="owl-carousel owl-theme">
                                    <a class="item" data-fancybox="gallery" href="{{ asset(@$data->image) }}"><img src="{{ asset(@$data->image) }}"></a>
                                    @foreach(@$tour_gallery as $gal)
                                        <a class="item" data-fancybox="gallery" href="{{ asset(@$gal->img) }}"><img src="{{ asset(@$gal->img) }}"></a>
                                    @endforeach
                                </div>
                                <div id="thumbs" class="owl-carousel owl-theme mt-3">
                                    <div class="item"><img src="{{ asset(@$data->image) }}"></div>
                                    @foreach(@$tour_gallery as $gal)
                                        <div class="item"><img src="{{ asset(@$gal->img) }}"></div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="boxdetailtop">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="tagcountry">
                                            <a>
                                                {{@$country_sel->country_name_th}}
                                            </a>
                                            {{-- <a><img src="{{asset('frontend/images/flag/japan_flag.svg')}}" alt=""> ทัวร์
                                                @foreach($country_sel as $co) 
                                                    {{@$co->country_name_th}}
                                                @endforeach
                                            </a> --}}
                                        </div>
                                    </div>
                                    <div class="col-lg-4 text-end">
                                        <a href="javascript:void(0);" class="addfave wishlist" data-tour-id="{{ $data->id }}" onclick="likedTour({{@$data->id}})"><i class="bi bi-heart-fill" id="likeButton"></i> ถูกใจ</a>
                                    </div>
                                </div>
                                <div class="row grouppad">
                                    <div class="col-lg-7 botst">
                                        ราคาเริ่มต้น
                                    </div>
                                    <div class="col-lg-5">
                                        {{ number_format(@$price,0) }} บาท
                                    </div>
                                    <div class="w-100"></div>
                                    <div class="col-lg-7">
                                        รหัสทัวร์
                                    </div>
                                    <div class="col-lg-5">
                                        @if(@$data->code1_check) {{@$data->code1}} @else {{@$data->code}} @endif
                                    </div>
                                    <div class="w-100"></div>
                                    <div class="col-lg-7">
                                        ระยะเวลา
                                    </div>
                                    <div class="col-lg-5">
                                        {{ @$data->num_day }}
                                    </div>

                                    <div class="w-100"></div>
                                    <div class="col-lg-7">
                                        ระดับที่พัก
                                    </div>
                                    <div class="col-lg-5 rating">
                                        @for($i=1; $i <= @$data->rating; $i++)
                                            <i class="bi bi-star-fill"></i>
                                        @endfor
                                    </div>
                                </div>
                                <hr>

                                <div class="row mt-2 grouppad">
                                    <div class="col-lg-12">
                                        <a href="{{ url('/booking/'.$data->slug.'/0')}}" class="btn-submit-search">จองเลย</a>
                                    </div>
                                    <div class="w-100"></div>
                                    <div class="col-lg-6">
                                        <a href="#selectboxdate" class="btn btn-border">เลือกวันเดินทาง</a>
                                    </div>
                                    <div class="col-lg-6">
                                        <a href="{{url('https://line.me/ti/p/'.@$contact->line_id)}}" target="_blank" class="btn bookline"><img src="{{asset('frontend/images/line_add.svg')}}" alt="">
                                            จองผ่านไลน์</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3 mt-lg-3">
                        <div class="col-lg-8">
                            @if(@$data->travel || @$data->shop || @$data->eat || @$data->special || @$data->stay)
                            <div class="titletopic">
                                <h2>ไฮไลท์โปรแกรมทัวร์</h2>
                            </div>
                            @endif
                            <div class="hilight mt-1 mt-lg-3">
                                @if(@$data->travel)
                                <li>
                                    <div class="iconle"><span><i class="bi bi-camera-fill"></i></span> </div>
                                    <div class="topiccenter"><b>เที่ยว</b></div>
                                    <div class="details">
                                        {{ @$data->travel }}
                                    </div>
                                </li>
                                @endif
                                @if(@$data->shop)
                                <li>
                                    <div class="iconle"><span><i class="bi bi-bag-fill"></i></span> </div>
                                    <div class="topiccenter"><b>ช้อป </b></div>
                                    <div class="details">
                                        {{ @$data->shop }}
                                    </div>
                                </li>
                                @endif
                                @if(@$data->eat)
                                <li>
                                    <div class="iconle"><span><svg xmlns="http://www.w3.org/2000/svg" width="22"
                                                height="22" fill="currentColor" class="bi bi-cup-hot-fill"
                                                viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                    d="M.5 6a.5.5 0 0 0-.488.608l1.652 7.434A2.5 2.5 0 0 0 4.104 16h5.792a2.5 2.5 0 0 0 2.44-1.958l.131-.59a3 3 0 0 0 1.3-5.854l.221-.99A.5.5 0 0 0 13.5 6H.5ZM13 12.5a2.01 2.01 0 0 1-.316-.025l.867-3.898A2.001 2.001 0 0 1 13 12.5Z" />
                                                <path
                                                    d="m4.4.8-.003.004-.014.019a4.167 4.167 0 0 0-.204.31 2.327 2.327 0 0 0-.141.267c-.026.06-.034.092-.037.103v.004a.593.593 0 0 0 .091.248c.075.133.178.272.308.445l.01.012c.118.158.26.347.37.543.112.2.22.455.22.745 0 .188-.065.368-.119.494a3.31 3.31 0 0 1-.202.388 5.444 5.444 0 0 1-.253.382l-.018.025-.005.008-.002.002A.5.5 0 0 1 3.6 4.2l.003-.004.014-.019a4.149 4.149 0 0 0 .204-.31 2.06 2.06 0 0 0 .141-.267c.026-.06.034-.092.037-.103a.593.593 0 0 0-.09-.252A4.334 4.334 0 0 0 3.6 2.8l-.01-.012a5.099 5.099 0 0 1-.37-.543A1.53 1.53 0 0 1 3 1.5c0-.188.065-.368.119-.494.059-.138.134-.274.202-.388a5.446 5.446 0 0 1 .253-.382l.025-.035A.5.5 0 0 1 4.4.8Zm3 0-.003.004-.014.019a4.167 4.167 0 0 0-.204.31 2.327 2.327 0 0 0-.141.267c-.026.06-.034.092-.037.103v.004a.593.593 0 0 0 .091.248c.075.133.178.272.308.445l.01.012c.118.158.26.347.37.543.112.2.22.455.22.745 0 .188-.065.368-.119.494a3.31 3.31 0 0 1-.202.388 5.444 5.444 0 0 1-.253.382l-.018.025-.005.008-.002.002A.5.5 0 0 1 6.6 4.2l.003-.004.014-.019a4.149 4.149 0 0 0 .204-.31 2.06 2.06 0 0 0 .141-.267c.026-.06.034-.092.037-.103a.593.593 0 0 0-.09-.252A4.334 4.334 0 0 0 6.6 2.8l-.01-.012a5.099 5.099 0 0 1-.37-.543A1.53 1.53 0 0 1 6 1.5c0-.188.065-.368.119-.494.059-.138.134-.274.202-.388a5.446 5.446 0 0 1 .253-.382l.025-.035A.5.5 0 0 1 7.4.8Zm3 0-.003.004-.014.019a4.077 4.077 0 0 0-.204.31 2.337 2.337 0 0 0-.141.267c-.026.06-.034.092-.037.103v.004a.593.593 0 0 0 .091.248c.075.133.178.272.308.445l.01.012c.118.158.26.347.37.543.112.2.22.455.22.745 0 .188-.065.368-.119.494a3.198 3.198 0 0 1-.202.388 5.385 5.385 0 0 1-.252.382l-.019.025-.005.008-.002.002A.5.5 0 0 1 9.6 4.2l.003-.004.014-.019a4.149 4.149 0 0 0 .204-.31 2.06 2.06 0 0 0 .141-.267c.026-.06.034-.092.037-.103a.593.593 0 0 0-.09-.252A4.334 4.334 0 0 0 9.6 2.8l-.01-.012a5.099 5.099 0 0 1-.37-.543A1.53 1.53 0 0 1 9 1.5c0-.188.065-.368.119-.494.059-.138.134-.274.202-.388a5.446 5.446 0 0 1 .253-.382l.025-.035A.5.5 0 0 1 10.4.8Z" />
                                            </svg></span> </div>
                                    <div class="topiccenter"><b>กิน </b></div>
                                    <div class="details">
                                        {{ @$data->eat }}
                                    </div>
                                </li>
                                @endif
                                @if(@$data->special)
                                <li>
                                    <div class="iconle"><span><i class="bi bi-bookmark-heart-fill" id="likeButton"></i></span> </div>
                                    <div class="topiccenter"><b>พิเศษ </b></div>
                                    <div class="details">
                                        {{ @$data->special }}
                                    </div>
                                </li>
                                @endif
                                @if(@$data->stay)
                                <li>
                                    <div class="iconle"><span><svg xmlns="http://www.w3.org/2000/svg" width="22"
                                                height="22" fill="currentColor" class="bi bi-buildings-fill"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M15 .5a.5.5 0 0 0-.724-.447l-8 4A.5.5 0 0 0 6 4.5v3.14L.342 9.526A.5.5 0 0 0 0 10v5.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V14h1v1.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5V.5ZM2 11h1v1H2v-1Zm2 0h1v1H4v-1Zm-1 2v1H2v-1h1Zm1 0h1v1H4v-1Zm9-10v1h-1V3h1ZM8 5h1v1H8V5Zm1 2v1H8V7h1ZM8 9h1v1H8V9Zm2 0h1v1h-1V9Zm-1 2v1H8v-1h1Zm1 0h1v1h-1v-1Zm3-2v1h-1V9h1Zm-1 2h1v1h-1v-1Zm-2-4h1v1h-1V7Zm3 0v1h-1V7h1Zm-2-2v1h-1V5h1Zm1 0h1v1h-1V5Z" />
                                            </svg></span> </div>
                                    <div class="topiccenter"><b>พัก </b></div>
                                    <div class="details">
                                        {{ @$data->stay }}
                                    </div>
                                </li>
                                @endif
                            </div>
                            <br>
                            @if(@$data->pdf_file)
                                <a href="{{ asset($data->pdf_file) }}" class="btn btn-border"><i class="bi bi-file-earmark-pdf-fill"></i> ดาวน์โหลดโปรแกรมทัวร์ PDF</a>
                            @endif
                            @if(@$data->word_file)
                                <a href="{{ asset($data->word_file) }}" class="btn btn-border"><i class="bi bi-file-earmark-word-fill"></i> ดาวน์โหลดโปรแกรมทัวร์ Word</a>
                            @endif
                        </div>
                        <div class="col-lg-4 mt-3">
                            <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                                <div class="mtupper">
                                    @if($data->video && $data->video_cover)
                                    <div class="titletopic">
                                        <h2>วีดีโอไฮไลท์</h2>
                                    </div>
                                    <div class="videogroupHilight">
                                        <a href="{{ @$data->video }}" data-fancybox="video-gallery"><img alt="" src="{{ asset($data->video_cover) }}"
                                            class="img-fluid"> <span><i class="bi bi-play-circle"></i></span></a>

                                    </div>
                                    @endif
                                    @php
                                        if($cityIds){
                                            $video_relate = App\Models\Backend\VideoModel::where('status','on')
                                            ->where(function ($query) use ($cityIds) {
                                                foreach ($cityIds as $cityId) {
                                                    $query->orWhereJsonContains('city_id', $cityId);
                                                }
                                            })
                                            ->limit(2)
                                            ->get();
                                        }else{
                                            $video_relate = null;
                                        }
                                    @endphp
                                    @if($video_relate && count($video_relate) > 0)
                                    <div class="titletopic mt-2">
                                        <h2>วีดีโอที่เกี่ยวข้อง</h2>
                                    </div>
                                    <div class="row">
                                        @foreach($video_relate as $vr)
                                        <div class="col-lg-6">
                                            <div class="videogroupHilight ">
                                                <a href="{{$vr->link}}" data-fancybox="video-gallery"><img alt="" src="{{asset(@$vr->img)}}" 
                                                    class="img-fluid"> <span><i class="bi bi-play-circle"></i></span></a>
                                            </div>
                                            <div class="newslistgroup hoverstyle">
                                                <h3>{{$vr->title}}</h3>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            </div>
                            {{-- mobile video --}}
                            <div class="row mt-2 d-block d-sm-block d-md-block d-lg-none d-xl-none">
                                <div class="col">
                                    <div class="listtourid select-display-slidev">
                                        @if($data->video && $data->video_cover)
                                        <li rel="1" class="active">
                                            <a href="javascript:void(0)">
                                                วีดีโอไฮไลท์ </a>
                                        </li>
                                        @endif
                                        @if($video_relate && count($video_relate) > 0)
                                        <li rel="2" @if(!$data->video && !$data->video_cover) class="active" @endif>
                                            <a href="javascript:void(0)">
                                                วีดีโอที่เกี่ยวข้อง </a>
                                        </li>
                                        @endif
                                    </div>
                                    @if($data->video && $data->video_cover)
                                    <div class="display-slidev" rel="1" style="display:block;">
                                        <div class="videogroupHilight mt-3">
                                            <a href="{{ @$data->video }}" data-fancybox="video-gallery"><img alt="" src="{{ asset($data->video_cover) }}"
                                                class="img-fluid"> <span><i class="bi bi-play-circle"></i></span></a>
                                        </div>
                                    </div>
                                    @endif
                                    @if($video_relate && count($video_relate) > 0)
                                    <div class="display-slidev" rel="2" @if(!$data->video && !$data->video_cover) style="display:block;" @else style="display:none;" @endif>
                                        <div class="row Cropscroll">
                                            @foreach($video_relate as $vr)
                                            <div class="col-lg-6">
                                                <div class="videogroupHilight mt-3">
                                                    <a href="{{$vr->link}}" data-fancybox="video-gallery"><img alt="" src="{{asset(@$vr->img)}}" 
                                                        class="img-fluid"> <span><i class="bi bi-play-circle"></i></span></a>
                                                </div>
                                                <div class="newslistgroup hoverstyle">
                                                    <h3>{{$vr->title}}</h3>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            {{-- mobile video --}}
                        </div>
                    </div>
                </div>
            </div>
            <section id="selectboxdate"><br>
            @if($period_date)
            <div class="row mt-2 mt-lg-0">
                <div class="col">
                    <div class="titletopic">
                        <h2>เลือกวันเดินทาง</h2>
                    </div>
                </div>
            </div>
            <div class="row mt-1">
                <div class="col-3 col-lg-2">
                    <div class="monthselect select-display-slide1">
                        @foreach ($period_date as $i => $ped)
                        <li class="@if($i == 0) active @endif" rel="{{$i}}" onclick="change_month('{{@$ped[0]['start_date']}}')" hash="#faq">
                            <a href="javascript:void(0)">
                                {{$month[date('n',strtotime($ped[0]['start_date']))]}} </a>
                        </li>
                        @endforeach
                    </div>
                </div>
                <div class="col-9 col-lg-5">
                    @foreach ($period_date as $i => $ped)
                    <div class="display-slide1" rel="{{$i}}" @if($i == 0) style="display:block;" @else style="display: none;" @endif>
                        <div class="calWH-BG">
                            <div id="calendar" class="calendar-{{$ped[0]['start_date']}}"></div>
                        </div>
                    </div>
                    @endforeach
                    <div class="display-slide">

                    </div>
                    <div class="explaincl mt-4">
                        <li><span class="available"></span> ว่าง จองได้เลย</li>
                        <li><span class="full"></span> เต็ม กรุณาติดต่อเจ้าหน้าที่</li>
                        <li><span class="choose"></span> คุณกำลังเลือก </li>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="priceperiodmb mt-3 mt-lg-0">
                        <div class="row bghead98">
                            <div class="col-8">
                                <input type="hidden" id="default_start_date" value="{{@$period_date[0][0]['start_date']}}">
                                <span id="period_change_date" class="mt-15">
                                    {{date('d',strtotime(@$period_date[0][0]['start_date']))}} {{$month[date('n',strtotime(@$period_date[0][0]['start_date']))]}} {{  date('y', strtotime('+543 Years', strtotime(@$period_date[0][0]['start_date']))) }}
                                    <i class="bi bi-arrow-right"></i> 
                                    {{date('d',strtotime(@$period_date[0][0]['end_date']))}} {{$month[date('n',strtotime(@$period_date[0][0]['end_date']))]}} {{  date('y', strtotime('+543 Years', strtotime(@$period_date[0][0]['end_date']))) }}
                                </span>
                                @if(@$period_date[0][0]['promotion_id'] && $period_date[0][0]['pro_start_date'] <= date('Y-m-d') && $period_date[0][0]['pro_end_date'] >= date('Y-m-d'))
                                @php
                                    $promotion = App\Models\Backend\PromotionModel::find(@$period_date[0][0]['promotion_id']);
                                    $promotion_tag = App\Models\Backend\PromotionTagModel::find(@$promotion->tag_id);
                                @endphp
                                <span id="promotion_change_date">
                                    {{-- <img src="{{ asset($promotion_tag->img) }}" alt=""> --}}
                                    <img src="{{asset('frontend/images/label/saletagcir.svg')}}" alt="">
                                    <br>
                                    <span class="endromotion">โปรโมชั่นสิ้นสุด {{date('d',strtotime($period_date[0][0]['pro_end_date']))}} {{$month[date('n',strtotime($period_date[0][0]['pro_end_date']))]}} {{  date('y', strtotime('+543 Years', strtotime($period_date[0][0]['pro_end_date']))) }}</span>
                                </span>
                                @endif
                            </div>
                            <div class="col-4" id="status_change_date">
                                @if(@$period_date[0][0]['status_period'] == 1)
                                    <a href="{{ url('/booking/'.$data->slug.'/'.@$period_date[0][0]['id'])}}" class="btn-submit">จองเลย</a>
                                @elseif(@$period_date[0][0]['status_period'] == 2)
                                    <a href="{{url('https://line.me/ti/p/'.@$contact->line_id)}}" class="btn bookline"><img src="{{ asset('frontend/images/line_add.svg') }}" alt=""> จองผ่านไลน์</a>
                                @elseif(@$period_date[0][0]['status_period'] == 3)
                                    <a href="javascrip:void(0);" class="btn soldoutbt">SOLD OUT</a>
                                @endif
                                {{-- <a href="#" class="btn bookline"><img src="{{asset('frontend/images/line_add.svg')}}" alt="">จองผ่านไลน์</a> --}}
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="boxfor345">
                                    <div class="row">
                                        <div class="col-6">
                                            <b>ผู้ใหญ่ (พัก2-3ท่าน)</b>
                                        </div>
                                        <div class="col-6 text-end">
                                            <div class="pricegroup" id="price1_change_date">
                                                @if(@$period_date[0][0]['special_price1'] > 0)
                                                    <span class="originalprice">{{ number_format(@$period_date[0][0]['price1'],0) }}</span>
                                                    <span class="saleprice">{{ number_format(@$period_date[0][0]['price1'] - @$period_date[0][0]['special_price1'],0) }}</span>
                                                @else
                                                    <span class="fullprice">{{ number_format(@$period_date[0][0]['price1'],0) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="boxfor345">
                                    <div class="row">
                                        <div class="col-6">
                                            <b> ผู้ใหญ่ (พักเดี่ยว)</b>
                                        </div>
                                        <div class="col-6 text-end">
                                            <div class="pricegroup" id="price2_change_date">
                                                @if(@$period_date[0][0]['special_price2'] > 0)
                                                    @php
                                                        $orignal_price = $period_date[0][0]['price1'] + $period_date[0][0]['price2'];
                                                        $sale_price = $orignal_price - @$period_date[0][0]['special_price2'];
                                                    @endphp
                                                    <span class="originalprice">{{ number_format(@$orignal_price,0) }}</span>
                                                    <span class="saleprice">{{ number_format(@$sale_price,0) }}</span>
                                                @else
                                                    <span class="fullprice">{{ number_format(@$period_date[0][0]['price1'] + @$period_date[0][0]['price2'],0) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="boxfor345">
                                    <div class="row">
                                        <div class="col-6">
                                            <b>เด็ก (ไม่มีเตียง)</b>
                                        </div>
                                        <div class="col-6 text-end">
                                            <div class="pricegroup" id="price4_change_date">
                                                @if(@$period_date[0][0]['special_price4'] > 0)
                                                    <span class="originalprice">{{ number_format(@$period_date[0][0]['price4'],0) }}</span>
                                                    <span class="saleprice">{{ number_format(@$period_date[0][0]['price4'] - @$period_date[0][0]['special_price4'],0) }}</span>
                                                @else
                                                    <span class="fullprice">{{ number_format(@$period_date[0][0]['price4'],0) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="boxfor345">
                                    <div class="row">
                                        <div class="col-6">
                                            <b> Group Size</b>
                                        </div>
                                        <div class="col-6 text-end" id="group_change_date">
                                            {{@$period_date[0][0]['group']}}
                                        </div>
                                    </div>
                                </div>

                                <div class="boxfor345">
                                    <div class="row">
                                        <div class="col-6">
                                            <b>จำนวนคงเหลือ</b>
                                        </div>
                                        <div class="col-6 text-end" id="count_change_date">
                                            {{@$period_date[0][0]['count']}}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            </section>
        </div>

        {{-- รายละเอียดทัวร์ --}}
        <div class="bgprogramdate mt-5">
            @if(json_decode($data->tour_detail))
            <div class="container">
                <div class="row pt-3">
                    <div class="col-lg-2">
                        <div class="titletopicdetails">
                            <h2>รายละเอียดทัวร์</h2>
                        </div>
                    </div>
                    <div class="col-lg-8 ps-lg-0">
                        <div class="detailssub">
                            {{ @$data->name }} {{ @$data->num_day }}
                            {{-- สายการบินแอร์เอเชียเอ๊กซ์ --}}
                        </div>
                    </div>
                </div>
                <div class="groupmenutour mt-4">
                    <div class="accordion" id="accordionExample">
                        @foreach(json_decode($data->tour_detail,true) as $i => $tour)
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{$i}}" @if($i == 0) aria-expanded="true" @else aria-expanded="false" @endif aria-controls="collapse{{$i}}">
                                    <div class="daycc">วันที่ {{ $i+1 }}</div>
                                    @foreach ($tour['header'] as $header)
                                    <div class="detaildate">{{ @$header }}</div>
                                    @endforeach

                                </button>
                            </h2>
                            <div id="collapse{{$i}}" class="accordion-collapse collapse @if($i == 0) show @endif"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="accordion-body">
                                        <div class="tourdetails_days">
                                            @if(isset($tour['sub']))
                                                @foreach ($tour['sub'] as $subItem)
                                                <div class="row mb-3">
                                                    <div class="col-4 col-lg-2">
                                                        <img src="{{asset($subItem['image'])}}" class="img-fluid" alt="">
                                                    </div>
                                                    <div class="col-8 col-lg-10">
                                                        <h3>{{ $subItem['time'] }}</h3>
                                                        <h4>{{ $subItem['title'] }}</h4>
                                                        {{ $subItem['detail'] }}
                                                    </div>
                                                </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="row mt-4 mb-4">
                        <div class="col text-center">
                            @if(@$data->pdf_file)
                            <a href="{{ asset(@$data->pdf_file)}}" class="btn btn-border"><i class="bi bi-file-earmark-pdf-fill"></i>
                                ดาวน์โหลดโปรแกรมทัวร์ PDF</a>
                            @endif
                            @if(@$data->word_file)
                            <a href="{{ asset(@$data->word_file)}}" class="btn btn-border ml-2"><i class="bi bi-file-earmark-word-fill"></i>
                                ดาวน์โหลดโปรแกรมทัวร์ Word</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        {{-- รายละเอียดทัวร์ --}}

        {{-- ช่วงวันเดินทาง --}}
        @if($period_date)
        <div class="container">
            <div class="row mt-2 mt-lg-5">
                <div class="col">
                    <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block ">
                        <div class="tableboxgroups">
                            <div class="row">
                                <div class="col-lg-2">
                                    <h4>ช่วงวันเดินทาง</h4>
                                </div>
                                <div class="col-lg-4 ps-lg-0">
                                    <div class="timeperiodmonth select-display-slide2">
                                        @foreach ($period_date as $i => $ped)
                                        <li rel="{{$i}}" class="@if($i == 0) active @endif">
                                            <a href="javascript:void(0)">
                                                {{$month[date('n',strtotime($ped[0]['start_date']))]}} </a>
                                        </li>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="tableprice">
                                @foreach ($period_date as $i => $ped)
                                <div class="display-slide2" rel="{{$i}}" @if($i == 0) style="display:block;" @else style="display:none;" @endif>
                                    <table class="table">
                                        <thead>
                                            <th>เลือกวันที่เดินทางและกดจอง:</th>
                                            <th>ผู้ใหญ่ (พัก2-3ท่าน)</th>
                                            <th>ผู้ใหญ่ (พักเดี่ยว)</th>
                                            <th>เด็ก (ไม่มีเตียง)</th>
                                            <th>Group Size</th>
                                            <th>จำนวนคงเหลือ</th>
                                            <th></th>
                                        </thead>
                                        <tbody>
                                            @php
                                                $period_show = \App\Models\Backend\TourPeriodModel::where(['tour_id'=>@$data->id,'status_display'=>'on','group_date'=>$ped[0]['group_date']])->whereDate('start_date','>=',now())->orderby('start_date','asc')->whereNull('deleted_at')->get();
                                            @endphp
                                            @foreach($period_show as $p)
                                            @php
                                                $promotion = App\Models\Backend\PromotionModel::find(@$p->promotion_id);
                                                $promotion_tag = App\Models\Backend\PromotionTagModel::find(@$promotion->tag_id);
                                            @endphp
                                            <tr>
                                                <td>
                                                    {{date('d',strtotime($p->start_date))}} {{$month[date('n',strtotime($p->start_date))]}} {{  date('y', strtotime('+543 Years', strtotime($p->start_date))) }} 
                                                    <i class="bi bi-arrow-right"></i>
                                                    {{date('d',strtotime($p->end_date))}} {{$month[date('n',strtotime($p->end_date))]}} {{  date('y', strtotime('+543 Years', strtotime($p->end_date))) }}
                                                    @if($promotion && $p->pro_start_date <= date('Y-m-d') && $p->pro_end_date >= date('Y-m-d'))
                                                        @if(@$promotion_tag->img)
                                                        <img src="{{ asset(@$promotion_tag->img) }}" alt="" style="width: 40px; height:40px; position:absolute;">
                                                        @endif
                                                        <br>
                                                        <span class="endromotion">โปรโมชั่นสิ้นสุด {{date('d',strtotime($p->pro_end_date))}} {{$month[date('n',strtotime($p->pro_end_date))]}} {{  date('y', strtotime('+543 Years', strtotime($p->pro_end_date))) }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="pricegroup">
                                                        @if($p->special_price1 > 0)
                                                            <span class="originalprice">{{ number_format(@$p->price1,0) }}</span> <br>
                                                            <span class="saleprice">{{ number_format(@$p->price1 - $p->special_price1,0) }}</span>
                                                        @else
                                                            <span class="fullprice">{{ number_format(@$p->price1,0) }}</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="pricegroup">
                                                        @if($p->special_price2 > 0)
                                                            @php
                                                                $orignal_price = $p->price1 + $p->price2;
                                                                $sale_price = $orignal_price - $p->special_price2;
                                                            @endphp
                                                            <span class="originalprice">{{ number_format(@$orignal_price,0) }}</span> <br>
                                                            <span class="saleprice">{{ number_format(@$sale_price,0) }}</span>
                                                        @else
                                                            <span class="fullprice">{{ number_format(@$p->price1 + @$p->price2,0) }}</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="pricegroup">
                                                        @if($p->special_price4 > 0)
                                                            <span class="originalprice">{{ number_format(@$p->price4,0) }}</span> <br>
                                                            <span class="saleprice">{{ number_format(@$p->price4 - $p->special_price4,0) }}</span>
                                                        @else
                                                            <span class="fullprice">{{ number_format(@$p->price4,0) }}</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>{{ @$p->group }}</td>
                                                <td>{{ @$p->count }}</td>
                                                <td> 
                                                    @if($p->status_period == 1)
                                                        <div class="col-lg-12">
                                                            <a href="{{ url('/booking/'.$data->slug.'/'.$p->id)}}" class="btn-submit">จองเลย</a>
                                                        </div>
                                                    @elseif($p->status_period == 2)
                                                        <a href="{{url('https://line.me/ti/p/'.@$contact->line_id)}}" class="btn bookline"><img src="{{ asset('frontend/images/line_add.svg') }}" alt=""> จองผ่านไลน์</a>
                                                    @elseif($p->status_period == 3)
                                                        <div class="col-lg-12">
                                                            <a href="javascrip:void(0);" class="soldoutbt">SOLD OUT</a>
                                                        </div>
                                                    @else
                                                        <center> - </center>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                    {{-- mobile ช่วงวันเดินทาง --}}
                    <div class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
                        <div class="row tableboxgroups">
                            <div class="col-lg-2 g-0">
                                <h4>ช่วงวันเดินทาง</h4>
                            </div>
                            <div class="col-lg-4 ps-0">
                                <div class="timeperiodmonth select-display-slide2">
                                    @foreach ($period_date as $i => $ped)
                                    <li rel="{{$i}}" class="@if($i == 0) active @endif">
                                        <a href="javascript:void(0)">
                                            {{$month[date('n',strtotime($ped[0]['start_date']))]}} </a>
                                    </li>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @foreach ($period_date as $i => $ped)
                        <div class="display-slide2" rel="{{$i}}" @if($i == 0) style="display:block;" @else style="display:none;" @endif>
                            @php
                                $period_show = \App\Models\Backend\TourPeriodModel::where(['tour_id'=>@$data->id,'status_display'=>'on','group_date'=>$ped[0]['group_date']])->whereDate('start_date','>=',now())->orderby('start_date','asc')->whereNull('deleted_at')->get();
                            @endphp
                            @foreach($period_show as $p)
                            @php
                                $promotion = App\Models\Backend\PromotionModel::find(@$p->promotion_id);
                                $promotion_tag = App\Models\Backend\PromotionTagModel::find(@$promotion->tag_id);
                            @endphp
                            <div class="priceperiodmb">
                                <div class="row bghead98">
                                    <div class="col-8">
                                        {{date('d',strtotime($p->start_date))}} {{$month[date('n',strtotime($p->start_date))]}} {{  date('y', strtotime('+543 Years', strtotime($p->start_date))) }}
                                        <i class="bi bi-arrow-right"></i> 
                                        {{date('d',strtotime($p->end_date))}} {{$month[date('n',strtotime($p->end_date))]}} {{  date('y', strtotime('+543 Years', strtotime($p->end_date))) }}
                                        @if($promotion && $p->pro_start_date <= date('Y-m-d') && $p->pro_end_date >= date('Y-m-d'))
                                            @if(@$promotion_tag->img)
                                            <img src="{{ asset(@$promotion_tag->img) }}" alt="">
                                            @endif
                                            <br>
                                            <span class="endromotion">โปรโมชั่นสิ้นสุด {{date('d',strtotime($p->pro_end_date))}} {{$month[date('n',strtotime($p->pro_end_date))]}} {{  date('y', strtotime('+543 Years', strtotime($p->pro_end_date))) }}</span>
                                        @endif
                                    </div>
                                    <div class="col-4">
                                        @if($p->status_period == 1)
                                            <a href="{{ url('/booking/'.$data->slug.'/'.$p->id)}}" class="btn-submit">จองเลย</a>
                                        @elseif($p->status_period == 2)
                                            <a href="{{url('https://line.me/ti/p/'.@$contact->line_id)}}" class="btn bookline"><img src="{{ asset('frontend/images/line_add.svg') }}" alt=""> จองผ่านไลน์</a>
                                        @elseif($p->status_period == 3)
                                            <a href="javascrip:void(0);" class="soldoutbt">SOLD OUT</a>
                                        @else
                                            <center> - </center>
                                        @endif
                                        {{-- <a href="#" class="soldoutbt">SOLD OUT</a> --}}
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="boxfor345">
                                            <div class="row">
                                                <div class="col-6">
                                                    <b>ผู้ใหญ่ (พัก2-3ท่าน)</b>
                                                </div>
                                                <div class="col-6 text-end">
                                                    <div class="pricegroup">
                                                        @if($p->special_price1 > 0)
                                                            <span class="originalprice">{{ number_format(@$p->price1,0) }}</span> <br>
                                                            <span class="saleprice">{{ number_format(@$p->price1 - $p->special_price1,0) }}</span>
                                                        @else
                                                            <span class="fullprice">{{ number_format(@$p->price1,0) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="boxfor345">
                                            <div class="row">
                                                <div class="col-6">
                                                    <b>ผู้ใหญ่ (พักเดี่ยว)</b>
                                                </div>
                                                <div class="col-6 text-end">
                                                    <div class="pricegroup">
                                                        @if($p->special_price2 > 0)
                                                            @php
                                                                $orignal_price = $p->price1 + $p->price2;
                                                                $sale_price = $orignal_price - $p->special_price2;
                                                            @endphp
                                                            <span class="originalprice">{{ number_format(@$orignal_price,0) }}</span> <br>
                                                            <span class="saleprice">{{ number_format(@$sale_price,0) }}</span>
                                                        @else
                                                            <span class="fullprice">{{ number_format(@$p->price1 + @$p->price2,0) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="boxfor345">
                                            <div class="row">
                                                <div class="col-6">
                                                    <b>เด็ก (ไม่มีเตียง)</b>
                                                </div>
                                                <div class="col-6 text-end">
                                                    <div class="pricegroup">
                                                        @if($p->special_price4 > 0)
                                                            <span class="originalprice">{{ number_format(@$p->price4,0) }}</span> <br>
                                                            <span class="saleprice">{{ number_format(@$p->price4 - $p->special_price4,0) }}</span>
                                                        @else
                                                            <span class="fullprice">{{ number_format(@$p->price4,0) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="boxfor345">
                                            <div class="row">
                                                <div class="col-6">
                                                    <b> Group Size</b>
                                                </div>
                                                <div class="col-6 text-end">
                                                    {{ @$p->group }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="boxfor345">
                                            <div class="row">
                                                <div class="col-6">
                                                    <b>จำนวนคงเหลือ</b>
                                                </div>
                                                <div class="col-6 text-end">
                                                    {{ @$p->count }}
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                    {{-- mobile ช่วงวันเดินทาง --}}
                </div>
            </div>
            @if($tour_nearby && count($tour_nearby) > 0)
            <div class="row mt-5">
                <div class="col">
                    <div class="titletopic">
                        <h2>โปรแกรมใกล้เคียง</h2>
                    </div>
                </div>
            </div>
            <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                <div class="row mt-3">
                    @foreach($tour_nearby as $tn)
                        @php
                            $tn_country = \App\Models\Backend\CountryModel::whereIn('id',json_decode(@$tn->country_id,true))->first();
                            $tn_airline = \App\Models\Backend\TravelTypeModel::find(@$tn->airline_id);
                            $tn_period = \App\Models\Backend\TourPeriodModel::where(['tour_id'=>@$tn->id,'status_display'=>'on'])->whereDate('start_date','>=',now())->where('count','>',0)->orderby('start_date','asc')->whereNull('deleted_at')->get()->groupby('group_date');
                        @endphp
                        <div class="col-6 col-lg-3 @if(count($tn_period) == 0)d-none @endif">
                            <div class="showvertiGroup">
                                <div class="boxwhiteshd hoverstyle">
                                    <figure>
                                        <a href="{{url('tour/'.@$tn->slug)}}">
                                            <img src="{{ asset(@$tn->image) }}" alt="">
                                        </a>
                                    </figure>
                                    {{-- <div class="tagontop">
                                        <li class="bgor"><a>{{@$tn->num_day}}</a> </li>
                                        <li class="bgblue"><a><i class="fi fi-rr-marker"></i> {{@$tn_country->country_name_th}}</a></li>
                                        <li>
                                            สายการบิน <img src="{{asset(@$tn_airline->image)}}" alt="">
                                        </li>
                                    </div> --}}
                                    <div class="contenttourshw">
                                        <div class="codeandhotel">
                                            <li>รหัสทัวร์ : <span class="bluetext">@if(@$tn->code1_check) {{@$tn->code1}} @else {{@$tn->code}} @endif</span> </li>
                                            <li class="rating">โรงแรม 
                                                @for($i=1; $i <= @$tn->rating; $i++)
                                                    <i class="bi bi-star-fill"></i>
                                                @endfor
                                            </li>
                                        </div>
                                        <hr>
                                        <div class="locationnewd mb-2 mt-2">
                                            <li> <a> <i class="fi fi-rr-marker"></i> {{@$tn_country->country_name_th}}</a></li>
                                            <li class="datetour"><a>{{$tn->num_day}}</a> </li>
                                            <li class="airlines"> 
                                                สายการบิน <img src="{{asset(@$tn_airline->image)}}" alt=""> 
                                            </li>
                                        </div>
                                        <h3> <a href="{{url('tour/'.@$tn->slug)}}"> {{@$tn->name}}</a> </h3>
                                        <div class="listperiod">
                                            @foreach($tn_period as $tpe)
                                            <li>
                                                <span class="month">{{$month[date('n',strtotime($tpe[0]->start_date))]}}</span>
                                                @php $toEnd = count($tpe);  @endphp
                                                @foreach($tpe as $key => $p)
                                                    {{date('d',strtotime($p->start_date))}} - {{date('d',strtotime($p->end_date))}} @if(0 !== --$toEnd)/@endif
                                                @endforeach
                                            </li><br>
                                            @endforeach
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <div class="pricegroup">
                                                    @if($tn->special_price > 0)
                                                    @php $tn_price = $tn->price - $tn->special_price; @endphp
                                                        <span class="originalprice">ปกติ {{ number_format($tn->price,0) }} </span><br>
                                                        เริ่ม<span class="saleprice"> {{ number_format(@$tn_price,0) }} บาท</span>
                                                    @else
                                                        <span class="saleprice"> {{ number_format($tn->price,0) }} บาท</span>
                                                    @endif
                                                </div>

                                            </div>
                                            <div class="col-lg-5 ps-0">
                                                <a href="{{url('tour/'.@$tn->slug)}}" class="btn-main-og morebtnog">รายละเอียด</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
                <div class="Cropscroll pb-2">
                    @foreach($tour_nearby as $tn)
                        @php
                            $tn_country = \App\Models\Backend\CountryModel::whereIn('id',json_decode(@$tn->country_id,true))->first();
                            $tn_airline = \App\Models\Backend\TravelTypeModel::find(@$tn->airline_id);
                            $tn_period = \App\Models\Backend\TourPeriodModel::where(['tour_id'=>@$tn->id,'status_display'=>'on'])->whereDate('start_date','>=',now())->orderby('start_date','asc')->whereNull('deleted_at')->get()->groupby('group_date');
                        @endphp
                        <div class="showhoriMB">
                            <div class="hoverstyle">
                                <div class="row">
                                    <div class="col-5 pe-0">
                                        <div class="imagestourid">
                                            <figure>
                                                <a href="{{url('tour/'.@$tn->slug)}}">
                                                    <img src="{{ asset(@$tn->image) }}" class="img-fluid" alt="">
                                                </a>
                                            </figure>
                                            @if(@$tn->special_price > 0)
                                            <div class="saleonpicbox">
                                                <span> ลดพิเศษ</span> <br>
                                                {{ number_format($tn->special_price,0) }} บาท
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-7 ps-2">
                                        <div class="contenttourshw">
                                            <div class="codeandhotel">
                                                <li>รหัสทัวร์ : <span class="bluetext">@if(@$tn->code1_check) {{@$tn->code1}} @else {{@$tn->code}} @endif</span>
                                                </li>
                                            </div>
                                            <hr>
                                            <a href="{{url('tour/'.@$tn->slug)}}" class="namess"> {{@$tn->name}}</a>
                                            <div class="listindetail_mb">
                                                <li>{{@$tn->num_day}}</li>
                                                <li><img src="{{asset(@$tn_airline->image)}}" alt=""></li>
                                                <li class="ratingid">
                                                    @for($i=1; $i <= @$tn->rating; $i++)
                                                        <i class="bi bi-star-fill"></i>
                                                    @endfor
                                                </li>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            @php
                $tagIds = json_decode($data->tag_id);

                if($tagIds){
                    $tour_tag = App\Models\Backend\TourModel::whereNull('deleted_at')
                    ->where('status','on')
                    ->where('id','!=',$data->id)
                    ->where(function ($query) use ($tagIds) {
                        foreach ($tagIds as $tagId) {
                            $query->orWhereJsonContains('tag_id', $tagId);
                        }
                    })
                    ->orderBy('id','desc')
                    ->limit(8)
                    ->get();
                }else{
                    $tour_tag = null;
                }
            @endphp
            @if($tour_tag && count($tour_tag) > 0)
            <div class="row mt-3">
                <div class="col">
                    <div class="titletopic">
                        <h2>คนที่ดูทัวร์นี้ยังดูทัวร์เหล่านี้ด้วย</h2>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="tagcat02">
                    @foreach($tag as $t)
                        <li><a href="{{url('/search-tour')}}?tag={{$t->id}}" {{-- onclick="Filter_tag({{$t->id}})" --}}>#{{ @$t->tag }}</a></li>
                    @endforeach
                </div>
            </div>
            <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                <div class="row mt-3">
                    @foreach($tour_tag as $tr)
                        @php
                            $tr_country = \App\Models\Backend\CountryModel::whereIn('id',json_decode(@$tr->country_id,true))->first();
                            $tr_airline = \App\Models\Backend\TravelTypeModel::find(@$tr->airline_id);
                            $tr_period = \App\Models\Backend\TourPeriodModel::where(['tour_id'=>@$tr->id,'status_display'=>'on'])->whereDate('start_date','>=',now())->orderby('start_date','asc')->whereNull('deleted_at')->get();
                            $count_pe = count($tr_period);
                            $tr_period = $tr_period->groupby('group_date');
                        @endphp
                        <div class="col-6 col-lg-3 @if($count_pe == 0)) d-none @endif">
                            <div class="showvertiGroup">
                                <div class="boxwhiteshd hoverstyle">
                                    <figure>
                                        <a href="{{url('tour/'.@$tr->slug)}}">
                                            <img src="{{asset(@$tr->image)}}" alt="">
                                        </a>
                                    </figure>
                                    {{-- <div class="tagontop">
                                        <li class="bgor"><a>{{@$tr->num_day}}</a> </li>
                                        <li class="bgblue"><a><i class="fi fi-rr-marker"></i> {{@$tr_country->country_name_th}}</a></li>
                                        <li>
                                            สายการบิน <img src="{{asset(@$tr_airline->image)}}" alt="">
                                        </li>
                                    </div> --}}
                                    <div class="contenttourshw">
                                        <div class="codeandhotel">
                                            <li>รหัสทัวร์ : <span class="bluetext">@if(@$tr->code1_check) {{@$tr->code1}} @else {{@$tr->code}} @endif</span> </li>
                                            <li class="rating">โรงแรม 
                                                @for($i=1; $i <= @$tr->rating; $i++)
                                                    <i class="bi bi-star-fill"></i>
                                                @endfor
                                            </li>

                                        </div>
                                        <hr>
                                        <div class="locationnewd mb-2 mt-2">
                                            <li> <a> <i class="fi fi-rr-marker"></i> {{@$tr_country->country_name_th}}</a></li>
                                            <li class="datetour"><a>{{$tr->num_day}}</a> </li>
                                            <li class="airlines"> 
                                                สายการบิน <img src="{{asset(@$tr_airline->image)}}" alt=""> 
                                            </li>
                                        </div>
                                        <h3> <a href="{{url('tour/'.@$tr->slug)}}"> {{@$tr->name}}</a> </h3>
                                        <div class="listperiod">
                                            @foreach($tr_period as $tpe)
                                            <li>
                                                <span class="month">{{$month[date('n',strtotime($tpe[0]->start_date))]}}</span>
                                                @php $toEnd = count($tpe);  @endphp
                                                @foreach($tpe as $key => $p)
                                                    {{date('d',strtotime($p->start_date))}} - {{date('d',strtotime($p->end_date))}} @if(0 !== --$toEnd)/@endif
                                                @endforeach
                                            </li><br>
                                            @endforeach
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <div class="pricegroup">
                                                    @if($tr->special_price > 0)
                                                    @php $tr_price = $tr->price - $tr->special_price; @endphp
                                                        <span class="originalprice">ปกติ {{ number_format($tr->price,0) }} </span><br>
                                                        เริ่ม<span class="saleprice"> {{ number_format(@$tr_price,0) }} บาท</span>
                                                    @else
                                                        <span class="saleprice"> {{ number_format($tr->price,0) }} บาท</span>
                                                    @endif
                                                </div>

                                            </div>
                                            <div class="col-lg-5 ps-0">
                                                <a href="{{url('tour/'.@$tr->slug)}}" class="btn-main-og morebtnog">รายละเอียด</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
                <div class="Cropscroll pb-2">
                    @foreach($tour_tag as $tr)
                        @php
                            $tr_country = \App\Models\Backend\CountryModel::whereIn('id',json_decode(@$tr->country_id,true))->first();
                            $tr_airline = \App\Models\Backend\TravelTypeModel::find(@$tr->airline_id);
                            $tr_period = \App\Models\Backend\TourPeriodModel::where(['tour_id'=>@$tr->id,'status_display'=>'on'])->whereDate('start_date','>=',now())->orderby('start_date','asc')->whereNull('deleted_at')->get()->groupby('group_date');
                        @endphp
                        <div class="showhoriMB">
                            <div class="hoverstyle">
                                <div class="row">
                                    <div class="col-5 pe-0">
                                        <div class="imagestourid">
                                            <figure>
                                                <a href="{{url('tour/'.@$tr->slug)}}">
                                                    <img src="{{ asset(@$tr->image) }}" class="img-fluid" alt="">
                                                </a>
                                            </figure>
                                            @if(@$tr->special_price > 0)
                                            <div class="saleonpicbox">
                                                <span> ลดพิเศษ</span> <br>
                                                {{ number_format($tr->special_price,0) }} บาท
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-7 ps-2">
                                        <div class="contenttourshw">
                                            <div class="codeandhotel">
                                                <li>รหัสทัวร์ : <span class="bluetext">@if(@$tr->code1_check) {{@$tr->code1}} @else {{@$tr->code}} @endif</span>
                                                </li>
                                            </div>
                                            <hr>
                                            <a href="{{url('tour/'.@$tr->slug)}}" class="namess">{{@$tr->name}}</a>
                                            <div class="listindetail_mb">
                                                <li>{{@$tr->num_day}}</li>
                                                <li><img src="{{asset(@$tr_airline->image)}}" alt=""></li>
                                                <li class="ratingid">
                                                    @for($i=1; $i <= @$tr->rating; $i++)
                                                        <i class="bi bi-star-fill"></i>
                                                    @endfor
                                                </li>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            @php
                if($cityIds){
                    $tour_review = App\Models\Backend\ThankInfoModel::where('status','on')
                    ->where(function ($query) use ($cityIds) {
                        foreach ($cityIds as $cityId) {
                            $query->orWhereJsonContains('city_id', $cityId);
                        }
                    })
                    ->get();
                }else{
                    $tour_review = null;
                }
            @endphp
            @if($tour_review && count($tour_review) > 0)
            <div class="row mt-3">
                <div class="col">
                    <div class="titletopic">
                        <h2>รีวิวลูกค้าในเส้นทางนี้</h2>
                    </div>
                </div>
            </div>
            <div class="row mt-4 mb-5">
                @foreach($tour_review as $tre)
                @php
                    $tre_country = \App\Models\Backend\CountryModel::whereIn('id',json_decode(@$tre->country_id,true))->get();
                @endphp
                <div class="col-6 col-lg-3">
                    <div class="clssgroup hoverstyle">
                        <figure>
                            <a href="{{ url('/clients-review') }}">
                                <img src="{{asset(@$tre->img)}}" alt="">
                            </a>
                        </figure>
                        <h3><a href="{{ url('/clients-review') }}"> {{$tre->title}}</a></h3>
                        <p>{!! $tre->detail !!}</p>

                        <div class="tagcat02 mt-3">
                            @foreach($tre_country as $co) 
                                <li><a href="{{ url('/oversea/'.$co->slug) }}">#{{@$co->country_name_th}}</a></li>
                            @endforeach
                        </div>
                        <hr>
                        <div class="groupshowname">
                            <div class="clleft">
                                <div class="clientpic">
                                    <img src="{{asset(@$tre->profile)}}" alt="">
                                </div>
                            </div>
                            <div class="clientname">
                                <span class="orgtext">{{@$tre->name}}</span>
                                <br>
                                {{@$tre->trip}}</div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
        @endif
        {{-- ช่วงวันเดินทาง --}}

    </section>
    @include("frontend.layout.inc_footer")
    <script>
        var default_start_date = document.getElementById('default_start_date').value;

        window.onload = function() {
            recordPageView({{$data->id}});
            change_month(default_start_date);
            setInitialLikedStatus();
        };

        @php
            echo "var period = $period_all_encode;";
            echo "var month_th = $month_th;";
        @endphp

        function recordPageView(id) {
            setTimeout(() => {
                $.ajax({
                    type: "POST",
                    url: '{{ url("/record-country-view")}}',
                    data: {
                        _token:"{{ csrf_token() }}",
                        id:id,
                    },
                    success: function(){
                        console.log('Page view recorded successfully');
                    }
                });
            }, 10000); // 10 วิ
        };

        var notAvailable = {};
        var available = {};

        {!! json_encode($period_all) !!}.forEach(function(item) {
            var dateParts = item.start_date.split('-');
            var formattedDate = dateParts[2] + '/' + dateParts[1] + '/' + dateParts[0];
            if(item.status_period == 3){
                notAvailable[formattedDate] = 'ไม่ว่าง';
            }else{
                available[formattedDate] = 'ว่าง';
            }
        });

        function formatDateTh(date) {
            var d = new Date(date),
                month = ' ' + month_th[d.getMonth()+1] + ' ',
                day = '' + d.getDate(),
                year = (d.getFullYear()+543) - 2500;


            return day + month + year;
        }

        function dateNow() {
            var currentDate = new Date();
            var year = currentDate.getFullYear();
            var month = String(currentDate.getMonth() + 1).padStart(2, '0'); // เพิ่ม 1 เนื่องจากเดือนเริ่มจาก 0
            var day = String(currentDate.getDate()).padStart(2, '0');
            var formattedDate = year + '-' + month + '-' + day;

            return formattedDate;
        }

        function formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2) month = '0' + month;
            if (day.length < 2) day = '0' + day;

            return [day, month, year].join('/');
        }

        function pad(str, max) {
            str = str.toString();
            return str.length < max ? pad("0" + str, max) : str;
        }

        function change_month(start_date) {
            // $('.monthselect li').removeClass('active');
            // $('[rel="' + start_date + '"]').addClass('active');
            // $('.display-slide').hide();
            // $('[rel="' + start_date + '"]').fadeIn();

            setupDatepicker(start_date);

            addCustomH();
        }

        function setupDatepicker(selectedDate) {
            $('.calendar-'+selectedDate).datepicker({
                inline: true,
                firstDay: 0,
                showOtherMonths: true,
                setMonthFront: new Date(selectedDate),
                // setMonthFront: new Date().setMonth(5),
                dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                beforeShow: addCustomH,
                onChangeMonthYear: addCustomH,
                onSelect: function (dateString) {
                    var dateSel = period.find(x => x.start_date == dateString);
                    if(dateSel){
                        $('#period_change_date').html(formatDateTh(dateSel.start_date) + ' <i class="bi bi-arrow-right"></i> ' + formatDateTh(dateSel.end_date));
                        if(dateSel.promotion_id && dateSel.pro_start_date <= dateNow() && dateSel.pro_end_date >= dateNow()){
                            $('#promotion_change_date').html('<img src="{{asset('frontend/images/label/saletagcir.svg')}}" alt=""><br><span class="endromotion">โปรโมชั่นสิ้นสุด ' + formatDateTh(dateSel.pro_end_date) + '</span>');
                        }else{
                            $('#promotion_change_date').html(null);
                        }

                        if(dateSel.status_period == 1){
                            var url = '{{ url("/booking/$data->slug") }}/' + dateSel.id;
                            $('#status_change_date').html('<a href="'+ url +'" class="btn-submit">จองเลย</a>');
                        }else if(dateSel.status_period == 2){
                            var url = '{{url('https://line.me/ti/p/'.@$contact->line_id)}}';
                            $('#status_change_date').html('<a href="'+ url +'" target="_blank" class="btn bookline"><img src="{{ asset('frontend/images/line_add.svg') }}" alt=""> จองผ่านไลน์</a>');
                        }else if(dateSel.status_period == 3){
                            $('#status_change_date').html('<a href="javascrip:void(0);" class="btn soldoutbt">SOLD OUT</a>');
                        }

                        if(dateSel.special_price1 > 0){
                            var originalPrice = parseFloat(dateSel.price1).toLocaleString();
                            var salePrice = (parseFloat(dateSel.price1) - parseFloat(dateSel.special_price1)).toLocaleString();
                            $('#price1_change_date').html('<span class="originalprice">'+originalPrice +'</span><span class="saleprice">'+salePrice+'</span>');
                        }else{
                            var originalPrice = parseFloat(dateSel.price1).toLocaleString();
                            $('#price1_change_date').html('<span class="fullprice">'+originalPrice+'</span>');
                        }

                        if(dateSel.special_price2 > 0){
                            var originalPrice = (parseFloat(dateSel.price1) + parseFloat(dateSel.price2));
                            var salePrice = (originalPrice - parseFloat(dateSel.special_price2)).toLocaleString();
                            $('#price2_change_date').html('<span class="originalprice">'+originalPrice.toLocaleString() +'</span><span class="saleprice">'+salePrice+'</span>');
                        }else{
                            var originalPrice = (parseFloat(dateSel.price1) + parseFloat(dateSel.price2));
                            $('#price2_change_date').html('<span class="fullprice">'+originalPrice.toLocaleString()+'</span>');
                        }
                        
                        if(dateSel.special_price4 > 0){
                            var originalPrice = parseFloat(dateSel.price4).toLocaleString();
                            var salePrice = (parseFloat(dateSel.price4) - parseFloat(dateSel.special_price4)).toLocaleString();
                            $('#price4_change_date').html('<span class="originalprice">'+originalPrice +'</span><span class="saleprice">'+salePrice+'</span>');
                        }else{
                            var originalPrice = parseFloat(dateSel.price4).toLocaleString();
                            $('#price4_change_date').html('<span class="fullprice">'+originalPrice+'</span>');
                        }

                        $('#group_change_date').html(dateSel.group);
                        $('#count_change_date').html(dateSel.count);
                        
                    }

                    setTimeout(function () {
                        var uisdw = 46.666666666666664;
                        // var uisdw = $('.ui-state-default').outerWidth() / 1.5;
                        $('.ui-state-default').css("line-height", uisdw + "px");
                        $(".ui-state-default").tooltip();
                    }, 0)

                },
                beforeShowDay: function (date) {
                    var day = date.getDate();
                    var month = date.getMonth() + 1;
                    var year = date.getFullYear();
                    var dateString = pad(day, 2) + '/' + pad(month, 2) + '/' + year;

                    if (dateString in notAvailable) {
                        return [true, 'event', notAvailable[dateString]];
                    }else if (dateString in available) {
                        return [true, 'holiday', available[dateString]];
                    } else {
                        return [true, '', ''];
                    }
                }
            });
        }

        function addCustomH() {
            setTimeout(function () {
                var uisdw = 46.666666666666664;
                // var uisdw = $('.ui-state-default').outerWidth() / 1.5;
                $('.ui-state-default').css("line-height", uisdw + "px");
                $(".ui-state-default").tooltip();
            }, 0)
        }

        function Filter_tag(id){
            let payload = {
                _token: '{{csrf_token()}}',
                tag: id,
            }
            $.ajax({
                type: 'POST',
                url: '{{url("/search-tour")}}',
                data: payload,
                success: function (data) {
                    window.location.href = "{{url('/search-tour')}}?tag=" + id;
                }
            });
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            var bigimage = $("#big");
            var thumbs = $("#thumbs");
            //var totalslides = 10;
            var syncedSecondary = false;

            bigimage
                .owlCarousel({
                    items: 1,
                    slideSpeed: 3500,
                    smartSpeed: 1500,
                    nav: true,
                    navText: ['<img src="{{asset('frontend/images/arrowRight.svg')}}">', '<img src="{{asset('frontend/images/arrowLeft.svg')}}">'],
                    navClass: ['owl-prev', 'owl-next'],
                    autoplay: false,
                    dots: false,
                    loop: false,
                    responsiveRefreshRate: 200,
                    responsive: {
                        0: {
                            items: 1,
                            nav: false
                        },
                        640: {
                            items: 1,
                            nav: false
                        },
                        1024: {
                            items: 1
                        },
                        1200: {
                            items: 1
                        }
                    }

                })
                .on("changed.owl.carousel", syncPosition);
            thumbs
                .on("initialized.owl.carousel", function () {
                    thumbs
                        .find(".owl-item")
                        .eq(0)
                        .addClass("current");
                })
                .owlCarousel({
                    items: 4,
                    margin: 10,
                    dots: false,
                    nav: false,
                    smartSpeed: 200,
                    slideSpeed: 1500,
                    slideBy: 1,
                    responsiveRefreshRate: 100,
                    responsive: {
                        0: {
                            items: 4,
                            margin: 6
                        },
                        640: {
                            items: 4,
                            margin: 6
                        },
                        1024: {
                            items: 4
                        },
                        1200: {
                            items: 6
                        }
                    }
                })
                .on("changed.owl.carousel", syncPosition2);

            function syncPosition(el) {

                // console.log(el);
                //if loop is set to false, then you have to uncomment the next line
                //var current = el.item.index;

                //to disable loop, comment this block
                var count = el.item.count - 1;

                var current = Math.round(el.item.index - el.item.count / 2 - 0.5);
                if (current < 0) {
                    current = count;
                }
                if (current > count) {
                    current = 0;
                }
                //to this
                // console.log(count + " " + current);
                thumbs
                    .find(".owl-item")
                    .removeClass("current")
                    .eq(el.item.index)
                    .addClass("current");

                var onscreen = thumbs.find(".owl-item.active").length - 1;
                var start = thumbs
                    .find(".owl-item.active")
                    .first()
                    .index();
                var end = thumbs
                    .find(".owl-item.active")
                    .last()
                    .index();

                if (current > end) {
                    thumbs.data("owl.carousel").to(current, 100, false);
                }
                if (current < start) {
                    thumbs.data("owl.carousel").to(current - onscreen, 100, false);
                }
            }

            function syncPosition2(el) {
                if (syncedSecondary) {
                    var number = el.item.index;
                    bigimage.data("owl.carousel").to(number, 100, false);
                }
            }
            thumbs.on("click", ".owl-item", function (e) {
                e.preventDefault();
                var number = $(this).index();
                bigimage.data("owl.carousel").to(number, 300, false);
            });

            $(".select-display-slidev > li").click(function() {
				var rel = $(this).attr("rel");
				$('.display-slidev').hide();
				$('.display-slidev[rel=' + rel + ']').fadeIn();
				$(".select-display-slidev > li").removeClass("active");
				$(this).addClass("active");
			});

            $(".select-display-slide1 > li").click(function() {
				var rel = $(this).attr("rel");
				$('.display-slide1').hide();
				$('.display-slide1[rel=' + rel + ']').fadeIn();
				$(".select-display-slide1 > li").removeClass("active");
				$(this).addClass("active");
			});

            $(".select-display-slide2 > li").click(function() {
				var rel = $(this).attr("rel");
				$('.display-slide2').hide();
				$('.display-slide2[rel=' + rel + ']').fadeIn();
				$(".select-display-slide2 > li").removeClass("active");
				$(this).addClass("active");
			});
        });

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
    </script>
    <script>
    function myFunction() {
        var copyText = document.getElementById("myInput");
        console.log(copyText)
        copyText.select();
        navigator.clipboard.writeText(copyText.value);
        alert("คัดลอกลิงก์สำเร็จ");
    }
    </script>
    
</body>

</html>