<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    @include("frontend.layout.inc_header")
</head>

<body>
    @include("frontend.layout.inc_topmenu")
    <section id="aboutpage" class="wrapperPages">
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
            <div class="row mt-5">
                <div class="col contentde text-center">
                    {!! $about->detail  !!}
                </div>
            </div>
            <div class="row g-0 mt-5">
                <div class="col-md-6 abtsect">
                    <img src="{{asset($about->img_left)}}" class="img-fluid" alt="">
                    <div class="abttext">
                        {!! $about->text_left  !!}
                    </div>
                </div>
                <div class="col-md-6 abtsect">
                    <img src="{{asset($about->img_right)}}" class="img-fluid" alt="">
                    <div class="abttext2">
                        {!! $about->text_right  !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row mt-5">
                <div class="col Cropscroll">
                    <div class="listtourid select-display-slide">
                        <li class="active" rel="1">
                            <a href="javascript:void(0)">
                                ข้อมูลการจัดตั้งบริษัท </a>
                        </li>
                        <li rel="2">
                            <a href="javascript:void(0)">
                                ธุรกิจหลักของบริษัท </a>
                        </li>
                        <li rel="3">
                            <a href="javascript:void(0)">
                                กลุ่มลูกค้าบริษัท</a>
                        </li>

                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col">
                    <div class="display-slide" rel="1" style="display:block;">
                        <div class="abtslide owl-theme owl-carousel">
                            @foreach($licen as $li)
                            <div class="item text-center">
                                <div class="boxwhiteshd  hoverstyle">
                                    <figure>
                                        <a href="#"><img src="{{asset($li->img)}}" class="img-fluid" alt=""></a>
                                    </figure>
                                    <p style="font-size: 14px;">{{$li->detail}}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="display-slide" rel="2">
                        @foreach($business as $b => $bu)
                        <div class="row">
                            <div class="col-lg-4 offset-lg-4 businessdetails">
                                <li class="listnumber"><span>0{{$b+1}}</span> {{$bu->list}}</li>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="display-slide" rel="3">
                        @foreach($group as $g => $gro)
                        <div class="row">
                            <div class="col-lg-8 offset-lg-2 businessdetails">
                                <li class="listnumber"><span>0{{$g+1}}</span>{{$gro->list}}</li>  
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row mt-5 mb-4">
                <div class="col">
                    <div class="titletopic text-center">
                        <h2>รางวัลที่ได้รับ</h2>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col">
                    <div class="awardsslider owl-theme owl-carousel">
                        @foreach($award as $aw)
                        <div class="item">
                            <div class="hoverstyle">
                                <figure>
                                    <a href="#"><img src="{{asset($aw->img)}}" class="img-fluid" alt=""></a>
                                </figure>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include("frontend.layout.inc_footer")

    <script>
        $(document).ready(function () {
            $('.awardsslider').owlCarousel({
                loop: true,
                autoplay: false,
                smartSpeed: 2000,
                nav: true,
                navText: ['<img src="{{url('frontend/images/arrowRight.svg')}}">', '<img src="{{url('frontend/images/arrowLeft.svg')}}">'],
                navClass: ['owl-prev', 'owl-next'],
                dots: false,
                margin: 20,
                responsive: {
                    0: {
                        items: 2,


                    },
                    600: {
                        items: 3,
                        slideBy: 1,

                    },
                    1024: {
                        items: 4,
                        slideBy: 1
                    },
                    1200: {
                        items: 4,
                        slideBy: 1
                    }
                }
            })
            $('.abtslide').owlCarousel({
                loop: true,
                autoplay: false,
                smartSpeed: 2000,
                nav: true,
                navText: ['<img src="{{url('frontend/images/arrowRight.svg')}}">', '<img src="{{url('frontend/images/arrowLeft.svg')}}">'],
                navClass: ['owl-prev', 'owl-next'],
                dots: false,
                margin: 10,
                responsive: {
                    0: {
                        items: 1,


                    },
                    600: {
                        items: 2,
                        slideBy: 1,

                    },
                    1024: {
                        items: 3,
                        slideBy: 1
                    },
                    1200: {
                        items: 3,
                        slideBy: 1
                    }
                }
            })


        });
    </script>

</body>

</html>