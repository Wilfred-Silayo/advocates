@extends('layout.app')
@section('title','Terms and Conditions')

@section('content')
<div class="container-fluid">
    <div class="container mt-4">
        <h3 class="fw-bold text-center">Terms and Conditions</h3>

        <p class="fw-medium">
            Please read these Terms and Conditions (“Terms”, “Terms and Conditions”) carefully before using our website
            (the “Service”) operated by Privacy Centre (“us”, “we”, or “our”).
        </p>
        <p class="fw-medium">
            Your access to and use of the Service is conditioned on your acceptance of and compliance with these Terms.
            These Terms apply to all visitors, users and others who access or use the Service.
        </p>
        <p class="fw-medium">
            By accessing or using the Service you agree to be bound by these Terms. If you disagree with any part of the
            terms then you may not access the Service.
        </p>
        <h3 class="mt-4 fw-bold text-center">Links To Other Web Sites</h3>
        <p class="fw-medium">
            Our Service may contain links to third-party web sites or services that are not owned or controlled by
            Privacy Centre.
        </p>
        <p class="fw-medium">
            Privacy Centre has no control over, and assumes no responsibility for, the content, privacy policies, or
            practices of any third-party web sites or services. You further acknowledge and agree that Privacy Centre
            shall not be responsible or liable, directly or indirectly, for any damage or loss caused or alleged to be
            caused by or in connection with use of or reliance on any such content, goods or services available on or
            through any such web sites or services.
        </p>
        <p class="fw-medium">
            We strongly advise you to read the terms and conditions and privacy notice of any third-party web sites or
            services that you visit.
        </p>
        <h3 class="mt-4 fw-bold text-center">Termination</h3>
        <p class="fw-medium">
            We may terminate or suspend access to our Service immediately, without prior notice or liability, for any
            reason whatsoever, including without limitation if you breach the Terms.
        </p>
        <p class="fw-medium">
            All provisions of the Terms which by their nature should survive termination shall survive termination,
            including, without limitation, ownership provisions, warranty disclaimers, indemnity and limitations of
            liability.
        </p>
        <h3 class="mt-4 fw-bold text-center">Governing Law</h3>
        <p class="fw-medium">
            These Terms shall be governed and construed in accordance with the laws of United Republic of Tanzania,
            without regard to its conflict of law with Global Instruments.
        </p>
        <p class="fw-medium">
            Our failure to enforce any right or provision of these Terms will not be considered a waiver of those
            rights. If any provision of these Terms is held to be invalid or unenforceable by a court, the remaining
            provisions of these Terms will remain in effect. These Terms constitute the entire agreement between us
            regarding our Service, and supersede and replace any prior agreements we might have between us regarding the
            Service.
        </p>
        <h3 class="mt-4 fw-bold text-center">Changes</h3>
        <p class="fw-medium">
            We reserve the right, at our sole discretion, to modify or replace these Terms at any time. If a revision is
            material, we will try to provide at least 30 days’ notice prior to any new terms taking effect. What
            constitutes a material change will be determined at our sole discretion.
        </p>
        <p class="fw-medium">
            By continuing to access or use our Service after those revisions become effective, you agree to be bound by
            the revised terms. If you do not agree to the new terms, please stop using the Service.
        </p>
        <h3 class="mt-4 fw-bold text-center">Contact Us</h3>
        <p class="fw-medium">
            If you have any questions about these Terms, please <span class="text-primary" style="cursor:pointer;"><a
                    href="{{route('chat')}}">Contact us</a></span>.
        </p>
    </div>
    <div class="row btn-teal">
        <x-footer-component />
    </div>
</div>
@endsection