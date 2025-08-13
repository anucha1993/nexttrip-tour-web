<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    @include("frontend.layout.inc_header")
    <?php $pageName="promotion";
    if(isset($_GET['page'])){ $page = urldecode($_GET['page']); }else{ $page = 1;}
    ?>
</head>

<body>
    @include("frontend.layout.inc_topmenu")

    <section id="promotionpage" class="wrapperPages">
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
                <div class="col-lg-3">
                    <div class="sticky-top">
                        <div class="boxfaqlist">
                            <div class="titletopic"> 
                                <h2>ประเทศ</h2>
                            </div>
                            <?php
                                $total = 0;
                                foreach($id_tour as $num_coun){
                                    $total += count($num_coun);
                                }
                            ?>
                            <ul class="favelist">
                                <li><a href="{{url('promotiontour/0/0')}}" @if($id == 0)  class="active" @endif >ทั้งหมด</a><span>({{$total}})</span></li>
                                @foreach ($country_all as $k => $coun)
                                @php
                                    $data = App\Models\Backend\CountryModel::find($coun);
                                @endphp
                                    <li><a href="{{url('promotiontour/'.$data->id.'/'.$tid)}}" @if($id == $data->id) class="active" @endif>{{$data->country_name_th}} </a> <span>({{isset($id_tour[$coun])?count($id_tour[$coun]):0}})</span></li>
                                @endforeach
                            </ul>
                        </div>
                      
                        <div class="boxfaqlist mt-3">
                            <div class="titletopic">
                                <h2>เลือกโปรโมชั่น</h2>
                            </div>
                            <?php
                                $total_pro = 0;
                                foreach($id_tour_pro as $i  => $num_coun){
                                    $check_promotion = App\Models\Backend\PromotionModel::where('id',$i)->where('status','on')->first();
                                    if($check_promotion){
                                        $total_pro += count($num_coun);
                                    }
                                }
                            ?>
                            <ul class="favelist">
                                <li><a href="{{url('promotiontour/0/0')}}" @if($tid == 0)  class="active" @endif >ทั้งหมด</a><span>({{$total_pro}})</span></li>
                                @foreach ($promotion_total as $k => $promo)
                                        @php
                                            $pro = App\Models\Backend\PromotionModel::where('id',$k)->where('status','on')->first();
                                        @endphp
                                    {{-- @if($pro)<li><a href="{{url('promotiontour/'.$id.'/'.$pro->id)}}" @if($tid == $pro->id) class="active" @endif>{{@$pro->promotion_name}} </a> <span>({{count($promo)}})</span></li>@endif --}}
                                    @if($pro)<li onClick="Promotion_filter('promoid{{$pro->id}}',{{json_encode($promo)}})" >
                                        <a href="javascript:void(0);" id="promoid{{$pro->id}}" >{{@$pro->promotion_name}}<span>({{count($promo)}})</span></a></li>@endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <?php
                    $month =['','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
                    $count_p1 = 1;
                    $page_data1 = array();
                    $check_d1 = false;
                    $check_d2 = false;
                    $check_d3 = false;
                    $check_d4 = false;
                    foreach ($express as  $ex) {
                        $ex_data = array();
                        foreach ($ex as $p => $pt1) {
                            $check_d1 = false;
                            $check_d2 = false;
                            $check_d3 = false;
                            $check_d4 = false;
                            $price1 = $pt1->price1*30/100;
                            $price2 = $pt1->price2*30/100;
                            $price3 = $pt1->price3*30/100;
                            $price4 = $pt1->price4*30/100;
                            if($pt1->special_price1 > $price1 || $pt1->special_price1 > 0){
                                $check_d1 = true;
                            } 
                            if($pt1->special_price2 > $price2 || $pt1->special_price2 > 0){
                                $check_d2 = true;
                            } 
                            if($pt1->special_price3 > $price3 || $pt1->special_price3 > 0){
                                $check_d3 = true;
                            } 
                            if($pt1->special_price4 > $price4 || $pt1->special_price4 > 0){
                                $check_d4 = true;
                            } 
                            // if($check_d){
                            //     $page_data1[$count_p1][$pt1->t_id][] = $pt1;
                            // }
                            // echo "$pt1->pe_id-$check_d1-$check_d2<br>";
                            if($check_d1 || $check_d2 || $check_d3 || $check_d4){
                                $ex_data[] = $pt1;
                            }
                        }
                        if(count($ex_data)){
                            $page_data1[$count_p1][] = $ex_data;
                        }
                        if(isset($page_data1[$count_p1])){
                            if(count($page_data1[$count_p1]) >= 6){
                                $count_p1++;
                            }
                        }
                        
                    }
                    //dd($page_data1[$page]);
                ?> 
                <div class="col-lg-9">
                    <div class="row mt-3 mt-lg-0">
                        <div class="col-12 col-md-8">
                            @if(isset($page_data1[$page]))
                                <div class="titletopic">
                                    <h2>โปรไฟไหม้</h2>
                                    <p>ทัวร์ไฟไหม้ ทัวร์ลดราคา ตั้งแต่ 30-70% แพคเกจทัวร์ลดราคา ทัวร์ไฟไหม้ญี่ปุ่น, ทัวร์ไฟไหม้ฮ่องกง, ทัวร์ไฟไหม้จีน, ทัวร์ไฟไหม้เวียดนาม,ทัวร์ไฟไหม้ต่างประเทศ เป็นทัวร์ที่ลดราคาขายแบบด่วน เพื่อให้กรุ๊ปได้ออกเดินทาง ทัวร์ขายลดราคา แต่ไม่ได้ลดคุณภาพ<br>เหมะสำหรับลูกค้าที่พร้อมชำระเงิน พาสปอร์ตพร้อมเดินทาง ซึ่งปกติจะลดราคาก่อนเดินทาง 3-7 วันเท่านั้น เป็นทัวร์ที่ราคาถูกที่สุด</p>
                                </div>
                            @endif
                        </div>
                        <div class="col-12 col-md-4 text-md-end">
                            <div class="socialshare_nonfix">
                                <ul>
                                    <li> <span>แชร์</span></li>
                                    @php
                                        $urlSharer = url("promotiontour/0/0");
                                        $lineUrl = "https://social-plugins.line.me/lineit/share?url=".$urlSharer;
                                        $facebookUrl = "https://www.facebook.com/sharer.php?u=".$urlSharer;
                                        $twitterUrl = "https://twitter.com/intent/tweet?url={$urlSharer}";
                                    @endphp
                                    <li><a href="{{url($lineUrl)}}" target="_blank">
                                            <img src="{{asset('frontend/images/line_share.svg')}}" alt="">
                                        </a></li>
                                    <li><a href="{{url($facebookUrl)}}" target="_blank">
                                            <img src="{{asset('frontend/images/facebook_share.svg')}}" alt="">
                                        </a></li>
                                    <li><a href="{{url($twitterUrl)}}" target="_blank">
                                            <img src="{{asset('frontend/images/twitter_share.svg')}}" alt="">
                                        </a></li>&nbsp;&nbsp;
                                    <input type="hidden" value="{{$urlSharer}}" id="myInput">
                                    <li class="copylink" style="color:#f15a22"><i class="fi fi-rr-link-alt" onclick="myFunction()"></i></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3" id="showhot_filter_hot">
                        {{-- <center>Loading hot...</center> --}}
                    </div>
                    <center><button class="btn btn-submit d-none" id="btn-hot" onClick="ShowmoreHot()">ดูเพิ่มเติม</button></center>
                    @php
                            $count_p = 1;
                            $page_data = array();
                            $save_promo = array();
                            $check_pro = false;
                            $check_price = false;
                            // dd($row);
                            foreach ($row as  $r) {
                                //    if(!isset($page_data[$count_p])){
                                //      $page_data[$count_p] = array();
                                //    }
                                $pro_data = array();
                                $key = null;
                                foreach ($r as $p => $pt) {
                                    // dd($r);
                                    $check_pro = false;
                                    $check_price = false;
                                    $date_now_pro = strtotime(date('Y-m-d'));
                                    $date_start_pro = strtotime($pt->pro_start_date);
                                    $date_end_pro = strtotime($pt->pro_end_date);
                                    // dd($date_start_pro,$date_now_pro,$date_end_pro);
                                    if($date_start_pro <= $date_now_pro && $date_end_pro >=  $date_now_pro){
                                        // $page_data[$count_p][] = $pt;
                                        // dd(1);
                                        $check_pro = true;
                                        // echo "$pt->t_id-$check_pro<br>";
                                        
                                    }else if($pt->special_price1 > 0 || $pt->special_price2 > 0 || $pt->special_price3 > 0 || $pt->special_price4 > 0 && $pt->promotion2 == 'Y'){
                                        // $page_data[$count_p][] = $pt;
                                        $check_price = true;
                                    }
                                    if($check_pro || $check_price){
                                        $pro_data[] = $pt;
                                        // break;
                                    }
                                }
                                if(count($pro_data)){
                                    $page_data[$count_p][] = $pro_data;
                                }
                                if(isset($page_data[$count_p])){
                                    if(count($page_data[$count_p]) >= 6){
                                        $count_p++;
                                    }
                                }
                            }
                            
                        //   dd($page_data);
                        @endphp
                    <div class="row mt-5" id="myScoll">
                        <div class="col" >
                            @if(isset($page_data[$page]))
                                    <div class="titletopic" id="topic_promotion">
                                        <h2>โปรโมชั่นทัวร์</h2>
                                        <p>ทัวร์โปรโมชั่น หลากหลายเส้นทาง โปรโมชั่นทัวร์จีน โปรโมชั่นทัวร์ฮ่องกง โปรโมชั่นทัวร์ญี่ปุ่น โปรโมชั่นทัวร์เวียดนาม โปรโมชั่นทัวร์ยุโรป ทัวร์โปรโมชั่นมีทั้ง ทัวร์รูดบัตรไม่ชาร์จ,ทัวร์ผ่อน 0% นาน 3-24 เดือน จองก่อนรับส่วนลดทัวร์คุ้มที่สุด</p>
                                    </div>
                            @endif
                        </div>
                    </div>
                    <div class="row mt-3" id="show_filter">
                        {{-- <center>Loading...</center> --}}
                    </div>
                    <center><button class="btn btn-submit d-none" id="btn-promotion" onClick="ShowmorePromotion()">ดูเพิ่มเติม</button></center>
                    <div class="row mt-4 mb-4">
                        <div class="col">
                          
                            {{-- <div class="pagination_bot" id="paginate">
                                <nav class="pagination-container">
                                    <div class="pagination">
                                        <?php $total_page = count($page_data); 
                                            $older = $page+1;    
                                            $newer = $page-1;  
                                        ?>
                                        <?php if($total_page > 1){?>
                                        @if($page != $newer && $page != 1)
                                            <a class="pagination-newer" href="?page={{$newer}}"><i class="fas fa-angle-left"></i></a>
                                        @endif
                                        <span class="pagination-inner">
                                            <?php for($i=1; $i<=$total_page; $i++){ ?> 
                                                <a class="<?php if($i == $page) { echo 'pagination-active';}?>"  href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                            <?php } ?>
                                        </span>
                                        @if($page != $older && $page != $total_page)
                                            <a class="pagination-older" href="?page={{$older}}"><i class="fas fa-angle-right"></i></a>
                                        @endif
                                        <?php } ?>
                                    </div>
                                </nav>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>
    @php
        $page_data = json_encode($page_data);
        $page_data1 = json_encode($page_data1);
        $save_promo = json_encode($save_promo);
        $pro_country = json_encode($pro_country);
    @endphp
    @include("frontend.layout.inc_footer")
    <script>
        $(document).ready(function () {
            $('.categoryslide_list').owlCarousel({
                loop: true,
                item: 1,
                margin: 0,
                slideBy: 1,
                autoplay: false,
                smartSpeed: 2000,
                nav: true,
                navText: ['<img src="{{asset('frontend/images/arrowRight.svg')}}">', '<img src="{{asset('frontend/images/arrowLeft.svg')}}">'],
                navClass: ['owl-prev', 'owl-next'],
                dots: false,
                responsive: {
                    0: {
                        items: 6,
                        margin: 0,
                        nav: false,


                    },
                    600: {
                        items: 6,
                        margin: 0,
                        nav: false,

                    },
                    1024: {
                        items: 6,
                        slideBy: 1
                    },
                    1200: {
                        items: 8,
                        slideBy: 1
                    }
                }
            })



        });
    </script>
    <script>
        <?php
            echo "var paginG = $page_data;" ;
            echo "var hot = $page_data1;" ;
            echo "var save_promo = $save_promo;";
            echo "var pro_country = $pro_country;";
        ?>
        var pagin_active = 1;
        var pagin_active_hot = 1;
        var pagin = paginG;
        ShowmorePromotion();
        ShowmoreHot();
        async function ShowmorePromotion(){
            console.log(pagin,'old')
            var tour_id = new Array();
            var period_id = new Array();
            for(let data in pagin){
                tour_id[data] = new Array();
                period_id[data] = new Array();
                for(let d in pagin[data]){
                    for(let a in pagin[data][d]){
                        tour_id[data].push(pagin[data][d][a].t_id);
                        period_id[data].push(pagin[data][d][a].pe_id);
                    }
                }
            }
            // if(pagin_active == 1){
            //     Swal.fire({
            //     title: "Loading . . . ",
            //         didOpen: () => {
            //             Swal.showLoading();
            //         },
            //     });
            // }
            $.ajax({
                type: 'POST',
                url: '{{url("/showmore")}}',
                data:  {
                    _token: '{{csrf_token()}}',
                    tour_id:tour_id,
                    period_id:period_id,
                    paginate:pagin_active,
                },
                success: function (data) {
                    if(data != false){
                        if(pagin_active == 1){
                            document.getElementById('show_filter').innerHTML =  data; 
                            var check_data = document.getElementById('check_data'+pagin_active).value;
                            if(check_data*1){
                                $('#btn-promotion').removeClass('d-none');
                            }else{
                                $('#btn-promotion').addClass('d-none');
                            }
                            // Swal.close();
                        }else{
                            $('#show_filter').append(data);
                            var check_data = document.getElementById('check_data'+pagin_active).value;
                            if(check_data*1){
                                $('#btn-promotion').removeClass('d-none');
                            }else{
                                $('#btn-promotion').addClass('d-none');
                            }
                           
                        }
                        pagin_active++;
                   }else{
                        $('#btn-promotion').addClass('d-none');
                   } 
                },
                error:function(e){
                    // if(pagin_active == 1){
                    //     Swal.close();
                    // }
                }
            });
           
        }
        async function ShowmoreHot(){
            var tour_id = new Array();
            var period_id = new Array();
            for(let data in hot){
                tour_id[data] = new Array();
                period_id[data] = new Array();
                for(let d in hot[data]){
                    for(let a in hot[data][d]){
                        tour_id[data].push(hot[data][d][a].t_id);
                        period_id[data].push(hot[data][d][a].pe_id);
                    }
                }
            }
            // var tour_id = new Array();
            // var period_id = new Array();
            // for(let data in hot){
            //     tour_id[data] = new Array();
            //     period_id[data] = new Array();
            //     for(let d in hot[data]){
            //         for(let a in hot[data][d]){
            //             tour_id[data].push(hot[data][d][a].t_id);
            //             period_id[data].push(hot[data][d][a].pe_id);
            //         }
            //     }
            // }
            $.ajax({
                type: 'POST',
                url: '{{url("/showmore-hot")}}',
                data:  {
                    _token: '{{csrf_token()}}',
                    tour_id:tour_id,
                    period_id:period_id,
                    paginate:pagin_active_hot,
                },
                success: function (data) {
                    if(data != false){
                        if(pagin_active_hot == 1){
                            document.getElementById('showhot_filter_hot').innerHTML = data; 
                            var check_data = document.getElementById('check_datahot'+pagin_active_hot).value;
                            if(check_data*1){
                                $('#btn-hot').removeClass('d-none');
                            }else{
                                $('#btn-hot').addClass('d-none');
                            }
                        }else{
                            $('#showhot_filter_hot').append(data);
                            var check_data = document.getElementById('check_datahot'+pagin_active_hot).value;
                            if(check_data*1){
                                $('#btn-hot').removeClass('d-none');
                            }else{
                                $('#btn-hot').addClass('d-none');
                            }
                        }
                        pagin_active_hot++;
                    }else{
                        $('#btn-hot').addClass('d-none');
                   }
                }
            });
           
        }



    var active = null;
    var pagin_filter = 1;
    var id = {{$id}};
      async  function Promotion_filter(promo_id,id_tour){
            if(id){
                var check_country = await id_tour.filter(x=> pro_country.includes(x));
                if(check_country.length){
                    id_tour = await check_country;
                }else{
                    id_tour = new Array();
                }
            }
            $('html, body').animate({
                scrollTop: $("#myScoll").offset().top
            }, 200);
            pagin_filter = 1;
            if(active){
                $("#"+active).removeClass('active');
            }
            $("#"+promo_id).addClass('active');
            active = promo_id;
            var tour_id = new Array();
            var period_id = new Array();
            var main_tour = new Array();
            var count_tour = 1;
            var check_data  = new Array();
            for(let data in id_tour){
                if(!main_tour[count_tour]){
                    main_tour[count_tour] = new Array();
                }
                main_tour[count_tour].push(id_tour[data]);
                if(main_tour[count_tour].length >= 6){
                    count_tour++;
                }
            }
          
            for(let data in main_tour){
                tour_id[data] = new Array();
                for(let d in main_tour[data]){
                    tour_id[data].push(main_tour[data][d]);
                    for(let check in paginG){
                        for(let aa in paginG[check]){
                            if(!check_data[data]){
                                check_data[data] = new Array();
                            }
                            let num = await paginG[check][aa].filter(x=>x.t_id == main_tour[data][d].toString());
                            if(num.length){
                                check_data[data].push(num);
                            }
                        }
                       
                
                    }
                   
                }
            }
            pagin = await check_data;
           await $.ajax({
                type: 'POST',
                url: '{{url("/promotiontour-filter")}}',
                data:  {
                    _token: '{{csrf_token()}}',
                    tour_id:tour_id,
                    paginate:pagin_filter,
                },
                success: function (data) {
                    if(data != false){
                        if(pagin_filter == 1){
                            document.getElementById('show_filter').innerHTML =  data; 
                            var check_data = document.getElementById('check_data'+pagin_filter).value;
                            if(check_data*1){
                                $('#btn-promotion').removeClass('d-none');
                            }else{
                                $('#btn-promotion').addClass('d-none');
                            }
                            // Swal.close();
                        }else{
                            $('#show_filter').append(data);
                            var check_data = document.getElementById('check_data'+pagin_filter).value;
                            if(check_data*1){
                                $('#btn-promotion').removeClass('d-none');
                            }else{
                                $('#btn-promotion').addClass('d-none');
                            }
                           
                        }
                        pagin_filter++;
                   }else{
                        document.getElementById('show_filter').innerHTML =  ''; 
                        $('#topic_promotion').addClass('d-none');
                        $('#btn-promotion').addClass('d-none');
                   } 
                }
            });
        }
    </script>
    <script>
    function myFunction() {
        var copyText = document.getElementById("myInput");
        console.log(copyText)
        copyText.select();
        navigator.clipboard.writeText(copyText.value);
        alert("คัดลอกลิงก์สำเร็จ");
    }
    </script>
</body>

</html>