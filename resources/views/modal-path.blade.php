@if ($paths)

	@foreach ($paths as $path)

		<div id="path-steps-{{ $loop->iteration }}" class="list-group path-steps" style="display: none;">
				
			@foreach ($path as $step)

				<div class="list-group-item align-items-center">
					<div class="row">

					<!--From stop-->
						<div class="col-sm-4">
							<span class="fas fa-walking"></span>
							<span>{{ $step['on_st'] }}</span>
						</div>

					<!--With line-->
						<div class="col-sm-4">
							<span class="fas fa-bus"></span>
							<span>{{ str_replace('_', '-', $step['line']) }}</span>
						</div>

					<!--To stop-->
						<div class="col-sm-4">
							<span class="fas fa-flag-checkered"></span>
							<span>{{ $step['off_st'] }}</span>
						</div>
					</div>
				</div>

			@endforeach

		</div>

	@endforeach

@else

	<div class="card">
		<div class="card-body">
			<h4 class="text-center">查無合適路線</h4>
		</div>
	</div>

@endif