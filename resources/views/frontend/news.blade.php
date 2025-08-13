<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    @include("frontend.layout.inc_header")
</head>

<body>
    @include("frontend.layout.inc_topmenu")
    <section id="newspage" class="wrapperPages">
        <div class="container-fluid g-0 overflow-hidden">
            <div class="row">
                <div class="col">
                    <div class="bannereach-left">
                        <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                            <img src="{{asset($banner->img)}}" alt="">
                        </div>
                        <div class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
                            <img src="{{asset($banner->img_mobile)}}" alt="">
                        </div>
                        <div class="bannercaption">
                            {!! $banner->detail !!}
                            <ul class="news_category">
                                <li @if($id == 0) class="active" @endif><a href="{{url('news/0/0')}}">ข่าวสารทั้งหมด</a></li>
                                <?php 
                                    $type_all = App\Models\Backend\TypeNewModel::orderBy('id','asc')->get();
                               ?>
                                @foreach ($type_all as $t => $ty)
                                    <li @if($id == $ty->id && $id != 0) class="active" @endif><a href="{{url('news/'.$ty->id.'/0')}}">{{$ty->type}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-5 trnstop">
            <?php
                $month =['','มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];
                $addYear = 543;
            ?>   
            @foreach ($now as $n)
                <?php  $type = App\Models\Backend\TypeNewModel::find($n->type_id); ?>
                <div class="col-lg-4">
                    <div class="newsboxshow hoverstyle">
                        <figure>
                            <a href="{{url('news-detail/'.$n->id)}}">
                                <img src="{{asset($n->img)}}" alt="">
                            </a>
                        </figure>
                        <a href="{{url('news-detail/'.$n->id)}}">
                            <div class="tagcatnews01">
                                {{$type->type}}
                            </div>
                            <div class="contentnews">
                                <h2>{{$n->title}}</h2>
                                <span class="date">{{date('d',strtotime($n->created_at))}} {{ $month[date('n',strtotime($n->created_at))] }}  {{date('Y',strtotime($n->created_at)) + $addYear}}</span>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
            </div>
            <div class="row mb-4">
                <div class="col">
                    <div class="titletopic">
                        <h2>ข่าวสารแนะนำจาก เน็กซ์ ทริป ฮอลิเดย์</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($row as $r)
                <?php  $type_r = App\Models\Backend\TypeNewModel::find($r->type_id); ?>
                <div class="col-6 col-lg-6">
                    <div class="row groupnews hoverstyle">
                        <div class="col-lg-6">
                            <figure>
                                <a href="{{url('news-detail/'.$r->id)}}">
                                    <img src="{{asset($r->img)}}" alt="">
                                </a>
                            </figure>
                        </div>
                        <div class="col-lg-6">
                            <div class="newslistgroup">
                                <div class="tagcat02">
                                    <li><a href="{{url('news/'.$type_r->id.'/0')}}">{{$type_r->type}}</a> </li>
                                </div>
                                <h3><a href="{{url('news-detail/'.$r->id)}}"> {{$r->title}}</a></h3>
                                <span class="date">{{date('d',strtotime($r->created_at))}} {{ $month[date('n',strtotime($r->created_at))] }}  {{date('Y',strtotime($r->created_at)) + $addYear}}</span> <br><br>
                                <a href="{{url('news-detail/'.$r->id)}}" class="btn-main-og morebtnog">อ่านต่อ</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="travelkndgsection mt-5 mb-5">
            <div class="container">
                <div class="row mb-4">
                    <div class="col">
                        <div class="titletopic text-center">
                            <h2>รอบรู้เรื่องเที่ยว</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                @foreach ($travel as $t => $tra)
                    @if($t == 0)
                        <div class="col-lg-6">
                            <div class="newsboxshow hoverstyle">
                                <figure>
                                    <a href="{{url('around-detail/'.$tra->id)}}">
                                        <img src="{{asset($tra->img_cover)}}" class="img-fluid" alt="">
                                    </a>
                                </figure>
                                <a href="{{url('around-detail/'.$tra->id)}}">
                                    <div class="contentnews">
                                        <h2>{{$tra->title}}</h2>
                                        <span class="date">{{date('d',strtotime($tra->created_at))}} {{ $month[date('n',strtotime($tra->created_at))] }}  {{date('Y',strtotime($tra->created_at)) + $addYear}}</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="col-lg-3">
                            <div class="newsboxshow hoverstyle">
                                <figure>
                                    <a href="{{url('around-detail/'.$tra->id)}}">
                                        <img src="{{asset($tra->img_cover)}}" class="img-fluid" alt="">
                                    </a>
                                </figure>
                                <a href="{{url('around-detail/'.$tra->id)}}">
                                    <div class="contentnews">
                                        <h2>{{$tra->title}}</h2>
                                        <span class="date">{{date('d',strtotime($tra->created_at))}} {{ $month[date('n',strtotime($tra->created_at))] }}  {{date('Y',strtotime($tra->created_at)) + $addYear}}</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mb-4">
                <div class="col">
                    <div class="titletopic">
                        <h2>ข่าวสารทั้งหมดจาก เน็กซ์ ทริป ฮอลิเดย์</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($new as $ne)
                <?php  $type_new = App\Models\Backend\TypeNewModel::find($ne->type_id); ?>
                <div class="col-lg-3">
                    <div class="newslistgroup hoverstyle">
                        <figure>
                            <a href="{{url('news-detail/'.$ne->id)}}">
                                <img src="{{asset($ne->img)}}" alt="">
                            </a>
                        </figure>
                        <div class="tagcat03pabs">
                           {{$type_new->type}} 
                        </div>
                        <h3><a href="{{url('news-detail/'.$ne->id)}}"> {{$ne->title}} </a></h3>
                        <span class="date">{{date('d',strtotime($ne->created_at))}} {{ $month[date('n',strtotime($ne->created_at))] }}  {{date('Y',strtotime($ne->created_at)) + $addYear}}</span> <br><br>
                        <a href="{{url('news-detail/'.$ne->id)}}" class="btn-main-og morebtnog">อ่านต่อ</a>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="row mt-4 mb-4">
                <div class="col">
                    <div class="pagination_bot">
                        <nav class="pagination-container">
                            <div class="pagination">
                                <?php $page = $new->currentPage();
                                      $total_page = $new->lastPage();
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