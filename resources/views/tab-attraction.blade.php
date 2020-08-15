<div id="attractions" class="list-group">
	
	@if (!empty($attras))
	
		@foreach ($attras as $attra)

			<div class='list-group-item d-flex justify-content-between align-items-center' data-value="{{ $attra->attra_name }}" onclick='getAttraInfo(this)'>
				
				{{ $attra->attra_name }}
				
				<i class="fas fa-plus add-attra-icon" onclick="addAttra(event, this)"></i>
			</div>

			
		
		@endforeach
	
	@else
		
		<p>查無景點</p>

	@endif

	<!-- Modal -->
	<div id="attraInfo" class="modal fade" role="dialog">
		<div class="modal-dialog modal-dialog-centered">
		
			<!-- Modal content-->					
			<div class="modal-content">

				<div class="modal-header">
					<h4 class="modal-title"></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
			
				<div class="modal-body"></div>

			</div>
		
		</div>
	</div>

</div>