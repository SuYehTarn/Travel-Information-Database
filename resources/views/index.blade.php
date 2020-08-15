@extends('layout')

@section('title', '旅遊資訊資料庫')

@section('header', '旅遊資訊資料庫')

@section('content')

	<div class="tab-content">
		
		<div id="info" class="tab-pane container fade show active">

			@include('tab-info')

		</div>
		
		<div id="attra" class="tab-pane container fade">

			@include('tab-attraction')

		</div>
		
		<div id="path" class="tab-pane container fade">

			@include('tab-path')

		</div>

	</div>

@endsection

@section('script')

	<script type="text/javascript" src='/js/funcs.js'></script>
	<script type="text/javascript">
		$(document).ready( function() {
			refresh();
		});
	</script>

@endsection