<div class="ui three column grid centered">
<div class="ui column row">
  <div class="column">
    <div class="ui form">
      <div class="ui divided selection list">
    
        <p class="item">
          <div class="ui purple horizontal label">Your ID</div>
          <?php echo $user['id']; ?>
        </p>
    
        <p class="item">
          <div class="ui purple horizontal label">Your Name</div>
          <?php echo $user['name']; ?>
        </p>
    
        <p class="item">
          <div class="ui purple horizontal label">Your Mail</div>
            <?php echo $user['mail']; ?>
        </p>

      </div>
    </div>

    <div class="ui divider"></div>

    <?php
    echo Form::open('/admin/users/update');
    echo Form::hidden('name', $user['name']);
    ?>
      <div class="actions">
        <?php echo Form::submit('submit', '編集', ['class' => 'ui inverted yellow button']); ?>
      </div>
    <?php echo Form::close(); ?>
    
    <?php
    echo Form::open('/admin/users/delete');
    echo Form::hidden('name', $user['name']);
    ?>
      <div class="actions">
        <?php echo Form::submit('submit2', '削除', ['class' => 'ui inverted red button']); ?>
      </div>
    <?php echo Form::close(); ?>
    
    <?php echo Form::open('/admin/users/logout'); ?>
      <div class="actions">
        <?php echo Form::submit('submit3', 'ログアウト', ['class' => 'ui inverted violet button']); ?>
      </div>
    <?php echo Form::close(); ?>
  </div>  
</div>
</div>