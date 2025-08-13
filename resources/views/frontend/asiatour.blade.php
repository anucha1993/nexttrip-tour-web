<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head><?php require('inc_header.php'); ?>
</head>

<body>
    <?php require('inc_topmenu.php'); ?>
    <section id="protourpage" class="wrapperPages">
        <div class="container-fluid g-0 overflow-hidden">
            <div class="row">
                <div class="col">
                    <div class="bannereach">
                        <img src="images/banner_asia_sub.webp" alt="">
                      
                        <div class="categoryslidegroup">
                            <div class="categoryslide_list owl-carousel owl-theme">
                                <?php for ($i = 1; $i <= 12; $i++) { ?>
                                <div class="item">
                                    <a href="javascript:(0);">
                                        <div class="catss">
                                        ทัวร์ญี่ปุ่น
                                        </div>
                                    </a>
                                </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-3 mt-lg-5">
                <div class="col-lg-4 col-xl-3">
                    <div class="row">
                        <div class="col-5 col-lg-12">
                            <?php require('inc_sidefilter.php'); ?>
                        </div>
                        <div class="col-5 ps-0">
                            <div class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
                                <select class="form-select" aria-label="Default select example">
                                    <option selected>เรียงตาม </option>
                                    <option value="1">One</option>
                                    <option value="2">Two</option>
                                    <option value="3">Three</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-2 g-0">
                            <div class="d-block d-sm-block d-md-block d-lg-none d-xl-none">
                                <div id="btnContainer">
                                    <button class="btn active" onclick="gridView()">
                                        <i class="bi bi-view-list list_img imgactive"></i>
                                        <i class="bi bi-view-list list_img  imgnonactive" style="color:#f15a22;"></i>
                                    </button>
                                    <button class="btn" onclick="listView()">
                                        <i class="bi bi-list-task grid_img imgnonactive" style="color:#f15a22;"></i>
                                        <i class="bi bi-list-task grid_img imgactive"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-xl-9">
                    <div class="row mt-3 mt-lg-0">
                        <div class="col-12 col-lg-7 col-xl-8">
                            <div class="titletopic">
                                <h1>ทัวร์ในประเทศ</h1>
                                <p>พบ 110 รายการ</p>
                            </div>
                        </div>
                        <div class="col-lg-5 col-xl-4 text-end">
                            <div class="row">
                                <div class="col-lg-8 col-xl-8">
                                    <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                                        <select class="form-select" aria-label="Default select example">
                                            <option selected>เรียงตาม </option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xl-4">
                                    <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                                        <div id="btnContainer">
                                            <button class="btn active" onclick="gridView()">
                                                <i class="bi bi-view-list list_img imgactive"></i>
                                                <i class="bi bi-view-list list_img  imgnonactive"
                                                    style="color:#f15a22;"></i>
                                            </button>
                                            <button class="btn" onclick="listView()">
                                                <i class="bi bi-list-task grid_img imgnonactive"
                                                    style="color:#f15a22;"></i>
                                                <i class="bi bi-list-task grid_img imgactive"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="table-grid">
                                <div class="row">
                                    <div class="col">
                                        <div class="boxwhiteshd">
                                            <div class="toursmainshowGroup">
                                                <div class="row">
                                                    <div class="col-lg-12 col-xl-4">
                                                        <div class="covertourimg">
                                                            <img src="images/cover_pe.webp" alt="">
                                                            <div class="tagontop">
                                                                <li class="bgor">4 วัน 3 คืน</li>
                                                                <li class="bgwhite"><i class="fi fi-rr-marker"></i>
                                                                    ทัวร์ไต้หวัน</li>
                                                            </div>
                                                            <div class="priceonpic">
                                                                <span class="originalprice">ปกติ 36,888 </span><br>
                                                                เริ่ม<span class="saleprice"> 21,888 บาท</span>
                                                            </div>
                                                            <div class="addwishlist">
                                                                <a href="#"><i class="bi bi-heart-fill"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12 col-xl-8">
                                                        <div class="codeandhotel Cropscroll mt-3">
                                                            <li>รหัสทัวร์ : <span class="bluetext">VVZ17</span> </li>
                                                            <li class="rating">โรงแรม <i class="bi bi-star-fill"></i> <i
                                                                    class="bi bi-star-fill"></i> <i
                                                                    class="bi bi-star-fill"></i> <i
                                                                    class="bi bi-star-fill"></i> <i
                                                                    class="bi bi-star-fill"></i>
                                                            </li>
                                                            <li>สายการบิน <img src="images/airasia-logo 3.svg" alt="">
                                                            </li>
                                                        </div>
                                                        <hr>
                                                        <div class="icontaglabll">
                                                            <img src="images/label/bestvalue.png" class="img-fluid"
                                                                alt="">
                                                        </div>
                                                        <div class="nameTop">
                                                            <h3> TAIWAN ไต้หวัน ซุปตาร์...KAOHSIUNG รักใสใส หัวใจอาร์ตๆ
                                                            </h3>
                                                        </div>
                                                        <div class="pricegroup">
                                                            <span class="originalprice">ปกติ 36,888 </span><br>
                                                            เริ่ม<span class="saleprice"> 21,888 บาท</span>
                                                        </div>
                                                        <hr>
                                                        <div class="hilight mt-4">
                                                            <div class="readMore">
                                                                <div class="readMoreWrapper">
                                                                    <div class="readMoreText">
                                                                        <li>
                                                                            <div class="iconle"><span><i
                                                                                        class="bi bi-camera-fill"></i></span>
                                                                            </div>
                                                                            <div class="topiccenter"><b>เที่ยว</b></div>
                                                                            <div class="details">
                                                                                วัดอาซากุสะ-ถนนนากามิเสะ-โตเกียวสกายทรี-คาวาโกเอะ-ศาลเจ้าฮิกาวะ-ถนนคุราสึคุริ-หอระฆังเวลาโทคิโนะคาเนะ-ตรอกลูกกวาด-หมู่บ้านโอชิโนะ
                                                                                ฮักไก-สวนโออิชิ-ภูเขาไฟฟูจิ ชั้น
                                                                                5-โอไดบะ-Diver
                                                                                City-อิสระท่องเที่ยว</div>
                                                                        </li>
                                                                        <li>
                                                                            <div class="iconle"><span><i
                                                                                        class="bi bi-bag-fill"></i></span>
                                                                            </div>
                                                                            <div class="topiccenter"><b>ช้อป </b></div>
                                                                            <div class="details">
                                                                                ย่านชินจูกุ</div>
                                                                        </li>
                                                                        <li>
                                                                            <div class="iconle"><span><svg
                                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                                        width="22" height="22"
                                                                                        fill="currentColor"
                                                                                        class="bi bi-cup-hot-fill"
                                                                                        viewBox="0 0 16 16">
                                                                                        <path fill-rule="evenodd"
                                                                                            d="M.5 6a.5.5 0 0 0-.488.608l1.652 7.434A2.5 2.5 0 0 0 4.104 16h5.792a2.5 2.5 0 0 0 2.44-1.958l.131-.59a3 3 0 0 0 1.3-5.854l.221-.99A.5.5 0 0 0 13.5 6H.5ZM13 12.5a2.01 2.01 0 0 1-.316-.025l.867-3.898A2.001 2.001 0 0 1 13 12.5Z" />
                                                                                        <path
                                                                                            d="m4.4.8-.003.004-.014.019a4.167 4.167 0 0 0-.204.31 2.327 2.327 0 0 0-.141.267c-.026.06-.034.092-.037.103v.004a.593.593 0 0 0 .091.248c.075.133.178.272.308.445l.01.012c.118.158.26.347.37.543.112.2.22.455.22.745 0 .188-.065.368-.119.494a3.31 3.31 0 0 1-.202.388 5.444 5.444 0 0 1-.253.382l-.018.025-.005.008-.002.002A.5.5 0 0 1 3.6 4.2l.003-.004.014-.019a4.149 4.149 0 0 0 .204-.31 2.06 2.06 0 0 0 .141-.267c.026-.06.034-.092.037-.103a.593.593 0 0 0-.09-.252A4.334 4.334 0 0 0 3.6 2.8l-.01-.012a5.099 5.099 0 0 1-.37-.543A1.53 1.53 0 0 1 3 1.5c0-.188.065-.368.119-.494.059-.138.134-.274.202-.388a5.446 5.446 0 0 1 .253-.382l.025-.035A.5.5 0 0 1 4.4.8Zm3 0-.003.004-.014.019a4.167 4.167 0 0 0-.204.31 2.327 2.327 0 0 0-.141.267c-.026.06-.034.092-.037.103v.004a.593.593 0 0 0 .091.248c.075.133.178.272.308.445l.01.012c.118.158.26.347.37.543.112.2.22.455.22.745 0 .188-.065.368-.119.494a3.31 3.31 0 0 1-.202.388 5.444 5.444 0 0 1-.253.382l-.018.025-.005.008-.002.002A.5.5 0 0 1 6.6 4.2l.003-.004.014-.019a4.149 4.149 0 0 0 .204-.31 2.06 2.06 0 0 0 .141-.267c.026-.06.034-.092.037-.103a.593.593 0 0 0-.09-.252A4.334 4.334 0 0 0 6.6 2.8l-.01-.012a5.099 5.099 0 0 1-.37-.543A1.53 1.53 0 0 1 6 1.5c0-.188.065-.368.119-.494.059-.138.134-.274.202-.388a5.446 5.446 0 0 1 .253-.382l.025-.035A.5.5 0 0 1 7.4.8Zm3 0-.003.004-.014.019a4.077 4.077 0 0 0-.204.31 2.337 2.337 0 0 0-.141.267c-.026.06-.034.092-.037.103v.004a.593.593 0 0 0 .091.248c.075.133.178.272.308.445l.01.012c.118.158.26.347.37.543.112.2.22.455.22.745 0 .188-.065.368-.119.494a3.198 3.198 0 0 1-.202.388 5.385 5.385 0 0 1-.252.382l-.019.025-.005.008-.002.002A.5.5 0 0 1 9.6 4.2l.003-.004.014-.019a4.149 4.149 0 0 0 .204-.31 2.06 2.06 0 0 0 .141-.267c.026-.06.034-.092.037-.103a.593.593 0 0 0-.09-.252A4.334 4.334 0 0 0 9.6 2.8l-.01-.012a5.099 5.099 0 0 1-.37-.543A1.53 1.53 0 0 1 9 1.5c0-.188.065-.368.119-.494.059-.138.134-.274.202-.388a5.446 5.446 0 0 1 .253-.382l.025-.035A.5.5 0 0 1 10.4.8Z" />
                                                                                    </svg></span> </div>
                                                                            <div class="topiccenter"><b>กิน </b></div>
                                                                            <div class="details">
                                                                                บุฟเฟ่ต์ขาปู </div>
                                                                        </li>
                                                                        <li>
                                                                            <div class="iconle"><span><i
                                                                                        class="bi bi-bookmark-heart-fill"></i></span>
                                                                            </div>
                                                                            <div class="topiccenter"><b>พิเศษ </b></div>
                                                                            <div class="details">
                                                                                แช่น้ำแร่ออนเซ็นธรรมชาติ</div>
                                                                        </li>
                                                                        <li>
                                                                            <div class="iconle"><span><svg
                                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                                        width="22" height="22"
                                                                                        fill="currentColor"
                                                                                        class="bi bi-buildings-fill"
                                                                                        viewBox="0 0 16 16">
                                                                                        <path
                                                                                            d="M15 .5a.5.5 0 0 0-.724-.447l-8 4A.5.5 0 0 0 6 4.5v3.14L.342 9.526A.5.5 0 0 0 0 10v5.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V14h1v1.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5V.5ZM2 11h1v1H2v-1Zm2 0h1v1H4v-1Zm-1 2v1H2v-1h1Zm1 0h1v1H4v-1Zm9-10v1h-1V3h1ZM8 5h1v1H8V5Zm1 2v1H8V7h1ZM8 9h1v1H8V9Zm2 0h1v1h-1V9Zm-1 2v1H8v-1h1Zm1 0h1v1h-1v-1Zm3-2v1h-1V9h1Zm-1 2h1v1h-1v-1Zm-2-4h1v1h-1V7Zm3 0v1h-1V7h1Zm-2-2v1h-1V5h1Zm1 0h1v1h-1V5Z" />
                                                                                    </svg></span> </div>
                                                                            <div class="topiccenter"><b>พัก </b></div>
                                                                            <div class="details">
                                                                                พักออนเซ็น</div>
                                                                        </li>
                                                                    </div>
                                                                    <div class="readMoreGradient"></div>
                                                                </div>
                                                                <a class="readMoreBtn"></a>
                                                                <span class="readLessBtnText"
                                                                    style="display: none;">Read Less</span>
                                                                <span class="readMoreBtnText"
                                                                    style="display: none;">Read More</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="periodtime">
                                                    <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                                                        <h5>กำหนดการเดินทาง</h5>
                                                    </div>

                                                    <div class="readMore mt-3">
                                                        <div class="readMoreWrapper">
                                                            <div class="readMoreText">
                                                                <div class="listperiod_moredetails">
                                                                    <div class="splgroup">
                                                                        <span class="month">พ.ค.</span>
                                                                        <li>
                                                                            <span class="staydate"><img
                                                                                    src="images/bag.svg" alt=""> ••
                                                                            </span> <br>
                                                                            12-15</li>
                                                                        <li>
                                                                            <span class="saleperiod">9,888฿ </span> <br>
                                                                            13-16</li>
                                                                        <li>
                                                                            <span class="saleperiod">9,888฿ </span> <br>
                                                                            18-21 </li>
                                                                        <li>
                                                                            <span class="staydate"><img
                                                                                    src="images/bag.svg" alt=""> •••
                                                                            </span> <br>
                                                                            25-28</li>
                                                                        <li>
                                                                            <span class="staydate"><img
                                                                                    src="images/bag.svg" alt=""> ••
                                                                            </span> <br>
                                                                            26-29</li>
                                                                    </div>
                                                                    <div class="splgroup">
                                                                        <span class="month">มิ.ย.</span>
                                                                        <li>
                                                                            <span class="fullbook"><img
                                                                                    src="images/alfull.svg" alt="">
                                                                            </span>
                                                                            <span class="fulltext"> ใกล้เต็ม</span>
                                                                            <br>
                                                                            12-15</li>
                                                                        <li>
                                                                            <span class="saleperiod">9,888฿ </span> <br>
                                                                            13-16</li>
                                                                        <li>
                                                                            <span class="saleperiod">9,888฿ </span> <br>
                                                                            18-21 </li>
                                                                        <li>
                                                                            <span class="staydate"><img
                                                                                    src="images/bag.svg" alt=""> •••
                                                                            </span> <br>
                                                                            25-28</li>
                                                                        <li>
                                                                            <span class="staydate"><img
                                                                                    src="images/bag.svg" alt=""> ••
                                                                            </span> <br>
                                                                            26-29</li>
                                                                    </div>
                                                                    <div class="splgroup">
                                                                        <span class="month">ก.ค.</span>
                                                                        <li>
                                                                            <span class="staydate"><img
                                                                                    src="images/bag.svg" alt=""> ••
                                                                            </span> <br>
                                                                            12-15</li>
                                                                        <li>
                                                                            <span class="saleperiod">9,888฿ </span> <br>
                                                                            13-16</li>
                                                                        <li>
                                                                            <span class="saleperiod">9,888฿ </span> <br>
                                                                            18-21 </li>
                                                                        <li>
                                                                            <span class="staydate"><img
                                                                                    src="images/bag.svg" alt=""> •••
                                                                            </span> <br>
                                                                            25-28</li>
                                                                        <li>
                                                                            <span class="staydate"><img
                                                                                    src="images/bag.svg" alt=""> ••
                                                                            </span> <br>
                                                                            26-29</li>
                                                                    </div>
                                                                    <div class="splgroup">
                                                                        <span class="month">ส.ค.</span>
                                                                        <li>
                                                                            <span class="staydate"><img
                                                                                    src="images/bag.svg" alt=""> ••
                                                                            </span> <br>
                                                                            12-15</li>
                                                                        <li>
                                                                            <span class="saleperiod">9,888฿ </span> <br>
                                                                            13-16</li>
                                                                        <li>
                                                                            <span class="saleperiod">9,888฿ </span> <br>
                                                                            18-21 </li>
                                                                        <li>
                                                                            <span class="staydate"><img
                                                                                    src="images/bag.svg" alt=""> •••
                                                                            </span> <br>
                                                                            25-28</li>
                                                                        <li>
                                                                            <span class="staydate"><img
                                                                                    src="images/bag.svg" alt=""> ••
                                                                            </span> <br>
                                                                            26-29</li>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="readMoreGradient"></div>
                                                        </div>
                                                        <a class="readMoreBtn"></a>
                                                        <span class="readLessBtnText" style="display: none;">Read
                                                            Less</span>
                                                        <span class="readMoreBtnText" style="display: none;">Read
                                                            More</span>
                                                    </div>
                                                </div>
                                                <div class="remainsFull">
                                                    <li><span class="noshowpad"><img src="images/bag.svg" alt=""></span>
                                                        <span class="showpad">•</span> จำนวนวันหยุด</li>
                                                    <li><img src="images/alfull.svg" alt=""> ใกล้เต็ม</li>
                                                </div>
                                                <div class="fullperiod">
                                                    <h6 class="pb-2">ทัวร์ที่เต็มแล้ว (2)</h6>
                                                    <span class="monthsold">พ.ค.</span>
                                                    <li>12-15</li>
                                                    <li> 13-16</li>
                                                    <li> 18-21 </li>
                                                    <li>25-28</li>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="boxwhiteshd">
                                            <div class="toursmainshowGroup">
                                                <div class="row">
                                                    <div class="col-12 col-xl-4">
                                                        <div class="covertourimg">
                                                            <img src="images/cover_pe.webp" alt="">
                                                            <div class="soldfilter">
                                                                <div class="soldop">
                                                                    <span class="bigSold">SOLD OUT </span> <br>
                                                                    <span class="textsold"> ว้า! หมดแล้ว
                                                                        คุณตัดสินใจช้าไป</span> <br>
                                                                    <a href="#" class="btn btn-second mt-3"><i
                                                                            class="fi fi-rr-search"></i>
                                                                        หาโปรแกรมทัวร์ใกล้เคียง</a>
                                                                </div>

                                                            </div>
                                                            <div class="tagontop">
                                                                <li class="bgor">4 วัน 3 คืน</li>
                                                                <li class="bgwhite"><i class="fi fi-rr-marker"></i>
                                                                    ทัวร์ไต้หวัน</li>
                                                            </div>
                                                            <div class="priceonpic">
                                                                <span class="originalprice">ปกติ 36,888 </span><br>
                                                                เริ่ม<span class="saleprice"> 21,888 บาท</span>
                                                            </div>
                                                            <div class="addwishlist">
                                                                <a href="#" class="active"><i
                                                                        class="bi bi-heart-fill"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-xl-8">
                                                        <div class="codeandhotel Cropscroll mt-3">
                                                            <li>รหัสทัวร์ : <span class="bluetext">VVZ17</span> </li>
                                                            <li class="rating">โรงแรม <i class="bi bi-star-fill"></i> <i
                                                                    class="bi bi-star-fill"></i> <i
                                                                    class="bi bi-star-fill"></i> <i
                                                                    class="bi bi-star-fill"></i> <i
                                                                    class="bi bi-star-fill"></i>
                                                            </li>
                                                            <li>สายการบิน <img src="images/airasia-logo 3.svg" alt="">
                                                            </li>
                                                        </div>
                                                        <hr>
                                                        <div class="icontaglabll">
                                                            <img src="images/label/bestprice.png" class="img-fluid"
                                                                alt="">
                                                        </div>
                                                        <div class="nameTop">
                                                            <h3> TAIWAN ไต้หวัน ซุปตาร์...KAOHSIUNG รักใสใส หัวใจอาร์ตๆ
                                                            </h3>
                                                        </div>
                                                        <div class="pricegroup">
                                                            <span class="originalprice">ปกติ 36,888 </span><br>
                                                            เริ่ม<span class="saleprice"> 21,888 บาท</span>
                                                        </div>
                                                        <hr>
                                                        <div class="hilight mt-4">
                                                            <div class="readMore">
                                                                <div class="readMoreWrapper">
                                                                    <div class="readMoreText">
                                                                        <li>
                                                                            <div class="iconle"><span><i
                                                                                        class="bi bi-camera-fill"></i></span>
                                                                            </div>
                                                                            <div class="topiccenter"><b>เที่ยว</b></div>
                                                                            <div class="details">
                                                                                วัดอาซากุสะ-ถนนนากามิเสะ-โตเกียวสกายทรี-คาวาโกเอะ-ศาลเจ้าฮิกาวะ-ถนนคุราสึคุริ-หอระฆังเวลาโทคิโนะคาเนะ-ตรอกลูกกวาด-หมู่บ้านโอชิโนะ
                                                                                ฮักไก-สวนโออิชิ-ภูเขาไฟฟูจิ ชั้น
                                                                                5-โอไดบะ-Diver
                                                                                City-อิสระท่องเที่ยว</div>
                                                                        </li>
                                                                        <li>
                                                                            <div class="iconle"><span><i
                                                                                        class="bi bi-bag-fill"></i></span>
                                                                            </div>
                                                                            <div class="topiccenter"><b>ช้อป </b></div>
                                                                            <div class="details">
                                                                                ย่านชินจูกุ</div>
                                                                        </li>
                                                                        <li>
                                                                            <div class="iconle"><span><svg
                                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                                        width="22" height="22"
                                                                                        fill="currentColor"
                                                                                        class="bi bi-cup-hot-fill"
                                                                                        viewBox="0 0 16 16">
                                                                                        <path fill-rule="evenodd"
                                                                                            d="M.5 6a.5.5 0 0 0-.488.608l1.652 7.434A2.5 2.5 0 0 0 4.104 16h5.792a2.5 2.5 0 0 0 2.44-1.958l.131-.59a3 3 0 0 0 1.3-5.854l.221-.99A.5.5 0 0 0 13.5 6H.5ZM13 12.5a2.01 2.01 0 0 1-.316-.025l.867-3.898A2.001 2.001 0 0 1 13 12.5Z" />
                                                                                        <path
                                                                                            d="m4.4.8-.003.004-.014.019a4.167 4.167 0 0 0-.204.31 2.327 2.327 0 0 0-.141.267c-.026.06-.034.092-.037.103v.004a.593.593 0 0 0 .091.248c.075.133.178.272.308.445l.01.012c.118.158.26.347.37.543.112.2.22.455.22.745 0 .188-.065.368-.119.494a3.31 3.31 0 0 1-.202.388 5.444 5.444 0 0 1-.253.382l-.018.025-.005.008-.002.002A.5.5 0 0 1 3.6 4.2l.003-.004.014-.019a4.149 4.149 0 0 0 .204-.31 2.06 2.06 0 0 0 .141-.267c.026-.06.034-.092.037-.103a.593.593 0 0 0-.09-.252A4.334 4.334 0 0 0 3.6 2.8l-.01-.012a5.099 5.099 0 0 1-.37-.543A1.53 1.53 0 0 1 3 1.5c0-.188.065-.368.119-.494.059-.138.134-.274.202-.388a5.446 5.446 0 0 1 .253-.382l.025-.035A.5.5 0 0 1 4.4.8Zm3 0-.003.004-.014.019a4.167 4.167 0 0 0-.204.31 2.327 2.327 0 0 0-.141.267c-.026.06-.034.092-.037.103v.004a.593.593 0 0 0 .091.248c.075.133.178.272.308.445l.01.012c.118.158.26.347.37.543.112.2.22.455.22.745 0 .188-.065.368-.119.494a3.31 3.31 0 0 1-.202.388 5.444 5.444 0 0 1-.253.382l-.018.025-.005.008-.002.002A.5.5 0 0 1 6.6 4.2l.003-.004.014-.019a4.149 4.149 0 0 0 .204-.31 2.06 2.06 0 0 0 .141-.267c.026-.06.034-.092.037-.103a.593.593 0 0 0-.09-.252A4.334 4.334 0 0 0 6.6 2.8l-.01-.012a5.099 5.099 0 0 1-.37-.543A1.53 1.53 0 0 1 6 1.5c0-.188.065-.368.119-.494.059-.138.134-.274.202-.388a5.446 5.446 0 0 1 .253-.382l.025-.035A.5.5 0 0 1 7.4.8Zm3 0-.003.004-.014.019a4.077 4.077 0 0 0-.204.31 2.337 2.337 0 0 0-.141.267c-.026.06-.034.092-.037.103v.004a.593.593 0 0 0 .091.248c.075.133.178.272.308.445l.01.012c.118.158.26.347.37.543.112.2.22.455.22.745 0 .188-.065.368-.119.494a3.198 3.198 0 0 1-.202.388 5.385 5.385 0 0 1-.252.382l-.019.025-.005.008-.002.002A.5.5 0 0 1 9.6 4.2l.003-.004.014-.019a4.149 4.149 0 0 0 .204-.31 2.06 2.06 0 0 0 .141-.267c.026-.06.034-.092.037-.103a.593.593 0 0 0-.09-.252A4.334 4.334 0 0 0 9.6 2.8l-.01-.012a5.099 5.099 0 0 1-.37-.543A1.53 1.53 0 0 1 9 1.5c0-.188.065-.368.119-.494.059-.138.134-.274.202-.388a5.446 5.446 0 0 1 .253-.382l.025-.035A.5.5 0 0 1 10.4.8Z" />
                                                                                    </svg></span> </div>
                                                                            <div class="topiccenter"><b>กิน </b></div>
                                                                            <div class="details">
                                                                                บุฟเฟ่ต์ขาปู </div>
                                                                        </li>
                                                                        <li>
                                                                            <div class="iconle"><span><i
                                                                                        class="bi bi-bookmark-heart-fill"></i></span>
                                                                            </div>
                                                                            <div class="topiccenter"><b>พิเศษ </b></div>
                                                                            <div class="details">
                                                                                แช่น้ำแร่ออนเซ็นธรรมชาติ</div>
                                                                        </li>
                                                                        <li>
                                                                            <div class="iconle"><span><svg
                                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                                        width="22" height="22"
                                                                                        fill="currentColor"
                                                                                        class="bi bi-buildings-fill"
                                                                                        viewBox="0 0 16 16">
                                                                                        <path
                                                                                            d="M15 .5a.5.5 0 0 0-.724-.447l-8 4A.5.5 0 0 0 6 4.5v3.14L.342 9.526A.5.5 0 0 0 0 10v5.5a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5V14h1v1.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5V.5ZM2 11h1v1H2v-1Zm2 0h1v1H4v-1Zm-1 2v1H2v-1h1Zm1 0h1v1H4v-1Zm9-10v1h-1V3h1ZM8 5h1v1H8V5Zm1 2v1H8V7h1ZM8 9h1v1H8V9Zm2 0h1v1h-1V9Zm-1 2v1H8v-1h1Zm1 0h1v1h-1v-1Zm3-2v1h-1V9h1Zm-1 2h1v1h-1v-1Zm-2-4h1v1h-1V7Zm3 0v1h-1V7h1Zm-2-2v1h-1V5h1Zm1 0h1v1h-1V5Z" />
                                                                                    </svg></span> </div>
                                                                            <div class="topiccenter"><b>พัก </b></div>
                                                                            <div class="details">
                                                                                พักออนเซ็น</div>
                                                                        </li>
                                                                    </div>
                                                                    <div class="readMoreGradient"></div>
                                                                </div>
                                                                <a class="readMoreBtn"></a>
                                                                <span class="readLessBtnText"
                                                                    style="display: none;">Read Less</span>
                                                                <span class="readMoreBtnText"
                                                                    style="display: none;">Read More</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="periodtime">
                                                    <div class="d-none d-sm-none d-md-none d-lg-block d-xl-block">
                                                        <h5>กำหนดการเดินทาง</h5>
                                                    </div>

                                                    <div class="readMore mt-3">
                                                        <div class="readMoreWrapper">
                                                            <div class="readMoreText">
                                                                <div class="listperiod_moredetails">
                                                                    <div class="splgroup">
                                                                        <span class="month">พ.ค.</span>
                                                                        <li>
                                                                            <span class="staydate"><img
                                                                                    src="images/bag.svg" alt=""> ••
                                                                            </span> <br>
                                                                            12-15</li>
                                                                        <li>
                                                                            <span class="saleperiod">9,888฿ </span> <br>
                                                                            13-16</li>
                                                                        <li>
                                                                            <span class="saleperiod">9,888฿ </span> <br>
                                                                            18-21 </li>
                                                                        <li>
                                                                            <span class="staydate"><img
                                                                                    src="images/bag.svg" alt=""> •••
                                                                            </span> <br>
                                                                            25-28</li>
                                                                        <li>
                                                                            <span class="staydate"><img
                                                                                    src="images/bag.svg" alt=""> ••
                                                                            </span> <br>
                                                                            26-29</li>
                                                                    </div>
                                                                    <div class="splgroup">
                                                                        <span class="month">มิ.ย.</span>
                                                                        <li>
                                                                            <span class="fullbook"><img
                                                                                    src="images/alfull.svg" alt="">
                                                                            </span>
                                                                            <span class="fulltext"> ใกล้เต็ม</span>
                                                                            <br>
                                                                            12-15</li>
                                                                        <li>
                                                                            <span class="saleperiod">9,888฿ </span> <br>
                                                                            13-16</li>
                                                                        <li>
                                                                            <span class="saleperiod">9,888฿ </span> <br>
                                                                            18-21 </li>
                                                                        <li>
                                                                            <span class="staydate"><img
                                                                                    src="images/bag.svg" alt=""> •••
                                                                            </span> <br>
                                                                            25-28</li>
                                                                        <li>
                                                                            <span class="staydate"><img
                                                                                    src="images/bag.svg" alt=""> ••
                                                                            </span> <br>
                                                                            26-29</li>
                                                                    </div>
                                                                    <div class="splgroup">
                                                                        <span class="month">ก.ค.</span>
                                                                        <li>
                                                                            <span class="staydate"><img
                                                                                    src="images/bag.svg" alt=""> ••
                                                                            </span> <br>
                                                                            12-15</li>
                                                                        <li>
                                                                            <span class="saleperiod">9,888฿ </span> <br>
                                                                            13-16</li>
                                                                        <li>
                                                                            <span class="saleperiod">9,888฿ </span> <br>
                                                                            18-21 </li>
                                                                        <li>
                                                                            <span class="staydate"><img
                                                                                    src="images/bag.svg" alt=""> •••
                                                                            </span> <br>
                                                                            25-28</li>
                                                                        <li>
                                                                            <span class="staydate"><img
                                                                                    src="images/bag.svg" alt=""> ••
                                                                            </span> <br>
                                                                            26-29</li>
                                                                    </div>
                                                                    <div class="splgroup">
                                                                        <span class="month">ส.ค.</span>
                                                                        <li>
                                                                            <span class="staydate"><img
                                                                                    src="images/bag.svg" alt=""> ••
                                                                            </span> <br>
                                                                            12-15</li>
                                                                        <li>
                                                                            <span class="saleperiod">9,888฿ </span> <br>
                                                                            13-16</li>
                                                                        <li>
                                                                            <span class="saleperiod">9,888฿ </span> <br>
                                                                            18-21 </li>
                                                                        <li>
                                                                            <span class="staydate"><img
                                                                                    src="images/bag.svg" alt=""> •••
                                                                            </span> <br>
                                                                            25-28</li>
                                                                        <li>
                                                                            <span class="staydate"><img
                                                                                    src="images/bag.svg" alt=""> ••
                                                                            </span> <br>
                                                                            26-29</li>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="readMoreGradient"></div>
                                                        </div>
                                                        <a class="readMoreBtn"></a>
                                                        <span class="readLessBtnText" style="display: none;">Read
                                                            Less</span>
                                                        <span class="readMoreBtnText" style="display: none;">Read
                                                            More</span>
                                                    </div>
                                                </div>
                                                <div class="remainsFull">
                                                    <li><span class="noshowpad"><img src="images/bag.svg" alt=""></span>
                                                        <span class="showpad">•</span> จำนวนวันหยุด</li>
                                                    <li><img src="images/alfull.svg" alt=""> ใกล้เต็ม</li>
                                                </div>
                                                <div class="fullperiod">
                                                    <h6 class="pb-2">ทัวร์ที่เต็มแล้ว (2)</h6>
                                                    <span class="monthsold">พ.ค.</span>
                                                    <li>12-15</li>
                                                    <li> 13-16</li>
                                                    <li> 18-21 </li>
                                                    <li>25-28</li>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                            </div>
                            <div class="table-list">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <?php require('inc_footer.php'); ?>
    <script>
        $(document).ready(function () {
            $('.categoryslide_list').owlCarousel({
                loop: false,
                item: 1,
                margin: 20,
                slideBy: 1,
                autoplay: false,
                smartSpeed: 2000,
                nav: true,
                navText: ['<img src="images/arrowRight.svg">', '<img src="images/arrowLeft.svg">'],
                navClass: ['owl-prev', 'owl-next'],
                dots: false,
                responsive: {
                    0: {
                        items: 2,
                        margin: 0,
                        nav: false,


                    },
                    600: {
                        items: 3,
                        margin: 0,
                        nav: false,

                    },
                    1024: {
                        items: 4,
                        slideBy: 1
                    },
                    1200: {
                        items: 7,
                        slideBy: 1
                    }
                }
            })



        });
    </script>
    <script>
        // Get the elements with class="column"
        var elements = document.getElementsByClassName("column");

        // Declare a loop variable
        var i;

        $('.table-list').hide();
        // List View
        function listView() {
            $('.table-grid').hide();
            $('.table-list').show();
            $('.list_img.imgactive').show();
            $('.list_img.imgnonactive').hide();
            $('.grid_img.imgactive').hide();
            $('.grid_img.imgnonactive').show();
        }

        // Grid View
        function gridView() {
            $('.table-grid').show();
            $('.table-list').hide();
            $('.grid_img.imgactive').show();
            $('.grid_img.imgnonactive').hide();
            $('.list_img.imgactive').hide();
            $('.list_img.imgnonactive').show();
        }

        /* Optional: Add active class to the current button (highlight it) */
        var container = document.getElementById("btnContainer");
        var btns = container.getElementsByClassName("btn");
        for (var i = 0; i < btns.length; i++) {
            btns[i].addEventListener("click", function () {
                var current = document.getElementsByClassName("active");
                current[0].className = current[0].className.replace(" active", "");
                this.className += " active";
            });
        }
    </script>
    <script>
        var $readMore = "อ่านต่อ";
        var $readLess = "ย่อข้อความ";
        $(".readMoreBtn").text($readMore);
        $('.readMoreBtn').click(function () {
            var $this = $(this);
            console.log($readMore);
            $this.text($readMore);
            if ($this.data('expanded') == "yes") {
                $this.data('expanded', "no");
                $this.text($readMore);
                $this.parent().find('.readMoreText').animate({
                    height: '160px'
                });
            } else {
                $this.data('expanded', "yes");
                $this.parent().find('.readMoreText').css({
                    height: 'auto'
                });
                $this.text($readLess);

            }
        });
    </script>
</body>

</html>