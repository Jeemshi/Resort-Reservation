<?php
if (!isset($page_title)) $page_title = 'WildNest Resort';
if (!isset($active_page)) $active_page = '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($page_title) ?> — WildNest Resort</title>
    <meta name="description" content="WildNest Resort — Where Adventure Meets Luxury in the heart of the Philippine highlands.">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
</head>
<body>

<nav class="navbar" id="mainNav">
    <div class="navbar-inner">
        <a href="<?= SITE_URL ?>/index.php" class="navbar-brand">
            <div class="navbar-logo"><i class="fas fa-mountain"></i></div>
            <div>
                <div class="navbar-name">WildNest</div>
                <div class="navbar-tagline">Resort & Retreat</div>
            </div>
        </a>

        <ul class="navbar-nav" id="navMenu">
            <li><a href="<?= SITE_URL ?>/index.php" class="nav-link <?= $active_page==='home'?'active':'' ?>">Home</a></li>
            <li><a href="<?= SITE_URL ?>/guest/about.php" class="nav-link <?= $active_page==='about'?'active':'' ?>">About</a></li>
            <li><a href="<?= SITE_URL ?>/guest/rooms.php" class="nav-link <?= $active_page==='rooms'?'active':'' ?>">Rooms</a></li>
            <li><a href="<?= SITE_URL ?>/guest/amenities.php" class="nav-link <?= $active_page==='amenities'?'active':'' ?>">Amenities</a></li>
            <li><a href="<?= SITE_URL ?>/guest/services.php" class="nav-link <?= $active_page==='services'?'active':'' ?>">Services</a></li>
            <li><a href="<?= SITE_URL ?>/guest/contact.php" class="nav-link <?= $active_page==='contact'?'active':'' ?>">Contact</a></li>
        </ul>

        <div class="navbar-actions">
            <?php if (isGuestLoggedIn()): ?>
                <a href="<?= SITE_URL ?>/guest/bookings.php" class="btn btn-secondary btn-sm">
                    <i class="fas fa-calendar"></i> My Bookings
                </a>
                <a href="<?= SITE_URL ?>/guest/logout.php" class="btn btn-primary btn-sm">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            <?php else: ?>
                <a href="<?= SITE_URL ?>/guest/login.php" class="btn btn-secondary btn-sm">Sign In</a>
                <a href="<?= SITE_URL ?>/guest/register.php" class="btn btn-primary btn-sm">Book Now</a>
            <?php endif; ?>
        </div>

        <button class="hamburger" id="hamburgerBtn" onclick="toggleMenu()">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>

<script>
function toggleMenu() {
    document.getElementById('navMenu').classList.toggle('open');
}
window.addEventListener('scroll', function() {
    document.getElementById('mainNav').classList.toggle('scrolled', window.scrollY > 50);
});
window.dispatchEvent(new Event('scroll'));
</script>
