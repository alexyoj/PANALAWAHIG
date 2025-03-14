<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panalawahig</title>
    <link rel="icon" href="img/p-logo-white.svg"> <!-- dark mode -->
    <!-- <link rel="icon" href="img/p-logo-black.svg"> --> <!-- light mode -->
    <link rel="stylesheet" type="text/css" href="postdetails.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" integrity="sha256-46r060N2LrChLLb5zowXQ72/iKKNiw/lAmygmHExk/o=" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <nav>
        <div class="logo">
            <img src="img/who-logo-black.svg" alt="panalawahig-logo" width="80px" height="40px">
        </div>
        <div class="openMenu"><i class="fa fa-bars"></i></div>
        <ul class="mainMenu">
            <li><a href="index.php">HOME</a></li>
            <li><a href="history.php">HISTORY</a></li>
            <li><a href="blog.php">BLOG</a></li>
            <li><a href="about.php">ABOUT</a></li>
            <li><a href="contact.php">CONTACT US</a></li>
            <div class="closeMenu"><i class="fa fa-times"></i></div>
        </ul>
    </nav>

    <!-- blog na dito -->
    <!-- Blog Post Detail Page -->
    <div class="post-detail">
        <header class="post-header">
            <h1 class="post-title"><b>Methodology</b></h1>
            <p class="post-date">Oct 28, 2024</p>
        </header>

        <div class="post-image">
            <img src="img/scrumban.png" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
        </div>        

        <div class="post-content">
            <div class="post-section">
                <!-- <h2 class="post-question">Lorem ipsum dolor sit amet?</h2> -->
                <p class="post-answer"><b>Development Tools:</b>
                    <ul>
                        <li>Hardware: Arduino Uno, pH Sensor, Turbidity Sensor, GSM Module, Power Bank.</li>
                        <li>Software: Arduino IDE, ThingSpeak, MySQL, PHP, XAMPP.</li>
                    </ul>
                    <b>Approach:</b><br>
                    The project follows the Scrumban methodology, blending iterative development with workflow efficiency. Development phases include:
                    <ul>
                        <li>Planning and requirements gathering.</li>
                        <li>Hardware prototyping.</li>
                        <li>Web application development.</li>
                        <li>System integration and testing.</li>
                    </ul>
                    <b>Technologies:</b>
                    <ul>
                        <li>ThingSpeak: For cloud data visualization and storage.</li>
                        <li>Arduino: For sensor data processing and microcontroller integration.</li>
                        <li>GSM Module: For SMS-based alerts in areas with limited internet access.</li>
                    </ul>
                </p>
            </div>
        </div>
    </div>

    <footer style="background-color: #A0DEFF;">
        <div class="container text-center">
            <p class="footer-text">Copyright © 2024 | KAJA</p>
        </div>
    </footer>

    <script>
        const mainMenu = document.querySelector('.mainMenu');
        const closeMenu = document.querySelector('.closeMenu');
        const openMenu = document.querySelector('.openMenu');
        const menu_items = document.querySelectorAll('nav .mainMenu li a');
  
        openMenu.addEventListener('click',show);
        closeMenu.addEventListener('click',close);
  
        // close menu when you click on a menu item 
        menu_items.forEach(item => {
            item.addEventListener('click',function(){
            close();
            })
        })
  
        function show(){
            mainMenu.style.display = 'flex';
            mainMenu.style.top = '0';
        }
        function close(){
            mainMenu.style.top = '-100%';
        }
      </script>
</body>
</html>