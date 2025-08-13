<section id="footer">
    <div class="subscribebg">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 offset-xl-2">
                    <div class="subsrcibeformbg">
                        <div class="row">
                            <div class="col-lg-6 border-end">
                                <div class="titletopic">
                                    <h2>ติดตามเพื่อรับโปรโมชั่น</h2>
                                    {{-- <form method="post" action="{{ url("/subscribe")}}" enctype="multipart/form-data">
                                    @csrf
                                        <div class="input-group  formsubcr mt-3 mb-2">
                                            <span class="input-group-text" id="basic-addon1"><i class="fi fi-rr-envelope"></i></span>
                                            <input type="email" name="email" class="form-control" placeholder="อีเมล์ของคุณ" aria-label="email" aria-describedby="basic-addon1" required>
                                            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">รับโปรโมชั่น</button>
                                        </div>
                                    </form> --}}

                                    <form method="post" action="{{ url('/subscribe') }}" enctype="multipart/form-data" id="subscribeForm">
                                    @csrf
                                        <div class="input-group formsubcr mt-3 mb-2">
                                            <span class="input-group-text" id="basic-addon1"><i class="fi fi-rr-envelope"></i></span>
                                            <input type="email" name="email" id="email" class="form-control" placeholder="อีเมล์ของคุณ" aria-label="email" aria-describedby="basic-addon1" required>
                                            <button class="btn btn-outline-secondary" type="submit" id="button-addon2">รับโปรโมชั่น</button>
                                        </div>
                                        <span id="error-message" style="color: red;"></span>
                                    </form>
                                </div>
                            </div>
                            <?php $contact = \App\Models\Backend\ContactModel::find(1); 
                                  $footer = \App\Models\Backend\FooterModel::find(1);
                            ?>
                            <div class="col-lg-6">
                                <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                                <div class="row">
                                    <div class="col-lg-6 text-center">
                                        <img src="{{asset($contact->qr_code)}}" alt="">
                                    </div>
                                    <div class="col-lg-6">
                                        @php
                                            $lineUrl = "https://line.me/ti/p/".$contact->line_id;
                                        @endphp
                                        <a href="{{url($lineUrl)}}" target="_blank"> <img src="{{asset('frontend/images/line_share.svg')}}" alt=""></a> <br><br>
                                        ติดตามเราผ่านไลน์ <br>
                                        <a href="{{url($lineUrl)}}" target="_blank"><span class="orgtext">{{$contact->line_id}}</span></a> 
                                    </div>
                                </div>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footergroup">
        <div class="container">
            <div class="row mt-5">
                <div class="col">
                    <div class="warning text-center">
                        <h3>ระวัง !! กลุ่มมิจฉาชีพขายทัวร์และบริการอื่นๆ</h3>
                        <h4>โดยแอบอ้างใช้ชื่อบริษัทเน็กซ์ ทริป ฮอลิเดย์ กรุณาชำระค่าบริการผ่านธนาคารชื่อบัญชีบริษัท
                            <a href="{{url('/')}}"><span class="orgtext">"เน็กซ์ ทริป ฮอลิเดย์ จำกัด"</span> </a> เท่านั้น</h4>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="container">
            <div class="row mt-5">
                <div class="col-lg-3">
                    <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                        <div class="titletopic">
                            <h2>เมนูที่เกี่ยวข้อง</h2>
                        </div>
                        <ul class="footerlist">
                            <li><a href="{{url('about')}}">เกี่ยวกับเรา</a></li>
                            <li><a href="{{url('aroundworld/0/0/0')}}">รอบรู้เรื่องเที่ยว</a></li>
                            <li><a href="{{url('clients-company/0')}}">ลูกค้าของเรา</a></li>
                            <li><a href="{{url('news/0/0')}}">ข่าวสารท่องเที่ยว</a></li>
                            <li><a href="{{url('video/0/0')}}">วีดีโอท่องเที่ยว</a></li>
                            <li><a href="{{url('clients-review/0/0')}}">คำรับรองจากลูกค้า</a></li>
                            <li><a href="{{url('faq')}}">คำถามที่พบบ่อย</a></li>
                            <li><a href="{{url('contact')}}">ติดต่อเรา</a></li>
                        </ul>
                        <div class="titletopic mt-3">
                            <h2>นโยบาย เงื่อนไขและข้อตกลง</h2>
                        </div>
                        <ul class="footerlist">
                            <?php $policy = \App\Models\Backend\TermsModel::where('status','on')->orderby('id','asc')->get(); ?>
                            @foreach(@$policy as $po)
                                <li><a href="{{url('policy')}}">{{$po->title}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        เมนูที่เกี่ยวข้อง
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <ul class="footerlist">
                                            <li><a href="{{url('about')}}">เกี่ยวกับเรา</a></li>
                                            <li><a href="{{url('aroundworld/0/0/0')}}">รอบรู้เรื่องเที่ยว</a></li>
                                            <li><a href="{{url('clients-company/0')}}">ลูกค้าของเรา</a></li>
                                            <li><a href="{{url('news/0/0')}}">ข่าวสารจากเน็กซ์ทริปฮอลิเดย์</a></li>
                                            <li><a href="{{url('video/0/0')}}">วีดีโอที่เกี่ยวข้อง</a></li>
                                            <li><a href="{{url('clients-review/0/0')}}">คำรับรองจากลูกค้า</a></li>
                                            <li><a href="{{url('faq')}}">คำถามที่พบบ่อย</a></li>
                                            <li><a href="{{url('contact')}}">ติดต่อเรา</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        นโยบาย เงื่อนไขและข้อตกลง

                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <ul class="footerlist">
                                            @foreach(@$policy as $po)
                                                <li><a href="{{url('policy')}}">{{$po->title}}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php $landmass = \App\Models\Backend\LandmassModel::where('deleted_at',null)->where('status','on')->orderBy('id','asc')->get(); ?>
                <div class="col-lg-6">
                    <div class="row">
                        @foreach($landmass as $l => $land)
                        <?php $country = \App\Models\Backend\CountryModel::where('deleted_at',null)->where('status','on')->where('landmass_id',$land->id)->orderBy('id','asc')->get(); ?>
                        <div class="col-lg-6">
                            <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                                <div class="titletopic">
                                    <h2>{{$land->landmass_name}}</h2>
                                </div>
                                <div class="row">
                                    @foreach($country as $k => $co)
                                        @if($k%2 == 0)
                                        <div class="col-lg-12 col-xl-6">
                                            <ul class="footerlist">
                                                <li><a href="{{url('oversea/'.$co->slug)}}"><img src="{{asset($co->img_icon)}}" class="flagsm" {{-- style="width:27px;height:20px;" --}} alt="">
                                                    ทัวร์{{$co->country_name_th}}</a>
                                                </li>
                                            </ul>
                                        </div>
                                        @else
                                        <div class="col-lg-12 col-xl-6">
                                            <ul class="footerlist ">
                                                <li><a href="{{url('oversea/'.$co->slug)}}"><img src="{{asset($co->img_icon)}}" class="flagsm" {{-- style="width:27px;height:20px;" --}} alt="">
                                                    ทัวร์{{$co->country_name_th}}</a>
                                                </li>
                                            </ul>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="titletopic mt-3 mt-lg-0">
                        <h2>บริษัท เน็กซ์ ทริป ฮอลิเดย์ จำกัด</h2>
                    </div>
                    <div class="contentde">
                        {!! $footer->detail !!}
                    </div>
                    <h4 class="mt-3">{!! $contact->service !!}</h4>
                    <div class="contactbot">
                        @php
                            $lineUrl = "https://line.me/ti/p/".$contact->line_id;
                        @endphp   
                        <li><span><img src="{{asset('frontend/images/phonefooter.svg')}}" alt=""></span> {{$contact->phone_front}}</li>
                        <li><a href="mailto:{{$contact->mail}}"><span><img src="{{asset('frontend/images/mailfooter.svg')}}" alt=""></span>{{$contact->mail}}</a> </li>
                        <li><a href="{{url($lineUrl)}}" target="_blank"><span><img src="{{asset('frontend/images/line.svg')}}" alt=""></span> {{$contact->line_id}}</a> </li>
                    </div>
                    <ul class="socialfooter mt-3">
                        <li><a href="{{$contact->link_fb}}" target="_blank"><img src="{{asset('frontend/images/facebook.svg')}}" alt=""></a></li>
                        <li><a href="{{$contact->link_yt}}" target="_blank"><img src="{{asset('frontend/images/youtube.svg')}}" alt=""></a></li>
                        <li><a href="{{$contact->link_ig}}" target="_blank"><img src="{{asset('frontend/images/instagram.svg')}}" alt=""></a></li>
                        <li><a href="{{$contact->link_tiktok}}" target="_blank"><img src="{{asset('frontend/images/tiktok_ic.svg')}}" alt=""></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="imgfooter mt-5">
            @if($footer->status == 'on')<img src="{{asset($footer->img_footer)}}" class="img-fluid" alt="">@endif
        </div>
    </div>
    <div class="footercopyright">
        Copyright © 2024 Next Trip Holiday, All Rights Reserved
        {{-- Copyright © <script>document.write(new Date().getFullYear())</script> Next Trip Holiday, All Rights Reserved --}}
    </div>
</section>

<div id="myID" class="bottomMenu hide">
    <div class="close"><i class="fi fi-rr-cross"></i></div>
    <div class="seimg">
        <img src="{{asset('frontend/images/customer_sercvice.webp')}}" alt="">
    </div>
    <div class="boxfs">
        วันนี้เปิดบริการ <span class="orgtext">{{$contact->service_time}}</span> <br>
        <h5>เน็กซ์ ทริป ฮอลิเดย์พร้อมให้บริการ</h5>
        <h4>{{$contact->phone_front}}</h4>
        @php
            $lineUrl = "https://line.me/ti/p/".$contact->line_id;
        @endphp
        <a href="{{url($lineUrl)}}" target="_blank" class="lineadd"><img src="{{asset('frontend/images/line_share.svg')}}" alt=""> {{$contact->line_id}}</a>
    </div>
</div>

<script>
    myID = document.getElementById("myID");

    var myScrollFunc = function () {
        var y = window.scrollY;
        if (y >= 300) {
            myID.className = "bottomMenu show"
        } else {
            myID.className = "bottomMenu hide"
        }
    };

    window.addEventListener("scroll", myScrollFunc);

    // Get all elements with class="close"
    var closebtns = document.getElementsByClassName("close");
    var i;

    // Loop through the elements, and hide the parent, when clicked on
    for (i = 0; i < closebtns.length; i++) {
        closebtns[i].addEventListener("click", function () {
            this.parentElement.style.display = 'none';
        });
    }
</script> 
<script>
    // Get the elements with class="column"
    var elements = document.getElementsByClassName("column");

    // Declare a loop variable
    var i;

    $('.table-list').hide();
    // List View
    function listView() {
        $('.table-grid').hide();
        $('.table-list').show();
        $('.list_img.imgactive').show();
        $('.list_img.imgnonactive').hide();
        $('.grid_img.imgactive').hide();
        $('.grid_img.imgnonactive').show();
    }

    // Grid View
    function gridView() {
        $('.table-grid').show();
        $('.table-list').hide();
        $('.grid_img.imgactive').show();
        $('.grid_img.imgnonactive').hide();
        $('.list_img.imgactive').hide();
        $('.list_img.imgnonactive').show();
    }

    /* Optional: Add active class to the current button (highlight it) */
    var container = document.getElementById("btnContainer");
    if(container){
        var btns = container.getElementsByClassName("btn");
        for (var i = 0; i < btns.length; i++) {
            btns[i].addEventListener("click", function () {
                var current = document.getElementsByClassName("active");
                current[0].className = current[0].className.replace(" active", "");
                this.className += " active";
            });
        }
    }
    
</script>

<script>
    var $readMore = "ดูช่วงเวลาเพิ่มเติม ";
    var $readLess = "ย่อข้อความ";
    $(".readMoreBtn").text($readMore);
    $('.readMoreBtn').click(function () {
        var $this = $(this);
        console.log($readMore);
        $this.text($readMore);
        if ($this.data('expanded') == "yes") {
            $this.data('expanded', "no");
            $this.text($readMore);
            $this.parent().find('.readMoreText').animate({
                maxHeight: '120px'
            });
        } else {
            $this.data('expanded', "yes");
            $this.parent().find('.readMoreText').css({
                maxHeight: 'none'
            });
            $this.text($readLess);

        }
    });

    var $readMore2 = "<i class=\"fi fi-rr-angle-small-down\"></i>";
    var $readLess2 = "<i class=\"fi fi-rr-angle-small-up\"></i>";
    $(".readMoreBtn2").html($readMore2);
    $('.readMoreBtn2').click(function () {
        var $this = $(this);
        console.log($readMore2);
        $this.html($readMore2);
        if ($this.data('expanded') == "yes") {
            $this.data('expanded', "no");
            $this.html($readMore2);
            $this.parent().find('.readMoreText2').animate({
                height: '50px'
            });
        } else {
            $this.data('expanded', "yes");
            $this.parent().find('.readMoreText2').css({
                height: 'auto'
            });
            $this.html($readLess2);

        }
    });

    document.getElementById('subscribeForm').addEventListener('submit', function(event) {
        const emailInput = document.getElementById('email');
        const errorMessage = document.getElementById('error-message');
        const emailValue = emailInput.value;

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        const doubleDotRegex = /(\.\.)/;

        if (!emailRegex.test(emailValue)) {
            // errorMessage.textContent = 'Invalid email format.';
            errorMessage.textContent = 'รูปแบบอีเมลไม่ถูกต้อง';
            event.preventDefault();
        } else if (doubleDotRegex.test(emailValue)) {
            // errorMessage.textContent = 'Email should not contain ".."';
            errorMessage.textContent = 'รูปแบบอีเมลไม่ควรมี ".."';
            event.preventDefault();
        } else {
            errorMessage.textContent = '';
        }
    });
</script>
    {{-- ไม่ให้ ctrl+u --}}
    {{-- <script>
                    document.addEventListener('contextmenu', event => event.preventDefault());

    document.onkeypress = function (event) {
        event = (event || window.event);
        if (event.keyCode == 123) {
            return false;
        }
    }

    document.onmousedown = function (event) {
        event = (event || window.event);
        if (event.keyCode == 123) {
            return false;
        }
    }
    document.onkeydown = function (event) {
        event = (event || window.event);
        if (event.keyCode == 123) {
            return false;
        }
    }

    jQuery(document).ready(function($){
        $(document).keydown(function(event) {
            var pressedKey = String.fromCharCode(event.keyCode).toLowerCase();

            if (event.ctrlKey && (pressedKey == "s" || pressedKey == "c" || pressedKey == "u")) {
                //alert('Sorry, This Functionality Has Been Disabled!');
                //disable key press porcessing
                return false;
            }
        });
    });
    </script> --}}