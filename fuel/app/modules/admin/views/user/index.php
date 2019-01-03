<?php echo Form::open('/admin/users/confirm'); ?>
<div class="ui two column grid centered">

<div class="ui five column row">
  <div class="column">
    <div class="ui form">
      
      <div class="field">
        <div class="label">ID</div>
        <div class="ui small">
          <?php echo Form::input('id', input::post('id'), ['placeholder' => 'Your ID...']); ?>
        </div>
      </div>
      
      <div class="field">
        <div class="label">Fullname</div>
        <div class="ui small">
        <?php echo Form::input('name', input::post('name'), ['placeholder' => 'Your Name...']); ?>
        </div>
      </div>
      
      <div class="field">
        <div class="label">Email</div>
        <div class="ui small">
        <?php echo Form::input('mail', Input::post('mail'), ['placeholder' => 'Your Email adress...']); ?>
        </div>
      </div>
      
      <div class="field">
        <div class="label">Password</div>
        <div class="ui small">
          <?php echo Form::password('pass', Input::post('pass'), ['placeholder' => 'Your Password...']); ?>
        </div>
      </div>
      
      <div class='actions'>
        <?php echo Form::submit('submit', '確認', ['class' => 'ui inverted primary button']); ?>
      </div>
      
      <?php if (isset($html_error)): ?>
        <div class="ui negative message">
          <?php echo $html_error; ?>
        </div>
      <?php endif;?>
    
    </div>
  </div>
</div>
</div>
<?php echo Form::close(); ?>