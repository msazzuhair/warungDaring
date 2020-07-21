<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>Warung Daring</title>
  <meta name="description" content="Belanja Gak Bikin Pening, Harga Miring!">
  <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/styles.min.css') ?>">
</head>

<body>
  <main class="page login-page">
    <section class="clean-block clean-form dark">
      <div class="container">
        <div class="block-heading">
          <h2 class="text-info">Warung Daring</h2>
        </div>
        <?php echo form_open("auth/login");?>
          <div class="form-group">
            <label for="email"><?php echo lang('login_identity_label', 'identity');?></label>
            <?php echo form_input($identity);?>
          </div>
          <div class="form-group">
            <label for="password"><?php echo lang('login_password_label', 'password');?></label>
            <?php echo form_input($password);?>
          </div>
          <div class="form-group">
            <div class="form-check">
              <?php echo form_checkbox('remember', '1', FALSE, 'id="remember" class="form-check-input"');?>
              <label class="form-check-label" for="checkbox"><?php echo lang('login_remember_label', 'remember');?></label>
            </div>
          </div>
          <?php echo form_submit('submit', lang('login_submit_btn'), 'class="btn btn-primary btn-block"');?>
        </form>
      </div>
    </section>
  </main>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js"></script>
  <script src="<?php echo base_url('assets/js/script.min.js'); ?>"></script>
</body>
</html>