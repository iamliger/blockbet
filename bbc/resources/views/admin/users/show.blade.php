{{-- resources/views/admin/users/show.blade.php --}}
@extends('admin.layouts.master')

@section('title', '사용자 상세 정보')

@section('content_header')
    <h1 class="m-0 text-dark">사용자 상세 정보</h1>
@stop

@section('admin_content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">사용자: {{ $user->name }} (ID: {{ $user->id }})</h3>
            <div class="card-tools">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm mr-2"><i class="fas fa-edit"></i> 수정</a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> 회원 목록으로</a>
            </div>
        </div>
        <div class="card-body">
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">이름:</label>
                <div class="col-sm-9"><p class="form-control-static">{{ $user->name }}</p></div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">이메일:</label>
                <div class="col-sm-9"><p class="form-control-static">{{ $user->email }}</p></div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">레벨:</label>
                <div class="col-sm-9"><p class="form-control-static">{{ $user->level }}</p></div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">포인트:</label>
                <div class="col-sm-9"><p class="form-control-static">{{ number_format($user->point, config('app.amount_decimals')) }}</p></div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">지갑 주소:</label>
                <div class="col-sm-9">
                    <p class="form-control-static">
                        <span title="{{ $user->address }}"
                              onclick="copyToClipboard(this, '{{ $user->address }}')"
                              style="cursor: pointer; text-decoration: underline;">
                            {{ $user->address }}
                        </span>
                    </p>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">추천인:</label>
                <div class="col-sm-9"><p class="form-control-static">{{ $user->recommander ?? '없음' }}</p></div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">스토어:</label>
                <div class="col-sm-9"><p class="form-control-static">{{ $user->store ?? '없음' }}</p></div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">가입일:</label>
                <div class="col-sm-9"><p class="form-control-static">{{ $user->created_at->format('Y-m-d H:i:s') }}</p></div>
            </div>
            {{-- 추가 필드 --}}
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">모바일:</label>
                <div class="col-sm-9"><p class="form-control-static">{{ $user->mobile ?? 'N/A' }}</p></div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">국가:</label>
                <div class="col-sm-9"><p class="form-control-static">{{ $user->country ?? 'N/A' }}</p></div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Otex 주소:</label>
                <div class="col-sm-9"><p class="form-control-static">{{ $user->otex ?? '없음' }}</p></div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">배당률:</label>
                <div class="col-sm-9"><p class="form-control-static">{{ $user->odds ?? '0' }}</p></div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Super:</label>
                <div class="col-sm-9"><p class="form-control-static">{{ $user->super ?? '없음' }}</p></div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">HQ:</label>
                <div class="col-sm-9"><p class="form-control-static">{{ $user->hq ?? '없음' }}</p></div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Dist:</label>
                <div class="col-sm-9"><p class="form-control-static">{{ $user->dist ?? '없음' }}</p></div>
            </div>
        </div>
    </div>
@stop

@section('js')
    @parent
    <script>
        function copyToClipboard(element, textToCopy) {
            navigator.clipboard.writeText(textToCopy).then(function() {
                element.style.color = 'green';
                element.textContent = 'Copied!';
                setTimeout(() => {
                    element.style.color = '';
                    element.textContent = textToCopy; // 상세 보기에서는 전체 주소 유지
                }, 1500);
            }).catch(function(err) {
                console.error('클립보드 복사 실패:', err);
                alert('클립보드 복사 실패!');
            });
        }
    </script>
@stop