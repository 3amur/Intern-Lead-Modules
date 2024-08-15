@extends('dashboard.layouts.app')
@section('title')
    {{ __('Collected Customer Mapping Data Page') }}
@endsection
@section('css')
@endsection
@section('content')
    {{-- Begin breadcrumb --}}
    <x-potentialcustomer::breadcrumb>
        <x-potentialcustomer::breadcrumb-item>
            <a href="{{ route('home.index') }}">{{ __('Home') }}</a>
        </x-potentialcustomer::breadcrumb-item>


        <x-potentialcustomer::breadcrumb-item>
            <a
                href="{{ route('collected_customer_data.showCollectedDataDetails', ['potential_account' => $potentialAccountId]) }}">{{ __('Collected Customer Data') }}</a>
        </x-potentialcustomer::breadcrumb-item>
        <x-potentialcustomer::breadcrumb-item>
    {{ __('Collected Customer Mapping Data Page') }}
        </x-potentialcustomer::breadcrumb-item>
    </x-potentialcustomer::breadcrumb>
    {{-- End breadcrumb --}}


    <div class="card mb-4">
        <div class="card-header">
            <h4 class="mb-0">{{ __(' Invalid Data ') }} </h4>

            @if (!empty($fails_rows_array_with_errors))
                <a class="btn btn-danger m-3" target="_blank"
                    href="{{ route('imported_customer_data.exportInvalidRows',['potential_account_id'=>$potentialAccountId]) }}">{{ __('Export Invalid Data') }}
                </a>
            @endif
        </div>
        <div class="card-body">
            @if (!empty($fails_rows_array_with_errors))
                <div>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover ">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">
                                        {{ __('Invalid Data IN Row') }}<span></span></th>
                                    <th class="text-center">{{ __('Errors') }}<span></span></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($fails_rows_array_with_errors as $rowNumber => $errors)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center"> {{ $rowNumber + 2 }} </td>
                                        <td class="text-center">
                                            @foreach ($errors as $error)
                                                *{{ $error }}
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <h4 class="mb-0">{{ __('New Data') }}</h4>
            <a class="btn btn-primary float-end" href="{{ route('imported_customer_data.exportNewData',['potential_account_id'=>$potentialAccountId]) }}">
                {{ __('Export') }}
            </a>
            <form method="post" action="{{ route('imported_customer_data.insertNewData') }}">
                @csrf
                @if(count($collectedData) > 0)

                <button class="btn btn-primary float-end me-3" type="submit"> {{ __('Insert') }}
                </button>
                @endif
            </form>
        </div>
        <div class="card-body">
            <div id="tableExample2">
                <div class="table-responsive">
                    <table class="table table-striped table-sm fs--1 mb-0">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">{{ __('Policy Holder') }}</th>
                                <th class="text-center">{{ __('Member Name') }}</th>
                                <th class="text-center">{{ __('Employee Code') }}</th>
                                <th class="text-center">{{ __('Medical Code') }}</th>
                                <th class="text-center">{{ __('Gender') }}</th>
                                <th class="text-center">{{ __('Date Of Birth') }}</th>
                                <th class="text-center">{{ __('Marital Status') }}</th>
                                <th class="text-center">{{ __('Start Date') }}</th>
                                <th class="text-center">{{ __('End Date') }}</th>

                                <th class="text-center">{{ __('Insurance Category') }}</th>
                                <th class="text-center">{{ __('Room Type') }}</th>
                                <th class="text-center">{{ __('Optical') }}</th>
                                <th class="text-center">{{ __('Dental') }}</th>
                                <th class="text-center">{{ __('Medication') }}</th>
                                <th class="text-center">{{ __('maternity') }}</th>
                                <th class="text-center">{{ __('Hof Id') }}</th>
                                <th class="text-center">{{ __('Labs And Radiology') }}</th>
                                <th class="text-center">{{ __('Notes') }}</th>
                                <th class="text-center">{{ __('Potential Account') }}</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @foreach ($collectedData as $data)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $data->policy_holder }}</td>
                                    <td class="text-center ">{{ $data->member_name }}</td>
                                    <td class="text-center ">{{ $data->employee_code }}</td>
                                    <td class="text-center ">{{ $data->medical_code }}</td>
                                    <td class="text-center ">{{ $data->gender }}</td>
                                    <td class="text-center ">{{ $data->date_of_birth }}</td>
                                    <td class="text-center ">{{ $data->marital_status }}</td>
                                    <td class="text-center ">{{ $data->start_date }}</td>
                                    <td class="text-center ">{{ $data->end_date }}</td>
                                    <td class="text-center ">{{ $data->insurance_category }}</td>
                                    <td class="text-center ">{{ $data->room_type }}</td>
                                    <td class="text-center ">{{ $data->optical }}</td>
                                    <td class="text-center ">{{ $data->dental}}</td>
                                    <td class="text-center ">{{ $data->medication }}</td>
                                    <td class="text-center ">{{ $data->maternity }}</td>
                                    <td class="text-center ">{{ $data->hof_id }}</td>
                                    <td class="text-center ">{{ $data->labs_and_radiology }}</td>
                                    <td class="text-center ">{{ $data->notes }}</td>
                                    <td class="text-center ">{{ $data->potentialAccount->account_name }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{--  <div class="card mb-4">
            <div class="card-header">
                <h4 class="mb-0">{{ __('Duplicate Data ') }}</h4>
                <div class="float-end ">
                    <a class="btn btn-primary btn-sm mb-3" href="{{ route('email_lists.exportDuplicate') }}">
                        {{ __('Export') }}
                    </a>
                </div>
                <div class="form-group float-end ">
                    <form method="post" action="{{ route('email_lists.updateDuplicate') }}">
                        @csrf
                        <button class="btn btn-primary btn-sm mx-2" style="border-radius: 10" type="submit">
                            {{ __('Update All') }}
                        </button>
                    </form>
                </div>
                <div class="form-group float-end ">
                    <form method="post" action="{{ route('email_lists.updateSelectedDuplicate') }}">
                        @csrf
                        <input type="hidden" name="selectedCheckboxes" id="selectedCheckboxes" value="">

                        <button class="btn btn-primary btn-sm mx-2" style="border-radius: 10" type="submit"
                            onclick="updateSelectedRows()">
                            {{ __('Update Selected') }}
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                <div id="tableExample2">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm fs--1 mb-0" id="emailListDuplicates">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="selectAllCheckbox">
                                            <label class="custom-control-label" for="selectAllCheckbox"></label>
                                        </div>
                                    </th>
                                    <th class="text-center ps-3">#</th>
                                    <th class="text-center ps-3">
                                        {{ __('Name') }}</th>
                                    <th class="text-center">{{ __('Email') }}
                                    </th>
                                    <th class="text-center">{{ __('Phone') }}
                                    </th>
                                    <th class="text-center">{{ __('Mobile') }}
                                    </th>
                                    <th class="text-center">{{ __('Current Email Categories') }}</th>

                                    <th class="text-center">{{ __('Email Categories Request') }}</th>

                                </tr>
                            </thead>
                            <tbody class="list">
                                @foreach ($duplicated_emailLists as $duplicated_emailList)
                                    <tr>
                                        <td class="text-center ">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input email_list-checkbox"
                                                    value="{{ $duplicated_emailList->id }}"
                                                    id="selectCheckbox-{{ $duplicated_emailList->id }}">
                                                <label class="custom-control-label"
                                                    for="selectCheckbox-{{ $duplicated_emailList->id }}"></label>
                                            </div>
                                        </td>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-center ps-3">
                                            {{ $duplicated_emailList->name }}</td>
                                        <td class="text-center ">
                                            {{ $duplicated_emailList->email }}</td>
                                        <td class="text-center ">
                                            {{ $duplicated_emailList->phone }}</td>
                                        <td class="text-center ">
                                            {{ $duplicated_emailList->mobile }}</td>
                                        @php
                                            $oldEmail = Modules\SendingEMails\app\Models\EmailList::where('email', $duplicated_emailList->email)->first();

                                        @endphp
                                        <td class="text-center">
                                            @foreach ($oldEmail->emailCategories as $category)
                                                {{ $category->name }}
                                            @endforeach
                                        </td>
                                        <td class="text-center ">
                                            @foreach ($duplicated_emailList->emailCategories as $category)
                                                {{ $category->name }} <br>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> --}}


    {{-- <div class="card mb-4">
            <div class="card-header">
                <h4 class="mb-0">{{ __(' Founded Data With Some Changes') }}</h4>
                <a class="btn btn-primary float-end" href="{{ route('email_lists.exportWithSomeChanges') }}">
                    {{ __('Export') }}
                </a>
                <form method="post" action="{{ route('email_lists.updateFullDuplicate') }}">
                    @csrf
                    <button class="btn btn-primary float-end me-3" type="submit"> {{ __('Update') }}
                    </button>
                </form>
            </div>
            <div class="card-body">
                <div id="tableExample2">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm fs--1 mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center ps-3">#</th>
                                    <th class="text-center ps-3" data-sort="name">
                                        {{ __('Name') }}</th>
                                    <th class="text-center" data-sort="email">{{ __('Email') }}
                                    </th>
                                    <th class="text-center" data-sort="age">{{ __('Phone') }}
                                    </th>
                                    <th class="text-center" data-sort="age">{{ __('Mobile') }}
                                    </th>

                                </tr>
                            </thead>
                            <tbody class="list">
                                @if ($changed_emailLists == [])
                                    <tr>
                                        <td>{{ __('No Data To Show') }}</td>
                                    </tr>
                                @else
                                    @foreach ($changed_emailLists as $changed_emailList)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="text-center ps-3 name">
                                                {{ $changed_emailList->name }}</td>
                                            <td class="text-center email">
                                                {{ $changed_emailList->email }}</td>
                                            <td class="text-center age">
                                                {{ $changed_emailList->phone }}</td>
                                            <td class="text-center age">
                                                {{ $changed_emailList->mobile }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
    </div> --}}



@endsection
@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var selectAllCheckbox = document.getElementById('selectAllCheckbox');
            var emailListCheckboxes = document.querySelectorAll('.email_list-checkbox');

            selectAllCheckbox.addEventListener('change', function() {
                emailListCheckboxes.forEach(function(checkbox) {
                    checkbox.checked = selectAllCheckbox.checked;
                });

                logSelectedCheckboxes();
            });

            emailListCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', logSelectedCheckboxes);
            });

            function logSelectedCheckboxes() {
                var selectedCheckboxes = Array.from(emailListCheckboxes)
                    .filter(function(checkbox) {
                        return checkbox.checked;
                    })
                    .map(function(checkbox) {
                        return checkbox.value;
                    });
                console.log('Selected Checkboxes:', selectedCheckboxes);
            }
        });
    </script>

    <script>
        function updateSelectedRows() {
            var selectedCheckboxes = Array.from(document.querySelectorAll('.email_list-checkbox:checked'))
                .map(function(checkbox) {
                    return checkbox.value;
                });
            document.getElementById('selectedCheckboxes').value = JSON.stringify(selectedCheckboxes);
            document.forms[0].submit();
        }
    </script>
@endsection
