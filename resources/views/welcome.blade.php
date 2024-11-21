<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>X-prees Laundry</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">
</head>
<body>
   <div id="hero">
    <div class="container">
        <div class="row align-items-center text-center">
            <div class="col-md-6">
                <h1 class="display-4">X-prees Laundry</h1>
                <p class="mb-5">Good and affordable service</p>
            </div>
            <div class="col-md-6">
                <img src="/images/hero.svg" class="img-fluid" alt="Hero Image">
            </div>
        </div>
    </div>
   </div>

   <div id="services">
       <div class="container">
           <div class="row text-center">
               <div class="col-md-12">
                   <h1>Our Services</h1>
               </div>
               @foreach ($services as $item)
                    <div class="col-lg-3 col-6">
                        <div class="card shadow my-4">
                            <div class="card-body">
                                <h2 class="mb-4">{{$item->name}}</h2>
                                <p>Duration: {{$item->duration}} hours</p>
                                <p>Price: Rp. {{number_format($item->price)}}</p>
                            </div>
                        </div>
                    </div>
               @endforeach
           </div>
       </div>
   </div>

   <div id="location">
   <div class="container my-4">
    <div class="row">
        <div class="col-md-12">
            <h2>Our Location</h2>
        </div>
        <div class="col-md-12">
            <!-- Responsive map container -->
            <div style="width: 100%; height: 0; padding-bottom: 56.25%; position: relative;">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3410.755903285637!2d75.6909446765!3d31.255179974336475!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x391a5f27064981e1%3A0x6ca5a27e0b9a4c65!2sX-Prees%20Laundry!5e0!3m2!1sen!2sin!4v1731946068208!5m2!1sen!2sin"
                        style="border:0; position: absolute; top: 0; left: 0; width: 100%; height: 100%;" 
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </div>
</div>

   </div>

   <div id="footer">
       <p class="text-center">Copyright Diwakar 2024</p>
   </div>
</body>
</html>
