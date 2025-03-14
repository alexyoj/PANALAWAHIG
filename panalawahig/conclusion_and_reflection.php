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
            <li><a href="sensors.html">SENSORS</a></li>
            <li><a href="history.html">HISTORY</a></li>
            <li><a href="blog.php">BLOG</a></li>
            <li><a href="about.html">ABOUT</a></li>
            <li><a href="contact.html">CONTACT US</a></li>
            <div class="closeMenu"><i class="fa fa-times"></i></div>
        </ul>
    </nav>

    <!-- blog na dito -->
    <!-- Blog Post Detail Page -->
    <div class="post-detail">
        <header class="post-header">
            <h1 class="post-title"><b>Conclusion and Reflection</b></h1>
            <p class="post-date">Oct 28, 2024</p>
        </header>

        <div class="post-image">
            <img src="img/conclusion.png" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
        </div>        

        <div class="post-content">
            <div class="post-section">
                <!-- <h2 class="post-question">Lorem ipsum dolor sit amet?</h2> -->
                <p class="post-answer"><b>Final Thoughts:</b><br>
                Panalawahig successfully met its objectives, providing a reliable and user-friendly solution to water quality challenges in remote areas. Moreover, it still has a lot to improve that will enable it to be better.<br><br>
                    <b>Key Learnings:</b><br>
                    <ul>
                        <li>Collaboration is essential in multidisciplinary projects.</li>
                        <li>Real-time systems require robust error handling.</li>
                        <li>Being aware of the quality of your water source is important.</li>
                        <li>IoT system is complex and expensive; you need to pour extra money for it to be successful.</li>
                    </ul>
                    <b>Future Work:</b><br>
                    <ul>
                        <li>Integrate additional parameters such as dissolved oxygen and automate sensor recalibration</li>
                        <li>Use more sustainable power source</li>
                        <li>Invest in high-end hardware components for enhanced performance</li>
                        <li>Utilize GPS to automatically record the test area's name</li>
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