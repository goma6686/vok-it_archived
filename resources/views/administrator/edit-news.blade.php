@extends('administrator.layouts.app')

@section('header')
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/css/bootstrap-switch-button.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/dist/bootstrap-switch-button.min.js"></script>
    <link href="/css/admin.css "rel="stylesheet">
    <script src="/js/admin.js" type="text/javascript" defer></script>
    {{-- CKEditor CDN --}}
    <script src="//cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

@endsection

@section('content')

    
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 tab-content">



                    <div role="tabpanel" id="create" class=" active tab-pane bg-white overflow-auto shadow-sm sm:rounded-lg"><!-- begin create block -->
                        <div class="p-6 bg-white border-b border-gray-200">
                            <div class="wrapper admin panel-body">
                                    <!-- Title image -->
                                    <div class="form-group">
                                        @if($news -> title_image != null)
                                        <img src="/news_images/title_images/{{$news->title_image}}" class="card-img-top" style="max-height: 100px; max-width: 100px">
                                        <form action="/administrator/news/changeImage/{{ $news -> id }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <button class="btn btn-outline-warning" style="color: #78003f !important; border-color: #78003f !important;">{{ __('Pakeisti viršelio nuotrauką') }}</button>
                                            <input type="file" name="imageChange">
                                        </form>
                                        <form action="/administrator/news/removeImage/{{ $news -> id }}" method="POST">
                                            @csrf
                                            <button onclick="return confirm('{{ __('Ar tikrai norite Ištrinti?')}}')">{{ __('Ištrinti viršelio nuotrauką') }}</button>
                                        </form>
                                        @else
                                        <form action="/administrator/news/uploadImage/{{ $news -> id }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <button class="btn btn-outline-warning" style="color: #78003f !important; border-color: #78003f !important;">{{ __('Įkelti viršelio nuotrauką') }}</button>
                                            <input type="file" name="titleImageUpload">
                                        </form>
                                        @endif
                                   </div>

                                <form method="POST" enctype="multipart/form-data" action="{{ route('administrator.update-news', array($news->id)) }}">
                                    @csrf

                                    <!-- Title -->
                                    <div>
                                        <x-label for="news_title" :value="__('Pavadinimas')" />
                                        <x-input id="news_title" class="block mt-1 w-full" type="text" name="news_title" value="{{ $news->news_title }}" required autofocus />
                                    </div>
                                    <!-- Description -->
                                    <div>
                                        <x-label for="description" :value="__('Aprašymas') " />

                                        <x-input id="description" class="block mt-1 w-full" type="text" name="description" value="{{ $news->description }}" />
                                    </div>

                                    <!-- News body -->
                                    <div class="mt-4">
                                        <x-label for="news_body" :value="__('Turinys')" />

                                        <textarea id="news_body" rows="10" cols="80" name="news_body"  required>{!! $news->news_body !!}</textarea>
                                        <script>

                                            CKEDITOR.replace('news_body', {
                                                filebrowserUploadUrl: "{{ route('image.upload', ['_token' => csrf_token() ])}}",
                                                filebrowserUploadMethod: 'form'
                                            });
                                        </script>
                                    </div>
                                    <div>
                                        <x-label for="news_categoryId" :value="__('Kategorija')"/>
                                        <div class="col-md-6">
                                            <select id="news_categoryId" type="news_categoryId" class="form-control" name="news_categoryId" required>
                                            @foreach($news_categories as $category)
                                                @if($category -> id == $news -> news_categoryId)
                                                    @if(strtoupper(app()->getLocale()) == "DE")
                                                        <option selected value="{{ $news -> news_categoryId }}">{{ $category -> name_de}}</option>
                                                        @else
                                                        <option selected value="{{ $news -> news_categoryId }}">{{ $category -> name}}</option>
                                                    @endif
                                                @else
                                                    @if(strtoupper(app()->getLocale()) == "DE")
                                                        <option selected value="{{ $news -> news_categoryId }}">{{ $category -> name_de}}</option>
                                                        @else
                                                        <option selected value="{{ $news -> news_categoryId }}">{{ $category -> name}}</option>
                                                    @endif
                                                @endif
                                            @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <input type="hidden" id="lang" name="lang" value="DE">
                                        <x-label :value="__('Kalba')"/>
                                        <input name="lang" id="lang" type="checkbox" data-onlabel="LT" data-offlabel="DE" data-toggle="switchbutton" a-onstyle="light" data-offstyle="light" data-style="fast" value="LT"
                                         @if ($news -> lang == "LT")
                                             checked
                                         @endif 
                                         data-onstyle="light" data-offstyle="light" data-style="fast">
                                    </div>

                                    <div class="flex items-center justify-end mt-4">
                                        <x-button class="ml-4">
                                            {{ __('Atnaujinti įrašą') }}
                                        </x-button>
                                    </div>
                                    
                                </form>
                            </div>
                        </div>
                    </div><!-- end create block -->

                </div>
            </div>
@endsection