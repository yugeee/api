<div class="ui two column grid centered">
<div class="ui five column row">
  <div class="column">
    <div class="ui form">
    <?php echo Form::open('/admin/users/loginform'); ?>

    <div class="field">
      <div class="label">ID</div>
      <div class="ui small">
        <?php echo Form::input('id', input::post('id'), ['placeholder' => 'Your ID...']); ?>
      </div>
    </div>

    <div class="field">
      <div class="label">Password</div>
      <div class="ui small">
        <?php echo Form::password('pass', Input::post('pass'), ['placeholder' => 'Your Password...']); ?>
      </div>
    </div>

    <div class='actions'>
      <?php echo Form::submit('submit', 'ログイン', ['class' => 'ui inverted primary button']); ?>
    </div>
    
    <?php echo Form::close(); ?>
    
    <div class="ui hidden divider"></div>
      
    <div class='actions'>
      <?php echo Form::open('admin/users/'); ?>
        <?php echo Form::submit('submit4', 'ユーザー新規登録', ['class' => 'ui inverted button']); ?>
      <?php echo Form::close(); ?>
    </div>

    <?php if (isset($html_error)): ?>
      <div class="ui negative message">
        <?php echo $html_error; ?>
      </div>
    <?php endif; ?>
    
  </div>
</div>
</div>