<x-app-layout>
    <style>
        /* Custom CSS for the 3-column layout */
        .card {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .card-body {
            flex: 1 1 auto;
            padding: 1.25rem;
        }
    </style>

    <div class="container-fluid">
        <div class="container p-5">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($packages as $package)
                    <form action="{{ route('selectedPackage') }}" method="post">
                        @csrf
                        <div class="col">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $package->name}}</h5>
                                    <small class='text-muted'>{{ $package->hours }} Lessons</small>
                                    <br><br>
                                    <span class="h2">{{ $package->price }}</span>/ package price
                                    <br><br>
                                    <input type="hidden" name="package_id" value="{{ $package->id }}">
                                    <div class="d-grid my-3">
                                        <button class="btn btn-outline-dark btn-block" type="submit">Select</button>
                                    </div>
                                    <ul>
                                        <li>Cras justo odio</li>
                                        <li>Dapibus ac facilisis in</li>
                                        <li>Vestibulum at eros</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </form>
                @endforeach
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</x-app-layout>
