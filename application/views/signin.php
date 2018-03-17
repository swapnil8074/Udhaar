<?php if ($this->session->flashdata('msg')) {?>
    <div class="alert <?php echo $this->session->flashdata('msgClass') ?>">
    <strong><?php //echo ($this->session->flashdata('msgClass') == 'alert-danger') ? "Oops!" : '' ?></strong>  <?php echo $this->session->flashdata('msg'); ?>
    </div>
<?php }?>

<h1>This is singin page</h1>