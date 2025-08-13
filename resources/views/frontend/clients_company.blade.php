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
                            <li class="active">
                                <a href="#">
                                     ลูกค้าทั่วไป</a>
                            </li>
                            <li rel="2">
                                <a href="{{url('clients-govern/0')}}">
                                องค์กรเอกชน/หน่วยงานราชการ </a>
                            </li>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-3">
                <div class="col">
                    <div class="titletopic text-center">
                        <h2>ลูกค้าทั่วไป</h2>
                        <p>{{$private}} กลุ่ม</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-3">
            @foreach ($row as $ro)
            <?php  $coun = App\Models\Backend\CountryModel::whereIn('id',json_decode($ro->country_id,true))->get();?>
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


</body>

</html>