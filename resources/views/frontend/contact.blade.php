<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head> 
    @include("frontend.layout.inc_header")
</head>

<body>
    @include("frontend.layout.inc_topmenu")
    <section id="contactpage" class="wrapperPages">
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
            <div class="row">
                <div class="col">
                    <div class="contactpp boxwhiteshd">
                        <div class="row">
                            <div class="col-lg-4 border-end">
                                <span>
                                    <img src="{{asset('frontend/images/sale_icon.svg')}}" alt="">
                                </span> <br>
                                <h3>แผนกขายหน้าร้านติดต่อ</h3>
                                <div class="boxog">{{$row->phone_front}}</div>
                            </div>
                            <div class="col-lg-4 border-end mt-3 mt-lg-0">
                                <span>
                                    <img src="{{asset('frontend/images/group_icon.svg')}}" alt="">
                                </span> <br>
                                <h3>แผนกกรุ๊ปเหมาติดต่อ</h3>
                                <div class="boxog">{{$row->phone_group}}</div>
                            </div>
                            <div class="col-lg-4 mt-3 mt-lg-0">
                                <span>
                                    <img src="{{asset('frontend/images/comment_icon.svg')}}" alt="">
                                </span> <br>
                                <h3>ร้องเรียนปัญหาติดต่อ</h3>
                                <div class="boxog">{{$row->phone_problem}}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-xl-6 contactinfo">
                    <h3><img src="{{asset('frontend/images/location_icon.svg')}}" alt=""> บริษัท เน็กซ์ ทริป ฮอลิเดย์ จำกัด </h3>
                    {!! $row->address !!}
                    <hr>
                    <h3><img src="{{asset('frontend/images/time_icon.svg')}}" alt=""> วัน-เวลาทำการ </h3>
                    <p>{{ $row->time }}</p>
                    <hr>
                    <h3><img src="{{asset('frontend/images/build_icon.svg')}}" alt=""> ติดต่อสำนักงาน </h3>
                    <p>{{ $row->office }}</p><br>
                    <hr>
                    <h3><img src="{{asset('frontend/images/phone_icon1.svg')}}" alt=""> สายด่วน</h3>
                    <p>{{ $row->hotline }}</p><br>
                    <hr>

                </div>
                <div class="col-lg-7 col-xl-6">
                    <form action="{{url('send-email')}}" method="post" enctype="multipart/form-data" >
                        @csrf
                        <div class="contactform boxwhiteshd">
                            <div class="titletopic">
                                <h2>แบบฟอร์มติดต่อเรา</h2>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <label>ชื่อผู้ติดต่อ <span>*</span></label>
                                    <input type="text" class="form-control" placeholder="กรอกชื่อผู้ติดต่อ" name="name" required >
                                </div>
                                <div class="col-lg-6">
                                    <label>นามสกุล <span>*</span></label>
                                    <input type="text" name="surname" required class="form-control" placeholder="กรอกชื่อผู้ติดต่อ">
                                </div>
                                <div class="col-lg-6">
                                    <label>บริษัท </label>
                                    <input type="text" name="company" class="form-control" placeholder="กรอกบริษัท">
                                </div>
                                <div class="col-lg-6">
                                    <label>อีเมล <span>*</span></label>
                                    <input type="text"  name="mail" required class="form-control" placeholder="กรอกอีเมลของท่าน">
                                </div>
                                <div class="col-lg-12">
                                    <label>เบอร์โทรศัพท์ <span>*</span></label>
                                    <input type="text" id="phone_data"  name="phone" required  class="form-control" placeholder="กรอกเบอร์โทรศัพท์">
                                </div>
                                <div class="col-lg-12">
                                    <label>รายละเอียดเนื้อหา</label>
                                    <textarea name="detail" id="" cols="30" rows="10" placeholder="กรุณาระบุรายละเอียด"
                                        class="form-control textboxx"></textarea>
                                </div>
                                <div class="col-lg-12">
                                    <label>ท่านรู้จักเราจาก <span>*</span></label>
                                    <select class="form-select" aria-label="Default select example" name="topic_id" id="topic_id" required>
                                        <option value="" hidden>กรุณาเลือก</option>
                                        @foreach($topic as $top)
                                        <option  value="{{$top->id}}">{{$top->topic}}</option>
                                        @endforeach
                                    </select>
                                </div> 
                            </div>
                            <br>
                            <!-- <div class="g-recaptcha" style="text-align: -webkit-center;" data-sitekey="6Le6CQopAAAAAEtOLHOjrKN5YrBtXRfMVc1vZ_r4"></div> -->
                            <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response" value="">
                            <button type="submit"  class="btn btn-submit-search ">ส่งข้อมูล</button>
                            <br>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col Cropscroll">
                    <div class="listtourid select-display-slide">
                        <li class="active" rel="1">
                            <a href="javascript:void(0)">
                                Google Map </a>
                        </li>
                        <li rel="2">
                            <a href="javascript:void(0)">
                                แผนที่ Next Trip Holiday</a>
                        </li>


                    </div>
                </div>
            </div>
            <div class="row mt-5 mb-5">
                <div class="col">
                    <div class="display-slide" rel="1" style="display:block;">
                        <div class="ggmap">
                            <iframe
                                src="{{$row->google_map}}"
                                width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                    <div class="display-slide" rel="2">
                        <img src="{{asset($row->map)}}" width="100%" style="border:0;">
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include("frontend.layout.inc_footer") 
    
</body>
<script>
       grecaptcha.ready(function() {
          grecaptcha.execute('6LdQYyIqAAAAAB3FGzKTWhkYEHyPkR0oPovosbNs', {action: 'submit'}).then(function(token) {
                document.getElementById('g-recaptcha-response').value = token;
          });
      });
</script>
</html>