<?php echo form_open('users/login'); ?>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
    <h1 class="text-center"><?php echo $title; ?></h1>
    <br><br><br>
    <div class="form-group">
        <br>
        <input type="text" name="username" placeholder="Enter Username" required autofocus class="form-control">
    </div>
    <div class="form-group">
        <br>
        <input type="password" name="password" placeholder="Enter Password" required autofocus class="form-control">
    </div>
    <br>
    <button type="submit" class="btn btn-secondary btn-block">Login</button>
    </div>
</div>

<?php echo form_close(); ?>