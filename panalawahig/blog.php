<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panalawahig</title>
    <link rel="icon" href="img/p-logo-white.svg"> <!-- dark mode -->
    <!-- <link rel="icon" href="img/p-logo-black.svg"> --> <!-- light mode -->
    <link rel="stylesheet" type="text/css" href="blog.css">
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
    <!-- Blog Grid Page -->
    <div class="container">
        <div class="header-content">
            <h1>Tested for Safety,<br>Trusted for Life</h1>
            <p>Ensuring Safe Water for All</p>
        </div>

        <div class="blog-grid">
            <!-- clickable card -->
            <a href="problem_statement.php" class="card-link">
                <article class="blog-card">
                    <div class="card-image" style="background-image: url('img/graph.png'); background-size: cover; background-position: center;"></div>
                    <div class="card-content">
                        <p class="card-date">Oct 28, 2024</p>
                        <h3 class="card-title">Problem Statement</h3>
                        <p class="card-excerpt">In far-flung areas of Davao City, access to safe drinking water is limited, exposing communities to waterborne diseases due to insufficient testing infrastructure.</p>
                    </div>
                </article>
            </a>
            <a href="objectives_and_goals.php" class="card-link">
                <article class="blog-card">
                <div class="card-image" style="background-image: url('img/goals.jpg'); background-size: cover; background-position: center;"></div>
                <div class="card-content">
                        <p class="card-date">Oct 28, 2024</p>
                        <h3 class="card-title">Objectives and Goals</h3>
                        <p class="card-excerpt">Develop a functional IoT-based system by December 2024...</p>
                    </div>
                </article>
            </a>
            <a href="methodology.php" class="card-link">
                <article class="blog-card">
                <div class="card-image" style="background-image: url('img/scrumban.png'); background-size: cover; background-position: center;"></div>
                <div class="card-content">
                        <p class="card-date">Oct 28, 2024</p>
                        <h3 class="card-title">Methodology</h3>
                        <p class="card-excerpt">Hardware: Arduino Uno, pH Sensor, Turbidity Sensor, GSM Module, Power Bank.</p>
                    </div>
                </article>
            </a>
            <a href="weekly_progress_updates.php" class="card-link">
                <article class="blog-card">
                <div class="card-image" style="background-image: url('img/progrss.jpg'); background-size: cover; background-position: center;"></div>
                <div class="card-content">
                        <p class="card-date">Oct 28, 2024</p>
                        <h3 class="card-title">Weekly Progress Updates</h3>
                        <p class="card-excerpt">Here are the weekly progress updates:</p>
                    </div>
                </article>
            </a>
            <a href="final_product.php" class="card-link">
                <article class="blog-card">
                <div class="card-image" style="background-image: url('img/website.png'); background-size: cover; background-position: center;"></div>
                <div class="card-content">
                        <p class="card-date">Oct 28, 2024</p>
                        <h3 class="card-title">Final Product</h3>
                        <p class="card-excerpt">Panalawahig is a portable device capable of testing pH, turbidity, TDS, and temperature...</p>
                    </div>
                </article>
            </a>
            <a href="testing_and_evaluation.php
            " class="card-link">
                <article class="blog-card">
                <div class="card-image" style="background-image: url('img/system.jpg'); background-size: cover; background-position: center;"></div>
                <div class="card-content">
                        <p class="card-date">Oct 28, 2024</p>
                        <h3 class="card-title">Testing and Evaluation</h3>
                        <p class="card-excerpt">Functional testing to ensure parameter accuracy...</p>
                    </div>
                </article>
            </a>
            <a href="conclusion_and_reflection.php" class="card-link">
                <article class="blog-card">
                <div class="card-image" style="background-image: url('img/conclusion.png'); background-size: cover; background-position: center;"></div>
                <div class="card-content">
                        <p class="card-date">Oct 28, 2024</p>
                        <h3 class="card-title">Conclusion and Reflection</h3>
                        <p class="card-excerpt">Panalawahig successfully met its objectives, providing a reliable and user-friendly solution to water quality challenges in remote areas...</p>
                    </div>
                </article>
            </a>
            <a href="acknowledgement.php" class="card-link">
                <article class="blog-card">
                <div class="card-image" style="background-image: url('img/ack.jpg'); background-size: cover; background-position: center;"></div>
                <div class="card-content">
                        <p class="card-date">Oct 28, 2024</p>
                        <h3 class="card-title">Acknowledgments</h3>
                        <p class="card-excerpt">We extend our heartfelt thanks to our mentors, Ms. Christine Marie D. Ordaneza and Ms. Roselyn...</p>
                    </div>
                </article>
            </a>
            <!-- Repeat for other cards -->
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