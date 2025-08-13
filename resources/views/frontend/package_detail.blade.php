<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    @include("frontend.layout.inc_header")
	<title>แพคเกจทัวร์ ,เที่ยวด้วยตนเอง</title>
</head>
<style>
    @media (max-width: 991px) {
        .contentde img {
            max-width: 100%;
            height: auto; 
        }
    }

</style>
<body>
    @include("frontend.layout.inc_topmenu")
    <section id="packagepage" class="wrapperPages">
        <div class="socialshare">
            <span>แชร์</span>
            <ul>
                @php
                                        $urlSharer = url("package-detail/".$id);
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
        <div class="container">
            <div class="row mt-5">
                <div class="col">
                    <div class="pageontop_sl">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">หน้าหลัก </a></li>
                                <li class="breadcrumb-item"><a href="{{url('package/0')}}">แพ็คเกจ </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">{{$row->package}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-lg-9">
                    <div class="bigpic">
                        <img src="{{asset($row->img)}}" class="img-fluid" alt="">
                    </div>
                    <div class="titletopic mt-3">
                        <h1>{{$row->package}}</h1>
                    </div>
                
                    <div class="contentde mt-3 mb-3">
                        {!! $row->detail !!}
                    </div>
                
                <div class="row mt-5 mb-4">
                    <div class="col-lg-4">
                        <div class="titletopic">
                            <h2>รวมในแพ็คเกจ</h2>
                        </div>
                        <div class="contentde">
                            {!! $row->include !!}
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="titletopic">
                            <h2>ไม่รวมในแพ็คเกจ</h2>
                        </div>
                        <div class="contentde">
                            {!! $row->not_include !!}
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="titletopic">
                            <h2>รายละเอียดโปรแกรมเพิ่มเติม</h2>
                        </div>
                        <a href="{{asset($row->pdf)}}" target="_blank" class="btn btn-border"><i class="bi bi-file-earmark-pdf-fill"></i> ดาวน์โหลดโปรแกรมทัวร์ PDF</a>
                    </div>
                </div>
                    <div class="tagcat02 mt-3 mb-3">
                        @foreach ($country as $c)
                            <li><a href="{{url('package/'.$c->id)}}">#{{$c->country_name_th}}</a></li>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="sticky-top">
                        <div class="boxfaqlist">
                            <div class="titletopic">
                                <h2>แพ็คเกจทัวร์</h2>
                            </div>
                            <ul class="favelist">
                                    <li><a href="{{url('package/0')}}">แพ็คเกจทัวร์ทั้งหมด</a></li>
                                @foreach($country_all as $c => $cou)
                                    <li><a href="{{url('package/'.$cou->id)}}">ทัวร์{{$cou->country_name_th}} </a></li>
                                @endforeach 
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="row mt-5">
                <div class="col">
                    <div class="titletopic">
                        <h2>แพคเกจที่เกี่ยวข้อง</h2>
                    </div>
                </div>
            </div>
            <div class="row mt-3 mb-3">
                @foreach ($recom as $re)
                <div class="col-6 col-lg-3">
                    <div class="newslistgroup hoverstyle">
                        <figure>
                            <a href="{{url('package-detail/'.$re->id)}}">
                                <img src="{{asset($re->img)}}" alt="">
                            </a>
                        </figure>
                        <div class="detail">
                            <h3>{{$re->package}}</h3>
                            <h4><span>ราคาเริ่มต้น</span> {{$re->price}} บาท</h4>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @include("frontend.layout.inc_footer")

</body>

</html>