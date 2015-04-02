<style type="text/css" media="screen">
  #icon-settings-hipchat {
    background: transparent url(/wp-content/plugins/hipchat/logo.png) no-repeat top left;
  }
</style>

<div class="wrap">
  <div id="icon-settings-hipchat" class="icon32"><br/></div>
  <h2>HipChat Plugin Settings</h2>

  <p>This plugin will send a HipChat message whenever a new blog entry is published. For support, please contact <a href="http://www.hipchat.com/contact">HipChat</a>.</p>

  <?php if ($updated): ?>
  <div class="updated"><p><?php echo $updated ?></p></div>
  <?php endif; ?>

  <?php if ($error): ?>
  <div class="error"><p><?php echo $error ?></p></div>
  <?php endif; ?>

  <form name="hipchat" method="post" action="">
    <table class="form-table">
      <tr>
        <th>
          <label for="auth_token">Auth Token</label>
        </th>
        <td>
          <input name="auth_token" type="text" id="auth_token"
                 value="<?php echo $auth_token ?>" class="regular-text">
          <span class="description">
            A HipChat
            <a href="http://www.hipchat.com/group_admin/api" target="_blank">
              API token</a>.
          </span>
        </td>
      </tr>
      <tr>
        <th>
          <label for="from">From Name</label>
        </th>
        <td>
          <input name="from" type="text" id="from" value="<?php echo $from ?>" 
                 class="regular-text">
          <span class="description">Name the messages will come from.</span>
        </td>
      </tr>
      <tr>
        <th>
          <label for="room_name">Room Name</label>
        </th>
        <td>
          <input name="room" type="text" id="room" value="<?php echo $room ?>" class="regular-text">
          <span class="description">
            Name of the room to send messages to.
          </span>
        </td>
      </tr>
    </table>
    <p class="submit">
      <input type="submit" name="Submit" class="button-primary"
             value="Save Changes">
    </p>
  </form>
</div>
