<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    @include("frontend.layout.inc_header")
    <?php $pageName="weekend";?>
	
</head>

<body>
    @include("frontend.layout.inc_topmenu")
    <section id="weekendpage" class="wrapperPages">
        <div class="container-fluid g-0 overflow-hidden">
            <div class="row">
                <div class="col">
                    <div class="bannereach-left">
                        @php
                            // ดึงวันที่ใกล้กับปัจจุบันที่สุดมาแสดง
                            $date_asc = \App\Models\Backend\CalendarModel::where(['status'=>'on','deleted_at'=>null])->where('start_date','>=',date('Y-m-d'))->orderby('start_date','asc')->first();
                            // dd($date_asc);
                            if($date_asc){
                                $check_start = date('m',strtotime($date_asc->start_date));
                                $check_end = date('m',strtotime($date_asc->end_date));

                                $carbonDate = \Carbon\Carbon::createFromFormat('Y-m-d', $date_asc->start_date)->locale('th');
                                $day_start = $carbonDate->isoFormat('dddd');
                                $date_start = $carbonDate->isoFormat('D');
                                $month_start = $carbonDate->isoFormat('MMMM');

                                $carbonEnd = \Carbon\Carbon::createFromFormat('Y-m-d', $date_asc->end_date)->locale('th');
                                $day_end = $carbonEnd->isoFormat('dddd');
                                $date_end = $carbonEnd->isoFormat('D');
                                $month_end = $carbonEnd->isoFormat('MMMM');
                            }
                            
                        @endphp
                        <img src="{{asset($banner->img)}}" alt="">
                        <div class="bannercaption">
                           {{-- <h1>ทัวร์ตามเทศกาล</h1> --}}
                           {!! $banner->detail !!}
                        </div>
                        @if($date_asc)
                            <div class="weekendtoprec">
                                <div class="datecalendarshow text-center"> 
                                        <span class="month">@if($check_start == $check_end) {{$month_start}} @else {{@$month_start}} - {{$month_end}} @endif</span> 
                                    <h2> {{@$date_start}} - {{@$date_end}}</h2> 
                                    <span class="day">วัน{{@$day_start}} - {{@$day_end}}</span> 
                                </div>
                            <div class="detail">
                            <h2>{{@$date_asc->holiday}}</h2>
                                <p>{{@$date_asc->description}}</p>
                                    <a href="{{url('weekend-landing/'.@$date_asc->id)}}" class="btn-white-main morebtn">ดูรายการของเทศกาลนี้</a>
                            </div>
                            </div> 
                        @endif   
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-5">
                <div class="col">
                    <div class="titletopic">
                        <h2>ทัวร์เทศกาลยอดนิยม</h2>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                @php
                    $tour = \App\Models\Backend\TourModel::where('status','on')->where('deleted_at',null)->get();
                @endphp
                @foreach($data as $dat)
                @php
                        $count_p = 0;
                        $period = \App\Models\Backend\TourPeriodModel::leftjoin('tb_tour','tb_tour_period.tour_id','=','tb_tour.id')
                        ->whereDate('tb_tour_period.start_date','>=',$dat->start_date)
                        ->whereDate('tb_tour_period.start_date','<=',$dat->end_date)
                        ->where('tb_tour.status','on')
                        ->where('tb_tour_period.status_display','on')
                        ->orderby('tb_tour_period.start_date','asc')
                        ->get()
                        ->groupBy('tour_id');
                        
                        $count_p = $count_p + count($period);
                        // dd($period);
                    
                @endphp
                @if($count_p > 0)
                    <div class="col-lg-4 mb-4">
                        <div class="hoverstyle weekdetails">
                            <figure>
                                <a href="{{url('weekend-landing/'.$dat->id)}}"><img src="{{asset($dat->img_cover)}}" class="img-fluid" alt=""></a>
                            </figure>
                            <br>
                            <center><a href="{{url('weekend-landing/'.$dat->id)}}" class="linkss">{{$count_p}} โปรแกรมทัวร์</a></center>
                        </div>
                    </div>
                @endif
                @endforeach
            </div>
        </div>
    </section>
    @include("frontend.layout.inc_footer")

</body>

</html>