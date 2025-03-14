<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panalawahig</title>
    <link rel="icon" href="img/p-logo-white.svg"> <!-- dark mode -->
    <!-- <link rel="icon" href="img/p-logo-black.svg"> --> <!-- light mode -->
    <link rel="stylesheet" type="text/css" href="contact.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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

    <section id="head">
        <div class="background-image"></div>
        <div class="text-container">
            <h2 class="contact-heading">GET IN TOUCH WITH US!</h2>
        </div>
    </section>

    <section id="contact-us">
        <div class="container">
            <div class="contact-card">
                <div class="left-side">
                    <h2>MEET US</h2>
                    <img src="img/who-logo-white.svg" alt="Panalawahig Logo" class="logo">
                    <div class="contact-info">
                        <p><i class="fa-solid fa-envelope"></i>panalawahig@gmail.com</p>
                        <p><i class="fa-solid fa-phone"></i>+63 968 4106 404 </p>
                    </div>
                </div>
                <div class="right-side">
                    <h2>CONTACT US</h2>
                    <form action="https://formsubmit.co/panalawahig@gmail.com" method="POST">
                        <input type="text" name="name" placeholder="Name" required>
                        <input type="email" name="email" placeholder="Email" required>
                        <input type="tel" name="tel" placeholder="Mobile Number" required>
                        <textarea placeholder="Message" name="message" required></textarea>
                        <input type="hidden" name="_subject" value="New submission!">
                        <input type="hidden" name="_next" value="http://localhost/panalawahig/thank-you.php">
                        <input type="hidden" name="_autoresponse" value="Thank you for sending us a message! Please wait 2-3 working days for a response.">
                        <input type="hidden" name="_template" value="table">
                         
                        <button type="submit">SUBMIT</button>
                    </form>
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