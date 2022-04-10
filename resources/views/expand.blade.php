@extends('layouts.layout')
@section('title', 'Vok-IT VU Namai')
@section('body')
  <!-- write body here -->
<div class="container">
  <div class="row" id="news" data-masonry='{"percentPosition": true }'>
    <div >
      <div class="card p-3">
        @if($news->title_image!=null)
        <img src="/news_images/title_images/{{$news->title_image}}" class="card-img-top" style="align-self: center;">
        @endif
        <div class="card-body">
          <h4 class="card-title text-center" style="font-weight: bold;">{{ $news->news_title }}</h4>
          <h6 class="card-title text-center">{{ $news->description }}</h5>
          <p class="card-text">
            {!! $news->news_body !!}

            <?php //echo "<script> str_limit_html('" . $new->news_body . "'); </script>"; ?>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection