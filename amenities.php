<?php
require_once __DIR__ . '/../includes/config.php';
$page_title = 'Amenities';
$active_page = 'amenities';
include __DIR__ . '/../includes/header.php';
$db = getDB();
$amenities = $db->query("SELECT * FROM amenities ORDER BY category, name");
$by_cat = [];
while ($a = $amenities->fetch_assoc()) {
    $by_cat[$a['category']][] = $a;
}
?>

<div class="page-banner">
    <div class="page-banner-content">
        <div class="eyebrow">What's Included</div>
        <h1>Resort Amenities</h1>
        <div class="breadcrumb"><a href="<?= SITE_URL ?>/index.php">Home</a> <i class="fas fa-chevron-right fa-xs"></i> Amenities</div>
    </div>
</div>

<!-- INTRO -->
<section class="section">
    <div class="container">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:5rem;align-items:center;margin-bottom:5rem">
            <div>
                <div class="eyebrow">The Full Picture</div>
                <h2 class="section-title" style="margin:.5rem 0 1.25rem">Everything Your<br>Wild Stay Needs</h2>
                <p style="font-size:1rem;color:var(--text-mid);line-height:1.8;margin-bottom:1rem">
                    Every room at WildNest comes stocked with what you actually need — no fluff, nothing missing. From the high-thread-count linens made in Pampanga to the hand-carved bamboo furniture from our local artisans, comfort is never an afterthought.
                </p>
                <p style="font-size:1rem;color:var(--text-mid);line-height:1.8">
                    We also maintain shared resort facilities that would make any city hotel envious — from the summit infinity pool to the forest-edge yoga platform and our legendary communal fire pit.
                </p>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
                <?php
                $highlights = [
                    ['fa-swimming-pool','Summit Infinity Pool','var(--jungle-dark)'],
                    ['fa-utensils','Canopy Restaurant','var(--ochre)'],
                    ['fa-spa','Forest Spa & Wellness','var(--jungle-mid)'],
                    ['fa-fire','Communal Fire Pit','var(--ember)'],
                ];
                foreach ($highlights as $h): ?>
                <div style="background:<?=$h[2]?>;border-radius:var(--radius-lg);padding:1.5rem;color:white;text-align:center">
                    <i class="fas <?=$h[0]?>" style="font-size:2rem;margin-bottom:.75rem;opacity:.9"></i>
                    <div style="font-family:var(--font-head);font-size:.78rem;letter-spacing:.08em;text-transform:uppercase;font-weight:600"><?=$h[1]?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Resort-Wide Amenities -->
        <div class="section-header center">
            <div class="eyebrow">Resort-Wide</div>
            <h2 class="section-title">Shared Facilities</h2>
        </div>
        <div class="grid-3" style="margin-bottom:5rem">
            <?php
            $facilities = [
                ['fa-swimming-pool','Summit Infinity Pool','Open 6AM–9PM. Heated during cooler months. Perched at the resort\'s highest point with unobstructed valley views.'],
                ['fa-utensils','Canopy Restaurant','Open for breakfast, lunch, and dinner. Our executive chef cooks what the forest provides — a different menu, daily.'],
                ['fa-spa','Forest Spa & Wellness Center','Full treatment menu: massage, botanical facials, herbal steam. Book at the front desk or add to your reservation.'],
                ['fa-fire','Communal Fire Pit','The social heart of WildNest. Nightly bonfire from 7PM. Stories, s\'mores, and cold local brew included.'],
                ['fa-mountain','Sunrise Yoga Deck','600m² open-air platform at the treeline. Morning sessions at 5:30AM and 7AM, led by certified instructors.'],
                ['fa-car','Complimentary Parking','Secure gated parking for all registered guests. Vintage jeepney shuttle runs every 30 minutes around the grounds.'],
                ['fa-wifi','Resort-Wide Wi-Fi','High-speed fiber connectivity throughout the property. Stream, work, or video call without interruption.'],
                ['fa-tshirt','Laundry Services','Same-day laundry service for all guests. Drop off at the front desk by 9AM for return by 6PM.'],
                ['fa-first-aid','24/7 Medical Support','Resident first-aider and emergency protocols for all adventure activities. Nearest hospital is 20 minutes away.'],
            ];
            foreach ($facilities as $f): ?>
            <div class="card" style="padding:1.75rem">
                <div style="width:52px;height:52px;background:var(--mist);border-radius:var(--radius);display:flex;align-items:center;justify-content:center;font-size:1.25rem;color:var(--canopy);margin-bottom:1rem">
                    <i class="fas <?=$f[0]?>"></i>
                </div>
                <h4 style="font-family:var(--font-display);font-size:1.05rem;font-weight:700;color:var(--jungle-dark);margin-bottom:.5rem"><?=$f[1]?></h4>
                <p style="font-size:.87rem;color:var(--text-mid);line-height:1.6"><?=$f[2]?></p>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- In-Room Amenities -->
        <?php if (!empty($by_cat)): ?>
        <div class="section-header center">
            <div class="eyebrow">In Every Room</div>
            <h2 class="section-title">In-Room Amenities by Category</h2>
        </div>
        <div style="display:flex;flex-direction:column;gap:3rem">
            <?php foreach ($by_cat as $cat => $amenity_list): ?>
            <div>
                <h3 style="font-family:var(--font-head);font-size:.85rem;letter-spacing:.15em;text-transform:uppercase;color:var(--ochre);font-weight:700;margin-bottom:1.25rem;padding-bottom:.75rem;border-bottom:2px solid var(--stone)">
                    <?= htmlspecialchars($cat) ?>
                </h3>
                <div class="grid-4">
                    <?php foreach ($amenity_list as $a): ?>
                    <div style="display:flex;align-items:flex-start;gap:.75rem;padding:1rem;background:var(--mist);border-radius:var(--radius)">
                        <div style="width:36px;height:36px;background:var(--white);border-radius:var(--radius-sm);display:flex;align-items:center;justify-content:center;font-size:.9rem;color:var(--canopy);flex-shrink:0">
                            <i class="fas <?= htmlspecialchars($a['icon'] ?? 'fa-check') ?>"></i>
                        </div>
                        <div>
                            <div style="font-weight:600;font-size:.88rem;color:var(--jungle-dark)"><?= htmlspecialchars($a['name']) ?></div>
                            <?php if ($a['description']): ?>
                            <div style="font-size:.78rem;color:var(--text-light);margin-top:.2rem"><?= htmlspecialchars($a['description']) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- CTA -->
<section style="background:var(--jungle-dark);padding:5rem 0;text-align:center">
    <div class="container">
        <div class="eyebrow" style="color:var(--ochre)">Bring Nothing But Curiosity</div>
        <h2 style="font-family:var(--font-display);font-size:clamp(1.8rem,4vw,2.8rem);font-weight:900;color:white;margin:.75rem 0 1.25rem">Everything Else Is Here Waiting</h2>
        <div style="display:flex;justify-content:center;gap:1rem;flex-wrap:wrap">
            <a href="<?= SITE_URL ?>/guest/rooms.php" class="btn btn-primary btn-lg"><i class="fas fa-bed"></i> Book a Room</a>
            <a href="<?= SITE_URL ?>/guest/services.php" class="btn btn-secondary btn-lg">Explore Services</a>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
