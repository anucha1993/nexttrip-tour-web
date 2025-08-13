<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    @include("frontend.layout.inc_header")
</head>

<body>
    @include("frontend.layout.inc_topmenu")
    <section id="tourdetailspage" class="wrapperPages">
        <div class="container">
            <div class="row mt-5">
                <div class="col">
                    <div class="pageontop_sl">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">หน้าหลัก </a></li>
                                {{-- <li class="breadcrumb-item"><a href="{{ url('/tour/'.@$data->slug) }}">{{ @$data->name }} {{ @$data->num_day }}</a></li> --}}
                                <li class="breadcrumb-item active" aria-current="page">การจอง</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            @php
                $month = ['','ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
                $airline = App\Models\Backend\TravelTypeModel::find(@$data->airline_id);
            @endphp
            <div class="row mt-5">
                <div class="col">
                    <div class="boxwhiteshd">
                        <div class="row">
                            <div class="col-lg-4 hoverstyle">
                                <figure>
                                    <a href="{{ url('/tour/'.@$data->slug) }}"><img src="{{asset(@$data->image)}}" alt=""></a>
                                </figure>
                            </div>
                            <div class="col-lg-8">
                                <span class="orgtext">แพ็กเกจทัวร์ที่คุณเลือก</span> <br>
                                @if(@$airline->image)
                                <div class="logoborder mt-2 mb-2">
                                    <img src="{{asset(@$airline->image)}}" class="img-fluid" alt="">
                                </div>
                                @endif
                                <h1>{{ @$data->name }} <br>
                                    {{ @$data->num_day }} </h1>
                                <p>รหัสทัวร์ : <span class="bluetext">@if(@$data->code1_check) {{@$data->code1}} @else {{@$data->code}} @endif</span> </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <form method="post" action="{{ url("/booking")}}" onsubmit="return check_add();">
            @csrf
            <div class="row mt-5">
                <div class="col-lg-6">
                    <div class="titletopic mt-2">
                        <h2>เลือกวันที่</h2>
                    </div>
                    <select class="form-select" name="period_id" id="period_id" aria-label="Default select example" required>
                            <option value="">กรุณาเลือก</option>
                            @foreach (@$periods as $p)
                            <option value="{{$p->id}}" @if(@$period_id == $p->id) selected @endif>{{date('d',strtotime($p->start_date))}} {{$month[date('n',strtotime($p->start_date))]}} {{  date('y', strtotime('+543 Years', strtotime($p->start_date))) }} - {{date('d',strtotime($p->end_date))}} {{$month[date('n',strtotime($p->end_date))]}} {{  date('y', strtotime('+543 Years', strtotime($p->end_date))) }} </option>
                            @endforeach
                    </select>
                </div>
            </div>
            <div class="loadprice">
                <div class="row mt-5" id="check-error">
                    <div class="col-lg-12">
                        <div class="titletopic mt-2">
                            <h2>เลือกจำนวนคน</h2>
                        </div>
                        <div class="hilight mt-4">
                            <li>
                                <div class="iconle"><span><i class="bi bi-info-lg"></i></span> </div>
                                <div class="details">
                                    ในแต่ละห้อง ผู้ใหญ่และเด็กนอนรวมกันได้ไม่เกิน 3 คน <br>
                                    (หากคุณมีทารกมาด้วย สามารถนอนรวมในห้องเดียวกันนี้ได้)</div>
                            </li>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="titletopic mt-2">
                        <h2 class="text-left mb-2">จำนวนคงเหลือ <span id="count_text">12</span> คน</h2>
                    </div>
                    <div class="col">
                        <div class="sumroomppl_table">
                            <table class="table">
                                <thead>
                                    <th>ประเภทห้องพัก</th>
                                    <th>จำนวน</th>
                                    <th>ราคาต่อคน</th>
                                    <th>รวมราคา</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>ผู้ใหญ่ (พัก2-3ท่าน)</td>
                                        <td style="width: 200px;">
                                            <div class="qtyCart">
                                                <div class="qty_group_cart mb-2">
                                                    <div class="input-group"> <span class="input-group-btn">
                                                            <button id="qty-minus" type="button"
                                                                class="btn btn-default btn-number" disabled="disabled"
                                                                data-type="minus" data-field="qty1">
                                                                <i class="bi bi-dash"></i>
                                                            </button>
                                                        </span>
                                                        <input id="CC-prodDetails-quantity1" onkeypress="return check_number(this)" onchange="cal_price(1)" type="text" name="qty1"
                                                            class="form-control input-number adult" value="0" min="0" max="100" readonly>
                                                        <span class="input-group-btn">
                                                            <button id="qty-plus" type="button"
                                                                class="btn btn-default btn-number" data-type="plus"
                                                                data-field="qty1">
                                                                <i class="bi bi-plus"></i>
                                                            </button>
                                                        </span> </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span id="price1_text">0</span></td>
                                        <td><span id="sum_price_text1">0</span></td>
                                        <input type="hidden" id="price1" name="price1" value="0">
                                    </tr>
                                    <tr>
                                        <td>ผู้ใหญ่ (พักเดี่ยว)</td>
                                        <td>
                                            <div class="qtyCart">
                                                <div class="qty_group_cart mb-2">
                                                    <div class="input-group"> <span class="input-group-btn">
                                                            <button id="qty-minus" type="button"
                                                                class="btn btn-default btn-number" disabled="disabled"
                                                                data-type="minus" data-field="qty2">
                                                                <i class="bi bi-dash"></i>
                                                            </button>
                                                        </span>
                                                        <input id="CC-prodDetails-quantity2" onkeypress="return check_number(this)" onchange="cal_price(2)" type="text" name="qty2"
                                                            class="form-control input-number adult" value="0" min="0" max="100" readonly>
                                                        <span class="input-group-btn">
                                                            <button id="qty-plus" type="button"
                                                                class="btn btn-default btn-number" data-type="plus"
                                                                data-field="qty2">
                                                                <i class="bi bi-plus"></i>
                                                            </button>
                                                        </span> </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span id="price2_text">0</span></td>
                                        <td><span id="sum_price_text2">0</span></td>
                                        <input type="hidden" id="price2" name="price2" value="0">
                                    </tr>
                                    <tr>
                                        <td>เด็ก (มีเตียง)</td>
                                        <td>
                                            <div class="qtyCart">
                                                <div class="qty_group_cart mb-2">
                                                    <div class="input-group"> <span class="input-group-btn">
                                                            <button id="qty-minus" type="button"
                                                                class="btn btn-default btn-number" disabled="disabled"
                                                                data-type="minus" data-field="qty3">
                                                                <i class="bi bi-dash"></i>
                                                            </button>
                                                        </span>
                                                        <input id="CC-prodDetails-quantity3" onkeypress="return check_number(this)" onchange="cal_price(3)" type="text" name="qty3"
                                                            class="form-control input-number child" value="0" min="0" max="100" readonly>
                                                        <span class="input-group-btn">
                                                            <button id="qty-plus" type="button"
                                                                class="btn btn-default btn-number" data-type="plus"
                                                                data-field="qty3">
                                                                <i class="bi bi-plus"></i>
                                                            </button>
                                                        </span> </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span id="price3_text">0</span></td>
                                        <td><span id="sum_price_text3">0</span></td>
                                        <input type="hidden" id="price3" name="price3" value="0">
                                    </tr>
                                    <tr>
                                        <td>เด็ก (ไม่มีเตียง)</td>
                                        <td>
                                            <div class="qtyCart">
                                                <div class="qty_group_cart mb-2">
                                                    <div class="input-group"> <span class="input-group-btn">
                                                            <button id="qty-minus" type="button"
                                                                class="btn btn-default btn-number" disabled="disabled"
                                                                data-type="minus" data-field="qty4">
                                                                <i class="bi bi-dash"></i>
                                                            </button>
                                                        </span>
                                                        <input id="CC-prodDetails-quantity4" onkeypress="return check_number(this)" onchange="cal_price(4)" type="text" name="qty4"
                                                            class="form-control input-number child" value="0" min="0" max="100" readonly>
                                                        <span class="input-group-btn">
                                                            <button id="qty-plus" type="button"
                                                                class="btn btn-default btn-number" data-type="plus"
                                                                data-field="qty4">
                                                                <i class="bi bi-plus"></i>
                                                            </button>
                                                        </span> </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span id="price4_text">0</span></td>
                                        <td><span id="sum_price_text4">0</span></td>
                                        <input type="hidden" id="price4" name="price4" value="0">
                                    </tr>
                                </tbody>
                                <input type="hidden" id="count" value="">
                                <tfoot>
                                    <tr>
                                        <th colspan="3"><span id="sum_adult_text">0</span> ผู้ใหญ่, <span id="sum_child_text">0</span> เด็ก</th>
                                        <th><span id="net_price_text">0</span> บาท</th>
                                    </tr>
                                </tfoot>
                                <input type="hidden" name="tour_id" value="{{$data->id}}">
                                <input type="hidden" class="cal_price" id="sum_price1" name="sum_price1" value="0">
                                <input type="hidden" class="cal_price" id="sum_price2" name="sum_price2" value="0">
                                <input type="hidden" class="cal_price" id="sum_price3" name="sum_price3" value="0">
                                <input type="hidden" class="cal_price" id="sum_price4" name="sum_price4" value="0">
                                <input type="hidden" class="" id="total_qty" name="total_qty" value="0">
                                <input type="hidden" id="net_total" name="net_total" value="0" >
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-5 mb-3">
                <div class="col-lg-6">
                    <div class="titletopic mt-2">
                        <h2>ข้อมูลผู้เดินทาง</h2>
                    </div>
                    @php
                            $check_login = App\Models\Backend\MemberModel::find(Auth::guard('Member')->id());
                    @endphp
                    <div class="formcontact">
                        <div class="row">
                        <div class="col-lg-6">
                                <label>ชื่อผู้ติดต่อ*</label>
                                <input type="text" class="form-control" name="name" @if($check_login) value="{{$check_login->name}}" @endif placeholder="กรอกชื่อผู้ติดต่อ" required>
                            </div>
                            <div class="col-lg-6">
                                <label>นามสกุล*</label>
                                <input type="text" class="form-control" name="surname" @if($check_login && $check_login->surname) value="{{$check_login->surname}}" @endif placeholder="กรอกนามสกุล" required>
                            </div>
                            <div class="col-lg-6">
                                <label>อีเมล*</label>
                                <input type="email" class="form-control" name="email" @if($check_login) value="{{$check_login->email}}" @endif placeholder="กรอกอีเมลของท่าน" required>
                            </div>
                            <div class="col-lg-6">
                                <label>เบอร์โทรศัพท์*</label>
                                <input type="text" class="form-control" name="phone" @if($check_login)  value="{{$check_login->phone}}" @endif placeholder="กรอกเบอร์โทรศัพท์" required>
                            </div>
                            <div class="col-lg-12">
                                <label>เลือก Sale</label>
                                <select class="form-select" id="sale_id" name="sale_id" aria-label="Default select example" required>
                                    <option value="" hidden>กรุณาเลือก </option>
                                    @if(@$sales)
                                        @foreach ($sales as $sale)
                                        <option value="{{$sale->id}}">{{$sale->name}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-lg-12 mb-4">
                                <label>ความต้องการพิเศษ</label>
                                <textarea name="detail" id="" cols="30" rows="10" class="form-control" placeholder="กรอกรายละเอียด"></textarea>
                            </div>
                            <!-- <div class="g-recaptcha" style="text-align: -webkit-center;" data-sitekey="6Le6CQopAAAAAEtOLHOjrKN5YrBtXRfMVc1vZ_r4"></div> -->
                            <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response" value="">
                        </div>
                        <button type="submit" class="btn-submit mt-4" style="border:none;">ส่งใบจอง</button>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="titletopic mt-2">
                        <h2>เงื่อนไขการจองทัวร์</h2>
                    </div>
                    @php
                        $condition = App\Models\Backend\BookingDetailModel::find(1);
                    @endphp
                    <div class="condition">
                        {!! $condition->detail !!}
                    </div>
                </div>
            </div>
            </form>
        </div>
    </section>
    @include("frontend.layout.inc_footer")

    <script>
        function check_add() {
                var total = $('#net_total').val();
                if (total <= 0) {
                    toastr.error('กรุณาเลือกจำนวนผู้เข้าพักก่อนบันทึกรายการ');
                    $('html, body').animate({
                        scrollTop: $('#check-error').offset().top
                    }, 800);
                    return false;
                }
        }
        grecaptcha.ready(function() {
            grecaptcha.execute('6LdQYyIqAAAAAB3FGzKTWhkYEHyPkR0oPovosbNs', {action: 'submit'}).then(function(token) {
                    document.getElementById('g-recaptcha-response').value = token;
            });
        });
        // window.onload = function() {
        //     loadPrice({{$period_id}});
        //     updateTotal();
        // };

        function check_number(ele) {
            var vchar = String.fromCharCode(event.keyCode);
            if ((vchar<'0' || vchar>'9') && (vchar != '.')) return false;
            ele.onKeyPress=vchar;
        }

        function updateTotal() {
            var count = $('#count').val(); // จำนวนที่ดึงมาจาก period
            var total = 0;
            $('.input-number').each(function () {
                total += parseInt($(this).val()) || 0;
            });
            $('#total_qty').val(total);

            // if(total >= count){ // เช็คการเลือกไม่ให้เลือกเกินจำนวนที่มี
            //     $(".btn-number[data-type='plus']").attr('disabled', true);
            // }else{
            //     $(".btn-number[data-type='plus']").attr('disabled', false);
            // }
        }

        $('.btn-number').click(function (e) {
            e.preventDefault();
            fieldName = $(this).attr('data-field');
            type = $(this).attr('data-type');
            var input = $("input[name='" + fieldName + "']");
            var currentVal = parseInt(input.val());
            if (!isNaN(currentVal)) {
                if (type == 'minus') {
                    if (currentVal > input.attr('min')) {
                        input.val(currentVal - 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('min')) {
                        $(this).attr('disabled', true);
                    }
                } else if (type == 'plus') {
                    if (currentVal < input.attr('max')) {
                        input.val(currentVal + 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('max')) {
                        $(this).attr('disabled', true);
                    }
                }
            } else {
                input.val(0);
            }

            updateTotal();
        });
        $('.input-number').change(function () {
            minValue = parseInt($(this).attr('min'));
            maxValue = parseInt($(this).attr('max'));
            valueCurrent = parseInt($(this).val());
            name = $(this).attr('name');
            if (valueCurrent >= minValue) {
                $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                alert('Sorry, the minimum value was reached');
                // $(this).val($(this).data('oldValue'));
            }
            if (valueCurrent <= maxValue) {
                $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                alert('Sorry, the maximum value was reached');
                // $(this).val($(this).data('oldValue'));
            }

            updateTotal();
        });

        $(document).ready(function () {
            loadPrice({{$period_id}});
        });

        $('#period_id').change(function () {
            var id = $(this).val();
            if(id != ''){
                // เคลียข้อมูลเก่าก่อน
                $('#CC-prodDetails-quantity1').val(0);
                $('#CC-prodDetails-quantity2').val(0);
                $('#CC-prodDetails-quantity3').val(0);
                $('#CC-prodDetails-quantity4').val(0);

                $('#sum_price_text1').text(0);
                $('#sum_price_text2').text(0);
                $('#sum_price_text3').text(0);
                $('#sum_price_text4').text(0);

                $("#price1").val(0);
                $("#sum_price1").val(0);
                $("#price2").val(0);
                $("#sum_price2").val(0);
                $("#price3").val(0);
                $("#sum_price3").val(0);
                $("#price4").val(0);
                $("#sum_price4").val(0);

                $('#net_price_text').text(0);
                $('#total_qty').val(0);
                $('#net_total').val(0);
                $('#sum_adult_text').text(0);
                $('#sum_child_text').text(0);

                loadPrice(id);
            }else{
                loadPrice(0);
            }

        });

        function loadPrice(id) {
            if(id != 0){
                $.ajax({
                    type: "POST",
                    url: '{{ url("/load-price")}}',
                    data: {
                        _token:"{{ csrf_token() }}",
                        id:id,
                    },
                    success: function(res){
                        if(res.status == 200){
                            $('#price1_text').text(Number.parseFloat(res.price1).toLocaleString());
                            $("#price1").val(res.price1);
                            $('#price2_text').text(Number.parseFloat(res.price2).toLocaleString());
                            $("#price2").val(res.price2);
                            $('#price3_text').text(Number.parseFloat(res.price3).toLocaleString());
                            $("#price3").val(res.price3);
                            $('#price4_text').text(Number.parseFloat(res.price4).toLocaleString());
                            $("#price4").val(res.price4);
                            $('#count_text').text(Number.parseFloat(res.count).toLocaleString());
                            $("#count").val(res.count);
                            $(".loadprice").attr("hidden",false);
                        }else{
                            $('#price1_text').text(0);
                            $("#price1").val(0);
                            $('#price2_text').text(0);
                            $("#price2").val(0);
                            $('#price3_text').text(0);
                            $("#price3").val(0);
                            $('#price4_text').text(0);
                            $("#price4").val(0);
                            $('#count_text').text(0);
                            $("#count").val(0);
                            $(".loadprice").attr("hidden",true);
                        }
                        
                    }
                });
            }else{
                $(".loadprice").attr("hidden",true);
            }
            
        };

        function cal_price(id) {
            var price = $('#price'+id).val();
            var qty = $('#CC-prodDetails-quantity'+id).val(); // จำนวนในช่อง +- แต่ละตัว
            var sum_price = price*qty;

            $('#sum_price_text'+id).text(Number.parseFloat(sum_price).toLocaleString());
            $('#sum_price'+id).val(sum_price);
            
            sum_net= 0;
            $('.cal_price').each(function () {
                sum_net += parseInt($(this).val()); // ราคารวม 4 แบบ
            });

            sum_adult = 0;
            $('.adult').each(function () {
                sum_adult += parseInt($(this).val()); // จำนวนผู้ใหญ่
            });

            sum_child = 0;
            $('.child').each(function () {
                sum_child += parseInt($(this).val()); // จำนวนเด็ก
            });
            
            $('#net_price_text').text(Number.parseFloat(sum_net).toLocaleString());
            $('#net_total').val(sum_net);
            $('#sum_adult_text').text(Number.parseFloat(sum_adult).toLocaleString());
            $('#sum_child_text').text(Number.parseFloat(sum_child).toLocaleString());
        }
        
    </script>

</body>

</html>