<?php
require_once __DIR__ . '/../includes/config.php';
$page_title = 'Services';
$active_page = 'services';
include __DIR__ . '/../includes/header.php';
$db = getDB();
$services = $db->query("SELECT * FROM services WHERE available=1 ORDER BY category, price ASC");
$by_cat = [];
while ($s = $services->fetch_assoc()) $by_cat[$s['category']][] = $s;
?>

<div class="page-banner">
    <div class="page-banner-content">
        <div class="eyebrow">What We Offer</div>
        <h1>Adventures & Services</h1>
        <div class="breadcrumb"><a href="<?= SITE_URL ?>/index.php">Home</a> <i class="fas fa-chevron-right fa-xs"></i> Services</div>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="section-header center">
            <div class="eyebrow">Beyond the Room</div>
            <h2 class="section-title">Curated for the Adventurous</h2>
            <p class="section-desc">Our guides, chefs, and wellness practitioners have spent their lives in these highlands. Everything we offer is designed by people who know this forest the way you know your neighborhood.</p>
        </div>

        <?php if (empty($by_cat)): ?>
        <div style="text-align:center;padding:4rem;color:var(--text-light)">No services currently available.</div>
        <?php else: ?>
        <?php foreach ($by_cat as $cat => $svcs): ?>
        <div style="margin-bottom:4rem">
            <div style="display:flex;align-items:center;gap:1rem;margin-bottom:2rem;padding-bottom:1rem;border-bottom:2px solid var(--stone)">
                <div style="width:40px;height:40px;background:var(--jungle-dark);border-radius:50%;display:flex;align-items:center;justify-content:center;color:var(--ochre-light);font-size:1rem">
                    <?php
                    $cat_icons = ['Adventure'=>'fa-hiking','Wellness'=>'fa-spa','Dining'=>'fa-utensils','Transport'=>'fa-bus','Experience'=>'fa-fire'];
                    $ci = $cat_icons[$cat] ?? 'fa-star';
                    ?>
                    <i class="fas <?=$ci?>"></i>
                </div>
                <div>
                    <h3 style="font-family:var(--font-head);font-size:1rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:var(--jungle-dark)"><?= htmlspecialchars($cat) ?></h3>
                    <div style="font-size:.8rem;color:var(--text-light)"><?= count($svcs) ?> experience<?=count($svcs)>1?'s':''?> available</div>
                </div>
            </div>
            <div class="grid-3">
                <?php foreach ($svcs as $s): ?>
                <div class="card">
                    <div style="background:linear-gradient(135deg,var(--jungle-dark),var(--jungle-mid));padding:2.5rem 2rem;text-align:center">
                        <div style="width:72px;height:72px;background:rgba(255,255,255,.1);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto;font-size:2rem;color:var(--ochre-light)">
                            <i class="fas <?= htmlspecialchars($s['icon']??'fa-star') ?>"></i>
                        </div>
                        <div style="margin-top:1rem;font-family:var(--font-head);font-size:.72rem;letter-spacing:.12em;text-transform:uppercase;color:var(--ochre-light)"><?= htmlspecialchars($s['category']) ?></div>
                    </div>
                    <div class="card-body">
                        <h4 style="font-family:var(--font-display);font-size:1.15rem;font-weight:700;color:var(--jungle-dark);margin-bottom:.5rem"><?= htmlspecialchars($s['name']) ?></h4>
                        <p style="font-size:.87rem;color:var(--text-mid);line-height:1.6"><?= htmlspecialchars($s['description']) ?></p>
                    </div>
                    <div class="card-footer">
                        <div class="price-tag"><?= formatCurrency($s['price']) ?> <span>/ person</span></div>
                        <a href="<?= SITE_URL ?>/guest/rooms.php" class="btn btn-dark btn-sm">
                            <i class="fas fa-plus"></i> Add to Stay
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<!-- HOW IT WORKS -->
<section class="section bg-stone">
    <div class="container">
        <div class="section-header center">
            <div class="eyebrow">How It Works</div>
            <h2 class="section-title">Adding Services to Your Stay</h2>
        </div>
        <div class="grid-4">
            <?php
            $steps = [
                ['1','Book Your Room','Choose and reserve your accommodation for your desired dates.'],
                ['2','Select Add-Ons','Browse and add any adventure or wellness services during checkout.'],
                ['3','Confirm with Staff','Our team confirms your service booking and assigns a guide or specialist.'],
                ['4','Experience Begins','Show up. We handle everything else.'],
            ];
            foreach ($steps as $step): ?>
            <div style="text-align:center;padding:2rem 1.25rem">
                <div style="width:56px;height:56px;background:var(--jungle-dark);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;font-family:var(--font-display);font-size:1.4rem;font-weight:900;color:var(--ochre-light)"><?=$step[0]?></div>
                <h4 style="font-family:var(--font-display);font-size:1rem;font-weight:700;color:var(--jungle-dark);margin-bottom:.5rem"><?=$step[1]?></h4>
                <p style="font-size:.85rem;color:var(--text-mid);line-height:1.6"><?=$step[2]?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
