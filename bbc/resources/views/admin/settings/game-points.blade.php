{{-- resources/views/admin/settings/game-points.blade.php --}}
@extends('admin.layouts.master')

@section('title', '게임포인트 설정')

@section('content_header')
    <h1 class="m-0 text-dark">게임포인트 설정</h1>
@stop

@section('admin_content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">총자산 설정</h3>
            <div class="card-tools">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> 대시보드로 돌아가기</a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form action="{{ route('admin.settings.game-points.update') }}" method="POST">
                @csrf
                @method('PUT') {{-- PUT 메서드 사용 --}}

                <div class="form-group">
                    <label for="total_assets">총자산</label>
                    <input type="text" name="total_assets" id="total_assets" {{-- type="number" 대신 text 사용 --}}
                           class="form-control @error('total_assets') is-invalid @enderror" 
                           value="{{ old('total_assets', number_format($totalAssets, 2)) }}" {{-- 초기 값도 포맷팅 --}}
                           oninput="formatNumberInput(this)" onblur="formatNumberInput(this, true)" {{-- JavaScript 이벤트 추가 --}}
                           required>
                    @error('total_assets')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">설정 저장</button>
            </form>
        </div>
    </div>
@stop

@section('js')
    @parent
    <script>
        // 숫자 입력 자동 콤마 포맷팅 함수
        // input: 입력 필드 요소, blur: blur 이벤트인지 여부 (true면 소수점 자리수 유지)
        function formatNumberInput(input, blur = false) {
            let value = input.value.replace(/[^0-9.]/g, ''); // 숫자와 소수점만 남기기
            let parts = value.split('.');
            let integerPart = parts[0];
            let decimalPart = parts.length > 1 ? '.' + parts[1].substring(0, 2) : ''; // 소수점 두 자리까지

            integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ','); // 3자리 콤마

            if (blur && decimalPart === '') {
                // blur 이벤트이고 소수점 부분이 없다면 .00 추가
                input.value = integerPart + '.00';
            } else {
                input.value = integerPart + decimalPart;
            }
        }

        // 페이지 로드 시 초기값 포맷팅 (optional)
        $(document).ready(function() {
            const totalAssetsInput = document.getElementById('total_assets');
            if (totalAssetsInput) {
                formatNumberInput(totalAssetsInput, true); // 페이지 로드 시 .00 추가
            }
        });
    </script>
@stop