@extends('dashboard.layouts.app')
@section('title')
{{ __($headMember->head_name . ' Family Members Details') }}
@endsection
@section('css')
    <style>
        .personal_image {
            height: 40px;
            width: 50px
        }

        .national_id_card {
            height: 40px;
            width: 50px
        }

        .avatar {
            cursor: pointer;
            /* Add pointer cursor to indicate it's clickable */
        }
    </style>
@endsection
@section('content')
    {{-- Begin breadcrumb --}}
    <x-potentialcustomer::breadcrumb>
        <x-potentialcustomer::breadcrumb-item>
            <a href="{{ route('lead_home.index') }}">{{ __('Home') }}</a>
        </x-potentialcustomer::breadcrumb-item>

        <x-potentialcustomer::breadcrumb-item>
            <a href="{{ route('potential_account.index') }}">{{ __('Potential Account') }}</a>
        </x-potentialcustomer::breadcrumb-item>

        <x-potentialcustomer::breadcrumb-item>
            <a
                href="{{ route('collected_customer_data.showCollectedDataDetails', ['potential_account' => $headMember->potentialAccount->id]) }}">{{ __('Collected Data Details') }}</a>
        </x-potentialcustomer::breadcrumb-item>
        <x-potentialcustomer::breadcrumb-item>
            {{ __('Head Member Data Details ') }}
        </x-potentialcustomer::breadcrumb-item>
    </x-potentialcustomer::breadcrumb>
    {{-- End breadcrumb --}}

    <div class="card">
        <div class="card-header">
            <h5>{{ __($headMember->head_name . ' Family Members Details') }}</h5>
        </div>
        <div class="card-body">

            <table id="example1" class="table  table-striped table-sm fs--1 my-1">
                <thead>
                    <tr>
                        <th class="text-center">{{ __('#') }}</th>
                        <th class="text-center">{{ __('Name') }}</th>
                        <th class="text-center">{{ __('Phone') }}</th>
                        <th class="text-center">{{ __('National Id') }}</th>
                        <th class="text-center">{{ __('RelationShip') }}</th>
                        <th class="text-center">{{ __('Date of birth') }}</th>
                        <th class="text-center">{{ __('Personal Image') }}</th>
                        <th class="text-center">{{ __('National Id Cards') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php

                    @endphp
                    <tr style="background-color:yellowgreen">
                        <td class="text-center">{{ $i = 1 }}</td>
                        <td class="text-center">{{ $headMember->head_name }}</td>
                        <td class="text-center">{{ $headMember->head_phone }}</td>
                        <td class="text-center">{{ $headMember->head_national_id }}</td>
                        <td class="text-center">{{ 'Head Member' }}</td>
                        <td class="text-center">{{ $headMember->head_birth_date }}</td>


                        <td class="text-center">
                            @foreach ($headMember->headFiles->whereNull('national_id_card')->whereNull('family_member_id') as $headImage)
                                <!-- Image Trigger -->
                                <a href="#" data-bs-toggle="modal" data-bs-target="#imageModal"
                                    class="d-flex justify-content-center">
                                    <img class="personal_image" src="{{ asset('storage/' . $headImage->personal_image) }}"
                                        alt="User Image" data-bs-toggle="modal" data-bs-target="#imageModal" />
                                </a>
                            @endforeach
                            <span class="d-none">{{ asset('storage/' . $headImage->personal_image) }}</span>

                        </td>
                        <td class="text-center">
                            @foreach ($headMember->headFiles->whereNull('personal_image')->whereNull('family_member_id') as $head_idCard)
                                <a href="#" class="open-modal2 mx-2" data-bs-toggle="modal" data-bs-target="#imageModal2"
                                    data-data="{{ asset('storage/' . $head_idCard->national_id_card) }}">
                                    <img class="national_id_card"
                                        src="{{ asset('storage/' . $head_idCard->national_id_card) }}" alt="User Image" />
                                </a>
                            @endforeach
                            <span class="d-none">{{ asset('storage/' . $head_idCard->national_id_card) }}</span>

                        </td>
                        </td>
                    </tr>
                    @foreach ($familyMembers as $familyMember)
                        <tr>
                            <td class="text-center">{{ ++$i }}</td>
                            <td class="text-center">{{ $familyMember->name }}</td>
                            <td class="text-center">{{ $familyMember->phone }}</td>
                            <td class="text-center">{{ $familyMember->national_id }}</td>
                            <td class="text-center">{{ ucfirst(str_replace('_', '/', $familyMember->relationship)) }}</td>
                            <td class="text-center">{{ $familyMember->birth_date }}</td>
                            <td class="text-center">
                                @foreach ($familyMember->familyMemberFiles->whereNull('national_id_card') as $member_personalImage)
                                    <a href="#" class="open-modal2 mx-2" data-bs-toggle="modal"
                                        data-bs-target="#imageModal2"
                                        data-data="{{ asset('storage/' . $member_personalImage->personal_image) }}">
                                        <img class="national_id_card" style="width: 50px;hight:50px;"
                                            src="{{ asset('storage/' . $member_personalImage->personal_image) }}"
                                            alt="User Image" />
                                    </a>

                                @endforeach
                                <span class="d-none">{{ asset('storage/' . $member_personalImage->personal_image) }}</span>
                            </td>

                            <td class="text-center">
                                @foreach ($familyMember->familyMemberFiles->whereNull('personal_image') as $memberNationalCardId)
                                    <a href="#" class="open-modal2 mx-2" data-bs-toggle="modal"
                                        data-bs-target="#imageModal2"
                                        data-data="{{ asset('storage/' . $memberNationalCardId->national_id_card) }}">
                                        <img class="national_id_card"
                                            src="{{ asset('storage/' . $memberNationalCardId->national_id_card) }}"
                                            alt="User Image" />
                                    </a>
                                @endforeach

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- Image Modal -->
    <div class="modal fade " id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl " role="document">
            <div class="modal-content bg-transparent">

                <div class="modal-body ">
                    <!-- Image -->
                    <img src="{{ asset('storage/' . $headImage->personal_image) }}" class="img-fluid" alt="User Image">
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal2" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel2"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content bg-transparent">
                <div class="modal-body">
                    <!-- Image -->
                    <img id="modalImage2" class="img-fluid" alt="User Image">
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')

    <script>
        $('#imageModal2').on('show.bs.modal', function(event) {
            var triggerElement = $(event.relatedTarget);
            var imageUrl = triggerElement.data('data');
            $('#modalImage2').attr('src', imageUrl);
        });
    </script>
    <!-- Page specific script -->
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)').addClass('mx-2');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endsection
