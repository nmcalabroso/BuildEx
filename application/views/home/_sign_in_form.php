<?php echo form_open("home/validate_user");?>
    <label>Username</label>
    <input type="text" id="signInUsername" required name="username" placeholder="Enter username">
    <label>Password</label>
    <input type="password" id="signInPass" required name="password" placeholder="Password">
    <input type="submit" class="button" value="Login">
<?php echo form_close();?>