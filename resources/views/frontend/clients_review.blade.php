<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    @include("frontend.layout.inc_header")
</head>

<body>
    @include("frontend.layout.inc_topmenu")
    <section id="reviewpage" class="wrapperPages">
        <div class="reviewtopbg">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="reviewslider owl-carousel owl-theme">
                            @foreach ($recomend as $re)
                            <?php  $tag_data = App\Models\Backend\TagContentModel::whereIn('id',json_decode($re->tag,true))->get(); 
                                   $coun = App\Models\Backend\CountryModel::whereIn('id',json_decode($re->country_id,true))->get(); 
                                   $ci = App\Models\Backend\CityModel::whereIn('id',json_decode($re->city_id,true))->get();   
                            ?>
                            <div class="item">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="hoverstyle">
                                            <figure><img src="{{asset($re->img)}}" class="img-fluid" alt=""></figure>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="contents">
                                        <h1 class="mb-3">{{$re->title}}</h1>
                                            {!! $re->detail !!}
                                        <div class="tagcat02">
                                            @if($ci) 
                                                @foreach ($coun as $c)
                                                    <li> <a href="{{url('clients-review/'.$c->id.'/0')}}">#{{$c->country_name_th}}</a> </li>
                                                @endforeach 
                                                @foreach ($ci as $i)
                                                    <li> <a href="{{url('clients-review/0/'.$i->id)}}">#{{$i->city_name_th}}</a> </li>
                                                @endforeach
                                            @else 
                                                @foreach ($coun as $c)
                                                    <li><a href="{{url('clients-review/'.$c->id.'/0')}}">#{{$c->country_name_th}}</a> </li>
                                                @endforeach
                                            @endif
                                        </div>
                                        <hr>
                                        <div class="groupshowname">
                                            <div class="clleft">
                                                <div class="clientpic">
                                                    <img src="{{asset($re->profile)}}" alt="">
                                                </div>
                                            </div>
                                            <div class="clientname">{{$re->name}} <br> ทริป{{$re->trip}}</div>
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
        </div>
        <div class="container">
            <div class="row mt-5 ">
                <div class="col-12 col-lg-8">
                    <div class="titletopic">
                        <h2>คำรับรองจากลูกค้า</h2>
                    </div>
                    <div class="contentde">
                        คำขอบคุณจากลูกค้าที่ให้ความไว้วางใจจากเรา
                    </div>
                    <div class="tagcat02">
                        <li><a href="{{url('clients-review/0/0')}}">ดูรีวิวทั้งหมด</a></li>
                    </div>
                </div>
                <div class="col-12 col-lg-4 mt-2 mt-lg-0">
                    <div class="formserch">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="fi fi-rr-search"></i></span>
                                <input type="text" class="form-control" placeholder="ค้นหาประเทศ, เมือง เช่น โอซาก้า" aria-label="search"
                                        aria-describedby="basic-addon1" name="search_data" id="search" onkeyup="Search()">
                            </div>
                        <div id="livesearch" ></div>
                    </div>
                </div>
            <div class="row mt-4">
                @foreach ($row as $r)
                <?php  $tag_data = App\Models\Backend\TagContentModel::whereIn('id',json_decode($r->tag,true))->get(); 
                       $coun_data = App\Models\Backend\CountryModel::whereIn('id',json_decode($r->country_id,true))->get();
                       $ci_data = App\Models\Backend\CityModel::whereIn('id',json_decode($r->city_id,true))->get();  
                ?>
                <div class="col-6 col-lg-4">
                    <div class="clssgroup hoverstyle">
                        <figure><img src="{{asset($r->img)}}" alt="" class="img-fluid"></figure>
                        <h3>{{$r->title}}</h3>
                            {!! $r->detail !!}

                        <div class="tagcat02 mt-3">
                            @if($ci_data) 
                                @foreach ($coun_data as $c)
                                    <li> <a href="{{url('clients-review/'.$c->id.'/0')}}">#{{$c->country_name_th}}</a> </li>
                                @endforeach 
                                @foreach ($ci_data as $i)
                                    <li> <a href="{{url('clients-review/0/'.$i->id)}}">#{{$i->city_name_th}}</a> </li>
                                @endforeach
                            @else 
                                @foreach ($coun_data as $c)
                                    <li><a href="{{url('clients-review/'.$c->id.'/0')}}">#{{$c->country_name_th}}</a> </li>
                                @endforeach
                            @endif
                        </div>
                        <hr>
                        <div class="groupshowname">
                            <div class="clleft">
                                <div class="clientpic">
                                    <img src="{{asset($r->profile)}}" alt="">
                                </div>
                            </div>
                            <div class="clientname">
                                <span class="orgtext">{{$r->name}}</span>
                                <br>ทริป{{$r->trip}}</div>
                        </div>
                    </div>
                </div>
                @endforeach
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
    <script>
        <?php 
            echo "var country = $data_country;";
            echo "var city = $data_city;";
        ?>
        function Search(){
            var data = document.getElementById('search').value ;
            var result_country = '';
            var result_city = '';
            var url = "{{url('clients-review')}}";
            if(data){
                let search_country = country.filter(x => x.country_name_th.includes(data));
                let search_city = city.filter(x => x.city_name_th.includes(data)); 
                if(search_country || search_city){
                    for(x=0;x < search_country.length;x++){
                        result_country = result_country+'<a href="'+url+'/'+search_country[x].id+'/0" style="color:black; text-decoration: none;">ประเทศ'+search_country[x].country_name_th+'</a><br>';  
                    }
                    console.log(result_country)
                    if(search_city){
                        for(i=0;i < search_city.length;i++){
                            result_city = result_city+'<a href="'+url+'/0/'+search_city[i].id+'" style="color:black;text-decoration: none;">เมือง'+search_city[i].city_name_th+'</a><br>';
                        }
                    }
                    if(result_country || result_city){
                        document.getElementById("livesearch").innerHTML= "<span style='color:#3952a4;'><b>ผลการค้นหา</b></span><br>"+result_country + result_city;
                        document.getElementById("livesearch").style.border="1px solid #f15a22"; 
                        document.getElementById("livesearch").style.backgroundColor = "white";
                        document.getElementById("livesearch").style.overflowY = "scroll";
                        document.getElementById("livesearch").style.position = "absolute"; 
                        document.getElementById("livesearch").style.width = "360px";
                        document.getElementById("livesearch").style.height = "200px";
                        document.getElementById("livesearch").style.zIndex= "1";
                    }else{
                        document.getElementById("livesearch").innerHTML= "<span class='text-danger'><b>ไม่พบผลการค้นหา</b></span><br>";
                        document.getElementById("livesearch").style.border="1px solid #f15a22"; 
                        document.getElementById("livesearch").style.backgroundColor = "white";
                        document.getElementById("livesearch").style.overflowY = null;
                        document.getElementById("livesearch").style.position = null; 
                        document.getElementById("livesearch").style.zIndex= null;
                        document.getElementById("livesearch").style.width = null;
                        document.getElementById("livesearch").style.height = null;
                    }
                }else{
                    document.getElementById("livesearch").innerHTML= null;
                    document.getElementById("livesearch").style.border="0px";
                    document.getElementById("livesearch").style.backgroundColor = null;
                    document.getElementById("livesearch").style.overflowY = null;
                    document.getElementById("livesearch").style.position = null; 
                    document.getElementById("livesearch").style.zIndex= null;
                    document.getElementById("livesearch").style.width = null;
                    document.getElementById("livesearch").style.height = null;
                }
            }else{
                document.getElementById("livesearch").innerHTML= null;
                document.getElementById("livesearch").style.border="0px";
                document.getElementById("livesearch").style.backgroundColor = null;
                document.getElementById("livesearch").style.overflowY = null;
                document.getElementById("livesearch").style.position = null; 
                document.getElementById("livesearch").style.zIndex= null;
                document.getElementById("livesearch").style.width = null;
                document.getElementById("livesearch").style.height = null;
            } 
        }
    </script>
    <script>
        $(document).ready(function () {
            $('.reviewslider').owlCarousel({
                loop: false,
                item: 1,
                margin: 20,
                slideBy: 1,
                autoplay: false,
                smartSpeed: 2000,
                nav: true,
                navText: ['<img src="{{url('frontend/images/arrowRight.svg')}}">', '<img src="{{url('frontend/images/arrowLeft.svg')}}">'],
                navClass: ['owl-prev', 'owl-next'],
                dots: true,
                responsive: {
                    0: {
                        items: 1,
                        margin: 0,
                        nav: false,


                    },
                    600: {
                        items: 1,
                        margin: 0,
                        nav: false,

                    },
                    1024: {
                        items: 1,
                        slideBy: 1
                    },
                    1200: {
                        items: 1,
                        slideBy: 1
                    }
                }
            })



        });
    </script>


</body>

</html>