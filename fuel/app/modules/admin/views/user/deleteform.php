<div class="ui one column centered grid">
  <div class="row">
    <div class="ui warning  message">
      <p>本当に削除しますか？</p>
    </div>
  </div>
</div>

<div class="ui two column grid centered">
<div class="ui five column row">
  <div class="column">
    <div class="ui form">
      <?php echo Form::open('/admin/users/deleteconfirm'); ?>
        <div class="field">
          
          <div class="label">Password for Confirm</div>
            <div class="ui small">
              <?php echo Form::password('pass', Input::post('pass'), ['placeholder' => 'Your Password...']); ?>
            </div>
          </div>
          
          <div class='actions'>
            <?php echo Form::submit('submit', 'OK', ['class' => 'ui inverted primary button']); ?>
          </div>

        </div>
          
      <?php echo Form::close(); ?>
    </div>
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
  </div>
</div> 

