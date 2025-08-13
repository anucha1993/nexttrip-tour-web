<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head> 
    @include("frontend.layout.inc_header")
	<title>แพคเกจทัวร์ ,เที่ยวด้วยตนเอง</title>
</head>

<body>
    @include("frontend.layout.inc_topmenu")
    <section id="packagepage" class="wrapperPages">
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
            <div class="row mt-3">
                <div class="col">
                    <div class="pageontop_sl">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">หน้าหลัก </a></li>

                                <li class="breadcrumb-item active" aria-current="page">แพ็คเกจทัวร์ทั้งหมด</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-lg-9">
                    <div class="row">
                        @foreach ($row as $r)
                        <div class="col-6 col-lg-4">
                            <div class="newslistgroup hoverstyle">
                                <figure>
                                    <a href="{{url('package-detail/'.$r->id)}}">
                                        <img src="{{asset($r->img)}}" alt="">
                                    </a>
                                </figure>
                                <div class="detail">
                                    <h3> <a href="{{url('package-detail/'.$r->id)}}">{{$r->package}} </a></h3>
                                    <h4><span>ราคาเริ่มต้น</span> {{$r->price}} บาท</h4>
                                </div>
                            </div>
                        </div>
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
                                <li @if($id == 0) class="active" @endif><a href="{{url('package/0')}}">แพ็คเกจทัวร์ทั้งหมด</a></li>
                                @foreach($country as $c => $cou)
                                    <li @if($id == $cou->id)class="active" @endif><a href="{{url('package/'.$cou->id)}}">ทัวร์{{$cou->country_name_th}} </a></li>
                                @endforeach 
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
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