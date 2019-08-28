<div class="members form">
    <?php echo $this->Form->create('Member'); ?>
    <fieldset>
        <legend><?php echo __('Edit Member', true); ?></legend>
        <?php
        echo $this->Form->input('id');
        echo $this->Form->input('Member.username', array(
            'type' => 'text',
            'label' => '帳號',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Member.group_id', array(
            'type' => 'select',
            'label' => '群組',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Member.password', array(
            'type' => 'password',
            'label' => '密碼',
            'value' => '',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Member.user_status', array(
            'type' => 'radio',
            'label' => '狀態',
            'options' => array('Y' => 'Y', 'N' => 'N'),
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Member.area_id', array(
            'label' => '地區',
            'type' => 'select',
            'options' => $areas,
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Member.unit', array(
            'label' => '單位',
            'type' => 'select',
            'options' => array('' => '--', '衛生所' => '衛生所', '區公所' => '區公所'),
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        ?>
    </fieldset>
    <?php echo $this->Form->end('送出'); ?>
</div>
