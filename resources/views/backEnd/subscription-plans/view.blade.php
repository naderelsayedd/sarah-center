@extends('backEnd.master')
@section('title')
@lang('common.subscription_purshased')
@endsection
@section('mainContent')
<section class="sms-breadcrumb mb-40 white-box">
    <div class="container-fluid">
        <div class="row justify-content-between">
            <h1>@lang('common.subscription_purshased') </h1>
            <div class="bc-pages">
                <a href="{{route('dashboard')}}">@lang('common.dashboard')</a>
                <a href="#">@lang('common.subscription')</a>
                <a href="#">@lang('common.subscription_purshased') </a>
            </div>
        </div>
    </div>
</section>
<section>
	<div class="container">
		<div class="row">
			<div class="col-sm-12 mb-40 white-box">
				<div class="filter-section">
					<div class="row">
						<div class="col-sm-3"> 
							<label for="name-filter">Name:</label>
					    	<input class="form-control" type="text" id="name-filter" placeholder="Search by name">
						</div>
						<div class="col-sm-3">
							<label for="start-date-filter">Start Date:</label>
					    	<input class="form-control" type="date" id="start-date-filter">
						</div>
						<div class="col-sm-3"> 
							<label for="expiry-date-filter">Expiry Date:</label>
					    	<input class="form-control" type="date" id="expiry-date-filter">
						</div>
						<div class="col-sm-3" style="padding: 30px;">
						    <button class="btn btn-primary" id="apply-filter">Apply Filter</button>
						    <button class="btn btn-primary" id="reset-filter">Reset Filter</button>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
            <div class="white-box">
                <h1 class="mb-4">Subscription Plans</h1>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>User Name</th>
                            <th>Type</th>
                            <th>Start Date</th>
                            <th>Expiry Date</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($subscriptionPlan as $plan)
                        <tr>
                            <td>{{ $plan->subscription_plan->name }}</td>
                            <td>{{ $plan->user->full_name }}</td>
                            <td>
                                <?php if ($plan->subscription_plan->type == 1) {
                                    echo "Bus Service";
                                }else if($plan->subscription_plan->type == 2){
                                    echo "Registration";
                                }?>
                            </td>
                            <td>{{ $plan->created_at }}</td>
                            <td>{{ $plan->expires_at }}</td>
                            <td>{{ $plan->subscription_plan->description }}</td>
                            <td>{{ $plan->subscription_plan->price }}</td>
                            <td>
                                <?php if ($plan->subscription_plan->duration_type == 1) {
                                    echo "Yearly";
                                }else if($plan->subscription_plan->duration_type == 2){
                                    echo "Half Yearly";
                                }else if($plan->subscription_plan->duration_type == 3){
                                    echo "Quarterly";
                                }else if($plan->subscription_plan->duration_type == 4){
                                    echo "Monthly";
                                } ?>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
		</div>
	</div>
</section>
<script>
	// Get the table and filter inputs
const table = document.querySelector('table');
const nameFilterInput = document.querySelector('#name-filter');
const startDateFilterInput = document.querySelector('#start-date-filter');
const expiryDateFilterInput = document.querySelector('#expiry-date-filter');
const applyFilterButton = document.querySelector('#apply-filter');
const resetFilterButton = document.querySelector('#reset-filter');

// Add event listeners to the filter inputs and buttons
applyFilterButton.addEventListener('click', applyFilter);
resetFilterButton.addEventListener('click', resetFilter);

// Function to apply the filter
function applyFilter() {
    const nameFilterValue = nameFilterInput.value.toLowerCase();
    const startDateFilterValue = startDateFilterInput.value;
    const expiryDateFilterValue = expiryDateFilterInput.value;

    let noRowsMatched = true;

    // Loop through each table row in the tbody section
    Array.prototype.forEach.call(table.tBodies[0].rows, (row) => {
        const nameCell = row.cells[0].textContent.toLowerCase();
        const startDateCell = row.cells[3].textContent;
        const expiryDateCell = row.cells[4].textContent;

        // Check if the row matches the filter criteria
        if (
            (!nameFilterValue || nameCell.indexOf(nameFilterValue) !== -1) &&
            (!startDateFilterValue || startDateCell >= startDateFilterValue) &&
            (!expiryDateFilterValue || expiryDateCell <= expiryDateFilterValue)
        ) {
            row.style.display = '';
            noRowsMatched = false;
        } else {
            row.style.display = 'none';
        }
    });

    // Show "No data found" message if no rows matched
    if (noRowsMatched) {
        const noDataFoundRow = document.createElement('tr');
        noDataFoundRow.innerHTML = '<td colspan="8">No data found</td>';
        table.tBodies[0].appendChild(noDataFoundRow);
    } else {
        // Remove any existing "No data found" rows
        const noDataFoundRows = table.tBodies[0].querySelectorAll('tr td[colspan="8"]');
        noDataFoundRows.forEach((row) => row.parentNode.remove());
    }
}
// Function to reset the filter
function resetFilter() {
    nameFilterInput.value = '';
    startDateFilterInput.value = '';
    expiryDateFilterInput.value = '';

    // Remove any existing "No data found" rows
    const noDataFoundRows = table.tBodies[0].querySelectorAll('tr td[colspan="8"]');
    noDataFoundRows.forEach((row) => row.parentNode.remove());

    // Show all table rows again
    Array.prototype.forEach.call(table.tBodies[0].rows, (row) => {
        row.style.display = '';
    });
}
</script>
@endsection