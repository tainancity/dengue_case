<?php

if (!isset($url)) {
    $url = array();
}
?>
<div id="AreaSourcesAdminIndex">
    <h1>區公所社區監測組孳生源清除</h1>
    <div class="btn-group">
        <?php echo $this->Html->link('新增', array('action' => 'area_sources'), array('class' => 'btn btn-secondary')); ?>
    </div>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <table class="table table-bordered" id="AreaSourcesAdminIndexTable">
        <thead>
            <tr>
                <th><?php echo $this->Paginator->sort('AreaSource.the_date', '日期', array('url' => $url)); ?></th>
                <th>區里</th>
                <th>調查戶數</th>
                <th>戶內陽性率</th>
                <th>戶外陽性率</th>
                <th>已處理陽性數</th>
                <th>志工人數</th>
                <th>異動者</th>
                <th><?php echo $this->Paginator->sort('AreaSource.modified', '更新時間', array('url' => $url)); ?></th>
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
                        echo $item['AreaSource']['the_date'];
                        ?></td>
                <td><?php
                        echo $item['Area']['name'];
                        ?></td>
                <td><?php
                        echo $item['AreaSource']['investigate'];
                        ?></td>
                <td><?php
                if($item['AreaSource']['i_water'] > 0) {
                        echo round($item['AreaSource']['i_positive'] / $item['AreaSource']['i_water'], 2);
                }
                        ?></td>
                <td><?php
                if($item['AreaSource']['o_water'] > 0) {
                        echo round($item['AreaSource']['o_positive'] / $item['AreaSource']['o_water'], 2);
                }
                        ?></td>
                <td><?php
                        echo $item['AreaSource']['positive_done'];
                        ?></td>
                <td><?php
                        echo $item['AreaSource']['people'];
                        ?></td>
                <td><?php
                        echo $item['MemberModified']['username'];
                        ?></td>
                <td><?php
                        echo $item['AreaSource']['modified'];
                        ?></td>
                <td>
                    <div class="btn-group" role="group">
                            <?php echo $this->Html->link('刪除', array('action' => 'area_sources_delete', $item['AreaSource']['id']), array('class' => 'btn btn-secondary'), '確定刪除？'); ?>
                    </div>
                </td>
            </tr>
            <?php } // End of foreach ($items as $item) {  ?>
        </tbody>
    </table>
    <div class="paging"><?php echo $this->element('paginator'); ?></div>
    <div id="AreaSourcesAdminIndexPanel"></div>
    <script type="text/javascript">
        //<![CDATA[
        $(function () {
        });
        //]]>
    </script>
</div>