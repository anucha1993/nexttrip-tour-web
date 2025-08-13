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
                            <?php for ($i = 1; $i <= 3; $i++) { ?>
                            <div class="item">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="hoverstyle">
                                            <figure>
                                                <a href="#"><img src="images/reccom.webp" class="img-fluid" alt=""></a>
                                            </figure>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 contents">
                                        <h1 class="mb-3">ยุโรปตะวันออก จัดเต็ม 7 วัน</h1>
                                        <p>ต้องบอกว่าคุ้มค่ามากๆ 7 วันเต็มอิ่มสุดๆ ไปกับครอบครัวแบบฟินๆ <br>
                                            แถมไกด์ดูแลเทคแคร์ดีมาก พาทัวร์ + เช็คอินเพลินเลยทีเดียว </p>
                                        <div class="tagcat02">
                                            <li><a href="#">#Italy</a></li>
                                            <li><a href="#">#France</a></li>
                                        </div>
                                        <hr>
                                        <div class="groupshowname">
                                            <div class="clleft">
                                                <div class="clientpic">
                                                    <img src="images/cl.png" alt="">
                                                </div>
                                            </div>
                                            <div class="clientname">คุณ จอน โดว <br> ทริปฮ่องกง 5วัน 4คืน</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-5 ">
                <div class="col">
                    <div class="titletopic">
                        <h2>คำรับรองจากลูกค้า</h2>
                    </div>
                    <div class="contentde">
                        คำขอบคุณจากลูกค้าที่ให้ความไว้วางใจจากเรา
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <?php for ($i = 1; $i <= 12; $i++) { ?>
                <div class="col-6 col-lg-4">
                    <div class="clssgroup hoverstyle">
                        <figure>
                            <a href="#">
                                <img src="images/newsmock.png" alt="">
                            </a>
                        </figure>
                        <h3>ยุโรปตะวันออก จัดเต็ม 7 วัน</h3>
                        <p>ต้องบอกว่าคุ้มค่ามากๆ 7 วันเต็มอิ่มสุดๆ ไปกับครอบครัวแบบฟินๆ แถมไกด์ดูแลเทคแคร์ดีมาก พาทัวร์
                            + เช็คอินเพลินเลยทีเดียว </p>

                        <div class="tagcat02 mt-3">
                            <li>
                                <a href="#">#Italy</a> </li>
                            <li><a href="#">#France</a> </li>
                        </div>
                        <hr>
                        <div class="groupshowname">
                            <div class="clleft">
                                <div class="clientpic">
                                    <img src="images/cl.png" alt="">
                                </div>
                            </div>
                            <div class="clientname">
                                <span class="orgtext">คุณ จอน โดว</span>
                                <br>

                                ทริปฮ่องกง 5วัน 4คืน</div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </section>
    @include("frontend.layout.inc_footer")
    <script>
        $(document).ready(function () {
            $('.reviewslider').owlCarousel({
                loop: false,
                item: 1,
                margin: 20,
                slideBy: 1,
                autoplay: false,
                smartSpeed: 2000,
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