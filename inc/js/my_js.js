$q=jQuery.noConflict();

$q(document).ready(function($){
  // alert('some msg');

$("select").change(function(){

var sel = $(this).val();
var ajax_url = '/wp-admin/admin-ajax.php';
		$.ajax({
			type : "post",
//			dataType : "json",
			url: ajax_url,
			data : {
				"action": 'sel_option',
				"agent": sel,
				// security: wfmajax.nonce,

			},
			success: function(json) {

var data = JSON.parse(json);

$(".all_blocks").empty();
var str='';

function prArr(arr) {
  var newArr = [];
for( var ArrVal in arr ) {
    var  nArr = arr[ArrVal]; 
    for( var ArrValIn in nArr ) {
str+='<div class="block">';
newArr.push ( nArr[ArrValIn] ) ;
var item = nArr[ArrValIn];
	str+="<a href='"+item.permalink+"'>"+item.post_title+"</a>";
	if(item.thumbnail_url)
	str+="<img src='"+item.thumbnail_url+"' alt=''>";
	str+="<h5>Площадь</h5><p>"+item.flache+"/м²</p>";
	if(item.oprice)
	str+="<h5>Стоимость</h5><p>"+item.fprice+" $</p>";
	if(item.oadress)
	str+="<h5>Адрес</h5><p>"+item.fadress+" $</p>";
	if(item.ojflache)
	str+="<h5>Жилая площадь</h5><p>"+item.fjflache+" $</p>";
	if(item.oetaj!="нет")
	str+="<h5>Этаж</h5><p>"+item.fetaj+"</p>";
str+='</div>';
    }
}
  return str;
}



var html=prArr(data);

console.log( data );

$(".all_blocks").html(html);


                               
			}
		});
		return false;
	});

});
