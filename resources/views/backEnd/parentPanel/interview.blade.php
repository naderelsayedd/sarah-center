<!-- Button to trigger the modal (not needed if you want it to auto-show) -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createInterviewModal">
  Create Interview Schedule
</button> -->

<!-- Modal -->
<div class="modal fade" id="createInterviewModal" tabindex="-1" role="dialog" aria-labelledby="createInterviewModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createInterviewModalLabel">@lang('common.create_interview_schedule')</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('interviews.store') }}">
          @csrf
          <div class="form-group">
            <label for="interview_date">@lang('common.interview_date')</label>
            <input type="date" class="form-control" id="interview_date" name="interview_date" required>
          </div>

          <div class="form-group">
            <label for="interview_time">@lang('common.interview_time')</label>
            <input type="time" class="form-control" id="interview_time" name="interview_time" required>
          </div>

          <div class="form-group">
            <label for="comment">@lang('common.comment')</label>
            <textarea class="form-control" id="comment" name="comment"></textarea>
          </div>

          {{-- 
          <div class="form-group">
            <label for="admin_comment">@lang('common.admin_comment')</label>
            <textarea class="form-control" id="admin_comment" name="admin_comment"></textarea>
          </div>


          <div class="form-group">
            <label for="status">@lang('common.status')</label>
            <select class="form-control" id="status" name="status" required>
              <option value="">@lang('common.select_status')</option>
              <option value="pending">@lang('common.pending')</option>
              <option value="confirmed">@lang('common.confirmed')</option>
              <option value="rescheduled">@lang('common.rescheduled')</option>
              <option value="cancelled">@lang('common.cancelled')</option>
            </select>
          </div>
          --}}
          <button type="submit" class="btn btn-primary">@lang('common.create_interview_schedule')</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#createInterviewModal').modal('show');
  });
</script>