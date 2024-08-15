@extends('dashboard.layouts.app')
@section('title')
    {{ __('Sales Target Details Page') }}
@endsection
@section('css')
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <h4>{{ __('Sales Target') }}</h4>
        </div>

        <div class="card-body">
            <div class="card-title">
                <h5>
                    {{ __('Sales Target Details ') }}
                </h5>
            </div>
            <div class="row mb-3">
                <div class="col-6">
                    <table class="table table-striped table-sm">
                        <tr>
                            <th class="text-center">{{ __('Target name : ') }}</th>
                            <td class="text-center">{{ $salesTarget->target_name }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <th class="text-center">{{ __('Target Types : ') }}</th>
                            <td class="text-center">{{ implode('-', $targetTypes->pluck('title')->toArray()) }}</td>
                            <td class="text-center"></td>
                        </tr>
                        <tr>
                            <th class="text-center">{{ __('Target duration : ') }}</th>
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
                            <td class="text-center">{{ $salesTarget->target_value }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <th class="text-center">{{ __('Sales Agents') }}</th>
                            <td class="text-center">{{ implode('-', $salesAgents->pluck('name')->toArray()) }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <th class="text-center">{{ __('Target Calculation Method') }}</th>
                            <td class="text-center">{{ $salesTarget->target_calc_method }}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <th class="text-center">{{ __('Created by') }}</th>
                            <td class="text-center">{{ $salesTarget->user->name }}</td>
                            <td class="text-center">{{ $salesTarget->created_at }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card-title mt-4">
                <h5>
                    {{ __(' Target Layers Details ') }}
                </h5>

            </div>
            @foreach ($targetTypes as $targetType )
            <div class="card-title">
                <h6>
                    {{ $targetType->title }}
                </h6>
            </div>
            <div class="row mb-3">
                <table class="table table-striped table-sm">
                    <thead>
                        <th class="text-center">{{ __('From') }}</th>
                        <th class="text-center">{{ __('to') }}</th>
                        <th class="text-center">{{ __('Percentage') }}</th>
                    </thead>
                    <tbody>
                        @foreach ($targetLayers as $targetLayer)
                        @if ($targetLayer->target_type_id == $targetType->id)
                        <tr>
                            <td class="text-center">{{ $targetLayer->from }}</td>
                            <td class="text-center">{{ $targetLayer->to }}</td>
                            <td class="text-center">{{ $targetLayer->percentage }}</td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endforeach
        </div>
    </div>
@endsection
@section('js')

@endsection
