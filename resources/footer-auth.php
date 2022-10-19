<footer class="app-auth-footer">
  <div class="container text-center py-3">
    <!--/* This template is free as long as you keep the footer attribution link. If you'd like to use the template without the attribution link, you can buy the commercial license via our website: themes.3rdwavemedia.com Thank you for your support. :) */-->
    <small class="copyright">All Rights Reserved By <a class="app-link" href="https://www.netmedia-framecode.com/" target="_blank">Netmedia Framecode</a></small>

  </div>
</footer>
<!--//app-auth-footer-->
</div>
<!--//flex-column-->
</div>
<!--//auth-main-col-->
<div class="col-12 col-md-5 col-lg-6 h-100 auth-background-col">
  <div class="auth-background-holder">
  </div>
  <div class="auth-background-mask"></div>
  <!--//auth-background-overlay-->
</div>
<!--//auth-background-col-->

</div>
<!--//row-->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script type="text/javascript" src="<?= $baseURL; ?>assets/js/jquery-3.5.1.min.js"></script>
<script>
  const messageSuccess = $('.message-success').data('message-success');
  const messageInfo = $('.message-info').data('message-info');
  const messageWarning = $('.message-warning').data('message-warning');
  const messageDanger = $('.message-danger').data('message-danger');

  if (messageSuccess) {
    Swal.fire({
      icon: 'success',
      title: 'Berhasil Terkirim',
      text: messageSuccess,
    })
  }

  if (messageInfo) {
    Swal.fire({
      icon: 'info',
      title: 'For your information',
      text: messageInfo,
    })
  }
  if (messageWarning) {
    Swal.fire({
      icon: 'warning',
      title: 'Peringatan!!',
      text: messageWarning,
    })
  }
  if (messageDanger) {
    Swal.fire({
      icon: 'error',
      title: 'Kesalahan',
      text: messageDanger,
    })
  }
</script>