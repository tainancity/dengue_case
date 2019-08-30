<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-TW">
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            登革熱防疫工作系統::
            <?php echo $title_for_layout; ?>
        </title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
            <?php
        echo $this->Html->meta('icon');
        echo $this->Html->css('jquery-ui');
        echo $this->Html->css('default');
        echo $this->Html->script('jquery');
        echo $this->Html->script('jquery-ui');
        echo $this->Html->script('olc');
        echo $scripts_for_layout;
        ?>
        <script>
            var baseUrl = '<?php echo $this->Html->url('/'); ?>';
        </script>
    </head>
    <body>
        <div class="container">
            <div id="header">
                <h1><?php echo $this->Html->link('登革熱防疫工作系統', '/'); ?></h1>
            </div>
            <div id="content">
                <div class="btn-group">
                    <?php
                    switch(Configure::read('loginMember.Group.name')) {
                        case '衛生所':
                            echo $this->Html->link('報表', '/areas/report', array('class' => 'btn btn-info'));
                            echo $this->Html->link('衛生所填報', '/areas/health_list', array('class' => 'btn btn-info'));
                            echo $this->Html->link('登出', '/members/logout', array('class' => 'btn btn-info'));
                            break;
                        case '區公所':
                            echo $this->Html->link('報表', '/areas/report', array('class' => 'btn btn-info'));
                            echo $this->Html->link('區公所填報', '/areas/bureau_list', array('class' => 'btn btn-info'));
                            echo $this->Html->link('稽督單', '/admin/cdc_points/bureau_index/', array('class' => 'btn btn-info'));
                            echo $this->Html->link('登出', '/members/logout', array('class' => 'btn btn-info'));
                            break;
                        case '局處':
                            echo $this->Html->link('報表', '/areas/report', array('class' => 'btn btn-info'));
                            echo $this->Html->link('各局處轄管防疫動員', '/areas/bureau_sources_list', array('class' => 'btn btn-info'));
                            echo $this->Html->link('登出', '/members/logout', array('class' => 'btn btn-info'));
                            break;
                        case 'Admin':
                            echo $this->Html->link('案例', '/admin/issues', array('class' => 'btn btn-info'));
                            echo $this->Html->link('報表', '/areas/report', array('class' => 'btn btn-info'));
                            echo $this->Html->link('衛生所填報', '/areas/health_list', array('class' => 'btn btn-info'));
                            echo $this->Html->link('區公所填報', '/areas/bureau_list', array('class' => 'btn btn-info'));
                            echo $this->Html->link('疫情現況', '/areas/daily_cases_list', array('class' => 'btn btn-info'));
                            echo $this->Html->link('各局處轄管防疫動員', '/areas/bureau_sources_list', array('class' => 'btn btn-info'));
                            echo $this->Html->link('化學防治', '/areas/chemicals_list', array('class' => 'btn btn-info'));
                            echo $this->Html->link('就醫健康監視人數', '/areas/fever_monitors_list', array('class' => 'btn btn-info'));
                            echo $this->Html->link('醫療院所通報數', '/areas/clinic_reports_list', array('class' => 'btn btn-info'));
                            echo $this->Html->link('稽督單', '/admin/cdc_points', array('class' => 'btn btn-info'));
                            echo $this->Html->link('帳號', '/admin/members', array('class' => 'btn btn-info'));
                            echo $this->Html->link('群組', '/admin/groups', array('class' => 'btn btn-info'));
                            echo $this->Html->link('登出', '/members/logout', array('class' => 'btn btn-info'));
                            break;
                        default:
                            echo $this->Html->link('登入', '/members/login', array('class' => 'btn btn-info'));
                    }
                    if (!empty($actions_for_layout)) {
                        foreach ($actions_for_layout as $title => $url) {
                            echo $this->Html->link($title, $url, array('class' => 'btn'));
                        }
                    }
                    ?>
                </div>

                <?php echo $this->Session->flash(); ?>
                <div id="viewContent"><?php echo $content_for_layout; ?></div>
            </div>
            <div id="footer">
                &nbsp;
            </div>
        </div>
        <?php
        echo $this->element('sql_dump');
        ?>
    </body>
</html>