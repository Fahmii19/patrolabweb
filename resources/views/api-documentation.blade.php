<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Api Documentation</title>
    @include('partials.header')
</head>
<body>
    <div class="container mt-5">
        <h2>Api Documentation</h2>
        <ul class="p-0" style="list-style: none">
            @foreach ($api as $item)
                <li><h6 class="fw-bold">{{ $item->nama }}</h6></li>
                <li>Endpoint : {{ $item->endpoint }}</li>
                <li>Method : <span class="text-uppercase">{{ $item->method }}</span></li>
                <li>
                    <label>Response :</label>
                    <div>
                        @php
                            dump(json_decode($item->response))
                        @endphp
                    </div>
                </li>
                <br>
            @endforeach
        </ul>
    </div>
    @include('partials.footer')
</body>
</html>