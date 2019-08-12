<?php

if (!isset($url)) {
    $url = array();
}
?>
<div id="DailyCasesAdminIndex">
    <h1>疫情現況</h1>
    <div class="btn-group">
        <?php echo $this->Html->link('新增', array('action' => 'daily_cases'), array('class' => 'btn btn-secondary')); ?>
    </div>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <table class="table table-bordered" id="DailyCasesAdminIndexTable">
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('DailyCase.the_date', '日期', array('url' => $url)); ?></th>
                <th>本土案例</th>
                <th>境外移入</th>
                <th>異動者</th>
                <th><?php echo $this->Paginator->sort('DailyCase.modified', '更新時間', array('url' => $url)); ?></th>
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
                        echo $item['DailyCase']['the_date'];
                        ?></td>
                <td><?php
                        echo $item['DailyCase']['count_local'];
                        ?></td>
                <td><?php
                        echo $item['DailyCase']['count_imported'];
                        ?></td>
                <td><?php
                        echo $item['MemberModified']['username'];
                        ?></td>
                <td><?php
                        echo $item['DailyCase']['modified'];
                        ?></td>
                <td>
                    <div class="btn-group" role="group">
                            <?php echo $this->Html->link('刪除', array('action' => 'daily_cases_delete', $item['DailyCase']['id']), array('class' => 'btn btn-secondary'), '確定刪除？'); ?>
                    </div>
                </td>
            </tr>
            <?php } // End of foreach ($items as $item) {  ?>
        </tbody>
    </table>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
</div>