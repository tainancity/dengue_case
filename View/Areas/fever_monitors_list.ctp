<?php

if (!isset($url)) {
    $url = array();
}
?>
<div id="FeverMonitorsAdminIndex">
    <h1>診所發燒病人就醫健康監視人數</h1>
    <div class="btn-group">
        <?php echo $this->Html->link('新增', array('action' => 'fever_monitors'), array('class' => 'btn btn-secondary')); ?>
    </div>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <table class="table table-bordered" id="FeverMonitorsAdminIndexTable">
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('FeverMonitor.the_date', '日期', array('url' => $url)); ?></th>
                <th>區域</th>
                <th>應追蹤人數</th>
                <th>已追蹤人數</th>
                <th>異動者</th>
                <th><?php echo $this->Paginator->sort('FeverMonitor.modified', '更新時間', array('url' => $url)); ?></th>
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
                        echo $item['FeverMonitor']['the_date'];
                        ?></td>
                <td><?php
                        echo $item['Area']['name'];
                        ?></td>
                <td><?php
                        echo $item['FeverMonitor']['people_count'];
                        ?></td>
                <td><?php
                        echo $item['FeverMonitor']['people_track'];
                        ?></td>
                <td><?php
                        echo $item['MemberModified']['username'];
                        ?></td>
                <td><?php
                        echo $item['FeverMonitor']['modified'];
                        ?></td>
                <td>
                    <div class="btn-group" role="group">
                            <?php echo $this->Html->link('刪除', array('action' => 'fever_monitors_delete', $item['FeverMonitor']['id']), array('class' => 'btn btn-secondary'), '確定刪除？'); ?>
                    </div>
                </td>
            </tr>
            <?php } // End of foreach ($items as $item) {  ?>
        </tbody>
    </table>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
</div>