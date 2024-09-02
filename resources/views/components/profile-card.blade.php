@props(['title', 'description', 'profileImage'])

<div class="card" style="width: 18rem;">
    <img src="{{ $profileImage }}" class="card-img-top" alt="Profile Image" width=150>
    <div class="card-body">
        <h5 class="card-title text-primary">{{ $title }}</h5>
        <p class="card-text">{{ $description }}</p>
    </div>
</div>
