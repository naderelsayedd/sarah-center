<style>
    /* Add some basic styling for the PDF */
    body {
        font-family: Arial, sans-serif;
    }
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        border: 1px solid black;
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #f2f2f2;
    }
</style>
@if(isset($data) &&!empty($data))
<!-- for pdf content starts here -->
<?php if (isset($data['pdf']) && $data['pdf'] == 'pdf'): ?>
	@if($data['type'] == 1)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th><strong>@lang('hr.clause')</strong></th>
                    <th><strong>@lang('hr.class')</strong></th>
                    <th><strong>@lang('hr.evaluation')</strong></th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['evaluation'] as $evaluation)
                    <tr>
                        <td>@lang('hr.'.$evaluation['question'])</td>
                        <td class="text-center"> {{$evaluation['rating']}}</td>
                        <td>{{$evaluation['note']}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @elseif($data['type'] == 2)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>@lang('hr.criteria')</th>
                    <th class="text-center">@lang('hr.rating')</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['evaluation'] as $evaluation)
                    <tr>
                        <td>@lang('hr.'.$evaluation['question'])</td>
                        <td class="text-center">
                            @if($evaluation['rating'] == 1)
                                @lang('hr.excellent')
                            @elseif($evaluation['rating'] == 2)
                                @lang('hr.very_good')
                            @elseif($evaluation['rating'] == 3)
                                @lang('hr.acceptable')
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @elseif($data['type'] == 3)
        <table class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th> 
                        @lang('hr.clause')
                    </th>
                    <th>
                        @lang('hr.class')
                    </th>
                    <th> 
                        @lang('hr.notes')
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['evaluation'] as $evaluation)
                    <tr>
                        <td>@lang('hr.'.$evaluation['question'])</td>
                        <td class="text-center">
                            {{$evaluation['rating']}}
                        </td>
                        <td>{{$evaluation['notes']}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @elseif($data['type'] == 4)
        <table class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th style="color:white;">@lang('common.question')</th>
                    <th style="color:white;">@lang('common.rating')</th>
                    <th style="color:white;">@lang('common.date')</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['evaluation'] as $evaluation)
                    <tr>
                        <td>@lang('common.'.$evaluation['question'])</td>
                        <td>{{ $evaluation['rating'] }}</td>
                        <td>{{ $evaluation['submitted_date'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif  

<?php endif ?>
@endif