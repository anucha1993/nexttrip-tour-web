<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head> 
    @include("frontend.layout.inc_header")
</head>

<body>
    @include("frontend.layout.inc_topmenu")
    <section id="clinetpage" class="wrapperPages">
        <div class="container-fluid g-0 overflow-hidden">
            <div class="row">
                <div class="col">
                    <div class="bannereach-left">
                        <img src="{{asset($banner->img)}}" alt="">
                        <div class="bannercaption">
                            {!! $banner->detail !!}
                        </div>
                        <div class="clientlist">
                            <li>
                                <a href="{{url('clients-company/0')}}">
                                   ลูกค้าทั่วไป </a>
                            </li>
                            <li  class="active">
                                <a href="#">
                                องค์กรเอกชน/หน่วยงานราชการ </a>
                            </li>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-5">
                <div class="col">
                    <div class="titletopic text-center">
                        <h2>องค์กรเอกชน/หน่วยงานราชการ</h2>
                        <p>{{$government}} องค์กร/หน่วยงาน</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid g-0 overflow-hidden">
        <div class="row mt-3">
                <div class="col">
                    <!--  Carousel 1    -->
                    <div class="slider">
                        <div class="slide-track">
                            @foreach ($row as $r)
                                <div class="slide"> <img src="{{asset($r->logo)}}" class="img-fluid" alt=""></div>
                            @endforeach
                            @foreach ($row as $r)
                                <div class="slide"> <img src="{{asset($r->logo)}}" class="img-fluid" alt=""></div>
                            @endforeach
                            @foreach ($row as $r)
                                <div class="slide"> <img src="{{asset($r->logo)}}" class="img-fluid" alt=""></div>
                            @endforeach
                        </div>
                    </div>
                    <!--  Carousel 2 -->
                    {{-- <div class="slider">
                        <div class="slide-track">
                            <?php for ($i = 1; $i <= 9; $i++) { ?>
                            <div class="slide"> <img src="images/clients_logo2.svg" class="img-fluid" alt=""></div>
                            <?php } ?>

                            <!-- same 9 slides doubled (duplicate) -->
                            <?php for ($i = 1; $i <= 9; $i++) { ?>
                            <div class="slide"> <img src="images/clients_logo2.svg" class="img-fluid" alt=""></div>
                            <?php } ?>
                        </div>
                    </div> --}}
                    <!--  Carousel 3 -->
                    {{-- <div class="slider">
                        <div class="slide-track">
                            <?php for ($i = 1; $i <= 9; $i++) { ?>
                            <div class="slide"> <img src="images/Logo-BTG-COP-440x440_px1.svg" class="img-fluid" alt="">
                            </div>
                            <?php } ?>

                            <!-- same 9 slides doubled (duplicate) -->
                            <?php for ($i = 1; $i <= 9; $i++) { ?>
                            <div class="slide"> <img src="images/Logo-BTG-COP-440x440_px1.svg" class="img-fluid" alt="">
                            </div>
                            <?php } ?>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="container mt-5">
            @foreach ($row as $ro)
            <?php  $coun = App\Models\Backend\CountryModel::whereIn('id',json_decode($ro->country_id,true))->get(); ?>
            <div class="row groupclientsshow hoverstyle">
                <div class="col-lg-5 g-lg-0">
                    <figure>
                        <a href="{{url('clients-detail/'.$ro->id)}}"><img src="{{asset($ro->img_cover)}}" class="img-fluid" alt=""></a>
                    </figure>
                </div>
                <div class="col-lg-7 g-lg-0">
                    <div class="cliboxcet">
                        <div class="locationtag"> <img src="{{asset('frontend/images/location_pin.svg')}}" alt=""> 
                            @foreach ($coun as $c)
                                {{@$c->country_name_th}}
                            @endforeach 
                        </div>
                        <div class="logocl">
                            <img src="{{asset($ro->logo)}}" class="img-fluid" alt="">
                        </div>
                        <div class="titletopic">
                            <h3>{{$ro->company}}</h3>
                            {!! $ro->detail !!}
                        </div>
                        <a href="{{url('clients-detail/'.$ro->id)}}" class="btn-main-og morebtnog">อ่านต่อ</a>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="row mt-4 mb-4">
                <div class="col">
                    <div class="pagination_bot">
                        <nav class="pagination-container">
                            <div class="pagination">
                                <?php $page = $row->currentPage();
                                    $total_page = $row->lastPage();
                                    $older = $page+1;    
                                    $newer = $page-1;  
                                ?>
                                @if($page != $newer && $page != 1)
                                    <a class="pagination-newer" href="?page={{$newer}}"><i class="fas fa-angle-left"></i></a>
                                @endif
                                <span class="pagination-inner">
                                    @if($total_page > 1)
                                        <?php for($i=1; $i<=$total_page; $i++){ ?> 
                                            <a @if($i == $page) class="pagination-active" @endif href="?page={{$i}}">{{$i}}</a>
                                        <?php } ?>
                                    @endif
                                </span>
                                @if($page != $older && $page != $total_page)
                                    <a class="pagination-older" href="?page={{$older}}"><i class="fas fa-angle-right"></i></a>
                                @endif
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include("frontend.layout.inc_footer")
    <script>
        $(document).ready(function () {

            $('.gallery').slick({
                slidesToShow: 5,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 0,
                speed: 8000,
                pauseOnHover: false,
                cssEase: 'linear'
                responsive: [{
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3

                        }
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1
                        }
                    }

                ]

            });
        });
    </script>

</body>

</html>