<div id="PointsAdminAdd">
    <?php
    echo $this->Form->create('Point', array('type' => 'file', 'url' => array('action' => 'add', $issue['Issue']['id'])));
    ?>
    <div class="Points form">
        <h2>新增 <?php echo $this->Html->link($issue['Issue']['label'], '/admin/issues/view/' . $issue['Issue']['id']); ?> 的活動點</h2>
        <?php
        echo $this->Form->input('Point.point_type', array(
            'legend' => '類型',
            'type' => 'radio',
            'options' => $this->Olc->pointTypeOptions,
            'div' => 'form-group',
            'class' => 'form-check form-check-inline',
        ));
        echo $this->Form->input('Point.label', array(
            'label' => '地點名稱',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Point.address', array(
            'label' => '住址',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Point.cunli', array(
            'label' => '區里',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Point.longitude', array(
            'type' => 'text',
            'label' => '經度',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Point.latitude', array(
            'type' => 'text',
            'label' => '緯度',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        ?>
    </div>
    <?php
    echo $this->Form->end('儲存');
    ?>
</div>