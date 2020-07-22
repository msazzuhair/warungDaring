<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>Payment - Warung Daring</title>
  <meta name="description" content="Belanja Gak Bikin Pening, Harga Miring!">
  <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/styles.min.css') ?>">
</head>

<body>
  <nav class="navbar navbar-light navbar-expand-lg fixed-top bg-light clean-navbar">
    <div class="container"><a class="navbar-brand logo" href="<?= site_url() ?>">Warung Daring</a><button data-toggle="collapse" class="navbar-toggler" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
      <div
        class="collapse navbar-collapse" id="navcol-1">
        <ul class="nav navbar-nav ml-auto">
<?php if (!$this->ion_auth->logged_in()) { ?>
          <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo site_url('auth/login') ?>"><i class="fa fa-sign-in"></i> Sign in</a></li>
<?php } else { ?>
          <li class="nav-item" role="presentation"><a class="nav-link" href="#"><?php echo $username; ?></a></li>
          <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo site_url('my_cart') ?>"><i class="fa fa-shopping-cart"></i> My Cart<?= $cart_count > 0 ? '<span class="badge badge-secondary">'.$cart_count.'</span>' : '' ?></a></li>
          <li class="nav-item" role="presentation"><a class="nav-link" href="<?php echo site_url('auth/logout') ?>"><i class="fa fa-sign-out"></i> Sign Out</a></li>
<?php } ?>
        </ul>
      </div>
    </div>
  </nav>
  <main class="page payment-page">
    <section class="clean-block payment-form dark">
      <div class="container">
        <div class="block-heading">
          <h2 class="text-info">Status</h2>
        </div>
          <div class="products">
            <h3 class="title">Data Pembelian</h3>
            <div class="item">
              <span class="price">Rp <?= number_format($item->total, 2, ',', '.') ?></span>
              <p class="item-name">Total</p>
              <p class="item-description">Total Pembayaran</p>
            </div>
          </div>
          <div class="card-details">
            <h3 class="title">Riwayat Pengiriman</h3>
            <dl>
            <?php foreach ($pengiriman as $p) : ?>
              <dt><?= $p['status'] ?></dt>
              <dd><?= $p['waktu'] ?></dd>
            </dl>
            <?php endforeach; ?>
          </div>
      </div>
    </section>
  </main>
  <footer class="page-footer dark">
    <div class="container">
      <div class="row">
        <div class="col-sm-3">
          <h5>Get started</h5>
          <ul>
            <li><a href="#">Home</a></li>
            <li><a href="#">Sign up</a></li>
            <li><a href="#">Downloads</a></li>
          </ul>
        </div>
        <div class="col-sm-3">
          <h5>About us</h5>
          <ul>
            <li><a href="#">Company Information</a></li>
            <li><a href="#">Contact us</a></li>
            <li><a href="#">Reviews</a></li>
          </ul>
        </div>
        <div class="col-sm-3">
          <h5>Support</h5>
          <ul>
            <li><a href="#">FAQ</a></li>
            <li><a href="#">Help desk</a></li>
            <li><a href="#">Forums</a></li>
          </ul>
        </div>
        <div class="col-sm-3">
          <h5>Legal</h5>
          <ul>
            <li><a href="#">Terms of Service</a></li>
            <li><a href="#">Terms of Use</a></li>
            <li><a href="#">Privacy Policy</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="footer-copyright">
      <p>© 2020 Warung Daring</p>
    </div>
  </footer>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js"></script>
  <script src="<?php echo base_url('assets/js/script.min.js'); ?>"></script>
</body>

</html>