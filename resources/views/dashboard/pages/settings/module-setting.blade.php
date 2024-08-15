@extends('dashboard.layouts.app')
@section('title')
    {{ __('Module Setting Page') }}
@endsection
@section('css')
    <link href="{{ asset('dashboard') }}/assets/css/responsive-datatable.min.css" rel="stylesheet">
@endsection
@section('content')
    <div class="content">
        <!-- add your content here -->
        <div class="px-2 px-md-5">
            <div class="align-items-start ">
                <div class="pt-1 w-100 mb-3 d-flex justify-content-between align-items-start ">
                    <div>
                        <h5 class="mb-2 me-2 lh-sm"><span class="fa-solid fa-sliders me-2 fs-0"></span>Modules Setting</h5>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade show active" id="tab-orders" role="tabpanel" aria-labelledby="orders-tab">
                <div class="border-top border-200" id="profileOrdersTable">
                    <div class=" data module-setting">
                        <table class="table table-responsive fs--1 mb-0 useDataTable">
                            <thead>
                                <tr>
                                    <th class="sort   text-start">Modules Name </th>
                                    <th class="sort    text-start">Modules status</th>
                                    <th class="sort  text-start">Version </th>
                                    <th class="sort   text-start">Description </th>
                                    <th class="sort  text-start">Expire date</th>
                                    <th class=" text-start">activate</th>
                                </tr>
                            </thead>
                            <tbody class="list" id="table-latest-review-body">
                                <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                    <td class="order align-middle white-space-nowrap py-2 ps-0 text-start"><a
                                            class="fw-semi-bold text-primary" href="#!">Test</a></td>
                                    <td class="status align-middle white-space-nowrap text-start fw-bold text-700 py-2">
                                        <span class="badge badge-phoenix fs--2 badge-phoenix-success"><span
                                                class="badge-label">Active</span><span class="ms-1" data-feather="check"
                                                style="height:12.8px;width:12.8px;"></span></span></td>
                                    <td class="delivery align-middle text-start white-space-nowrap text-900 py-2">1.1.0</td>
                                    <td class="total align-middle text-700 text-start py-2">test Description</td>
                                    <td class="date align-middle  fw-semi-bold text-start py-2 text-1000">Dec 12, 12:56 PM
                                    </td>
                                    <td class="align-middle text-start white-space-nowrap pe-0 action py-2">
                                        <div class="font-sans-serif btn-reveal-trigger position-static"><button
                                                class="btn btn-md border bg-light dropdown-toggle dropdown-caret-none transition-none btn-reveal"
                                                type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"><span
                                                    class="fas fa-ellipsis-h fs--2"></span></button>
                                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Activate Module
                                                            </h5><button class="btn p-1" type="button"
                                                                data-bs-dismiss="modal" aria-label="Close"><span
                                                                    class="fas fa-times fs-9"></span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <label
                                                                class="form-label text-1000 fs-0 ps-0 text-capitalize lh-sm mb-2"
                                                                for="adminTitle"> Serial Number </label>
                                                            <input class="form-control" id="adminTitle" type="text"
                                                                placeholder="Serial Number" />
                                                        </div>
                                                        <div class="modal-footer"><button class="btn btn-primary"
                                                                type="button" data-bs-dismiss="modal">Okay</button><button
                                                                class="btn btn-outline-primary" type="button"
                                                                data-bs-dismiss="modal">Cancel</button></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                                    <td class="order align-middle white-space-nowrap py-2 ps-0 text-start"><a
                                            class="fw-semi-bold text-primary" href="#!">Test2</a></td>
                                    <td class="status align-middle white-space-nowrap text-start fw-bold text-700 py-2">
                                        <span class="badge badge-phoenix fs--2 badge-phoenix-danger"><span
                                                class="badge-label">inactive</span><span class="ms-1" data-feather="x"
                                                style="height:12.8px;width:12.8px;"></span></span></td>
                                    <td class="delivery align-middle text-start white-space-nowrap text-900 py-2">1.0.0</td>
                                    <td class="total align-middle text-700 text-start py-2">test Description</td>
                                    <td class="date align-middle  fw-semi-bold text-start py-2 text-1000">Dec 12, 12:56 PM
                                    </td>
                                    <td class="align-middle text-start white-space-nowrap pe-0 action py-2">
                                        <div class="font-sans-serif btn-reveal-trigger position-static"><button
                                                class="btn btn-md border bg-light dropdown-toggle dropdown-caret-none transition-none btn-reveal"
                                                type="button" data-bs-toggle="modal" data-bs-target="#exampleModal"><span
                                                    class="fas fa-ellipsis-h fs--2"></span></button>
                                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Activate Module
                                                            </h5><button class="btn p-1" type="button"
                                                                data-bs-dismiss="modal" aria-label="Close"><span
                                                                    class="fas fa-times fs-9"></span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <label
                                                                class="form-label text-1000 fs-0 ps-0 text-capitalize lh-sm mb-2"
                                                                for="adminTitle"> Serial Number </label>
                                                            <input class="form-control" id="adminTitle" type="text"
                                                                placeholder="Serial Number" />
                                                        </div>
                                                        <div class="modal-footer"><button class="btn btn-primary"
                                                                type="button"
                                                                data-bs-dismiss="modal">Okay</button><button
                                                                class="btn btn-outline-primary" type="button"
                                                                data-bs-dismiss="modal">Cancel</button></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('dashboard') }}/vendors/dataTables.responsive.min.js"></script>
@endsection
