@extends('emails._layout')

@section('title', 'تایید ایمیل')

@section('body')
    <strong>{{ $user->full_name }}</strong> <span>عزیز</span> سلام

    <p style="margin:10px 0">
        برای تایید ایمیل خود در استادیو بر روی دکمه زیر کلیک کنید
    </p>

    دکمه تایید ایمیل در رستادیو:

    <div style="text-align: center; margin-top: 12px">
        <a class="btn btn-primary" href="{{ route('account.email.verify' , ['token' => $token]) }}">
            {{ trans('general.confirm') }}
        </a>
    </div>
@endsection
