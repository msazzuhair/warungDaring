<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>Catalog - Warung Daring</title>
  <meta name="description" content="Belanja Gak Bikin Pening, Harga Miring!">
  <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
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
  <main class="page catalog-page">
    <section class="clean-block clean-catalog dark">
      <div class="container">
        <div class="carousel slide" data-ride="carousel" id="carousel-1">
          <div class="carousel-inner" role="listbox">
            <div class="carousel-item active"><img class="img-fluid w-100 d-block" src="assets/img/cf6e08-Main-Banner.jpg" alt="Slide Image" loading="lazy"></div>
            <div class="carousel-item"><img class="img-fluid w-100 d-block" src="assets/img/ac2fa1-Gadget-Mb-ok.jpg" alt="Slide Image"></div>
            <div class="carousel-item"><img class="img-fluid w-100 d-block" src="assets/img/aa0e4f-MB01v2rev.jpg" alt="Slide Image"></div>
          </div>
          <div><a class="carousel-control-prev" href="#carousel-1" role="button" data-slide="prev"><span class="carousel-control-prev-icon"></span><span class="sr-only">Previous</span></a><a class="carousel-control-next" href="#carousel-1" role="button"
              data-slide="next"><span class="carousel-control-next-icon"></span><span class="sr-only">Next</span></a></div>
          <ol class="carousel-indicators">
            <li data-target="#carousel-1" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-1" data-slide-to="1"></li>
            <li data-target="#carousel-1" data-slide-to="2"></li>
          </ol>
        </div>
        <div class="content">
          <div class="row">
            <div class="col-12">
              <div class="products" style="margin-left: 30px;">
                <div class="row no-gutters">
                <?php foreach($items as $item) : ?>
                  <div class="col-12 col-md-4 col-lg-4">
                    <div class="clean-product-item d-flex align-items-center flex-column">
                      <div class="image"><a href="<?= site_url('barang/details?id='.$item->id) ?>"><img class="img-fluid d-block mx-auto w-100" src="<?= base_url($item->photo) ?>"></a></div>
                      <div class="product-name mb-auto"><a href="<?= site_url('barang/details?id='.$item->id) ?>"><br><?= $item->name ?></a></div>
                      <div class="about d-flex justify-content-center justify-content-md-start mt-3">
                        <div>Stok : <?= ($item->stock > 0) ? $item->stock : 'habis' ?></div>
                      </div>
                      <div class="about d-flex justify-content-center justify-content-md-start mt-2">
                        <div class="price">
                          <h3>Rp <?= number_format($item->price,2,',','.') ?></h3>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
                </div>
                <nav>
                  <ul class="pagination">
                    <!-- Previous page -->
                  <?php if ($page <= 1): ?>
                    <li class="page-item disabled"><a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                  <?php else : ?>
                    <li class="page-item"><a class="page-link" href="<?= site_url('barang?page='.($page-1)) ?>" aria-label="Previous"><span aria-hidden="true">«</span></a></li>
                  <?php endif; ?>
                    <!-- Page numbers -->
                  <?php for ($i = 1; $i <= $pages; $i++) : ?>
                  <?php if ($page === $i): ?>
                    <li class="page-item disabled"><a class="page-link" href="#"><?= $i ?></a></li>
                  <?php else : ?>
                    <li class="page-item"><a class="page-link" href="<?= site_url('barang?page='.$i) ?>"><?= $i ?></a></li>
                  <?php endif; ?>
                  <?php endfor; ?>
                    <!-- Next page -->
                  <?php if ($page >= $pages): ?>
                    <li class="page-item disabled"><a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">»</span></a></li>
                  <?php else : ?>
                    <li class="page-item"><a class="page-link" href="<?= site_url('barang?page='.($page+1))?>" aria-label="Next"><span aria-hidden="true">»</span></a></li>
                  <?php endif; ?>
                  </ul>
                </nav>
              </div>
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