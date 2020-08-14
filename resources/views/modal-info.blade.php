<div class="panel panel-default">

	<div class="panel-body">
		
		@if ($address)

			<p><b>地址</b></p>

			<p>{{ $address }}</p>

		@else

			<p>查無地址</p>

		@endif

		@if ($texts)

			<p><b>開放時間</b></p>

			@foreach ($texts as $text)

				<p>{{ $text }}</p>

			@endforeach

		@else

			<p>查無開放時間</p>

		@endif

	</div>

</div>