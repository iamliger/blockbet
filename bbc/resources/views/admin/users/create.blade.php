{{-- resources/views/admin/users/create.blade.php --}}
@extends('admin.layouts.master')

@section('title', '회원 추가')

@section('content_header')
    <h1 class="m-0 text-dark">회원 추가</h1>
@stop

@section('admin_content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">새로운 사용자 등록</h3>
            <div class="card-tools">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> 회원 목록으로 돌아가기</a>
            </div>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">이름 <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">이메일 <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password">비밀번호 <span class="text-danger">*</span></label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">비밀번호 확인 <span class="text-danger">*</span></label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="level">레벨 <span class="text-danger">*</span></label>
                    <input type="number" name="level" id="level" class="form-control @error('level') is-invalid @enderror" value="{{ old('level', 0) }}" min="0" max="10" required>
                    @error('level')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="point">포인트 <span class="text-danger">*</span></label>
                    <input type="number" name="point" id="point" class="form-control @error('point') is-invalid @enderror" value="{{ old('point', 0) }}" step="0.01" min="0" required>
                    @error('point')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="recommander">추천인 (선택 사항)</label>
                    <select name="recommander" id="recommander" class="form-control @error('recommander') is-invalid @enderror">
                        <option value="">-- 추천인 없음 --</option>
                        @foreach($recommenders as $recommander)
                            <option value="{{ $recommander->name }}" {{ old('recommander') == $recommander->name ? 'selected' : '' }}>
                                {{ $recommander->name }} (ID: {{ $recommander->id }})
                            </option>
                        @endforeach
                    </select>
                    @error('recommander')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                {{-- 추가 필드 (country, mobile, address, otex, odds, super, hq, dist)도 필요에 따라 추가 --}}
                <div class="form-group">
                    <label for="country">국가</label>
                    <input type="text" name="country" id="country" class="form-control @error('country') is-invalid @enderror" value="{{ old('country', 'Unknown') }}">
                    @error('country')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="mobile">모바일</label>
                    <input type="text" name="mobile" id="mobile" class="form-control @error('mobile') is-invalid @enderror" value="{{ old('mobile', 'N/A') }}">
                    @error('mobile')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address">지갑 주소</label>
                    <input type="text" name="address" id="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', '') }}">
                    @error('address')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">회원 등록</button>
            </form>
        </div>
    </div>
@stop