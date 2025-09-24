@extends('layouts.app')

@section('body')


	<div class="subWrap">

		<!-- signup -->
		<div class="innerWrap signupWrap">
			<p class="subTitle effect-fadeDown">@lang('Partner Info')</p>

			<!-- tab menu -->
			<div class="tabMenu tab2 effect-fadeUp">
				<button type="button" class="tab" onclick="location.href='/partner'">@lang('Basic Information')</button>
				<button type="button" class="tab current" onclick="location.href='/points'">@lang('User Bets')</button>
			</div>

			@if ($errors->any())
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

            <form class="basicForm tabBody tabBody2 bbsWrap">
                <table >
                <thead>
                    <tr>
                        <th>@lang('User Id')</th>
                        <th>@lang('Game')</th>
                        <th>@lang('Bet')</th>
                        <th>@lang('Profit')</th>
                        <th>@lang('created_at')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list as $point)
                    <tr>
                        <td class="text-center">{{$point->fromName}}</td>
                        <td class="text-center"><p class="address">{{$point->game}}</p></td>
                        <td class="text-center"><p class="alias">{{$point->amount}}</p></td>                        
                        <td class="text-center"><p class="alias">{{$point->request}}</p></td>
                        <td class="text-center"><p class="alias">{{$point->created_at}}</p></td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
                {{$list->links()}}
            </form>
		</div>

	</div> <!-- subWrap -->
<style>
.text-center{
    text-align:center;
}
</style>
@endsection

@push('scripts')


	<script>



	</script>

@endpush