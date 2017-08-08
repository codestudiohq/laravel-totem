@if(session()->has('success'))
    @component('totem::partials.message')
        @slot('class')
            bgsuccess tcw
        @endslot
        {{session()->get('success')}}
    @endcomponent
@endif
@if($errors->any())
    @component('totem::partials.message')
        @slot('class')
            bg1 tcw
        @endslot
        Please Correct the errors and try resubmitting.
    @endcomponent
@endif