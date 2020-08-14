<div class="panel-group" id="attractions">
	
	@if (!empty($attras))
	
		@foreach ($attras as $attra)

			<div class="panel panel-default">
				<div class='panel-heading' data-toggle="modal" data-target="#attra-{{ $loop->iteration }}" data-value="{{ $attra->attra_name }}" onclick='getAttraInfo(this)'>
					<span class="panel-title">{{ $attra->attra_name }}</span>
					<span class="glyphicon glyphicon-plus add-attra-icon" onclick="addAttra(event, this)"></span>
				</div>
			</div>

			<!-- Modal -->
			<div class="modal fade" id="attra-{{ $loop->iteration }}" role="dialog">
				<div class="modal-dialog">
				
					<!-- Modal content-->					
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">{{ $attra->attra_name }}</h4>
						</div>
					
						<div class="modal-body"></div>

					</div>
				
				</div>
			</div>
		
		@endforeach
	
	@else
		
		<p>查無景點</p>

	@endif

</div>