
@php
      $months =['','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
@endphp
@foreach ($data as $pro_page)

<?php 
                               
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
                                        }
                                        if($pro->promotion2 == 'Y'){
                                            $check_promo2 = 'Y';
                                        }else if($pro->pr_promotion && $pro->pro_start_date && $pro->pro_end_date ){
                                            $check_tag = 'Y';
                                        }
                                    }
                                 
                                ?>  
   @if($check_promo2 == 'Y' || $check_tag = 'Y')
   <div class="col-lg-4">
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
                           <li><span class="month">{{ $months[date('n',strtotime($pe_ex->start_date))] }}</span> {{date('d',strtotime($pe_ex->start_date))}} {{ $months[date('n',strtotime($pe_ex->start_date))] }} - {{date('d',strtotime($pe_ex->end_date))}} {{ $months[date('n',strtotime($pe_ex->end_date))] }}
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