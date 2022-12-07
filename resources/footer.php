<!-- footer section -->
<section class="container-fluid footer_section ">
  <div class="container">
    <p>
      &copy; <span id="displayYear"></span> All Rights Reserved By
      <a href="https://www.netmedia-framecode.com/" target="_blank">Netmedia Framecode</a>
    </p>
  </div>
</section>
<!-- end  footer section -->

<script type="text/javascript" src="assets/js/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.js"></script>
<script type="text/javascript" src="assets/js/custom.js"></script>
<script type="text/javascript" src="assets/js/jquery-3.5.1.min.js"></script>
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