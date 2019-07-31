<?php

if (!isset($url)) {
    $url = array();
}
?>
<div id="ChemicalsAdminIndex">
    <h1>化學防治</h1>
    <div class="btn-group">
        <?php echo $this->Html->link('新增', array('action' => 'chemicals'), array('class' => 'btn btn-secondary')); ?>
    </div>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <table class="table table-bordered" id="ChemicalsAdminIndexTable">
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('Chemical.the_date', '日期', array('url' => $url)); ?></th>
                <th>區里</th>
                <th>戶外場次</th>
                <th>完噴率</th>
                <th>拒噴戶開單數</th>
                <th>人力支援數</th>
                <th>異動者</th>
                <th><?php echo $this->Paginator->sort('Chemical.modified', '更新時間', array('url' => $url)); ?></th>
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
                        echo $item['Chemical']['the_date'];
                        ?></td>
                <td><?php
                        echo $item['Area']['name'];
                        ?></td>
                <td><?php
                        echo $item['Chemical']['trips'];
                        ?></td>
                <td><?php
                if($item['Chemical']['door_count'] > 0) {
                    echo round($item['Chemical']['door_done'] / $item['Chemical']['door_count'], 2);
                }
                        ?></td>
                <td><?php
                        echo $item['Chemical']['fine'];
                        ?></td>
                <td><?php
                        echo $item['Chemical']['people'];
                        ?></td>
                <td><?php
                        echo $item['MemberModified']['username'];
                        ?></td>
                <td><?php
                        echo $item['Chemical']['modified'];
                        ?></td>
                <td>
                    <div class="btn-group" role="group">
                            <?php echo $this->Html->link('刪除', array('action' => 'chemicals_delete', $item['Chemical']['id']), array('class' => 'btn btn-secondary'), '確定刪除？'); ?>
                    </div>
                </td>
            </tr>
            <?php } // End of foreach ($items as $item) {  ?>
        </tbody>
    </table>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
</div>