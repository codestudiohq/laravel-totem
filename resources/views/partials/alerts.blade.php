@if(session()->has('success'))
    <uikit-alert type="success">
        {{session()->get('success')}}
    </uikit-alert>
@endif
@if($errors->any())
    <uikit-alert type="danger">
        Please Correct the errors and try resubmitting.
    </uikit-alert>
@endif