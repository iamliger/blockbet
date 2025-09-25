{{-- resources/views/admin/users/edit.blade.php --}}
@extends('admin.layouts.master')

@section('title', '사용자 수정')

@section('content_header')
    <h1 class="m-0 text-dark">사용자 수정</h1>
@stop

@section('admin_content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">사용자 정보 수정: {{ $user->name }}</h3>
            <div class="card-tools">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> 회원 목록으로 돌아가기</a>
            </div>
        </div>
        <div class="card-body">
            {{-- 수정 폼 시작 --}}
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- PUT 메서드를 사용해야 updateUser 컨트롤러 메서드로 매핑됩니다 --}}

                <div class="form-group">
                    <label for="name">이름</label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">이메일</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="level">레벨</label>
                    <input type="number" name="level" id="level" class="form-control @error('level') is-invalid @enderror" value="{{ old('level', $user->level) }}" min="0" max="10" required>
                    @error('level')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="point">포인트</label>
                    <input type="number" name="point" id="point" class="form-control @error('point') is-invalid @enderror" value="{{ old('point', $user->point) }}" step="0.01" min="0" required>
                    @error('point')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address">지갑 주소</label>
                    <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $user->address) }}" readonly>
                    @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="recommander">추천인</label>
                    <input type="text" name="recommander" id="recommander" class="form-control @error('recommander') is-invalid @enderror" value="{{ old('recommander', $user->recommander) }}" readonly>
                    @error('recommander')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                
                {{-- 추가 필드 (store, odds, otex, country, mobile, super, hq, dist)도 필요에 따라 여기에 추가 --}}

                <button type="submit" class="btn btn-primary">정보 업데이트</button>
            </form>
            {{-- 수정 폼 끝 --}}
        </div>
    </div>
@stop