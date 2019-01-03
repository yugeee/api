<div class="ui one column centered grid">
  <div class="row">
    <div class="ui warning  message">
      <p>こちらの内容で再登録しますか？</p>
    </div>
  </div>
</div>

<div class="ui two column grid centered">
<div class="ui six column row">
  <div class="column">
    <div class="ui form">
      <div class="ui divided selection list">
      
        <p class="item">
          <div class="ui purple horizontal label">Your New Name</div>
          <?php echo $input['name']; ?>
        </p>
      
        <p class="item">
          <div class="ui purple horizontal label">Your New Mail</div>
            <?php echo $input['mail']; ?>
        </p>

      </div>
    </div>

    <div class="ui divider"></div>

    <?php
    echo Form::open('/admin/users/updatesend');
    echo Form::hidden('name',  $input['name'],    array('id'=>'name'));
    echo Form::hidden('mail',  $input['mail'],    array('id'=>'mail'));
    echo Form::hidden('pass',  $input['pass'],    array('id'=>'pass'));
    ?>
      <div class="actions">
        <?php echo Form::submit('submit2', '送信', ['class' => 'ui inverted primary button']); ?>
      </div>
    <?php echo Form::close(); ?>

    <?php
    echo Form::open('/admin/users/update');
    echo Form::hidden('name', $input['name']);
    echo Form::hidden('mail',  $input['mail']);
    ?>
      <div class='actions'>
        <?php echo Form::submit('submit1', '修正', ['class' => 'ui inverted olive button']); ?>
      </div>
    <?php echo Form::close(); ?>

  </div> 
</div>
</div>