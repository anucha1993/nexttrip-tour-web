<script>

async function Send_search(){
        var form = $('#searchForm')[0];
        var data = new FormData(form);
            await $.ajax({
                type: 'POST',
                url: '{{url("/search-tour")}}',
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                success: function (datas) {
                    document.getElementById('show_count').innerHTML = "พบ "+datas.period+" รายการ";
                    document.getElementById('show_search').innerHTML = datas.data;
                }
            });
        return false;
}

function SearchData(){
    var data = document.getElementById('search_data').value ;
    var result_country = '';
    var result_city = '';
    var result_province = '';
    var result_amupur = '';
    var searchfamus = '';
    var search_keyword = '';
    var url = "{{url('/')}}";
    if(data){
            let search_country = country.filter(x => x.country_name_th.includes(data));
            let search_city = city.filter(x => x.city_name_th.includes(data)); 
            let search_province = province.filter(x => x.name_th.includes(data));
            let search_amupur = amupur.filter(x => x.name_th.includes(data)); 
            if(search_country || search_city||search_province || search_amupur){
                document.getElementById("search_famus").innerHTML = '';
                for(x=0;x < search_country.length;x++){
                    result_country = result_country+'<li><a href="javascript:void(0)" onclick="select_country('+search_country[x].id+')" style="color:black; text-decoration: none;">ประเทศ'+search_country[x].country_name_th+'</a><li><br>';  
                }
                if(search_city){
                    for(i=0;i < search_city.length;i++){
                        result_city = result_city+'<li><a href="javascript:void(0)" onclick="select_city('+search_city[i].id+')" style="color:black;text-decoration: none;">เมือง'+search_city[i].city_name_th+'</a><li><br>';
                    }
                }
                if(search_province){
                    for(i=0;i < search_province.length;i++){
                        result_province = result_province+'<li><a href="javascript:void(0)" onclick="select_province('+search_province[i].id+')" style="color:black;text-decoration: none;">จังหวัด'+search_province[i].name_th+'</a><li><br>';
                    }
                }
                if(search_amupur){
                    for(i=0;i < search_amupur.length;i++){
                        result_city = result_city+'<li><a href="javascript:void(0)" onclick="select_amupur('+search_amupur[i].id+')" style="color:black;text-decoration: none;">อำเภอ'+search_amupur[i].name_th+'</a><li><br>';
                    }
                }
                if(result_country || result_city ||result_province || result_amupur){
                    search_keyword = search_keyword+"<div class='searchexpbox' style='position: absolute;width: 90%;  background: white;  z-index: 1; height: 200px;overflow-x: hidden; overflow-y: scroll; border: 1px solid #eee;'><div class='col-lg-4'><div class='titletopic'><h3>ผลการค้นหา</h3></div><div class='listsearchsq'>";
                    search_keyword = search_keyword+result_country+result_city+result_province+result_amupur;   
                    search_keyword = search_keyword+"</div></div> </div>";
                    document.getElementById("livesearch").innerHTML = search_keyword
                }else{
                    // search_keyword = search_keyword+"<div class='row'><div class='col-lg-4'><div class='titletopic'><h3>ผลการค้นหา</h3></div><div class='listsearchsq'>";
                    // search_keyword = search_keyword+"<span class='text-danger'><b>ไม่พบผลการค้นหา</b></span><br>";   
                    // search_keyword = search_keyword+"</div></div> </div>";
                    // $('#livesearch').hide();
                    document.getElementById("livesearch").innerHTML = '';
                }       
            }
    }else{
            searchfamus = searchfamus+"<div class='row' style='position: absolute;width: 90%;  background: white;  z-index: 1; height: 200px;overflow-x: hidden; overflow-y: scroll; border: 1px solid #eee;'><div class='col-lg-6'><div class='titletopic'><h3>คำค้นหายอดนิยม</h3></div><div class='listsearchsq'>";
            for(z = 0 ; z < keyword_famus.length ; z++) {
                searchfamus = searchfamus+" <li id='famus"+z+"'><a href='javascript:void(0)' onclick='select_keyword("+keyword_famus[z].id+")' >"+keyword_famus[z].keyword+"</a></li><br>";                         
            }
            searchfamus = searchfamus+"</div></div><div class='col-lg-6'><div class='titletopic'><h3>ประเทศยอดนิยมในการค้นหา</h3></div>";                            
            for(y = 0 ; y < country_famus.length ; y++) {       
                searchfamus = searchfamus+"<a href='javascript:void(0)' onclick='select_country("+country_famus[y].id+")'  class='sitesertc'>";                
                searchfamus = searchfamus+"<div class='row'><div class='col-4 col-lg-4'><img src='"+country_famus[y].img_banner+"' class='img-fluid p-1' alt=''></div>";
                searchfamus = searchfamus+"<div class='col-8 col-lg-8'><div class='details'><h4>"+country_famus[y].country_name_th+" <span>( "+country_famus[y].count_search+" )</span></h4>";
                if(country_famus[y].description){
                    searchfamus = searchfamus+"<p>"+country_famus[y].description+"</p>";
                }    
                searchfamus = searchfamus+"</div></div></div></a>";                             
            }
            searchfamus = searchfamus+"</div></div>";    
            document.getElementById("search_famus").innerHTML = searchfamus;
            // $('#livesearch').hide();
            document.getElementById("livesearch").innerHTML = '';
    }
}
function SearchData1(){
    var data1 = document.getElementById('search_data1').value ;
    var result_country = '';
    var result_city = '';
    var result_province = '';
    var result_amupur = '';
    var searchfamus = '';
    var search_keyword = '';
    var url = "{{url('/')}}";
    if(data1){
        let search_country = country.filter(x => x.country_name_th.includes(data1));
        let search_city = city.filter(x => x.city_name_th.includes(data1)); 
        let search_province = province.filter(x => x.name_th.includes(data1));
        let search_amupur = amupur.filter(x => x.name_th.includes(data1)); 
        if(search_country || search_city||search_province || search_amupur){
            for(x=0;x < search_country.length;x++){
                result_country = result_country+'<li><a href="javascript:void(0)" onclick="select_country1('+search_country[x].id+')" style="color:black; text-decoration: none;">ประเทศ'+search_country[x].country_name_th+'</a><li><br>';  
            }
            if(search_city){
                for(i=0;i < search_city.length;i++){
                    result_city = result_city+'<li><a href="javascript:void(0)" onclick="select_city1('+search_city[i].id+')" style="color:black;text-decoration: none;">เมือง'+search_city[i].city_name_th+'</a><li><br>';
                }
            }
            if(search_province){
                for(i=0;i < search_province.length;i++){
                    result_province = result_province+'<li><a href="javascript:void(0)" onclick="select_province1('+search_province[i].id+')" style="color:black;text-decoration: none;">จังหวัด'+search_province[i].name_th+'</a><li><br>';
                }
            }
            if(search_amupur){
                for(i=0;i < search_amupur.length;i++){
                    result_city = result_city+'<li><a href="javascript:void(0)" onclick="select_amupur1('+search_amupur[i].id+')" style="color:black;text-decoration: none;">อำเภอ'+search_amupur[i].name_th+'</a><li><br>';
                }
            }
            if(result_country || result_city ||result_province || result_amupur){
                search_keyword = search_keyword+"<div class='searchexpbox' style='position: absolute;width: 90%;  background: white;  z-index: 1; height: 200px;overflow-x: hidden; overflow-y: scroll; border: 1px solid #eee;'><div class='col-lg-4'><div class='titletopic'><h3>ผลการค้นหา</h3></div><div class='listsearchsq'>";
                search_keyword = search_keyword+result_country+result_city+result_province+result_amupur;   
                search_keyword = search_keyword+"</div></div> </div>";
                document.getElementById("livesearch1").innerHTML = search_keyword
            }else{
                // search_keyword = search_keyword+"<div class='searchexpbox' style='position: absolute;width: 100%;  background: white;  z-index: 1; height: 200px;overflow-x: hidden; overflow-y: scroll; border: 1px solid #eee;'><div class='col-lg-4'><div class='titletopic'><h3>ผลการค้นหา</h3></div><div class='listsearchsq'>";
                // search_keyword = search_keyword+"<span class='text-danger'><b>ไม่พบผลการค้นหา</b></span><br>";   
                // search_keyword = search_keyword+"</div></div> </div>";
                // document.getElementById("livesearch1").innerHTML = search_keyword;
                document.getElementById("livesearch1").innerHTML = '';
            }
        }else{
            document.getElementById("livesearch1").innerHTML = '';
        }
    }else{
        document.getElementById("livesearch1").innerHTML = '';
    }
}
        function select_country(id){
            var selected = country.find(x => x.id == id);
            if(selected){
                document.getElementById('search_data').value = selected.country_name_th;
            }
            $('#livesearch').hide();
            $('#search_famus').hide();
            // document.getElementById("livesearch").innerHTML = '';
        }
        function select_city(id){
            var selected = city.find(x => x.id == id);
            if(selected){
                document.getElementById('search_data').value = selected.city_name_th;
            }
            // $('#livesearch').hide();
            document.getElementById("livesearch").innerHTML = '';
        }
        function select_province(id){
            var selected = province.find(x => x.id == id);
            if(selected){
                document.getElementById('search_data').value = selected.name_th;
            }
            // $('#livesearch').hide();
            document.getElementById("livesearch").innerHTML = '';
        }
        function select_amupur(id){
            var selected = amupur.find(x => x.id == id);
            if(selected){
                document.getElementById('search_data').value = selected.name_th;
            }
            // $('#livesearch').hide();
            document.getElementById("livesearch").innerHTML = '';
        }
        function select_keyword(id){
            var selected = keyword_famus.find(x => x.id == id);
            if(selected){
                document.getElementById('search_data').value = selected.keyword;
            }
            // $('#search_famus').hide();
            document.getElementById("search_famus").innerHTML = '';
        }

        function select_country1(id){
            var selected = country.find(x => x.id == id);
            if(selected){
                document.getElementById('search_data1').value = selected.country_name_th;
            }
            // $('#livesearch1').hide();
            document.getElementById("livesearch1").innerHTML = '';
        }
        function select_city1(id){
            var selected = city.find(x => x.id == id);
            if(selected){
                document.getElementById('search_data1').value = selected.city_name_th;
            }
            // $('#livesearch1').hide();
            document.getElementById("livesearch1").innerHTML = '';
        }
        function select_province1(id){
            var selected = province.find(x => x.id == id);
            if(selected){
                document.getElementById('search_data1').value = selected.name_th;
            }
            // $('#livesearch1').hide();
            document.getElementById("livesearch1").innerHTML = '';
        }
        function select_amupur1(id){
            var selected = amupur.find(x => x.id == id);
            if(selected){
                document.getElementById('search_data1').value = selected.name_th;
            }
            // $('#livesearch1').hide();
            document.getElementById("livesearch1").innerHTML = '';
        }
        function HideSearch(){
            setTimeout(function(){ 
                let data = document.getElementById('search_data').value ;
                if(!data){
                    $('#livesearch').hide();
                    $('#search_famus').hide();
                }
            }, 500);
            
        }

</script>