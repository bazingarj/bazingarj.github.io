function myFunction(id) {
    var x = document.getElementById(id);
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
        x.previousElementSibling.className += " w3-theme-d1";
    } else { 
        x.className = x.className.replace("w3-show", "");
        x.previousElementSibling.className = 
        x.previousElementSibling.className.replace(" w3-theme-d1", "");
    }
}

// Used to toggle the menu on smaller screens when clicking on the menu button
function openNav() {
    var x = document.getElementById("navMobile");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else { 
        x.className = x.className.replace(" w3-show", "");
    }
}
    
var totalPosts = 0;    
function getPosts(){
    var str = "";
    $.ajax({
        url: "https://www.googleapis.com/blogger/v3/blogs/4493404020514779453/posts?key=AIzaSyCzqQKpYLBXgEdDNGRfUZEXgcqukQQvJXE",
        dataType: "json",
        success: function(result){
            if( typeof result.items !== 'undefined' && result.items.length > 0 ){
                for( var i in result.items ){
                    str += '<div class="post w3-container w3-card-2 w3-white w3-round w3-margin"><br>'+
                                '<a href="'+result.items[i].url+'" rel="nofollow" title="'+result.items[i].title+'" >'+
                                  '<p> <b> '+result.items[i].title+' </b> </p>'+
                                '<hr class="w3-clear">'+
                                '<p> '+result.items[i].content+' </p>'+
                                    ' </a> <a href="'+result.items[i].author.url+'" rel="nofollow" title="'+result.items[i].author.displayName+'"> '+
                                  '<img src="'+result.items[i].author.image.url+'" alt="Avatar" class="w3-left w3-circle w3-margin-right cube-40"> '+result.items[i].author.displayName+' </a>'+
                                  '<span class="w3-right w3-opacity"> '+dateToStr(result.items[i].updated)+' </span>'+
                                  '<br/><br/>'+
                              '</div>'       
                }
                $('#Posts').append(str);
            } else {
                $('#NoPostFound').removeClass('hidden');
            }
        },
        error:function(result){
            $('#NoPostFound').removeClass('hidden');
        },
        complete: function(){ $('#loadingPosts').addClass('hidden'); }
    });    
}
function numberEnding (number) {
  return (number > 1) ? 's' : '';
}
function dateToStr(k) {

    var j = k.split('T');
    //var input_date = j[0]+" "+j[1].split("-")[0];
   //input_date += " UTC";
  // convert times in milliseconds
  var a = j[0].split('-');
  var b = j[1].split(':');
  var input_time_in_ms = new Date(a[0], a[1], a[2], b[0], [1], [2]).getTime();
  var current_time_in_ms = new Date().getTime();
  var elapsed_time = current_time_in_ms - input_time_in_ms;

  var temp = Math.floor(elapsed_time / 1000);
  var years = Math.floor(temp / 31536000);

  if (years) {
      return years + ' year' + numberEnding(years);
  }
    
  var weeks = Math.floor((temp %= 31536000) / 604800);
  if (weeks) {
      if( weeks > 5){
          months = weeks/4.5;
        return parseInt(months) + ' month' + numberEnding(months);  
      } else {
        return weeks + ' week' + numberEnding(weeks);
      }
  }
    
  var days = Math.floor((temp %= 31536000) / 86400);
  if (days) {
      return days + ' day' + numberEnding(days);
  }
  var hours = Math.floor((temp %= 86400) / 3600);
  if (hours) {
      return hours + ' hour' + numberEnding(hours);
  }
  var minutes = Math.floor((temp %= 3600) / 60);
  if (minutes) {
      return minutes + ' minute' + numberEnding(minutes);
  }
  var seconds = temp % 60;
  if (seconds) {
      return seconds + ' second' + numberEnding(seconds);
  }
  return 'just now'; //'just now' //or other string you like;
}
$(document).ready(function(){ getPosts(); });