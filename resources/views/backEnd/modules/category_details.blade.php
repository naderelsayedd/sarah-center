<div class="row">
    <?php foreach ($sm_student_category as $key => $value): ?>
        <div class="col-lg-3 col-md-6 col-sm-6" onclick="showModelCategoryDetails({{$value->id}})">
            <a href="#" class="d-block">
                <div class="white-box single-summery">
                    <div class="d-flex justify-content-between">
                        <div>
                        	@php $data = getSmStuentDetails($value->id); @endphp
                            <h3>{{$value->category_name}}</h3>
                            <p class="mb-0">@lang('common.students_count') {{ $value->students->count() }}</p>
                            <p class="mb-0">@lang('common.transportation_count') {{ $data['transportation_count'] }}</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="categoryModal-{{$value->id}}" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="categoryModalLabel">@lang('common.category_details')</h5>
                    </div>
                    <div class="modal-body">
                        <!-- Show category details here -->
                        <p>@lang('common.category_name'): {{$value->category_name}}</p>
                        <p>@lang('common.students_count'): {{ $value->students->count() }}</p>
                        <p>@lang('common.transportation_count'): {{ $data['transportation_count'] }}</p>
                        <p>@lang('common.description'): {{ $value->description }}</p>
                        <!-- Add more details as needed -->
                    </div>
                </div>
            </div>
        </div>

    <?php endforeach ?>
</div>
<script>
function showModelCategoryDetails(categoryId) {
    $('#categoryModal-' + categoryId).modal('show');
}
</script>