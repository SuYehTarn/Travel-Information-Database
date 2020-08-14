@if ($paths)

	@foreach ($paths as $path)

		<div id="path-steps-{{ $loop->iteration }}" class="path-steps panel panel-default" style="display: none;">
				
			@foreach ($path as $step)

				<div class="panel-body">

					<!--From stop-->
					<div class="col-sm-4">
						<span style="margin-right: 5px;">自: {{ $step['on_st'] }}</span>
						<span class="glyphicon glyphicon-map-marker"></span>
					</div>

					<!--With line-->
					<div class="col-sm-4">
						<span style="margin-right: 5px;">經: {{ str_replace('_', '-', $step['line']) }}</span>
						<span class="glyphicon glyphicon-road"></span>
					</div>

					<!--To stop-->
					<div class="col-sm-4">
						<span style="margin-right: 5px;">至: {{ $step['off_st'] }}</span>
						<span class="glyphicon glyphicon-map-marker"></span>
					</div>

				</div>

			@endforeach

		</div>

	@endforeach

@else

	<div class="panel panel-default">
		<div class="panel-body">
			<h4 class="text-center">查無合適路線</h4>
		</div>
	</div>

@endif