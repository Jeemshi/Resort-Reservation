<?php
require_once __DIR__ . '/../includes/config.php';
requireAdminLogin(); // Protects this page from unauthenticated guests

$db = getDB();

// Fetch metrics summary from database
$room_count = $db->query("SELECT COUNT(*) as total FROM rooms")->fetch_assoc()['total'];
$booking_count = $db->query("SELECT COUNT(*) as total FROM bookings")->fetch_assoc()['total'];
$guest_count = $db->query("SELECT COUNT(*) as total FROM guests WHERE status='active'")->fetch_assoc()['total'];

// Fetch the 5 most recent bookings
$recent_bookings = $db->query("
    SELECT b.*, g.first_name, g.last_name, r.room_number 
    FROM bookings b
    JOIN guests g ON b.guest_id = g.id
    JOIN rooms r ON b.room_id = r.id
    ORDER BY b.created_at DESC LIMIT 5
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard — WildNest</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= SITE_URL ?>/assets/css/style.css">
</head>
<body style="background: var(--stone); margin:0; min-height: 100vh; display: flex; flex-direction: column;">

<nav style="background: var(--jungle-dark); color: white; padding: 1rem 2rem; display: flex; justify-content: space-between; align-items: center;">
    <div style="display: flex; align-items: center; gap: 1rem;">
        <span style="font-size: 1.5rem; color: var(--ochre-light);"><i class="fas fa-shield-alt"></i></span>
        <h3 style="margin: 0; font-family: var(--font-display);">WildNest HQ</h3>
    </div>
    <div style="display: flex; align-items: center; gap: 1.5rem;">
        <span style="font-size: 0.9rem; color: rgba(255,255,255,0.8);">Welcome, <strong><?= htmlspecialchars($_SESSION['admin_username']) ?></strong></span>
        <a href="<?= SITE_URL ?>/guest/logout.php" style="color: var(--ochre-light); text-decoration: none; font-size: 0.9rem;"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</nav>

<div style="display: flex; flex: 1;">
    <aside style="width: 240px; background: var(--jungle); color: white; padding: 2rem 1rem;">
        <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.5rem;">
            <li><a href="dashboard.php" style="display: block; padding: 0.75rem 1rem; color: white; text-decoration: none; background: rgba(255,255,255,0.1); border-radius: 6px; font-weight: 600;"><i class="fas fa-tachometer-alt" style="width: 25px;"></i> Dashboard</a></li>
            <li><a href="manage-rooms.php" style="display: block; padding: 0.75rem 1rem; color: rgba(255,255,255,0.8); text-decoration: none; border-radius: 6px;"><i class="fas fa-bed" style="width: 25px;"></i> Manage Rooms</a></li>
            <li><a href="<?= SITE_URL ?>/index.php" target="_blank" style="display: block; padding: 0.75rem 1rem; color: rgba(255,255,255,0.8); text-decoration: none; border-radius: 6px;"><i class="fas fa-external-link-alt" style="width: 25px;"></i> View Website</a></li>
        </ul>
    </aside>

    <main style="flex: 1; padding: 3rem;">
        <h1 style="font-family: var(--font-display); color: var(--jungle-dark); margin-bottom: 2rem;">Overview Matrix</h1>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
            <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border-left: 5px solid var(--canopy);">
                <div style="color: var(--text-light); font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Total Properties</div>
                <div style="font-size: 2.5rem; font-weight: 700; color: var(--jungle-dark); margin-top: 0.5rem;"><?= $room_count ?> Rooms</div>
            </div>
            <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border-left: 5px solid var(--ochre);">
                <div style="color: var(--text-light); font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Total Bookings</div>
                <div style="font-size: 2.5rem; font-weight: 700; color: var(--jungle-dark); margin-top: 0.5rem;"><?= $booking_count ?></div>
            </div>
            <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); border-left: 5px solid var(--ember);">
                <div style="color: var(--text-light); font-size: 0.85rem; font-weight: 600; text-transform: uppercase;">Registered Guests</div>
                <div style="font-size: 2.5rem; font-weight: 700; color: var(--jungle-dark); margin-top: 0.5rem;"><?= $guest_count ?></div>
            </div>
        </div>

        <div style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
            <h3 style="font-family: var(--font-display); color: var(--jungle-dark); margin-bottom: 1.5rem;">Recent Reservations</h3>
            <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
                <thead>
                    <tr style="border-bottom: 2px solid var(--stone); color: var(--text-light);">
                        <th style="padding: 1rem 0.5rem;">Guest</th>
                        <th style="padding: 1rem 0.5rem;">Room</th>
                        <th style="padding: 1rem 0.5rem;">Check In</th>
                        <th style="padding: 1rem 0.5rem;">Check Out</th>
                        <th style="padding: 1rem 0.5rem;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($recent_bookings->num_rows === 0): ?>
                        <tr><td colspan="5" style="padding: 2rem; text-align: center; color: var(--text-light);">No bookings records found.</td></tr>
                    <?php else: ?>
                        <?php while ($b = $recent_bookings->fetch_assoc()): ?>
                            <tr style="border-bottom: 1px solid var(--stone);">
                                <td style="padding: 1rem 0.5rem; font-weight: 600;"><?= htmlspecialchars($b['first_name'] . ' ' . $b['last_name']) ?></td>
                                <td style="padding: 1rem 0.5rem;">Room <?= htmlspecialchars($b['room_number']) ?></td>
                                <td style="padding: 1rem 0.5rem;"><?= formatDate($b['check_in']) ?></td>
                                <td style="padding: 1rem 0.5rem;"><?= formatDate($b['check_out']) ?></td>
                                <td style="padding: 1rem 0.5rem;"><span class="badge <?= getStatusBadge($b['status']) ?>"><?= ucfirst($b['status']) ?></span></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

</body>
</html>