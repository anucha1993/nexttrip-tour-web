<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head> 
    @include("frontend.layout.inc_header")
</head>

<body>
    @include("frontend.layout.inc_topmenu")
    @php
        if(Session::has('booking') && Session::has('tour')){
            $book = Session::get('booking');
            $tour = Session::get('tour');
        }
    @endphp
    @if(@$book && @$tour)
    <section id="tourdetailspage" class="wrapperPages">
        <div class="container">
            <div class="row mt-10">
                <div class="col">
                    <div class="pageontop_sl">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('')}}">หน้าหลัก </a></li>
                                <li class="breadcrumb-item active" aria-current="page">การจองสำเร็จ</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col topicsuccess text-center">
                    <h2>ขอบคุณที่ทำการจองทัวร์กับ เน็กซ์ ทริป ฮอลิเดย์ </h2>
                    <h3>หมายเลขการจองของคุณ : {{@$book->code}}</h3>
                    <span>การจองทัวร์นี้ยังไม่ใช่การคอนเฟิร์มที่นั่งทันที กรุณารอการตอบกลับจากเจ้าหน้าที่เท่านั้น</span>
                </div>
            </div>
            @php
                $month = ['','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
                $airline = App\Models\Backend\TravelTypeModel::find($tour->airline_id);
            @endphp
            <div class="row mt-5">
                <div class="col">
                    <div class="boxwhiteshd">
                        <div class="row">
                            <div class="col-lg-3 hoverstyle">
                                <figure>
                                    <a href="{{ url('/tour/'.@$tour->slug) }}"><img src="{{asset(@$tour->image)}}" alt=""></a>
                                </figure>
                            </div>
                            <div class="col-lg-9">
                                <span class="orgtext">โปรแกรมทัวร์ที่คุณเลือก</span> <br>
                                @if(@$airline->image)
                                <div class="logoborder mt-2 mb-2">
                                    <img src="{{asset(@$airline->image)}}" class="img-fluid" alt="">
                                </div>
                                @endif
                                <h1>{{$tour->name}} <br>
                                    {{$tour->num_day}} </h1>
                                    <p>รหัสทัวร์ : <span class="bluetext">@if(@$tour->code1_check) {{@$tour->code1}} @else {{@$tour->code}} @endif</span> </p>
                                <p>วันที่ : <span class="bluetext">{{date('d',strtotime($book->start_date))}} {{$month[date('n',strtotime($book->start_date))]}} {{  date('y', strtotime('+543 Years', strtotime($book->start_date))) }} - {{date('d',strtotime($book->end_date))}} {{$month[date('n',strtotime($book->end_date))]}} {{  date('y', strtotime('+543 Years', strtotime($book->end_date))) }}</span> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="row mt-5">
                <div class="col">
                    <div class="sumroomppl_table">
                        <table class="table">
                            <thead>
                                <th>ประเภทห้องพัก</th>
                                <th>จำนวน</th>
                                <th>ราคาต่อคน</th>
                                <th>รวมราคา</th>
                            </thead>
                            <tbody>
                                @if($book->num_twin > 0)
                                <tr>
                                    <td>ผู้ใหญ่ (พักคู่)</td>
                                    <td style="width: 200px;">
                                      {{$book->num_twin}}
                                    </td>
                                    <td>{{number_format($book->price1,2)}}</td>
                                    <td>{{number_format($book->sum_price1,2)}}</td>
                                </tr>
                                @endif
                                @if($book->num_single > 0)
                                <tr>
                                    <td>ผู้ใหญ่ (พักเดี่ยว)</td>
                                    <td style="width: 200px;">
                                      {{$book->num_single}}
                                    </td>
                                    <td>{{number_format($book->price2,2)}}</td>
                                    <td>{{number_format($book->sum_price2,2)}}</td>
                                </tr>
                                @endif
                                @if($book->num_child > 0)
                                <tr>
                                    <td>เด็ก (มีเตียง)</td>
                                    <td style="width: 200px;">
                                      {{$book->num_child}}
                                    </td>
                                    <td>{{number_format($book->price3,2)}}</td>
                                    <td>{{number_format($book->sum_price3,2)}}</td>
                                </tr>
                                @endif
                                @if($book->num_childnb > 0)
                                <tr>
                                    <td>เด็ก (ไม่มีเตียง)</td>
                                    <td style="width: 200px;">
                                      {{$book->num_childnb}}
                                    </td>
                                    <td>{{number_format($book->price4,2)}}</td>
                                    <td>{{number_format($book->sum_price4,2)}}</td>
                                </tr>
                                @endif
                            </tbody>
                            @php
                                $adult = $book->num_twin + $book->num_single;
                                $child = $book->num_child + $book->num_childnb;
                            @endphp
                            <tfoot>
                                <tr>
                                    <th colspan="2">{{$adult}} ผู้ใหญ่, {{$child}} เด็ก</th>
                                    <th></th>
                                    <th>{{number_format($book->total_price,2)}} บาท</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row mt-5 mb-3">
                <div class="col-lg-6">
                    <div class="titletopic mt-2">
                        <h2>ข้อมูลผู้เดินทาง</h2>
                    </div>
                    <div class="formcontact">
                        <div class="row">
                            <div class="col-lg-12">
                                <label>ชื่อ : {{$book->name}}  {{$book->surname}}</label>
                            </div>
                            <div class="col-lg-12">
                                <label>อีเมล์ : {{$book->email}}</label>
                            </div>
                            <div class="col-lg-12">
                                <label>เบอร์โทรศัพท์ : {{$book->phone}}</label>
                            </div>
                            @php
                                $sale = App\Models\Backend\User::find($book->sale_id);
                            @endphp
                            <div class="col-lg-12">
                                <label>Sale : {{@$sale->name}}</label>
                            </div>
                            <div class="col-lg-12">
                                {{-- <label>ความต้องการพิเศษ : ทดสอบ</label> --}}
                                <label>ความต้องการพิเศษ : {{$book->detail}}</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br>
    @else
    <section id="tourdetailspage" class="wrapperPages">
        <div class="container">
            <div class="row mt-5">
                <div class="col">
                    <div class="pageontop_sl">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('')}}">หน้าหลัก </a></li>
                                <li class="breadcrumb-item active" aria-current="page">การจองสำเร็จ</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col topicsuccess text-center">
                    <h2>ขอบคุณที่ทำการจองทัวร์กับ เน็กซ์ ทริป ฮอลิเดย์ </h2>
                    <span>การจองทัวร์นี้ยังไม่ใช่การคอนเฟิร์มที่นั่งทันที กรุณารอการตอบกลับจากเจ้าหน้าที่เท่านั้น</span>
                </div>
            </div>
        </div>
    </section>
    <br>
    @endif
    
    @include("frontend.layout.inc_footer")
</body>

</html>