{{-- resources/views/admin/settings/capital-manage.blade.php --}}
@extends('admin.layouts.master')

@section('title', '자본금 관리')

@section('content_header')
    <h1 class="m-0 text-dark">자본금 관리</h1>
@stop

@section('admin_content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">현재 총자본금 현황</h3>
            <div class="card-tools">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> 대시보드로 돌아가기</a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="alert alert-info">
                현재 총자본금: <strong>{{ number_format($currentTotalAssets, config('app.amount_decimals')) }}</strong>
            </div>

            <h4 class="mt-4">자본금 추가 / 회수</h4>
            <form action="{{ route('admin.settings.capital-manage') }}" method="POST" onsubmit="return cleanAmountForSubmission(this);">
                @csrf

                <div class="form-group">
                    <label for="amount">금액</label>
                    <input type="text" name="amount" id="amount" 
                           class="form-control @error('amount') is-invalid @enderror" 
                           value="{{ old('amount', number_format(0.00, config('app.amount_decimals'))) }}" 
                           oninput="formatNumberInput(this)" onblur="formatNumberInput(this, true)" 
                           required>
                    @error('amount')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="operation_type">작업 유형</label>
                    <select name="operation_type" id="operation_type" class="form-control" required>
                        <option value="add">자본금 추가</option>
                        <option value="withdraw">자본금 회수</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">처리</button>
            </form>

            <h4 class="mt-5">자본금 변동 내역</h4>
            <div class="table-responsive">
                <table class="table table-striped table-bordered text-nowrap">
                    <thead>
                        <tr>
                            <th class="text-nowrap">ID</th>
                            <th class="text-nowrap">타입</th>
                            <th class="text-nowrap">변동 금액</th>
                            <th class="text-nowrap">변동 전 자산</th>
                            <th class="text-nowrap">변동 후 자산</th>
                            <th class="text-nowrap">설명</th>
                            <th class="text-nowrap">날짜</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($history as $record)
                        <tr>
                            <td class="text-nowrap">{{ $record->id }}</td>
                            <td class="text-nowrap">{{ $record->type }}</td>
                            <td class="text-nowrap">{{ number_format($record->amount, config('app.amount_decimals')) }}</td>
                            <td class="text-nowrap">{{ number_format($record->previous_total_assets, config('app.amount_decimals')) }}</td>
                            <td class="text-nowrap">{{ number_format($record->new_total_assets, config('app.amount_decimals')) }}</td>
                            <td class="text-nowrap">{{ $record->description }}</td>
                            <td class="text-nowrap">{{ $record->created_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $history->links('vendor.pagination.adminlte') }}
            </div>
        </div>
    </div>
@stop

@section('js')
    @parent
    <script>
        // 숫자 입력 자동 콤마 포맷팅 함수 (기존 함수와 동일)
        function formatNumberInput(input, blur = false) {
            let value = input.value.replace(/[^0-9.]/g, '');
            let parts = value.split('.');
            let integerPart = parts[0];
            let decimalPart = parts.length > 1 ? parts[1] : '';

            const decimals = window.APP_AMOUNT_DECIMALS;

            if (decimalPart.length > decimals) {
                decimalPart = decimalPart.substring(0, decimals);
            }

            integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

            let formattedValue = integerPart;
            if (decimals > 0) {
                if (parts.length > 1) {
                    formattedValue += '.' + decimalPart;
                } else if (blur) {
                    formattedValue += '.' + '0'.repeat(decimals);
                }
            } else {
                formattedValue = integerPart;
            }
            
            input.value = formattedValue;
        }

        // 폼 제출 전에 금액 필드의 콤마를 제거하는 함수
        function cleanAmountForSubmission(form) {
            const amountInput = form.querySelector('#amount');
            if (amountInput) {
                console.log('DEBUG (Client): Amount before cleaning:', amountInput.value); // <-- 디버그 로그
                amountInput.value = amountInput.value.replace(/,/g, '');
                console.log('DEBUG (Client): Amount after cleaning:', amountInput.value); // <-- 디버그 로그
            }
            return true; // 폼 제출 계속
        }

        // 페이지 로드 시 초기값 포맷팅
        $(document).ready(function() {
            const amountInput = document.getElementById('amount');
            if (amountInput) {
                formatNumberInput(amountInput, true);
            }
        });
    </script>
@stop