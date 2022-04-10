@extends('layouts.layout')
@section('title', 'Vok-IT VU Namai')
@section('body')
  <!-- write body here -->
<div class="container">
  <div id="btnContainer" style="margin-bottom: 15px;">
    <button class="Nbtn active" onclick="filterSelection('all')"> {{__('Rodyti viską')}}</button>
    @foreach($news_categories as $categ)
        @if(strtoupper(app()->getLocale()) == "DE")
          <button class="Nbtn" onclick="filterSelection('{{$categ -> id}}')"> {{$categ -> name_de}}</button>
        @else
          <button class="Nbtn" onclick="filterSelection('{{$categ -> id}}')"> {{$categ -> name}}</button>
        @endif
    @endforeach
  </div>
  <div class="row" id="news" data-masonry='{"percentPosition": true }'>
    @foreach($news as $new)
    <div class="col-sm-6 col-lg-4 mb-4 filterDiv {{ $new -> news_categoryId }}">
      <div class="card p-3">
        <div style="text-align: right; color: #b1bab4;">
          <h6>{{__('Data')}}: {{$new->created_at}}</h6>
        </div>
        @if($new->title_image!=null)
        	<img src="news_images/title_images/{{$new->title_image}}" class="card-img-top">
        @endif
        <div class="card-body">
          <h4 class="card-title text-center">{{$new->news_title}}</h4>
          <h6 class="card-description text-center">{{$new->description}}</h6>
          <div style="text-align: center;">
          <a href="/read/{{ $new -> id }}" class="card-link" style="color:#78003e;">{{__('Skaityti')}}</a>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</div>
<script type="text/javascript">
	filterSelection("all")
	function filterSelection(c) {
	  var x, i;
	  x = document.getElementsByClassName("filterDiv");
	  if (c == "all") c = "";
	  for (i = 0; i < x.length; i++) {
	    RemoveClass(x[i], "Nshow");
	    if (x[i].className.indexOf(c) > -1) AddClass(x[i], "Nshow");
	  }
	}

	function AddClass(element, name) {
	  var i, arr1, arr2;
	  arr1 = element.className.split(" ");
	  arr2 = name.split(" ");
	  for (i = 0; i < arr2.length; i++) {
	    if (arr1.indexOf(arr2[i]) == -1) {element.className += " " + arr2[i];}
	  }
	}

	function RemoveClass(element, name) {
	  var i, arr1, arr2;
	  arr1 = element.className.split(" ");
	  arr2 = name.split(" ");
	  for (i = 0; i < arr2.length; i++) {
	    while (arr1.indexOf(arr2[i]) > -1) {
	      arr1.splice(arr1.indexOf(arr2[i]), 1);     
	    }
	  }
	  element.className = arr1.join(" ");
	}
</script>

@endsection