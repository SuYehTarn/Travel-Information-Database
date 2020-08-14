@extends('layout')

@section('title', '旅遊資訊資料庫')

@section('header', '旅遊資訊資料庫')

@section('content')
	
	<div class="content container">

		<div class="tab-content" style="margin-bottom: 20px;">
			
			<div id="info" class="tab-pane fade in active">

				@include('tab-info')

			</div>
			
			<div id="attra" class="tab-pane fade">

				@include('tab-attraction')

			</div>
			
			<div id="path" class="tab-pane fade">

				@include('tab-path')

			</div>

		</div>

	</div>

@endsection

@section('script')

	<script type="text/javascript" src='/js/funcs.js'></script>
	<script type="text/javascript" src='/js/flow-index.js'></script>

@endsection