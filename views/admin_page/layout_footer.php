<script>
    let flash_message_success = '<?= $this->flash_message['success'] ?>';
    let flash_message_warning = '<?= $this->flash_message['warning'] ?>';
    let flash_message_error = '<?= $this->flash_message['error'] ?>';
    let flash_message_info = '<?= $this->flash_message['info'] ?>';

    if(flash_message_success != ''){
      $(document).Toasts('create', {
        class: 'bg-success',
        title: 'Success',
        autohide: true,
        delay: 5000,
        body: flash_message_success
      })
    }

    if(flash_message_warning != ''){
      $(document).Toasts('create', {
        class: 'bg-warning',
        title: 'Warning',
        autohide: true,
        delay: 5000,
        body: flash_message_warning
      })
    }

    if(flash_message_error != ''){
      $(document).Toasts('create', {
        class: 'bg-danger',
        title: 'Error',
        autohide: true,
        delay: 5000,
        body: flash_message_error
      })
    }

    if(flash_message_info != ''){
      $(document).Toasts('create', {
        class: 'bg-info',
        title: 'Info',
        autohide: true,
        delay: 5000,
        body: flash_message_info
      })
    }
</script>

</body>
</html>