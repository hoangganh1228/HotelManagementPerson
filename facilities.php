<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TJ Hotel - FACILITIES</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
    <?php require('inc/links.php')?>
    <style>
        
        .pop:hover {
            border-top-color: #2ec1ac !important;
            transform: scale(1.03);
            transition: all 0.3s;
        }

       
    </style>
</head>
<body class="bg-light">
    
    <?php require('inc/header.php'); ?>

    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center">OUR FACILITIES</h2>
        <div class="h-line bg-dark"></div>
        <p class="text-center mt-3">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere modi id, in exercitationem, enim cumque suscipit, nemo <br>alias consequuntur eos reiciendis! Illum provident architecto inventore dicta! Quod obcaecati quasi laborum!
        </p>
    </div>
    
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-5 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop">
                    <div class="d-flex align-items-center mb-2">
                        <img src="./Hotel-Booking-Website-Assets/images/facilities/IMG_43553.svg" width="40px">
                        <h5 class="m-0 ms-3">Wifi</h5>

                    </div>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aperiam culpa, repellat possimus reprehenderit animi ducimus enim.</p>
                </div>    
            </div>
            <div class="col-lg-4 col-md-6 mb-5 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop">
                    <div class="d-flex align-items-center mb-2">
                        <img src="./Hotel-Booking-Website-Assets/images/facilities/IMG_43553.svg" width="40px">
                        <h5 class="m-0 ms-3">Wifi</h5>

                    </div>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aperiam culpa, repellat possimus reprehenderit animi ducimus enim.</p>
                </div>    
            </div>
            <div class="col-lg-4 col-md-6 mb-5 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop">
                    <div class="d-flex align-items-center mb-2">
                        <img src="./Hotel-Booking-Website-Assets/images/facilities/IMG_43553.svg" width="40px">
                        <h5 class="m-0 ms-3">Wifi</h5>

                    </div>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aperiam culpa, repellat possimus reprehenderit animi ducimus enim.</p>
                </div>    
            </div>
            <div class="col-lg-4 col-md-6 mb-5 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop">
                    <div class="d-flex align-items-center mb-2">
                        <img src="./Hotel-Booking-Website-Assets/images/facilities/IMG_43553.svg" width="40px">
                        <h5 class="m-0 ms-3">Wifi</h5>

                    </div>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aperiam culpa, repellat possimus reprehenderit animi ducimus enim.</p>
                </div>    
            </div>
            <div class="col-lg-4 col-md-6 mb-5 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop">
                    <div class="d-flex align-items-center mb-2">
                        <img src="./Hotel-Booking-Website-Assets/images/facilities/IMG_43553.svg" width="40px">
                        <h5 class="m-0 ms-3">Wifi</h5>

                    </div>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aperiam culpa, repellat possimus reprehenderit animi ducimus enim.</p>
                </div>    
            </div>
            <div class="col-lg-4 col-md-6 mb-5 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop">
                    <div class="d-flex align-items-center mb-2">
                        <img src="./Hotel-Booking-Website-Assets/images/facilities/IMG_43553.svg" width="40px">
                        <h5 class="m-0 ms-3">Wifi</h5>

                    </div>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aperiam culpa, repellat possimus reprehenderit animi ducimus enim.</p>
                </div>    
            </div>
            <div class="col-lg-4 col-md-6 mb-5 px-4">
                <div class="bg-white rounded shadow p-4 border-top border-4 border-dark pop">
                    <div class="d-flex align-items-center mb-2">
                        <img src="./Hotel-Booking-Website-Assets/images/facilities/IMG_43553.svg" width="40px">
                        <h5 class="m-0 ms-3">Wifi</h5>

                    </div>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aperiam culpa, repellat possimus reprehenderit animi ducimus enim.</p>
                </div>    
            </div>
        </div>
    </div>

    <?php require('inc/footer.php')?>


    
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".swiper-container", {
            spaceBetween: 30,
            effect: "fade",
            loop: true,
            autoplay: {
                delay: 3500,
                disableOnInteration: false,
            }
        });
        var swiper = new Swiper(".swiper-testimonials", {
            effect: "coverflow",
            grabCursor: true,
            centeredSlides: true,
            slidesPerView: "auto",
            slidesPerView: "3",
            loop: true, 
            coverflowEffect: {
                rotate: 50,
                stretch: 0,
                depth: 100,
                modifier: 1,
                slideShadows: false,
            },
            pagination: {
                el: ".swiper-pagination",
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                },
                640: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3    ,
                },
            }
        });
  </script>

</body>
</html>