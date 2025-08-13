<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    @include("frontend.layout.inc_header")
</head>

<body>
    @include("frontend.layout.inc_topmenu")
    <section id="clientdetaipage" class="wrapperPages">
        <div class="container">
            <div class="row mt-5">
                <div class="col">
                    <div class="pageontop_sl">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">หน้าหลัก </a></li>
                                <li class="breadcrumb-item"><a href="@if($row->type_id == 1) {{url('clients-company/0')}} @else {{url('clients-govern/0')}} @endif">ลูกค้าของเรา </a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{$row->company}}</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col bigpic">
                    <img src="{{asset($row->img_cover)}}" class="img-fluid" alt="">
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-3 text-lg-center">
                    @if($row->logo) <img src="{{asset($row->logo)}}" class="img-fluid" style="border-radius: 20px;" alt=""> @endif
                </div>
                <div class="col-lg-9">
                    <div class="titletopic">
                        <h3 class="orgtext">{{$row->company}}</h3>
                        {!! $row->detail !!}
                    </div>
                    <br>
                    <div class="tagcat02">
                        @foreach($tag as $t)
                            <li><a href="@if($row->type_id == 1) {{url('clients-company/'.$t->id)}}  @else {{url('clients-govern/'.$t->id)}} @endif">#{{$t->tag}}</a></li>
                        @endforeach
                    </div>
                   
                </div>
            </div>
            <div class="row mt-5">
                <div class="col">
                    <div class="titletopic">
                        <h2>ภาพกิจกรรม</h2>
                        <p>{{$count_gal}} ภาพ</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($gallery as $ga)
                <div class="col-6 col-lg-3 hoverstyle mb-3">
                    <figure>
                        <a href="#" data-fancybox="gallery" data-src="{{asset($ga->img)}}">
                            <img src="{{asset($ga->img)}}" class="img-fluid" alt="">
                        </a>
                    </figure>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @include("frontend.layout.inc_footer")

</body>

</html>