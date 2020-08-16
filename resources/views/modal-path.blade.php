@if ($paths)

@foreach ($paths as $path)

@if ($loop->index == 0)

<div class="carousel-item active" data-pnum="{{ $loop->iteration }}">

@else

<div class="carousel-item" data-pnum="{{ $loop->iteration }}">

@endif
	
	<div class="d-flex flex-column path-steps">
	
	@foreach ($path as $node)

		<div class="d-flex justify-content-left align-items-center my-2">

			@if ($node[0] == 0)

			<span class="fas fa-sign fa-fw mr-3"></span>

			@elseif ($node[0] == 1)

			<span class="fas fa-bus fa-fw mr-3"></span>

			@elseif ($node[0] == 2)

			<span class="fas fa-walking fa-fw mr-3"></span>

			@elseif ($node[0] == 3)

				@if ($loop->iteration == count($path))

				<span class="fas fa-flag-checkered fa-fw mr-3"></span>

				@else

				<span class="fas fa-map-marker-alt fa-fw mr-3"></span>

				@endif

			@endif

			<span>{{ $node[1] }}</span>
		
		</div>

	@endforeach

	</div>

</div>

@endforeach

@else

	<div class="card">
		<div class="card-body">
			<h4 class="text-center">查無合適路線</h4>
		</div>
	</div>

@endif