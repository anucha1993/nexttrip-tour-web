<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    @include("frontend.layout.inc_header")
</head>

<body>
    @include("frontend.layout.inc_topmenu")
    <section id="helppage" class="wrapperPages">
        <div class="container-fluid g-0 overflow-hidden">
            <div class="row">
                <div class="col">
                    @php
                        $banner = \App\Models\Backend\BannerModel::where('id',13)->first();
                    @endphp
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
            <div class="row mt-5">
                <div class="col-lg-4">
                    <div class="boxfaqlist sticky-top">
                        <div class="d-flex align-items-start">
                            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist"
                                aria-orientation="vertical">
                                @foreach($data as $k => $dat)
                                <button class="nav-link @if($k == 0) active @endif" id="v-pills-home-tab" data-bs-toggle="pill"
                                    data-bs-target="#v-pills-home-{{$dat->id}}" type="button" role="tab" aria-controls="v-pills-home"
                                    aria-selected="true"> {{$dat->title}}</button>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="tab-content" id="v-pills-tabContent">
                        @foreach($data as $k => $dat)
                        <div class="tab-pane fade @if($k == 0) show active @endif" id="v-pills-home-{{$dat->id}}" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">
                            <div class="titletopic mb-4">
                                <h2>{{$dat->title}}</h2>
                            </div>
                            <div class="contentde">
                                {!! $dat->detail !!}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include("frontend.layout.inc_footer")

</body>

</html>