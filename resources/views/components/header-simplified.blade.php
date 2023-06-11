@props(['content'=>'','bg'=>'bg-gradient-primary-to-secondary'])
<header class="page-header page-header-dark {{$bg}} mb-4">
    <div class="container-xl px-4">
        <div class="page-header-content pt-4">
            <div class="row align-items-center justify-content-between">
                <div class="col-auto mt-4">
                    {{ $content }}
                </div>
            </div>
        </div>
    </div>
</header>
