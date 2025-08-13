@php
    $tag = null;
    $check_date_end = array();
    $promo_name = array();
@endphp
<input type="hidden" id="check_datahot{{$page}}" value="{{$check_data}}">
@foreach ($tour as $t)
@php
    $period_data = $t->period->whereIn('id',$period_id)->first();
@endphp
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
                                <div class="tagfire">
                                    <i class="bi bi-fire"></i> ทัวร์ไฟไหม้
                                </div>
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
                        </div>
                    </div>
                    <div class="contenttourshw">
                        <h3>ทัวร์{{$t->name}} </h3>
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
   
@endforeach