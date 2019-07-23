<div id="IssuesAdminView">
    <h3>檢視案例</h3>
    <table class="table">
        <tbody>
            <tr>
                <th scope="row">通報編號</th>
                <td><?php echo $this->data['Issue']['code']; ?></td>
            </tr>
            <tr>
                <th scope="row">案例名稱</th>
                <td><?php echo $this->data['Issue']['label']; ?></td>
            </tr>
            <tr>
                <th scope="row">通報日期</th>
                <td><?php echo $this->data['Issue']['reported']; ?></td>
            </tr>
            <tr>
                <th scope="row">確診日期</th>
                <td><?php echo $this->data['Issue']['confirmed']; ?></td>
            </tr>
            <tr>
                <th scope="row">發病日期</th>
                <td><?php echo $this->data['Issue']['date_onset']; ?></td>
            </tr>
            <tr>
                <th scope="row">姓名</th>
                <td><?php echo $this->data['Issue']['name']; ?></td>
            </tr>
            <tr>
                <th scope="row">居住地</th>
                <td><?php echo $this->data['Issue']['address']; ?></td>
            </tr>
            <tr>
                <th scope="row">區里</th>
                <td><?php echo $this->data['Issue']['cunli']; ?></td>
            </tr>
            <tr>
                <th scope="row">經度</th>
                <td><?php echo $this->data['Issue']['longitude']; ?></td>
            </tr>
            <tr>
                <th scope="row">緯度</th>
                <td><?php echo $this->data['Issue']['latitude']; ?></td>
            </tr>
            <tr>
                <th scope="row">IgM</th>
                <td><?php echo $this->data['Issue']['igm']; ?></td>
            </tr>
            <tr>
                <th scope="row">IgG</th>
                <td><?php echo $this->data['Issue']['igg']; ?></td>
            </tr>
            <tr>
                <th scope="row">建立者</th>
                <td><?php echo $this->data['MemberCreated']['username']; ?></td>
            </tr>
            <tr>
                <th scope="row">異動者</th>
                <td><?php echo $this->data['MemberModified']['username']; ?></td>
            </tr>
            <tr>
                <th scope="row">建立時間</th>
                <td><?php echo $this->data['Issue']['created']; ?></td>
            </tr>
            <tr>
                <th scope="row">更新時間</th>
                <td><?php echo $this->data['Issue']['modified']; ?></td>
            </tr>
        </tbody>
    </table>
    <div id="IssuesAdminViewPanel"></div>
</div>
<div id="PointsAdminIndex">
    <h2>活動點</h2>
    <div class="btn-group">
        <?php echo $this->Html->link('新增', array('controller' => 'points', 'action' => 'add', $this->data['Issue']['id']), array('class' => 'btn btn-secondary')); ?>
    </div>
    <table class="table table-bordered" id="PointsAdminIndexTable">
        <thead>
            <tr>
                <th>類型</th>
                <th>地點名稱</th>
                <th>住址</th>
                <th>區里</th>
                <th class="actions">操作</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            foreach ($this->data['Point'] as $item) {
                $class = null;
                if ($i++ % 2 == 0) {
                    $class = ' class="altrow"';
                }
                ?>
                <tr<?php echo $class; ?>>
                    <td><?php echo $this->Olc->pointTypeOptions[$item['point_type']]; ?></td>
                    <td><?php echo $item['label']; ?></td>
                    <td><?php echo $item['address']; ?></td>
                    <td><?php echo $item['cunli']; ?></td>
                    <td>
                        <div class="btn-group" role="group">
                            <?php echo $this->Html->link('編輯', array('controller' => 'points', 'action' => 'edit', $item['id']), array('class' => 'btn btn-secondary')); ?>
                            <?php echo $this->Html->link('刪除', array('controller' => 'points', 'action' => 'delete', $item['id']), array('class' => 'btn btn-secondary'), '確定刪除？'); ?>
                        </div>
                    </td>
                </tr>
            <?php } // End of foreach ($items as $item) {  ?>
        </tbody>
    </table>
    <div id="PointsAdminIndexPanel"></div>
</div>