@if(session()->has('success'))
    <vk-alert type="success">
        {{session()->get('success')}}
    </vk-alert>
@endif
@if($errors->any())
    <vk-alert type="danger">
        Please Correct the errors and try resubmitting.
    </vk-alert>
@endif