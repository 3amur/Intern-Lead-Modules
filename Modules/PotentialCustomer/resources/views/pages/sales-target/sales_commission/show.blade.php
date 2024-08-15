@extends('dashboard.layouts.app')
@section('title')
    {{ __('Sales Agent Details Page') }}
@endsection
@section('css')
@endsection
@section('content')
    {{-- Begin breadcrumb --}}
    <x-potentialcustomer::breadcrumb>
        <x-potentialcustomer::breadcrumb-item>
            <a href="{{ route('lead_home.index') }}">{{ __('Home') }}</a>
        </x-potentialcustomer::breadcrumb-item>

        <x-potentialcustomer::breadcrumb-item>
            <a href="{{ route('sales_agents.index') }}">{{ __('Sales Agents') }}</a>
        </x-potentialcustomer::breadcrumb-item>

        <x-potentialcustomer::breadcrumb-item>
            {{ __($salesAgent->name . ' Details Page') }}
        </x-potentialcustomer::breadcrumb-item>
    </x-potentialcustomer::breadcrumb>
    {{-- End breadcrumb --}}


    <div class="container">
        @include('dashboard.layouts.alerts')

        <div class="card my-3">
            <div class="card-header">
                <h5> {{ __($salesAgent->name . ' Details Page') }}</h5>
            </div>
            <div class="card-body">
                @if ($salesTargets->all() == null)
                    <h6>{{ __('No Targets Fount For this Agent') }}</h6>
                @else
                    @foreach ($salesTargets as $salesTarget)
                        <div class="row mb-3">
                            <div class="col-6">
                                <table class="table table-striped table-sm">
                                    <tr>
                                        <th class="text-center">{{ __('Target name : ') }}</th>
                                        <td class="text-center">{{ $salesTarget->target_name }}</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th class="text-center">{{ __('Target duation : ') }}</th>
                                        <td class="text-center">{{ __('From : ') . $salesTarget->start_date }}</td>
                                        <td class="text-center">{{ __(' To :') . $salesTarget->end_date }}</td>
                                    </tr>
                                    <tr>
                                        <th class="text-center">{{ __('Target Status : ') }}</th>
                                        <td class="text-center">{{ $salesTarget->status }}</td>
                                        <td></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-6">
                                <table class="table table-striped table-sm">
                                    <tr>
                                        <th class="text-center">{{ __('Target value') }}</th>
                                        <td class="text-center"><span
                                                class="badge badge-phoenix badge-phoenix-info">{{ 'Total: ' .number_format($salesTarget->target_value, 2, '.', ',') }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if ($salesTarget->target_calc_method == 'separate')
                                                <span
                                                    class="badge badge-phoenix badge-phoenix-info">{{ 'Per Agent: ' . number_format($salesTarget->target_value, 2, '.', ',') }}</span>
                                            @else
                                            <span class="badge badge-phoenix badge-phoenix-info">{{ 'Per Agent: ' . number_format($salesTarget->target_value / ($salesAgentsCounts = $salesTarget->salesAgents->count()), 2, '.', ',')  }}</span>

                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="text-center">{{ __('Target Calculation Method') }}</th>
                                        <td class="text-center"><span
                                                class="badge badge-phoenix badge-phoenix-info">{{ $salesTarget->target_calc_method }}</span>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <th class="text-center">{{ __('Created by') }}</th>
                                        <td class="text-center">{{ $salesTarget->user->name }}</td>
                                        <td class="text-center">{{ $salesTarget->created_at }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="row mb-3">
                                <h6>{{ __('Notes') }}</h6>
                                <p>{{ $salesTarget->notes }}</p>
                            </div>
                            <hr>
                        </div>

                        @foreach ($salesTarget->targetTypes as $targetType)
                            <div class="border border-secondary mb-3 py-2 px-1">
                                <div class="card-title">
                                    <h5>{{ $targetType->title }}</h5>
                                </div>
                                @if (!empty($targetType->targetLayers->where('sales_target_id', $salesTarget->id)->all()))
                                    <table class="table  table-striped table-bordered table-sm fs--1 mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">From</th>
                                                <th class="text-center">To</th>
                                                <th class="text-center">Percentage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($targetType->targetLayers->where('sales_target_id', $salesTarget->id) as $targetLayer)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td class="text-center">{{ number_format($targetLayer->from, 2, '.', ',') }}</td>
                                                    <td class="text-center">{{ number_format($targetLayer->to, 2, '.', ',') }}</td>
                                                    <td class="text-center">{{ $targetLayer->percentage . ' %' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p>
                                        {{ 'No Layers Found' }}
                                    </p>
                                @endif
                            </div>
                        @endforeach
                    @endforeach
                @endif
            </div>
            <div class="card-footer d-flex justify-content-center">
                <div class="">{{ $salesTargets->links() }}</div>
            </div>
        </div>
    </div>
@endsection
@section('js')
@endsection
