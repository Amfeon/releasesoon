$(".showUpdate li").css('display',"none");
var $letter;
$('input').keyup(function(){
    $letter = $('input').val();
    if($letter.length>=3){
        searchMovie($letter);
    }
});
function searchMovie($temp){
    $(".showUpdate li:contains("+ $temp +")").each(function(){
        $(this).css("display","block");
      //  console.log($(this).html());
        //console.log($(this).html());
    });
}