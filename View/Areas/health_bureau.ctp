<div>
    <?php
    echo $this->Form->create('Area', array('type' => 'file', 'url' => array('action' => 'health_bureau')));
    ?>
    <div class="Areas form">
        <h1>衛生所疫情監測</h1>
        <?php
        echo $this->Form->input('Expand.the_date', array(
            'label' => '日期',
            'type' => 'text',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Expand.area_id', array(
            'label' => '地區',
            'type' => 'select',
            'options' => $areas,
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        ?>
        <h2>擴採人數及結果</h2>
        <?php
        echo $this->Form->input('Expand.count_p', array(
            'type' => 'number',
            'label' => 'NS1 (+)',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Expand.count_n', array(
            'type' => 'number',
            'label' => 'NS1 (-)',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Expand.note', array(
            'label' => '備註',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        ?>
        <h2>個案家戶發燒追蹤結果</h2>
        <?php
        echo $this->Form->input('Fever.count_people', array(
            'type' => 'number',
            'label' => '個案戶家人數',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Fever.count_fever', array(
            'type' => 'number',
            'label' => '個案戶家人發燒人數',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Fever.count_draw', array(
            'type' => 'number',
            'label' => '個案戶家人採血數',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Fever.count_p', array(
            'type' => 'number',
            'label' => 'NS1 (+)',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Fever.count_n', array(
            'type' => 'number',
            'label' => 'NS1 (-)',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Fever.note', array(
            'label' => '備註',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        ?>
        <h2>個案住家半徑 50 公尺民眾健康追蹤</h2>
        <?php
        echo $this->Form->input('Track.track_count', array(
            'type' => 'number',
            'label' => '社區應追蹤人數',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Track.track_done', array(
            'type' => 'number',
            'label' => '社區已追蹤人數',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Track.fever_count', array(
            'type' => 'number',
            'label' => '社區發燒人數',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Track.fever_draw', array(
            'type' => 'number',
            'label' => '社區發燒採血人數',
            'div' => 'form-group',
            'class' => 'form-control',
        ));
        echo $this->Form->input('Track.note', array(
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
echo $this->Html->script('c/areas/health_bureau.js');
