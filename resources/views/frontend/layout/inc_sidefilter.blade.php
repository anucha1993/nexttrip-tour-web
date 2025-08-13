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
                        <ul id="show_select_date"></ul>
                        <ul id="show_select"></ul>
                    </div>
                </div>
                <div class="col-4 col-lg-3 text-end">
                    <a href="javascript:void(0)" onclick="window.location.reload()" class="refreshde" >ล้างค่า</a>
                </div>
            </div>
        </div>
        <input type="hidden" name="search_price" id="search_price" value="{{$search_price}}">
        <div class="boxfilter mt-3">
            @php
                $data_type = ['country' => array(),'city' => array(),'day' => array(),'price' => array(),'airline' => array(),'rating' => array(),'start_date' => array(),'end_date' => array(),'month_fil' => array(),'calen_start' => array()];
            @endphp
            <input type="hidden" class="form-control" id="slug" name="slug" value="{{$main_slug}}">
            <input type="hidden" name="tour_id" id="tour_id_data" value="{{json_encode($tour_id)}}">
            <input type="hidden" class="form-control" id="calen_id" name="calen_id" value="{{json_encode($arr)}}">
            <input type="hidden" name="orderby_data" id="orderby_data" value="{{@$orderby_data}}">
            <div class="titletopic">
                <h2>ช่วงวันเดินทาง</h2>
            </div>
            {{-- <hr> --}}
            {{-- @if($filter) --}}
                {{-- <div class="filtermenu" > --}}
                    <div class="col-lg-12" id="hide_date" style="margin-top:20px;">
                        <div class="row">
                            <div class="col-12 col-lg-12">
                                @php
                                    $data_type['start_date'][] = $search_start;
                                    $data_type['end_date'][] = $search_end;
                                @endphp
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar"></i></span>
                                    <input type="text" class="form-control" name="daterange" id="hide_date_select" @if($search_start || $search_end) value="{{date('m/d/Y',strtotime($search_start))}} - {{date('m/d/Y',strtotime($search_end))}}" @else  value="{{date('m/d/Y')}} - {{date('m/d/Y',strtotime('+1 day'))}}" @endif/>
                                    <input type="hidden" name="start_date" id="s_date" @if($search_start) value="{{$search_start}}" @endif {{-- value="{{date('Y-m-d')}}" --}} />
                                    <input type="hidden" name="end_date" id="e_date" @if($search_end) value="{{$search_end}}" @endif {{-- value="{{date('Y-m-d',strtotime('+1 day'))}}" --}} />
                                    <div class="form-control"   id="show_date_calen" onclick="show_datepicker()" ></div>
                                    <div class="form-control"  id="show_end_calen" onclick="show_datepicker()" ></div>
                                </div>
                            </div>
                            
                            {{-- <div class="col-lg-6">
                                <p style="text-align:left;">วันไป</p>
                                <input type="date" class="form-control" @if(@$search_start) value="{{$search_start}}"  @endif min="{{date('Y-m-d')}}" name="start_date" id="s_date" onchange="Check_filter(this.value,'start_date')">
                                @php
                                    $data_type['start_date'][] = $search_start;
                                @endphp
                            </div>
                            <div class="col-lg-6">
                                <p style="text-align:left;">วันกลับ</p>
                                <input type="date" class="form-control" @if(@$search_end) value="{{$search_end}}" @endif min="{{date('Y-m-d')}}" name="end_date" id="e_date" onchange="Check_filter(this.value,'end_date')">
                                @php
                                    $data_type['end_date'][] = $search_end;
                                @endphp
                            </div> --}}
                        </div>
                    </div>
                {{-- </div> --}}
                <br>
           {{-- @endif --}}
            <div id="hide_month"> 
                <div class="titletopic">
                    <h2>ช่วงเดือน</h2>
                </div>
                @if(isset($filter['year']) && count($filter['year']) > 0)
                <div class="filtermenu">
                    <ul id="show_month">
                        @php
                            $months =['','มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];
                        @endphp
                        @foreach ($filter['year'] as $year => $num)
                        
                        <li>{{$year}} </li>
                            @foreach ($num as $m => $n)
                            @php
                            
                                if($m <= 9){
                                    $my = '0'.$m;
                                }else{
                                    $my = $m;
                                }
                                $value_m = $my.$year;
                                $data_type['month_fil'][] = $value_m;
                            
                            @endphp
                                <li><label class="check-container"> {{$months[$m]}}
                                    <input type="checkbox" name="month_fil" id="month_fil{{$m}}" onclick="Check_filter('{{$value_m}}','month_fil')"  value="{{$value_m}}">
                                    <span class="checkmark"></span>
                                    <div class="count">({{count($n)}})</div>
                                </label></li>
                            @endforeach
                        @endforeach
                    </ul>
                </div>
                <br>
                @endif
                @if(isset($filter['calendar']) && count($filter['calendar']) > 0)
                <div class="titletopic"  id="hide_calen">
                    <h2>วันหยุด</h2>
                </div>
                <div class="filtermenu" >
                    <ul id="show_calen">
                            @php
                                $check_calen = 0;
                            @endphp
                            @foreach ($filter['calendar'] as $ca => $num)
                            @php
                                $calen = App\Models\Backend\CalendarModel::find($ca);
                                $data_type['calen_start'][] = $calen;
                                
                            @endphp
                            {{-- @if($check_calen <= 3) --}}
                                <li><label class="check-container"> {{$calen->holiday}}
                                        <input type="checkbox" name="calen_start" id="calen_start{{$ca}}" onclick="Check_filter({{$ca}},'calen_start')" value="{{$ca}}">
                                        <span class="checkmark"></span>
                                        <div class="count">({{count($num)}})</div>
                                    </label></li>
                            @php
                                // $check_calen++;
                                // if(count($filter['calendar']) > 3){
                                //     break;
                                // }
                            @endphp
                            {{-- @endif --}}
                            @endforeach
                                {{-- <div id="moreday" class="collapse">
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
                                </div> --}}
                            <input type="hidden" class="form-control" name="start_date_calen" value="{{$calen->start_date}}">
                            <input type="hidden" class="form-control"  name="end_date_calen" value="{{$calen->end_date}}">
                            <input type="hidden" name="calen_end" value="{{$calen->end_date}}">
                        {{-- @if(count($filter['calendar']) > 3)<a data-bs-toggle="collapse" data-bs-target="#moreday" class="seemore"> ดูเพิ่มเติม</a> @endif --}}
                    </ul>
                </div>
                @endif
            </div>
            <hr>
            <div class="titletopic">
                <h2>เมือง</h2>
            </div>
            @if(isset($filter['city']) && count($filter['city']) > 0)
            <div class="filtermenu">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="ชื่อเมือง" name="city_search" id="city_search"  aria-label="air"
                        aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="button" id="button-addon2" onclick="Search_city()"><i
                            class="fi fi-rr-search"></i></button>
                </div>
                <ul  id="show_city">
                    @php
                        $check_city = array();
                        $city_num = array();
                        $city = array();
                        $t_id = array();
                        $data_city = array();
                        foreach ($filter['city'] as $id => $f_city) {
                            $city = array_merge($city,json_decode($f_city,true));
                            $t_id[] = $id;
                        }
                        $city = array_unique($city);
                        foreach ($city as $re) {
                            $data_city[] = App\Models\Backend\CityModel::where('id',$re)->get(); 
                        }
                        // dd($filter['city'],$data_city,$check_city);
                    @endphp
                    @if(isset($data_city))
                        {{-- <li><label class="check-container"> ทั้งหมด
                            <input type="checkbox"  id="city_total"  onclick="UncheckdCity(7)"  >
                            <span class="checkmark"></span>
                            <div class="count">({{$num_price}})</div>
                        </label></li>  --}}
                        @foreach ($data_city as $n => $coun)
                            @if($n <= 9)
                                @foreach ($coun as $c)
                                    @php
                                        $check_city[] = $c->id;
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
                                            // if(count($check_period)){
                                                $tour = $tour->whereIn('id',$check_period)/* ->where('promotion2','Y') */;
                                            // }  
                                        }
                                        $tour = $tour->count(); 
                                        $city_num[$c->id] = $tour;
                                    @endphp
                                    {{-- @if($n <= 3) --}}
                                    <li><label class="check-container"> {{$c->city_name_th?$c->city_name_th:$c->city_name_en}}
                                            <input type="checkbox" name="city" @if(@$search_city == $c->id) checked @endif id="city{{$c->id}}" onclick="Check_filter({{$c->id}},'city')" value="{{$c->id}}">
                                            <span class="checkmark"></span>
                                            <div class="count">({{$tour}})</div>
                                        </label></li>
                                    {{-- @endif --}}
                                @endforeach
                            @elseif($n > 9) 
                                <div id="moreprovince" class="collapse">
                                    @foreach ($coun as $c)
                                        @php
                                            $check_city[] = $c->id;
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
                                                // if(count($check_period)){
                                                    $tour = $tour->whereIn('id',$check_period)/* ->where('promotion2','Y') */;
                                                // }  
                                            }
                                            $tour = $tour->count(); 
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
                            {{-- <div id="moreprovince" class="collapse">
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
                            @if(count($data_city) > 3)<a data-bs-toggle="collapse" data-bs-target="#moreprovince" class="seemore"> ดูเพิ่มเติม</a> @endif --}}
                        @if(count($data_city) > 9)<a data-bs-toggle="collapse" data-bs-target="#moreprovince" class="seemore"> ดูเพิ่มเติม</a> @endif
                    @endif
                </ul>
            </div>
            <input type="hidden" id="city_data" value="{{ json_encode($check_city) }}">
            <input type="hidden" id="city_num" value="{{ json_encode($city_num) }}">
            <hr>
            @endif

            <div class="titletopic">
                <h2>ช่วงราคา</h2>
            </div>
            {{-- @if($filter) --}}
            <div class="filtermenu">
                <ul id="show_total" hidden>
                <li><label class="check-container"> ทั้งหมด
                        <input type="checkbox"  id="price7"  onclick="UncheckdPrice(7)"  >
                        <span class="checkmark"></span>
                        <div class="count">({{$num_price}})</div>
                </label></li> 
                </ul>
                <ul id="show_price">
                @if(isset($filter['price'][1]))
                    @php
                        $data_type['price'][] = 1;
                    @endphp
                    <li><label class="check-container"> ต่ำกว่า 10,000
                            {{-- <input type="checkbox" name="price[]" id="price1" onclick="UncheckdPrice(1)" value="1" > --}}
                            <input type="checkbox" name="price[]" id="price1" @if(@$search_price == 1) checked @endif onclick="Check_filter(1,'price')" value="1" >
                            <span class="checkmark"></span>
                            <div class="count">({{count($filter['price'][1])}})</div>
                        </label></li>
                    @endif
                    @if(isset($filter['price'][2]))
                    @php
                        $data_type['price'][] = 2;
                    @endphp
                    <li><label class="check-container"> 10,001-20,000
                            {{-- <input type="checkbox" name="price[]" id="price2" onclick="UncheckdPrice(2)" value="2"> --}}
                            <input type="checkbox" name="price[]" id="price2" @if(@$search_price == 2) checked @endif  onclick="Check_filter(2,'price')" value="2">
                            <span class="checkmark"></span>
                            <div class="count">({{count($filter['price'][2])}})</div>
                        </label></li>
                    @endif
                    @if(isset($filter['price'][3]))
                    @php
                        $data_type['price'][] = 3;
                    @endphp
                    <li><label class="check-container"> 20,001-30,000
                            {{-- <input type="checkbox" name="price[]" id="price3" onclick="UncheckdPrice(3)" value="3"> --}}
                            <input type="checkbox" name="price[]" id="price3" @if(@$search_price == 3) checked  @endif  onclick="Check_filter(3,'price')" value="3">
                            <span class="checkmark"></span>
                            <div class="count">({{count($filter['price'][3])}})</div>
                        </label></li>
                    @endif
                    @if(isset($filter['price'][4]))   
                    @php
                        $data_type['price'][] = 4;
                    @endphp 
                    <li><label class="check-container"> 30,001-50,000
                            {{-- <input type="checkbox" name="price" id="price4" onclick="UncheckdPrice(4)" value="4"> --}}
                            <input type="checkbox" name="price[]" id="price4" @if(@$search_price == 4) checked @endif  onclick="Check_filter(4,'price')" value="4">
                            <span class="checkmark" ></span>
                            <div class="count">({{count($filter['price'][4])}})</div>
                        </label></li>
                    @endif
                    @if(isset($filter['price'][5]))
                    @php
                        $data_type['price'][] = 5;
                    @endphp
                    <li><label class="check-container"> 50,001-80,000
                            {{-- <input type="checkbox" name="price" id="price5" onclick="UncheckdPrice(5)" value="5"> --}}
                            <input type="checkbox" name="price[]" id="price5" @if(@$search_price == 5) checked @endif  onclick="Check_filter(5,'price')" value="5">
                            <span class="checkmark"></span>
                            <div class="count">({{count($filter['price'][5])}})</div>
                        </label></li>
                    @endif
                    @if(isset($filter['price'][6]))
                    @php
                        $data_type['price'][] = 6;
                    @endphp
                    <li><label class="check-container"> 80,001 ขึ้นไป
                            {{-- <input type="checkbox" name="price" id="price6" onclick="UncheckdPrice(6)" value="6"> --}}
                            <input type="checkbox" name="price[]" id="price6" @if(@$search_price == 6) checked @endif  onclick="Check_filter(6,'price')" value="6">
                            <span class="checkmark"></span>
                            <div class="count">({{count($filter['price'][6])}})</div>
                        </label></li>
                    @endif
                </ul>
            </div>
            <hr>
            {{-- @endif --}}
            <div class="titletopic">
                <h2>เลือกจำนวนวัน</h2>
            </div>
            @if(isset($filter['day']) && count($filter['day']) > 0)
            <div class="filtermenu">
                <ul id="show_day">
                    @foreach ($filter['day'] as $day => $num)
                        @php
                            $data_type['day'][] = $day;
                        @endphp
                        {{-- @if($day <= 3) --}}
                        <li>
                            <label class="check-container"> {{$day}} วัน
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
            <div class="titletopic">
                <h2>สายการบิน</h2>
            </div>
            @if(isset($filter['airline']) && count($filter['airline']) > 0)
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
                        @if(count($airline_id) > 9)<a data-bs-toggle="collapse" data-bs-target="#moreair" class="seemore"> ดูเพิ่มเติม</a>  @endif
                </ul>
                <input type="hidden" id="airline_num" value="{{ json_encode($airline_num) }}" >
                <input type="hidden" id="airline_id" value="{{ json_encode($airline_id) }}" >
            </div>
            <hr>
            @endif
            <div class="titletopic">
                <h2>ระดับดาวที่พัก</h2>
            </div>
            @if($filter)
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
            <br><br>
        <div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom"
            aria-labelledby="offcanvasBottomLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title" id="offcanvasBottomLabel">ตัวกรองที่เลือก <a href="javascript:void(0)" onclick="window.location.reload()" class="refreshde" >ล้างค่า</a> </h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <ul id="show_select_date_mb"></ul>
            <ul id="show_select_mb"></ul>
            <div class="offcanvas-body small">
                <div class="boxfilter">
                        <div class="titletopic">
                            <h2>ช่วงวันเดินทาง</h2>
                        </div>
                        {{-- @if($filter) --}}
                            {{-- <div class="filtermenu" > --}}
                                <div class="col-lg-12" id="hide_date_mb"  style="margin-top:20px;">
                                    <div class="row">
                                        <div class="col-12 col-lg-12">
                                            <div class="input-group mb-3">
                                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar"></i></span>
                                                <input type="text" class="form-control" name="daterange" id="hide_date_select_mb"  @if($search_start || $search_end) value="{{date('m/d/Y',strtotime($search_start))}} - {{date('m/d/Y',strtotime($search_end))}}" @else  value="{{date('m/d/Y')}} - {{date('m/d/Y',strtotime('+1 day'))}}" @endif />
                                                <input type="hidden" name="start_date" id="s_date_mb" @if($search_start) value="{{$search_start}}" @endif />
                                                <input type="hidden" name="end_date" id="e_date_mb"  @if($search_end) value="{{$search_end}}" @endif />
                                                <div class="form-control"   id="show_date_calen_mb" onclick="show_datepicker_mb()" ></div>
                                                <div class="form-control"  id="show_end_calen_mb" onclick="show_datepicker_mb()" ></div>
                                            </div>
                                        </div>
                                        {{-- <div class="col-lg-6">
                                            <p style="text-align:left;">วันไป</p>
                                            <input type="date" class="form-control" @if(@$search_start) value="{{$search_start}}" @endif name="start_date" id="s_date_mb" onchange="Check_filter(this.value,'start_date')">
                                        </div>
                                        <div class="col-lg-6">
                                            <p style="text-align:left;">วันกลับ</p>
                                            <input type="date" class="form-control" @if(@$search_end) value="{{$search_end}}" @endif  name="end_date" id="e_date_mb" onchange="Check_filter(this.value,'end_date')">
                                        </div> --}}
                                    </div>
                                </div>
                            {{-- </div> --}}
                        <br>
                    {{-- @endif --}}
                    <div id="hide_month_mb"> 
                        <div class="titletopic">
                            <h2>ช่วงเดือน</h2>
                        </div>
                        @if(isset($filter['year']) && count($filter['year']) > 0)
                            <div class="filtermenu">
                                <ul id="show_month_mb">
                                    @foreach ($filter['year'] as $year => $num)
                                    <li>{{$year}} </li>
                                        @foreach ($num as $m => $n)
                                        @php
                                            if($m <= 9){
                                                $my_mb = '0'.$m;
                                            }else{
                                                $my_mb = $m;
                                            }
                                            $value_mb = $my_mb.$year;
                                        
                                        @endphp
                                            <li><label class="check-container"> {{$months[$m]}}
                                                <input type="checkbox" name="month_fil" id="month_fil_mb{{$m}}" onclick="Check_filter('{{$value_mb}}','month_fil')"  value="{{$value_mb}}">
                                                <span class="checkmark"></span>
                                                <div class="count">({{count($n)}})</div>
                                            </label></li>
                                        @endforeach
                                    @endforeach
                                </ul>
                            </div>
                            <br>
                        @endif
                        @if(isset($filter['calendar']) && count($filter['calendar']) > 0)
                        <div class="titletopic" id="hide_calen_mb">
                            <h2>วันหยุด</h2>
                        </div>
                        <div class="filtermenu">
                            <ul id="show_calen_mb">
                                    @php
                                        $check_calen = 0;
                                    @endphp
                                    @foreach ($filter['calendar'] as $ca => $num)
                                    @php
                                        $calen_mb = App\Models\Backend\CalendarModel::find($ca);
                                    @endphp
                                        <li><label class="check-container"> {{$calen_mb->holiday}}
                                                <input type="checkbox" name="calen_start" id="calen_start_mb{{$ca}}" onclick="Check_filter({{$ca}},'calen_start')" value="{{$ca}}">
                                                <span class="checkmark"></span>
                                                <div class="count">({{count($num)}})</div>
                                        </label></li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                    <hr>
                    <div class="titletopic">
                        <h2>เมือง</h2>
                    </div>
                    @if(isset($filter['city']) && count($filter['city']) > 0)
                        <div class="filtermenu">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="ชื่อเมือง" name="city_search" id="city_search"  aria-label="air"
                                    aria-describedby="button-addon2">
                                <button class="btn btn-outline-secondary" type="button" id="button-addon2" onclick="Search_city()"><i
                                        class="fi fi-rr-search"></i></button>
                            </div>
                            <ul  id="show_city_mb">
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
                                @endphp
                                @if(isset($data_city_mb))
                                    @foreach ($data_city_mb as $n => $coun)
                                        @if($n <= 9)
                                            @foreach ($coun as $c)
                                                @php
                                                    $tour_mb = App\Models\Backend\TourModel::whereIn('id',$t_id_mb)->where('city_id','like','%"'.$c->id.'"%')/* ->where('status','on')->where('deleted_at',null) */;
                                                    // ราคาถูกสุด
                                                    if($orderby_data == 1){
                                                        $tour_mb = $tour_mb->orderby('price','asc');
                                                    }
                                                    // ยอดวิวเยอะสุด
                                                    if($orderby_data == 2){
                                                        $tour_mb = $tour_mb->orderby('tour_views','desc');
                                                    }
                                                    //ลดราคา
                                                    if($orderby_data == 3){
                                                        $tour_mb = $tour_mb->where('special_price','>',0)->orderby('special_price','desc');
                                                    }
                                                    //มีโปรโมชั่น
                                                    if($orderby_data == 4){
                                                        $check_period = array();
                                                        $check_p = App\Models\Backend\TourPeriodModel::whereNotNull('promotion_id')->whereDate('pro_start_date','<=',date('Y-m-d'))->whereDate('pro_end_date','>=',date('Y-m-d'))->get(['tour_id']);
                                                        foreach($check_p  as $check){
                                                            $check_period[] = $check->tour_id;
                                                        }
                                                        // if(count($check_period)){
                                                            $tour_mb = $tour_mb->whereIn('id',$check_period)/* ->where('promotion2','Y') */;
                                                        // }  
                                                    }
                                                    $tour_mb = $tour_mb->count(); 
                                                    $check_city_mb[] = $c->id;
                                                    $city_num_mb[$c->id] = $tour_mb;
                                                @endphp
                                                <li><label class="check-container"> {{$c->city_name_th?$c->city_name_th:$c->city_name_en}}
                                                        <input type="checkbox" name="city" @if(@$search_city == $c->id) checked @endif id="city_mb{{$c->id}}" onclick="Check_filter({{$c->id}},'city')" value="{{$c->id}}">
                                                        <span class="checkmark"></span>
                                                        <div class="count">({{$tour_mb}})</div>
                                                    </label></li>
                                            @endforeach
                                        @elseif($n > 9)  
                                            <div id="moreprovince" class="collapse">
                                                @foreach ($coun as $c)
                                                    @php
                                                       $tour_mb = App\Models\Backend\TourModel::whereIn('id',$t_id_mb)->where('city_id','like','%"'.$c->id.'"%')/* ->where('status','on')->where('deleted_at',null) */;
                                                        // ราคาถูกสุด
                                                        if($orderby_data == 1){
                                                            $tour_mb = $tour_mb->orderby('price','asc');
                                                        }
                                                        // ยอดวิวเยอะสุด
                                                        if($orderby_data == 2){
                                                            $tour_mb = $tour_mb->orderby('tour_views','desc');
                                                        }
                                                        //ลดราคา
                                                        if($orderby_data == 3){
                                                            $tour_mb = $tour_mb->where('special_price','>',0)->orderby('special_price','desc');
                                                        }
                                                        //มีโปรโมชั่น
                                                        if($orderby_data == 4){
                                                            $check_period = array();
                                                            $check_p = App\Models\Backend\TourPeriodModel::whereNotNull('promotion_id')->whereDate('pro_start_date','<=',date('Y-m-d'))->whereDate('pro_end_date','>=',date('Y-m-d'))->get(['tour_id']);
                                                            foreach($check_p  as $check){
                                                                $check_period[] = $check->tour_id;
                                                            }
                                                            // if(count($check_period)){
                                                                $tour_mb = $tour_mb->whereIn('id',$check_period)/* ->where('promotion2','Y') */;
                                                            // }  
                                                        }
                                                        $tour_mb = $tour_mb->count(); 
                                                        $check_city_mb[] = $c->id;
                                                        $city_num_mb[$c->id] = $tour_mb;
                                                    @endphp
                                                    <li><label class="check-container">  {{$c->city_name_th?$c->city_name_th:$c->city_name_en}}
                                                        <input type="checkbox" name="city" id="city_mb{{$c->id}}" onclick="Check_filter({{$c->id}},'city')" value="{{$c->id}}">
                                                        <span class="checkmark"></span>
                                                        <div class="count">({{$tour_mb}})</div>
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
                    <div class="titletopic">
                        <h2>ช่วงราคา</h2>
                    </div>
                    @if($filter)
                    <div class="filtermenu">
                        <ul id="show_total_mb" hidden>
                        <li><label class="check-container"> ทั้งหมด
                                <input type="checkbox"  id="price_mb7"  onclick="UncheckdPrice(7)"  >
                                <span class="checkmark"></span>
                                <div class="count">({{$num_price}})</div>
                        </label></li> 
                        </ul>
                        <ul id="show_price_mb">
                            @if(isset($filter['price'][1]))
                            <li><label class="check-container"> ต่ำกว่า 10,000
                                    <input type="checkbox" name="price[]" id="price_mb1" @if(@$search_price == 1) checked @endif onclick="Check_filter(1,'price')" value="1" >
                                    <span class="checkmark"></span>
                                    <div class="count">({{count($filter['price'][1])}})</div>
                                </label></li>
                            @endif
                            @if(isset($filter['price'][2]))
                            <li><label class="check-container"> 10,001-20,000
                                    <input type="checkbox" name="price[]" id="price_mb2" @if(@$search_price == 2) checked @endif  onclick="Check_filter(2,'price')" value="2">
                                    <span class="checkmark"></span>
                                    <div class="count">({{count($filter['price'][2])}})</div>
                                </label></li>
                            @endif
                            @if(isset($filter['price'][3]))
                            <li><label class="check-container"> 20,001-30,000
                                    <input type="checkbox" name="price[]" id="price_mb3" @if(@$search_price == 3) checked @endif  onclick="Check_filter(3,'price')" value="3">
                                    <span class="checkmark"></span>
                                    <div class="count">({{count($filter['price'][3])}})</div>
                                </label></li>
                            @endif
                            @if(isset($filter['price'][4]))   
                            <li><label class="check-container"> 30,001-50,000
                                    <input type="checkbox" name="price[]" id="price_mb4" @if(@$search_price == 4) checked @endif  onclick="Check_filter(4,'price')" value="4">
                                    <span class="checkmark" ></span>
                                    <div class="count">({{count($filter['price'][4])}})</div>
                                </label></li>
                            @endif
                            @if(isset($filter['price'][5]))
                            <li><label class="check-container"> 50,001-80,000
                                    <input type="checkbox" name="price[]" id="price_mb5" @if(@$search_price == 5) checked @endif  onclick="Check_filter(5,'price')" value="5">
                                    <span class="checkmark"></span>
                                    <div class="count">({{count($filter['price'][5])}})</div>
                                </label></li>
                            @endif
                            @if(isset($filter['price'][6]))
                            <li><label class="check-container"> 80,001 ขึ้นไป
                                    <input type="checkbox" name="price[]" id="price_mb6" @if(@$search_price == 6) checked @endif  onclick="Check_filter(6,'price')" value="6">
                                    <span class="checkmark"></span>
                                    <div class="count">({{count($filter['price'][6])}})</div>
                                </label></li>
                            @endif
                        </ul>
                    </div>
                <hr>
                @endif
                <div class="titletopic">
                    <h2>เลือกจำนวนวัน</h2>
                </div>
                @if(isset($filter['day']) && count($filter['day']) > 0)
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
                <div class="titletopic">
                    <h2>สายการบิน</h2>
                </div>
                @if(isset($filter['airline']) && count($filter['airline']) > 0)
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
                <div class="titletopic">
                    <h2>ระดับดาวที่พัก</h2>
                </div>
                @if($filter)
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
<?php 
        echo '<script>';
        echo 'var data_type = '. json_encode($data_type) .';';
        echo 'var find_airline = '. json_encode($airline_data) .';';
        echo 'var price_search = '. json_encode($search_price) .';';
        echo 'var city_search = '. json_encode($search_city) .';';
        echo 'var isWin = '. $isWin .';';
        echo 'var isMac = '. $isMac .';';
        echo 'var isAndroid = '. $isAndroid .';';
        echo 'var isIPhone = '. $isIPhone .';';
        echo 'var isIPad = '. $isIPad .';';
        echo '</script>';

?>

