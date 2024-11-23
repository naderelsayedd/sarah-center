<input type="hidden" name="routine_id" value="{{ $routine_id }}">
<div class="row">
	<div class="col-lg-2">
		<div class="form-group">
			<label>{{ $day }}</label>
		</div>
	</div>
	<div class="col-lg-5">
		<div class="form-group">
			<label>Start time:</label>
			<input type="time" name="start_time" class="form-control" value="{{$start_time}}">
		</div>
	</div>
	<div class="col-lg-5">
		<div class="form-group">
			<label>End time:</label>
			<input type="time" name="end_time" class="form-control" value="{{$end_time}}">
		</div>
	</div>
</div>
