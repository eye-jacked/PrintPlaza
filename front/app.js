<script src="https://code.jquery.com/jquery-2.2.0.min.js"></script>

$(function () {
  $.ajax({
      url:"api/src/books.php",
      data:{},
      type: "GET",
      dataType: "json",
      success:function(){
          console.log('successful ajax call for GET')
          console.log();
      },
      error:function(){},
      complete:function(){}
  })

    
})