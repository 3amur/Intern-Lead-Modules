<button id="importBtn" onclick="$('#importFile').trigger('click')" class="btn btn-success btn-sm mx-2 float-end"
    style="border-radius: 0.375rem;">
    <i class="fas fa-upload me-2 " style="color: #ffffff;"></i>{{ __('Import') }}
    <div id="importProgress" style="height: 25px;width: 73px;" class="progress d-none">
        <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0"
            aria-valuemax="100">25%</div>
    </div>
</button>
<input type="file" class="d-none" id="importFile" accept=".csv,.xlsx,.xls">
