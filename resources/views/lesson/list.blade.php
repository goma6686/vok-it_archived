@extends('layouts.layout')
@section('title', 'Vok-IT VU Lesson list')

@section('header')
	<link href="/css/lesson.css" rel="stylesheet">
@endsection

@section('body')


	<div class="container" id="lessons">
    <div class="col-6 mb-3">
      <form>
      <input type="text" id="filter" class="form-control" onkeyup="myFunction()" placeholder="{{__('Paieška')}}">
    </form>
    </div>
      
    <div class="row">
      @switch($sort)

      @case("categories")
        @foreach($groups as $groupbox)
        <div class="row col-xl-4 col-md-6 col-sm-12 card-body hideableElement" >
                <h5 class="card-title" style="color:#78003e;"> ~@if($groupbox -> name_de == null)
                    {{ $groupbox -> name}}
                  @elseif((strtoupper(app()->getLocale()))=="DE")
                    {{ $groupbox -> name_de}}
                  @else
                  {{ $groupbox -> name}}
                  @endif  
                  ~</h5>

        @foreach($lessons as $lesson) 
          @if($lesson -> category_id == $groupbox -> id)
          @php
          //$image = preg_grep('~^cover.*\.jpg$~', scandir("pamokos_files/{$lesson->name}/content/images/"));
          //echo $image;
          @endphp
            <div class="card col box-shadow" style="padding: 5px; height: 100%;">
              <img src="../pamokos_files/{{ $lesson -> name}}/content/images/{{ $lesson -> picture }}" class="card-img-top" style="object-fit:fit; display: block; margin-left: auto; margin-right: auto;" alt="{{ $lesson -> picture }}">
              <div class="card-body">
                
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><h5 class="card-title">{{ $lesson -> name }}</h5></li>
                <li class="list-group-item"><a href="../lesson/{{ $lesson -> id }}/" class="card-link" style="color:#78003e;">{{ __('Rodyti') }}</a></li>
                <li class="list-group-item">{{ __('Tema') }}: 
                  @foreach($topics as $topic)
                    @if($topic -> id == $lesson -> topic_id)
                      @if((strtoupper(app()->getLocale()))=="DE")
                        {{ $topic -> name_de}}
                      @else
                      {{ $topic -> name}}
                      @endif
                    @endif
                  @endforeach
                <li class="list-group-item">{{ __('Lygis') }}: 
                @foreach($levels as $level)
                    @if($level -> id == $lesson -> level_id)
                      {{ $level -> name}}
                    @endif
                  @endforeach</li>
        </ul>
        </div>
        @endif
        @endforeach
        </div>
        @endforeach
        <div class="row col-xl-4 col-md-6 col-sm-12 card-body hideableElement" style=" height: 100%;">
          <h5 class="card-title" style="color:#78003e;">{{ __('Nesurūšiuotos pamokos') }}</h5>
        @foreach($lessons as $lesson)
          @if($lesson -> category_id == null)
          <div class="card col" style="padding: 5px;">
              <img src="../pamokos_files/{{ $lesson -> name}}/content/images/{{ $lesson -> picture }}" class="card-img-top" style="object-fit:fit; display: block; margin-left: auto; margin-right: auto;" alt="{{ $lesson -> picture }}">
              <div class="card-body">
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><h5 class="card-title">{{ $lesson -> name }}</h5></li>
                <li class="list-group-item"><a href="../lesson/{{ $lesson -> id }}/" class="card-link" style="color:#78003e;">{{ __('Rodyti') }}</a></li>
                <li class="list-group-item">{{ __('Tema') }}: 
                  @foreach($topics as $topic)
                    @if($topic -> id == $lesson -> topic_id)
                      @if((strtoupper(app()->getLocale()))=="DE")
                        {{ $topic -> name_de}}
                      @else
                      {{ $topic -> name}}
                      @endif
                    @endif
                  @endforeach
                <li class="list-group-item">{{ __('Lygis') }}: 
                @foreach($levels as $level)
                    @if($level -> id == $lesson -> level_id)
                      {{ $level -> name}}
                    @endif
                  @endforeach</li>
              </ul>
            </div>
          
          @endif
        @endforeach
        </div>
      @break

      @case("topics")
        @foreach($groups as $groupbox)
        <div class="row col-xl-4 col-md-6 col-sm-12 card-body hideableElement" id="searchCard" >
                <h5 class="card-title" style="color:#78003e;"> ~@if($groupbox -> name_de == null)
                    {{ $groupbox -> name}}
                  @elseif((strtoupper(app()->getLocale()))=="DE")
                    {{ $groupbox -> name_de}}
                  @else
                  {{ $groupbox -> name}}
                  @endif  
                  ~</h5>

      	@foreach($lessons as $lesson) 
          @if($lesson -> topic_id == $groupbox -> id)
          @php
          //$image = preg_grep('~^cover.*\.jpg$~', scandir("pamokos_files/{$lesson->name}/content/images/"));
          //echo $image;
          @endphp
            <div class="card col box-shadow" style="padding: 5px; height: 100%;">
            	<img src="../pamokos_files/{{ $lesson -> name}}/content/images/{{ $lesson -> picture }}" class="card-img-top" style="object-fit:fit; display: block; margin-left: auto; margin-right: auto;" alt="{{ $lesson -> picture }}">
              <div class="card-body">
                
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><h5 class="card-title">{{ $lesson -> name }}</h5></li>
                <li class="list-group-item"><a href="../lesson/{{ $lesson -> id }}/" class="card-link" style="color:#78003e;">{{ __('Rodyti') }}</a></li>
  		          <li class="list-group-item">{{ __('Kategorija') }}: 
            @foreach($categories as $category)
                    @if($category -> id == $lesson -> category_id)
                      @if((strtoupper(app()->getLocale()))=="DE")
                        {{ $category -> name_de}}
                      @else
                      {{ $category -> name}}
                      @endif
                    @endif
                  @endforeach</li>
		      <li class="list-group-item">{{ __('Lygis') }}: 
          @foreach($levels as $level)
                    @if($level -> id == $lesson -> level_id)
                      {{ $level -> name}}
                    @endif
                  @endforeach</li>
		    </ul>
        </div>
        @endif
        @endforeach
        </div>
        @endforeach
        <div class="row col-xl-4 col-md-6 col-sm-12 card-body hideableElement" style=" height: 100%;">
          <h5 class="card-title" style="color:#78003e;">{{ __('Nesurūšiuotos pamokos') }}</h5>
        @foreach($lessons as $lesson)
          @if($lesson -> topic_id == null)
          <div class="card col" style="padding: 5px;">
              <img src="../pamokos_files/{{ $lesson -> name}}/content/images/{{ $lesson -> picture }}" class="card-img-top" style="object-fit:fit; display: block; margin-left: auto; margin-right: auto;" alt="{{ $lesson -> picture }}">
              <div class="card-body">
                
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><h5 class="card-title">{{ $lesson -> name }}</h5></li>
                <li class="list-group-item"><a href="../lesson/{{ $lesson -> id }}/" class="card-link" style="color:#78003e;">{{ __('Rodyti') }}</a></li>
                <li class="list-group-item">{{ __('Kategorija') }}: 
                @foreach($categories as $category)
                    @if($category -> id == $lesson -> category_id)
                      @if((strtoupper(app()->getLocale()))=="DE")
                        {{ $category -> name_de}}
                      @else
                      {{ $category -> name}}
                      @endif
                    @endif
                  @endforeach</li>      
                <li class="list-group-item">{{ __('Lygis') }}: 
                @foreach($levels as $level)
                    @if($level -> id == $lesson -> level_id)
                      {{ $level -> name}}
                    @endif
                  @endforeach</li>
              </ul>
            </div>
          
          @endif
        @endforeach
        </div>
      @break

      @case("levels")
        @foreach($groups as $groupbox)
        <div class="row col-xl-4 col-md-6 col-sm-12 card-body hideableElement" >
                <h5 class="card-title" style="color:#78003e;"> ~@if($groupbox -> name_de == null)
                    {{ $groupbox -> name}}
                  @elseif((strtoupper(app()->getLocale()))=="DE")
                    {{ $groupbox -> name_de}}
                  @else
                  {{ $groupbox -> name}}
                  @endif  
                  ~</h5>

        @foreach($lessons as $lesson) 
          @if($lesson -> level_id == $groupbox -> id)
          @php
          //$image = preg_grep('~^cover.*\.jpg$~', scandir("pamokos_files/{$lesson->name}/content/images/"));
          //echo $image;
          @endphp
            <div class="card col box-shadow" style="padding: 5px; height: 100%;">
              <img src="../pamokos_files/{{ $lesson -> name}}/content/images/{{ $lesson -> picture }}" class="card-img-top" style="object-fit:fit; display: block; margin-left: auto; margin-right: auto;" alt="{{ $lesson -> picture }}">
              <div class="card-body">

              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><h4 class="card-title">{{ $lesson -> name }}</h4></li>
                <li class="list-group-item"><a href="../lesson/{{ $lesson -> id }}/" class="card-link" style="color:#78003e;">{{ __('Rodyti') }}</a></li>
                <li class="list-group-item">{{ __('Kategorija') }}: 
                @foreach($categories as $category)
                    @if($category -> id == $lesson -> category_id)
                      @if((strtoupper(app()->getLocale()))=="DE")
                        {{ $category -> name_de}}
                      @else
                      {{ $category -> name}}
                      @endif
                    @endif
                  @endforeach</li>
                <li class="list-group-item">{{ __('Tema') }}: 
                  @foreach($topics as $topic)
                    @if($topic -> id == $lesson -> topic_id)
                      @if((strtoupper(app()->getLocale()))=="DE")
                        {{ $topic -> name_de}}
                      @else
                      {{ $topic -> name}}
                      @endif
                    @endif
                  @endforeach
              </ul>
            </div>
            @endif
        @endforeach
        </div>
        @endforeach
        <div class="row col-xl-4 col-md-6 col-sm-12 card-body hideableElement" style=" height: 100%;">
        <h5 class="card-title" style="color:#78003e;">{{ __('Nesurūšiuotos pamokos') }}</h5>
        @foreach($lessons as $lesson)
          @if($lesson -> level_id == null)
          <div class="card col" style="padding: 5px;">
              <img src="../pamokos_files/{{ $lesson -> name}}/content/images/{{ $lesson -> picture }}" class="card-img-top" style="object-fit:fit; display: block; margin-left: auto; margin-right: auto;" alt="{{ $lesson -> picture }}">
              <div class="card-body">
                
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item"><h5 class="card-title">{{ $lesson -> name }}</h5></li>
                <li class="list-group-item"><a href="../lesson/{{ $lesson -> id }}/" class="card-link" style="color:#78003e;">{{ __('Rodyti') }}</a></li>
                <li class="list-group-item">{{ __('Kategorija') }}: {{ $lesson -> category_id }}</li>
                <li class="list-group-item">{{ __('Tema') }}: 
                  @foreach($topics as $topic)
                    @if($topic -> id == $lesson -> topic_id)
                      @if((strtoupper(app()->getLocale()))=="DE")
                        {{ $topic -> name_de}}
                      @else
                      {{ $topic -> name}}
                      @endif
                    @endif
                  @endforeach
              </ul>
            </div>
          
          @endif
        @endforeach
        </div>
      @break

      @endswitch
</div>
        </div>

      </div>
    </div>
    
<script type="text/javascript">
  function myFunction() {
        var input, filter, cards, cardContainer, title, i, txtValue;
        input = document.getElementById("filter");
        filter = input.value.toUpperCase();
        cardContainer = document.getElementById("lessons");
        //cards = cardContainer.getElementsByClassName("card-body");
        cards = cardContainer.getElementsByClassName("card");
        for (i = 0; i < cards.length; i++) {
            title = cards[i].querySelector(".list-group-item h5.card-title");
            txtValue = title.textContent || title.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                cards[i].style.display = "";
            } else {
                cards[i].style.display = "none";
            }
        }
    }
</script>
    <script src ="/js/lesson.js" type="text/javascript" defer></script>

@endsection