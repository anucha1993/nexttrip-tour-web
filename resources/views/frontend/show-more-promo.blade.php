@php
    $tag = null;
    $check_date_end = array();
    $promo_name = array();
@endphp
<input type="hidden" id="check_data{{$page}}" value="{{$check_data}}">
@foreach ($tour as $t)
@php
    $period_data = $t->period->whereIn('id',$period_id)->first();
    foreach($t->period as $pre){
        if(in_array($pre->id,$period_id) ){
            $check_date = false;
            $check_promo2 = 'N';
            $check_tag = 'N';
            $check_tag = 'N';
            
            $date_now = strtotime(date('Y-m-d'));
            $date_start = strtotime($pre->pro_start_date);
            $date_end = strtotime($pre->pro_end_date);
            if($date_start <= $date_now && $date_end >=  $date_now){
                $check_date = true;
                $check_date_end[$pre->tour_id][] = $pre->pro_end_date;
                $promo_name[$pre->tour_id][] = $pre->promotion_id;
            }
            if($t->promotion2 == 'Y'){
                $check_promo2 = 'Y';
            }else if($pre->promotion_id && $pre->pro_start_date && $pre->pro_end_date ){
                $check_tag = 'Y';
               
            }
        }
    }
    if(isset($promo_name[$t->id][0]) || !$tag){
        $check_date = true;
        @$promo = App\Models\Backend\PromotionModel::where('id',$promo_name[$t->id][0])->where('status','on')->first();
        @$tag = App\Models\Backend\PromotionTagModel::find($promo->tag_id);
    }
    //dd($promo_name,$promo_name[$t->id][0],$tag->id,$period_data[0]->promotion_id,$check_date);
@endphp
    @if($check_promo2 == 'Y' || $check_tag = 'Y')
        <div class="col-lg-4">
            <div class="showvertiGroup">
                <div class="boxwhiteshd">
                    <div class="hoverstyle">
                        <div class="groupweekpos">
                            <figure>
                                <a href="{{url('tour/'.$t->slug)}}"><img
                                        src="{{asset($t->image)}}"
                                        class="img-fluid" alt=""></a>
                            </figure>
                            @if(isset($promo_name[$t->id][0]) && $check_date)
                                <div class="tagforpromotion_g">
                                    <img src="{{asset(@$tag->img)}}" alt="">
                                </div>
                            @elseif(!isset($promo_name[$t->id][0]) || $check_date == false)
                                    @if($period_data->special_price1 > 0)
                                    @php $tv_price = $period_data->price1 - $period_data->special_price1; @endphp
                                        <div class="saleonpicbox">
                                            <span> ลดราคาพิเศษ</span> <br>
                                            {{number_format($period_data->special_price1,0)}} บาท <br>
                                            <span>เหลือเริ่ม</span><br>
                                            {{number_format(@$tv_price,0)}}  
                                        </div>
                                    @elseif($period_data->special_price2 > 0)
                                    @php $tv_price = ($period_data->price1+$period_data->price2) - $period_data->special_price2; @endphp
                                        <div class="saleonpicbox">
                                            <span> ลดราคาพิเศษ</span> <br>
                                            {{number_format($period_data->special_price2,0)}} บาท <br>
                                            <span>เหลือเริ่ม</span><br>
                                            {{number_format(@$tv_price,0)}}  
                                        </div>
                                    @elseif($period_data->special_price3 > 0)
                                        @php $tv_price = $period_data->price3 - $period_data->special_price3; @endphp
                                            <div class="saleonpicbox">
                                                <span> ลดราคาพิเศษ</span> <br>
                                                {{number_format($period_data->special_price3,0)}} บาท <br>
                                                <span>เหลือเริ่ม</span><br>
                                                {{number_format(@$tv_price,0)}}  
                                            </div>
                                    @elseif($period_data->special_price4 > 0)
                                        @php $tv_price = $period_data->price4 - $period_data->special_price4; @endphp
                                            <div class="saleonpicbox">
                                                <span> ลดราคาพิเศษ</span> <br>
                                                {{number_format($period_data->special_price4,0)}} บาท <br>
                                                <span>เหลือเริ่ม</span><br>
                                                {{number_format(@$tv_price,0)}}  
                                            </div>       
                                    @endif
                            @endif
                            @if($period_data->special_price1 > 0)
                            @php $tv_price = $period_data->price1 - $period_data->special_price1; @endphp
                                <div class="tagdiscount_n">
                                    <span class="pricegroup">
                                        <span class="originalprice"> {{number_format($period_data->price1,0)}}</span>
                                        <span class="orgtext"> <b> {{number_format(@$tv_price,0)}} บาท</b></span>
                                    </span>
                                </div>
                            @elseif($period_data->special_price2 > 0)
                            @php $tv_price = ($period_data->price1+$period_data->price2) - $period_data->special_price2; @endphp
                                <div class="tagdiscount_n">
                                    <span class="pricegroup">
                                        <span class="originalprice"> {{number_format(($period_data->price1+$period_data->price2),0)}}</span>
                                        <span class="orgtext"> <b> {{number_format(@$tv_price,0)}} บาท</b></span>
                                    </span>
                                </div>
                            @elseif($period_data->special_price3 > 0)
                            @php $tv_price = $period_data->price3 - $period_data->special_price3; @endphp
                                <div class="tagdiscount_n">
                                    <span class="pricegroup">
                                        <span class="originalprice"> {{number_format($period_data->price3,0)}}</span>
                                        <span class="orgtext"> <b> {{number_format(@$tv_price,0)}} บาท</b></span>
                                    </span>
                                </div>
                            @elseif($period_data->special_price4 > 0)
                            @php $tv_price = $period_data->price4 - $period_data->special_price4; @endphp
                                <div class="tagdiscount_n">
                                    <span class="pricegroup">
                                        <span class="originalprice"> {{number_format($period_data->price4,0)}}</span>
                                        <span class="orgtext"> <b> {{number_format(@$tv_price,0)}} บาท</b></span>
                                    </span>
                                </div>  
                            @endif
                            @if(isset($check_date_end[$t->id][0]))
                                <div class="tagweekend_verti">
                                    <i class="fi fi-rr-calendar-clock"></i> โปรโมชั่นสิ้นสุด {{date('d/m/Y',strtotime(@$check_date_end[$t->id][0]))}} 
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="contenttourshw">
                        <h3>ทัวร์{{$t->name}} 
                            @if(isset($promo_name[$t->id][0]) && $check_date)
                                {{@$promo->promotion_name}}
                            @endif
                        </h3>
                        <div class="listperiod">
                            @foreach($t->period as $pe_ex)
                                @if(in_array($pe_ex->id,$period_id))
                                <li><span class="month">{{ $month[date('n',strtotime($pe_ex->start_date))] }}</span> 
                                    {{date('d',strtotime($pe_ex->start_date))}} {{ $month[date('n',strtotime($pe_ex->start_date))] }} - {{date('d',strtotime($pe_ex->end_date))}} {{ $month[date('n',strtotime($pe_ex->end_date))] }}
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
                                @endif
                            @endforeach
                        </div>
                        <hr>
                        <a href="{{url('tour/'.$t->slug)}}" class="btn-main-og morebtnog">รายละเอียด</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach