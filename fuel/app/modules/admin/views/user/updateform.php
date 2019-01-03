<div class="ui two column grid centered">
<div class="ui three column row">
  <div class="column">
    <div class="ui form">
    <?php echo Form::open('/admin/users/updateconfirm'); ?>

    <div class="field">
      <div class="label">Fullname</div>
      <div class="ui small">
        <?php echo Form::input('name', Input::post('name'), ['placeholder' => 'Your Name...']);?>
      </div>
    </div>

    <div class="field">
      <div class="label">Email</div>
      <div class="ui small">
        <?php echo Form::input('mail', Input::post('mail'), ['placeholder' => 'Your Email adress...']);?>
      </div>
    </div>

    <div class="field">
        <div class="label">Password for Confirm</div>
        <div class="ui small">
          <?php echo Form::password('pass', Input::post('pass'), ['placeholder' => 'Your Password...']); ?>
        </div>
      </div>

    <div class='actions'>
      <?php echo Form::submit('submit', '確認', ['class' => 'ui inverted primary button']); ?>
    </div>
    
    <?php echo Form::close(); ?>
    
  </div>
</div> 
</div>
<div class="ui one column centered grid">
  <div class="row">
    <?php if (isset($html_error)): ?>
      <div class="ui negative message">
        <?php echo $html_error; ?>
      </div>
    <?php endif; ?>
    <div class="ui info message">
      <p>ＩＤとパスワードは、ここでは変更できません。</p>
    </div>
  </div>
</div> 