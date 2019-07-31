<?php

if (!isset($url)) {
    $url = array();
}
?>
<div id="BureauSourcesAdminIndex">
    <h1>各局處轄管防疫動員</h1>
    <div class="btn-group">
        <?php echo $this->Html->link('新增', array('action' => 'bureau_sources'), array('class' => 'btn btn-secondary')); ?>
    </div>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <table class="table table-bordered" id="BureauSourcesAdminIndexTable">
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('BureauSource.the_date', '日期', array('url' => $url)); ?></th>
                <th>單位</th>
                <th>檢查地點數</th>
                <th>異動者</th>
                <th><?php echo $this->Paginator->sort('BureauSource.modified', '更新時間', array('url' => $url)); ?></th>
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
                        echo $item['BureauSource']['the_date'];
                        ?></td>
                <td><?php
                        echo $item['BureauSource']['unit'];
                        ?></td>
                <td><?php
                        echo $item['BureauSource']['investigate'];
                        ?></td>
                <td><?php
                        echo $item['MemberModified']['username'];
                        ?></td>
                <td><?php
                        echo $item['BureauSource']['modified'];
                        ?></td>
                <td>
                    <div class="btn-group" role="group">
                            <?php echo $this->Html->link('刪除', array('action' => 'bureau_sources_delete', $item['BureauSource']['id']), array('class' => 'btn btn-secondary'), '確定刪除？'); ?>
                    </div>
                </td>
            </tr>
            <?php } // End of foreach ($items as $item) {  ?>
        </tbody>
    </table>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
</div>