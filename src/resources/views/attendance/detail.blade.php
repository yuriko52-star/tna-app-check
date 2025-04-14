@extends('layouts.app')
<!--userとadminで画面を分けること。コントローラも -->
@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}" class="">
@endsection

@section('content')
<div class="content">
    <div class="title">
        <div class="image">
          <img src="{{asset('img/Line 2.png')}}" style="height:40px;width:8px;"alt="" class="img">
        </div>
          <h1>勤怠詳細</h1> 
    </div> 
    <table>
        
        <form action="{{ route('attendance.update', ['id' => $attendance->id]) }}" method="POST">
        @csrf
            
        <tr>
            <th class="data-label">名前</th>
            <td class="data-item">
                <span class="name">{{ $attendance->user->name}}</span>
            </td>
        </tr>
        <tr>
            <th class="data-label">日付</th>
            <td class="data-item">
                <div class="date-wrapper">
                    <span class="year">{{$year}}</span>
                    <span class="date-space"></span>
                    <span class="date">{{ $monthDay}}</span>
                </div>
            </td>
        </tr>
        <tr>
            <th class="data-label">
                <span class="work">出勤・退勤</span>
            </th>
            <td class="data-item">
                <div class="time-wrapper">
                    <input type="text" class="time-input" name="clock_in"value="{{ old('clock_in' ,$attendance->clock_in ? \Carbon\Carbon::parse($attendance->clock_in)->format('H:i') : '') }}">
                    <span class="time-separator">~</span>
                    <input type="text" class="time-input"name="clock_out" value="{{ old('clock_out', $attendance->clock_out ? \Carbon\Carbon::parse($attendance->clock_out)->format('H:i') : '') }}">
                </div> 
                <p class="form_error">
                    @error('clock_time_invalid')
                    {{ $message}}
                    @enderror
                </p>
                 <p class="form_error">
                    @error('clock_in')
                    {{ $message}} 
                    @enderror
                </p>    
                <p class="form_error">
                    @error('clock_out')
                    {{ $message}} 
                    @enderror
                </p>    
                
            </td>
        </tr>
        @foreach($attendance->breakTimes as $i => $break)
        <tr>
            <th class="data-label">休憩{{ $i> 0 ? $i+1 : '' }}</th>
            <td class="data-item">
                <div class="time-wrapper">
                    <input type="hidden" class=""name="breaks[{{ $i }}][id]" value="{{$break->id}}">

                    <input type="text" class="time-input"name="breaks[{{ $i}}][clock_in]" value="{{ old("breaks.$i.clock_in",$break->clock_in  ? \Carbon\Carbon::parse($break->clock_in)->format('H:i') : '' )}}">
                    <span class="time-separator">~</span> 
                    <input type="text" class="time-input"name="breaks[{{$i}}][clock_out]" value="{{ old("breaks.$i.clock_out",$break->clock_out ? \Carbon\Carbon::parse($break->clock_out)->format('H:i') : '' )}}">
                </div>
                <p class="form_error">
                    @error("breaks.$i.outside_working_time")
                    {{$message}}
                    @enderror
                </p>
                 <p class="form_error">
                    @error('breaks.*.clock_in')
                    {{ $message}} 
                    @enderror
                </p>    
                <p class="form_error">
                    @error('breaks.*.clock_out')
                    {{ $message}} 
                    @enderror
                </p>    
            </td>
        </tr>
        @endforeach
         <tr>
            <th class="data-label">休憩{{ count($attendance->breakTimes)+ 1}} </th>
            <td class="data-item">
                <div class="time-wrapper">
                    <input type="text" class="time-input" name="breaks[{{ count($attendance->breakTimes) }}][clock_in]"value="{{ old('breaks.' . count($attendance->breakTimes) . '.clock_in') }}">
                    <span class="time-separator">~</span> 
                    <input type="text" class="time-input"name ="breaks[{{ count($attendance->breakTimes) }}][clock_out]" value="{{ old('breaks.' . count($attendance->breakTimes) . '.clock_out') }}">

                </div>
                @php
                    $index = count($attendance->breakTimes);
                @endphp

            <p class="form_error">
               @error("breaks.$index.outside_working_time")
                    {{$message}}
                @enderror
            </p>
            </td>
        </tr>
        <tr>
            <th class="data-label">備考</th>
            <td class="data-item">
               <textarea class="reason-input" name="reason"></textarea>
            
            <p class="form_error">
                @error('reason')
                {{ $message}}
                @enderror
            </p>
            </td>
        </tr>
    </table>
        <div class="button">
            <button class="edit-btn" type="submit">修正</button>
        </div>
        </form>
</div>
@endsection   