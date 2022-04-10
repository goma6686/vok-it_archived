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


    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active"  aria-controls="home" role="tab" data-toggle="tab" aria-current="page" href="#edit">{{ __('Redaguoti įrašus') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active"  aria-controls="home" role="tab" data-toggle="tab" aria-current="page" href="#create">{{ __('Sukurti įrašą') }}</a>
        </li>
    </ul>

@endsection

@section('content')

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 tab-content">

                    <div role="tabpanel" id="edit" class="active tab-pane tab bg-white overflow-auto shadow-sm sm:rounded-lg"><!-- begin edit block -->
                        <div class="p-6 bg-white border-b border-gray-200">
                            <div class="wrapper admin panel-body">
                                <b>{{ __('Naujienos') }}</b>
                    <div class="wrapper admin panel-body">
                        <table class="table table-hover table-striped">
                        <thead>
                            <th scope="col" id="title" style="width: 40%;">{{ __('Pavadinimas') }}</th>
                            <th scope="col" id="body" style="width: 20%;">{{ __('Kategorija') }}</th>
                            <th scope="col" id="date" style="width: 20%;">{{ __('Data') }}</th>
                            <th scope="col" id="actions" style="width: 10%;">{{ __('Kalba') }}</th>
                            <th scope="col" id="actions" style="width: 10%;">{{ __('Actions') }}</th>
                        </thead>
                        <tbody>
                            @foreach($news as $new)
                                <tr>
                                    <td>{{ $new -> news_title }}</td>
                                        <td>
                                        @foreach($news_categories as $category)
                                            @if($category -> id == $new -> news_categoryId)
                                              @if((strtoupper(app()->getLocale()))=="DE")
                                                {{ $category -> name_de}}
                                              @else
                                              {{ $category -> name}}
                                              @endif
                                            @endif
                                        @endforeach
                                        </td>
                                    <td>{{ $new -> created_at }}</td>
                                    <td> {{ $new -> lang }} </td>
                                    <td>
                                        <button>
                                            <a href="/administrator/news/edit/{{ $new -> id }}">{{ __('Atnaujinti') }}</a>
                                        </button>
                                        <br>
                                        <form action="/administrator/news/delete/{{ $new -> id }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('{{ __('Ar tikrai norite Ištrinti?')}}')">{{ __('Ištrinti') }}</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        </table>
                    </div>
                            </div>
                        </div>
                        {{ $news->links() }}
                    </div><!-- end edit block -->

                    <div role="tabpanel" id="create" class="tab tab-pane bg-white overflow-auto shadow-sm sm:rounded-lg"><!-- begin create block -->
                        <div class="p-6 bg-white border-b border-gray-200">
                            <div class="wrapper admin panel-body">
                                <form method="POST" enctype="multipart/form-data" action="{{ route('administrator.post-news') }}">
                                    @csrf

                                    <!-- Title -->
                                    <div>
                                        <x-label for="news_title" :value="__('Pavadinimas') " />

                                        <x-input id="news_title" class="block mt-1 w-full" type="text" name="news_title" :value="old('news_title')" required autofocus/>
                                    </div>

                                    <!-- Title image -->
                                    <div class="form-group">
                                        <x-label for="title_image" :value="__('Įrašo nuotrauka') " />
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type='file' name='title_image' class="form-control">
                                        </div>
                                   </div>

                                   <!-- Description -->
                                    <div>
                                        <x-label for="description" :value="__('Aprašymas') " />

                                        <x-input id="description" class="block mt-1 w-full" type="text" name="description" :value="old('description')" />
                                    </div>

                                    <!-- News body -->
                                    <div class="mt-4">
                                        <x-label for="news_body" :value="__('Turinys')" />

                                        <textarea id="news_body" rows="10" cols="80" name="news_body" value="{{ old('news_body') }}" required></textarea>
                                        <script>
                                            CKEDITOR.replace('news_body');
                                        </script>
                                    </div>
                                    <div>
                                        <x-label for="news_categoryId" :value="__('Kategorija')"/>
                                        <div class="col-md-6">
                                            <select id="news_categoryId" type="news_categoryId" class="form-control" name="news_categoryId" required>
                                                <option value="">{{ __('Nepasirinkta') }}</option>
                                                    @foreach($news_categories as $category)
                                                        @if(strtoupper(app()->getLocale()) == "DE")
                                                            <option value="{{ $category->id }}"> {{$category->name_de}} </option>
                                                        @else
                                                            <option value="{{ $category->id }}"> {{$category->name}} </option>
                                                        @endif
                                                    @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <input type="hidden" name="lang" value="DE">
                                        <x-label :value="__('Kalba')"/>
                                        <input name="lang" id="lang" type="checkbox" data-onlabel="LT" data-offlabel="DE" data-toggle="switchbutton" checked data-onstyle="light" data-offstyle="light" data-style="fast" value="LT">

                                    </div>

                                    <div class="flex items-center justify-end mt-4">
                                        <x-button class="ml-4">
                                            {{ __('Skelbti įrašą') }}
                                        </x-button>
                                    </div>
                                    
                                </form>
                            </div>
                        </div>
                    </div><!-- end create block -->

                </div>
            </div>
         
    <script>
        $(function(){
          var hash = window.location.hash;
          hash && $('div.tab-content a[href="' + hash + '"]').tab('show');

          $('.tab-content a').click(function (e) {
            $(this).tab('show');
            var scrollmem = $('body').scrollTop();
            window.location.hash = this.hash;
            $('html,body').scrollTop(scrollmem);
          });
        });
    </script>   
@endsection