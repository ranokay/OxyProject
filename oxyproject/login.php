<?php
session_start();
?> <!DOCTYPE html><html lang="en"><head><title>OxyProject | Login</title><meta charset="UTF-8"><meta http-equiv="X-UA-Compatible" content="IE=edge"><meta name="viewport" content="width=device-width,initial-scale=1"><!-- fav icons --><link rel="apple-touch-icon" sizes="180x180" href="assets/logo/apple-touch-icon.png"><link rel="icon" type="image/png" sizes="32x32" href="assets/logo/favicon-32x32.png"><link rel="icon" type="image/png" sizes="16x16" href="assets/logo/favicon-16x16.png"><link rel="icon" type="image/x-icon" href="assets/logo/favicon.ico"><link rel="shortcut icon" type="image/x-icon" href="assets/logo/favicon.ico"><link rel="manifest" href="assets/logo/site.webmanifest"><link rel="mask-icon" href="assets/logo/safari-pinned-tab.svg" color="#5bbad5"><meta name="msapplication-TileColor" content="#da532c"><meta name="theme-color" content="#ffffff"><!-- fonts --><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;600;700&display=swap" rel="stylesheet"><!-- styles --><link rel="stylesheet" href="css/style.min.css"><!-- font awesome --><script src="https://kit.fontawesome.com/e659bd6042.js" crossorigin="anonymous"></script><!-- scripts --><script src="js/main.min.js" defer="defer"></script></head> <?php
if (isset($_SESSION['userID'])) {
	header("Location: ../dashboard.php");
	exit();
}
?> <body><div class="wrapper"><div class="loader"><img src="assets/logo/logo-footer.svg" alt=""></div><header class="header__main"><a class="logo" href="index.php" title="Homepage"><img src="assets/logo/logo.svg" alt="Oxy Project Logo"><div class="logo__text">OxyProject</div></a><div class="line"></div><div class="left__side-mobile"> <?php
		include "php/dbh.inc.php";
		if (isset($_SESSION['userID'])) {
			$userID = $_SESSION['userID'];
			include "php/UserContr.inc.php";
			$user = new UserContr($userID);
			?> <a class="btn btn-profile-mobile" href="dashboard.php"><img class="profile__icon-mobile" src="assets/icons/circle-user-regular.svg" alt="Profile"> </a> <?php
		} else {
			?> <a class="btn btn-profile-mobile" href="login.php"><img class="profile__icon-mobile" src="assets/icons/circle-user-regular.svg" alt="Profile"> </a> <?php
		}
		?> <div class="mobile__burger"><span class="mobile__burger_line"></span> <span class="mobile__burger_line"></span> <span class="mobile__burger_line"></span></div></div><div class="mobile"><div class="mobile__menu"><!-- <div class="mobile__menu_search">
				<div class="search__icon">
					<img src="assets/icons/search.svg" alt="Search" />
				</div>
				<input class="search__input" name="search" type="search" placeholder="Search arts and creators" autocomplete="on" />
			</div> --><nav class="navbar"><div class="navbar__resources"><a class="nav__btn" href="collections.php"><img class="link__icon" src="assets/icons/explore.svg" alt="">Collection</a></div><div class="navbar__resources"><a class="nav__btn" href="contact.php"><img class="link__icon" src="assets/icons/contact.svg" alt="">Contact</a></div><div class="navbar__resources"><a class="nav__btn" href="about.php"><img class="link__icon" src="assets/icons/home.svg" alt="">About</a></div></nav> <?php
			if (isset($_SESSION['userID'])) {
				?> <a class="btn btn-profile" href="dashboard.php"><img class="profile__icon" src="assets/icons/circle-user-regular.svg" alt="Profile" title="Profile"> </a><a class="btn btn-profile" href="php/logout.inc.php"><img class="profile__icon" src="assets/icons/logout.svg" alt="Logout" title="Logout"> </a> <?php
			} else {
				?> <a class="btn btn__gradient" href="login.php">Login</a> <a class="btn btn__default btn-connect" href="signup.php">Sign Up</a> <?php
			}
			?> </div><div class="mobile__footer"> <?php
			if (isset($_SESSION['userID'])) {
				?> <a class="btn btn__blue" href="php/logout.inc.php">Logout</a> <?php
			} else {
				?> <a class="btn btn__blue" href="signup.php">Sign Up</a> <?php
			}
			?> <div class="mobile__footer_bg"><svg class="logo__icons" viewBox="0 0 193 42" fill="none" xmlns="http://www.w3.org/2000/svg"><a class="icon" href="https://www.facebook.com/" target="_blank"><circle cx="21.5" cy="21" r="21" stroke="#0F172A"/><path d="M22.8333 22.2H24.7381L25.5 19H22.8333V17.4C22.8333 16.576 22.8333 15.8 24.3571 15.8H25.5V13.112C25.2516 13.0776 24.3137 13 23.3232 13C21.2547 13 19.7857 14.3256 19.7857 16.76V19H17.5V22.2H19.7857V29H22.8333V22.2Z"/></a><a class="icon" href="https://twitter.com/" target="_blank"><circle cx="71.5" cy="21" r="20.5" stroke="#0F172A"/><path d="M81.5 14.8979C80.7645 15.2186 79.9744 15.4353 79.1438 15.5333C80.0008 15.0286 80.642 14.2343 80.9477 13.2986C80.1425 13.7693 79.2612 14.1006 78.3422 14.2781C77.7242 13.6288 76.9057 13.1984 76.0136 13.0537C75.1216 12.9091 74.206 13.0583 73.409 13.4783C72.6119 13.8982 71.9781 14.5654 71.6058 15.3761C71.2336 16.1869 71.1437 17.0959 71.3503 17.9621C69.7187 17.8814 68.1226 17.4641 66.6655 16.7372C65.2085 16.0102 63.923 14.9899 62.8926 13.7424C62.5403 14.3405 62.3377 15.034 62.3377 15.7725C62.3373 16.4373 62.5036 17.092 62.822 17.6784C63.1404 18.2648 63.6009 18.7648 64.1627 19.134C63.5112 19.1136 62.874 18.9403 62.3042 18.6286V18.6806C62.3041 19.6131 62.6319 20.5169 63.2319 21.2386C63.8318 21.9603 64.6671 22.4555 65.5958 22.6402C64.9914 22.8012 64.3577 22.8249 63.7426 22.7096C64.0046 23.5119 64.5151 24.2135 65.2024 24.7162C65.8898 25.2188 66.7197 25.4974 67.5759 25.5128C66.1224 26.6357 64.3273 27.2448 62.4795 27.2421C62.1521 27.2422 61.8251 27.2234 61.5 27.1858C63.3757 28.3726 65.5591 29.0024 67.7891 29C75.3378 29 79.4644 22.8474 79.4644 17.5113C79.4644 17.338 79.46 17.1629 79.4521 16.9895C80.2548 16.4183 80.9476 15.7109 81.4982 14.9005L81.5 14.8979Z"/></a><a class="icon" href="https://www.instagram.com/" target="_blank"><circle cx="121.5" cy="21" r="20.5" stroke="#0F172A"/><path d="M121.498 16.8952C119.226 16.8952 117.393 18.7285 117.393 21C117.393 23.2715 119.226 25.1048 121.498 25.1048C123.769 25.1048 125.603 23.2715 125.603 21C125.603 18.7285 123.769 16.8952 121.498 16.8952ZM121.498 23.6678C120.029 23.6678 118.83 22.469 118.83 21C118.83 19.531 120.029 18.3322 121.498 18.3322C122.967 18.3322 124.166 19.531 124.166 21C124.166 22.469 122.967 23.6678 121.498 23.6678ZM125.771 15.7705C125.24 15.7705 124.812 16.1988 124.812 16.7291C124.812 17.2595 125.24 17.6878 125.771 17.6878C126.301 17.6878 126.729 17.2615 126.729 16.7291C126.729 16.6032 126.705 16.4784 126.657 16.3621C126.609 16.2457 126.538 16.1399 126.449 16.0509C126.36 15.9618 126.254 15.8912 126.138 15.8431C126.021 15.795 125.897 15.7703 125.771 15.7705ZM129.499 21C129.499 19.8953 129.509 18.8005 129.447 17.6978C129.385 16.4169 129.093 15.2801 128.156 14.3435C127.218 13.4049 126.083 13.1147 124.802 13.0526C123.697 12.9906 122.603 13.0006 121.5 13.0006C120.395 13.0006 119.3 12.9906 118.198 13.0526C116.917 13.1147 115.78 13.4069 114.843 14.3435C113.905 15.2821 113.615 16.4169 113.553 17.6978C113.491 18.8025 113.501 19.8973 113.501 21C113.501 22.1027 113.491 23.1995 113.553 24.3022C113.615 25.5831 113.907 26.7199 114.843 27.6565C115.782 28.5951 116.917 28.8853 118.198 28.9474C119.302 29.0094 120.397 28.9994 121.5 28.9994C122.605 28.9994 123.699 29.0094 124.802 28.9474C126.083 28.8853 127.22 28.5931 128.156 27.6565C129.095 26.7179 129.385 25.5831 129.447 24.3022C129.511 23.1995 129.499 22.1047 129.499 21ZM127.738 25.7192C127.592 26.0834 127.416 26.3556 127.134 26.6358C126.851 26.918 126.581 27.0941 126.217 27.2402C125.164 27.6585 122.665 27.5644 121.498 27.5644C120.331 27.5644 117.829 27.6585 116.777 27.2422C116.413 27.0961 116.14 26.92 115.86 26.6378C115.578 26.3556 115.402 26.0854 115.256 25.7212C114.839 24.6665 114.934 22.1668 114.934 21C114.934 19.8332 114.839 17.3315 115.256 16.2788C115.402 15.9146 115.578 15.6424 115.86 15.3622C116.142 15.082 116.413 14.9039 116.777 14.7578C117.829 14.3415 120.331 14.4356 121.498 14.4356C122.665 14.4356 125.166 14.3415 126.219 14.7578C126.583 14.9039 126.855 15.08 127.136 15.3622C127.418 15.6444 127.594 15.9146 127.74 16.2788C128.156 17.3315 128.062 19.8332 128.062 21C128.062 22.1668 128.156 24.6665 127.738 25.7192Z"/></a><a class="icon" href="https://www.linkedin.com/" target="_blank"><circle cx="171.5" cy="21" r="20.5" stroke="#0F172A"/><path d="M165.423 16.8525C166.485 16.8525 167.346 15.9901 167.346 14.9263C167.346 13.8624 166.485 13 165.423 13C164.361 13 163.5 13.8624 163.5 14.9263C163.5 15.9901 164.361 16.8525 165.423 16.8525Z" fill="#0F172A"/><path d="M169.162 18.3122V28.9991H172.474V23.7142C172.474 22.3197 172.736 20.9692 174.462 20.9692C176.165 20.9692 176.186 22.5636 176.186 23.8022V29H179.5V23.1393C179.5 20.2605 178.881 18.0481 175.522 18.0481C173.909 18.0481 172.828 18.9346 172.386 19.7736H172.342V18.3122H169.162ZM163.764 18.3122H167.081V28.9991H163.764V18.3122Z"/></a></svg></div></div></div></header><main class="main__content main__login"><form class="form form__login" action="php/login.inc.php" method="POST"><label for="form">Login</label> <span class="form__line"></span> <?php
				if (isset($_SESSION['error'])) {
					$errorMsg = $_SESSION['error'];
					unset($_SESSION['error']);
					echo "<p class='form__error'>{$errorMsg}</p>";
				}
				if (isset($_SESSION['success'])) {
					$successMsg = $_SESSION['success'];
					unset($_SESSION['success']);
					echo "<p class='form__success'>{$successMsg}</p>";
				}
				?> <div class="form__group"><input type="text" name="username" placeholder="Username or Email"></div><div class="form__group"><input type="password" name="password" placeholder="Password"></div><div class="form__buttons"><button type="submit" class="btn btn__gradient" name="submit">Log In</button> <a class="forgot-password" href="reset-password-request.php">Forgot Password?</a></div><div class="form__delimiter"><span class="line"></span> <span class="text">or</span> <span class="line"></span></div><a href="signup.php" class="btn btn__default create-account">Create an account</a></form></main><footer class="footer__main" id="footer"><div class="container"><span class="container__line"></span><div class="logo"><div class="logo__content"><img src="assets/logo/logo-footer.svg" alt="Oxy Project Logo"> <a class="logo__content_text" href="index.php">OxyProject</a></div><svg class="logo__icons" viewBox="0 0 193 42" fill="none" xmlns="http://www.w3.org/2000/svg"><a class="icon" href="https://www.facebook.com/" target="_blank"><circle cx="21.5" cy="21" r="21" stroke="#0F172A"/><path d="M22.8333 22.2H24.7381L25.5 19H22.8333V17.4C22.8333 16.576 22.8333 15.8 24.3571 15.8H25.5V13.112C25.2516 13.0776 24.3137 13 23.3232 13C21.2547 13 19.7857 14.3256 19.7857 16.76V19H17.5V22.2H19.7857V29H22.8333V22.2Z"/></a><a class="icon" href="https://twitter.com/" target="_blank"><circle cx="71.5" cy="21" r="20.5" stroke="#0F172A"/><path d="M81.5 14.8979C80.7645 15.2186 79.9744 15.4353 79.1438 15.5333C80.0008 15.0286 80.642 14.2343 80.9477 13.2986C80.1425 13.7693 79.2612 14.1006 78.3422 14.2781C77.7242 13.6288 76.9057 13.1984 76.0136 13.0537C75.1216 12.9091 74.206 13.0583 73.409 13.4783C72.6119 13.8982 71.9781 14.5654 71.6058 15.3761C71.2336 16.1869 71.1437 17.0959 71.3503 17.9621C69.7187 17.8814 68.1226 17.4641 66.6655 16.7372C65.2085 16.0102 63.923 14.9899 62.8926 13.7424C62.5403 14.3405 62.3377 15.034 62.3377 15.7725C62.3373 16.4373 62.5036 17.092 62.822 17.6784C63.1404 18.2648 63.6009 18.7648 64.1627 19.134C63.5112 19.1136 62.874 18.9403 62.3042 18.6286V18.6806C62.3041 19.6131 62.6319 20.5169 63.2319 21.2386C63.8318 21.9603 64.6671 22.4555 65.5958 22.6402C64.9914 22.8012 64.3577 22.8249 63.7426 22.7096C64.0046 23.5119 64.5151 24.2135 65.2024 24.7162C65.8898 25.2188 66.7197 25.4974 67.5759 25.5128C66.1224 26.6357 64.3273 27.2448 62.4795 27.2421C62.1521 27.2422 61.8251 27.2234 61.5 27.1858C63.3757 28.3726 65.5591 29.0024 67.7891 29C75.3378 29 79.4644 22.8474 79.4644 17.5113C79.4644 17.338 79.46 17.1629 79.4521 16.9895C80.2548 16.4183 80.9476 15.7109 81.4982 14.9005L81.5 14.8979Z"/></a><a class="icon" href="https://www.instagram.com/" target="_blank"><circle cx="121.5" cy="21" r="20.5" stroke="#0F172A"/><path d="M121.498 16.8952C119.226 16.8952 117.393 18.7285 117.393 21C117.393 23.2715 119.226 25.1048 121.498 25.1048C123.769 25.1048 125.603 23.2715 125.603 21C125.603 18.7285 123.769 16.8952 121.498 16.8952ZM121.498 23.6678C120.029 23.6678 118.83 22.469 118.83 21C118.83 19.531 120.029 18.3322 121.498 18.3322C122.967 18.3322 124.166 19.531 124.166 21C124.166 22.469 122.967 23.6678 121.498 23.6678ZM125.771 15.7705C125.24 15.7705 124.812 16.1988 124.812 16.7291C124.812 17.2595 125.24 17.6878 125.771 17.6878C126.301 17.6878 126.729 17.2615 126.729 16.7291C126.729 16.6032 126.705 16.4784 126.657 16.3621C126.609 16.2457 126.538 16.1399 126.449 16.0509C126.36 15.9618 126.254 15.8912 126.138 15.8431C126.021 15.795 125.897 15.7703 125.771 15.7705ZM129.499 21C129.499 19.8953 129.509 18.8005 129.447 17.6978C129.385 16.4169 129.093 15.2801 128.156 14.3435C127.218 13.4049 126.083 13.1147 124.802 13.0526C123.697 12.9906 122.603 13.0006 121.5 13.0006C120.395 13.0006 119.3 12.9906 118.198 13.0526C116.917 13.1147 115.78 13.4069 114.843 14.3435C113.905 15.2821 113.615 16.4169 113.553 17.6978C113.491 18.8025 113.501 19.8973 113.501 21C113.501 22.1027 113.491 23.1995 113.553 24.3022C113.615 25.5831 113.907 26.7199 114.843 27.6565C115.782 28.5951 116.917 28.8853 118.198 28.9474C119.302 29.0094 120.397 28.9994 121.5 28.9994C122.605 28.9994 123.699 29.0094 124.802 28.9474C126.083 28.8853 127.22 28.5931 128.156 27.6565C129.095 26.7179 129.385 25.5831 129.447 24.3022C129.511 23.1995 129.499 22.1047 129.499 21ZM127.738 25.7192C127.592 26.0834 127.416 26.3556 127.134 26.6358C126.851 26.918 126.581 27.0941 126.217 27.2402C125.164 27.6585 122.665 27.5644 121.498 27.5644C120.331 27.5644 117.829 27.6585 116.777 27.2422C116.413 27.0961 116.14 26.92 115.86 26.6378C115.578 26.3556 115.402 26.0854 115.256 25.7212C114.839 24.6665 114.934 22.1668 114.934 21C114.934 19.8332 114.839 17.3315 115.256 16.2788C115.402 15.9146 115.578 15.6424 115.86 15.3622C116.142 15.082 116.413 14.9039 116.777 14.7578C117.829 14.3415 120.331 14.4356 121.498 14.4356C122.665 14.4356 125.166 14.3415 126.219 14.7578C126.583 14.9039 126.855 15.08 127.136 15.3622C127.418 15.6444 127.594 15.9146 127.74 16.2788C128.156 17.3315 128.062 19.8332 128.062 21C128.062 22.1668 128.156 24.6665 127.738 25.7192Z"/></a><a class="icon" href="https://www.linkedin.com/" target="_blank"><circle cx="171.5" cy="21" r="20.5" stroke="#0F172A"/><path d="M165.423 16.8525C166.485 16.8525 167.346 15.9901 167.346 14.9263C167.346 13.8624 166.485 13 165.423 13C164.361 13 163.5 13.8624 163.5 14.9263C163.5 15.9901 164.361 16.8525 165.423 16.8525Z" fill="#0F172A"/><path d="M169.162 18.3122V28.9991H172.474V23.7142C172.474 22.3197 172.736 20.9692 174.462 20.9692C176.165 20.9692 176.186 22.5636 176.186 23.8022V29H179.5V23.1393C179.5 20.2605 178.881 18.0481 175.522 18.0481C173.909 18.0481 172.828 18.9346 172.386 19.7736H172.342V18.3122H169.162ZM163.764 18.3122H167.081V28.9991H163.764V18.3122Z"/></a></svg></div><div class="navigation"><div class="column"><div class="column__title">Navigation</div><div class="column__links"><a href="index.php">Home</a> <a href="collections.php">Collections</a></div></div><div class="column"><div class="column__title">Community</div><div class="column__links"><a href="about.php">About</a> <a href="contact.php">Help Center</a></div></div></div><div class="subscribe"><div class="subscribe__title">Subscribe Us</div><div class="subscribe__form form"><form action="php/subscribe.inc.php" method="POST"><input class="form__input" name="email" type="email" placeholder="Enter your email"> <button class="plane__btn" type="submit" name="subscribe"><img class="plane__icon" src="assets/icons/paper-plane.svg" alt="Send message"></button> <?php
					if (isset($_SESSION['error-subs'])) {
						$errorMsg = $_SESSION['error-subs'];
						unset($_SESSION['error-subs']);
						echo "<p class='error-msg'>{$errorMsg}</p>";
					}
					if (isset($_SESSION['success-subs'])) {
						$successMsg = $_SESSION['success-subs'];
						unset($_SESSION['success-subs']);
						echo "<p class='success-msg'>{$successMsg}</p>";
					}
					?> </form></div><p class="subscribe__subtitle">Your privacy is protected! We dont disclose Email.</p></div></div><div class="copyright"><div class="copyright__text">&copy; <?= date('Y') ?> - OxyProject. All rights reserved.</div><div class="copyright__links"><a href="terms.php#privacy-policy">Privacy Policy</a> <a href="terms.php">Terms of Service</a></div></div></footer></div><a href="#" class="btn_to_top"><i class="fas fa-chevron-up"></i></a></body></html>