<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    @include("frontend.layout.inc_header")
    <?php $pageName="promotion";
    if(isset($_GET['page'])){ $page = urldecode($_GET['page']); }else{ $page = 1;}
    ?>
</head>

<body>
    @include("frontend.layout.inc_topmenu")

    <section id="promotionpage" class="wrapperPages">
        <div class="container-fluid g-0 overflow-hidden">

            <div class="row">
                <div class="col">
                    <div class="bannereach-left">
                        <img src="{{asset($banner->img)}}" alt="">
                        <div class="bannercaption">
                            {!! $banner->detail !!} 
                        </div>
                    </div>
                </div>
            </div>
        </div>
       
        <div class="container">
            <div class="row mt-5">
                <div class="col-lg-3">
                    <div class="sticky-top">
                        <div class="boxfaqlist">
                            <div class="titletopic"> 
                                <h2>ประเทศ</h2>
                            </div>
                            <?php
                                $total = 0;
                                foreach($id_tour as $num_coun){
                                    $total += count($num_coun);
                                }
                            ?>
                            <ul class="favelist">
                                <li><a href="{{url('promotiontour/0/0')}}" @if($id == 0)  class="active" @endif >ทั้งหมด</a><span>({{$total}})</span></li>
                                @foreach ($country_all as $k => $coun)
                                @php
                                    $data = App\Models\Backend\CountryModel::find($coun);
                                @endphp
                                    <li><a href="{{url('promotiontour/'.$data->id.'/'.$tid)}}" @if($id == $data->id) class="active" @endif>{{$data->country_name_th}} </a> <span>({{isset($id_tour[$coun])?count($id_tour[$coun]):0}})</span></li>
                                @endforeach
                            </ul>
                        </div>
                      
                        <div class="boxfaqlist mt-3">
                            <div class="titletopic">
                                <h2>เลือกโปรโมชั่น</h2>
                            </div>
                            <?php
                                $total_pro = 0;
                                foreach($id_tour_pro as $i  => $num_coun){
                                    $check_promotion = App\Models\Backend\PromotionModel::where('id',$i)->where('status','on')->first();
                                    if($check_promotion){
                                        $total_pro += count($num_coun);
                                    }
                                }
                            ?>
                            <ul class="favelist">
                                <li><a href="{{url('promotiontour/0/0')}}" @if($tid == 0)  class="active" @endif >ทั้งหมด</a><span>({{$total_pro}})</span></li>
                                @foreach ($promotion_total as $k => $promo)
                                        @php
                                            $pro = App\Models\Backend\PromotionModel::where('id',$k)->where('status','on')->first();
                                        @endphp
                                    {{-- @if($pro)<li><a href="{{url('promotiontour/'.$id.'/'.$pro->id)}}" @if($tid == $pro->id) class="active" @endif>{{@$pro->promotion_name}} </a> <span>({{count($promo)}})</span></li>@endif --}}
                                    @if($pro)<li onclick="Promotion_filter('promoid{{$pro->id}}',{{json_encode($promo)}})" >
                                        <a href="javascript:void(0);" id="promoid{{$pro->id}}" >{{@$pro->promotion_name}}<span>({{count($promo)}})</span></a></li>@endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <?php
                    $month =['','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
                    $count_p1 = 1;
                    $page_data1 = array();
                    $check_d1 = false;
                    $check_d2 = false;
                    $check_d3 = false;
                    $check_d4 = false;
                    foreach ($express as  $ex) {
                        $ex_data = array();
                        foreach ($ex as $p => $pt1) {
                            $check_d1 = false;
                            $check_d2 = false;
                            $check_d3 = false;
                            $check_d4 = false;
                            $price1 = $pt1->price1*30/100;
                            $price2 = $pt1->price2*30/100;
                            $price3 = $pt1->price3*30/100;
                            $price4 = $pt1->price4*30/100;
                            if($pt1->special_price1 > $price1){
                                $check_d1 = true;
                            } 
                            if($pt1->special_price2 > $price2){
                                $check_d2 = true;
                            } 
                            if($pt1->special_price3 > $price3){
                                $check_d3 = true;
                            } 
                            if($pt1->special_price4 > $price4){
                                $check_d4 = true;
                            } 
                            // if($check_d){
                            //     $page_data1[$count_p1][$pt1->t_id][] = $pt1;
                            // }
                            // echo "$pt1->pe_id-$check_d1-$check_d2<br>";
                            if($check_d1 || $check_d2){
                                $ex_data[] = $pt1;
                            }
                        }
                        if(count($ex_data)){
                            $page_data1[$count_p1][] = $ex_data;
                        }
                        if(isset($page_data1[$count_p1])){
                            if(count($page_data1[$count_p1]) >= 6){
                                $count_p1++;
                            }
                        }
                       
                    }
                    // dd($page_data1[$page]);
                ?> 
                <div class="col-lg-9">
                    <div class="row mt-3 mt-lg-0">
                        <div class="col-12 col-md-8">
                            @if(isset($page_data1[$page]))
                                <div class="titletopic">
                                    <h2>โปรไฟไหม้</h2>
                                    <p>ทัวร์ลดราคา ไม่ลดคุณภาพ เดินทางภายใน 7 วัน แพ็คกระเป๋าทัน <br> เงินพร้อม
                                        พาสปอร์ตพร้อม จองเลย
                                        ถูกที่สุดแล้ว!</p>
                                </div>
                            @endif
                        </div>
                        <div class="col-12 col-md-4 text-md-end">
                            <div class="socialshare_nonfix">
                                <ul>
                                    <li> <span>แชร์</span></li>
                                    @php
                                        $urlSharer = url("promotiontour/0/0");
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

                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        @if(isset($page_data1[$page]))
                            @foreach ($page_data1[$page] as $i => $ex) 
                                    <div class="col-lg-6 col-xl-4">
                                        <div class="showvertiGroup">
                                            <div class="boxwhiteshd">
                                                <div class="hoverstyle">
                                                    <div class="groupweekpos">
                                                        <figure>
                                                            <a href="{{url('tour/'.$ex[0]->slug)}}"><img src="{{asset($ex[0]->image)}}" class="img-fluid"
                                                                    alt=""></a>
                                                        </figure>
                                                        <div class="tagfire">
                                                            <i class="bi bi-fire"></i> ทัวร์ไฟไหม้
                                                        </div>
                                                        @if($ex[0]->special_price1 > 0)
                                                        @php $tv_price = $ex[0]->price1 - $ex[0]->special_price1; @endphp
                                                            <div class="saleonpicbox">
                                                                <span> ลดราคาพิเศษ</span> <br>
                                                                {{number_format($ex[0]->special_price1,0)}} บาท <br>
                                                                <span>เหลือเริ่ม</span><br>
                                                                {{number_format(@$tv_price,0)}}  
                                                            </div>
                                                        @elseif($ex[0]->special_price2 > 0)
                                                        @php $tv_price = ($ex[0]->price1+$ex[0]->price2) - $ex[0]->special_price2; @endphp
                                                            <div class="saleonpicbox">
                                                                <span> ลดราคาพิเศษ</span> <br>
                                                                {{number_format($ex[0]->special_price2,0)}} บาท <br>
                                                                <span>เหลือเริ่ม</span><br>
                                                                {{number_format(@$tv_price,0)}}  
                                                            </div>
                                                        @elseif($ex[0]->special_price3 > 0)
                                                            @php $tv_price = $ex[0]->price3 - $ex[0]->special_price3; @endphp
                                                                <div class="saleonpicbox">
                                                                    <span> ลดราคาพิเศษ</span> <br>
                                                                    {{number_format($ex[0]->special_price3,0)}} บาท <br>
                                                                    <span>เหลือเริ่ม</span><br>
                                                                    {{number_format(@$tv_price,0)}}  
                                                                </div>
                                                        @elseif($ex[0]->special_price4 > 0)
                                                            @php $tv_price = $ex[0]->price4 - $ex[0]->special_price4; @endphp
                                                                <div class="saleonpicbox">
                                                                    <span> ลดราคาพิเศษ</span> <br>
                                                                    {{number_format($ex[0]->special_price4,0)}} บาท <br>
                                                                    <span>เหลือเริ่ม</span><br>
                                                                    {{number_format(@$tv_price,0)}}  
                                                                </div>       
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="contenttourshw">
                                                    <h3>{{$ex[0]->name}}</h3>
                                                    <div class="listperiod">
                                                        @foreach ($ex as $pe_ex)
                                                            <li><span class="month">{{ $month[date('n',strtotime($pe_ex->start_date))] }}</span> {{date('d',strtotime($pe_ex->start_date))}} {{ $month[date('n',strtotime($pe_ex->start_date))] }} - {{date('d',strtotime($pe_ex->end_date))}} {{ $month[date('n',strtotime($pe_ex->end_date))] }}
                                                            <span class="pricegroup">
                                                                @if($pe_ex->special_price1 > 0)
                                                                    @php $tv_price = $pe_ex->price1 - $pe_ex->special_price1; @endphp
                                                                    <span class="originalprice">{{ number_format($pe_ex->price1,0) }} </span>
                                                                    <span class="orgtext"><b> {{ number_format(@$tv_price,0) }} บาท</b></span>
                                                                @elseif($pe_ex->special_price2 > 0)
                                                                    @php $tv_price = ($pe_ex->price1+$pe_ex->price2) - $pe_ex->special_price2; @endphp
                                                                    <span class="originalprice">{{ number_format(($pe_ex->price1+$pe_ex->price2),0) }} </span>
                                                                    <span class="orgtext"><b> {{ number_format(@$tv_price,0) }} บาท</b></span>
                                                                @elseif($pe_ex->special_price3 > 0)
                                                                    @php $tv_price = $pe_ex->price3 - $pe_ex->special_price3; @endphp
                                                                    <span class="originalprice">{{ number_format($pe_ex->price3,0) }} </span>
                                                                    <span class="orgtext"><b> {{ number_format(@$tv_price,0) }} บาท</b></span>
                                                                @elseif($pe_ex->special_price4 > 0)
                                                                    @php $tv_price = $pe_ex->price4 - $pe_ex->special_price4; @endphp
                                                                    <span class="originalprice">{{ number_format($pe_ex->price4,0) }} </span>
                                                                    <span class="orgtext"><b> {{ number_format(@$tv_price,0) }} บาท</b></span>
                                                                @else
                                                                    <span class="orgtext"><b> {{ number_format($pe_ex->price1,0) }} บาท</b></span>
                                                                @endif
                                                            </span>
                                                            </li>
                                                        @endforeach
                                                    </div>
                                                    <hr>
                                                    <a href="{{url('tour/'.$ex[0]->slug)}}" class="btn-main-og morebtnog">รายละเอียด</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            @endforeach
                        @endif
                    </div>
                    @php
                            $count_p = 1;
                            $page_data = array();
                            $check_pro = false;
                            $check_price = false;
                            // dd($row);
                            foreach ($row as  $r) {
                                //    if(!isset($page_data[$count_p])){
                                //      $page_data[$count_p] = array();
                                //    }
                                $pro_data = array();
                                $key = null;
                                foreach ($r as $p => $pt) {
                                    // dd($r);
                                    $check_pro = false;
                                    $check_price = false;
                                    $date_now_pro = strtotime(date('Y-m-d'));
                                    $date_start_pro = strtotime($pt->pro_start_date);
                                    $date_end_pro = strtotime($pt->pro_end_date);
                                    // dd($date_start_pro,$date_now_pro,$date_end_pro);
                                    if($date_start_pro <= $date_now_pro && $date_end_pro >=  $date_now_pro){
                                        // $page_data[$count_p][] = $pt;
                                        $check_pro = true;
                                        // echo "$pt->t_id-$check_pro<br>";
                                        
                                    }else if($pt->special_price1 > 0 || $pt->special_price2 > 0 || $pt->special_price3 > 0 || $pt->special_price4 > 0 && $pt->promotion2 == 'Y'){
                                        // $page_data[$count_p][] = $pt;
                                        $check_price = true;
                                    }
                                    if($check_pro || $check_price){
                                        $pro_data[] = $pt;
                                        // break;
                                    }
                                }
                                if(count($pro_data)){
                                    $page_data[$count_p][] = $pro_data;
                                }
                                if(isset($page_data[$count_p])){
                                    if(count($page_data[$count_p]) >= 6){
                                        $count_p++;
                                    }
                                
                                }
                            }
                           
                        //   dd(count($page_data),$page_data);
                        @endphp
                    <div class="row mt-5">
                        <div class="col">
                            @if(isset($page_data[$page]))
                                    <div class="titletopic">
                                        <h2>โปรโมชั่นทัวร์</h2>
                                        <p>แนะนำทัวร์สุดคุ้ม ให้คุณเที่ยวอย่างคุ้มค่า ที่นั่งเต็มไวมาก อย่าลังเล
                                            รีบเช็คราคาและที่ว่างด่วน!</p>
                                    </div>
                            @endif
                        </div>
                    </div>
                    <div class="row mt-3" id="show_filter">
                        @if(isset($page_data[$page]))
                        @php
                             $check_date = false;
                             $check_promo2 = 'N';
                             $check_tag = 'N';
                        @endphp
                            @foreach ($page_data[$page] as  $pro_page)
                                <?php 
                                    //$tour  = App\Models\Backend\TourModel::find($pro[0]->tour_id);
                                    $tag = null;
                                    $check_date_end = array();
                                    foreach ($pro_page  as  $pro) {
                                        $check_date = false;
                                        $check_promo2 = 'N';
                                        $check_tag = 'N';
                                        if(!$tag){
                                            @$promotion  = App\Models\Backend\PromotionModel::where('id',$pro->pr_promotion)->where('status','on')->first();
                                            @$tag = App\Models\Backend\PromotionTagModel::find($promotion->tag_id);
                                        }
                                        $date_now = strtotime(date('Y-m-d'));
                                        $date_start = strtotime($pro->pro_start_date);
                                        $date_end = strtotime($pro->pro_end_date);
                                        if($date_start <= $date_now && $date_end >=  $date_now){
                                            $check_date = true;
                                            $check_date_end[$pro->t_id][] = $pro->pro_end_date;
                                            // dd($check_date_end,$pro_page[0]->t_id);
                                        }
                                        if($pro->promotion2 == 'Y'){
                                            $check_promo2 = 'Y';
                                        }else if($pro->pr_promotion && $pro->pro_start_date && $pro->pro_end_date ){
                                            $check_tag = 'Y';
                                        }
                                           
                                    // echo "$pro_page[0]<br>";
                                    }
                                 
                                ?>  
                                @if($check_promo2 == 'Y' || $check_tag = 'Y' )
                                <div class="col-lg-6 col-xl-4">
                                       <div class="showvertiGroup">
                                           <div class="boxwhiteshd">
                                               <div class="hoverstyle">
                                                   <div class="groupweekpos">
                                                       <figure>
                                                           <a href="{{url('tour/'.$pro_page[0]->slug)}}"><img src="{{asset($pro_page[0]->image)}}" class="img-fluid"
                                                                   alt=""></a>
                                                       </figure>
                                                      
                                                       @if($pro_page[0]->pr_promotion && $check_date)
                                                            <div class="tagforpromotion_g">
                                                                <img src="{{asset(@$tag->img)}}" alt="">
                                                            </div>
                                                        {{-- @endif --}}
                                                       @elseif(!$pro_page[0]->pr_promotion || $check_date == false)
                                                            @if($pro_page[0]->special_price1 > 0)
                                                            @php $tv_price = $pro_page[0]->price1 - $pro_page[0]->special_price1; @endphp
                                                                <div class="saleonpicbox">
                                                                    <span> ลดราคาพิเศษ</span> <br>
                                                                    {{number_format($pro_page[0]->special_price1,0)}} บาท <br>
                                                                    <span>เหลือเริ่ม</span><br>
                                                                    {{number_format(@$tv_price,0)}}  
                                                                </div>
                                                            @elseif($pro_page[0]->special_price2 > 0)
                                                            @php $tv_price = ($pro_page[0]->price1+$pro_page[0]->price2) - $pro_page[0]->special_price2; @endphp
                                                                <div class="saleonpicbox">
                                                                    <span> ลดราคาพิเศษ</span> <br>
                                                                    {{number_format($pro_page[0]->special_price2,0)}} บาท <br>
                                                                    <span>เหลือเริ่ม</span><br>
                                                                    {{number_format(@$tv_price,0)}}  
                                                                </div>
                                                            @elseif($pro_page[0]->special_price3 > 0)
                                                                @php $tv_price = $pro_page[0]->price3 - $pro_page[0]->special_price3; @endphp
                                                                    <div class="saleonpicbox">
                                                                        <span> ลดราคาพิเศษ</span> <br>
                                                                        {{number_format($pro_page[0]->special_price3,0)}} บาท <br>
                                                                        <span>เหลือเริ่ม</span><br>
                                                                        {{number_format(@$tv_price,0)}}  
                                                                    </div>
                                                            @elseif($pro_page[0]->special_price4 > 0)
                                                                @php $tv_price = $pro_page[0]->price4 - $pro_page[0]->special_price4; @endphp
                                                                    <div class="saleonpicbox">
                                                                        <span> ลดราคาพิเศษ</span> <br>
                                                                        {{number_format($pro_page[0]->special_price4,0)}} บาท <br>
                                                                        <span>เหลือเริ่ม</span><br>
                                                                        {{number_format(@$tv_price,0)}}  
                                                                    </div>       
                                                            @endif
                                                       @endif
                                                       @if($pro_page[0]->special_price1 > 0)
                                                            @php $tv_price = $pro_page[0]->price1 - $pro_page[0]->special_price1; @endphp
                                                                <div class="tagdiscount_n">
                                                                    <span class="pricegroup">
                                                                        <span class="originalprice"> {{number_format($pro_page[0]->price1,0)}}</span>
                                                                        <span class="orgtext"> <b> {{number_format(@$tv_price,0)}} บาท</b></span>
                                                                    </span>
                                                                </div>
                                                        @elseif($pro_page[0]->special_price2 > 0)
                                                            @php $tv_price = ($pro_page[0]->price1+$pro_page[0]->price2) - $pro_page[0]->special_price2; @endphp
                                                                <div class="tagdiscount_n">
                                                                    <span class="pricegroup">
                                                                        <span class="originalprice"> {{number_format(($pro_page[0]->price1+$pro_page[0]->price2),0)}}</span>
                                                                        <span class="orgtext"> <b> {{number_format(@$tv_price,0)}} บาท</b></span>
                                                                    </span>
                                                                </div>
                                                        @elseif($pro_page[0]->special_price3 > 0)
                                                            @php $tv_price = $pro_page[0]->price3 - $pro_page[0]->special_price3; @endphp
                                                                <div class="tagdiscount_n">
                                                                    <span class="pricegroup">
                                                                        <span class="originalprice"> {{number_format($pro_page[0]->price3,0)}}</span>
                                                                        <span class="orgtext"> <b> {{number_format(@$tv_price,0)}} บาท</b></span>
                                                                    </span>
                                                                </div>
                                                        @elseif($pro_page[0]->special_price4 > 0)
                                                            @php $tv_price = $pro_page[0]->price4 - $pro_page[0]->special_price4; @endphp
                                                                <div class="tagdiscount_n">
                                                                    <span class="pricegroup">
                                                                        <span class="originalprice"> {{number_format($pro_page[0]->price4,0)}}</span>
                                                                        <span class="orgtext"> <b> {{number_format(@$tv_price,0)}} บาท</b></span>
                                                                    </span>
                                                                </div>  
                                                        @endif
                                                        @if(isset($check_date_end[$pro_page[0]->t_id][0]))
                                                            <div class="tagweekend_verti">
                                                                <i class="fi fi-rr-calendar-clock"></i> โปรโมชั่นสิ้นสุด {{date('d/m/Y',strtotime(@$check_date_end[$pro_page[0]->t_id][0]))}} 
                                                            </div>
                                                        @endif
                                                   </div>
                                               </div>
                                               <div class="contenttourshw">
                                                   <h3>ทัวร์{{$pro_page[0]->name}} {{@$promotion->promotion_name}}</h3>
                                                   <div class="listperiod">
                                                       @foreach ($pro_page as $pe_ex)
                                                           <li><span class="month">{{ $month[date('n',strtotime($pe_ex->start_date))] }}</span> {{date('d',strtotime($pe_ex->start_date))}} {{ $month[date('n',strtotime($pe_ex->start_date))] }} - {{date('d',strtotime($pe_ex->end_date))}} {{ $month[date('n',strtotime($pe_ex->end_date))] }}
                                                               <span class="pricegroup">
                                                                    @if($pe_ex->special_price1 > 0)
                                                                        @php $tv_price = $pe_ex->price1 - $pe_ex->special_price1; @endphp
                                                                        <span class="originalprice">{{ number_format($pe_ex->price1,0) }} </span>
                                                                        <span class="orgtext"><b> {{ number_format(@$tv_price,0) }} บาท</b></span>
                                                                    @elseif($pe_ex->special_price2 > 0)
                                                                        @php $tv_price = ($pe_ex->price1+$pe_ex->price2) - $pe_ex->special_price2; @endphp
                                                                        <span class="originalprice">{{ number_format(($pe_ex->price1+$pe_ex->price2),0) }} </span>
                                                                        <span class="orgtext"><b> {{ number_format(@$tv_price,0) }} บาท</b></span>
                                                                    @elseif($pe_ex->special_price3 > 0)
                                                                        @php $tv_price = $pe_ex->price3 - $pe_ex->special_price3; @endphp
                                                                        <span class="originalprice">{{ number_format($pe_ex->price3,0) }} </span>
                                                                        <span class="orgtext"><b> {{ number_format(@$tv_price,0) }} บาท</b></span>
                                                                    @elseif($pe_ex->special_price4 > 0)
                                                                        @php $tv_price = $pe_ex->price4 - $pe_ex->special_price4; @endphp
                                                                        <span class="originalprice">{{ number_format($pe_ex->price4,0) }} </span>
                                                                        <span class="orgtext"><b> {{ number_format(@$tv_price,0) }} บาท</b></span>
                                                                    @else
                                                                        <span class="orgtext"><b> {{ number_format($pe_ex->price1,0) }} บาท</b></span>
                                                                    @endif
                                                               </span>
                                                           </li>
                                                       @endforeach
                                                   </div>
                                                   <hr>
                                                   <a href="{{url('tour/'.$pro->slug)}}" class="btn-main-og morebtnog">รายละเอียด</a>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                    <div class="row mt-4 mb-4">
                        <div class="col">
                            <div class="pagination_bot" id="paginate">
                                <nav class="pagination-container">
                                    <div class="pagination">
                                        <?php $total_page = count($page_data); 
                                            $older = $page+1;    
                                            $newer = $page-1; 
                                        ?>
                                        <?php if($total_page > 1){?>
                                        @if($page != $newer && $page != 1)
                                            <a class="pagination-newer" href="?page={{$newer}}"><i class="fas fa-angle-left"></i></a>
                                        @endif
                                        <span class="pagination-inner">
                                            <?php for($i=1; $i<=$total_page; $i++){ ?> 
                                                <a class="<?php if($i == $page) { echo 'pagination-active';}?>"  href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                            <?php } ?>
                                        </span>
                                        @if($page != $older && $page != $total_page)
                                            <a class="pagination-older" href="?page={{$older}}"><i class="fas fa-angle-right"></i></a>
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
    </section>
    @include("frontend.layout.inc_footer")
    <script>
        $(document).ready(function () {
            $('.categoryslide_list').owlCarousel({
                loop: true,
                item: 1,
                margin: 0,
                slideBy: 1,
                autoplay: false,
                smartSpeed: 2000,
                nav: true,
                navText: ['<img src="{{asset('frontend/images/arrowRight.svg')}}">', '<img src="{{asset('frontend/images/arrowLeft.svg')}}">'],
                navClass: ['owl-prev', 'owl-next'],
                dots: false,
                responsive: {
                    0: {
                        items: 6,
                        margin: 0,
                        nav: false,


                    },
                    600: {
                        items: 6,
                        margin: 0,
                        nav: false,

                    },
                    1024: {
                        items: 6,
                        slideBy: 1
                    },
                    1200: {
                        items: 8,
                        slideBy: 1
                    }
                }
            })



        });
    </script>
    <script>
        var active = null;
        function Promotion_filter(promo_id,id_tour){
            if(active){
                $("#"+active).removeClass('active');
            }
            $("#"+promo_id).addClass('active');
            active = promo_id;
            $.ajax({
                type: 'POST',
                url: '{{url("/promotiontour-filter")}}',
                data:  {
                    _token: '{{csrf_token()}}',
                    tour_id:id_tour,
                },
                success: function (data) {
                    document.getElementById('show_filter').innerHTML = data; 
                    document.getElementById('paginate').innerHTML = null;
                }
            });
        }
    </script>
</body>

</html>