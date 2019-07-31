<div>
    <?php
    echo $this->Form->create('Area', array('type' => 'file', 'url' => array('action' => 'educations')));
    ?>
    <div class="Areas form">
        <h1>衛教宣導</h1>
        <?php
        echo $this->Form->input('Education.the_date', array(
            'label' => '日期',
            'type' => 'text',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Education.area_id', array(
            'label' => '地區',
            'type' => 'select',
            'options' => $areas,
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Education.unit', array(
            'label' => '單位',
            'type' => 'select',
            'options' => array('衛生所' => '衛生所', '區公所' => '區公所'),
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Education.education', array(
            'label' => '宣導人次',
            'type' => 'number',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        ?>
    </div>
    <input type="submit" class="btn btn-block btn-primary" value="送出" />
    <?php
    echo $this->Form->end();
    ?>
</div>
<?php
echo $this->Html->script('c/areas/educations.js');
