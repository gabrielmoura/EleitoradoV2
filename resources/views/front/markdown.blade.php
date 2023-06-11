<x-guest-layout>
    <div class="bg-gradient-primary-to-secondary vh-100">
        <div class="container-xl px-4">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="card shadow-lg border-0 rounded-lg mt-5">
                        <div class="card-header justify-content-center">
                            <div class="card-body p-5 text-center">
                                <div class="h3 text-secondary mb-0">
                                    {{$title}}
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            {{$text}}
                        </div>
                        <div class="card-footer text-center">
                            <div class="small">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
