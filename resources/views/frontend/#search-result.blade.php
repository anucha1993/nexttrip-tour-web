<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    @include("frontend.layout.inc_header")
    <?php $pageName="oversea"; 
     if(isset($_GET['page'])){ $page = urldecode($_GET['page']); }else{ $page = 1;}
    ?>
</head>

<body>
    @include("frontend.layout.inc_topmenu")
    <section id="protourpage" class="wrapperPages">
        <div class="container-fluid g-0 overflow-hidden">
            <div class="row">
                <div class="col">
                    {{-- {{dd( $search_price,$search_start, $search_end,$search_keyword,$search_code)}} --}}
                    <div class="bannereach">
                        <img src="{{asset('frontend/images/oversea.webp')}}" alt="">
                        <div class="bannercaption">
                            <h4 id="show_result">ผลการค้นหา {{@$search_keyword}}</h4>
                            <input type="hidden" name="keyword_search" id="keyword_search" @if($search_keyword) value="{{@$search_keyword}}" @endif>
                            @if($search_code)<h4>รหัสทัวร์ {{$search_code}}</h4>@endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            {{-- <div class="socialshare">
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
                    <li class="copylink"><a href="#"><i class="fi fi-rr-link-alt"></i></a></li>
                </ul>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <div class="pageontop_sl">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">หน้าหลัก </a></li>

                                <li class="breadcrumb-item active" aria-current="page">ทัวร์{{@$country->country_name_th}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div> --}}
           
            <div class="row mt-3">
                <div class="col-lg-4 col-xl-3">
                    <div class="row">
                        <div class="col-5 col-lg-12">
                            @include("frontend.layout.inc_sidefilter_tour")
                            <div id="show_filter">
                            </div>
                        </div>
                        <div class="col-5 ps-0">
                            <div class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
                                <select class="form-select" aria-label="Default select example" name="orderby_data" onchange="OrderByData(this.value)">
                                    <option value="" >เรียงตาม</option>
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
                                @php
                                    $length_price_mb = ['','ต่ำกว่า 10,000','10,001-20,000','20,001-30,000','30,001-50,000','50,001-80,000','80,001 ขึ้นไป'];
                                @endphp
                                <div class="filtermenu">
                                    <ul id="show_select_date_mb_all"></ul>
                                    <ul id="show_select_mb_all">
                                        @if($search_price)
                                            @for($i=1;$i<=$search_price;$i++)
                                                @if($i == $search_price)
                                                    <li onclick="document.getElementById(`price_mb{{$i}}`).click()">
                                                        <label class="check-container">{{ $length_price_mb[$i] }}<i class='fa fa-times-circle' aria-hidden='true'></i>
                                                        </label>
                                                    </li>  
                                                @endif  
                                            @endfor
                                        @endif    
                                    </ul>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-xl-9">
                    <div class="row mt-3 mt-lg-0">
                        <div class="col-12 col-lg-7 col-xl-8">
                            <div class="titletopic">
                                <h1> </h1>
                                <p id="show_count"></p>
                            </div>
                        </div>
                        <div class="col-lg-5 col-xl-4 text-end">
                            <div class="row">
                                <div class="col-lg-8 col-xl-8">
                                    <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                                        <select class="form-select" aria-label="Default select example" name="orderby_data" {{-- onchange="windown.location.replace('{{url('/search-tour')}}?orderby_data='this.value)" --}} onchange="OrderByData(this.value)">
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
                                        $count_p = 1;
                                        $page_data = array();
                                        $count_tour = 0;
                                        $allSoldOut = array();
                                        $checkSold = false;
                                    @endphp
                                    @foreach($period as $pre)
                                            <?php
                                                $pro_data = array();
                                                $check_code = true;
                                                if($tour_code){
                                                    $message = $pre['tour']->code1_check?"Find".$pre['tour']->code1:"Find2".$pre['tour']->code;
                                                
                                                    $find = $tour_code;
                                                    if( !strpos( $message, $tour_code )) {
                                                        $check_code = false;
                                                    } 
                                                
                                                }
                                                $country = App\Models\Backend\CountryModel::whereIn('id',json_decode($pre['tour']->country_id,true))->get();
                                                $airline = \App\Models\Backend\TravelTypeModel::find($pre['tour']->airline_id);
                                                $type = \App\Models\Backend\TourTypeModel::find(@$pre['tour']->type_id);
                                                
                                                if($check_code){
                                                        $pro_data[] = $pre;
                                                    }
                                                if(count($pro_data)){
                                                        $page_data[$count_p][] = $pro_data;
                                                    }
                                                    if(isset($page_data[$count_p])){
                                                        if(count($page_data[$count_p]) >= 10){
                                                            $count_p++;
                                                        }
                                                }
                                                // dd($page_data,count($page_data[$count_p]))
                                            ?>
                                            @if($pre['tour'] && $check_code)
                                                @php
                                                    $count_tour++; 
                                                @endphp
                                            @endif
                                        @endforeach
                                            @if(isset($page_data[$page]))
                                                @foreach ($page_data[$page] as  $pro_page)
                                                    @foreach ($pro_page as $pre)

                                                    @php
                                                        $checkSold = false;
                                                        foreach ($pre['period'] as $p){ 
                                                            // $checkSold = false;
                                                            if($p->count == 0 && $p->status_period == 3){
                                                                $allSoldOut[$p->tour_id][] = $p->id;
                                                            }  
                                                        }
                                                    if(isset($allSoldOut[$pre['tour']->id])){
                                                        if(count($pre['period']) == count($allSoldOut[$pre['tour']->id])){
                                                            $checkSold = true;
                                                        } 
                                                    } 
                                                    @endphp
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
                                                                            <a href="{{url('tour/'.$pre['tour']->slug)}}" class="tagicbest"><img
                                                                                    src="{{asset(@$type->image)}}"
                                                                                    class="img-fluid" alt=""></a>
                                                                        </div>
                                                                        @if($pre['tour']->special_price > 0)
                                                                            <div class="saleonpicbox">
                                                                                <span> ลดราคาพิเศษ</span> <br>
                                                                                {{number_format($pre['tour']->special_price ,0)}} บาท  
                                                                            </div>
                                                                        @endif
                                                                       
                                                                        @if($checkSold)
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
                                                                            <a href="javascript:void(0);"><i class="bi bi-heart-fill" id="likeButton" {{-- onclick="likedTour({{@$pre['tour']->id}})" --}}></i></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12 col-xl-9">
                                                                    <div class="codeandhotel Cropscroll mt-1">
                                                                        <li class="bgwhite"><a href="{{ url('oversea/'.@$country[0]->slug)}}"><i class="fi fi-rr-marker" style="color:#f15a22;"></i> @foreach ($country as $coun) {{$coun->country_name_th?$coun->country_name_th:$coun->country_name_en}} @endforeach</a></li>
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
                                                                        <li>สายการบิน <a href="javascript:void(0);" onclick="Check_filter({{@$airline->id}},'airline')"><img src="{{asset(@$airline->image)}}" alt=""></a>
                                                                        </li>
                                                                        <li>
                                                                            <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                                                                                <a href="javascript:void(0);" class="tagicbest"  name="type_data" onclick="OrderByType({{@$dat->type_id}})"><img src="{{asset(@$type->image)}}"
                                                                                        class="img-fluid" alt=""></a>
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
                                                                                @foreach ($pre['period']->groupby('group_date') as $group)
                                                                                    <div class="tagmonth">
                                                                                        <span class="month">{{$month[date('n',strtotime($group[0]->start_date))]}}</span>
                                                                                    </div>
                                                                                    <div class="splgroup">
                                                                                        @foreach ($group as $p)
                                                                                        @php
                                                                                            if($p->count == 0 && $p->status_period == 3){
                                                                                                $sold_tour[] = $p->id;
                                                                                            }
                                                                                        @endphp
                                                                                        <li>
                                                                                        @php
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
                                                                                        @endphp
                                                                                            <a @if(${'holliday'.$p->id} > 0) data-tooltip="{{ ${'holliday'.$p->id} }} วัน" @endif id="staydate{{$p->id}}" class="staydate">
                                                                                            @php
                                                                                                    $start = strtotime($p->start_date); 
                                                                                                    $chk_price = true;
                                                                                                    while ($start <= strtotime($p->end_date)) { 
                                                                                                        if(in_array(date('Y-m-d',$start),$arr) || date('N',$start) >= 6){
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
                                                                                            @endphp
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
                                                                                @if($sold->count == 0 && $sold->status_period == 3)
                                                                                    <span class="monthsold">{{$month[date('n',strtotime($pre['period'][0]->start_date))]}}</span>
                                                                                    <li>{{date('d',strtotime($sold->start_date))}} - {{date('d',strtotime($sold->end_date))}} </li>
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
                                                    @endforeach
                                                @endforeach
                                            @endif
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
                                                <th>ช่วงเดือน</th>
                                                <th>สายการบิน</th>
                                                <th>ราคา</th>
                                                <th>โรงแรม</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody {{-- id="show_search_view" --}} id="show_grid">
                                            @if(isset($page_data[$page]))
                                                @foreach ($page_data[$page] as  $pro_page)
                                                    @foreach ($pro_page as $pre)
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
                                                        <td><a href="javascript:void(0);" onclick="Check_filter({{$pre['period'][0]->day}},'day')">{{$pre['tour']->num_day}}</a> </td>
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
                                                        <td> <a href="{{url('tour/'.$pre['tour']->slug)}}" class="tagicbest">
                                                            <img src="{{asset(@$type_list->image)}}"  class="img-fluid" alt=""></a>
                                                        </td>
                                                        <td> <a href="{{url('tour/'.$pre['tour']->slug)}}" class="link"> <i class="bi bi-chevron-right"></i></a></td>
                                                    </tr>
                                                @endif
                                                @endforeach
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- end grid view --}}
                            <div class="row mt-4 mb-4">
                                <div class="col">
                                    <div class="pagination_bot">
                                        <nav class="pagination-container">
                                            <?php $total_page = count($page_data); 
                                                $older = $page+1;    
                                                $newer = $page-1;  
                                                $start_page = max(1, $page - 2);
                                                $end_page = min($total_page, $start_page + 19);
                                            ?>
                                            <div class="pagination">
                                                <?php if($total_page > 1){?>
                                                    @if($page != $newer && $page != 1)
                                                        {{-- <a class="pagination-newer" href="?page=1">หน้าแรก</a> --}}
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
                                                        {{-- <a class="pagination-older" href="?page={{$total_page}}">สุดท้าย</a> --}}
                                                    @endif
                                                <?php } ?>
                                            </div>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    @include("frontend.layout.inc_footer")
    @include("frontend.layout.filter_tour")
    <?php 
        echo '<script>';
        echo 'var find_airline = '. json_encode($airline_data) .';';
        echo '</script>';
    ?>
    <script>
        document.getElementById('show_count').innerHTML = "พบ {{$count_tour}} รายการ";
        var active_day = '';
        var active_price = '';
        var active_calendar = '';
        var active_city = '';
        var active_airline = '';
        var active_rating = '';
        var active_month = '';
        function UncheckdDay (tid){
            if(active_day){
                 $('#day'+active_day).prop('checked', false);
            }
            active_day = active_day==tid?null:tid ;
            Send_search();
        }
        function UncheckdPrice (tid){
            if(active_price){
                 $('#price'+active_price).prop('checked', false);
            }
            active_price = active_price==tid?null:tid ;
            Send_search();
        }
        function UncheckdCalendar (tid){
            if(active_calendar){
                 $('#calen_start'+active_calendar).prop('checked', false);
            }
            active_calendar = active_calendar==tid?null:tid ;
            Send_search();
        }
        function UncheckdMonth (tid){
            if(active_month){
                 $('#month_fil'+active_month).prop('checked', false);
            }
            active_month = active_month==tid?null:tid ;
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
            check_date();
            var form = $('#searchForm')[0];
            var data = new FormData(form);
            var start = document.getElementById('s_date').value;
            var end = document.getElementById('e_date').value;
                    await $.ajax({
                                type: 'POST',
                                url: '{{url("/search-filter")}}',
                                data: data,
                                processData: false,
                                contentType: false,
                                cache: false,
                                success: function (datas) {
                                    document.getElementById('show_count').innerHTML = "พบ "+datas.period+" รายการ";
                                    document.getElementById('show_search').innerHTML = datas.data;
                                    if(datas.calen_start_date){
                                        document.getElementById('s_date').value = datas.calen_start_date;
                                        document.getElementById('e_date').value  = datas.calen_end_date;
                                    }
                                }
                            });
                    return false;
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
        function check_date(){
            var start_data = document.getElementById('s_date').value;
            var end_data = document.getElementById('e_date').value;
            if(start_data || end_data){
                $('#hide_month').hide();
            }else{
                $('#hide_month').show();
            }
        }
        check_date();

        function OrderByData(id) {
            if(id != null){
                window.location.replace("{{url('/search-tour')}}?orderby_data="+id);
                // $.ajax({
                //     type: 'GET',
                //     url: '{{url("/search-tour")}}?orderby_data='+id,
                //     // data:  {
                //     //     _token: '{{csrf_token()}}',
                //     //     orderby:id,
                //     // },
                //     success: function (data) {
                //         // document.getElementById('show_count').innerHTML = "พบ "+data.period+" รายการ";
                //         // document.getElementById('show_search').innerHTML = data;
                //     }
                // });
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
        });

    </script>
 

</body>

</html>