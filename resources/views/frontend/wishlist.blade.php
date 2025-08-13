<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    @include("frontend.layout.inc_header")
</head>

<body>
    @include("frontend.layout.inc_topmenu")
    <section id="favepage" class="wrapperPages">
        <input type="hidden" name="country_id" id="country_id" value="{{$id}}">
        <div class="container">
            <div class="row mt-3">
                <div class="col">
                    <div class="pageontop_sl">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">หน้าหลัก </a></li>
                                <li class="breadcrumb-item active" aria-current="page"> ทัวร์ที่กดถูกใจ</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-lg-3">
                    <div class="sticky-top">
                        <div class="boxfaqlist">
                            <div id="show_country"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="titletopic mb-4">
                        <h1>ทัวร์ที่กดถูกใจ (<span id="numberwishls1"></span>)</h1>
                    </div>
                    <div id="tourList">

                    </div>
                </div>
            </div>
        </div>
    </section>
    @include("frontend.layout.inc_footer")

</body>
    <script>
        $(document).ready(function () {

            const likedTours = JSON.parse(localStorage.getItem('likedTours')) || [];
            const likedCountElement1 = document.getElementById('numberwishls1');

            // แสดงจำนวนที่ถูกใจใน header
            likedCountElement1.textContent = `${likedTours.length}`;

        });

        // ดึงข้อมูลที่เก็บใน local storage
        const likedTours = JSON.parse(localStorage.getItem('likedTours')) || [];
        var c_id = document.getElementById('country_id').value;
        $.ajax({
            url: '{{ url('get-like-tours') }}',
            type: 'POST',
            data: { 
                _token : '{{ csrf_token() }}',
                likedTours: likedTours ,
                c_id:c_id,
            },
            success: function(data) {
                const tourList = document.getElementById('tourList');
                tourList.innerHTML = data;
                readMore();
                clearIds();

                setInitialLikedStatus();
            }
        });

        $.ajax({
            url: '{{ url('wishlist-country') }}',
            type: 'POST',
            data: { 
                _token : '{{ csrf_token() }}',
                likedTours: likedTours ,
                c_id:c_id,
            },
            success: function(data) {
                const show_country = document.getElementById('show_country');
                show_country.innerHTML = data;
                setInitialLikedStatus();
            }
        });

        // ติด active ใน icon heart
        function setInitialLikedStatus() {
            const heartIcons = document.querySelectorAll('.wishlist');
            
            heartIcons.forEach(icon => {
                const tourId = parseInt(icon.getAttribute('data-tour-id'));
                if (likedTours.includes(tourId)) {
                    icon.classList.add('active');
                }
            });
        }

        function clearIds() {
            var invalidIdsInput  = document.getElementById('invalidIds');
            var invalidIds = JSON.parse(invalidIdsInput.value);

            invalidIds.forEach(function(invalidId) {
                var index = likedTours.indexOf(invalidId);
                if (index !== -1) {
                    likedTours.splice(index, 1);
                }
            });

            // อัปเดต localStorage
            localStorage.setItem('likedTours', JSON.stringify(likedTours));

            const likedCountElement1 = document.getElementById('numberwishls1');
            const likedCountElement = document.getElementById('numberwishls');
            const likedCountElementM = document.getElementById('numberwishlsM');

            // แสดงจำนวนที่ถูกใจใน header
            likedCountElement1.textContent = `${likedTours.length}`;
            likedCountElement.textContent = `${likedTours.length}`;
            likedCountElementM.textContent = `${likedTours.length}`;
        }

        function likedTour(tourId) {
            const index = likedTours.indexOf(tourId);

            if (index === -1) {
                likedTours.push(tourId);
            } else {
                likedTours.splice(index, 1);
            }

            // บันทึก likedTours ใน local storage
            localStorage.setItem('likedTours', JSON.stringify(likedTours));

            // อัปเดตสถานะของไอคอนถูกใจ
            const heartIcon = document.querySelector(`[data-tour-id="${tourId}"]`);
            if (likedTours.includes(tourId)) {
                heartIcon.classList.add('active');
                toastr.success("ได้เพิ่มทัวร์ในรายการที่ต้องการสำเร็จแล้ว");
            } else {
                heartIcon.classList.remove('active');
                toastr.error("ลบรายการทัวร์ที่ต้องการสำเร็จแล้ว");
            }

            const likedCountElement = document.getElementById('numberwishls');
            const likedCountElementM = document.getElementById('numberwishlsM');

            // แสดงจำนวนที่ถูกใจใน header
            likedCountElement.textContent = `${likedTours.length}`;
            likedCountElementM.textContent = `${likedTours.length}`;

            location.reload();
        }
        async function readMore(){
            var $readMore = "ดูช่วงเวลาเพิ่มเติม ";
            var $readLess = "ย่อข้อความ";
            $(".readMoreBtn").text($readMore);
            $('.readMoreBtn').click(function () {
                var $this = $(this);
                $this.text($readMore);
                if ($this.data('expanded') == "yes") {
                    $this.data('expanded', "no");
                    $this.text($readMore);
                    $this.parent().find('.readMoreText').animate({
                        maxHeight: '120px'
                    });
                } else {
                    $this.data('expanded', "yes");
                    $this.parent().find('.readMoreText').css({
                        maxHeight: 'none'
                    });
                    $this.text($readLess);

                }
            });

            var $readMore2 = "<i class=\"fi fi-rr-angle-small-down\"></i>";
            var $readLess2 = "<i class=\"fi fi-rr-angle-small-up\"></i>";
            $(".readMoreBtn2").html($readMore2);
            $('.readMoreBtn2').click(function () {
                var $this = $(this);
                $this.html($readMore2);
                if ($this.data('expanded') == "yes") {
                    $this.data('expanded', "no");
                    $this.html($readMore2);
                    $this.parent().find('.readMoreText2').animate({
                        height: '50px'
                    });
                } else {
                    $this.data('expanded', "yes");
                    $this.parent().find('.readMoreText2').css({
                        height: 'auto'
                    });
                    $this.html($readLess2);

                }
            });
        }
    </script>
</html>