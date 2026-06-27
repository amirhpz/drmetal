@props(['service'])

<article class="card service-card">
    <div class="service-icon"><x-site.icon :name="$service->icon ?: 'quality'" /></div>
    <h3>{{ $service->title }}</h3>
    <p>{{ $service->short_description }}</p>
</article>
