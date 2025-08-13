<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    @include("frontend.layout.inc_header")
    <?php $pageName="around";?>
</head>
<style>
    @media (max-width: 991px) {
        .contentde img {
            max-width: 100%;
            height: auto; 
        }
    }

</style>
<body>
    @include("frontend.layout.inc_topmenu")
    <section id="fordetailspage" class="wrapperPages">
        <div class="socialshare">
            <span>แชร์</span>
            <ul>
                @php
                                        $urlSharer = url("around-detail/".$id);
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
            <div class="row mt-5">
                <div class="col">
                    <div class="pageontop_sl">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">หน้าหลัก </a></li>
                                <li class="breadcrumb-item"><a href="{{url('aroundworld/0/0/0')}}">รอบรู้เรื่องเที่ยว </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page"> {{$row->title}}
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-lg-8">
                    <div class="bigpic">
                        <img src="{{asset($row->img_cover)}}" class="img-fluid" alt="">
                    </div>
                    <div class="tagcat02 mt-3 mb-3">
                        <li><a href="#">{{$type_a->type}}</a> </li>
                    </div>
                    <?php
                        $month = ['','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
                        $addYear = 543;
                    ?>   
                    <div class="titletopic mt-2">
                        <h1>{{$row->title}}</h1>
                        <p>{{date('d',strtotime($row->created_at))}} {{ $month[date('n',strtotime($row->created_at))] }}  {{date('Y',strtotime($row->created_at)) + $addYear}}</p>
                    </div>
                    <div class="contentde mb-3">
                        {!! $row->detail !!}
                    </div>
                    <div class="tagcat02">
                        @foreach($tag as $t)
                            <li><a href="{{url('aroundworld/0/0/'.$t->id)}}">#{{$t->tag}}</a></li>
                        @endforeach
                    </div>
                    <hr class="mt-5">
                    <div class="titletopic mt-4">
                        <h2>โปรแกรมทัวร์ที่เกี่ยวข้อง</h2>
                    </div>
                    <div class="row mt-4 mb-lg-5">
                        <div class="col-lg-12">
                                <!-- PC -->
                                <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                                    <div class="others_slider owl-theme owl-carousel">
                                        @foreach($tour as $to)
                                        @php
                                            $tr_country = \App\Models\Backend\CountryModel::whereIn('id',json_decode(@$to->country_id,true))->first();
                                            $type = \App\Models\Backend\TourTypeModel::find(@$to->type_id);
                                            $airline = \App\Models\Backend\TravelTypeModel::find(@$to->airline_id);
                                            $period = \App\Models\Backend\TourPeriodModel::where(['tour_id'=>@$to->id,'status_display'=>'on'])->whereNull('deleted_at')->orderby('start_date','asc')->get()->groupby('group_date');               
                                        @endphp
                                        <div class="item">
                                            <div class="showvertiGroup">
                                                <div class="boxwhiteshd hoverstyle">
                                                    <figure>
                                                        <a href="{{url('tour/'.$to->slug)}}">
                                                            <img src="{{ asset(@$to->image) }}" alt="">
                                                        </a>
                                                    </figure>
                                                    {{-- @if($to->special_price)
                                                        <div class="saleonpicbox">
                                                            <span> ลดราคาพิเศษ</span> <br>
                                                            {{number_format($to->special_price,0)}} บาท  
                                                        </div>
                                                    @endif --}}
                                                    {{-- <div class="tagontop">
                                                        <li class="bgor"><a href="{{url('tour/'.$to->slug)}}">{{$to->num_day}}</a> </li>
                                                        <li class="bgblue"><a href="{{url('tour/'.$to->slug)}}"><i class="fi fi-rr-marker"></i>
                                                            ทัวร์{{@$tr_country->country_name_th}}</a> </li>
                                                        <li>สายการบิน <a href="{{url('tour/'.$to->slug)}}"> <img src="{{asset(@$airline->image)}}"
                                                                    alt=""></a>
                                                        </li>
                                                    </div> --}}
                                                    <div class="contenttourshw">
                                                        <div class="codeandhotel">
                                                            <li>รหัสทัวร์ : <span class="bluetext">@if(@$to->code1_check) {{@$to->code1}} @else {{@$to->code}} @endif</span> </li>
                                                            <li class="rating">โรงแรม<a href="{{url('tour/'.$to->slug)}}">
                                                                    @for($i=1; $i <= @$to->rating; $i++)
                                                                        <i class="bi bi-star-fill"></i>
                                                                    @endfor
                                                                </a>
                                                            </li>

                                                        </div>
                                                        <hr>
                                                        <div class="locationnewd mb-2 mt-2">
                                                            <li> <a> <i class="fi fi-rr-marker"></i> {{@$tr_country->country_name_th}}</a></li>
                                                            <li class="datetour"><a>{{$to->num_day}}</a> </li>
                                                            <li class="airlines"> 
                                                                สายการบิน <img src="{{asset(@$airline->image)}}" alt=""> 
                                                            </li>
                                                        </div>
                                                        <h3><a href="{{url('tour/'.$to->slug)}}"> {{ @$to->name }}</a></h3>
                                                        <div class="listperiod">
                                                            @foreach($period as  $pe)
                                                                <li><span class="month">{{$month[date('n',strtotime($pe[0]->start_date))]}}</span>
                                                                    @php $toEnd = count($pe);  @endphp
                                                                    @foreach($pe as  $p)
                                                                        {{date('d',strtotime($p->start_date))}} - {{date('d',strtotime($p->end_date))}} @if(0 !== --$toEnd)/@endif
                                                                    @endforeach
                                                                </li>
                                                            @endforeach
                                                        </div>
                                                        <hr>
                                                        <div class="row">
                                                            <div class="col-lg-7">
                                                                <div class="pricegroup">
                                                                    @if($to->special_price > 0)
                                                                    @php $to_price = $to->price - $to->special_price; @endphp
                                                                        <span class="originalprice">ปกติ {{ number_format($to->price,0) }} </span> <br>
                                                                        เริ่ม <span class="saleprice">{{ number_format(@$to_price,0) }} บาท</span>
                                                                    @else
                                                                        เริ่ม <span class="saleprice"> {{ number_format($to->price,0) }} บาท</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-5 ps-0">
                                                                <a href="{{url('tour/'.$to->slug)}}" class="btn-main-og morebtnog">รายละเอียด</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                <!-- mb -->
                                <div class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
                                    <div class="Cropscroll pb-2">
                                        @foreach($tour as $to)
                                            @php
                                                $tr_country = \App\Models\Backend\CountryModel::whereIn('id',json_decode(@$to->country_id,true))->first();
                                                $type = \App\Models\Backend\TourTypeModel::find(@$to->type_id);
                                                $airline = \App\Models\Backend\TravelTypeModel::find(@$to->airline_id);
                                                $period = \App\Models\Backend\TourPeriodModel::where(['tour_id'=>@$to->id,'status_display'=>'on'])->whereNull('deleted_at')->orderby('start_date','asc')->get()->groupby('group_date');               
                                            @endphp
                                            <div class="showhoriMB">
                                                <div class="hoverstyle">
                                                    <div class="row">
                                                        <div class="col-5 pe-0">
                                                            <div class="imagestourid">
                                                                <figure>
                                                                    <a href="{{url('tour/'.$to->slug)}}">
                                                                        <img src="{{ asset(@$to->image) }}" class="img-fluid" alt="">
                                                                    </a>
                                                                </figure>
                                                                {{-- @if($to->special_price)
                                                                    <div class="saleonpicbox">
                                                                        <span> ลดพิเศษ</span> <br>
                                                                        {{number_format($to->special_price,0)}} บาท
                                                                    </div>
                                                                @endif --}}
                                                            </div>
                                                        </div>
                                                        <div class="col-7 ps-2">
                                                            <div class="contenttourshw">
                                                                <div class="codeandhotel">
                                                                    <li>รหัสทัวร์ : <span class="bluetext">@if(@$to->code1_check) {{@$to->code1}} @else {{@$to->code}} @endif</span>
                                                                    </li>
                                                                </div>
                                                                <hr>
                                                                <a href="{{url('tour/'.$to->slug)}}" class="namess"> {{ @$to->name }} </a>
                                                                <div class="listindetail_mb">
                                                                    <li><a href="{{url('tour/'.$to->slug)}}"> {{$to->num_day}}</a></li>
                                                                    <li><a href="{{url('tour/'.$to->slug)}}"> <img src="{{asset(@$airline->image)}}" alt=""></a></li>
                                                                    <li class="ratingid"><a href="{{url('tour/'.$to->slug)}}">
                                                                            @for($i=1; $i <= @$to->rating; $i++)
                                                                                <i class="bi bi-star-fill"></i>
                                                                            @endfor
                                                                        </a>
                                                                    </li>
                                                                </div>
                                                                <hr>
                                                                <div class="listperiodmbs3">
                                                                    @foreach($period as  $pe)
                                                                        {{$month[date('n',strtotime($pe[0]->start_date))]}}
                                                                        @if (!$loop->last) - @endif
                                                                    @endforeach
                                                                    <br>
                                                                    @if($to->special_price > 0)
                                                                        @php $to_price = $to->price - $to->special_price; @endphp
                                                                        <span>เริ่มต้น {{ number_format(@$to_price,0) }} บาท</span>
                                                                    @else
                                                                        <span>เริ่มต้น {{ number_format($to->price,0) }} บาท</span>
                                                                    @endif
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
                <div class="col-lg-4 mt-3">
                    <div class="boxfaqlist">
                        <div class="titletopic">
                            <h3>ดูบทความตามประเทศ</h3>
                        </div>
                        <?php 
                            $arr = array();
                            foreach($row_all as $in){
                                $arr = array_merge($arr,json_decode($in->country_id,true));
                            }  
                            $arr = array_unique($arr);
                            $country = App\Models\Backend\CountryModel::whereIn('id',$arr)->get(); 
                        ?>
                        <ul class="countryBlog">
                            @foreach($country as $c => $cou)
                                <li><a href="{{url('aroundworld/'.$cou->id.'/0/0')}}" class="containcc">
                                        <img src="{{asset($cou->img_banner)}}" alt="">
                                        <div class="text">{{$cou->country_name_th}}</div>
                                        <div class="overlay">
                                            <div class="text">{{$cou->country_name_th}}</div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="boxfaqlist">
                        <div class="titletopic">
                            <h3>ประเภทบทความ</h3>
                        </div>
                        <?php 
                            $check_type = array();
                            foreach($row_all as $in){
                                $check_type[$in->id] = $in->type_id;    
                            }  
                            $check_type = array_unique($check_type); 
                            $count_type = App\Models\Backend\TypeArticleModel::whereIn('id',$check_type)->get(); 
                        ?>
                        <ul class="favelist">
                            @foreach ($count_type as $c )
                                <li><a href="{{url('aroundworld/0/'.$c->id.'/0')}}">{{$c->type}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="boxfaqlist">
                        <div class="titletopic">
                            <h3>บทความอัพเดทล่าสุด</h3>
                        </div>
                        @foreach ($connect as $lat)
                        <div class="row mt-3 ">
                            <div class="col">
                                <div class="row groupnews hoverstyle">
                                    <div class="col-5 col-lg-4">
                                        <figure>
                                            <a href="{{url('around-detail/'.$lat->id)}}">
                                                <img src="{{asset($lat->img_cover)}}" alt="">
                                            </a>
                                        </figure>
                                    </div>
                                    <div class="col-7 col-lg-8 ps-0">
                                        <div class="newslistgroup">
                                            <h3><a href="{{url('around-detail/'.$lat->id)}}">{{$lat->title}}</a>
                                            </h3>
                                            <span class="date">{{date('d',strtotime($lat->created_at))}} {{ $month[date('n',strtotime($lat->created_at))] }}  {{date('Y',strtotime($lat->created_at)) + $addYear}}</span>
                                            <div class="viewscount text-end"><i class="fi fi-rr-eye"></i> {{$lat->views}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="boxfaqlist">
                        <div class="titletopic">
                            <h3><i class="fi fi-rr-circle-star"></i> บทความยอดนิยม</h3>
                        </div>
                        @foreach($popular as $pop)
                            <?php  $coun = App\Models\Backend\CountryModel::whereIn('id',json_decode($pop->country_id,true))->first();  ?>
                        <div class="row mt-3 ">
                            <div class="col">
                                <div class="row groupnews hoverstyle">
                                    <div class="col-5 col-lg-4">
                                        <figure>
                                            <a href="{{url('around-detail/'.$pop->id)}}">
                                                <img src="{{asset($pop->img_cover)}}" alt="">
                                            </a>
                                        </figure>
                                    </div>
                                    <div class="col-7 col-lg-8 ps-0">
                                        <div class="newslistgroup">
                                            <h3><a href="{{url('around-detail/'.$pop->id)}}">{{$pop->title}}</a>
                                            </h3>
                                            <span class="date">{{date('d',strtotime($pop->created_at))}} {{ $month[date('n',strtotime($pop->created_at))] }}  {{date('Y',strtotime($pop->created_at)) + $addYear}}</span>
                                            <div class="viewscount"><i class="fi fi-rr-eye"></i> {{$pop->views}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="boxfaqlist">
                        <div class="titletopic">
                            <h3><i class="fi fi-rr-tags"></i> แท๊กที่เกี่ยวข้อง</h3>
                        </div>
                        <?php 
                            $check = array();
                            foreach($row_all as $in){
                                $check = array_merge($check,json_decode($in->tag,true));
                            }  
                            $check = array_unique($check); 
                            $count_tag =  App\Models\Backend\TagContentModel::whereIn('id',$check)->limit(15)->get();
                        ?>
                        <div class="tagcat02">
                            @foreach ($count_tag as $ta)
                                <li><a href="{{url('aroundworld/0/0/'.$ta->id)}}">{{$ta->tag}}</a> </li>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include("frontend.layout.inc_footer")

    <script>
       window.onload = function() {
            recordPageView();
        };
        function recordPageView() {
            setTimeout(() => {
                $.ajax({
                    type: "POST",
                    url: '{{ url("/record-view/".$id)}}',
                    data: {
                        _token:"{{ csrf_token() }}"
                    },
                    success: function(){
                        console.log('Page view recorded successfully');
                    }
                });
            }, 10000);
        };
        function myFunction() {
            var copyText = document.getElementById("myInput");
            console.log(copyText)
            copyText.select();
            navigator.clipboard.writeText(copyText.value);
            alert("คัดลอกลิงก์สำเร็จ");
        }
    </script>
    <script>
        $(document).ready(function () {
            $('.others_slider').owlCarousel({
                loop: true,
                autoplay: false,
                smartSpeed: 2000,
                dots: true,
                nav: true,
                navText: ['<img src="{{asset('frontend/images/arrowRight.svg')}}">', '<img src="{{asset('frontend/images/arrowLeft.svg')}}">'],
                navClass: ['owl-prev', 'owl-next'],
                margin: 0,
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
                        items: 2,
                        slideBy: 1
                    },
                    1200: {
                        items: 3,
                        slideBy: 1
                    }
                }
            })

        });
    </script>
</body>

</html>