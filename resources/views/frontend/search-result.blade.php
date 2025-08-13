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
                    <div class="bannereach">
                        <img src="{{asset('frontend/images/oversea.webp')}}" alt="">
                        <div class="bannercaption">
                            <h4 id="show_result">ผลการค้นหา</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-3">
                <div class="col-lg-4 col-xl-3">
                    <div class="row">
                        <div class="col-5 col-lg-12">
                            {{-- @include("frontend.layout.inc_sidefilter_tour") --}}
                            <section id="sortfilter">
                                <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                                    <div class="boxfilter">
                                        <div class="row">
                                            <div class="col-8 col-lg-9">
                                                <div class="titletopic">
                                                    <h2>ตัวกรองที่เลือก</h2>
                                                </div>
                                                <div class="filtermenu">
                                                    <ul id="show_select_date"></ul>
                                                    <ul id="show_keyword"></ul>
                                                    <ul id="show_code"></ul>
                                                    <ul id="show_tag"></ul>
                                                    <ul id="show_select"></ul>
                                                </div>
                                            </div>
                                            <div class="col-4 col-lg-3 text-end">
                                                <a href="javascript:void(0)" onclick="clear_filter()" class="refreshde" >ล้างค่า</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="boxfilter mt-3">
                                            <div id="hide_date">
                                                <div class="titletopic">
                                                    <h2>ช่วงวันเดินทาง</h2>
                                                </div>
                                                <div class="col-lg-12"  style="margin-top:20px;">
                                                    <div class="row">
                                                        <div class="col-12 col-lg-12">
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar"></i></span>
                                                                <input type="text" class="form-control" name="daterange" id="hide_date_select" @if($start_search && $end_search) value="{{date('m/d/Y',strtotime($start_search))}} - {{date('m/d/Y',strtotime($end_search))}}" @else value="{{date('m/d/Y')}} - {{date('m/d/Y',strtotime('+1 day'))}}"  @endif/>
                                                                <input type="hidden" name="start_date" id="s_date" />
                                                                <input type="hidden" name="end_date" id="e_date" />
                                                                <div class="form-control"   id="show_date_calen" onclick="show_datepicker()" ></div>
                                                                <div class="form-control"  id="show_end_calen" onclick="show_datepicker()" ></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="hide_month">
                                                <div class="titletopic" id="month-topic">
                                                    <h2>ช่วงเดือน</h2>
                                                </div>
                                                <div class="filtermenu">
                                                    <ul id="show_month"></ul>
                                                </div>  
                                            </div> 
                                            <div id="hide_holiday">
                                                <div class="titletopic" id="holiday-topic" >
                                                    <h2>วันหยุด</h2>
                                                </div>
                                                <div class="filtermenu">
                                                    <ul id="show_holiday"></ul>
                                                </div>   
                                            </div>
                                            <div class="titletopic" id="country-topic">
                                                <h2>ประเทศ</h2>
                                            </div>
                                            <div class="filtermenu">
                                                @if($isWin || $isMac)
                                                <div class="input-group mb-3" id="country_input">
                                                    <input type="text" class="form-control" placeholder="ค้นหาชื่อประเทศ"  id="find_country"  aria-label="air"
                                                        aria-describedby="button-addon2" onkeyup="find_country()">
                                                </div>
                                                @endif
                                                <ul id="show_country"></ul>
                                            </div>   
                                            <div class="titletopic" id="city-topic" hidden>
                                                <h2>เมือง</h2>
                                            </div>
                                            <div class="filtermenu" hidden>
                                                @if($isWin || $isMac)
                                                <div class="input-group mb-3" id="city_input">
                                                    <input type="text" class="form-control" placeholder="ค้นหาชื่อเมือง"  id="find_city"  aria-label="air"
                                                        aria-describedby="button-addon2" onkeyup="find_city()">
                                                </div>
                                                @endif
                                                <ul id="show_city"></ul>
                                            </div>   
                                            <div class="titletopic" id="amupur-topic" hidden>
                                                <h2>อำเภอ</h2>
                                            </div>
                                            <div class="filtermenu" hidden>
                                                <ul id="show_amupur"></ul>
                                            </div>   
                                            <div class="titletopic" id="price-topic">
                                                <h2>ช่วงราคา</h2>
                                            </div>
                                            <div class="filtermenu">
                                                <ul id="show_price"></ul>
                                            </div>   
                                            <div class="titletopic" id="day-topic">
                                                <h2>เลือกจำนวนวัน</h2>
                                            </div>
                                            <div class="filtermenu">
                                                <ul id="show_day"></ul>
                                            </div>   
                                            <div class="titletopic" id="airline-topic">
                                                <h2>สายการบิน</h2>
                                            </div>
                                            <div class="filtermenu">
                                                @if($isWin || $isMac)
                                                <div class="input-group mb-3"  id="airline_input">
                                                    <input type="text" class="form-control" placeholder="ค้นหาสายการบิน"  id="find_airline"  aria-label="air"
                                                        aria-describedby="button-addon2" onkeyup="find_airline()">
                                                </div>
                                                @endif
                                                <ul id="show_airline"></ul>
                                            </div>   
                                            <div class="titletopic" id="rating-topic">
                                                <h2>ระดับดาวที่พัก</h2>
                                            </div>
                                            <div class="filtermenu">
                                                <ul id="show_rating"></ul>
                                            </div>  
                                    </div>  
                                </div>
                                <div class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
                                    <button class="btn btnfilter" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom"
                                        aria-controls="offcanvasBottom">ตัวกรอง</button>
                            
                                    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom"
                                        aria-labelledby="offcanvasBottomLabel">
                                        <div class="offcanvas-header">
                                            <h5 class="offcanvas-title" id="offcanvasBottomLabel">กรองการค้นหา <a href="javascript:void(0)" onclick="clear_filter()" class="refreshde">ล้างค่า</a> </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                        </div>
                                        <ul id="show_select_date_mb"></ul>
                                        <ul id="show_keyword_mb"></ul>
                                        <ul id="show_code_mb"></ul>
                                        <ul id="show_tag_mb"></ul>
                                        <ul id="show_select_mb"></ul>
                                        <div class="offcanvas-body small">
                                            <div class="boxfilter">
                                                <div id="hide_date_mb">
                                                    <div class="titletopic">
                                                        <h2>ช่วงวันเดินทาง</h2>
                                                    </div>
                                                    <div class="col-lg-12"  style="margin-top:20px;">
                                                        <div class="row">
                                                            <div class="col-12 col-lg-12">
                                                                <div class="input-group mb-3">
                                                                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar"></i></span>
                                                                    <input type="text" class="form-control" name="daterange" id="hide_date_select_mb" @if($start_search && $end_search) value="{{date('m/d/Y',strtotime($start_search))}} - {{date('m/d/Y',strtotime($end_search))}}" @else value="{{date('m/d/Y')}} - {{date('m/d/Y',strtotime('+1 day'))}}"  @endif/>
                                                                    <input type="hidden" name="start_date" id="s_date_mb" />
                                                                    <input type="hidden" name="end_date" id="e_date_mb" />
                                                                    <div class="form-control"   id="show_date_calen_mb" onclick="show_datepicker_mb()" ></div>
                                                                    <div class="form-control"  id="show_end_calen_mb" onclick="show_datepicker_mb()" ></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="hide_month_mb">
                                                    <div class="titletopic">
                                                        <h2>ช่วงเดือน</h2>
                                                    </div>
                                                    <div class="filtermenu">
                                                        <ul id="show_month_mb"></ul>
                                                    </div>   
                                                </div>
                                                <div id="hide_holiday_mb">
                                                    <div class="titletopic">
                                                        <h2>วันหยุด</h2>
                                                    </div>
                                                    <div class="filtermenu">
                                                        <ul id="show_holiday_mb"></ul>
                                                    </div>   
                                                </div>
                                                <div class="titletopic">
                                                    <h2>ประเทศ</h2>
                                                </div>
                                                <div class="filtermenu">
                                                    @if($isAndroid || $isIPhone || $isIPad)
                                                    <div class="input-group mb-3" id="country_input">
                                                        <input type="text" class="form-control" placeholder="ค้นหาชื่อประเทศ"  id="find_country"  aria-label="air"
                                                            aria-describedby="button-addon2" onkeyup="find_country()">
                                                    </div>
                                                    @endif
                                                    <ul id="show_country_mb"></ul>
                                                </div>   
                                                <div class="titletopic" hidden>
                                                    <h2>เมือง</h2>
                                                </div>
                                                <div class="filtermenu" hidden>
                                                    @if($isAndroid || $isIPhone || $isIPad)
                                                    <div class="input-group mb-3" id="city_input">
                                                        <input type="text" class="form-control" placeholder="ค้นหาชื่อเมือง"  id="find_city"  aria-label="air"
                                                            aria-describedby="button-addon2" onkeyup="find_city()">
                                                    </div>
                                                    @endif
                                                    <ul id="show_city_mb"></ul>
                                                </div>   
                                                <div class="titletopic" hidden>
                                                    <h2>อำเภอ</h2>
                                                </div>
                                                <div class="filtermenu" hidden>
                                                    <ul id="show_amupur_mb"></ul>
                                                </div>   
                                                <div class="titletopic">
                                                    <h2>ช่วงราคา</h2>
                                                </div>
                                                <div class="filtermenu">
                                                    <ul id="show_price_mb"></ul>
                                                </div>   
                                                <div class="titletopic">
                                                    <h2>เลือกจำนวนวัน</h2>
                                                </div>
                                                <div class="filtermenu">
                                                    <ul id="show_day_mb"></ul>
                                                </div>   
                                                <div class="titletopic">
                                                    <h2>สายการบิน</h2>
                                                </div>
                                                <div class="filtermenu">
                                                    @if($isAndroid || $isIPhone || $isIPad)
                                                    <div class="input-group mb-3"  id="airline_input">
                                                        <input type="text" class="form-control" placeholder="ค้นหาสายการบิน"  id="find_airline"  aria-label="air"
                                                            aria-describedby="button-addon2" onkeyup="find_airline()">
                                                    </div>
                                                    @endif
                                                    <ul id="show_airline_mb"></ul>
                                                </div>   
                                                <div class="titletopic">
                                                    <h2>ระดับดาวที่พัก</h2>
                                                </div>
                                                <div class="filtermenu">
                                                    <ul id="show_rating_mb"></ul>
                                                </div> 
                                            </div>
                                            <a href="javascript:void(0);" class="btn btnonmb" data-bs-dismiss="offcanvas" aria-label="Close">แสดงผลการกรอง</a>
                                        </div>
                                    </div>
                                </div>
                                </section>
                        </div>
                        <div class="col-5 ps-0">
                            <div class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
                                <select class="form-select" aria-label="Default select example" id="orderby_data1" name="orderby_data" onchange="OrderByData(this.value)">
                                    <option value="0" >เรียงตาม </option>
                                    <option value="1">ราคาถูกที่สุด</option>
                                    <option value="2">ดูมากที่สุด</option>
                                    <option value="3">ลดราคา</option>
                                    <option value="4">มีโปรโมชั่น</option>
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
                                    <ul id="show_select_date_all"></ul>
                                    <ul id="show_keyword_all"></ul>
                                    <ul id="show_code_all"></ul>
                                    <ul id="show_tag_all"></ul>
                                    <ul id="show_select_all"></ul>
                                </div>
                                {{-- <div class="filtermenu"></div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-xl-9">
                    <div class="row mt-3 mt-lg-0">
                        <div class="col-12 col-lg-7 col-xl-8">
                            <div class="titletopic">
                                <h1> </h1>
                                <p id="show_total"></p>
                            </div>
                        </div>
                        <div class="col-lg-5 col-xl-4 text-end">
                            <div class="row">
                                <div class="col-lg-8 col-xl-8">
                                    <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                                        <select class="form-select" aria-label="Default select example" id="orderby_data2" name="orderby_data" onchange="OrderByData(this.value)">
                                            <option value="0" >เรียงตาม </option>
                                            <option value="1">ราคาถูกที่สุด</option>
                                            <option value="2">ดูมากที่สุด</option>
                                            <option value="3">ลดราคา</option>
                                            <option value="4">มีโปรโมชั่น</option>
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
                    {{-- <div class="row">
                        <div class="col-lg-12">
                            <p id="show_total"></p>
                            <ul id="show_tour"></ul>
                        </div>
                        <div class="col-lg-12" id="pagination"></div>
                    </div> --}}
                    <div class="row">
                        <div class="col">
                            <div class="table-grid">
                                <div class="row">
                                    <div class="col" id="show_tour"></div>
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
                                        <tbody id="show_grid"></tbody>
                                    </table>
                                </div>
                            </div>
                            {{-- end grid view --}}
                            <div class="row mt-4 mb-4">
                                <div class="col">
                                    <div class="pagination_bot">
                                        <nav class="pagination-container">
                                            <button class="btn btn-submit d-none" id="btn-showmore" id="btn-showmore" onclick="show_tour()">ดูเพิ่มเติม</button>
                                            {{-- <div class="pagination" id="pagination">
                                            </div> --}}
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-lg-12" id="pagination"></div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include("frontend.layout.inc_footer")
    <script>
        var price_search = {{isset($price_search)?$price_search:0}};
        var country_search = {{isset($country_search)?$country_search:0}};
        var city_search = {{isset($city_search)?$city_search:0}};
        <?php 
            echo isset($start_search)?"var start_search = '$start_search' ; ":"var start_search = 0 ;";
            echo isset($end_search)?"var end_search = '$end_search' ; ":"var end_search = 0 ;";
            echo isset($keyword_search)?"var keyword_search = '$keyword_search' ; ":"var keyword_search = 0 ;";
            echo isset($code_id)?"var code_id = '$code_id' ; ":"var code_id = 0 ;";
            echo isset($tag_name)?"var tag_name = '$tag_name' ; ":"var tag_name = 0 ;";
        ?>
        var str_start = {{isset($str_start)?$str_start:0}};
        var str_end = {{isset($str_end)?$str_end:0}} ;
        var travel_search = {{isset($travel_search)?json_encode($travel_search):0}};
        var tour_code = {{isset($tour_code)?json_encode($tour_code):0}};
       
        var isWin = {{isset($isWin)?json_encode($isWin):0}};
        var isMac = {{isset($isMac)?json_encode($isMac):0}};
        var isAndroid = {{isset($isAndroid)?json_encode($isAndroid):0}};
        var isIPhone = {{isset($isIPhone)?json_encode($isIPhone):0}};
        var isIPad = {{isset($isIPad)?json_encode($isIPad):0}};
        var tag_search = {{isset($tag_search)?$tag_search:0}};
    </script>
    <script src="script-filter.js?v={{ filemtime(public_path('script-filter.js')) }}"> </script>
    <script src="data-filter.js"> </script>
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