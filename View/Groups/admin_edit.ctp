<div class="groups form">
    <?php echo $this->Form->create('Group'); ?>
    <fieldset>
        <legend>編輯群組</legend>
        <?php
        echo $this->Form->input('id');
        echo $this->Form->input('name', array('label' => '名稱'));
        echo $this->Form->input('is_area', array('label' => '限制區域'));
        ?>
    </fieldset>
    <?php echo $this->Form->end('送出'); ?>
</div>