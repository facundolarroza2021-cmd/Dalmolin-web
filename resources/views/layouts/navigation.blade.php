<div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
    <x-nav-link :href="route('admin.properties.index')" :active="request()->routeIs('admin.properties.*')">
        {{ __('Propiedades') }}
    </x-nav-link>
</div>