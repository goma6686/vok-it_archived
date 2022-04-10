@extends('layouts.layout')
@section('title', 'Vok-IT VU Admin Panel')

@section('head')
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css" integrity="sha512-jU/7UFiaW5UBGODEopEqnbIAHOI8fO6T99m7Tsmqs2gkdujByJfkCbbfPSN4Wlqlb9TGnsuC0YgUgWkRBK7B9A==" crossorigin="anonymous"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js" integrity="sha512-VQQXLthlZQO00P+uEu4mJ4G4OAgqTtKG1hri56kQY1DtdLeIqhKUp9W/lllDDu3uN3SnUNawpW7lBda8+dSi7w==" crossorigin="anonymous"></script>

	<link href="/css/admin.css "rel="stylesheet">
	<script src="/js/admin.js" type="text/javascript" defer></script>
@endsection

@section('body')

	<div class="wrapper admin">
		<table>
			<thead>
				<th>name</th>
				<th>description</th>
				<th>category_id</th>
				<th>topic_id</th>
				<th>level_id</th>
				<th>format</th>
				<th>picture</th>
			</thead>
			<tbody>
				<form action="/admin/post" method="POST">
					@csrf
					<td><input type="text" name="p_name"></td>
					<td><input type="text" name="p_description"></td>
					<td><input type="text" name="p_category_id"></td>
					<td><input type="text" name="p_topic_id"></td>
					<td><input type="text" name="p_level_id"></td>
					<td><input type="text" name="p_format"></td>
					<td><input type="text" name="p_picture"></td>

					<td><input type="submit" name="submit"></td>
				</form>
			</tbody>
		</table>

		<table>
			<thead>
				<th>id</th>
				<th>name</th>
				<th>description</th>
				<th>category_id</th>
				<th>topic_id</th>
				<th>level_id</th>
				<th>format</th>
				<th>picture</th>
				<th>updated_at</th>
				<th>created_at</th>
				<th>edit</th>
			</thead>
			<tbody>
				@foreach($lessons as $lesson)
					<tr>
						<form action="/admin/post/{{ $lesson -> id }}" method="POST">
						@csrf
						<td>{{ $lesson -> id }}</td>
						<td><input type="text" name="u_name" value="{{ $lesson -> name }}"></td>
						<td><input type="text" name="u_description" value="{{ $lesson -> description }}"></td>
						<td><input type="text" name="u_category_id" value="{{ $lesson -> category_id }}"></td>
						<td>
							<select class="form-select" aria-label="Topic select" name="u_topic_id" style="width: auto;">
								@foreach($topics as $topic)
							  		@if($topic -> id == $lesson -> topic_id)
							  			<option selected value="{{ $lesson -> topic_id }}">{{ $topic -> name}}</option>
							  		@else
							  			<option value="{{ $topic -> id }}">{{ $topic -> name }}</option>
							  		@endif
						  		@endforeach
							</select>
						</td>
						<td><input type="text" name="u_level_id" value="{{ $lesson -> level_id }}"></td>
						<td><input type="text" name="u_format" value="{{ $lesson -> format }}"></td>
						<td><input type="text" name="u_picture" value="{{ $lesson -> picture }}"></td>
						<td>{{ $lesson -> updated_at }}</td>
						<td>{{ $lesson -> created_at }}</td>

						<td>
							<button>Update</button>
						</form>
							<form action="/admin/delete/{{ $lesson -> id }}" method="POST">
								@csrf
								@method('DELETE')
								<button>Delete</button>
							</form>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>

	











	<div class="allLessonsContainer">
		<div class="byCategoryContainer">
			


		</div>
		<div class="byTopicContainer">
			@foreach($topics as $topic)
				<div class="topic containerForDraggable" id="{{$topic -> id}}">
					@foreach($lessons as $lesson)
						@if($topic -> id == $lesson -> topic_id)
							<div class="lesson draggable" id="{{$lesson -> id}}" draggable="true" >
								<table>
									<tr>
										<td>{{$lesson -> name}}</td>
										<td>{{$lesson -> description}}</td>
										<td>{{$lesson -> category_id}}</td>
										<td>{{$lesson -> topic_id}}</td>
										<td>{{$lesson -> level_id}}</td>
										<td>{{$lesson -> format}}</td>
										<td>{{$lesson -> picture}}</td>
									</tr>
								</table>
								
								
							</div>
						@endif
					@endforeach
				</div>
			@endforeach
		</div>
		<div class="byLevelContainer">
			


		</div>
	</div>



	<form action="/test/final_script.php" method="get">
		<input type="submit" name="Run!">
	</form>



	<div>
		<div class="containerForDraggable">
			<p class="draggable" draggable = "true">1</p>
			<p class="draggable" draggable = "true">2</p>
		</div>
		<div class="containerForDraggable">
			<p class="draggable" draggable = "true">3</p>
			<p class="draggable" draggable = "true">4</p>
		</div>
	</div>




	<section>
		<form action="/admin/uploadFile" class="dropzone" id="file-upload">
			@csrf
			<div class="fallback">
		    	<input name="file" type="file"/>
		    </div>
		</form>
	</section>
	
	<script type="text/javascript">
		Dropzone.options.fileUpload = {
			paramName: "file",
			acceptedFiles : '.zip, .h5p'
		}
	</script>

@endsection