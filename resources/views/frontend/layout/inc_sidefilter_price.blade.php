<section id="sortfilter">
    <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
        <div class="boxfilter">
            <div class="row">
                <div class="col-8 col-lg-9">
                    <div class="titletopic">
                        <h2>ตัวกรองที่เลือก</h2>
                    </div>
                </div>
                <div class="col-4 col-lg-3 text-end">
                    <a href="javascript:void(0)" onclick="window.location.reload()" class="refreshde" >ล้างค่า</a>
                </div>
            </div>
        </div>
        <div class="boxfilter mt-3">
            <form action="" method="POST" enctype="multipart/form-data"  id="searchForm">
            @csrf
            <input type="hidden" name="tour_id" value="{{json_encode($tour_id)}}">
            @if($filter)
            <div class="titletopic">
                <h2>ช่วงวันเดินทาง</h2>
            </div>
            <hr>
           <div class="filtermenu">
               <li>วันไป</li>
               <div class="input-group mb-3">
                   <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar"></i></span>
                       <input type="date" class="form-control" name="start_date" id="s_date" onchange="Send_search()">
                   
               </div>
               <li>วันกลับ</li>
               <div class="input-group mb-3">
                   <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar"></i></span>
                       <input type="date" class="form-control"  name="end_date" id="e_date" onchange="Send_search()">
               </div>
           </div>
           @endif
            @if(isset($filter['city']) && count($filter['city']) > 0)
                <div class="titletopic">
                    <h2>เมือง</h2>
                </div>
                <div class="filtermenu">
                    <ul>
                        @php
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
                                @foreach ($coun as $c)
                                    @php
                                        $tour = App\Models\Backend\TourModel::whereIn('id',$t_id)->where('city_id','like','%"'.$c->id.'"%')->where('status','on')->where('deleted_at',null)->count(); 
                                    @endphp
                                    @if($n <= 3)
                                    <li><label class="check-container"> {{$c->city_name_th?$c->city_name_th:$c->city_name_en}}
                                            <input type="checkbox" name="city" id="city{{$c->id}}" onclick="UncheckdCity({{$c->id}})" value="{{$c->id}}">
                                            <span class="checkmark"></span>
                                            <div class="count">({{$tour}})</div>
                                        </label></li>
                                    @endif
                                @endforeach
                            @endforeach
                                <div id="moreprovince" class="collapse">
                                    @foreach ($data_city as $n =>  $coun)
                                        @foreach ($coun as $c)
                                            @if($n > 3)
                                            @php
                                                $tour = App\Models\Backend\TourModel::whereIn('id',$t_id)->where('city_id','like','%"'.$c->id.'"%')->where('status','on')->where('deleted_at',null)->count(); 
                                            @endphp
                                            <li><label class="check-container">  {{$c->city_name_th?$c->city_name_th:$c->city_name_en}}
                                                <input type="checkbox" name="city" id="city{{$c->id}}" onclick="UncheckdCity({{$c->id}})" value="{{$c->id}}">
                                                <span class="checkmark"></span>
                                                <div class="count">({{$tour}})</div>
                                            </label></li>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </div>
                                @if(count($data_city) > 3)<a data-bs-toggle="collapse" data-bs-target="#moreprovince" class="seemore"> ดูเพิ่มเติม</a> @endif
                        @endif
                    </ul>
                    {{-- <center><span class="text-danger" id="show_alert" ></span></center> --}}
                </div>
                <hr>
            @endif
            @if($filter)
            <div class="titletopic">
                <h2>ช่วงราคา</h2>
            </div>
            <div class="filtermenu">
                <ul>
                   @if(isset($filter['price'][0]))
                    <li><label class="check-container"> 0-10,000
                            <input type="checkbox" name="price" id="price1" onclick="UncheckdPrice(1)" value="{{json_encode([0,10000])}}" >
                            <span class="checkmark"></span>
                            <div class="count">({{count($filter['price'][0])}})</div>
                        </label></li>
                    @endif
                    @if(isset($filter['price'][1]))
                    <li><label class="check-container"> 10,001-15,000
                            <input type="checkbox" name="price" id="price2"  onclick="UncheckdPrice(2)" value="{{json_encode([10001,15000])}}">
                            <span class="checkmark"></span>
                            <div class="count">({{count($filter['price'][1])}})</div>
                        </label></li>
                    @endif
                    @if(isset($filter['price'][2]))
                    <li><label class="check-container"> 15,001-20,000
                            <input type="checkbox" name="price" id="price3"  onclick="UncheckdPrice(3)" value="{{json_encode([15001,20000])}}">
                            <span class="checkmark"></span>
                            <div class="count">({{count($filter['price'][2])}})</div>
                        </label></li>
                    @endif
                    @if(isset($filter['price'][3]))    
                    <li><label class="check-container"> 20,001-25,000
                            <input type="checkbox" name="price" id="price4"  onclick="UncheckdPrice(4)" value="{{json_encode([20001,25000])}}">
                            <span class="checkmark" ></span>
                            <div class="count">({{count($filter['price'][3])}})</div>
                        </label></li>
                    @endif
                    @if(isset($filter['price'][4]))
                    <li><label class="check-container"> 25,001-30,000
                            <input type="checkbox" name="price" id="price5"  onclick="UncheckdPrice(5)" value="{{json_encode([25001,30000])}}">
                            <span class="checkmark"></span>
                            <div class="count">({{count($filter['price'][4])}})</div>
                        </label></li>
                    @endif
                    @if(isset($filter['price'][5]))
                    <li><label class="check-container"> 30,001 ขึ้นไป
                            <input type="checkbox" name="price" id="price6"  onclick="UncheckdPrice(6)" value="{{json_encode([30001])}}">
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
                <ul>
                    @foreach ($filter['day'] as $day => $num)
                        {{-- @if($day <= 3) --}}
                        <li>
                            <label class="check-container"> {{$day}} วัน
                                <input type="checkbox" name="day" id="day{{$day}}" onclick="UncheckdPrice({{$day}})" value="{{$day}}">
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
          
            {{-- <div class="titletopic">
                <h2>ประเทศ</h2>
            </div>
            <div class="filtermenu">
                <ul>
                    @php
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
                    @if($data_country)
                        @foreach ($data_country as $coun)
                            @foreach ($coun as $c)
                                @php
                                    $total_tour = App\Models\Backend\TourModel::whereIn('id',$tour_id)->where('country_id','like','%"'.$c->id.'"%')->where('status','on')->where('deleted_at',null)->count(); 
                                @endphp
                                <li><label class="check-container"> {{$c->country_name_th}}
                                        <input type="radio" @if($c->id == $slug) checked @endif name="country" onclick="Send_search()" value="{{$c->id}}">
                                        <span class="checkmark"></span>
                                        <div class="count">({{$total_tour}})</div>
                                    </label></li>
                            @endforeach
                        @endforeach
                        @if(count($filter['country']) > 4)<a data-bs-toggle="collapse" data-bs-target="#moreprovince" class="seemore"> ดูเพิ่มเติม</a>@endif
                    @endif
                </ul>
            </div>
            <hr> --}}
            <hr>
            @endif
            <div id="hide_month"> 
                @if(isset($filter['year']) && count($filter['year']) > 0)
                <div class="titletopic">
                    <h2>ช่วงเดือน</h2>
                </div>
                <div class="filtermenu">
                    <ul>
                        @php
                            $months =['','มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];
                        @endphp
                        @foreach ($filter['year'] as $year => $num)
                        
                        <li>{{$year}}</li>
                            @foreach ($num as $m => $n)
                            @php
                            
                                if($m <= 9){
                                    $my = '0'.$m;
                                }else{
                                    $my = $m;
                                }
                                $value_m = $my.$year;
                            @endphp
                                <li><label class="check-container"> {{$months[$m]}}
                                    <input type="checkbox" name="month_fil" id="month_fil{{$m}}" onclick="UncheckdMonth({{$m}})"  value="{{$value_m}}">
                                    <span class="checkmark"></span>
                                    <div class="count">({{count($n)}})</div>
                                </label></li>
                            @endforeach
                        @endforeach
                    </ul>
                </div>
                <hr>
                @endif
                @if(isset($filter['calendar']) && count($filter['calendar']) > 0)
                <div class="titletopic">
                    <h2>วันหยุด</h2>
                </div>
                <div class="filtermenu">
                    <ul>
                            @php
                                $check_calen = 0;
                            @endphp
                            @foreach ($filter['calendar'] as $ca => $num)
                            @php
                                $calen = App\Models\Backend\CalendarModel::find($ca);
                            @endphp
                            @if($check_calen <= 3)
                                <li><label class="check-container"> {{$calen->holiday}}
                                        <input type="checkbox" name="calen_start" id="calen_start{{$calen->id}}" onclick="UncheckdCalendar({{$calen->id}})" value="{{$calen->start_date}}">
                                        <span class="checkmark"></span>
                                        <div class="count">({{count($num)}})</div>
                                    </label></li>
                            @php
                                $check_calen++;
                                if(count($filter['calendar']) > 3){
                                    break;
                                }
                            @endphp
                            @endif
                            @endforeach
                                <div id="moreday" class="collapse">
                                    @foreach ($filter['calendar'] as $ca => $num)
                                        @if($check_calen > 3)
                                        @php
                                            $calen = App\Models\Backend\CalendarModel::find($ca);
                                        @endphp
                                            <li><label class="check-container"> {{$calen->holiday}}
                                                <input type="checkbox" name="calen_start" id="calen_start{{$calen->id}}" onclick="UncheckdCalendar({{$calen->id}})" value="{{$calen->start_date}}">
                                                <span class="checkmark"></span>
                                                <div class="count">({{count($num)}})</div>
                                            </label></li>
                                        @endif
                                    @endforeach
                                </div>
                            <input type="hidden" class="form-control" name="start_date_calen" value="{{$calen->start_date}}">
                            <input type="hidden" class="form-control"  name="end_date_calen" value="{{$calen->end_date}}">
                            <input type="hidden" name="calen_end" value="{{$calen->end_date}}">
                        @if(count($filter['calendar']) > 3)<a data-bs-toggle="collapse" data-bs-target="#moreday" class="seemore"> ดูเพิ่มเติม</a> @endif
                    </ul>
                </div>
                <hr>
                @endif
            </div>
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
                         $airline_id[] = $air;
                         $airline_num[$airline->id] = count($num);
                    @endphp
                        @if($check_airline <= 3)
                        <li><label class="check-container">@if($airline->image)<img src="{{asset($airline->image)}}" alt="">@endif {{$airline->travel_name}}
                                <input type="checkbox" name="airline" id="airline{{$airline->id}}" onclick="UncheckdAirline({{$airline->id}})" value="{{$airline->id}}">
                                <span class="checkmark"></span>
                                <div class="count">({{count($num)}})</div>
                            </label></li>
                        @php
                            $check_airline++;
                            if(count($airline_id) > 3){
                                break;
                            }
                        @endphp
                        @endif
                    @endforeach
                        <div id="moreair" class="collapse">
                            @foreach ($filter['airline'] as $air => $num)
                                @if($check_airline > 3 && !in_array($air,$airline_id))
                                @php
                                    $airline = App\Models\Backend\TravelTypeModel::find($air);
                                    $airline_id[] = $air;
                                    $airline_num[$airline->id] = count($num);
                                @endphp
                                <li><label class="check-container">@if($airline->image)<img src="{{asset($airline->image)}}" alt="">@endif {{$airline->travel_name}}
                                    <input type="checkbox" name="airline" id="airline{{$airline->id}}" onclick="UncheckdAirline({{$airline->id}})" value="{{$airline->id}}">
                                    <span class="checkmark"></span>
                                    <div class="count">({{count($num)}})</div>
                                </label></li>
                                @endif
                            @endforeach
                        </div>
                        @if(count($airline_id) > 3)<a data-bs-toggle="collapse" data-bs-target="#moreair" class="seemore"> ดูเพิ่มเติม</a>  @endif
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
                <ul>
                    @if(isset($filter['rating'][0]))
                    <li><label class="check-container">
                            <div class="rating">
                                <i class="bi bi-star-fill"></i> <i class="bi bi-star-fill"></i> 
                                <i class="bi bi-star-fill"></i> <i class="bi bi-star-fill"></i> 
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <input type="checkbox" name="rating" id="rating6" onclick="UncheckdRating(6)" value="5">
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
                            <input type="checkbox" name="rating" id="rating5" onclick="UncheckdRating(5)" value="4">
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
                            <input type="checkbox" name="rating" id="rating4" onclick="UncheckdRating(4)" value="3">
                            <span class="checkmark"></span>
                            <div class="count">({{count($filter['rating'][2])}})</div>
                        </label></li>
                    @endif
                    @if(isset($filter['rating'][3]))
                    <li><label class="check-container">
                            <div class="rating">
                                <i class="bi bi-star-fill"></i> <i class="bi bi-star-fill"></i> 
                            </div>
                            <input type="checkbox" name="rating" id="rating3" onclick="UncheckdRating(3)" value="2">
                            <span class="checkmark"></span>
                            <div class="count">({{count($filter['rating'][3])}})</div>
                        </label></li>
                    @endif
                    @if(isset($filter['rating'][4]))
                    <li><label class="check-container">
                            <div class="rating">
                                <i class="bi bi-star-fill"></i> 
                            </div>
                            <input type="checkbox" name="rating" id="rating2" onclick="UncheckdRating(2)" value="1">
                            <span class="checkmark"></span>
                            <div class="count">({{count($filter['rating'][4])}})</div>
                        </label></li>
                    @endif
                    @if(isset($filter['rating'][5]))
                    <li><label class="check-container"> ไม่มีระดับดาวที่พัก
                            <input type="checkbox" name="rating" id="rating1" onclick="UncheckdRating(1)" value="0">
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
                <h5 class="offcanvas-title" id="offcanvasBottomLabel">กรองการค้นหา <a href="#"
                        class="refreshde">ล้างค่า</a> </h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body small">

                <div class="boxfilter">
                    <div class="titletopic">
                        <h2>ช่วงราคา</h2>
                    </div>
                    <div class="filtermenu">
                        <ul>
                            <li><label class="check-container"> ทั้งหมด
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>
                            <li><label class="check-container"> 0-10,000
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>
                            <li><label class="check-container"> 10,001-15,000
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>
                            <li><label class="check-container"> 15,001-20,000
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>
                            <li><label class="check-container"> 20,001-25,000
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>
                            <li><label class="check-container"> 25,001-30,000
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>
                            <li><label class="check-container"> 30,001 ขึ้นไป
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>
                        </ul>
                    </div>
                    <hr>
                    <div class="titletopic">
                        <h2>เลือกจำนวนวัน</h2>
                    </div>
                    <div class="filtermenu">
                        <ul>
                            <li><label class="check-container"> 1 วัน
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>
                            <li><label class="check-container"> 2 วัน
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>
                            <li><label class="check-container"> 3 วัน
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>
                            <li><label class="check-container"> 4 วัน
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>
                            <div id="moreprd" class="collapse">
                                <li><label class="check-container"> 5 วัน
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                        <div class="count">(25)</div>
                                    </label></li>
                                <li><label class="check-container"> 6 วัน
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                        <div class="count">(25)</div>
                                    </label></li>
                                <li><label class="check-container"> 7 วัน
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                        <div class="count">(25)</div>
                                    </label></li>
                            </div>
                            <a data-bs-toggle="collapse" data-bs-target="#moreprd" class="seemore"> ดูเพิ่มเติม</a>
                        </ul>
                    </div>
                    <hr>
                    <div class="titletopic">
                        <h2>เส้นทาง</h2>
                    </div>
                    <div class="filtermenu">
                        <ul>
                            <li><label class="check-container"> โตเกียว
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>
                            <li><label class="check-container"> โอซาก้า
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>
                            <li><label class="check-container"> ฟุกุโอกะ
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>
                            <li><label class="check-container"> โอซาก้า นาโกย่า
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>
                            <div id="moreprd" class="collapse">
                                <li><label class="check-container"> ฮอกไกโด
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                        <div class="count">(25)</div>
                                    </label></li>
                                <li><label class="check-container"> คันไซ
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                        <div class="count">(25)</div>
                                    </label></li>
                                <li><label class="check-container"> คิวชู
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                        <div class="count">(25)</div>
                                    </label></li>
                            </div>
                            <a data-bs-toggle="collapse" data-bs-target="#moreprd" class="seemore"> ดูเพิ่มเติม</a>
                        </ul>
                    </div>

                    <hr>
                    <div class="titletopic">
                        <h2>ช่วงวันเดินทาง</h2>
                    </div>
                    <div class="filtermenu">
                        <li>วันไป</li>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar"></i></span>
                            <form action="example.php" method="post">
                                <input autocomplete="off" class="datepicker form-control arrow_down"
                                    placeholder="DD/MM/YY" />
                            </form>
                        </div>
                        <li>วันกลับ</li>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar"></i></span>
                            <form action="example.php" method="post">
                                <input autocomplete="off" class="datepicker form-control arrow_down"
                                    placeholder="DD/MM/YY" />
                            </form>
                        </div>
                    </div>
                    <hr>
                    <div class="titletopic">
                        <h2>ช่วงเดือน</h2>
                    </div>
                    <div class="filtermenu">
                        <ul>
                            <li>2023</li>
                            <li><label class="check-container"> พฤษภาคม
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>
                            <li><label class="check-container"> มิถุนายน
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>
                            <li><label class="check-container"> กรกฎาคม
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>
                            <li><label class="check-container"> สิงหาคม
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>
                            <li><label class="check-container"> กันยายน
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>
                            <li><label class="check-container"> ตุลาคม
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>
                            <li><label class="check-container"> พฤศจิกายน
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>
                            <li><label class="check-container"> ธันวาคม
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>
                            <li>2024</li>
                            <li><label class="check-container"> มกราคม
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>

                        </ul>
                    </div>
                    <hr>
                    <div class="titletopic">
                        <h2>วันหยุด</h2>
                    </div>
                    <div class="filtermenu">
                        <ul>
                            <li><label class="check-container"> วันแรงงาน
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>
                            <li><label class="check-container"> วันแม่แห่งชาติ
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>
                            <li><label class="check-container"> วันพ่อแห่งชาติ
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>

                            <div id="moreday" class="collapse">
                                <li><label class="check-container"> วันปีใหม่
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                        <div class="count">(25)</div>
                                    </label></li>
                                <li><label class="check-container"> วันสงกรานต์
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                        <div class="count">(25)</div>
                                    </label></li>
                                <li><label class="check-container"> วันวาเลนไทน์
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                        <div class="count">(25)</div>
                                    </label></li>
                            </div>
                            <a data-bs-toggle="collapse" data-bs-target="#moreday" class="seemore"> ดูเพิ่มเติม</a>
                        </ul>
                    </div>
                    <hr>
                    <div class="titletopic">
                        <h2>สายการบิน</h2>
                    </div>
                    <div class="filtermenu">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="ชื่อสายการบิน" aria-label="air"
                                aria-describedby="button-addon2">
                            <button class="btn btn-outline-secondary" type="button" id="button-addon2"><i
                                    class="fi fi-rr-search"></i></button>
                        </div>
                        <ul>
                            <li><label class="check-container"><img src="images/logo_air.svg" alt=""> Air Asia
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>
                            <li><label class="check-container"><img src="images/airlogo/jeju_logo.svg" alt=""> Jeju Air
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>
                            <li><label class="check-container"><img src="images/airlogo/eva_logo.svg" alt=""> EVA Air
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>
                            <li><label class="check-container"><img src="images/airlogo/japan_logo.svg" alt=""> Japan
                                    Airlines
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>
                            <li><label class="check-container"><img src="images/airlogo/starlux_logo.svg" alt="">
                                    Starlux
                                    Airlines
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>

                            <div id="moreair" class="collapse">
                                <li><label class="check-container"><img src="images/logo_air.svg" alt=""> Air Asia
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                        <div class="count">(25)</div>
                                    </label></li>
                                <li><label class="check-container"><img src="images/airlogo/jeju_logo.svg" alt=""> Jeju
                                        Air
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                        <div class="count">(25)</div>
                                    </label></li>
                                <li><label class="check-container"><img src="images/airlogo/eva_logo.svg" alt=""> EVA
                                        Air
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                        <div class="count">(25)</div>
                                    </label></li>

                            </div>
                            <a data-bs-toggle="collapse" data-bs-target="#moreair" class="seemore"> ดูเพิ่มเติม</a>
                        </ul>
                    </div>
                    <hr>
                    <div class="titletopic">
                        <h2>ระดับดาวที่พัก</h2>
                    </div>
                    <div class="filtermenu">
                        <ul>

                            <li><label class="check-container">
                                    <div class="rating">
                                        <i class="bi bi-star-fill"></i> <i class="bi bi-star-fill"></i> <i
                                            class="bi bi-star-fill"></i> <i class="bi bi-star-fill"></i> <i
                                            class="bi bi-star-fill"></i>
                                    </div>
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>
                            <li><label class="check-container">
                                    <div class="rating">
                                        <i class="bi bi-star-fill"></i> <i class="bi bi-star-fill"></i> <i
                                            class="bi bi-star-fill"></i> <i class="bi bi-star-fill"></i>
                                    </div>
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>
                            <li><label class="check-container">
                                    <div class="rating">
                                        <i class="bi bi-star-fill"></i> <i class="bi bi-star-fill"></i> <i
                                            class="bi bi-star-fill"></i>
                                    </div>
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>
                            <li><label class="check-container"> ไม่มีระดับดาวที่พัก
                                    <input type="checkbox">
                                    <span class="checkmark"></span>
                                    <div class="count">(25)</div>
                                </label></li>
                        </ul>
                    </div>
                </div>
                <a href="#" class="btn btnonmb">แสดงผลการกรอง</a>
            </div>
        </form>
        </div>
    </div>

</section>

<script>
    $(document).ready(function () {
        $(function () {
            $('.datepicker').datepicker({
                dateFormat: 'dd/mm/yy',
                showButtonPanel: false,
                changeMonth: false,
                changeYear: false,
                /*showOn: "button",
                 buttonImage: "images/calendar.gif",
                 buttonImageOnly: true,
                 minDate: '+1D',
                 maxDate: '+3M',*/
                inline: true
            });
        });
        $.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            prevText: '<Ant',
            nextText: 'Sig>',
            currentText: 'Hoy',
            monthNames: ['January', 'Februaly', 'March', 'April', 'May', 'June', 'July', 'August',
                'September', 'October', 'November', 'December'
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