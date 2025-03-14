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
            <h1 class="post-title"><b>Problem Statement</b></h1>
            <p class="post-date">Oct 28, 2024</p>
        </header>

        <div class="post-image">
            <img src="img/graph.png" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
        </div>        

        <div class="post-content">
            <div class="post-section">
                <!-- <h2 class="post-question">Lorem ipsum dolor sit amet?</h2> -->
                <p class="post-answer"><b>Problem Definition:</b><br>
                    In far-flung areas of Davao City, access to safe drinking water is limited, exposing communities to waterborne diseases due to insufficient testing infrastructure.
                    <br><br>
                    <b>Justification:</b><br>
                    Unsafe water sources have led to numerous health challenges. Between 2010 and 2019, over 50,000 Filipinos succumbed to waterborne diseases. Traditional testing methods are often inaccessible, costly, and time-consuming, making on-site solutions vital for public health improvement​(KAJA_Manuscript).
                    <br><br>
                    <b>Target Audience:</b>
                    <ul>
                        <li>Rural communities in Davao City for immediate water quality insights.</li>
                        <li>Environmental organizations conducting field research.</li>
                        <li>Government agencies aiming to improve water safety.</li>
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