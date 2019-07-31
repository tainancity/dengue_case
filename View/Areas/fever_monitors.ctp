<div>
    <?php
    echo $this->Form->create('Area', array('type' => 'file', 'url' => array('action' => 'fever_monitors')));
    ?>
    <div class="Areas form">
        <h1>診所發燒病人就醫健康監視人數</h1>
        <?php
        echo $this->Form->input('FeverMonitor.the_date', array(
            'label' => '日期',
            'type' => 'text',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('FeverMonitor.area_id', array(
            'label' => '地區',
            'type' => 'select',
            'options' => $areas,
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('FeverMonitor.people_count', array(
            'label' => '應追蹤人數',
            'type' => 'number',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('FeverMonitor.people_track', array(
            'label' => '已追蹤人數',
            'type' => 'number',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('FeverMonitor.note', array(
            'label' => '備註',
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
echo $this->Html->script('c/areas/fever_monitors.js');
