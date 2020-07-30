<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
</head>
<body style="background: black; color: white">
<div class="row">
    <div class="col-xl-12 text-center">
        <img src="https://xtremereflection.app/assets/img/Logo1.png" width="400px" height="100px" alt="XtremeReflectionLog">
    </div>
    <div class="col-xl-12 text-center">
        <img src="https://xtremereflection.app/assets/img/systemxlogo.png" width="400px" height="100px" alt="SystemXLogo">
    </div>
</div>

<div class="row">
    <div class="col-xl-10 m-4">
        <h1></h1>
        <p>{{$workOrder->estimate->customer->firstName ?? ''}} {{$workOrder->estimate->customer->lastName ?? ''}}I hope this email finds you well</p>

        <p>Your mobile auto detail is scheduled for today and you detail specialist is on his way. Your specialist today will be Josh Blevins. We will be arriving on schedule today at {{$workOrder->estimate->serviceAddress ?? ''}}</p>
    </div>
</div>

<div class="row">
    <div class="col-xl-12 text-center">
        <h1>SEE WHAT'S <span class="text-danger">NEW</span></h1>
    </div>
    <div class="col-xl-12 text-center">
        <img src="https://xtremereflection.app/assets/img/systemxtrmess.png" alt="SystemXLogo">
    </div>

</div>
<div class="row">
    <div class="col-xl-4">
        <img src="https://xtremereflection.app/assets/img/seadoo.png" width="200px" height="200px" alt="SystemXLogo">
    </div>
    <div class="col-xl-4">
        <img src="https://xtremereflection.app/assets/img/plane.png" width="200px" height="200px" alt="SystemXLogo">
    </div>
    <div class="col-xl-4">
        <img src="https://xtremereflection.app/assets/img/rims.png" width="200px" height="200px" alt="SystemXLogo">
    </div>
</div>
<div class="row">
    <div class="col-xl-12 text-center">
        <img src="https://xtremereflection.app/assets/img/systemx2.png" alt="SystemXLogo">
    </div>
    <div class="col-xl-12 text-center">
        Proprietary, shatter proof ceramic technology for Auto, Aircraft, and Marine. System X Ceramic coatings offer unmatched protection for paint, glass, and gelcoat. We don't stop at just exterior paint protection.  Our interior spray protect fabrics, leather, suede, and many other textiles while leavening an ultra hydrophobic effect to expel liquids and stains.


        Ask me about our glass, plastic/trim, and newest spray and wipe protection.
    </div>
</div>

</body>
</html>
