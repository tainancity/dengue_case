<div class="groups form">
    <?php echo $this->Form->create('Group', array('url' => array($parentId))); ?>
    <fieldset>
        <legend>新增群組</legend>
        <?php
        echo $this->Form->input('name', array('label' => '名稱'));
        echo $this->Form->input('is_area', array('label' => '限制區域'));
        ?>
    </fieldset>
    <?php echo $this->Form->end('送出'); ?>
</div>