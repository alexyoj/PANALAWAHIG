<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>Panalawahig</title>
    <link rel="icon" href="img/p-logo-white.svg"> <!-- dark mode -->
    <!-- <link rel="icon" href="img/p-logo-black.svg"> --> <!-- light mode -->
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.0-2/css/all.min.css" integrity="sha256-46r060N2LrChLLb5zowXQ72/iKKNiw/lAmygmHExk/o=" crossorigin="anonymous" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <nav>
        <div class="logo">
            <img src="img/who-logo-white.svg" alt="panalawahig-logo" width="80px" height="40px">
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

    <div class="front">
        <div class="slogan">
            <h1>Tested for Safety,</br>Trusted for Life</h1>
        </div>
        <div class="phrase">
            <h4>Ensuring Safe Water for All</h4>
        </div>
        <button class="btn" onclick="document.location='history.php'">View Historical Data</button>
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

        openMenu.addEventListener('click', show);
        closeMenu.addEventListener('click', close);

        // close menu when you click on a menu item 
        menu_items.forEach(item => {
            item.addEventListener('click', close);
        });

        function show() {
            mainMenu.classList.add('active');
            mainMenu.style.display = 'flex';
        }

        function close() {
            mainMenu.classList.remove('active');
            
            // On smaller screens, hide the menu
            if (window.innerWidth <= 800) {
                mainMenu.style.display = 'none';
            }
        }

        // Ensure proper menu display on window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 800) {
                mainMenu.style.display = 'flex';
                mainMenu.classList.remove('active');
            } else {
                if (!mainMenu.classList.contains('active')) {
                    mainMenu.style.display = 'none';
                }
            }
        });
    </script>
</body>
</html>