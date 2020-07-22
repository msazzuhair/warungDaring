<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>My Cart - Warung Daring</title>
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
  <main class="page shopping-cart-page">
    <section class="clean-block clean-cart dark">
      <div class="container">
        <div class="block-heading">
          <h2 class="text-info">My Cart</h2>
        </div>
        <div class="content">
          <div class="row no-gutters">
            <div class="col-md-12 col-lg-8">
            <?php if (empty($items)) : ?><h5 class="mt-5 text-center">Keranjang belanja Anda kosong!</h5><?php endif; ?>
              <div class="items">
              <?php
                $total = 0;
                $weight = 0;
                foreach($items as $item) : 
                $total += $item->price * $item->qty;
                $weight += $item->weight * $item->qty;
              ?>
                <div class="product">
                  <div class="row justify-content-center align-items-center">
                    <div class="col-md-3">
                      <div class="product-image"><img class="img-fluid d-block mx-auto image" src="<?= base_url($item->photo) ?>"></div>
                    </div>
                    <div class="col-md-5 product-info"><a class="product-name" href="<?= site_url('barang/details?id='.$item->id) ?>"><?= $item->name ?></a>
                      <div class="product-specs">
                        <?php foreach ($item->description as $p) : ?><p class="value"><?= $p ?></p><?php endforeach; ?>
                      </div>
                    </div>
                    <div class="col-6 col-md-4">
                      <div class="quantity">
                        <div class="d-none d-md-block" for="quantity">Quantity: <?= $item->qty ?></div>
                        <div class="btn-group mt-2" role="group" aria-label="Edit Item">
                          <a href="<?= site_url('my_cart/reduce_qty?id='.$item->id) ?>" class="btn btn-warning"><i class="fas fa-minus"></i></a>
                          <a href="<?= site_url('my_cart/remove_from_cart?id='.$item->id) ?>" class="btn btn-danger"><i class="fas fa-trash"></i></a>
                          <a href="<?= site_url('my_cart/add_to_cart?id='.$item->id) ?>" class="btn btn-primary"><i class="fas fa-plus"></i></a>
                        </div>
                      </div>
                      <div class="price mt-4"><span>Rp <?= number_format($item->price * $item->qty, 2, ',', '.') ?></span></div>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
              </div>
            </div>
            <div class="col-md-12 col-lg-4">
              <div class="summary">
                <h3>Summary</h3>
                <h4><span class="text">Subtotal</span><span class="price">Rp <?= number_format($total, 2, ',', '.') ?></span></h4>
                <h4><span class="text">Diskon</span><span class="price">Rp 0,00</span></h4>
                <h4><span class="text">Pengiriman</span><span class="price">Rp <?= number_format($shipping = ceil($weight/1000) * 20000, 2, ',', '.') ?></span></h4>
                <h4><span class="text">Total</span><span class="price">Rp <?= number_format($total+$shipping, 2, ',', '.') ?></span></h4>
                <a class="btn btn-primary btn-block btn-lg<?= $total > 0 ? '' : ' disabled' ?>" role="button" href="<?= $total > 0 ? site_url('checkout') : '' ?>">Checkout</a></div>
            </div>
          </div>
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