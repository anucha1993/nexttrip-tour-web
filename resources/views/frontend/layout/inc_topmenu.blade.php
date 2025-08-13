<?php $landmass = \App\Models\Backend\LandmassModel::where('deleted_at',null)->orderBy('id','asc')->get(); 
    $contact = \App\Models\Backend\ContactModel::find(1); 
    $footer = \App\Models\Backend\FooterModel::find(1);
?>
<section id="menuontop">
    <div class="wrap_menu">
        <div class="d-none d-sm-none d-md-none d-xl-block d-lg-block">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 text-center pe-0">
                        <a href="{{url('/')}}" class="mainlogo">
                            <img src="{{asset('frontend/images/logo.svg')}}" alt="" class="img-fluid">
                        </a>
                    </div>
                    <div class="col-lg-10 text-end">
                        <div class="topcontact">
                            <li class="splitontr">
                                <div class="helpcallmenu">
                                    <span>ศูนย์บริการช่วยเหลือ</span> <br>
                                    <div class="text"><b> <i class="fi fi-rr-phone-call"></i><a> {{$contact->phone_front}}</a></b> </div>
                                    <span class="hotline">Hotline : {{$contact->hotline}}</span>
                                    <span class="opentimes">เปิดให้บริการ {{$contact->time}}</span>
                                </div>
                            </li>
                            <li class="splitonmid">
                                <div class="helpcallmenu">
                                    <div class="iconlineleft"><img src="{{asset('frontend/images/line_share.svg')}}" alt=""></div>
                                    <div class="contenter">
                                        <span> เราพร้อมช่วยคุณ </span> <br>
                                        @php
                                            $lineUrl = "https://line.me/ti/p/".$contact->line_id;
                                        @endphp
                                        <div class="text"> <a href="{{url($lineUrl)}}" target="_blank"><b>{{$contact->line_id}}</b></a> </div>
                                    </div>

                                </div>
                            </li>
                            <li class="splitonlast">
                                <div class="socialtop">
                                    <span> ติดตามเราที่ช่องทาง </span>
                                    <ul>
                                        <li><a href="{{$contact->link_fb}}"><img src="{{asset('frontend/images/facebook.svg')}}" alt=""></a></li>
                                        <li><a href="{{$contact->link_yt}}"><img src="{{asset('frontend/images/youtube.svg')}}" alt=""></a></li>
                                        <li><a href="{{$contact->link_ig}}"><img src="{{asset('frontend/images/instagram.svg')}}" alt=""></a></li>
                                        <li><a href="{{$contact->link_tiktok}}"><img src="{{asset('frontend/images/tiktok_ic.svg')}}" alt=""></a></li>
                                    </ul>
                                </div>
                            </li>
                        </div>
                    </div>
                </div>
            </div>
            <div class="borderontop">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9">
                            <div id="nav">
                                <div class="mainmenu">
                                    <ul>
                                        <li class="homeicon"><a href="{{url('/')}}"><i class="bi bi-house-door-fill"></i></a></li>
                                        <li data-page="oversea"><a href="javascript:void(0);"> ทัวร์ต่างประเทศ </a>
                                            <div class="dropdown-container">
                                                <ul class="submenudrop">
                                                    <div class="row">
                                                        @foreach($landmass as $land)
                                                        <?php $country = \App\Models\Backend\CountryModel::where(['landmass_id' => $land->id,'status' => 'on','deleted_at' => null])->orderBy('id','asc')->get(); ?>
                                                        <div class="col-lg-4 border-end">
                                                            <h4>{{@$land->landmass_name}}</h4>
                                                            @foreach($country as $co)
                                                                <li><a href="{{url('oversea/'.$co->slug)}}"><img src="{{asset($co->img_icon)}}" style="width:27px;height:20px;" alt=""> ทัวร์{{$co->country_name_th}}</a></li>
                                                            @endforeach
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </ul>
                                            </div>
                                        </li>
                                        <li data-page="inthai"><a href="javascript:void(0);"> ทัวร์ในประเทศ </a>
                                            <div class="dropdown-container">
                                                <ul class="submenudrop_thai">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <?php 
                                                                // $province = \App\Models\Backend\ProvinceModel::join('tb_tour', 'tb_province.id', '=', 'tb_tour.province_id')
                                                                // ->select('tb_province.id as pro_id','tb_province.name_th')
                                                                // ->whereNull('tb_province.deleted_at')->orderBy('tb_province.id','asc')->get();
                                                                $province = \App\Models\Backend\ProvinceModel::where(['status'=>'on','deleted_at'=>null])->orderby('id','asc')->get();
                                                            ?>
                                                            @foreach(@$province as $pro)
                                                                <li>
                                                                    <a href="{{url('inthai/'.$pro->slug)}}"> ทัวร์{{$pro->name_th}}</a>
                                                                </li>
                                                            @endforeach
                                                        </div>

                                                    </div>
                                                </ul>
                                            </div>
                                        </li>
                                        <li data-page="promotion"><a href="{{url('promotiontour/0/0')}}">ทัวร์โปรโมชั่น</a></li>
                                        <li data-page="weekend"><a href="{{url('weekend')}}"> ทัวร์ตามเทศกาล </a>
                                            <div class="dropdown-container">
                                                <ul class="submenudrop_weekend">
                                                    <div class="row">
                                                        <div class="col">
                                                            <h4>ทัวร์ตามเทศกาล</h4>
                                                            <?php $calendar = \App\Models\Backend\CalendarModel::where('start_date','>=',date('Y-m-d'))->where(['status'=>'on','deleted_at'=>null])->orderBy('start_date','asc')->get(); ?>
                                                            @foreach($calendar as $ca)
                                                                <li><a href="{{url('weekend-landing/'.$ca->id)}}">ทัวร์{{$ca->holiday}}</a></li>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </ul>
                                            </div>
                                        </li>
                                        <?php   $row = \App\Models\Backend\PackageModel::where('status','on')->get();
                                            $arr  = array();
                                            foreach($row as $r){
                                                $arr = array_merge($arr,json_decode($r->country_id,true));
                                            }
                                            $arr = array_unique($arr);
                                            $count = \App\Models\Backend\CountryModel::whereIn('id',$arr)->where('deleted_at',null)->where('status','on')->get();
                                        ?>
                                        <li data-page="package"><a href="{{url('package/0')}}">แพ็คเกจทัวร์</a>
                                            <div class="dropdown-container">
                                                <ul class="submenudrop">
                                                    <h4>เที่ยวด้วยตัวเอง</h4>
                                                    @foreach ($count as $co)
                                                        <li><a href="{{url('package/'.$co->id)}}">แพ็คเกจ{{$co->country_name_th}}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </li>
                                        <li data-page="organize"><a href="{{url('organizetour')}}">รับจัดกรุ๊ปทัวร์</a></li>
                                        <li data-page="around"><a href="{{url('aroundworld/0/0/0')}}">รอบรู้เรื่องเที่ยว</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        @php
                            $check_auth = App\Models\Backend\MemberModel::find(Auth::guard('Member')->id());
                        @endphp
                        <div class="col-lg-3 text-end">
                            <div class="abstopanc">
                                <li class="act-mem">
                                    <a @if($check_auth) href="{{url('/member-booking')}}" @else href="javascript:;" @endif data-width="548" data-height="765" @if(!$check_auth) data-fancybox
                                        data-src="#login" @endif><i class="fi fi-rr-user"></i> <span class="textacct">@if($check_auth) {{$check_auth->name}} @else เข้าสู่ระบบ/สมัครสมาชิก @endif</span></a>
                                </li>
                                <li class="searchtopbars"><a href="#" data-bs-toggle="offcanvas"
                                        data-bs-target="#searchcanvas" aria-controls="searchcanvas"><i
                                            class="fi fi-rr-search"></i></a>

                                </li>
                                <li><a href="{{url('wishlist/0')}}"><i class="bi bi-heart-fill"></i></a> <span
                                        class="numberwishls" id="numberwishls"></span>
                                </li>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
            <div class="container-fluid menuonmb">
                <div class="row">
                    <div class="col-3 topmbact">
                        <ul>
                            <li class="menumb"> <a  data-bs-toggle="offcanvas" href="#menuonmb" role="button"
                                    aria-controls="offcanvasExample">
                                    <img src="{{asset('frontend/images/navmb.svg')}}" alt="">
                                </a></li>

                        </ul>
                        <div class="offcanvas offcanvas-start" tabindex="-1" id="menuonmb"
                            aria-labelledby="offcanvasExampleLabel">
                            <div class="offcanvas-header">
                                <h5 class="offcanvas-title" id="offcanvasExampleLabel">
                                    <img src="{{asset('frontend/images/logo.svg')}}" alt="">
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                    aria-label="Close" id="close-mb"></button>
                            </div>
                            <div class="offcanvas-body">

                                <li><a href="{{url('/')}}"><span class="iccss"><i class="bi bi-house-door-fill"></i></span> หน้าหลัก</a></li>
                                <div class="accordion" id="accordionExample2">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button  collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseFive"
                                                aria-expanded="false" aria-controls="collapseFive">
                                            <div class="iccss"><i class="fi fi-rr-plane"></i></div>   ทัวร์ต่างประเทศ

                                            </button>
                                        </h2>
                                        <div id="collapseFive" class="accordion-collapse collapse"
                                            data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <ul class="listmenuOnmb">
                                                    @foreach($landmass as $land)
                                                    <?php $country_mb = \App\Models\Backend\CountryModel::where(['landmass_id' => $land->id,'status' => 'on','deleted_at' => null])->orderBy('id','asc')->get(); ?>
                                                    <h6>{{@$land->landmass_name}}</h6>
                                                        @foreach($country_mb as $co)
                                                            <li><a href="{{url('oversea/'.$co->slug)}}"><img src="{{asset($co->img_icon)}}"alt="">ทัวร์{{$co->country_name_th}}</a></li>
                                                        @endforeach
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button  collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                aria-expanded="false" aria-controls="collapseTwo">
                                                <div class="iccss"><i class="fi fi-rr-suitcase-alt"></i></div> ทัวร์ในประเทศ
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse"
                                            data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <ul class="listmenuOnmb">
                                                    <?php 
                                                        $province_mb = \App\Models\Backend\ProvinceModel::where(['status'=>'on','deleted_at'=>null])->orderby('id','asc')->get();
                                                    ?>
                                                    @foreach(@$province_mb as $pro)
                                                        <li>
                                                            <a href="{{url('inthai/'.$pro->slug)}}"> ทัวร์{{$pro->name_th}}</a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <li><a href="{{url('promotiontour/0/0')}}"><span class="iccss"><i class="bi bi-fire"></i></span>ทัวร์โปรโมชั่น</a></li>
                                <div class="accordion" id="accordionExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseThree" aria-expanded="true"
                                                aria-controls="collapseThree">
                                                <div class="iccss"><i class="fi fi-rr-party-horn"></i></div>     ทัวร์ตามเทศกาล
                                            </button>
                                        </h2>
                                        <div id="collapseThree" class="accordion-collapse collapse"
                                            data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <ul class="listmenuOnmb">
                                                    <?php $calendar_mb = \App\Models\Backend\CalendarModel::where('start_date','>=',date('Y-m-d'))->where(['status'=>'on','deleted_at'=>null])->orderBy('start_date','asc')->get(); ?>
                                                    @foreach($calendar_mb as $ca)
                                                        <li><a href="{{url('weekend-landing/'.$ca->id)}}">ทัวร์{{$ca->holiday}}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <?php   
                                        $row_mb = \App\Models\Backend\PackageModel::where('status','on')->get();
                                        $arr_mb  = array();
                                        foreach($row_mb as $r){
                                            $arr_mb = array_merge($arr_mb,json_decode($r->country_id,true));
                                        }
                                        $arr_mb = array_unique($arr_mb);
                                        $count_mb = \App\Models\Backend\CountryModel::whereIn('id',$arr_mb)->where('deleted_at',null)->where('status','on')->get();
                                    ?>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                                aria-expanded="false" aria-controls="collapseFour">
                                                <div class="iccss"><i class="fi fi-rr-layers"></i></div> แพ็คเกจทัวร์

                                            </button>
                                        </h2>
                                        <div id="collapseFour" class="accordion-collapse collapse"
                                            data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <ul class="listmenuOnmb">
                                                    @foreach ($count_mb as $co)
                                                        <li><a href="{{url('package/'.$co->id)}}">แพ็คเกจ{{$co->country_name_th}}</a></li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <li><a href="{{url('organizetour')}}"><span class="iccss"><i class="fi fi-rr-users-alt"></i></span> รับจัดกรุ๊ปทัวร์</a></li>
                                <li><a href="{{url('aroundworld/0/0/0')}}"><span class="iccss"><i class="bi bi-newspaper"></i></span> รอบรู้เรื่องเที่ยว</a></li>
                                <li><a @if($check_auth) href="{{url('/member-booking')}}" @else href="javascript:;" @endif class="accordion-button" data-width="548" data-height="765" @if(!$check_auth)  data-fancybox data-src="#login" @endif><span class="iccss"><i class="fi fi-rr-circle-user"></i></span> 
                                    @if($check_auth) {{$check_auth->name}} @else เข้าสู่ระบบ/สมัครสมาชิก @endif
                                </a></li>
                                <div class="contactanc mt-2">
                                <i class="fi fi-rr-phone-call"></i> ศูนย์บริการช่วยเหลือลูกค้า <br>
                                    <b class="orgtext"> {{$contact->phone_front}} </b> <br> เปิดให้บริการ {{$contact->time}} 
                                    <br>
                                    <a href="{{$lineUrl}}" class="lineonmbf"><img src="{{asset('frontend/images/line_add.svg')}}" alt=""> {{$contact->line_id}} </a>
                                </div>
                                

                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mainlogo">
                            <a href="{{url('/')}}">
                                <img src="{{asset('frontend/images/logo.svg')}}" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-3 text-end g-0">
                        <div class="abstopanc">
                            <li><a href="{{url('wishlist/0')}}"><i class="bi bi-heart-fill"></i></a> <span
                                    class="numberwishls" id="numberwishlsM"></span>
                            </li>
                            <li class="searchtopbars"><a href="#" data-bs-toggle="offcanvas"
                                    data-bs-target="#searchcanvas" aria-controls="searchcanvas"><i
                                        class="fi fi-rr-search"></i></a>

                            </li>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
<div class="offcanvas offcanvas-top" tabindex="-1" id="searchcanvas" aria-labelledby="searchcanvasLabel">
    <div class="offcanvas-header">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="titletopic">
            <h2>ไปเที่ยวที่ไหนดี?</h2>
        </div>
        <form action="{{url('search-tour')}}" method="POST" enctype="multipart/form-data"  id="searchForm">
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <div class="input-group formcountry mb-3">
                        <span class="input-group-text" id="basic-addon1"><i class="fi fi-rr-search"></i></span>
                        <input type="text" class="form-control" placeholder="ประเทศ, เมือง, สถานที่ท่องเที่ยว"
                        aria-label="country" aria-describedby="basic-addon1" name="search_data" id="search_data1" onkeyup="SearchData1()" >
                        {{-- <input type="text" class="form-control" placeholder="ประเทศ, เมือง, สถานที่ท่องเที่ยว"
                            aria-label="country" aria-describedby="basic-addon1"> --}}
                    </div>
                    <div id="livesearch1" class="searchexpbox" style="background-color: white;"></div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        <div class="col-12 col-lg-8">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1"><i class="bi bi-calendar"></i></span>
                                <input type="text" class="form-control" name="daterange_top"  id="hide_date_select_top" value="{{date('m/d/Y')}} - {{date('m/d/Y',strtotime('+1 day'))}}" />
                                <input type="hidden" name="start_date" id="start_date_top" {{-- value="{{date('Y-m-d')}}" --}} />
                                <input type="hidden" name="end_date" id="end_date_top" {{-- value="{{date('Y-m-d',strtotime('+1 day'))}}" --}} />
                                <div class="form-control"  style="height:52px;" id="show_date_calen_top" onclick="show_datepicker_top()" ></div>
                                <div class="form-control" style="height:52px;" id="show_end_calen_top" onclick="show_datepicker_top()" ></div>
                            </div>
                            {{-- <input class="form-control" type="date" name="start_date" /> --}}
                        </div>
                         {{-- <div class="col-6 col-lg-2">
                            <input class="form-control" type="date" name="end_date" />
                        </div>  --}}
                        <div class="col-12 col-lg-4 mt-3 mt-lg-0">
                            <select class="form-control"  aria-label="ช่วงราคา" name="price">
                                <option value="">ช่วงราคา</option>
                                <option value="1">ต่ำกว่า 10,000</option>
                                <option value="2">10,001-20,000</option>
                                <option value="3">20,001-30,000</option>
                                <option value="4">30,001-50,000</option>
                                <option value="5">50,001-80,000</option>
                                <option value="6">80,001 ขึ้นไป</option>
                            </select>
                        </div>
                     
                </div>
            </div>
                {{-- <div class="col-lg-8">
                    <div class="row">
                        <div class="col-6 col-lg-2">
                            <input class="form-control" type="date" name="start_date" />
                        </div>
                        <div class="col-6 col-lg-2">
                            <input class="form-control" type="date" name="end_date" />
                        </div>
                        <div class="col-6 col-lg-4">
                            <select class="form-control"  aria-label="ช่วงราคา" name="price">
                                <option value="">ช่วงราคา</option>
                                <option value="1">ต่ำกว่า 10,000</option>
                                <option value="2">10,001-20,000</option>
                                <option value="3">20,001-30,000</option>
                                <option value="4">30,001-50,000</option>
                                <option value="5">50,001-80,000</option>
                                <option value="6">80,001 ขึ้นไป</option>
                            </select>
                        </div>
                        <div class="col-6 col-lg-4">
                            <button type="submit" class="btn btn-submit ">ค้นหาทัวร์</button>
                        </div>
                    </div>
                </div> --}}
                <div class="row">
                <div class="col-lg-12 mt-3 mt-lg-0">
                            <button type="submit" class="btn btn-submit " name="code_tour">ค้นหาทัวร์</button>
                        </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div style="display: none;" id="login">
    <div class="accountlist select-display-slide">
        <li class="active" rel="1">
            <a href="javascript:void(0)">
                สมัครสมาชิก
            </a>
        </li>
        <li rel="2">
            <a href="javascript:void(0)">
                เข้าสู่ระบบ  
            </a>
        </li>
    </div>
    <div class="display-slide" rel="1" style="display:block;">
            <div class="contactform">
                
                    <h3>สมัครสมาชิก</h3>
                    <label>ชื่อ</label>
                    <input type="text" name="name_top" id="name_top" class="form-control" placholder="กรอกชื่อ">
                    <label>นามสกุล</label>
                    <input type="text" name="surname_top" id="surname_top" class="form-control" placholder="กรอกนามสกุล">
                    <label>อีเมล</label>
                    <span class="text-danger" id="check_email"></span>
                    <input type="email" name="email_top"  id="email_top" class="form-control" placholder="อีเมล" required>
                    <label>เบอร์โทรศัพท์</label>
                    <span class="text-danger" id="check_phone"></span>
                    <input type="text" name="phone_top"  id="phone_top" class="form-control" placholder="เบอร์โทรศัพท์" required>
                    <label>รหัสผ่าน</label>
                    <span class="text-danger" id="check_pass"></span>
                    <input type="password" name="password_top" id="password_top" class="form-control" placholder="รหัสผ่าน" required>
                    <label>ยืนยันรหัสผ่าน</label>
                    <span class="text-danger" id="check_confirm"></span>
                    <input type="password" name="confirm_password" id="confirm_password_top" class="form-control" placholder="รหัสผ่าน" required>
                    <label class="check-container"> ฉันยอมรับ <a href="{{url('policy')}}">นโยบายความเป็นส่วนตัว</a> <span class="text-danger" id="check_accept"></span>
                                    <input type="checkbox" id="accept" required>
                                    <span class="checkmark"></span>
                                
                                </label>
                    <center class="mt-3"> 
                        {{-- <button type="submit" class="btn btnfilter">ลงทะเบียน</button> --}}
                        <a href="javascript:void(0);" onclick="check_password();" class="btn btnfilter">ลงทะเบียน</a>
                    </center>
                {{-- </form> --}}
                
            </div>
        
    </div>
    <div class="display-slide" rel="2">
    <form action="/login" method="POST">
        @csrf
        <div class="contactform">
                <h3>เข้าสู่ระบบ</h3>
                <label>อีเมล</label>
                <input type="email" name="email" class="form-control" placholder="อีเมล">
                <label>รหัสผ่าน</label>
                <input type="password" name="password" class="form-control" placholder="รหัสผ่าน">
                <div class="row mt-3 mb-5">
                    
                    <div class="col text-end">
                        <a href="javascript:;" data-width="548" data-height="765" data-fancybox data-src="#forgetpass"
                            class="forgetpass">ลืมรหัสผ่าน?</a>
                    </div>
                </div>
            
                <center class="mt-3"> <button type="submit" class="btn btnfilter">เข้าสู่ระบบ</button>
                </center>
                <span class="orlog mb-2">หรือเข้าสู่ระบบด้วย</span>
                    <div class="sociallogin text-center">
                        <ul>
                        {{-- <li class="searchtopbars"><a href="{{ url('auth/facebook') }}"><img src="{{asset('frontend/images/facebook.svg')}}" alt=""></a></li>
                        <li class="searchtopbars" onclick="LoginLine()" >Line</li> --}}
                        <li><a href="{{ url('auth/facebook') }}" ><img src="{{asset('frontend/Facebook.svg')}}" alt=""></a></li>
                        <li><a href="{{ url('/google') }}" ><img src="{{asset('frontend/gglogin.svg')}}" alt="" {{-- onclick="sociallogin()" --}} ></a></li>
                        <li><a href="javascript:void(0);"  onclick="LoginLine()"><img src="{{asset('frontend/linelogin.svg')}}" alt=""></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </form>
</div>


<div style="display: none;" id="forgetpass">
<div class="contactform">
        <h3>ลืมรหัสผ่าน</h3>
        <label>อีเมล</label>
        <form action="{{url('/forgot-password')}}" method="POST">
            @csrf
            <input type="email" name="reset_email" class="form-control" placholder="อีเมล">
            <center class="mt-5 mb-3">  <button type="submit" class="btn btnfilter">รีเซ็ตรหัสผ่านใหม่</button>
            </center>
        </form>
        
       
    </div>
</div>
@php
        $data_country = App\Models\Backend\CountryModel::where(['status'=>'on','deleted_at'=>null])->whereNotNull('country_name_th')->get();
        $data_city = App\Models\Backend\CityModel::where(['status'=>'on','deleted_at'=>null])->whereNotNull('city_name_th')->get();
        $data_province = App\Models\Backend\ProvinceModel::where(['status'=>'on','deleted_at'=>null])->whereNotNull('name_th')->get();
        $data_amupur= App\Models\Backend\AmupurModel::where(['status'=>'on','deleted_at'=>null])->whereNotNull('name_th')->get();
        $country_famus = App\Models\Backend\CountryModel::where('count_search','!=',0)->orderBy('count_search','desc')->limit(3)->get();
        $keyword_famus = App\Models\Backend\KeywordSearchModel::orderBy('count_search','desc')->limit(10)->get();
@endphp
<?php 
        echo '<script>';
        echo 'var country = '. json_encode($data_country) .';';
        echo 'var city = '. json_encode($data_city) .';';
        echo 'var country_famus = '. json_encode($country_famus) .';';
        echo 'var keyword_famus = '. json_encode($keyword_famus) .';';
        echo 'var province = '. json_encode($data_province) .';';
        echo 'var amupur = '. json_encode($data_amupur) .';';
        echo '</script>';
?>
 @include("frontend.layout.search-data")
<script src="https://static.line-scdn.net/liff/edge/versions/2.3.0/sdk.js"></script>
<script>       
        function LoginLine(){
            var profile = null;
            liff.init({ liffId: '2003705473-mOBqvyPY' },async () => {
                // liff.logout();
                if(!liff.isLoggedIn()){
                    console.log('1')
                    await liff.login();
                }else{
                    profile = await liff.getProfile();
                    console.log(profile);
                    $.ajax({
                        type: 'POST',
                        url: '{{url("/line-login")}}',
                        data: {
                            _token: '{{csrf_token()}}',
                            profile:profile,
                        },
                        success: function (data) {
                            console.log(data)
                                if(data){
                                    window.location.replace('/member-booking');
                                }else{
                                    liff.login();
                                }
                        },
                    });
                }   
            });
        }
    async function check_password() {
        var password_top = $('#password_top').val();
        var accept = $('#accept').prop('checked');
        var confirm_password_top = $('#confirm_password_top').val();
        var email = $('#email_top').val();
        var check_mail = /^([0-9a-zA-Z]([-_\\.]*[0-9a-zA-Z]+)*)@([0-9a-zA-Z]([-_\\.]*[0-9a-zA-Z]+)*)[\\.]([a-zA-Z]{2,9})$/;
        var phone = $('#phone_top').val();
        if(password_top == ''){
            document.getElementById('check_pass').innerHTML = 'กรุณากรอกรหัสผ่าน';
            return false;
        }
        if(password_top != confirm_password_top) {
            document.getElementById('check_confirm').innerHTML = 'กรุณากรอกรหัสผ่านให้เหมือนกัน';
            return false;
        }
        if (!check_mail.test(email)) {
            document.getElementById('check_email').innerHTML = 'กรุณากรอกอีเมลให้ถูกต้อง';
            return false
        }
        if(phone.length != 10 || !Number(phone) || phone.charAt(0) != '0'){
            document.getElementById('check_phone').innerHTML = 'กรุณากรอกเบอร์โทรให้ถูกต้อง';
            return false
        }
        if(!accept){
            document.getElementById('check_accept').innerHTML = ' (กรุณากดยอมรับนโยบาย) ';
            return false;
            
        }
        if(accept && check_mail.test(email) && password_top == confirm_password_top && password_top != '' && phone.length == 10 && Number(phone) > 1 && phone.charAt(0) == '0'){
            document.getElementById('check_pass').innerHTML = '';
            document.getElementById('check_email').innerHTML = '';
            document.getElementById('check_accept').innerHTML = '';
            document.getElementById('check_phone').innerHTML = '';
            document.getElementById('check_confirm').innerHTML = '';
            let payload = {
               name:document.getElementById('name_top').value,
               surname : document.getElementById('surname_top').value,
               email:document.getElementById('email_top').value,
               phone:document.getElementById('phone_top').value,
               password:document.getElementById('password_top').value,
               _token: '{{csrf_token()}}',
           }
           $.ajax({
              type: 'POST',
               url: '{{url("/register")}}',
               data: payload,
               success: function (data) {
                    if(data){
                        $.fancybox.close();
                        document.getElementById('close-mb').click();
                        Swal.fire({
                                icon: "success",
                                title: "สมัครสมาชิกสำเร็จ กรุณาล็อคอินเพื่อเข้าสู่ระบบ",
                                showConfirmButton: false,
                                timer: 3000,
                        });
                        document.getElementById('name_top').value = '';
                        document.getElementById('surname_top').value = '';
                        document.getElementById('email_top').value = '';
                        document.getElementById('phone_top').value = '';
                        document.getElementById('password_top').value = '';
                        document.getElementById('confirm_password_top').value = '';
                        document.getElementById('accept').checked = false;
                    }else{
                        $.fancybox.close();
                        document.getElementById('close-mb').click();
                        Swal.fire({
                                icon: "error",
                                title: "มีอีเมลนี้ในระบบแล้วกรุณากรอกอีเมลใหม่",
                                showConfirmButton: false,
                                timer: 3500,
                        }); 
                        // document.getElementById('name_top').value = '';
                        // document.getElementById('surname_top').value = '';
                        // document.getElementById('email_top').value = '';
                        // document.getElementById('phone_top').value = '';
                        // document.getElementById('password_top').value = '';
                        // document.getElementById('confirm_password_top').value = '';
                        // document.getElementById('accept').checked = false;
                    }
               },
           });
           
        }
    }
    // async function sociallogin(){
    //     await $.fancybox.close();
    //     await document.getElementById('close-mb').click();
    //     Swal.fire({
    //             icon: "success",
    //             title: "ลงทะเบียนสำเร็จ",
    //             showConfirmButton: false,
    //             timer: 3000,
    //     });
    // }
</script>
<script>
    var day_top = ['วันอาทิตย์','วันจันทร์','วันอังคาร','วันพุธ','วันพฤหัสบดี','วันศุกร์','วันเสาร์'];
    var month_top = ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
    var check_after_top = new Date();
    var check_befor_top = new Date(check_after_top.valueOf()+86400000);
    var strat_show_top = check_after_top.getDate()+'  '+month_top[check_after_top.getMonth()]+'  '+(check_after_top.getFullYear()*1+543);
    var start_day_show_top = day_top[check_after_top.getDay()];
    var end_show_top = check_befor_top.getDate()+'  '+month_top[check_befor_top.getMonth()]+'  '+(check_befor_top.getFullYear()*1+543);
    var end_day_show_top = day_top[check_befor_top.getDay()];
    var text_s_show_top = '';
        text_s_show_top += "<span style='color:gray'>"+strat_show_top+"</span><br>";
        text_s_show_top += "<span style='font-size:0.7rem;padding:3px 2px;display:block;color:gray;'>"+start_day_show_top+"</span>";
    var text_e_show_top = '';
        text_e_show_top += "<span style='color:gray'>"+end_show_top+"</span><br>";
        text_e_show_top += "<span style='font-size:0.7rem;padding:3px 2px;display:block;color:gray;'>"+end_day_show_top+"</span>";

    document.getElementById('show_date_calen_top').innerHTML = text_s_show_top;
    document.getElementById('show_end_calen_top').innerHTML = text_e_show_top;
    $('#hide_date_select_top').hide();

    $(function() {
        $('input[name="daterange_top"]').daterangepicker({
            opens: 'left',
            minDate: "{{date('m/d/Y')}}"
        }, function(start, end, label) {
            document.getElementById('start_date_top').value = start.format('YYYY-MM-DD');
            document.getElementById('end_date_top').value = end.format('YYYY-MM-DD');
            let y = new Date(start);
            let x = new Date(end);
            let s_show = y.getDate()+'  '+month_top[y.getMonth()]+'  '+(y.getFullYear()*1+543);
            let e_show = x.getDate()+'  '+month_top[x.getMonth()]+'  '+(x.getFullYear()*1+543);
            let s_day = day_top[y.getDay()];
            let e_day = day_top[x.getDay()];
            // document.getElementById('show_date_select').value = test;
            var text_start = '';
                text_start += s_show+"<br>";
                text_start += "<span style='font-size:0.8rem;padding:3px 2px;display:block;'>"+s_day+"</span>";
            var text_end = '';
                text_end += e_show+"<br>";
                text_end += "<span style='font-size:0.8rem;padding:3px 2px;display:block;'>"+e_day+"</span>";

            document.getElementById('show_date_calen_top').innerHTML = text_start;
            document.getElementById('show_end_calen_top').innerHTML = text_end;

            $('#show_date_calen_top').show();
            $('#show_end_calen_top').show();
            $('#hide_date_select_top').hide();
        });
        $('input[name="daterange_top"]').on('cancel.daterangepicker', function(ev, picker) {
            document.getElementById('start_date_top').value = null;
            document.getElementById('end_date_top').value = null;

            let y = new Date("{{date('m/d/Y')}}");
            let x = new Date("{{date('m/d/Y',strtotime('+1 day'))}}");
            let s_show = y.getDate()+'  '+month_top[y.getMonth()]+'  '+(y.getFullYear()*1+543);
            let e_show = x.getDate()+'  '+month_top[x.getMonth()]+'  '+(x.getFullYear()*1+543);
            let s_day = day_top[y.getDay()];
            let e_day = day_top[x.getDay()];
            
            var text_start1 = '';
                text_start1 += "<span style='color:gray'>"+s_show+"<span><br>";
                text_start1 += "<span style='font-size:0.7rem;padding:3px 2px;display:block;color:gray;'>"+s_day+"</span>";
            var text_end2 = '';
                text_end2 += "<span style='color:gray'>"+e_show+"</span><br>";
                text_end2 += "<span style='font-size:0.7rem;padding:3px 2px;display:block;color:gray;'>"+e_day+"</span>";
            document.getElementById('show_date_calen_top').innerHTML = text_start1;
            document.getElementById('show_end_calen_top').innerHTML = text_end2;

            $('#show_date_calen_top').show();
            $('#show_end_calen_top').show();
            $('#hide_date_select_top').hide();
            
        });
        $('input[name="daterange_top"]').on('hide.daterangepicker', function(ev, picker) {
            $('#show_date_calen_top').show();
            $('#show_end_calen_top').show();
            $('#hide_date_select_top').hide();
        });
    });
    function show_datepicker_top() {
        $('#show_date_calen_top').hide();
        $('#show_end_calen_top').hide();
        $('#hide_date_select_top').show();
        document.getElementById("hide_date_select_top").click();
    }
    
</script>
<script>
    $(function () {
        var getPage = '<?php echo(@$pageName); ?>';
        $(".mainmenu li").each(function () {
            var getMenu = $(this).attr("data-page");
            if (getPage == getMenu) {
                $(this).addClass('active');
            }
        });
    });
</script>
<script>
    $(window).scroll(function () {
        if ($(this).scrollTop() > 25) {
            $('.wrap_menu').addClass("sticky");
        } else {
            $('.wrap_menu').removeClass("sticky");
        }
    });

    $(document).ready(function () {
        var mmH = $('.wrap_menu').outerHeight(true);
        $('.wrapperPages').eq(0).css('padding-top', mmH);

        const likedTours = JSON.parse(localStorage.getItem('likedTours')) || [];
        const likedCountElement = document.getElementById('numberwishls');
        const likedCountElementM = document.getElementById('numberwishlsM');

        // แสดงจำนวนที่ถูกใจใน header
        likedCountElement.textContent = `${likedTours.length}`;
        likedCountElementM.textContent = `${likedTours.length}`;

    });
</script>
<script>
    var menu_width;

    jQuery(document).ready(
        function () {

            initMenu();

        });

    function initMenu() {
        menu_width = $("#menu .menu").width();

        $(".menu-back").click(function () {

            var _pos = $(".menu-slider").position().left + menu_width;
            var _obj = $(this).closest(".submenu");

            $(".menu-slider").stop().animate({
                left: _pos
            }, 300, function () {
                _obj.hide();
            });

            return false;
        });

        $(".menu-anchor").click(function () {
            var _d = $(this).data('menu');
            $(".submenu").each(function () {

                var _d_check = $(this).data('menu');

                if (_d_check == _d) {
                    $(this).show();
                    var _pos = $(".menu-slider").position().left - menu_width;

                    $(".menu-slider").stop(true, true).animate({
                        left: _pos
                    }, 300);
                    return false;
                }
            });

            return false;
        });

    }
</script>