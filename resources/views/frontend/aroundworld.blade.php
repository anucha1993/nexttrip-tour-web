<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    @include("frontend.layout.inc_header")
    <?php $pageName="around"; ?>
</head>

<body>
    @include("frontend.layout.inc_topmenu")
    <section id="aroundpage" class="wrapperPages">
        <div class="container-fluid g-0 overflow-hidden">
            <div class="row">
                <div class="col">
                    <div class="bannereach-left">
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
                <div class="col">
                    <div class="pageontop_sl">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">หน้าหลัก </a></li>

                                <li class="breadcrumb-item active" aria-current="page">รอบรู้เรื่องเที่ยว</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-lg-8">
                    <div class="row">
                        @foreach($travel as $t)
                            <?php  
                                    if(!$country_id){
                                        @$coun_t = App\Models\Backend\CountryModel::whereIn('id',json_decode($t->country_id,true))->first(); 
                                    }else{
                                        $coun_t = App\Models\Backend\CountryModel::where('id',$country_id)->first();
                                    }
                                   $type_t =  App\Models\Backend\TypeArticleModel::where('id',$t->type_id)->first(); 
                            ?>
                        <div class="col-6 col-lg-6">
                            <div class="newslistgroup hoverstyle">
                                <figure>
                                    <a href="{{url('around-detail/'.$t->id)}}">
                                        <img src="{{asset($t->img_cover)}}" alt="">
                                    </a>
                                </figure>
                                <div class="crntag">
                                    <img src="{{asset(@$coun_t->img_icon)}}" alt="" style="width:27px;height:20px;"> {{@$coun_t->country_name_th}}
                                </div>
                                <div class="tagcat02 mt-3">
                                    <li>
                                        <a href="{{url('aroundworld/'.$country_id.'/'.$type_t->id.'/0')}}">{{$type_t->type}}</a> </li>
                                </div>
                                <h3><a href="{{url('around-detail/'.$t->id)}}">{{$t->title}}</a> </h3>

                                <div class="row">
                                    <div class="col-lg-8"> <span class="date">{{date('d',strtotime($t->created_at))}} {{ $month[date('n',strtotime($t->created_at))] }}  {{date('Y',strtotime($t->created_at)) + $addYear}}</span></div>
                                    <div class="col-lg-4 text-lg-end">
                                        <div class="viewscount"><i class="fi fi-rr-eye"></i> {{$t->views}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="boxfaqlist">
                        <div class="titletopic">
                            <h3>ดูบทความตามประเทศ</h3>
                        </div>
                        <?php 
                            $arr = array();
                            foreach($row as $in){
                                $arr = array_merge($arr,json_decode($in->country_id,true));
                            }  
                            $arr = array_unique($arr);
                            $country = App\Models\Backend\CountryModel::whereIn('id',$arr)->get(); 
                        ?>
                        <ul class="countryBlog">
                            @foreach($country as $c => $cou)
                                <li><a href="{{url('aroundworld/'.$cou->id.'/'.$type_id.'/'.$tag_id)}}" class="containcc">
                                        <img src="{{asset($cou->img_banner)}}" alt="">
                                        <div class="text">{{$cou->country_name_th}}</div>
                                        <div class="overlay">
                                            <div class="text">{{$cou->country_name_th}}</div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                        </ul>

                    </div>
                    <div class="boxfaqlist">
                        <div class="titletopic">
                            <h3>ประเภทบทความ</h3>
                        </div>
                        <?php 
                            $check_type = array();
                            foreach($row as $in){
                                $check_type[$in->id] = $in->type_id;    
                            }  
                            $check_type = array_unique($check_type); 
                            $count_type = App\Models\Backend\TypeArticleModel::whereIn('id',$check_type)->get(); 
                        ?>
                        <ul class="favelist">
                            @foreach ($count_type as $c )
                                <li><a href="{{url('aroundworld/'.$country_id.'/'.$c->id.'/0')}}" @if($type_id == $c->id) style="color:#f15a22" @endif>{{$c->type}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="boxfaqlist">
                        <div class="titletopic">
                            <h3>บทความอัพเดทล่าสุด</h3>
                        </div>
                        @foreach ($latest as $lat)
                        <div class="row mt-3 ">
                            <div class="col">
                                <div class="row groupnews hoverstyle">
                                    <div class="col-5 col-lg-4">
                                        <figure>
                                            <a href="{{url('around-detail/'.$lat->id)}}">
                                                <img src="{{asset($lat->img_cover)}}" alt="">
                                            </a>
                                        </figure>
                                    </div>
                                    <div class="col-7 col-lg-8 ps-0">
                                        <div class="newslistgroup">
                                            <h3><a href="{{url('around-detail/'.$lat->id)}}">{{$lat->title}}</a>
                                            </h3>
                                            <span class="date">{{date('d',strtotime($lat->created_at))}} {{ $month[date('n',strtotime($lat->created_at))] }}  {{date('Y',strtotime($lat->created_at)) + $addYear}}</span>
                                            <div class="viewscount text-end"><i class="fi fi-rr-eye"></i> {{$lat->views}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="boxfaqlist">
                        <div class="titletopic">
                            <h3><i class="fi fi-rr-circle-star"></i> บทความยอดนิยม</h3>
                        </div>
                        @foreach($popular as $pop)
                            <?php  $coun = App\Models\Backend\CountryModel::whereIn('id',json_decode($pop->country_id,true))->first();  ?>
                        <div class="row mt-3 ">
                            <div class="col">
                                <div class="row groupnews hoverstyle">
                                    <div class="col-5 col-lg-4">
                                        <figure>
                                            <a href="{{url('around-detail/'.$pop->id)}}">
                                                <img src="{{asset($pop->img_cover)}}" alt="">
                                            </a>
                                        </figure>
                                    </div>
                                    <div class="col-7 col-lg-8 ps-0">
                                        <div class="newslistgroup">
                                            <h3><a href="{{url('around-detail/'.$pop->id)}}">{{$pop->title}}</a>
                                            </h3>
                                            <span class="date">{{date('d',strtotime($pop->created_at))}} {{ $month[date('n',strtotime($pop->created_at))] }}  {{date('Y',strtotime($pop->created_at)) + $addYear}}</span>
                                            <div class="viewscount"><i class="fi fi-rr-eye"></i> {{$pop->views}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="boxfaqlist">
                        <div class="titletopic">
                            <h3><i class="fi fi-rr-tags"></i> แท๊กที่เกี่ยวข้อง</h3>
                        </div>
                        <?php 
                            $check = array();
                            foreach($row as $in){
                                $check = array_merge($check,json_decode($in->tag,true));
                            }  
                            $check = array_unique($check); 
                            $count_tag =  App\Models\Backend\TagContentModel::whereIn('id',$check)->limit(15)->get();
                        ?>
                        <div class="tagcat02">
                        @foreach ($count_tag as $c)
                            <li ><a href="{{url('aroundworld/'.$country_id.'/0'.'/'.$c->id)}}">{{$c->tag}}</a> </li>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4 mb-4">
                <div class="col">
                    <div class="pagination_bot">
                        <nav class="pagination-container">
                            <div class="pagination">
                                <?php $page = $travel->currentPage();
                                    $total_page = $travel->lastPage();
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