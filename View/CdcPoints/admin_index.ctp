<?php

if (!isset($url)) {
    $url = array();
}
?>
<div id="CdcPointsAdminIndex">
    <h1>列管點</h1>
    <div class="btn-group">
        <?php echo $this->Html->link('新增', array('action' => 'add'), array('class' => 'btn btn-secondary')); ?>
        <?php echo $this->Html->link('匯入', array('action' => 'import'), array('class' => 'btn btn-secondary')); ?>
        <?php echo $this->Html->link('匯出', array('action' => 'export'), array('class' => 'btn btn-secondary')); ?>
    </div>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <table class="table table-bordered" id="CdcPointsAdminIndexTable">
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('CdcPoint.issue_date', '抽查日期', array('url' => $url)); ?></th>
                <th>區域</th>
                <th>住址</th>
                <th>異動者</th>
                <th><?php echo $this->Paginator->sort('CdcPoint.modified', '更新時間', array('url' => $url)); ?></th>
                <th class="actions">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach ($items as $item) {
                $class = null;
                if ($i++ % 2 == 0) {
                    $class = ' class="altrow"';
                }
                ?>
            <tr<?php echo $class; ?>>
                <td><?php
                echo $item['CdcPoint']['issue_date'];
                        ?></td>
                <td><?php
                if(isset($item['Area']['Parent']['name'])) {
                    echo $item['Area']['Parent']['name'];
                }
                        echo $item['Area']['name'];
                        ?></td>
                <td><?php
                echo $item['CdcPoint']['address'];
                        ?></td>
                <td><?php
                        echo $item['MemberModified']['username'];
                        ?></td>
                <td><?php
                        echo $item['CdcPoint']['modified'];
                        ?></td>
                <td>
                    <div class="btn-group" role="group">
                        <?php echo $this->Html->link('編輯', array('action' => 'edit', $item['CdcPoint']['id']), array('class' => 'btn btn-secondary')); ?>
                        <?php echo $this->Html->link('刪除', array('action' => 'delete', $item['CdcPoint']['id']), array('class' => 'btn btn-secondary'), '確定刪除？'); ?>
                    </div>
                </td>
            </tr>
            <?php } // End of foreach ($items as $item) {  ?>
        </tbody>
    </table>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
</div>