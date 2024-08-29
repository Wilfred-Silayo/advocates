@extends('layout.app')
@section('title','Disclaimer')

@section('content')
<div class="container-fluid">
    <div class="container mt-4">
        <h3 class="text-center fw-bold">DISCLAIMER</h3>
        <p class="fw-medium">The information contained under this website (“Service”) is for general information
            purposes only.
        </p>
        <p class="fw-medium"><span class="fw-bold">Privacy centre</span> assumes no responsibility for errors or
            omissions in the contents
            on
            the Service.
            In no event shall <span class="fw-bold"> Privacy Centre</span> be liable for any special, direct, indirect,
            consequential, or incidental
            damages or any damages whatsoever, whether in an action of contract, negligence or other tort, arising out
            of or
            in connection with the use of the Service or the contents of the Service. <span class="fw-bold"> Privacy
                Centre</span> reserves the right to
            make additions, deletions, or modification to the contents on the Service at any time without prior notice.
        </p>
        <p class="fw-medium"><span class="fw-bold"> Privacy Centre</span> does not warrant that the website is free
            of viruses or other
            harmful components.</p>

    </div>
    <div class="row btn-teal">
        <x-footer-component />
    </div>
</div>
@endsection