{{-- resources/views/admin/partners/send-points.blade.php --}}
@extends('admin.layouts.master')

@section('title', '하위 멤버 포인트 지급')

@section('content_header')
    <h1 class="m-0 text-dark">하위 멤버 포인트 지급</h1>
@stop

@section('admin_content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">내 하위 멤버에게 포인트 지급</h3>
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

            <form action="{{ route('admin.partners.send-points') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="target_member_id">지급 대상 하위 멤버</label>
                    <select name="target_member_id" id="target_member_id" class="form-control @error('target_member_id') is-invalid @enderror" required>
                        <option value="">-- 하위 멤버 선택 --</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}" {{ old('target_member_id') == $member->id ? 'selected' : '' }}>
                                {{ $member->name }} (레벨: {{ $member->level }}, 현재 포인트: {{ number_format($member->point, 2) }})
                            </option>
                        @endforeach
                    </select>
                    @error('target_member_id')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="amount">지급 금액</label>
                    <input type="number" name="amount" id="amount" 
                           class="form-control @error('amount') is-invalid @enderror" 
                           value="{{ old('amount', 0.00) }}" step="0.01" min="0.01" required>
                    @error('amount')
                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">포인트 지급</button>
            </form>
        </div>
    </div>
@stop