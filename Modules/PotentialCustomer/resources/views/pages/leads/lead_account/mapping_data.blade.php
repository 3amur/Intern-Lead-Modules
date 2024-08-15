@extends('dashboard.layouts.app')
@section('title')
    {{ __('Lead Account Mapping Data Page') }}
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
            <a href="{{ route('lead_account.index') }}">{{ __('Lead Accounts') }}</a>
        </x-potentialcustomer::breadcrumb-item>
        <x-potentialcustomer::breadcrumb-item>
            {{ __('Lead Account Mapping Data Page') }}
        </x-potentialcustomer::breadcrumb-item>
    </x-potentialcustomer::breadcrumb>
    {{-- End breadcrumb --}}


    <div class="card mb-4">
        <div class="card-header">
            <h4 class="mb-0">{{ __(' Invalid Data ') }} </h4>

            @if (!empty($fails_rows_array_with_errors))
                <a class="btn btn-danger m-3" target="_blank"
                    href="{{ route('lead_account.exportInvalidRows') }}">{{ __('Export Invalid Data') }}
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
            <h4 class="mb-0">{{ __('Duplicate Data ') }}</h4>
            <div class="float-end ">
                {{-- <a class="btn btn-primary btn-sm mb-3" href="{{ route('lead_account.exportDuplicate') }}">
                        {{ __('Export') }}
                    </a> --}}
            </div>
            {{-- <div class="form-group float-end ">
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
                </div> --}}
        </div>
        <div class="card-body">
            <div id="tableExample2">
                <div class="table-responsive">
                    <table class="table table-striped table-sm fs--1 mb-0" id="emailListDuplicates">
                        <thead>
                            <tr>
                                {{-- <th>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="selectAllCheckbox">
                                            <label class="custom-control-label" for="selectAllCheckbox"></label>
                                        </div>
                                    </th> --}}
                                <th class="text-center ps-3">#</th>
                                <th class="text-center">{{ __('Account Name') }}</th>
                                <th class="text-center">{{ __('Account Title') }}</th>
                                <th class="text-center">{{ __('personal Number') }}</th>
                                <th class="text-center">{{ __('Mobile') }}</th>
                                <th class="text-center">{{ __('Phone') }}</th>
                                <th class="text-center">{{ __('Email') }}</th>
                                <th class="text-center">{{ __('Website') }}</th>
                                <th class="text-center">{{ __('zip Code') }}</th>
                                <th class="text-center">{{ __('Address') }}</th>
                                <th class="text-center">{{ __('Note') }}</th>

                            </tr>
                        </thead>
                        <tbody class="list">
                            @if (count($duplicated_leadAccounts) === 0)
                                <tr>
                                    <td colspan="12">{{ __('No Data To Show') }}</td>
                                </tr>
                            @else
                                @foreach ($duplicated_leadAccounts as $duplicated_leadAccount)
                                    <tr>
                                        {{-- <td class="text-center ">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input email_list-checkbox"
                                                    value="{{ $duplicated_emailList->id }}"
                                                    id="selectCheckbox-{{ $duplicated_emailList->id }}">
                                                <label class="custom-control-label"
                                                    for="selectCheckbox-{{ $duplicated_emailList->id }}"></label>
                                            </div>
                                        </td> --}}
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $duplicated_leadAccount->account_name }}</td>
                                        <td class="text-center ">{{ $duplicated_leadAccount->account_title }}</td>
                                        <td class="text-center ">{{ $duplicated_leadAccount->personal_number }}</td>
                                        <td class="text-center ">{{ $duplicated_leadAccount->mobile }}</td>
                                        <td class="text-center ">{{ $duplicated_leadAccount->phone }}</td>
                                        <td class="text-center ">{{ $duplicated_leadAccount->email }}</td>
                                        <td class="text-center ">{{ $duplicated_leadAccount->website }}</td>
                                        <td class="text-center ">{{ $duplicated_leadAccount->zip_code }}</td>
                                        <td class="text-center ">{{ $duplicated_leadAccount->address }}</td>
                                        <td class="text-center ">{{ $duplicated_leadAccount->notes }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="card mb-4">
        <div class="card-header">
            <h4 class="mb-0">{{ __(' Founded Data With Some Changes') }}</h4>
            {{--  <a class="btn btn-primary float-end" href="{{ route('lead_account.exportWithSomeChanges') }}">
                    {{ __('Export') }}
                </a> --}}
            {{--                 <form method="post" action="{{ route('email_lists.updateFullDuplicate') }}">
                    @csrf
                    <button class="btn btn-primary float-end me-3" type="submit"> {{ __('Update') }}
                    </button>
                </form> --}}
        </div>
        <div class="card-body">
            <div id="tableExample2">
                <div class="table-responsive">
                    <table class="table table-striped table-sm fs--1 mb-0">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">{{ __('Account Name') }}</th>
                                <th class="text-center">{{ __('Contact Name') }}</th>
                                <th class="text-center">{{ __('Account Title') }}</th>
                                <th class="text-center">{{ __('personal Number') }}</th>
                                <th class="text-center">{{ __('Mobile') }}</th>
                                <th class="text-center">{{ __('Phone') }}</th>
                                <th class="text-center">{{ __('Email') }}</th>
                                <th class="text-center">{{ __('Website') }}</th>
                                <th class="text-center">{{ __('zip Code') }}</th>
                                <th class="text-center">{{ __('Address') }}</th>
                                <th class="text-center">{{ __('Note') }}</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @if (count($changed_leadAccounts) === 0)
                                <tr>
                                    <td colspan="12">{{ __('No Data To Show') }}</td>
                                </tr>
                            @else
                                @foreach ($changed_leadAccounts as $changed_leadAccount)
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $changed_leadAccount->account_name }}</td>
                                <td class="text-center">{{ $changed_leadAccount->account_contact_name }}</td>
                                <td class="text-center ">{{ $changed_leadAccount->account_title }}</td>
                                <td class="text-center ">{{ $changed_leadAccount->personal_number }}</td>
                                <td class="text-center ">{{ $changed_leadAccount->mobile }}</td>
                                <td class="text-center ">{{ $changed_leadAccount->phone }}</td>
                                <td class="text-center ">{{ $changed_leadAccount->email }}</td>
                                <td class="text-center ">{{ $changed_leadAccount->website }}</td>
                                <td class="text-center ">{{ $changed_leadAccount->zip_code }}</td>
                                <td class="text-center ">{{ $changed_leadAccount->address }}</td>
                                <td class="text-center ">{{ $changed_leadAccount->notes }}</td>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h4 class="mb-0">{{ __('New Data') }}</h4>
            <a class="btn btn-primary float-end" href="{{ route('lead_account.exportNewData') }}">
                {{ __('Export') }}
            </a>
            <form method="post" action="{{ route('lead_account.insertNewData') }}">
                @csrf
                <button class="btn btn-primary float-end me-3" type="submit"> {{ __('Insert') }}
                </button>
            </form>
        </div>
        <div class="card-body">
            <div id="tableExample2">
                <div class="table-responsive">
                    <table class="table table-striped table-sm fs--1 mb-0">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">{{ __('Account Name') }}</th>
                                <th class="text-center">{{ __('Contact Name') }}</th>
                                <th class="text-center">{{ __('Account Title') }}</th>
                                <th class="text-center">{{ __('personal Number') }}</th>
                                <th class="text-center">{{ __('Mobile') }}</th>
                                <th class="text-center">{{ __('Phone') }}</th>
                                <th class="text-center">{{ __('Email') }}</th>
                                <th class="text-center">{{ __('Website') }}</th>
                                <th class="text-center">{{ __('zip Code') }}</th>
                                <th class="text-center">{{ __('Address') }}</th>
                                <th class="text-center">{{ __('Note') }}</th>
                            </tr>
                        </thead>
                        <tbody class="list">
                            @if (count($leadAccounts) === 0)
                                <tr>
                                    <td colspan="12">{{ __('No Data To Show') }}</td>

                                </tr>
                            @else
                                @foreach ($leadAccounts as $leadAccount)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $leadAccount->account_name }}</td>
                                        <td class="text-center">{{ $leadAccount->account_contact_name }}</td>
                                        <td class="text-center ">{{ $leadAccount->account_title }}</td>
                                        <td class="text-center ">{{ $leadAccount->personal_number }}</td>
                                        <td class="text-center ">{{ $leadAccount->mobile }}</td>
                                        <td class="text-center ">{{ $leadAccount->phone }}</td>
                                        <td class="text-center ">{{ $leadAccount->email }}</td>
                                        <td class="text-center ">{{ $leadAccount->website }}</td>
                                        <td class="text-center ">{{ $leadAccount->zip_code }}</td>
                                        <td class="text-center ">{{ $leadAccount->address }}</td>
                                        <td class="text-center ">{{ $leadAccount->notes }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script>
        $(document).ready(function() {
            var $selectAllCheckbox = $('#selectAllCheckbox');
            var $emailListCheckboxes = $('.email_list-checkbox');

            $selectAllCheckbox.change(function() {
                $emailListCheckboxes.prop('checked', $selectAllCheckbox.prop('checked'));
                logSelectedCheckboxes();
            });

            $emailListCheckboxes.change(logSelectedCheckboxes);

            function logSelectedCheckboxes() {
                var selectedCheckboxes = $emailListCheckboxes.filter(':checked').map(function() {
                    return $(this).val();
                }).get();
            }
        });
    </script>

    <script>
        function updateSelectedRows() {
            var selectedCheckboxes = $('.email_list-checkbox:checked').map(function() {
                return $(this).val();
            }).get();
            $('#selectedCheckboxes').val(JSON.stringify(selectedCheckboxes));
            $('form').submit();
        }
    </script>
@endsection
