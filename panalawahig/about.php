<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panalawahig</title>
    <link rel="icon" href="img/p-logo-white.svg"> <!-- dark mode -->
    <!-- <link rel="icon" href="img/p-logo-black.svg"> --> <!-- light mode -->
    <link rel="stylesheet" type="text/css" href="about.css">
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

    <section id="about">
        <div class="ab">
            <div class="image-container">
              <img src="img/picsample.jpg" alt="Headline Img">
            </div>
            <div class="abt">
                <div class="ab-title">
                    <h3>PANALAWAHIG: ENSURING CLEAN WATER FOR FAR-FLUNG AREAS</h3>
                </div>
                <div class="ab-desc">
                    <h4>Panalawahig is an innovative water quality testing system developed to address the critical need for clean drinking water in remote areas. The system utilizes an IoT-based approach, integrating advanced sensors to measure essential water quality parameters such as pH level, turbidity, temperature, and total dissolved solids (TDS). As a result, Panalawahig gives communities quick access to information about the safety of local water sources, enabling citizens to make wise choices regarding their drinking water.</h4>
                    <br>
                    <h4><b>KEY FEATURES OF PANALAWAHIG</h4>
                    <!-- <br> -->
                    <h4>
                        <b>💧 Real-Time Water Testing:</b> The device measures and displays results in real-time, offering immediate feedback about the water’s safety level.<br>
                        <b>💧 SMS Alerts:</b> Automatic notifications are sent to community leaders if the water quality does not meet safe drinking standards, allowing for rapid response.<br>
                        <b>💧 Portable Design:</b> Built to be easily transportable, Panalawahig allows testing in even the most remote locations.<br>
                        <b>💧 Data History Access:</b> A user-friendly web interface provides access to historical test results, helping communities track water quality over time.<br>
                    </h4>
                    <br>
                    <h4><b>BENEFITS</b></h4>
                    <h4>
                        Panalawahig supports local health, environmental awareness, and community empowerment. With reliable, on-site testing, it reduces the reliance on delayed laboratory results and provides a convenient, proactive solution to safeguard against waterborne illnesses.
                        By ensuring water safety through easy, accessible testing, Panalawahig stands as a vital resource for remote communities striving for safe, potable water.
                    </h4>
                </div>
            </div>
        </div>
    </section>

    <section id="testimonial">
        <div class="tes">
            <div class="tes-title">
                <h3>TESTIMONIALS</h3>
            </div>
            <!-- <div class="tes-img">
                <img src="img/officeman1.jpg" alt="1stPersonTes">
            </div>
            <div class="tes-desc">
                <h4><i>“Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Imperdiet massa tincidunt nunc pulvinar sapien et ligula ullamcorper malesuada. Sed viverra tellus in hac habitasse platea ”</i></h4>
            </div>
            <div class="tes-name">
                <h4>John Doe</h4> -->
                <div class="testi">
                    <h4>Be one of the first to experience the future of water quality testing. Try our solution today and share your feedback. Your testimonial could help others make informed decisions about their water safety.</h4>
                </div>
            </div>
        </div>
    </section>

    <section id="team">
        <div class="te">
            <div class="te-title">
                <h3>OUR TEAM</h3>
            </div>
            <div class="team-members">
                <div class="team-member">
                    <img src="img/picfemale1.png" alt="Member 1">
                    <h4>Kate Andrea Sebandal</h4>
                    <p class="team-role">UI/UX Designer</p>
                </div>
                <div class="team-member">
                    <img src="img/picfemale2.png" alt="Member 2">
                    <h4>Asianna Grace Tejero</h4>
                    <p class="team-role">System Analyst</p>
                </div>
                <div class="team-member">
                    <img src="img/picfemale3.png" alt="Member 3">
                    <h4>Jancil Joy Amores</h4>
                    <p class="team-role">Technical Writer</p>
                </div>
                <div class="team-member">
                    <img src="img/picmale.png" alt="Member 4">
                    <h4>Alexis Joseph Yoj Bacaltos</h4>
                    <p class="team-role">Programmer</p>
                </div>
            </div>
        </div>
    </section>

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