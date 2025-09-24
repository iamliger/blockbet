@extends('layouts.app')

@section('body')


	<div class="subWrap">

		<!-- signup -->
		<div class="innerWrap signupWrap">
			<p class="subTitle effect-fadeDown">@lang('Partner Info')</p>

			<!-- tab menu -->
			<div class="tabMenu tab2 effect-fadeUp">
				<button type="button" class="tab current" onclick="location.href='/partner'">@lang('Basic Information')</button>
				<button type="button" class="tab" onclick="location.href='/points'">@lang('User Bets')</button>
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

			<form class="basicForm tabBody tabBody1" action="{{route('partner.update.exchange')}}" method="post" name="frmPointExchange">
			@csrf
			
				<label>
					<p class="text">@lang('My Level')</p>
					<p class="value">{{Auth::user()->level}}</p>
				</label>
				
				<label>
					<p class="text">@lang('My Point')</p>
					<p class="value">{{Auth::user()->point}}
					
					</p>
					
				</label>
				
				<label>
					<p class="text">@lang('Set Point')</p>
					<p class="value">{{Auth::user()->odds*100}}%</p>
				</label>

			

			<div class="flex between" style="margin:30px 0;padding-bottom:10px;border-bottom:1px solid #727272;">
				<span>@lang('BBT token conversion application')</span>
				<button type="button" class="bbtApplyBtn" onclick='bbtApply(this)'>@lang('Apply')</button>
			</div>

			</form> <!-- tabbody 1 -->

            <form class="basicForm tabBody tabBody2 bbsWrap">
                <table>
                <thead>
                    <tr>
                        <th>@lang('User Id')</th>
                        <th>@lang('Registerd At')</th>
                        <th>@lang('Setting')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list as $user)
                    <tr>
                        <td class="text-center">{{$user->name}}</td>
                        <td class="text-center"><p class="alias">{{$user->created_at}}</p></td>
                        <td class="text-center">
                            @if(!$user->odds)
							<div class="flex between">
								<div class="inputBox" style="flex-grow:1;width:4rem;height:30px;margin:0;padding-left:0;">
									<input type="number" min="0" max="{{Auth::user()->odds*100}}" step="0.1" name="odds" id="odds_{{$user->id}}" value="{{$user->odds*100}}">
									<span class="unit">%</span>
								</div>
								<!-- set 'disabled' for buttons with values -->							
								<button type="button" class="btnTransfer" onclick="posintSetting(this,{{$user->id}})" >@lang('Confirm')</button>
							</div>
							@else
							{{$user->odds*100}} %
							@endif 
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
                {{$list->links()}}
            </form>
		</div>

	</div> <!-- subWrap -->

<form method="post" action="{{route('partner.set.odds')}}" name="frmSetOdds">
@csrf
<input type="hidden" name="id" value="" />
<input type="hidden" name="odds" value="" />
</form>

<script>
	function bbtApply(btn) {

		confirmPop('icon-check', "@lang('Thank you.<br><br>Within one hour of applying for conversion Tokens to the BBT account It will be sent.')", "@lang('Confirm')", "@lang('Cancel')", function() {
			// next..
			$(btn).prop('disabled', true);
			document.frmPointExchange.submit();
		});

		
	}

	function posintSetting(btn,id) {
		confirmPop('icon-ask', "@lang('<b>Unable to reset</b><br><br>Do you want to set it up?')", "@lang('Confirm')", "@lang('Cancel')", function() {
			// disable button
			$(btn).prop('disabled', true);
			// next..
			document.frmSetOdds.id.value = id;
			document.frmSetOdds.odds.value = $('#odds_'+id).val();
			document.frmSetOdds.submit();

		});
	}

	@error('odds','alert-error')
	
	$(function(){
		alertPop('icon-error','{{$message}}');
	});

	@enderror


</script>




<style>
.text-center{
    text-align:center;
} 
.btnTransfer{
	height:30px;
	margin-left:5px;
    padding:0 0.5em;
    font-weight:400;
    font-size: 1.1em;
	color:#000 !important;
	white-space:nowrap;
    background: #e8bd71;
}
.btnTransfer:disabled {background-color:#555;color:#fff;}
</style>
@endsection

@push('scripts')

@auth
	<script>
    
    function transfer(name){
        let amount = window.prompt('Input amount for sending',"1");
        amount = $.trim(amount);
        if(/^[0-9]+(\.[0-9]+)?$/ && amount > 0){
            $.post('/api/user/transfer',{amount,'api_token':'{{Auth::user()->api_token}}',name},(data)=>{
                alert(data.message);
            });
        }else alert('Cannot send '+amount+' BBT ');
    }
 
	</script>
@endauth
@endpush