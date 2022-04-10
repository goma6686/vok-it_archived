<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" type="image/png" href="../../img/VU-logotype.png" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@800&display=swap" rel="stylesheet"> 

    <!-- Takes the title and any extra head code if there is any -->
    <title>@yield('title')</title>
    <link rel="stylesheet" type="text/css" href="{{ url('/css/style.css') }}" />
    @hasSection('head')
      @yield('head')
    @endif
  </head>
  <body>
    @include('partials.navigation')
    @yield('body')

    <!-- start feedback button -->
    <div id="feedbackcontainer" style="position: fixed; right: 0px; bottom: 80px; background: none; height: 120px; width: 40px; font-size: 14px; font-family: Arial, sans-serif;">
      <button id="feedbackbutton" style="transform: rotate(-90.0deg); background-color: #78003e !important; border-radius: 4px; width: 120px; border: solid 1px #e3e3e3; letter-spacing: 1; padding: 5px 5px; color: #FFF; font-weight: bold; cursor: pointer; float: right; margin-top: 45px; margin-right: -45px" onclick="extendFeedback();">{{ __('Atsiliepimas') }}</button>
      <div id="feedbackform" style="display: none; position: relative; top: -70px; left: 5px">
        <!--<input type="text" id="feedbackemail" name="email" placeholder="your@email.com" style="width: 290px; border-radius: 3px; border: 1px solid #CCC;  padding: 2px; margin-bottom: 5px;" /><br>-->
        <textarea id="feedbackmessage" style="width: 290px; height: 150px; border: 1px solid #CCC; border-radius: 3px; padding: 2px; margin-bottom: 5px; font-size: 12px; font-family: Arial, sans-serif;"></textarea><br>
        <button onclick="submitFeedback();" style="padding: 3px; background-color: #78003e !important; border-radius: 4px; width: 120px; border: solid 1px #e3e3e3; color: #FFF; font-weight: bold; cursor: pointer;">{{ __('Siųsti') }}</button>
      </div>
    </div>

    <script>
    var feedbackform_url = '/feedback';
    var feedbackform_emailsubject = 'Feedback Form';
    var csrfToken = "{{ csrf_token() }}";
    var feedbackform_fc = document.getElementById('feedbackcontainer');
    var feedbackform_fb = document.getElementById('feedbackbutton');
    var feedbackform_ff = document.getElementById('feedbackform');
    //var feedbackform_fe = document.getElementById('feedbackemail');
    var feedbackform_fm = document.getElementById('feedbackmessage');
  

    function extendFeedback() {
      feedbackform_fc.style.width = '320px';
      feedbackform_fc.style.height = '240px';
      feedbackform_fc.style.bottom = '5px';
      feedbackform_fb.style.marginRight = '272px'
      feedbackform_ff.style.display = 'block';
      feedbackform_fb.onclick = function() { closeFeedback(); }
    }
    function closeFeedback() {
      feedbackform_fc.style.width = '40px';
      feedbackform_fc.style.height = '120px';
      feedbackform_fc.style.bottom = '80px';
      feedbackform_fb.style.marginRight = '-45px'
      feedbackform_ff.style.display = 'none';
      feedbackform_fb.onclick = function() { extendFeedback(); }
    }
    function submitFeedback() {
      //if (feedbackform_fe.value.indexOf('@') == -1) { alert('You need to enter a valid email address'); return; }
      feedbackform_ff.innerHTML = '<p style="text-align: center; font-size: 16px; margin-top: 20px;">{{ __('Atsiliepimas išsiųstas') }}</p>';
      setTimeout(function() { closeFeedback(); }, 2000);

      // Ajax Post
      var feedbackform_lookup = "subject=" + encodeURIComponent(feedbackform_emailsubject) + '&message=' + encodeURIComponent(feedbackform_fm.value) + '&page=' + window.top.document.location + '&_token=' + csrfToken; // $_POST['email']
      if (window.XMLHttpRequest) { feedbackform_xmlhttp=new XMLHttpRequest(); } else { feedbackform_xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); }
      feedbackform_xmlhttp.onreadystatechange=function() {
        if (feedbackform_xmlhttp.readyState==4 && feedbackform_xmlhttp.status==200) {
          console.log(feedbackform_xmlhttp.responseText);
        }
      }   
      feedbackform_xmlhttp.open("POST",feedbackform_url,true);
      //feedbackform_xmlhttp.setRequestHeader("x-csrf-token", "fetch");   
      //feedbackform_xmlhttp.setRequestHeader("csrf-token", "fetch"); 
      feedbackform_xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      //feedbackform_xmlhttp.setRequestHeader('x-csrf-token', csrfToken);         
      feedbackform_xmlhttp.setRequestHeader("Content-length", feedbackform_lookup.length);
      feedbackform_xmlhttp.setRequestHeader("Connection", "close");
      feedbackform_xmlhttp.send(feedbackform_lookup);
    }
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>

  </body>
</html>