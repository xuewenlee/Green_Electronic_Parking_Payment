$(document).ready(function(){
  $.ajax({
    url:"http://localhost/parkingDB/reports.php",
    method:"GET",
    success:function(data) {
      console.log(data);

      var player = [];
      var score = [];

      for(var i in data){
        player.push("Player " + data[i].playerid)
      }
    },
    error: function(data){
      console.log(data);
    }
  });
});
