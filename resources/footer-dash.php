<footer class="app-footer">
  <div class="container text-center py-3">
    <!--/* This template is free as long as you keep the footer attribution link. If you'd like to use the template without the attribution link, you can buy the commercial license via our website: themes.3rdwavemedia.com Thank you for your support. :) */-->
    <small class="copyright">All Rights Reserved By <a class="app-link" href="https://www.netmedia-framecode.com/" target="_blank">Netmedia Framecode</a></small>

  </div>
</footer>
<!--//app-footer-->

</div>
<!--//app-wrapper-->

<!-- Javascript -->
<script src="<?= $baseURL ?>assets/js/popper.min.js"></script>
<script src="<?= $baseURL ?>assets/js/bootstrap.min.js"></script>

<!-- Charts JS -->
<script src="<?= $baseURL ?>assets/js/chart.min.js"></script>
<script src="<?= $baseURL ?>assets/js/index-charts.js"></script>

<!-- Page Specific JS -->
<script src="<?= $baseURL ?>assets/js/app.js"></script>

<script src="<?= $baseURL; ?>assets/js/jquery-3.5.1.min.js"></script>
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