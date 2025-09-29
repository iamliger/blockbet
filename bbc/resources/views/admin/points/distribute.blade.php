{{-- resources/views/admin/points/distribute.blade.php --}}
@extends('admin.layouts.master')

@section('title', '포인트 지급 (슈퍼관리자)')

@section('content_header')
    <h1 class="m-0 text-dark">포인트 지급</h1>
@stop

@section('admin_content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">회원에게 포인트 지급</h3>
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

            <form action="{{ route('admin.points.distribute') }}" method="POST" onsubmit="return cleanAmountForSubmission(this);">
                @csrf

                <div class="form-group">
                    <label for="target_user_id">지급 대상 회원</label>
                    <select name="target_user_id[]" id="target_user_id" 
                            class="form-control select2-ajax @error('target_user_id') is-invalid @enderror" 
                            multiple="multiple" data-placeholder="회원 이름 또는 이메일 검색" style="width: 100%;" required>
                        @if(old('target_user_id'))
                            @foreach(old('target_user_id') as $oldUserId)
                                @php $oldUser = App\User::find($oldUserId); @endphp
                                @if($oldUser)
                                    <option value="{{ $oldUser->id }}" selected>
                                        {{ $oldUser->name }} (Email: {{ $oldUser->email }}, 레벨: {{ $oldUser->level }})
                                    </option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                    @error('target_user_id')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="amount">지급 금액</label>
                    <input type="text" name="amount" id="amount"
                           class="form-control @error('amount') is-invalid @enderror" 
                           value="{{ old('amount', number_format(0.00, 2)) }}"
                           oninput="formatNumberInput(this)" onblur="formatNumberInput(this, true)"
                           required>
                    @error('amount')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">포인트 지급</button>
            </form>
        </div>
    </div>
@stop

@section('js')
    @parent
    <script>
        // 숫자 입력 자동 콤마 포맷팅 함수 (재사용)
        function formatNumberInput(input, blur = false) {
            let value = input.value.replace(/[^0-9.]/g, ''); // 숫자와 소수점만 남기기
            let parts = value.split('.');
            let integerPart = parts[0];
            // let decimalPart = parts.length > 1 ? '.' + parts[1].substring(0, 2) : ''; // <-- 소수점 부분 제거
            let formattedValue = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ','); // 3자리 콤마

            input.value = formattedValue;
        }

        // 폼 제출 전에 금액 필드의 콤마를 제거하는 함수
        function cleanAmountForSubmission(form) {
            const amountInput = form.querySelector('#amount');
            if (amountInput) {
                amountInput.value = amountInput.value.replace(/,/g, ''); // 모든 콤마 제거
            }
            return true; // 폼 제출 계속
        }
        
        // 페이지 로드 시 초기값 포맷팅 (optional)
        $(document).ready(function() {
            $('.select2-ajax').select2({
                theme: 'bootstrap4',
                width: 'resolve',
                ajax: {
                    url: "{{ route('admin.users.search') }}", // Ajax 검색을 위한 API 라우트
                    dataType: 'json',
                    delay: 250, // 쿼리 요청 전 지연 시간
                    data: function (params) {
                        return {
                            q: params.term // 검색어
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: data.results
                        };
                    },
                    cache: true
                },
                minimumInputLength: 2, // 최소 2글자 이상 입력 시 검색 시작
                placeholder: "회원 이름 또는 이메일 검색",
                language: { // <-- 언어 설정 추가 (필요시)
                    inputTooShort: function () {
                        return "2자 이상 입력해주세요.";
                    },
                    noResults: function () {
                        return "검색 결과가 없습니다.";
                    },
                    searching: function () {
                        return "검색 중...";
                    },
                    errorLoading: function () {
                        return "결과를 불러올 수 없습니다.";
                    }
                }
            });
            
            const amountInput = document.getElementById('amount');
            if (amountInput) {
                formatNumberInput(amountInput, true);
            }
        });
    </script>
@stop