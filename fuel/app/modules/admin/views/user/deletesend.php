<div class="ui one column centered grid">
  <div class="row">
    <div class="ui warning  message">
    <p>削除しました！</p>
    </div>
  </div>
  <div class="row">
    <?php
    echo Form::open('/admin/users/login');
    ?>
      <div class='actions'>
        <?php echo Form::submit('submit','ログインページへ', ['class' => 'ui inverted primary button']); ?>
      </div>
    <?php echo Form::close(); ?>
  </div>
</div>
