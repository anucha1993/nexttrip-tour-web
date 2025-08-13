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
    <li><a href="{{url('wishlist/0')}}" @if($c_id == 0)  class="active" @endif >ทั้งหมด</a><span>({{$total}})</span></li>
    @foreach ($country_all as $k => $coun)
       @php $data = App\Models\Backend\CountryModel::find($coun); @endphp
            <li><a href="{{url('wishlist/'.$coun)}}" @if($c_id == $data->id) class="active" @endif>{{$data->country_name_th}} </a> <span>({{isset($id_tour[$coun])?count($id_tour[$coun]):0}})</span></li>
    @endforeach
</ul>
<br>
@if($province_all)
<div class="titletopic">
    <h2>จังหวัด</h2>
</div>
<?php
        $totalP = 0;
        foreach($id_tourP as $num_coun){
            $totalP += count($num_coun);
        }
    ?>
<ul class="favelist">
    <li><a href="{{url('wishlist/0')}}" @if($c_id == 0)  class="active" @endif >ทั้งหมด</a><span>({{$totalP}})</span></li>
    @foreach ($province_all as $k => $coun)
       @php $data = App\Models\Backend\ProvinceModel::find($coun); @endphp
            <li><a href="{{url('wishlist/'.$coun)}}" @if($c_id == $data->id) class="active" @endif>{{$data->name_th}} </a> <span>({{isset($id_tourP[$coun])?count($id_tourP[$coun]):0}})</span></li>
    @endforeach
</ul>
@endif