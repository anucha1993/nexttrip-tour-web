<script>
    var active_day = '';
       var active_price = '';
       var active_country = '';
       var active_city = '';
       var active_airline = '';
       var active_rating = '';
       var before = new Array();
       var type_data = {
           country: new Array(),
           city: new Array(),
           price: new Array(),
           airline: new Array(),
           rating: new Array(),
           day: new Array(),
           start_date:new Array(),
           end_date:new Array(),
           month_fil:new Array(),
           calen_start:new Array(),
       };
       var length_price = ['','ต่ำกว่า 10,000','10,001-20,000','20,001-30,000','30,001-50,000','50,001-80,000','80,001 ขึ้นไป'];
       var month_data =['','มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'];

       // var info_search = '';
       // var search_price  =  document.getElementById('search_price').value;
       // if(search_price){
       //     info_search += "<li onclick='SelectSearch()'><label class='check-container'>"+length_price[search_price]+"  <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";      
       //     document.getElementById('show_select').innerHTML = info_search;
       // }
       // function SelectSearch(){
       //     search_price = '';
       //     document.getElementById('show_select').innerHTML = '';
       // }

       function SelectFilter(){
           var text = '';
           var text_mb = '';
           var check_list = {
               country : 'country',
               city : 'city',
               day : 'day',
               airline : 'airline',
               rating : 'rating',
               price : 'price',
               start_date : 'start_date',
               end_date : 'end_date',
               month_fil : 'month_fil',
               calen_start : 'calen_start',
           };
          
           for(let x in type_data){
               if(type_data[x].length){
                   // if(x == 'start_date'){
                   //     // for(let y in type_data[x]){
                   //         text += "<li onclick='document.getElementById(`s_date`).click()'><label class='check-container'>"+type_data[x]+"  <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";      
                   //     // }
                   // }
                   if(x == 'price'){
                       for(let y in type_data[x]){
                           text += "<li onclick='document.getElementById(`"+check_list[x]+type_data[x][y]+"`).click()'><label class='check-container'>"+length_price[type_data[x][y]]+"  <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";      
                           text_mb += "<li onclick='document.getElementById(`price_mb"+type_data[x][y]+"`).click()'><label class='check-container'>"+length_price[type_data[x][y]]+"  <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";           
                       }
                   }
                   if(x == 'city'){
                       for(let y in type_data[x]){
                           let go = data_type[x].find(z=>z.id == type_data[x][y]);
                           let name_city = go.city_name_th?go.city_name_th:go.city_name_en;
                           text += "<li onclick='document.getElementById(`"+check_list[x]+type_data[x][y]+"`).click()'><label class='check-container'>"+name_city+"  <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";      
                           text_mb += "<li onclick='document.getElementById(`city_mb"+type_data[x][y]+"`).click()'><label class='check-container'>"+name_city+"  <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";          
                       }
                   }
                   if(x == 'day'){
                       for(let y in type_data[x]){
                           text += "<li onclick='document.getElementById(`"+check_list[x]+type_data[x][y]+"`).click()'><label class='check-container'>"+type_data[x][y]+" วัน  <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";      
                           text_mb += "<li onclick='document.getElementById(`day_mb"+type_data[x][y]+"`).click()'><label class='check-container'>"+type_data[x][y]+" วัน  <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";          
                       }
                   }
                   if(x == 'airline'){
                       for(let y in type_data[x]){
                           text += "<li onclick='document.getElementById(`"+check_list[x]+type_data[x][y]+"`).click()'><label class='check-container'>"+data_type[x].find(z=>z.id == type_data[x][y]).travel_name+"  <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";      
                           text_mb += "<li onclick='document.getElementById(`airline_mb"+type_data[x][y]+"`).click()'><label class='check-container'>"+data_type[x].find(z=>z.id == type_data[x][y]).travel_name+"  <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>"; 
                       }
                   }
                   if(x == 'rating'){
                       for(let y in type_data[x]){
                           text += "<li onclick='document.getElementById(`"+check_list[x]+type_data[x][y]+"`).click()'><label class='check-container'>";
                           text_mb += "<li onclick='document.getElementById(`rating_mb"+type_data[x][y]+"`).click()'><label class='check-container'>";
                           if(type_data[x][y] != 0){
                               text += type_data[x][y]+' ดาว';
                               text_mb += type_data[x][y]+' ดาว';
                           }else{
                               text += 'ไม่มีระดับดาวที่พัก';
                               text_mb += 'ไม่มีระดับดาวที่พัก';
                           }   
                           text += " <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";      
                           text_mb += " <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";    
                       }
                   }
                   if(x == 'month_fil'){
                       for(let y in type_data[x]){
                           let month_value = type_data[x][y];
                           let m =  month_value.substr(0,2)*1;
                           let year =  month_value.substr(2,5);
                           text += "<li onclick='document.getElementById(`"+check_list[x]+m+"`).click()'><label class='check-container'>"+month_data[m]+" "+year+" <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";  
                           text_mb += "<li onclick='document.getElementById(`month_fil_mb"+m+"`).click()'><label class='check-container'>"+month_data[m]+" "+year+" <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";          
                       }
                       check_month(type_data[x]);
                   }
                   if(x == 'calen_start'){
                       for(let y in type_data[x]){
                           let go = data_type[x].find(z=>z.id == type_data[x][y]);
                           let name = go.holiday;
                           text += "<li onclick='document.getElementById(`"+check_list[x]+go.id+"`).click()'><label class='check-container'>"+name+"  <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";   
                           text_mb += "<li onclick='document.getElementById(`calen_start_mb"+go.id+"`).click()'><label class='check-container'>"+name+"  <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";         
                       }
                       check_month(type_data[x]);
                   }
               }
           }
           if(isWin || isMac){
               if(text == '' && document.getElementById('s_date').value == ''){
                   window.location.reload();
               }
           }else if(isAndroid || isIPhone || isIPad){
               if(text_mb == '' && document.getElementById('s_date_mb').value == ''){
                   window.location.reload();
               }
           }
          
          
           document.getElementById('show_select').innerHTML = text;
           document.getElementById('show_select_mb').innerHTML = text_mb;
           document.getElementById('show_select_mb_all').innerHTML = text_mb;
          
       }
       if(price_search){
           var check = document.getElementById('price'+price_search).checked;
           if(check){
               Check_filter(price_search*1,'price');
           }
       }
       if(city_search){
           var check = document.getElementById('city'+city_search).checked;
           if(check){
               Check_filter(city_search,'city');
           }
       }
       async function Check_filter(value,type){
           check_date();
           if(type_data[type] != type_data['start_date'] && type_data[type] != type_data['end_date']){
               if(type_data[type].includes(value)){
                   var index = type_data[type].indexOf(value);
                   type_data[type].splice(index,1);
                   check_month(index);
               }else{
                   type_data[type].push(value);
               }
               if(type_data['price'].length != data_type['price'].length){
                   document.getElementById('price7').checked = false;
                   document.getElementById('price_mb7').checked = false;
               }else{
                   document.getElementById('price7').checked = true;
                   document.getElementById('price_mb7').checked = true;
               }
               var start_data = document.getElementById('s_date').value;
               var end_data = document.getElementById('e_date').value;
               var start_data_mb = document.getElementById('s_date_mb').value;
               var end_data_mb = document.getElementById('e_date_mb').value;
           }
           var start_data = document.getElementById('s_date').value;
           var end_data = document.getElementById('e_date').value;
           var start_data_mb = document.getElementById('s_date_mb').value;
           var end_data_mb = document.getElementById('e_date_mb').value;
       
           
           SelectFilter();
           let payload = {
               tour_id:document.getElementById('tour_id_data').value,
               data:type_data,
               start_date: start_data,
               end_date: end_data,
               start_date_mb: start_data_mb,
               end_date_mb: end_data_mb,
               calen_id : document.getElementById('calen_id').value,
               orderby:document.getElementById('orderby_data').value,
               _token: '{{csrf_token()}}',
               slug:document.getElementById('slug').value,
           }
            Swal.fire({
                title: "Now loading",
                timerProgressBar: true,
                didOpen: () => {
                        Swal.showLoading();
                },
            });
           await $.ajax({
               type: 'POST',
               url: '{{url("/filter-oversea")}}',
               data: payload,
               success: function (data) {
                   document.getElementById('show_search').innerHTML = data.tour_list;
                   document.getElementById('show_grid').innerHTML = data.tour_grid;
                   document.getElementById('show_count').innerHTML = "พบ "+data.count_pe+" รายการ";
                   var price_select = '';
                   var price_select_mb = '';
                   var price_count = 0;
                   for(let p in data.filter.price){
                        try {
                            let check = type_data.price.includes(p*1)?'checked':'';
                            price_select = price_select+'<li><label class="check-container">'+length_price[p];
                            price_select = price_select+'<input type="checkbox" name="price" id="price'+p+'" onclick="Check_filter('+p+',`price`)" value="'+p+'" '+check+'>';
                            price_select = price_select+'<span class="checkmark"></span><div class="count">('+data.filter.price[p].length+')</div></label></li>';
                            price_count++;

                            price_select_mb = price_select_mb+'<li><label class="check-container">'+length_price[p];
                            price_select_mb = price_select_mb+'<input type="checkbox" name="price" id="price_mb'+p+'" onclick="Check_filter('+p+',`price`)" value="'+p+'" '+check+'>';
                            price_select_mb = price_select_mb+'<span class="checkmark"></span><div class="count">('+data.filter.price[p].length+')</div></label></li>';
                        } catch (error) {}
                   }
                   document.getElementById('show_price').innerHTML = price_select; 
                   document.getElementById('show_price_mb').innerHTML = price_select_mb;    
                   if(price_count > 1){
                       $('#show_total').show();  
                       $('#show_total_mb').show(); 
                   }else{
                       $('#show_total').hide();  
                       $('#show_total_mb').hide(); 
                   }
                   var day_select = '';
                   var day_select_mb = '';
                   for(let d in data.filter.day){
                        try {
                            let check = type_data.day.includes(d*1)?'checked':'';
                            day_select = day_select+'<li><label class="check-container">'+d+' วัน';
                            day_select = day_select+'<input type="checkbox" name="day" id="day'+d+'" onclick="Check_filter('+d+',`day`)" value="'+d+'" '+check+'>';
                            day_select = day_select+'<span class="checkmark"></span><div class="count">('+data.filter.day[d].length+')</div></label></li>';
                        
                            day_select_mb = day_select_mb+'<li><label class="check-container">'+d+' วัน';
                            day_select_mb = day_select_mb+'<input type="checkbox" name="day" id="day_mb'+d+'" onclick="Check_filter('+d+',`day`)" value="'+d+'" '+check+'>';
                            day_select_mb = day_select_mb+'<span class="checkmark"></span><div class="count">('+data.filter.day[d].length+')</div></label></li>';
                        } catch (error) { }
                   }
                   document.getElementById('show_day').innerHTML = day_select;
                   document.getElementById('show_day_mb').innerHTML = day_select_mb; 

                   var month_select = '';
                   var month_select_mb = '';
                   for(let y in data.filter.year){
                        try {
                            month_select = month_select+'<li>'+y+'</li>';
                            for(let m in data.filter.year[y]){
                                let value_m = m < 10 ?'0'+m+y:m+y;
                                let check = type_data.month_fil.includes(value_m)?'checked':'';
                                month_select = month_select+'<li><label class="check-container">'+month_data[m];
                                month_select = month_select+'<input type="checkbox" name="month_fil" id="month_fil'+m+'" onclick="Check_filter(`'+value_m+'`,`month_fil`)" value="'+value_m+'" '+check+'>';
                                month_select = month_select+'<span class="checkmark"></span><div class="count">('+data.filter.year[y][m].length+')</div></label></li>';
                            
                                month_select_mb = month_select_mb+'<li><label class="check-container">'+month_data[m];
                                month_select_mb = month_select_mb+'<input type="checkbox" name="month_fil" id="month_fil_mb'+m+'" onclick="Check_filter(`'+value_m+'`,`month_fil`)" value="'+value_m+'" '+check+'>';
                                month_select_mb = month_select_mb+'<span class="checkmark"></span><div class="count">('+data.filter.year[y][m].length+')</div></label></li>';

                            }
                        } catch (error) { }
                   }
                   document.getElementById('show_month').innerHTML = month_select;
                   document.getElementById('show_month_mb').innerHTML = month_select_mb;

                   var city_select = '';
                   var city_select_mb = '';
                   for(let c in data.filter.city){
                    try {
                        let num_tour = 0;
                        for(let y in data.period){
                            if(data.period[y].city_id.includes(data.filter.city[c])){
                                num_tour++;
                            }
                        }
                        if(c <= 9){
                            let go = data_type.city.find(z=>z.id == data.filter.city[c]);
                            let check = type_data.city.includes(data.filter.city[c]*1)?'checked':'';
                            let name_city = go.city_name_th?go.city_name_th:go.city_name_en;
                            if(go){
                                city_select = city_select+'<li><label class="check-container">'+name_city ;
                                city_select = city_select+'<input type="checkbox" name="city" id="city'+go.id+'" onclick="Check_filter('+go.id+',`city`)" value="'+go.id+'" '+check+'>';
                                city_select = city_select+'<span class="checkmark"></span><div class="count">('+num_tour+')</div></label></li>';
                                
                                city_select_mb = city_select_mb+'<li><label class="check-container">'+name_city ;
                                city_select_mb = city_select_mb+'<input type="checkbox" name="city" id="city_mb'+go.id+'" onclick="Check_filter('+go.id+',`city`)" value="'+go.id+'" '+check+'>';
                                city_select_mb = city_select_mb+'<span class="checkmark"></span><div class="count">('+num_tour+')</div></label></li>';
                            }
                        }else{ 
                            let go = data_type.city.find(z=>z.id == data.filter.city[c]);
                            let check = type_data.city.includes(data.filter.city[c]*1)?'checked':'';
                            let name_city = go.city_name_th?go.city_name_th:go.city_name_en;
                            if(go){
                                city_select = city_select+'<div id="moreprovince" class="collapse">';
                                city_select = city_select+'<li><label class="check-container">'+name_city ;
                                city_select = city_select+'<input type="checkbox" name="city" id="city'+go.id+'" onclick="Check_filter('+go.id+',`city`)" value="'+go.id+'" '+check+'>';
                                city_select = city_select+'<span class="checkmark"></span><div class="count">('+num_tour+')</div></label></li>';
                                city_select = city_select+'</div>';

                                city_select_mb = city_select_mb+'<div id="moreprovince" class="collapse">';
                                city_select_mb = city_select_mb+'<li><label class="check-container">'+name_city ;
                                city_select_mb = city_select_mb+'<input type="checkbox" name="city" id="city_mb'+go.id+'" onclick="Check_filter('+go.id+',`city`)" value="'+go.id+'" '+check+'>';
                                city_select_mb = city_select_mb+'<span class="checkmark"></span><div class="count">('+num_tour+')</div></label></li>';
                                city_select_mb = city_select_mb+'</div>';
                            }
                        }
                    } catch (error) { }
                      
                   }
                   if(data.filter.city.length > 9){ 
                       city_select = city_select+'<a data-bs-toggle="collapse" data-bs-target="#moreprovince" class="seemore"> ดูเพิ่มเติม</a>';
                       city_select_mb = city_select_mb+'<a data-bs-toggle="collapse" data-bs-target="#moreprovince" class="seemore"> ดูเพิ่มเติม</a>';
                   }
                   document.getElementById('show_city').innerHTML = city_select;
                   document.getElementById('show_city_mb').innerHTML = city_select_mb;

                    var airline_select = '';
                    var airline_select_mb = '';
                    var airline_count = 0;
                    for(let a in data.filter.airline){
                        try {
                            if(a){
                                airline_count++
                            }
                            if(airline_count <= 10){
                                let go = data_type.airline.find(z=>z.id == a);
                                let check = type_data.airline.includes(a*1)?'checked':'';
                                if(go){
                                    airline_select = airline_select+'<li><label class="check-container">';
                                    if(go.image){
                                        airline_select = airline_select+'<img src="/'+go.image+'" alt=""> '+go.travel_name;
                                    }else{
                                        airline_select = airline_select+go.travel_name;
                                    }
                                    airline_select = airline_select+'<input type="checkbox" name="airline" id="airline'+a+'" onclick="Check_filter('+a+',`airline`)" value="'+a+'" '+check+'>';
                                    airline_select = airline_select+'<span class="checkmark"></span><div class="count">('+data.filter.airline[a].length+')</div></label></li>';
                                
                                    airline_select_mb = airline_select_mb+'<li><label class="check-container">';
                                    if(go.image){
                                        airline_select_mb = airline_select_mb+'<img src="/'+go.image+'" alt=""> '+go.travel_name;
                                    }else{
                                        airline_select_mb = airline_select_mb+go.travel_name;
                                    }
                                    airline_select_mb = airline_select_mb+'<input type="checkbox" name="airline" id="airline_mb'+a+'" onclick="Check_filter('+a+',`airline`)" value="'+a+'" '+check+'>';
                                    airline_select_mb = airline_select_mb+'<span class="checkmark"></span><div class="count">('+data.filter.airline[a].length+')</div></label></li>';
                                }
                            }else{
                                let go = data_type.airline.find(z=>z.id == a);
                                let check = type_data.airline.includes(a*1)?'checked':'';
                                if(go){
                                    airline_select = airline_select+'<div id="moreair" class="collapse"><li><label class="check-container">';
                                    if(go.image){
                                        airline_select = airline_select+'<img src="/'+go.image+'" alt=""> '+go.travel_name;
                                    }else{
                                        airline_select = airline_select+go.travel_name;
                                    }
                                    airline_select = airline_select+'<input type="checkbox" name="airline" id="airline'+a+'" onclick="Check_filter('+a+',`airline`)" value="'+a+'" '+check+'>';
                                    airline_select = airline_select+'<span class="checkmark"></span><div class="count">('+data.filter.airline[a].length+')</div></label></li></div>';
                                
                                    airline_select_mb = airline_select_mb+'<div id="moreair" class="collapse"><li><label class="check-container">';
                                    if(go.image){
                                        airline_select_mb = airline_select_mb+'<img src="/'+go.image+'" alt=""> '+go.travel_name;
                                    }else{
                                        airline_select_mb = airline_select_mb+go.travel_name;
                                    }
                                    airline_select_mb = airline_select_mb+'<input type="checkbox" name="airline" id="airline_mb'+a+'" onclick="Check_filter('+a+',`airline`)" value="'+a+'" '+check+'>';
                                    airline_select_mb = airline_select_mb+'<span class="checkmark"></span><div class="count">('+data.filter.airline[a].length+')</div></label></li></div>';
                                }
                            }      
                        } catch (error) { }
                       
                    }
                    if(airline_count > 10){
                            airline_select = airline_select+'<a data-bs-toggle="collapse" data-bs-target="#moreair" class="seemore"> ดูเพิ่มเติม</a>';
                            airline_select_mb = airline_select_mb+'<a data-bs-toggle="collapse" data-bs-target="#moreair" class="seemore"> ดูเพิ่มเติม</a>';
                    } 
                   document.getElementById('show_air').innerHTML = airline_select; 
                   document.getElementById('show_air_mb').innerHTML = airline_select_mb;

                   var rating_select = '';
                   var rating_select_mb = '';
                   for(let r in data.filter.rating){
                        try {
                            let check = type_data.rating.includes(r*1)?'checked':'';
                            rating_select = rating_select+'<li><label class="check-container"><div class="rating">';
                            if(r*1 == 0){
                                rating_select = rating_select+'ไม่มีระดับดาวที่พัก';
                            }else{
                                for(n=1;n<=r*1;n++){
                                    rating_select = rating_select+'<i class="bi bi-star-fill"></i>';
                                }     
                            }                
                            rating_select = rating_select+'</div><input type="checkbox" name="rating" id="rating'+r*1+'" onclick="Check_filter('+r*1+',`rating`)" value="'+r*1+'" '+check+'>';
                            rating_select = rating_select+'<span class="checkmark"></span><div class="count">('+data.filter.rating[r].length+')</div></label></li>';
                        
                            rating_select_mb = rating_select_mb+'<li><label class="check-container"><div class="rating">';
                            if(r*1 == 0){
                                rating_select_mb = rating_select_mb+'ไม่มีระดับดาวที่พัก';
                            }else{
                                for(n=1;n<=r*1;n++){
                                    rating_select_mb = rating_select_mb+'<i class="bi bi-star-fill"></i>';
                                }     
                            }                         
                            rating_select_mb = rating_select_mb+'</div><input type="checkbox" name="rating" id="rating_mb'+r*1+'" onclick="Check_filter('+r*1+',`rating`)" value="'+r*1+'" '+check+'>';
                            rating_select_mb = rating_select_mb+'<span class="checkmark"></span><div class="count">('+data.filter.rating[r].length+')</div></label></li>';
                        } catch (error) { }
                       
                   }
                   document.getElementById('show_rating').innerHTML = rating_select; 
                   document.getElementById('show_rating_mb').innerHTML = rating_select_mb; 

                   var calen_select = '';
                   var calen_select_mb = '';
                   for(let d in data.filter.calendar){
                        try {
                            let go = data_type.calen_start.find(z=>z.id == d*1);
                            let check = type_data.calen_start.includes(d*1)?'checked':'';
                            if(go){
                                calen_select = calen_select+'<li><label class="check-container">'+go.holiday;
                                calen_select = calen_select+'<input type="checkbox" name="calen_start" id="calen_start'+d*1+'" onclick="Check_filter('+d*1+',`calen_start`)" value="'+d+'" '+check+'>';
                                calen_select = calen_select+'<span class="checkmark"></span><div class="count">('+data.filter.calendar[d].length+')</div></label></li>';

                                calen_select_mb = calen_select_mb+'<li><label class="check-container">'+go.holiday;
                                calen_select_mb = calen_select_mb+'<input type="checkbox" name="calen_start" id="calen_start_mb'+d+'" onclick="Check_filter('+d+',`calen_start`)" value="'+d+'" '+check+'>';
                                calen_select_mb = calen_select_mb+'<span class="checkmark"></span><div class="count">('+data.filter.calendar[d].length+')</div></label></li>';
                            }
                          
                        } catch (error) {  }
                   }
                   
                   if(calen_select == ''){
                        $('#hide_calen').hide();  
                   }else{
                        $('#hide_calen').show();  
                   }

                   if(calen_select_mb == ''){
                        $('#hide_calen_mb').hide();  
                   }else{
                        $('#hide_calen_mb').show();  
                   }
                   document.getElementById('show_calen').innerHTML = calen_select; 
                   document.getElementById('show_calen_mb').innerHTML = calen_select_mb; 
                  
                   Swal.close();
               },
               error : function(){
                Swal.close();
               }
           });
           readMore();
       }
       
       function UncheckdDay (tid){
           if(active_day){
               $('#day'+active_day).prop('checked', false);
           }
           active_day = active_day==tid?null:tid ;
           Send_search();
       }
       
       async function UncheckdPrice (tid){
       
           if(tid == 7){
               if(document.getElementById('price'+tid).checked || document.getElementById('price_mb'+tid).checked){
                   type_data['price'] = new Array();
                   for(x=1;x<7;x++){
                       if( document.getElementById('price'+x) || document.getElementById('price_mb'+x)){
                           document.getElementById('price'+x).checked = true;
                           document.getElementById('price_mb'+x).checked = true;
                           // before.push(x);
                           type_data['price'].push(x);
                       }
                       
                   }
               }else{
                   type_data['price'] = new Array();
                   for(x=1;x<7;x++){
                       if(document.getElementById('price'+x) || document.getElementById('price_mb'+x)){
                           document.getElementById('price'+x).checked = false;
                           document.getElementById('price_mb'+x).checked = false;
                       }
                       
                   }
               }
           }else{
               if(document.getElementById('price'+tid).checked == true || document.getElementById('price_mb'+tid).checked == true){
                   type_data['price'].push(tid);
               }else{
                   var index = type_data['price'].indexOf(tid);
                   type_data['price'].splice(index,1);
               }
           }
           SelectFilter();
           var start_data = document.getElementById('s_date').value;
           var end_data = document.getElementById('e_date').value;
           var start_data_mb = document.getElementById('s_date_mb').value;
           var end_data_mb = document.getElementById('e_date_mb').value;
           let payload = {
               tour_id:document.getElementById('tour_id_data').value,
               data:type_data,
               start_date: start_data,
               end_date: end_data,
               start_date_mb: start_data_mb,
               end_date_mb: end_data_mb,
               calen_id : document.getElementById('calen_id').value,
               orderby:document.getElementById('orderby_data').value,
               _token: '{{csrf_token()}}',
               slug:document.getElementById('slug').value,
           }
           Swal.fire({
                title: "Now loading",
                timerProgressBar: true,
                didOpen: () => {
                        Swal.showLoading();
                },
            });
           $.ajax({
               type: 'POST',
               url: '{{url("/filter-oversea")}}',
               data: payload,
               success: function (data) {
                   document.getElementById('show_search').innerHTML = data.tour_list;
                   document.getElementById('show_grid').innerHTML = data.tour_grid;
                   document.getElementById('show_count').innerHTML = "พบ "+data.count_pe+" รายการ";
                   var price_select = '';
                   var price_select_mb = '';
                   var price_count = 0;
                      
                   for(let p in data.filter.price){
                        try {
                            let check = type_data.price.includes(p*1)?'checked':'';
                            price_select = price_select+'<li><label class="check-container">'+length_price[p];
                            price_select = price_select+'<input type="checkbox" name="price" id="price'+p+'" onclick="Check_filter('+p+',`price`)" value="'+p+'" '+check+'>';
                            price_select = price_select+'<span class="checkmark"></span><div class="count">('+data.filter.price[p].length+')</div></label></li>';
                            price_count++;

                            price_select_mb = price_select_mb+'<li><label class="check-container">'+length_price[p];
                            price_select_mb = price_select_mb+'<input type="checkbox" name="price" id="price_mb'+p+'" onclick="Check_filter('+p+',`price`)" value="'+p+'" '+check+'>';
                            price_select_mb = price_select_mb+'<span class="checkmark"></span><div class="count">('+data.filter.price[p].length+')</div></label></li>';
                        } catch (error) { }  
                   }
                   document.getElementById('show_price').innerHTML = price_select; 
                   document.getElementById('show_price_mb').innerHTML = price_select_mb;    
                   if(price_count > 1){
                       $('#show_total').show();  
                       $('#show_total_mb').show(); 
                   }else{
                       $('#show_total').hide();  
                       $('#show_total_mb').hide(); 
                   }
                   var day_select = '';
                   var day_select_mb = '';
                   for(let d in data.filter.day){
                        try {
                            let check = type_data.day.includes(d*1)?'checked':'';
                            day_select = day_select+'<li><label class="check-container">'+d+' วัน';
                            day_select = day_select+'<input type="checkbox" name="day" id="day'+d+'" onclick="Check_filter('+d+',`day`)" value="'+d+'" '+check+'>';
                            day_select = day_select+'<span class="checkmark"></span><div class="count">('+data.filter.day[d].length+')</div></label></li>';
                        
                            day_select_mb = day_select_mb+'<li><label class="check-container">'+d+' วัน';
                            day_select_mb = day_select_mb+'<input type="checkbox" name="day" id="day_mb'+d+'" onclick="Check_filter('+d+',`day`)" value="'+d+'" '+check+'>';
                            day_select_mb = day_select_mb+'<span class="checkmark"></span><div class="count">('+data.filter.day[d].length+')</div></label></li>';
                        } catch (error) { }
                      
                   }
                   document.getElementById('show_day').innerHTML = day_select;
                   document.getElementById('show_day_mb').innerHTML = day_select_mb; 

                   var month_select = '';
                   var month_select_mb = '';
                   for(let y in data.filter.year){
                        try {
                                month_select = month_select+'<li>'+y+'</li>';
                                for(let m in data.filter.year[y]){
                                    let value_m = m < 10 ?'0'+m+y:m+y;
                                    let check = type_data.month_fil.includes(value_m)?'checked':'';
                                    month_select = month_select+'<li><label class="check-container">'+month_data[m];
                                    month_select = month_select+'<input type="checkbox" name="month_fil" id="month_fil'+m+'" onclick="Check_filter(`'+value_m+'`,`month_fil`)" value="'+value_m+'" '+check+'>';
                                    month_select = month_select+'<span class="checkmark"></span><div class="count">('+data.filter.year[y][m].length+')</div></label></li>';
                                
                                    month_select_mb = month_select_mb+'<li><label class="check-container">'+month_data[m];
                                    month_select_mb = month_select_mb+'<input type="checkbox" name="month_fil" id="month_fil_mb'+m+'" onclick="Check_filter(`'+value_m+'`,`month_fil`)" value="'+value_m+'" '+check+'>';
                                    month_select_mb = month_select_mb+'<span class="checkmark"></span><div class="count">('+data.filter.year[y][m].length+')</div></label></li>';
                                }
                        } catch (error) {  }
                   }
                   document.getElementById('show_month').innerHTML = month_select;
                   document.getElementById('show_month_mb').innerHTML = month_select_mb;

                   var city_select = '';
                   var city_select_mb = '';
                   for(let c in data.filter.city){
                        try {
                            let num_tour = 0;
                            for(let y in data.period){
                                if(data.period[y].city_id.includes(data.filter.city[c])){
                                    num_tour++;
                                }
                            }
                            if(c <= 9){
                                let go = data_type.city.find(z=>z.id == data.filter.city[c]);
                                let check = type_data.city.includes(data.filter.city[c]*1)?'checked':'';
                                let name_city = go.city_name_th?go.city_name_th:go.city_name_en;
                                if(go){
                                    city_select = city_select+'<li><label class="check-container">'+name_city ;
                                    city_select = city_select+'<input type="checkbox" name="city" id="city'+go.id+'" onclick="Check_filter('+go.id+',`city`)" value="'+go.id+'" '+check+'>';
                                    city_select = city_select+'<span class="checkmark"></span><div class="count">('+num_tour+')</div></label></li>';
                                    
                                    city_select_mb = city_select_mb+'<li><label class="check-container">'+name_city ;
                                    city_select_mb = city_select_mb+'<input type="checkbox" name="city" id="city_mb'+go.id+'" onclick="Check_filter('+go.id+',`city`)" value="'+go.id+'" '+check+'>';
                                    city_select_mb = city_select_mb+'<span class="checkmark"></span><div class="count">('+num_tour+')</div></label></li>';
                                }
                            
                            }else{
                                let go = data_type.city.find(z=>z.id == data.filter.city[c]);
                                let check = type_data.city.includes(data.filter.city[c]*1)?'checked':'';
                                let name_city = go.city_name_th?go.city_name_th:go.city_name_en;
                                if(go){
                                    city_select = city_select+'<div id="moreprovince" class="collapse">';
                                    city_select = city_select+'<li><label class="check-container">'+name_city ;
                                    city_select = city_select+'<input type="checkbox" name="city" id="city'+go.id+'" onclick="Check_filter('+go.id+',`city`)" value="'+go.id+'" '+check+'>';
                                    city_select = city_select+'<span class="checkmark"></span><div class="count">('+num_tour+')</div></label></li>';
                                    city_select = city_select+'</div>';

                                    city_select_mb = city_select_mb+'<div id="moreprovince" class="collapse">';
                                    city_select_mb = city_select_mb+'<li><label class="check-container">'+name_city ;
                                    city_select_mb = city_select_mb+'<input type="checkbox" name="city" id="city_mb'+go.id+'" onclick="Check_filter('+go.id+',`city`)" value="'+go.id+'" '+check+'>';
                                    city_select_mb = city_select_mb+'<span class="checkmark"></span><div class="count">('+num_tour+')</div></label></li>'; 
                                    city_select_mb = city_select_mb+'</div>';
                                }
                            }
                        } catch (error) { }
                   }
                   if(data.filter.city.length > 9){ 
                       city_select = city_select+'<a data-bs-toggle="collapse" data-bs-target="#moreprovince" class="seemore"> ดูเพิ่มเติม</a>';
                       city_select_mb = city_select_mb+'<a data-bs-toggle="collapse" data-bs-target="#moreprovince" class="seemore"> ดูเพิ่มเติม</a>';
                   }
                   document.getElementById('show_city').innerHTML = city_select;
                   document.getElementById('show_city_mb').innerHTML = city_select_mb;

                   var airline_select = '';
                   var airline_select_mb = '';
                   var airline_count = 0;
                    for(let a in data.filter.airline){
                        try {
                            if(a){
                                airline_count++
                            }
                            if(airline_count <= 10){
                                let go = data_type.airline.find(z=>z.id == a);
                                let check = type_data.airline.includes(a*1)?'checked':'';
                                if(go){
                                    airline_select = airline_select+'<li><label class="check-container">';
                                    if(go.image){
                                        airline_select = airline_select+'<img src="/'+go.image+'" alt=""> '+go.travel_name;
                                    }else{
                                        airline_select = airline_select+go.travel_name;
                                    }
                                    airline_select = airline_select+'<input type="checkbox" name="airline" id="airline'+a+'" onclick="Check_filter('+a+',`airline`)" value="'+a+'" '+check+'>';
                                    airline_select = airline_select+'<span class="checkmark"></span><div class="count">('+data.filter.airline[a].length+')</div></label></li>';
                                
                                    airline_select_mb = airline_select_mb+'<li><label class="check-container">';
                                    if(go.image){
                                        airline_select_mb = airline_select_mb+'<img src="/'+go.image+'" alt=""> '+go.travel_name;
                                    }else{
                                        airline_select_mb = airline_select_mb+go.travel_name;
                                    }
                                    airline_select_mb = airline_select_mb+'<input type="checkbox" name="airline" id="airline_mb'+a+'" onclick="Check_filter('+a+',`airline`)" value="'+a+'" '+check+'>';
                                    airline_select_mb = airline_select_mb+'<span class="checkmark"></span><div class="count">('+data.filter.airline[a].length+')</div></label></li>';
                                }
                            }else{
                                let go = data_type.airline.find(z=>z.id == a);
                                let check = type_data.airline.includes(a*1)?'checked':'';
                                if(go){
                                    airline_select = airline_select+'<div id="moreair" class="collapse"><li><label class="check-container">';
                                    if(go.image){
                                        airline_select = airline_select+'<img src="/'+go.image+'" alt=""> '+go.travel_name;
                                    }else{
                                        airline_select = airline_select+go.travel_name;
                                    }
                                    airline_select = airline_select+'<input type="checkbox" name="airline" id="airline'+a+'" onclick="Check_filter('+a+',`airline`)" value="'+a+'" '+check+'>';
                                    airline_select = airline_select+'<span class="checkmark"></span><div class="count">('+data.filter.airline[a].length+')</div></label></li></div>';
                                
                                    airline_select_mb = airline_select_mb+'<div id="moreair" class="collapse"><li><label class="check-container">';
                                    if(go.image){
                                        airline_select_mb = airline_select_mb+'<img src="/'+go.image+'" alt=""> '+go.travel_name;
                                    }else{
                                        airline_select_mb = airline_select_mb+go.travel_name;
                                    }
                                    airline_select_mb = airline_select_mb+'<input type="checkbox" name="airline" id="airline_mb'+a+'" onclick="Check_filter('+a+',`airline`)" value="'+a+'" '+check+'>';
                                    airline_select_mb = airline_select_mb+'<span class="checkmark"></span><div class="count">('+data.filter.airline[a].length+')</div></label></li></div>';
                                }
                            }      
                        } catch (error) { }
                    }
                    if(airline_count > 10){
                            airline_select = airline_select+'<a data-bs-toggle="collapse" data-bs-target="#moreair" class="seemore"> ดูเพิ่มเติม</a>';
                            airline_select_mb = airline_select_mb+'<a data-bs-toggle="collapse" data-bs-target="#moreair" class="seemore"> ดูเพิ่มเติม</a>';
                    } 
                   document.getElementById('show_air').innerHTML = airline_select; 
                   document.getElementById('show_air_mb').innerHTML = airline_select_mb;

                   var rating_select = '';
                   var rating_select_mb = '';
                   for(let r in data.filter.rating){
                        try {
                            let check = type_data.rating.includes(r*1)?'checked':'';
                            rating_select = rating_select+'<li><label class="check-container"><div class="rating">';
                            if(r*1 == 0){
                                rating_select = rating_select+'ไม่มีระดับดาวที่พัก';
                            }else{
                                for(n=1;n<=r*1;n++){
                                    rating_select = rating_select+'<i class="bi bi-star-fill"></i>';
                                }     
                            }                         
                            rating_select = rating_select+'</div><input type="checkbox" name="rating" id="rating'+r*1+'" onclick="Check_filter('+r*1+',`rating`)" value="'+r*1+'" '+check+'>';
                            rating_select = rating_select+'<span class="checkmark"></span><div class="count">('+data.filter.rating[r].length+')</div></label></li>';
                        
                            rating_select_mb = rating_select_mb+'<li><label class="check-container"><div class="rating">';
                            if(r*1 == 0){
                                rating_select_mb = rating_select_mb+'ไม่มีระดับดาวที่พัก';
                            }else{
                                for(n=1;n<=r*1;n++){
                                    rating_select_mb = rating_select_mb+'<i class="bi bi-star-fill"></i>';
                                }     
                            }                         
                            rating_select_mb = rating_select_mb+'</div><input type="checkbox" name="rating" id="rating_mb'+r*1+'" onclick="Check_filter('+r*1+',`rating`)" value="'+r*1+'" '+check+'>';
                            rating_select_mb = rating_select_mb+'<span class="checkmark"></span><div class="count">('+data.filter.rating[r].length+')</div></label></li>';
                        } catch (error) {}
                   }
                   document.getElementById('show_rating').innerHTML = rating_select; 
                   document.getElementById('show_rating_mb').innerHTML = rating_select_mb; 

                   var calen_select = '';
                   var calen_select_mb = '';
                   for(let d in data.filter.calendar){
                        try {
                            let go = data_type.calen_start.find(z=>z.id == d*1);
                            let check = type_data.calen_start.includes(d*1)?'checked':'';
                            if(go){
                                calen_select = calen_select+'<li><label class="check-container">'+go.holiday;
                                calen_select = calen_select+'<input type="checkbox" name="calen_start" id="calen_start'+d*1+'" onclick="Check_filter('+d*1+',`calen_start`)" value="'+d+'" '+check+'>';
                                calen_select = calen_select+'<span class="checkmark"></span><div class="count">('+data.filter.calendar[d].length+')</div></label></li>';

                                calen_select_mb = calen_select_mb+'<li><label class="check-container">'+go.holiday;
                                calen_select_mb = calen_select_mb+'<input type="checkbox" name="calen_start" id="calen_start_mb'+d+'" onclick="Check_filter('+d+',`calen_start`)" value="'+d+'" '+check+'>';
                                calen_select_mb = calen_select_mb+'<span class="checkmark"></span><div class="count">('+data.filter.calendar[d].length+')</div></label></li>';
                            }
                        } catch (error) {}
                   }

                   if(calen_select == ''){
                        $('#hide_calen').hide();  
                   }else{
                        $('#hide_calen').show();  
                   }

                   if(calen_select_mb == ''){
                        $('#hide_calen_mb').hide();  
                   }else{
                        $('#hide_calen_mb').show();  
                   }
                   
                   document.getElementById('show_calen').innerHTML = calen_select; 
                   document.getElementById('show_calen_mb').innerHTML = calen_select_mb; 
                   
                   Swal.close();
               },
               error : function(){
                Swal.close();
               }
           });
           readMore();
           // await Send_price(type_data['price']);
           // Send_search();
           // if(active_price){
           //     $('#price'+active_price).prop('checked', false);
           // }
           // active_price = active_price==tid?null:tid ;
           // Send_search();
       }

       function UncheckdCountry (tid){
           if(active_country){
               $('#country'+active_country).prop('checked', false);
           }
           active_country = active_country==tid?null:tid ;
           Send_search();
       }
       function UncheckdCity (){
               // var check_data = document.getElementById('city_total').checked;
               // for(let cid in check_city){
               //     document.getElementById('city'+check_city[cid]).checked = check_data;
               //     if(type_data['city'].includes(check_city[cid])){
               //         var index = type_data['city'].indexOf(check_city[cid]);
               //         type_data['city'].splice(index,1);
               //     }else{
               //         type_data['city'].push(check_city[cid]);
               //     }
               // }
               // SelectFilter();
               // console.log(type_data)
           // if(active_city){
           //     $('#city'+active_city).prop('checked', false);
           // }
           // active_city = active_city==tid?null:tid ;
           // Send_search();
       }
       function UncheckdAirline (tid){
           if(active_airline){
               $('#airline'+active_airline).prop('checked', false);
           }
           active_airline = active_airline==tid?null:tid ;
           Send_search();
       }
       function UncheckdRating (tid){
           if(active_rating){
               $('#rating'+active_rating).prop('checked', false);
           }
           active_rating = active_rating==tid?null:tid ;
           Send_search();
       }
       
       async function Send_search(){
           check_date();
           var form = $('#searchForm')[0];
           var data = new FormData(form);
           var start = document.getElementById('s_date').value;
           var end = document.getElementById('e_date').value;
           var start_mb = document.getElementById('s_date_mb').value;
           var end_mb = document.getElementById('e_date_mb').value;
                   await $.ajax({
                           type: 'POST',
                           url: '{{url("/search-filter")}}',
                           data: data,
                           processData: false,
                           contentType: false,
                           cache: false,
                           success: function (datas) {
                               document.getElementById('show_count').innerHTML = "พบ "+datas.period+" รายการ";
                               document.getElementById('show_search').innerHTML = datas.data;
                               if(datas.calen_start_date){
                                   document.getElementById('s_date').value = datas.calen_start_date;
                                   document.getElementById('e_date').value  = datas.calen_end_date;
                                   document.getElementById('s_date_mb').value = datas.calen_start_date;
                                   document.getElementById('e_date_mb').value  = datas.calen_end_date;
                               }
                           }
                       });
               return false;
       }
       function check_date(){
           var start_data = document.getElementById('s_date').value;
           var end_data = document.getElementById('e_date').value;
           var start_data_mb = document.getElementById('s_date_mb').value;
           if(start_data || end_data || start_data_mb ){
               $('#hide_month').hide();
               $('#hide_month_mb').hide();
           }else{
               $('#hide_month').show();
               $('#hide_month_mb').show();
           }
       }
       function check_month(value){
           if(value != 0){
               $('#hide_date').hide();
               $('#hide_date_mb').hide();
           }else{
               $('#hide_date').show();
               $('#hide_date_mb').show();
           }
           
       }
       check_date();
       function Search_airline(){
           var air_value = document.getElementById('search_airline').value;
           if(air_value != ''){
               var air_id = document.getElementById('airline_id').value;
               var air_num = document.getElementById('airline_num').value;
                   $.ajax({
                   type: 'POST',
                   url: '{{url("/search-airline")}}',
                   data:  {
                       _token: '{{csrf_token()}}',
                       text:air_value,
                       id:air_id,
                       num:air_num,
                   },
                   success: function (datas) {
                       if(datas){
                           document.getElementById('show_air').innerHTML = datas;
                           document.getElementById('show_air_mb').innerHTML = datas;
                       }else{
                           document.getElementById('show_air').innerHTML = "<center><strong class='text-danger'>ไม่พบผลการค้นหา</strong></center>";
                           document.getElementById('show_air_mb').innerHTML = "<center><strong class='text-danger'>ไม่พบผลการค้นหา</strong></center>";
                           // document.getElementById('search_airline').value = null ;
                       }
                   }
               });
           }else{
               window.location.reload();
           }
       }
       function Search_city(){
           var city_value = document.getElementById('city_search').value;
           if(city_value != ''){
               var city_id = document.getElementById('city_data').value;
               var city_num = document.getElementById('city_num').value;
                   $.ajax({
                   type: 'POST',
                   url: '{{url("/search-city")}}',
                   data:  {
                       _token: '{{csrf_token()}}',
                       text:city_value,
                       id:city_id,
                       num:city_num,
                   },
                   success: function (datas) {
                       if(datas){
                           document.getElementById('show_city').innerHTML = datas;
                           document.getElementById('show_city_mb').innerHTML = datas;
                       }else{
                           document.getElementById('show_city').innerHTML = "<center><strong class='text-danger'>ไม่พบผลการค้นหา</strong></center>";
                           document.getElementById('show_city_mb').innerHTML = "<center><strong class='text-danger'>ไม่พบผลการค้นหา</strong></center>";
                       }
                   }
               });
           }else{
               window.location.reload();
           }
           // document.getElementById('city_search').value = null ;
       }
       async function Send_price(p){
               $.ajax({
                   type: 'GET',
                   url: '{{url("/search-price")}}',
                   data: {
                       price: p,
                       start_date:document.getElementById('start_date').value,
                       end_date:document.getElementById('end_date').value,
                       slug:document.getElementById('slug').value,
                   },
                   success: function (data) {
                       document.getElementById('show_day').innerHTML = data;
                   }
               });
               // var form = $('#searchForm')[0];
               // var data = new FormData(form);
               // await $.ajax({
               //     type: 'POST',
               //     url: '{{url("/search-price")}}',
               //     data: p,
               //     processData: false,
               //     contentType: false,
               //     cache: false,
               //     success: function (datas) {
               //         // document.getElementById('show_count').innerHTML = "พบ "+datas.period+" รายการ";
               //         document.getElementById('show_day').innerHTML = datas;
               //     }
               // });
               return false;
       }
       function readMore(){
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
<script>
   var check_start = '{{$search_start}}';
   var check_end = '{{$search_end}}';
   var day = ['วันอาทิตย์','วันจันทร์','วันอังคาร','วันพุธ','วันพฤหัสบดี','วันศุกร์','วันเสาร์'];
   var month = ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.'];
   var month_number = ['01','02','03','04','05','06','07','08','09','10','11','12'];
   
   if(check_start){
       var check_after = new Date(check_start);
   }else{
       var check_after = new Date();
   }
   if(check_end){
       var check_befor = new Date(check_end);
   }else{
       var check_befor = new Date(check_after.valueOf()+86400000);
   }
   // let test = day[check_after.getDay()]+'ที่ '+check_after.getDate()+' '+month[check_after.getMonth()]+' '+(check_after.getFullYear()*1+543)+' | '+day[check_befor.getDay()]+'ที่ '+check_befor.getDate()+' '+month[check_befor.getMonth()]+' '+(check_befor.getFullYear()*1+543);
   // document.getElementById('show_date_select').value = test;
   var strat_show = check_after.getDate()+'  '+month[check_after.getMonth()]+'  '+(check_after.getFullYear()*1+543);
   var strat_select = check_after.getDate()+'/'+month_number[check_after.getMonth()]+'/'+(check_after.getFullYear()*1+543);
   var start_day_show = day[check_after.getDay()];
   var end_show = check_befor.getDate()+'  '+month[check_befor.getMonth()]+'  '+(check_befor.getFullYear()*1+543);
   var end_select = check_befor.getDate()+'/'+month_number[check_befor.getMonth()]+'/'+(check_befor.getFullYear()*1+543);
   var end_day_show = day[check_befor.getDay()];
   var text_s_show = '';
       text_s_show += "<span style='font-size:0.8rem;padding:3px 2px;display:block;color:gray;'>"+strat_show+"</span>";
       text_s_show += "<span style='font-size:0.8rem;padding:3px 2px;display:block;color:gray;'>"+start_day_show+"</span>";
   var text_e_show = '';
       text_e_show += "<span style='font-size:0.8rem;padding:3px 2px;display:block;color:gray;'>"+end_show+"</span>";
       text_e_show += "<span style='font-size:0.8rem;padding:3px 2px;display:block;color:gray;'>"+end_day_show+"</span>";

    if(check_start && check_end){
        document.getElementById('show_select_date').innerHTML = "<li onclick='DeletedDate()'><label class='check-container'>"+strat_select+" ถึง "+end_select+" <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";
        document.getElementById('show_select_date_mb').innerHTML = "<li onclick='DeletedDate()'><label class='check-container'>"+strat_select+" ถึง "+end_select+" <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>"; 
        document.getElementById('show_select_date_mb_all').innerHTML = "<li onclick='DeletedDate()'><label class='check-container'>"+strat_select+" ถึง "+end_select+" <i class='fa fa-times-circle' aria-hidden='true'></i></label></li>";   
    }
   document.getElementById('show_date_calen').innerHTML = text_s_show;
   document.getElementById('show_end_calen').innerHTML = text_e_show;
   document.getElementById('show_date_calen_mb').innerHTML = text_s_show;
   document.getElementById('show_end_calen_mb').innerHTML = text_e_show;
   $('#hide_date_select').hide();
   $('#hide_date_select_mb').hide();

   $(function() {
       $('input[name="daterange"]').daterangepicker({
           opens: 'left',
           minDate: "{{date('m/d/Y')}}"
       }, function(start, end, label) {
           document.getElementById('s_date').value = start.format('YYYY-MM-DD');
           document.getElementById('e_date').value = end.format('YYYY-MM-DD');
           document.getElementById('s_date_mb').value = start.format('YYYY-MM-DD');
           document.getElementById('e_date_mb').value = end.format('YYYY-MM-DD');
           if(start && end){
               Check_filter(start,'start_date',end,'end_date');
               $('#hide_month_mb').hide();
           }
           let y = new Date(start);
           let x = new Date(end);
           let s_show = y.getDate()+'  '+month[y.getMonth()]+'  '+(y.getFullYear()*1+543);
           let e_show = x.getDate()+'  '+month[x.getMonth()]+'  '+(x.getFullYear()*1+543);
           var s_select = y.getDate()+'/'+month_number[y.getMonth()]+'/'+(y.getFullYear()*1+543);
           let e_select = x.getDate()+'/'+month_number[x.getMonth()]+'/'+(x.getFullYear()*1+543);
           let s_day = day[y.getDay()];
           let e_day = day[x.getDay()];
           // document.getElementById('show_date_select').value = test;
           var text_start = '';
               text_start += "<span style='font-size:0.8rem;padding:3px 2px;display:block;'>"+s_show+"</span>";
               text_start += "<span style='font-size:0.8rem;padding:3px 2px;display:block;'>"+s_day+"</span>";
           var text_end = '';
               text_end += "<span style='font-size:0.8rem;padding:3px 2px;display:block;'>"+e_show+"</span>";
               text_end += "<span style='font-size:0.8rem;padding:3px 2px;display:block;'>"+e_day+"</span>";

           document.getElementById('show_select_date').innerHTML = "<li onclick='DeletedDate()'><label class='check-container'>"+s_select+" ถึง "+e_select+"<i class='fa fa-times-circle' aria-hidden='true'></i></label></li>"; 
           document.getElementById('show_date_calen').innerHTML = text_start;
           document.getElementById('show_end_calen').innerHTML = text_end;

           document.getElementById('show_select_date_mb_all').innerHTML = "<li onclick='DeletedDate()'><label class='check-container'>"+s_select+" ถึง "+e_select+"<i class='fa fa-times-circle' aria-hidden='true'></i></label></li>"; 
           document.getElementById('show_select_date_mb').innerHTML = "<li onclick='DeletedDate()'><label class='check-container'>"+s_select+" ถึง "+e_select+"<i class='fa fa-times-circle' aria-hidden='true'></i></label></li>"; 
           document.getElementById('show_date_calen_mb').innerHTML = text_start;
           document.getElementById('show_end_calen_mb').innerHTML = text_end;

           $('#show_date_calen').show();
           $('#show_end_calen').show();
           $('#hide_date_select').hide();

           $('#show_date_calen_mb').show();
           $('#show_end_calen_mb').show();
           $('#hide_date_select_mb').hide();
       });
       $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
           document.getElementById('s_date').value = null;
           document.getElementById('e_date').value = null;
           document.getElementById('s_date_mb').value = null;
           document.getElementById('e_date_mb').value = null;
           if(check_start || check_end){
               document.getElementById('hide_date_select').value = "{{date('m/d/Y')}} - {{date('m/d/Y',strtotime('+1 day'))}}";
               document.getElementById('hide_date_select_mb').value = "{{date('m/d/Y')}} - {{date('m/d/Y',strtotime('+1 day'))}}";
           }else{
               document.getElementById('hide_date_select').value = "{{date('m/d/Y')}} - {{date('m/d/Y',strtotime('+1 day'))}}";
               document.getElementById('hide_date_select_mb').value = "{{date('m/d/Y')}} - {{date('m/d/Y',strtotime('+1 day'))}}";
           }

           Check_filter(null,'start_date',null,'end_date');
           $('#hide_month_mb').show();
           let y = new Date("{{date('m/d/Y')}}");
           let x = new Date("{{date('m/d/Y',strtotime('+1 day'))}}");
           let s_show = y.getDate()+'  '+month[y.getMonth()]+'  '+(y.getFullYear()*1+543);
           let e_show = x.getDate()+'  '+month[x.getMonth()]+'  '+(x.getFullYear()*1+543);
           let s_day = day[y.getDay()];
           let e_day = day[x.getDay()];
           
           var text_start1 = '';
               text_start1 += "<span style='font-size:0.8rem;padding:3px 2px;display:block;color:gray;'>"+s_show+"</span>";
               text_start1 += "<span style='font-size:0.8rem;padding:3px 2px;display:block;color:gray;'>"+s_day+"</span>";
           var text_end2 = '';
               text_end2 += "<span style='font-size:0.8rem;padding:3px 2px;display:block;color:gray;'>"+e_show+"</span>";
               text_end2 += "<span style='font-size:0.8rem;padding:3px 2px;display:block;color:gray;'>"+e_day+"</span>";
           document.getElementById('show_date_calen').innerHTML = text_start1;
           document.getElementById('show_end_calen').innerHTML = text_end2;

           document.getElementById('show_date_calen_mb').innerHTML = text_start1;
           document.getElementById('show_end_calen_mb').innerHTML = text_end2;
          

           $('#show_date_calen').show();
           $('#show_end_calen').show();
           $('#hide_date_select').hide();
           
           $('#show_date_calen_mb').show();
           $('#show_end_calen_mb').show();
           $('#hide_date_select_mb').hide();
       });
       $('input[name="daterange"]').on('hide.daterangepicker', function(ev, picker) {
           $('#show_date_calen').show();
           $('#show_end_calen').show();
           $('#hide_date_select').hide();

           $('#show_date_calen_mb').show();
           $('#show_end_calen_mb').show();
           $('#hide_date_select_mb').hide();

           var start_data = document.getElementById('s_date').value;
           var end_data = document.getElementById('e_date').value;
           if(start_data.length == 0 && end_data.length == 0){
               document.getElementById('hide_date_select').value = "{{date('m/d/Y')}} - {{date('m/d/Y',strtotime('+1 day'))}}";
           }
       });
   });
   function show_datepicker() {
       $('#show_date_calen').hide();
       $('#show_end_calen').hide();
       $('#hide_date_select').show();
       document.getElementById("hide_date_select").click();
   }
   function show_datepicker_mb() {
       $('#show_date_calen_mb').hide();
       $('#show_end_calen_mb').hide();
       $('#hide_date_select_mb').show();
       document.getElementById("hide_date_select_mb").click();
   }
   function DeletedDate(){
            document.getElementById('show_select_date').innerHTML = '';
            document.getElementById('show_select_date_mb').innerHTML = '';
            document.getElementById('show_select_date_mb_all').innerHTML = '';
            document.getElementById('s_date').value = null;
            document.getElementById('e_date').value = null;
            document.getElementById('s_date_mb').value = null;
            document.getElementById('e_date_mb').value = null;
           Check_filter(null,'start_date',null,'end_date');
           let y = new Date("{{date('m/d/Y')}}");
           let x = new Date("{{date('m/d/Y',strtotime('+1 day'))}}");
           let s_show = y.getDate()+'  '+month[y.getMonth()]+'  '+(y.getFullYear()*1+543);
           let e_show = x.getDate()+'  '+month[x.getMonth()]+'  '+(x.getFullYear()*1+543);
           let s_day = day[y.getDay()];
           let e_day = day[x.getDay()];
           
           var text_start1 = '';
               text_start1 += "<span style='font-size:0.8rem;padding:3px 2px;display:block;color:gray;'>"+s_show+"</span>";
               text_start1 += "<span style='font-size:0.8rem;padding:3px 2px;display:block;color:gray;'>"+s_day+"</span>";
           var text_end2 = '';
               text_end2 += "<span style='font-size:0.8rem;padding:3px 2px;display:block;color:gray;'>"+e_show+"</span>";
               text_end2 += "<span style='font-size:0.8rem;padding:3px 2px;display:block;color:gray;'>"+e_day+"</span>";
           document.getElementById('hide_date_select').value = "{{date('m/d/Y')}} - {{date('m/d/Y',strtotime('+1 day'))}}";
           document.getElementById('show_date_calen').innerHTML = text_start1;
           document.getElementById('show_end_calen').innerHTML = text_end2;
   }
   
</script>
<script>
   $(document).ready(function () {
       $(function () {
           $('.datepicker').datepicker({
               dateFormat: 'dd/mm/yy',
               showButtonPanel: false,
               changeMonth: false,
               changeYear: false,
               /*showOn: "button",
                buttonImage: "images/calendar.gif",
                buttonImageOnly: true,
                minDate: '+1D',
                maxDate: '+3M',*/
               inline: true
           });
       });
       $.datepicker.regional['es'] = {
           closeText: 'Cerrar',
           prevText: '<Ant',
           nextText: 'Sig>',
           currentText: 'Hoy',
           monthNames: ['January', 'Februaly', 'March', 'April', 'May', 'June', 'July', 'August',
               'September', 'October', 'November', 'December'
           ],
           monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct',
               'Nov', 'Dec'
           ],
           dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Sathurday'],
           dayNamesShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thr', 'Fri', 'Sat'],
           dayNamesMin: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
           weekHeader: 'Sm',
           dateFormat: 'dd/mm/yy',
           firstDay: 1,
           isRTL: false,
           showMonthAfterYear: false,
           yearSuffix: ''
       };
       $.datepicker.setDefaults($.datepicker.regional['es']);
   });
</script>