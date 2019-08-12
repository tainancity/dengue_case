<div>
    <?php
    echo $this->Form->create('Area', array('type' => 'file', 'url' => array('action' => 'daily_cases')));
    ?>
    <div class="Areas form">
        <h1>疫情現況</h1>
        <?php
        echo $this->Form->input('DailyCase.the_date', array(
            'label' => '日期',
            'type' => 'text',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('DailyCase.count_local', array(
            'type' => 'number',
            'label' => '本土案例數量',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('DailyCase.count_imported', array(
            'type' => 'number',
            'label' => '境外移入數量',
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
echo $this->Html->script('c/areas/daily_cases.js');