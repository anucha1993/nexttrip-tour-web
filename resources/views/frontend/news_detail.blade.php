<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    @include("frontend.layout.inc_header")
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
    <section id="fordetailspage" class="wrapperPages">
        <div class="socialshare">
            <span>แชร์</span>
            <ul>
                @php
                                        $urlSharer = url("news-detail/".$id);
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
                                <li class="breadcrumb-item"><a href="{{url('news/0/0')}}">ข่าวสารจากเน็กซ์ ทริป ฮอลิเดย </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{$row->title}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row mt-5 mb-5">
                <div class="col-lg-8">
                    <?php
                        $month =['','มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];
                        $addYear = 543;
                    ?>   
                    <div class="bigpic">
                        <img src="{{asset($row->img)}}" class="img-fluid" alt="">
                    </div>
                    <div class="tagcat02 mt-3 mb-3">
                        <li>
                           <a href="{{url('news/'.$type->id.'/0')}}">{{$type->type}}</a> </li>
                    </div>
                    <div class="titletopic mt-2">
                        <h1>{{$row->title}}</h1>
                        <p>{{date('d',strtotime($row->created_at))}} {{ $month[date('n',strtotime($row->created_at))] }}  {{date('Y',strtotime($row->created_at)) + $addYear}}</p>
                    </div>
                    <div class="contentde mb-3">
                        {!! $row->detail !!}
                    </div>
                    <div class="tagcat02">
                        @foreach($tag as $t)
                        <li><a href="{{url('news/0/'.$t->id)}}">#{{$t->tag}}</a></li>
                        @endforeach
                    </div>
                    <hr class="mt-5">
                    <div class="titletopic mt-4">
                        <h2>ข่าวสารที่เกี่ยวข้อง</h2>
                    </div>
                    <div class="row mt-4">
                        @foreach($connect as $con)
                        <?php  $type_n = App\Models\Backend\TypeNewModel::find($con->type_id); ?>
                        <div class="col-6 col-lg-4">
                            <div class="newslistgroup hoverstyle">
                                <figure>
                                    <a href="{{url('news-detail/'.$con->id)}}">
                                        <img src="{{asset($con->img)}}" alt="">
                                    </a>
                                </figure>
                                <div class="tagcat03pabs">
                                    {{$type_n->type}}
                                </div>
                                <h3><a href="{{url('news-detail/'.$con->id)}}">{{$con->title}}</a> </h3>
                                <span class="date">{{date('d',strtotime($con->created_at))}} {{ $month[date('n',strtotime($con->created_at))] }}  {{date('Y',strtotime($con->created_at)) + $addYear}}</span> <br><br>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4 mt-3 mt-lg-0">
                    <div class="sticky-top">
                        <div class="titletopic">
                            <h2>ข่าวสารล่าสุด</h2>
                        </div>
                        @foreach($now as $n)
                            <?php  $type_now = App\Models\Backend\TypeNewModel::find($n->type_id); ?>
                            <div class="row mt-3 ">
                                <div class="col">
                                    <div class="row groupnews hoverstyle">
                                        <div class="col-5 col-lg-4">
                                            <figure>
                                                <a href="{{url('news-detail/'.$n->id)}}">
                                                    <img src="{{asset($n->img)}}" alt="">
                                                </a>
                                            </figure>
                                        </div>
                                        <div class="col-7 col-lg-8 ps-0">
                                            <div class="newslistgroup">
                                                <div class="tagcat02">
                                                    <li><a href="{{url('news/'.$type_now->id.'/0')}}">{{$type_now->type}}</a> </li>
                                                </div>
                                                <h3><a href="{{url('news-detail/'.$n->id)}}"> {{$n->title}} </a></h3>
                                                <span class="date">{{date('d',strtotime($n->created_at))}} {{ $month[date('n',strtotime($n->created_at))] }}  {{date('Y',strtotime($n->created_at)) + $addYear}}</span> <br><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include("frontend.layout.inc_footer")

</body>

</html>