<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head> 
    @include("frontend.layout.inc_header")
</head>

<body>
    @include("frontend.layout.inc_topmenu")
    <section id="helppage" class="wrapperPages">
        <div class="container-fluid g-0 overflow-hidden">
            <div class="row">
                <div class="col">
                    <div class="bannereach">
                        <img src="{{asset($banner->img)}}" alt="">
                        <div class="bannercaption">
                            {!! $banner->detail !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-5">
                <div class="col-lg-4">
                    <div class="boxfaqlist sticky-top">
                        <div class="d-flex align-items-start">
                            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                @foreach ($row as $i => $r)
                                <button class="nav-link @if($i == 0) active @endif" id="v-pills-home-tab{{$r->id}}" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-home{{$r->id}}" type="button" role="tab" aria-controls="v-pills-home"
                                    aria-selected="true"> {{$r->title}}</button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 mt-4 mt-lg-0">
                    <div class="tab-content" id="v-pills-tabContent">
                        @foreach ($row as $i => $r)
                        <?php  $detail = json_decode($r->detail,true); ?>
                        <div class="tab-pane fade @if($i == 0) show active @endif " id="v-pills-home{{$r->id}}" role="tabpanel"
                            aria-labelledby="v-pills-home-tab{{$r->id}}" tabindex="0">
                            <div class="titletopic mb-4">
                                <h2>{{$r->title}}</h2>
                            </div>
                            <div class="accordion" id="accordionPanelsStayOpenExample">
                            @foreach ($detail as $k => $de)
                                @foreach ($de as $t => $d)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button  @if($k != 0) collapsed @endif" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#panelsStayOpen-collapseOne{{$k}}"  @if($k == 0) aria-expanded="true" @else aria-expanded="false" @endif
                                                aria-controls="panelsStayOpen-collapseOne{{$k}}">
                                                {{$t}}
                                            </button>
                                        </h2>
                                        <div id="panelsStayOpen-collapseOne{{$k}}" class="accordion-collapse collapse  @if($k == 0) show @endif">
                                            <div class="accordion-body">
                                                {{$d}}
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid g-0 overflow-hidden contactlink">
            <div class="row mt-5">
                <div class="col">
                    <img src="{{asset('frontend/images/faqfooter.webp')}}" alt="">
                    <div class="contactps">
                        <span>หาคำถามของท่านไม่เจอใช่หรือไม่?</span>
                        <h3>ติดต่อเราเพื่อสอบถามเพิ่มเติมได้ที่</h3>
                        <a href="{{url('contact')}}" class="btn-white-main morebtn">ติดต่อเรา</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include("frontend.layout.inc_footer")

</body>

</html>