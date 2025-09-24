@extends('layouts.app')

@section('body')


	<div class="subWrap">

		<!-- signup -->
		<div class="innerWrap signupWrap">
			<p class="subTitle effect-fadeDown">@lang('TRANSFER HISTORY')</p>		

            <form class="basicForm tabBody tabBody2 bbsWrap">
                <table>
                <thead>
                    <tr>
                        <th>@lang('Name')</th>
                        <th>@lang('Amount')</th>
                        <th>@lang('Address')</th>                        
                        <th>@lang('Status')</th>
                        <th>@lang('Registerd At')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($list as $transfer)
                    <tr>
                        <td class="text-center" rowspan="2">{{$transfer->toName}}</td>
                        
                        <td class="text-center">{{$transfer->amount}}</td>                        
                        <td><p class="address">{{$transfer->toAddress}}</p></td>                        
                        <td  class="text-center">
                            @if($transfer->status === 'R')
                            <span class="badge border border-secondary text-secondary">Requested</span>
                            @elseif($transfer->status === 'S')
                            <span class="badge border border-info text-info">Processing</span>
                            @elseif($transfer->status === 'F')
                            <span class="badge border border-primary text-primary">Completed</span>
                            @elseif($transfer->status === 'C')
                            <span class="badge border border-dark text-dark">Canceled</span>                                    
                            @else
                                {{$transfer->status}} 
                            @endif
                        </td>                                                        
                        <td class="text-center"><p class="alias">{{$transfer->created_at}}</p></td>
                    </tr>
                    <tr>
                        
                        <td>Tid</td>
                        <td colspan="3" >{{$transfer->tid}}</td>
                        
                    </tr>
                    @endforeach
                </tbody>
                </table>
                
            </form>
		</div>

	</div> <!-- subWrap -->
<style>
.text-center{
    text-align:center;
} 
@endsection

@push('scripts')

@endpush