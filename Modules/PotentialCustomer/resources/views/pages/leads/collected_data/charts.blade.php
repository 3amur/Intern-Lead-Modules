@extends('dashboard.layouts.app')
@section('title')
{{ __('Cahrts Page') }}
@endsection
@section('css')
@endsection
@section('content')
<div id="main" style="width: 600px;height:400px;"></div>

@endsection
@section('js')
<script src="{{ asset('dashboard/vendors/echarts/echarts.min.js') }}"></script>

<script type="text/javascript">
    // Initialize the echarts instance based on the prepared dom
    var myChart = echarts.init(document.getElementById('main'));

    // Specify the configuration items and data for the chart
    var option = {
      title: {
        text: 'ECharts Getting Started Example'
      },
      tooltip: {},
      legend: {
        data: ['sales']
      },
      xAxis: {
        data: ['Shirts', 'Cardigans', 'Chiffons', 'Pants', 'Heels', 'Socks']
      },
      yAxis: {},
      series: [
        {
          name: 'sales',
          type: 'bar',
          data: [-41, 20, 36, 10, 50, 20]
        }
      ]
    };

    // Display the chart using the configuration items and data just specified.
    myChart.setOption(option);
  </script>
@endsection
