<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head> 
    @include("frontend.layout.inc_header")
</head>

<body>
    @include("frontend.layout.inc_topmenu") 
    <section id="vidopages" class="wrapperPages">
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
                        </div>
                        <div class="formserch">
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1"><i class="fi fi-rr-search"></i></span>
                                <input type="text" class="form-control" placeholder="ค้นหาวีดีโอประเทศ, เมือง เช่น โอซาก้า" aria-label="search"
                                    aria-describedby="basic-addon1" name="search_data" id="search" onkeyup="Search()">
                            </div>
                            <div id="livesearch"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-6 trnstop" style="margin-top: 4rem;">
                <?php
                    $month =['','มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];
                    $addYear = 543;
                ?>   
                @foreach ($now as $n)
                    <?php  $tag = App\Models\Backend\TagContentModel::whereIn('id',json_decode($n->tag,true))->get(); 
                        $coun_data = App\Models\Backend\CountryModel::whereIn('id',json_decode($n->country_id,true))->get();
                       $ci_data = App\Models\Backend\CityModel::whereIn('id',json_decode($n->city_id,true))->get(); 
                    ?>
                    <div class="col-6 col-lg-6">
                        <div class="newslistgroup hoverstyle">
                            <figure>
                                <a href="{{$n->link}}" target="_blank">
                                    <img src="{{asset($n->img)}}" alt="">
                                </a>
                            </figure>
                            <div class="tagcat02 mt-3">
                                @if($ci_data) 
                                    @foreach ($coun_data as $c)
                                        <li> <a href="{{url('video/'.$c->id.'/0')}}">#{{$c->country_name_th}}</a> </li>
                                    @endforeach 
                                    @foreach ($ci_data as $i)
                                        <li> <a href="{{url('video/0/'.$i->id)}}">#{{$i->city_name_th}}</a> </li>
                                    @endforeach
                                @else 
                                    @foreach ($coun_data as $c)
                                        <li><a href="{{url('video/'.$c->id.'/0')}}">#{{$c->country_name_th}}</a> </li>
                                    @endforeach
                                @endif
                            </div>
                            <h3><a href="{{$n->link}}" target="_blank">{{$n->title}}</a> </h3>
                            <span class="date">{{date('d',strtotime($n->created_at))}} {{ $month[date('n',strtotime($n->created_at))] }}  {{date('Y',strtotime($n->created_at)) + $addYear}}</span>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col">
                    <div class="titletopic">
                        <h2>วีดีโอทั้งหมด </h2>
                    </div>
                    <div class="tagcat02">
                        <li><a href="{{url('video/0/0')}}">ดูวิดีโอทั้งหมด</a></li>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                @foreach ($row as $r)
                <?php  $tag_data = App\Models\Backend\TagContentModel::whereIn('id',json_decode($r->tag,true))->get();
                       $coun = App\Models\Backend\CountryModel::whereIn('id',json_decode($r->country_id,true))->get();
                       $ci = App\Models\Backend\CityModel::whereIn('id',json_decode($r->city_id,true))->get(); 
                ?>
                <div class="col-6 col-lg-3">
                    <div class="newslistgroup hoverstyle">
                        <figure>
                            <a href="{{$r->link}}" target="_blank">
                                <img src="{{asset($r->img)}}" alt="">
                            </a>
                        </figure>
                        <div class="tagcat02 mt-3">
                            @if($ci) 
                                @foreach ($coun as $c)
                                    <li> <a href="{{url('video/'.$c->id.'/0')}}">#{{$c->country_name_th}}</a> </li>
                                @endforeach 
                                @foreach ($ci as $i)
                                    <li> <a href="{{url('video/0/'.$i->id)}}">#{{$i->city_name_th}}</a> </li>
                                @endforeach
                            @else 
                                @foreach ($coun as $c)
                                    <li><a href="{{url('video/'.$c->id.'/0')}}">#{{$c->country_name_th}}</a> </li>
                                @endforeach
                            @endif
                        </div>
                        <h3> <a href="{{$r->link}}" target="_blank">{{$r->title}}</a> </h3>
                        <span class="date">{{date('d',strtotime($r->created_at))}} {{ $month[date('n',strtotime($r->created_at))] }}  {{date('Y',strtotime($r->created_at)) + $addYear}}</span>
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
            var url = "{{url('video')}}";
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
                        document.getElementById("livesearch").style.zIndex="1";
                        document.getElementById("livesearch").style.width = "100%";
                        document.getElementById("livesearch").style.height = "200px";
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
</body>

</html>