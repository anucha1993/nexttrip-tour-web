<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>  @include("frontend.layout.inc_header")
</head>

<body>
    @include("frontend.layout.inc_topmenu")
    <section id="memberpage" class="wrapperPages">
        <div class="container">
            <div class="row mt-0 mt-lg-5">
                <div class="col-lg-4">
                    <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                        <div class="titletopic mb-4">
                            <h1>บัญชีของฉัน</h1>
                        </div>
                    </div>
                    <div class="boxfaqlist sticky-top">
                        <div class="d-flex align-items-start ">
                            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home"
                                    aria-selected="true" ><i class="fi fi-rr-calendar"></i> การจองของฉัน</button>

                                <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-messages" type="button" role="tab"
                                    aria-controls="v-pills-messages" aria-selected="false" ><i
                                        class="fi fi-rr-comment-alt"></i> โปรโมชั่น <span
                                        class="alrt-nb" id="count_read">({{$read_message}})</span></button>

                                <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-profile" type="button" role="tab"
                                    aria-controls="v-pills-profile" aria-selected="false" ><i class="fi fi-rr-user"></i>
                                    ข้อมูลส่วนตัว</button>
                            </div>
                        </div>
                        <center class="pb-3"> <a href="javascript:void(0);" onClick="logOut()" class="logoutbtn">ออกจากระบบ</a></center>
                    </div>


                </div>
                <div class="col-lg-8 mt-4 mt-lg-0">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                            aria-labelledby="v-pills-home-tab" tabindex="0">
                            <div class="titletopic mt-5 mb-4">
                                <h2>การจองของฉัน</h2>
                            </div>
                            @php
                                 $month = ['','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
                            @endphp
                            @foreach($booking as $b => $book)
                            <div class="bookmain" id="list_book{{$b+1}}">
                                @php
                                    $tour = App\Models\Backend\TourModel::find($book->tour_id);
                                    $period = App\Models\Backend\TourPeriodModel::find($book->period_id);
                                    $airline = App\Models\Backend\TravelTypeModel::find(@$tour->airline_id);
                                    $start_date = date('d',strtotime($period->start_date)).' '.$month[date('n',strtotime($period->start_date))].' '.date('Y',strtotime($period->start_date));
                                    $end_date = date('d',strtotime($period->end_date)).' '.$month[date('n',strtotime($period->end_date))].' '.date('Y',strtotime($period->end_date));
                                @endphp
                                <div class="boxbooking-list  hoverstyle" >
                                    <div class="row">
                                        <div class="col-lg-9">
                                            <div class="row">
                                                <div class="col bookdetailone">
                                                    หมายเลขการจอง <span class="numberss">{{$book->code}}</span>
                                                    @if($book->status == "Booked")
                                                        <div class="bookstatus-box status01">รอคอนเฟิร์มที่นั่ง</div>
                                                    @elseif($book->status == "Waiting")
                                                        <div class="bookstatus-box status02">รอที่นั่ง</div>
                                                    @elseif($book->status == "Pay")
                                                        <div class="bookstatus-box status03">รอชำระเงิน</div>
                                                    @elseif($book->status == "Success")
                                                        <div class="bookstatus-box status04">จองสำเร็จ</div>
                                                    @elseif($book->status == "Cancel")
                                                        <div class="bookstatus-box status05">ยกเลิกการจอง</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <div class="bookdetailtwo">
                                                        <li> รหัสทัวร์ : <span class="bluetext">@if($tour->code1_check){{$tour->code1}} @else {{$tour->code}} @endif</span> </li>
                                                        <li>วันที่เดินทาง : {{$start_date}} - {{$end_date}}</li>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-3 col-lg-3">
                                                    <div class="airline-logo">
                                                        <img src="{{asset(@$airline->image)}}" alt="">
                                                    </div>

                                                </div>
                                                <div class="col-9 col-lg-9">
                                                    <div class="content-dt">
                                                        <p>{{$tour->name}}</p>
                                                        <span class="orgtext"> <b>{{number_format($tour->price,0)}} บาท</b></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 mt-3 mt-lg-0">
                                            <figure>
                                                <a href="{{url('tour/'.@$tour->slug)}}" target="_blank"><img src="{{asset($tour->image)}}" alt=""></a>
                                            </figure>
                                            <center class="pt-2"> <a href="javascript:void(0);" onClick="tour_detail({{$b+1}})" class="smsize pt-3">ดูรายละเอียด</a>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bookpage" id="detail_book{{$b+1}}">
                                <div class="boxbooking-list mt-3" >
                                    <div class="row">
                                        <div class="col-6 col-lg-6 bookdetailone">
                                            หมายเลขการจอง <span class="numberss">{{$book->code}}</span>
                                        </div>
                                        <div class="col-6 col-lg-6 lgtext text-end">
                                            วันที่ทำการจอง {{date('d/m/Y H:i',strtotime($book->created_at))}}
                                        </div>
                                    </div>
                                    <hr class="mt-2 mb-2">
                                    <div class="row">
                                        <div class="col-6 col-lg-6">
                                            สถานะการจอง
                                        </div>
                                        <div class="col-6 col-lg-6 text-end">
                                            <div class="orgtext"> 
                                                @if($book->status == "Booked")
                                                        <b>รอคอนเฟิร์มที่นั่ง</b>
                                                @elseif($book->status == "Waiting")
                                                        <b>รอที่นั่ง</b>
                                                @elseif($book->status == "Pay")
                                                        <b>รอชำระเงิน </b>
                                                @elseif($book->status == "Success")
                                                        <b>จองสำเร็จ</b>
                                                @elseif($book->status == "Cancel")
                                                        <b>ยกเลิกการจอง</b>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="titletopic">
                                    <h3>ข้อมูลการจอง</h3>
                                </div>
                                <div class="boxbooking-list  hoverstyle mt-3">
                                    <div class="row">
                                        <div class="col-lg-9">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="bookdetailtwo">
                                                        <li> รหัสทัวร์ : <span class="bluetext">@if($tour->code1_check){{$tour->code1}} @else {{$tour->code}} @endif</span> </li>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-3 col-lg-3">
                                                    <div class="airline-logo">
                                                        <img src="{{asset(@$airline->image)}}" alt="">
                                                    </div>
                                                </div>
                                                <div class="col-9 col-lg-9">
                                                    <div class="content-dt">
                                                        <p>{{$tour->name}}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-5 col-lg-4">วันที่เดินทาง :</div>
                                                <div class="col-7 col-lg-8"><b>{{$start_date}} - {{$end_date}}</b></div>
                                                <div class="w-100 mb-2"></div>
                                                @if($book->num_twin > 0)
                                                    <div class="col-5  col-lg-4">ผู้ใหญ่พักคู่ :</div>
                                                    <div class="col-7 col-lg-8"><b>{{$book->num_twin}} คน</b></div>
                                                    <div class="w-100 mb-2"></div>
                                                    <div class="col-5 col-lg-4">ราคาต่อคนผู้ใหญ่พักคู่ :</div>
                                                    <div class="col-7 col-lg-8"><b>{{number_format($book->price1,2)}} บาท</b></div>
                                                    <div class="w-100 mb-2"></div>
                                                    <div class="col-5 col-lg-4">ราคารวมผู้ใหญ่พักคู่ :</div>
                                                    <div class="col-7 col-lg-8"><b>{{number_format($book->sum_price1,2)}} บาท</b></div>
                                                    <div class="w-100 mb-2"></div>
                                                @endif
                                                @if($book->num_single > 0)
                                                    <div class="col-5  col-lg-4">ผู้ใหญ่พักเดี่ยว :</div>
                                                    <div class="col-7 col-lg-8"><b>{{$book->num_single}} คน</b></div>
                                                    <div class="w-100 mb-2"></div>
                                                    <div class="col-5 col-lg-4">ราคาต่อคนผู้ใหญ่พักเดี่ยว :</div>
                                                    <div class="col-7 col-lg-8"><b>{{number_format($book->price2,2)}} บาท</b></div>
                                                    <div class="w-100 mb-2"></div>
                                                    <div class="col-5 col-lg-4">ราคารวมผู้ใหญ่พักเดี่ยว :</div>
                                                    <div class="col-7 col-lg-8"><b>{{number_format($book->sum_price2,2)}} บาท</b></div>
                                                    <div class="w-100 mb-2"></div>
                                                @endif
                                                @if($book->num_child > 0)
                                                    <div class="col-5  col-lg-4">เด็กมีเตียง :</div>
                                                    <div class="col-7 col-lg-8"><b>{{$book->num_child}} คน</b></div>
                                                    <div class="w-100 mb-2"></div>
                                                    <div class="col-5 col-lg-4">ราคาต่อคนเด็กมีเตียง :</div>
                                                    <div class="col-7 col-lg-8"><b>{{number_format($book->price3,2)}} บาท</b></div>
                                                    <div class="w-100 mb-2"></div>
                                                    <div class="col-5 col-lg-4">ราคารวมเด็กมีเตียง :</div>
                                                    <div class="col-7 col-lg-8"><b>{{number_format($book->sum_price3,2)}} บาท</b></div>
                                                    <div class="w-100 mb-2"></div>
                                                @endif
                                                @if($book->num_childnb > 0)
                                                    <div class="col-5  col-lg-4">เด็กไม่มีเตียง :</div>
                                                    <div class="col-7 col-lg-8"><b>{{$book->num_childnb}} คน</b></div>
                                                    <div class="w-100 mb-2"></div>
                                                    <div class="col-5 col-lg-4">ราคาต่อคนเด็กไม่มีเตียง :</div>
                                                    <div class="col-7 col-lg-8"><b>{{number_format($book->price4,2)}} บาท</b></div>
                                                    <div class="w-100 mb-2"></div>
                                                    <div class="col-5 col-lg-4">ราคารวมเด็กไม่มีเตียง :</div>
                                                    <div class="col-7 col-lg-8"><b>{{number_format($book->sum_price4,2)}} บาท</b></div>
                                                    <div class="w-100 mb-2"></div>
                                                @endif
                                                <div class="col-lg-12 mt-3">
                                                    <span class="orgtext"> <b>รวม {{number_format($book->total_price,2)}} บาท</b></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 mt-3 mt-lg-0">
                                            <figure>
                                                <a href="{{url('tour/'.@$tour->slug)}}" target="_blank"><img src="{{asset($tour->image)}}" alt=""></a>
                                            </figure>
                                        </div>
                                    </div>
                                </div>
                                <div class="titletopic">
                                    <h3>ข้อมูลผู้จอง</h3>
                                </div>
                                <div class="boxbooking-list mt-3">
                                    <div class="customerdetail">
                                        <li><b> ชื่อผู้ติดต่อ :</b> {{$book->name}} {{$book->surname}}</li>
                                        <li><b>อีเมล :</b> {{$book->email}}</li>
                                        <li><b>เบอร์โทรศัพท์ : </b> {{$book->phone}}</li>
                                        <li><b>ความต้องการพิเศษ :</b> {!! $book->detail !!} </li>
                                    </div>
                                </div>
                                <center><a href="javascript:void(0);" class="btn_mainbook" onClick="hide_book()">ย้อนกลับ</a></center>
                                <br>
                            </div>
                            @endforeach
                        </div>
                        <div class="tab-pane fade" id="v-pills-messages" role="tabpanel"
                            aria-labelledby="v-pills-messages-tab" tabindex="0">
                            <div class="titletopic mt-5 mb-4">
                                <h2>โปรโมชั่น</h2>
                            </div>
                            @php
                                $check_read = json_decode($member->status_message,true);
                            @endphp
                            @foreach ($message as  $m => $mes)
                            @php
                                $textOnly = strip_tags($mes->message);
                                $message_data =  mb_strimwidth($textOnly, 0, 150, "...");
                            @endphp
                            <div class="msgmain">
                                {{-- @if(!in_array($mes->id,$check_read)) --}}
                                <a href="javascript:void(0);" onClick="read_message({{$mes->id}})" @if(!in_array($mes->id,$check_read)) class="boxnoti-unread" @else class="boxnoti-read" @endif id="message{{$mes->id}}">
                                    <div class="iconbl"><i class="fi fi-rr-bell-ring"></i></div>
                                    <div class="content-noti">
                                        <h2>{{$mes->subject}}</h2>
                                        <p>{{$message_data}}</p>
                                    </div>
                                    <div class="stdate">{{date('d/m/Y',strtotime($mes->created_at))}}</div>
                                </a>
                                {{-- @endif --}}
                                {{-- @if(in_array($mes->id,$check_read))
                                    <a href="javascript:void(0);" onClick="read_message({{$mes->id}})" class="boxnoti-read" id="message{{$mes->id}}">
                                        <div class="iconbl"><i class="fi fi-rr-bell-ring"></i></div>
                                        <div class="content-noti">
                                            <h2>{{$mes->subject}}</h2>
                                            <p>{{$message_data}}</p>
                                        </div>
                                        <div class="stdate">{{date('d/m/Y',strtotime($mes->created_at))}}</div>
                                    </a>
                                @endif --}}
                            </div>
                            <div class="msgdetail" id="message_detail{{$mes->id}}">
                                <div class="boxnoti-read">
                                    <div class="content-noti">
                                        <h2>{{$mes->subject}}</h2>
                                        <p>{!! $mes->message !!}</p>
                                    </div>
                                    <div class="stdate">{{date('d/m/Y',strtotime($mes->created_at))}}</div>
                                </div>
                                <center><a href="javascript:void(0);" class="btn_mainbook" onClick="hide_message()" >ย้อนกลับ</a></center>
                                <br>
                            </div>
                            @endforeach
                        </div>
                        <input type="hidden" value="{{$member->id}}" id="member_id">
                        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                            aria-labelledby="v-pills-profile-tab" tabindex="0">
                            <div class="titletopic  mt-5 mb-4">
                                <h2> ข้อมูลส่วนตัว</h2>
                            </div>
                            <div class="boxaccount">
                                <div class="row">
                                    <div class="col">
                                        <div class="titletopic">
                                            <h3>ข้อมูลสมาชิก</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="nameids" rel="1">
                                    <div class="row">
                                        <div class="col-9 col-lg-10">
                                            <div class="row">
                                                <div class="col-lg-3">อีเมล</div>
                                                <div class="col-lg-9">
                                                    <div class="formGroupacct" id="new_email">
                                                       {{$member->email}}
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">เบอร์โทรศัพท์</div>
                                                <div class="col-lg-9">
                                                    <div class="formGroupacct" id="new_phone">
                                                        {{$member->phone}}
                                                    </div>
                                                </div>
                                                {{-- <div class="col-lg-3">รหัสผ่าน</div>
                                                <div class="col-lg-9">
                                                    <div class="formGroupacct">
                                                        **********
                                                    </div>
                                                </div> --}}
                                            </div>
                                        </div>
                                        <div class="col-3 col-lg-2 text-end">
                                            <a href="javascript:void(0);" class="editLink" rel="1">
                                                <i class="fi fi-rr-pencil"></i>
                                                แก้ไข</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="editnameids" style="display:none;" rel="1">
                                    {{-- <form action="{{url('/update-member')}}" onSubmit="return check_add();">
                                        @csrf --}}
                                        <div class="formGroupacct">
                                                <div class="row">
                                                    <div class="col-lg-5">อีเมล
                                                        <span class="text-danger" id="check_email1"></span>
                                                    </div>
                                                    <div class="col-lg-7">
                                                        <div class="formGroupacct">
                                                            <input type="email" name="email" id="email" class="form-control" value="{{$member->email}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-lg-5">เบอร์โทรศัพท์
                                                        <span class="text-danger" id="check_phone1"></span>
                                                    </div>
                                                    <div class="col-lg-7">
                                                        <div class="formGroupacct">
                                                            <input type="text" name="phone" id="phone" class="form-control" value="{{$member->phone}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                @if($member->login_by == 'R')
                                                    <div class="row">
                                                        <div class="col-lg-5">รหัสผ่าน</div>
                                                        <div class="col-lg-7">
                                                            <div class="formGroupacct">
                                                                <input type="password" name="password" id="password" class="form-control" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-5">ยืนยันรหัสผ่าน
                                                            <span class="text-danger" id="check_confirm1"></span>
                                                        </div>
                                                        <div class="col-lg-7">
                                                            <div class="formGroupacct">
                                                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" >
                                                            </div>
                                                        </div>
                                                    
                                                    </div>
                                                @endif
                                        </div>
                                        <button class="showCT btn-cancel" onClick="cancleUpdate();" type="button"  rel="1">ยกเลิก</button>
                                        <button class="showCT btn-save" onClick="updateMember();" type="button" rel="1">บันทึก</button>
                                        {{-- <a href="javascript:void(0);" onClick="updateMember();" class="showCT btn-save">บันทึก</a> --}}
                                    {{-- </form> --}}
                                </div>
                                <hr class="mt-3 mb-3">
                                <div class="row">
                                    <div class="col">
                                        <div class="titletopic">
                                            <h3>ข้อมูลส่วนตัว</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="nameids" rel="2">
                                    <div class="row">
                                        <div class="col-9 col-lg-10">
                                            <div class="row">
                                                <div class="col-lg-3">ชื่อ-นามสกุล</div>
                                                <div class="col-lg-9">
                                                    <div class="formGroupacct" id="new_name">
                                                        {{$member->name}} {{$member->surname}}
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-3 col-lg-2 text-end">
                                            <a href="javascript:void(0);" class="editLink" rel="2">
                                                <i class="fi fi-rr-pencil"></i>
                                                แก้ไข</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="editnameids" style="display:none;" rel="2">
                                        <div class="formGroupacct">
                                            <div class="row">
                                                <div class="col-lg-3">ชื่อ</div>
                                                <div class="col-lg-9">
                                                    <div class="formGroupacct">
                                                        <input type="text" name="name" id="name" class="form-control"
                                                            value="{{$member->name}}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">นามสกุล</div>
                                                <div class="col-lg-9">
                                                    <div class="formGroupacct">
                                                        <input type="text" name="surname" id="surname" class="form-control"
                                                            value="{{$member->surname}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button class="showCT btn-cancel" onClick="cancleUpdateName();" type="button"  rel="2">ยกเลิก</button>
                                        <button class="showCT btn-save" onClick="updateMember();" type="button" rel="2">บันทึก</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
     @include("frontend.layout.inc_footer")
     <script>
        async function tour_detail(id){
            $('.bookmain').hide();
            $('#detail_book'+id).fadeIn();
        }
        async function read_message(id){
            $('.msgmain').hide();
            $('#message_detail'+id).fadeIn();
            $('#message'+id).removeClass('boxnoti-unread');
            let payload = {
                id:document.getElementById('member_id').value,
                message:id,
               _token: '{{csrf_token()}}',
           }
            $.ajax({
                type: "POST",
                url: '{{url("/update-message")}}',
                data: payload,
                success: function (data) {
                        document.getElementById('count_read').innerHTML = '('+data+')';
                        $('#message'+id).addClass('boxnoti-read');
                }
            });
        }
       
        async function check_add() {
            var password = $('#password').val();
            var confirm_password = $('#confirm_password').val();
            if (password != confirm_password) {
                toastr.error('กรุณากรอกรหัสผ่านให้เหมือนกัน');
                return false;
            }
        }

        async function updateMember() {
        var password_top = $('#password').val();
        var confirm_password_top = $('#confirm_password').val();
        var email = $('#email').val();
        var check_mail = /^([0-9a-zA-Z]([-_\\.]*[0-9a-zA-Z]+)*)@([0-9a-zA-Z]([-_\\.]*[0-9a-zA-Z]+)*)[\\.]([a-zA-Z]{2,9})$/;
        var phone = $('#phone').val();
        var type_login = "{{$member->login_by}}";
        var password_data = null;
        if(password_top != confirm_password_top) {
            alert('กรุณากรอกรหัสผ่านให้ถูกต้อง')
            document.getElementById('check_confirm1').innerHTML = 'กรุณากรอกรหัสผ่านให้เหมือนกัน';
            return false;
        }
        if (!check_mail.test(email) && email) {
            alert('กรุณากรอกอีเมลให้ถูกต้อง')
            document.getElementById('check_email1').innerHTML = 'กรุณากรอกอีเมลให้ถูกต้อง';
            return false
        }
        // if(phone.length != 10 || !Number(phone) || phone.charAt(0) != '0'){
        //     console.log('เข้าif',Number(phone))
        //     document.getElementById('check_phone1').innerHTML = 'กรุณากรอกเบอร์โทรให้ถูกต้อง';
        //     return false
        // }
        if(/* check_mail.test(email) &&  */password_top == confirm_password_top /* && phone.length == 10 && Number(phone) > 1 && phone.charAt(0) == '0' */){
            document.getElementById('check_email1').innerHTML = '';
            document.getElementById('check_phone1').innerHTML = '';
            if(type_login == 'R'){
                document.getElementById('check_confirm1').innerHTML = '';
                password_data = document.getElementById('password').value;
            }
            let payload = {
               name:document.getElementById('name').value,
               surname : document.getElementById('surname').value,
               email:document.getElementById('email').value,
               phone:document.getElementById('phone').value,
               password:password_data,
               _token: '{{csrf_token()}}',
           }
           console.log(type_login,'type_login')
           $.ajax({
              type: 'POST',
               url: '{{url("/update-member")}}',
               data: payload,
               success: function (data) {
                    console.log(data)
                    if(data){
                        Swal.fire({
                                icon: "success",
                                title: "บันทึกข้อมูลสำเร็จ",
                                showConfirmButton: false,
                                timer: 3000,
                        });
                        document.getElementById('name').value = data.name;
                        document.getElementById('surname').value = data.surname;
                        document.getElementById('email').value = data.email ;
                        document.getElementById('phone').value = data.phone;
                        document.getElementById('new_name').innerHTML = data.name+' '+data.surname;
                        document.getElementById('new_email').innerHTML = data.email ;
                        document.getElementById('new_phone').innerHTML = data.phone;
                    }else{
                        Swal.fire({
                                icon: "error",
                                title: "มีอีเมลนี้ในระบบแล้วกรุณากรอกอีเมลใหม่",
                                showConfirmButton: false,
                                timer: 3000,
                        }); 
                        document.getElementById('email').value = "{{$member->email}}" ;
                        document.getElementById('phone').value = "{{$member->phone}}" ;
                        document.getElementById('password').value = null ;
                        document.getElementById('confirm_password').value = null ;
                    }
               },
           });
        //    window.location.reload();
        }
    }
       async function logOut(){
        liff.init({ liffId: '2003705473-mOBqvyPY' },async () => {
                if(liff.isLoggedIn()){
                    await liff.logout();  
                }
                window.location.replace('/logout');  
        });

    }
    function cancleUpdate(){
        document.getElementById('email').value = "{{Auth::guard('Member')->user()->email}}" ;
        document.getElementById('phone').value = "{{$member->phone}}" ;
        document.getElementById('password').value = null ;
        document.getElementById('confirm_password').value = null ;
    }
    function cancleUpdateName(){
        document.getElementById('name').value = "{{$member->name}}" ;
        document.getElementById('surname').value = "{{$member->surname}}" ;
    }
    </script>
    <script>
        async function hide_message(){
            $('.msgdetail').hide();
            $('.msgmain').fadeIn();
        }
        async function hide_book(){
            $('.bookpage').hide();
            $('.bookmain').fadeIn();
        }
        $(document).ready(function () {
            $('.msgdetail').hide();
            // $('#mainbook').click(function (event) {
            //     $('.bookpage').hide();
            //     $('.bookmain').fadeIn();
            //     event.preventDefault();
            // });
            // $('.btn_bookdetail').click(function (event) {
            //     $('.bookmain').hide();
            //     $('.bookpage').fadeIn();
            //     event.preventDefault();
            // });

            $(".editLink").click(function () {
                var rel = $(this).attr("rel");
                $(".editnameids[rel='" + rel + "']").show();
                $(".nameids[rel='" + rel + "']").hide();
            });
            $(".showCT").click(function () {
                var rel = $(this).attr("rel");
                $(".editnameids[rel='" + rel + "']").hide();
                $(".nameids[rel='" + rel + "']").show();
            });


        });
    </script>


</body>


</html>