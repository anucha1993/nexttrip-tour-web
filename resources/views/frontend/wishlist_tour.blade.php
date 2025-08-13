@php
    $month = ['','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
@endphp
@foreach (@$data as $dat)
    @php
        $country = \App\Models\Backend\CountryModel::whereIn('id',json_decode($dat->country_id,true))->get();
        $type = \App\Models\Backend\TourTypeModel::find(@$dat->type_id);
        $airline = \App\Models\Backend\TravelTypeModel::find(@$dat->airline_id);
        $period_all = \App\Models\Backend\TourPeriodModel::where(['tour_id'=>@$dat->id,'status_display'=>'on'])->whereDate('start_date','>=',now())->whereNull('deleted_at')->orderby('start_date','asc')->get();
        $period = $period_all->groupby('group_date');

        $allSoldOut = $period_all->every(function ($period_all) {
            return $period_all->status_period == 3; // เช็คถ้าทุก Period เป็น sold out
        });
    @endphp
    <div class="boxwhiteshd">
        <div class="toursmainshowGroup  hoverstyle">
            <div class="row">
                <div class="col-lg-12 col-xl-3 pe-xl-0">
                    <div class="covertourimg">
                        <figure>
                            <a href="{{url('tour/'.$dat->slug)}}" target="_blank"><img src="{{asset(@$dat->image)}}" alt=""></a>
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
                            <li class="bgwhite"><a><i class="fi fi-rr-marker"></i>{{@$country->country_name_th}}</a></li>
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
                        @if(count($country))
                            <li class="bgwhite"><a href="{{url('/oversea/'.$country[0]->slug)}}"><i class="fi fi-rr-marker" style="color:#f15a22;">
                                @foreach ($country as $co)
                                  {{$co->country_name_th?$co->country_name_th:$co->country_name_en}}
                                @endforeach   
                            </a></i>
                        @endif
                        <li>รหัสทัวร์ : <span class="bluetext">@if(@$dat->code1_check) {{@$dat->code1}} @else {{@$dat->code}} @endif</span> </li>
                        <li class="rating">โรงแรม
                            @for($i=1; $i <= @$dat->rating; $i++)
                                <i class="bi bi-star-fill"></i>
                            @endfor
                        </li>
                        <li>
                            สายการบิน <img src="{{asset(@$airline->image)}}" alt="">
                        </li>
                        <li>
                            <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                                <a class="tagicbest"><img src="{{asset(@$type->image)}}" class="img-fluid" alt=""></a>
                            </div>
                        </li>
                        <li class="bgor">ระยะเวลา {{$dat->num_day}}</li>
                    </div>

                    <div class="nameTop">
                        <h3> <a href="{{url('tour/'.$dat->slug)}}" target="_blank">{{ @$dat->name }}</a>
                        </h3>
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
                    <div class="hilight mt-2">
                        <div class="readMore">
                            <div class="readMoreWrapper">
                                <div class="readMoreText2">
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
                                        <div class="iconle"><span><i class="bi bi-bookmark-heart-fill" id="likeButton"></i></span></div>
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
                                @foreach($period as $k => $pe)
                                    <div class="tagmonth">
                                        <span class="month">{{$month[date('n',strtotime($pe[0]->start_date))]}}</span>
                                    </div>
                                    <div class="splgroup">
                                        @foreach($pe as $p)
                                        <?php 
                                            $start_date = strtotime($p->start_date);
                                            ${'holliday'.$p->id} = 0;
                                            while ($start_date <= strtotime($p->end_date)) {
                                                if(in_array(date('Y-m-d',$start_date),$arr) || date('N',$start_date) >= 6){
                                                    ${'holliday'.$p->id}++;
                                                    
                                                }
                                                $start_date = $start_date + 86400;
                                            }
                                        ?>
                                        <li>
                                            <a @if(${'holliday'.$p->id} > 0) data-tooltip="{{ ${'holliday'.$p->id} }} วัน" @endif id="staydate{{$p->id}}" class="staydate">
                                                <?php 
                                                    if($arr != null){
                                                        $start = strtotime($p->start_date); // แปลง start_date เป็นตัวเลข
                                                        $chk_price = true;
                                                        while ($start <= strtotime($p->end_date)) { // จับคู่กับวันหยุดแล้วใส่จุด
                                                            if(in_array(date('Y-m-d',$start),$arr)){
                                                                $chk_price = false;
                                                                echo $p->count <= 10 ? '<span class="fulltext">*</span>' : '<span class="staydate">-</span>';
                                                                if($p->count <= 10){
                                                                    break;
                                                                }
                                                                // echo '-';
                                                            }
                                                            $start = $start + 86400;
                                                        } 
                                                    }
                                                ?>
                                            </a>
                                            <?php 
                                                if($chk_price){
                                                    if($p->special_price1 && $p->special_price1 > 0){
                                                        $price = $p->price1 - $p->special_price1;
                                                    }else{
                                                        $price = $p->price1;
                                                    }
                                                    echo '<span class="saleperiod">'.number_format($price,0).'฿ </span>';
                                                }
                                            ?>
                                            <br>
                                            {{date('d',strtotime($p->start_date))}} - {{date('d',strtotime($p->end_date))}}
                                            {{-- {{date('d',strtotime($p->start_date))}} {{$month[date('n',strtotime($p->start_date))]}}-{{date('d',strtotime($p->end_date))}} {{$month[date('n',strtotime($p->end_date))]}} --}}
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
            <div class="row">
                <div class="col-md-9">
                    @if($allSoldOut)
                        <div class="fullperiod">
                            <h6>พีเรียดที่เต็มแล้ว ({{count($allSoldOut)}})</h6>
                            @foreach($period as $k => $pe)
                                @foreach($pe as $p)
                                    @if($p->count == 0)
                                        <span class="monthsold">{{$month[date('n',strtotime($pe[0]->start_date))]}}</span>
                                        <li>{{date('d',strtotime($p->start_date))}} - {{date('d',strtotime($p->end_date))}}</li>
                                    @endif
                                @endforeach
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="col-md-3 text-md-end">
                    <a href="{{url('tour/'.$dat->slug)}}" target="_blank" class="btn-main-og  morebtnog">รายละเอียด</a>
                </div>
            </div>
            <input type="hidden" id="invalidIds" value="{{ json_encode(array_values($invalidIds)) }}">
        </div>
    </div>
@endforeach
