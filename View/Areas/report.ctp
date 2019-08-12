<?php
if(!isset($dailyCase['DailyCase'])) {
    $dailyCase['DailyCase'] = array(
        'count_local' => 0,
        'count_imported' => 0,
    );
}
echo $this->Form->input('the_date', array(
            'label' => '日期',
            'type' => 'text',
    'value' => $theDate,
            'div' => 'form-group',
            'class' => 'form-control',
        ));
?>
<p><?php echo $theDate; ?> 防治成果如下：</p>
<p>一、疫情監測</p>
<p>（一）疫情現況：本土 <?php echo $dailyCase['DailyCase']['count_local']; ?> 例，境外 <?php echo $dailyCase['DailyCase']['count_imported']; ?> 例</p>
<p>（二）擴採人數及結果（衛生所）</p>
<?php
$sum = array(
    'count_p' => 0,
    'count_n' => 0,
);
foreach($expands AS $expand) {
    $sum['count_p'] += $expand['Expand']['count_p'];
    $sum['count_n'] += $expand['Expand']['count_n'];
}
?>
<table class="table table-bordered">
    <thead>
    <th>區別</th>
    <th>當日採血數</th>
    <th>NS1 (+)</th>
    <th>NS1 (-)</th>
    <th>備註</th>
</thead>
<tbody>
    <?php if(count($expands) > 1) { ?>
    <tr class="table-info">
        <td>累計</td>
        <td><?php echo ($sum['count_p'] + $sum['count_n']); ?></td>
        <td><?php echo $sum['count_p']; ?></td>
        <td><?php echo $sum['count_n']; ?></td>
        <td> </td>
    </tr>
    <?php } ?>
    <?php foreach($expands AS $expand) { ?>
    <tr>
        <td><?php echo $expand['Area']['name']; ?></td>
        <td><?php echo ($expand['Expand']['count_p'] + $expand['Expand']['count_n']); ?></td>
        <td><?php echo $expand['Expand']['count_p']; ?></td>
        <td><?php echo $expand['Expand']['count_n']; ?></td>
        <td><?php echo $expand['Expand']['note']; ?></td>
    </tr>
    <?php } ?>
</tbody>
</table>
<p>（三）個案家戶發燒追蹤成果（衛生所）</p>
<?php
$sum = array(
    'count_people' => 0,
    'count_fever' => 0,
    'count_draw' => 0,
    'count_p' => 0,
    'count_n' => 0,
);
foreach($fevers AS $fever) {
    $sum['count_people'] += $fever['Fever']['count_people'];
    $sum['count_fever'] += $fever['Fever']['count_fever'];
    $sum['count_draw'] += $fever['Fever']['count_draw'];
    $sum['count_p'] += $fever['Fever']['count_p'];
    $sum['count_n'] += $fever['Fever']['count_n'];
}
?>
<table class="table table-bordered">
    <thead>
    <th>區別</th>
    <th>個案戶家人數</th>
    <th>個案戶家人發燒人數</th>
    <th>個案戶家人採血數</th>
    <th>NS1 (+)</th>
    <th>NS1 (-)</th>
    <th>備註</th>
</thead>
<tbody>
    <?php if(count($fevers) > 1) { ?>
    <tr class="table-info">
        <td>累計</td>
        <td><?php echo $sum['count_people']; ?></td>
        <td><?php echo $sum['count_fever']; ?></td>
        <td><?php echo $sum['count_draw']; ?></td>
        <td><?php echo $sum['count_p']; ?></td>
        <td><?php echo $sum['count_n']; ?></td>
        <td> </td>
    </tr>
    <?php } ?>
    <?php foreach($fevers AS $fever) { ?>
    <tr>
        <td><?php echo $fever['Area']['name']; ?></td>
        <td><?php echo $fever['Fever']['count_people']; ?></td>
        <td><?php echo $fever['Fever']['count_fever']; ?></td>
        <td><?php echo $fever['Fever']['count_draw']; ?></td>
        <td><?php echo $fever['Fever']['count_p']; ?></td>
        <td><?php echo $fever['Fever']['count_n']; ?></td>
        <td><?php echo $fever['Fever']['note']; ?></td>
    </tr>
    <?php } ?>
</tbody>
</table>
<p>（四）登革熱個案住家半徑 50 公尺民眾健康追蹤（衛生所）</p>
<?php
$sum = array(
    'track_count' => 0,
    'track_done' => 0,
    'fever_count' => 0,
    'fever_draw' => 0,
);
foreach($tracks AS $track) {
    $sum['track_count'] += $track['Track']['track_count'];
    $sum['track_done'] += $track['Track']['track_done'];
    $sum['fever_count'] += $track['Track']['fever_count'];
    $sum['fever_draw'] += $track['Track']['fever_draw'];
}
?>
<table class="table table-bordered">
    <thead>
    <th>區別</th>
    <th>社區應追蹤人數</th>
    <th>社區已追蹤人數</th>
    <th>完成率</th>
    <th>社區發燒人數</th>
    <th>社區發燒採血人數</th>
    <th>發燒率</th>
    <th>備註</th>
</thead>
<tbody>
    <?php if(count($tracks) > 1) { ?>
    <tr class="table-info">
        <td>累計</td>
        <td><?php echo $sum['track_count']; ?></td>
        <td><?php echo $sum['track_done']; ?></td>
        <td><?php
        if($sum['track_count'] > 0) {
            echo (round($sum['track_done'] / $sum['track_count'], 3) * 100) . '%';
        }
        ?></td>
        <td><?php echo $sum['fever_count']; ?></td>
        <td><?php echo $sum['fever_draw']; ?></td>
        <td><?php
        if($sum['track_count'] > 0) {
            echo (round($sum['fever_count'] / $sum['track_count'], 3) * 100) . '%';
        }
        ?></td>
        <td> </td>
    </tr>
    <?php } ?>
    <?php foreach($tracks AS $track) { ?>
    <tr>
        <td><?php echo $track['Area']['name']; ?></td>
        <td><?php echo $track['Track']['track_count']; ?></td>
        <td><?php echo $track['Track']['track_done']; ?></td>
        <td><?php
        if($track['Track']['track_count'] > 0) {
            echo (round($track['Track']['track_done'] / $track['Track']['track_count'], 3) * 100) . '%';
        }
        ?></td>
        <td><?php echo $track['Track']['fever_count']; ?></td>
        <td><?php echo $track['Track']['fever_draw']; ?></td>
        <td><?php
        if($track['Track']['track_count'] > 0) {
            echo (round($track['Track']['fever_count'] / $track['Track']['track_count'], 3) * 100) . '%';
        }
        ?></td>
        <td><?php echo $track['Track']['note']; ?></td>
    </tr>
    <?php } ?>
</tbody>
</table>
<p>二、衛生所中心監測孳生源清除</p>
<?php
$keys = array('investigate', 'i_water', 'i_positive', 'o_water', 'o_positive', 'positive_done', 'fine', 'people');
$sum = array();
foreach($keys AS $key) {
    $sum[$key] = 0;
}
$areaSum = array();
foreach($centerSources AS $centerSource) {
    if(!isset($areaSum[$centerSource['Area']['Parent']['name']])) {
        $areaSum[$centerSource['Area']['Parent']['name']] = array();
        foreach($keys AS $key) {
            $areaSum[$centerSource['Area']['Parent']['name']][$key] = 0;
        }
        $areaSum[$centerSource['Area']['Parent']['name']]['count'] = 0;
    }
    foreach($keys AS $key) {
        $sum[$key] += $centerSource['CenterSource'][$key];
        $areaSum[$centerSource['Area']['Parent']['name']][$key] += $centerSource['CenterSource'][$key];
    }
    $areaSum[$centerSource['Area']['Parent']['name']]['count'] += 1;
}
?>
<table class="table table-bordered">
    <thead>
    <th>區別</th>
    <th>里別</th>
    <th>調查戶數</th>
    <th>戶內積水容器</th>
    <th>戶內陽性容器</th>
    <th>戶內陽性率</th>
    <th>戶外積水容器</th>
    <th>戶外陽性容器</th>
    <th>戶外陽性率</th>
    <th>已處理陽性數</th>
    <th>舉發單數</th>
    <th>動員人數</th>
    <th>備註</th>
</thead>
<tbody>
    <?php if(count($centerSources) > 1) { ?>
    <tr class="table-info">
        <td>累計</td>
        <td></td>
        <td><?php echo $sum['investigate']; ?></td>
        <td><?php echo $sum['i_water']; ?></td>
        <td><?php echo $sum['i_positive']; ?></td>
        <td><?php
        if($sum['i_water'] > 0) {
            echo (round($sum['i_positive'] / $sum['i_water'], 3) * 100) . '%';
        }
        ?></td>
        <td><?php echo $sum['o_water']; ?></td>
        <td><?php echo $sum['o_positive']; ?></td>
        <td><?php
        if($sum['o_water'] > 0) {
            echo (round($sum['o_positive'] / $sum['o_water'], 3) * 100) . '%';
        }
        ?></td>
        <td><?php echo $sum['positive_done']; ?></td>
        <td><?php echo $sum['fine']; ?></td>
        <td><?php echo $sum['people']; ?></td>
        <td> </td>
    </tr>
    <?php } ?>
    <?php foreach($centerSources AS $centerSource) {
        if(isset($areaSum[$centerSource['Area']['Parent']['name']]) && $areaSum[$centerSource['Area']['Parent']['name']]['count'] > 1) {
            ?>
    <tr class="table-warning">
        <td><?php echo $centerSource['Area']['Parent']['name']; ?>累計</td>
        <td></td>
        <td><?php echo $areaSum[$centerSource['Area']['Parent']['name']]['investigate']; ?></td>
        <td><?php echo $areaSum[$centerSource['Area']['Parent']['name']]['i_water']; ?></td>
        <td><?php echo $areaSum[$centerSource['Area']['Parent']['name']]['i_positive']; ?></td>
        <td><?php
        if($areaSum[$centerSource['Area']['Parent']['name']]['i_water'] > 0) {
            echo (round($areaSum[$centerSource['Area']['Parent']['name']]['i_positive'] / $areaSum[$centerSource['Area']['Parent']['name']]['i_water'], 3) * 100) . '%';
        }
        ?></td>
        <td><?php echo $areaSum[$centerSource['Area']['Parent']['name']]['o_water']; ?></td>
        <td><?php echo $areaSum[$centerSource['Area']['Parent']['name']]['o_positive']; ?></td>
        <td><?php
        if($areaSum[$centerSource['Area']['Parent']['name']]['o_water'] > 0) {
            echo (round($areaSum[$centerSource['Area']['Parent']['name']]['o_positive'] / $areaSum[$centerSource['Area']['Parent']['name']]['o_water'], 3) * 100) . '%';
        }
        ?></td>
        <td><?php echo $areaSum[$centerSource['Area']['Parent']['name']]['positive_done']; ?></td>
        <td><?php echo $areaSum[$centerSource['Area']['Parent']['name']]['fine']; ?></td>
        <td><?php echo $areaSum[$centerSource['Area']['Parent']['name']]['people']; ?></td>
        <td></td>
    </tr>
    <?php
    unset($areaSum[$centerSource['Area']['Parent']['name']]);
        }
        ?>
    <tr>
        <td><?php echo $centerSource['Area']['Parent']['name']; ?></td>
        <td><?php echo $centerSource['Area']['name']; ?></td>
        <td><?php echo $centerSource['CenterSource']['investigate']; ?></td>
        <td><?php echo $centerSource['CenterSource']['i_water']; ?></td>
        <td><?php echo $centerSource['CenterSource']['i_positive']; ?></td>
        <td><?php
        if($centerSource['CenterSource']['i_water'] > 0) {
            echo (round($centerSource['CenterSource']['i_positive'] / $centerSource['CenterSource']['i_water'], 3) * 100) . '%';
        }
        ?></td>
        <td><?php echo $centerSource['CenterSource']['o_water']; ?></td>
        <td><?php echo $centerSource['CenterSource']['o_positive']; ?></td>
        <td><?php
        if($centerSource['CenterSource']['o_water'] > 0) {
            echo (round($centerSource['CenterSource']['o_positive'] / $centerSource['CenterSource']['o_water'], 3) * 100) . '%';
        }
        ?></td>
        <td><?php echo $centerSource['CenterSource']['positive_done']; ?></td>
        <td><?php echo $centerSource['CenterSource']['fine']; ?></td>
        <td><?php echo $centerSource['CenterSource']['people']; ?></td>
        <td><?php echo $centerSource['CenterSource']['note']; ?></td>
    </tr>
    <?php } ?>
</tbody>
</table>
<p>三、區公所社區監測組孳生源清除（含里幹事）</p>
<?php
$keys = array('investigate', 'i_water', 'i_positive', 'o_water', 'o_positive', 'positive_done', 'people');
$sum = array();
foreach($keys AS $key) {
    $sum[$key] = 0;
}
$areaSum = array();
foreach($areaSources AS $areaSource) {
    if(!isset($areaSum[$areaSource['Area']['Parent']['name']])) {
        $areaSum[$areaSource['Area']['Parent']['name']] = array();
        foreach($keys AS $key) {
            $areaSum[$areaSource['Area']['Parent']['name']][$key] = 0;
        }
        $areaSum[$areaSource['Area']['Parent']['name']]['count'] = 0;
    }
    foreach($keys AS $key) {
        $sum[$key] += $areaSource['AreaSource'][$key];
        $areaSum[$areaSource['Area']['Parent']['name']][$key] += $areaSource['AreaSource'][$key];
    }
    $areaSum[$areaSource['Area']['Parent']['name']]['count'] += 1;
}
?>
<table class="table table-bordered">
    <thead>
    <th>區別</th>
    <th>里別</th>
    <th>調查戶數</th>
    <th>戶內積水容器</th>
    <th>戶內陽性容器</th>
    <th>戶內陽性率</th>
    <th>戶外積水容器</th>
    <th>戶外陽性容器</th>
    <th>戶外陽性率</th>
    <th>已處理陽性數</th>
    <th>動員人數</th>
    <th>備註</th>
</thead>
<tbody>
    <?php if(count($areaSources) > 1) { ?>
    <tr class="table-info">
        <td>累計</td>
        <td></td>
        <td><?php echo $sum['investigate']; ?></td>
        <td><?php echo $sum['i_water']; ?></td>
        <td><?php echo $sum['i_positive']; ?></td>
        <td><?php
        if($sum['i_water'] > 0) {
            echo (round($sum['i_positive'] / $sum['i_water'], 3) * 100) . '%';
        }
        ?></td>
        <td><?php echo $sum['o_water']; ?></td>
        <td><?php echo $sum['o_positive']; ?></td>
        <td><?php
        if($sum['o_water'] > 0) {
            echo (round($sum['o_positive'] / $sum['o_water'], 3) * 100) . '%';
        }
        ?></td>
        <td><?php echo $sum['positive_done']; ?></td>
        <td><?php echo $sum['people']; ?></td>
        <td> </td>
    </tr>
    <?php } ?>
    <?php foreach($areaSources AS $areaSource) {
        if(isset($areaSum[$areaSource['Area']['Parent']['name']]) && $areaSum[$areaSource['Area']['Parent']['name']]['count'] > 1) {
            ?>
    <tr class="table-warning">
        <td><?php echo $areaSource['Area']['Parent']['name']; ?>累計</td>
        <td></td>
        <td><?php echo $areaSum[$areaSource['Area']['Parent']['name']]['investigate']; ?></td>
        <td><?php echo $areaSum[$areaSource['Area']['Parent']['name']]['i_water']; ?></td>
        <td><?php echo $areaSum[$areaSource['Area']['Parent']['name']]['i_positive']; ?></td>
        <td><?php
        if($areaSum[$areaSource['Area']['Parent']['name']]['i_water'] > 0) {
            echo (round($areaSum[$areaSource['Area']['Parent']['name']]['i_positive'] / $areaSum[$areaSource['Area']['Parent']['name']]['i_water'], 3) * 100) . '%';
        }
        ?></td>
        <td><?php echo $areaSum[$areaSource['Area']['Parent']['name']]['o_water']; ?></td>
        <td><?php echo $areaSum[$areaSource['Area']['Parent']['name']]['o_positive']; ?></td>
        <td><?php
        if($areaSum[$areaSource['Area']['Parent']['name']]['o_water'] > 0) {
            echo (round($areaSum[$areaSource['Area']['Parent']['name']]['o_positive'] / $areaSum[$areaSource['Area']['Parent']['name']]['o_water'], 3) * 100) . '%';
        }
        ?></td>
        <td><?php echo $areaSum[$areaSource['Area']['Parent']['name']]['positive_done']; ?></td>
        <td><?php echo $areaSum[$areaSource['Area']['Parent']['name']]['people']; ?></td>
        <td></td>
    </tr>
    <?php
    unset($areaSum[$areaSource['Area']['Parent']['name']]);
        }
        ?>
    <tr>
        <td><?php echo $areaSource['Area']['Parent']['name']; ?></td>
        <td><?php echo $areaSource['Area']['name']; ?></td>
        <td><?php echo $areaSource['AreaSource']['investigate']; ?></td>
        <td><?php echo $areaSource['AreaSource']['i_water']; ?></td>
        <td><?php echo $areaSource['AreaSource']['i_positive']; ?></td>
        <td><?php
        if($areaSource['AreaSource']['i_water'] > 0) {
            echo (round($areaSource['AreaSource']['i_positive'] / $areaSource['AreaSource']['i_water'], 3) * 100) . '%';
        }
        ?></td>
        <td><?php echo $areaSource['AreaSource']['o_water']; ?></td>
        <td><?php echo $areaSource['AreaSource']['o_positive']; ?></td>
        <td><?php
        if($areaSource['AreaSource']['o_water'] > 0) {
            echo (round($areaSource['AreaSource']['o_positive'] / $areaSource['AreaSource']['o_water'], 3) * 100) . '%';
        }
        ?></td>
        <td><?php echo $areaSource['AreaSource']['positive_done']; ?></td>
        <td><?php echo $areaSource['AreaSource']['people']; ?></td>
        <td><?php echo $areaSource['AreaSource']['note']; ?></td>
    </tr>
    <?php } ?>
</tbody>
</table>

<p>四、防疫志工隊孳生源清除（區公所）</p>
<?php
$keys = array('investigate', 'i_water', 'i_positive', 'o_water', 'o_positive', 'positive_done', 'people');
$sum = array();
foreach($keys AS $key) {
    $sum[$key] = 0;
}
$areaSum = array();
foreach($volunteerSources AS $volunteerSource) {
    if(!isset($areaSum[$volunteerSource['Area']['Parent']['name']])) {
        $areaSum[$volunteerSource['Area']['Parent']['name']] = array();
        foreach($keys AS $key) {
            $areaSum[$volunteerSource['Area']['Parent']['name']][$key] = 0;
        }
        $areaSum[$volunteerSource['Area']['Parent']['name']]['count'] = 0;
    }
    foreach($keys AS $key) {
        $sum[$key] += $volunteerSource['VolunteerSource'][$key];
        $areaSum[$volunteerSource['Area']['Parent']['name']][$key] += $volunteerSource['VolunteerSource'][$key];
    }
    $areaSum[$volunteerSource['Area']['Parent']['name']]['count'] += 1;
}
?>
<table class="table table-bordered">
    <thead>
    <th>區別</th>
    <th>里別</th>
    <th>調查戶數</th>
    <th>戶內積水容器</th>
    <th>戶內陽性容器</th>
    <th>戶內陽性率</th>
    <th>戶外積水容器</th>
    <th>戶外陽性容器</th>
    <th>戶外陽性率</th>
    <th>已處理陽性數</th>
    <th>志工人數</th>
    <th>備註</th>
</thead>
<tbody>
    <?php if(count($volunteerSources) > 1) { ?>
    <tr class="table-info">
        <td>累計</td>
        <td></td>
        <td><?php echo $sum['investigate']; ?></td>
        <td><?php echo $sum['i_water']; ?></td>
        <td><?php echo $sum['i_positive']; ?></td>
        <td><?php
        if($sum['i_water'] > 0) {
            echo (round($sum['i_positive'] / $sum['i_water'], 3) * 100) . '%';
        }
        ?></td>
        <td><?php echo $sum['o_water']; ?></td>
        <td><?php echo $sum['o_positive']; ?></td>
        <td><?php
        if($sum['o_water'] > 0) {
            echo (round($sum['o_positive'] / $sum['o_water'], 3) * 100) . '%';
        }
        ?></td>
        <td><?php echo $sum['positive_done']; ?></td>
        <td><?php echo $sum['people']; ?></td>
        <td> </td>
    </tr>
    <?php } ?>
    <?php foreach($volunteerSources AS $volunteerSource) {
        if(isset($areaSum[$volunteerSource['Area']['Parent']['name']]) && $areaSum[$volunteerSource['Area']['Parent']['name']]['count'] > 1) {
            ?>
    <tr class="table-warning">
        <td><?php echo $volunteerSource['Area']['Parent']['name']; ?>累計</td>
        <td></td>
        <td><?php echo $areaSum[$volunteerSource['Area']['Parent']['name']]['investigate']; ?></td>
        <td><?php echo $areaSum[$volunteerSource['Area']['Parent']['name']]['i_water']; ?></td>
        <td><?php echo $areaSum[$volunteerSource['Area']['Parent']['name']]['i_positive']; ?></td>
        <td><?php
        if($areaSum[$volunteerSource['Area']['Parent']['name']]['i_water'] > 0) {
            echo (round($areaSum[$volunteerSource['Area']['Parent']['name']]['i_positive'] / $areaSum[$volunteerSource['Area']['Parent']['name']]['i_water'], 3) * 100) . '%';
        }
        ?></td>
        <td><?php echo $areaSum[$volunteerSource['Area']['Parent']['name']]['o_water']; ?></td>
        <td><?php echo $areaSum[$volunteerSource['Area']['Parent']['name']]['o_positive']; ?></td>
        <td><?php
        if($areaSum[$volunteerSource['Area']['Parent']['name']]['o_water'] > 0) {
            echo (round($areaSum[$volunteerSource['Area']['Parent']['name']]['o_positive'] / $areaSum[$volunteerSource['Area']['Parent']['name']]['o_water'], 3) * 100) . '%';
        }
        ?></td>
        <td><?php echo $areaSum[$volunteerSource['Area']['Parent']['name']]['positive_done']; ?></td>
        <td><?php echo $areaSum[$volunteerSource['Area']['Parent']['name']]['people']; ?></td>
        <td></td>
    </tr>
    <?php
    unset($areaSum[$volunteerSource['Area']['Parent']['name']]);
        }
        ?>
    <tr>
        <td><?php echo $volunteerSource['Area']['Parent']['name']; ?></td>
        <td><?php echo $volunteerSource['Area']['name']; ?></td>
        <td><?php echo $volunteerSource['VolunteerSource']['investigate']; ?></td>
        <td><?php echo $volunteerSource['VolunteerSource']['i_water']; ?></td>
        <td><?php echo $volunteerSource['VolunteerSource']['i_positive']; ?></td>
        <td><?php
        if($volunteerSource['VolunteerSource']['i_water'] > 0) {
            echo (round($volunteerSource['VolunteerSource']['i_positive'] / $volunteerSource['VolunteerSource']['i_water'], 3) * 100) . '%';
        }
        ?></td>
        <td><?php echo $volunteerSource['VolunteerSource']['o_water']; ?></td>
        <td><?php echo $volunteerSource['VolunteerSource']['o_positive']; ?></td>
        <td><?php
        if($volunteerSource['VolunteerSource']['o_water'] > 0) {
            echo (round($volunteerSource['VolunteerSource']['o_positive'] / $volunteerSource['VolunteerSource']['o_water'], 3) * 100) . '%';
        }
        ?></td>
        <td><?php echo $volunteerSource['VolunteerSource']['positive_done']; ?></td>
        <td><?php echo $volunteerSource['VolunteerSource']['people']; ?></td>
        <td><?php echo $volunteerSource['VolunteerSource']['note']; ?></td>
    </tr>
    <?php } ?>
</tbody>
</table>

<p>五、衛教宣導（衛生所、區公所）</p>
<?php
$keys = array('education');
$sum = array();
foreach($keys AS $key) {
    $sum[$key] = 0;
}
$areaSum = array();
foreach($educations AS $education) {
    foreach($keys AS $key) {
        $sum[$key] += $education['Education'][$key];
    }
}
?>
<table class="table table-bordered">
    <thead>
    <th>單位</th>
    <th>宣導人次</th>
</thead>
<tbody>
    <?php if(count($educations) > 1) { ?>
    <tr class="table-info">
        <td>累計</td>
        <td><?php echo $sum['education']; ?></td>
    </tr>
    <?php } ?>
    <?php foreach($educations AS $education) {
        ?>
    <tr>
        <td><?php echo $education['Area']['name'] . $education['Education']['unit']; ?></td>
        <td><?php echo $education['Education']['education']; ?></td>
    </tr>
    <?php } ?>
</tbody>
</table>

<p>六、各局處轄管防疫動員（各局處）</p>
<?php
$keys = array('investigate', 'i_water', 'i_positive', 'o_water', 'o_positive', 'positive_done', 'education', 'people');
$sum = array();
foreach($keys AS $key) {
    $sum[$key] = 0;
}
$areaSum = array();
foreach($bureauSources AS $bureauSource) {
    foreach($keys AS $key) {
        $sum[$key] += $bureauSource['BureauSource'][$key];
    }
}
?>
<table class="table table-bordered">
    <thead>
    <th>局處</th>
    <th>檢查地點數</th>
    <th>戶內積水容器</th>
    <th>戶內陽性容器</th>
    <th>戶內陽性率</th>
    <th>戶外積水容器</th>
    <th>戶外陽性容器</th>
    <th>戶外陽性率</th>
    <th>已處理陽性數</th>
    <th>宣導人次</th>
    <th>動員人數</th>
    <th>檢查地點（名稱）</th>
    <th>備註</th>
</thead>
<tbody>
    <?php if(count($bureauSources) > 1) { ?>
    <tr class="table-info">
        <td>累計</td>
        <td><?php echo $sum['investigate']; ?></td>
        <td><?php echo $sum['i_water']; ?></td>
        <td><?php echo $sum['i_positive']; ?></td>
        <td><?php
        if($sum['i_water'] > 0) {
            echo (round($sum['i_positive'] / $sum['i_water'], 3) * 100) . '%';
        }; ?></td>
        <td><?php echo $sum['o_water']; ?></td>
        <td><?php echo $sum['o_positive']; ?></td>
        <td><?php
        if($sum['o_water'] > 0) {
            echo (round($sum['o_positive'] / $sum['o_water'], 3) * 100) . '%';
        }; ?></td>
        <td><?php echo $sum['positive_done']; ?></td>
        <td><?php echo $sum['education']; ?></td>
        <td><?php echo $sum['people']; ?></td>
        <td></td>
        <td></td>
    </tr>
    <?php } ?>
    <?php foreach($bureauSources AS $bureauSource) {
        ?>
    <tr>
        <td><?php echo $bureauSource['BureauSource']['unit']; ?></td>
        <td><?php echo $bureauSource['BureauSource']['investigate']; ?></td>
        <td><?php echo $bureauSource['BureauSource']['i_water']; ?></td>
        <td><?php echo $bureauSource['BureauSource']['i_positive']; ?></td>
        <td><?php
        if($bureauSource['BureauSource']['i_water'] > 0) {
            echo (round($bureauSource['BureauSource']['i_positive'] / $bureauSource['BureauSource']['i_water'], 3) * 100) . '%';
        }; ?></td>
        <td><?php echo $bureauSource['BureauSource']['o_water']; ?></td>
        <td><?php echo $bureauSource['BureauSource']['o_positive']; ?></td>
        <td><?php
        if($bureauSource['BureauSource']['o_water'] > 0) {
            echo (round($bureauSource['BureauSource']['o_positive'] / $bureauSource['BureauSource']['o_water'], 3) * 100) . '%';
        }; ?></td>
        <td><?php echo $bureauSource['BureauSource']['positive_done']; ?></td>
        <td><?php echo $bureauSource['BureauSource']['education']; ?></td>
        <td><?php echo $bureauSource['BureauSource']['people']; ?></td>
        <td><?php echo $bureauSource['BureauSource']['location']; ?></td>
        <td><?php echo $bureauSource['BureauSource']['note']; ?></td>
    </tr>
    <?php } ?>
</tbody>
</table>

<p>七、化學防治（化學組）</p>
<?php
$keys = array('trips', 'door_count', 'door_done', 'fine', 'people', 'i_water', 'i_positive', 'o_water', 'o_positive');
$sum = array();
foreach($keys AS $key) {
    $sum[$key] = 0;
}
$areaSum = array();
foreach($chemicals AS $chemical) {
    if(!isset($areaSum[$chemical['Area']['Parent']['name']])) {
        $areaSum[$chemical['Area']['Parent']['name']] = array();
        foreach($keys AS $key) {
            $areaSum[$chemical['Area']['Parent']['name']][$key] = 0;
        }
        $areaSum[$chemical['Area']['Parent']['name']]['count'] = 0;
    }
    foreach($keys AS $key) {
        $sum[$key] += $chemical['Chemical'][$key];
        $areaSum[$chemical['Area']['Parent']['name']][$key] += $chemical['Chemical'][$key];
    }
    $areaSum[$chemical['Area']['Parent']['name']]['count'] += 1;
}
?>
<table class="table table-bordered">
    <thead>
    <th>區別</th>
    <th>里別</th>
    <th>戶外場次</th>
    <th>戶內應完成戶數</th>
    <th>已完成戶數</th>
    <th>完噴率</th>
    <th>拒噴戶開單數</th>
    <th>人力支援數</th>
    <th>戶內積水容器</th>
    <th>戶內陽性容器</th>
    <th>戶內陽性率</th>
    <th>戶外積水容器</th>
    <th>戶外陽性容器</th>
    <th>戶外陽性率</th>
    <th>備註</th>
</thead>
<tbody>
    <?php if(count($chemicals) > 1) { ?>
    <tr class="table-info">
        <td>累計</td>
        <td></td>
        <td><?php echo $sum['trips']; ?></td>
        <td><?php echo $sum['door_count']; ?></td>
        <td><?php echo $sum['door_done']; ?></td>
        <td><?php
        if($sum['door_count'] > 0) {
            echo (round($sum['door_done'] / $sum['door_count'], 3) * 100) . '%';
        }
        ?></td>
        <td><?php echo $sum['fine']; ?></td>
        <td><?php echo $sum['people']; ?></td>
        <td><?php echo $sum['i_water']; ?></td>
        <td><?php echo $sum['i_positive']; ?></td>
        <td><?php
        if($sum['i_water'] > 0) {
            echo (round($sum['i_positive'] / $sum['i_water'], 3) * 100) . '%';
        }
        ?></td>
        <td><?php echo $sum['o_water']; ?></td>
        <td><?php echo $sum['o_positive']; ?></td>
        <td><?php
        if($sum['o_water'] > 0) {
            echo (round($sum['o_positive'] / $sum['o_water'], 3) * 100) . '%';
        }
        ?></td>
        <td> </td>
    </tr>
    <?php } ?>
    <?php foreach($chemicals AS $chemical) {
        if(isset($areaSum[$chemical['Area']['Parent']['name']]) && $areaSum[$chemical['Area']['Parent']['name']]['count'] > 1) {
            ?>
    <tr class="table-warning">
        <td><?php echo $chemical['Area']['Parent']['name']; ?>累計</td>
        <td></td>
        <td><?php echo $areaSum[$chemical['Area']['Parent']['name']]['trips']; ?></td>
        <td><?php echo $areaSum[$chemical['Area']['Parent']['name']]['door_count']; ?></td>
        <td><?php echo $areaSum[$chemical['Area']['Parent']['name']]['door_done']; ?></td>
        <td><?php
        if($areaSum[$chemical['Area']['Parent']['name']]['door_count'] > 0) {
            echo (round($areaSum[$chemical['Area']['Parent']['name']]['door_done'] / $areaSum[$chemical['Area']['Parent']['name']]['door_count'], 3) * 100) . '%';
        }
        ?></td>
        <td><?php echo $areaSum[$chemical['Area']['Parent']['name']]['fine']; ?></td>
        <td><?php echo $areaSum[$chemical['Area']['Parent']['name']]['people']; ?></td>
        <td><?php echo $areaSum[$chemical['Area']['Parent']['name']]['i_water']; ?></td>
        <td><?php echo $areaSum[$chemical['Area']['Parent']['name']]['i_positive']; ?></td>
        <td><?php
        if($areaSum[$chemical['Area']['Parent']['name']]['i_water'] > 0) {
            echo (round($areaSum[$chemical['Area']['Parent']['name']]['i_positive'] / $areaSum[$chemical['Area']['Parent']['name']]['i_water'], 3) * 100) . '%';
        }
        ?></td>
        <td><?php echo $areaSum[$chemical['Area']['Parent']['name']]['o_water']; ?></td>
        <td><?php echo $areaSum[$chemical['Area']['Parent']['name']]['o_positive']; ?></td>
        <td><?php
        if($areaSum[$chemical['Area']['Parent']['name']]['o_water'] > 0) {
            echo (round($areaSum[$chemical['Area']['Parent']['name']]['o_positive'] / $areaSum[$chemical['Area']['Parent']['name']]['o_water'], 3) * 100) . '%';
        }
        ?></td>
        <td></td>
    </tr>
    <?php
    unset($areaSum[$chemical['Area']['Parent']['name']]);
        }
        ?>
    <tr>
        <td><?php echo $chemical['Area']['Parent']['name']; ?></td>
        <td><?php echo $chemical['Area']['name']; ?></td>
        <td><?php echo $chemical['Chemical']['trips']; ?></td>
        <td><?php echo $chemical['Chemical']['door_count']; ?></td>
        <td><?php echo $chemical['Chemical']['door_done']; ?></td>
        <td><?php
        if($chemical['Chemical']['door_count'] > 0) {
            echo (round($chemical['Chemical']['door_done'] / $chemical['Chemical']['door_count'], 3) * 100) . '%';
        }
        ?></td>
        <td><?php echo $chemical['Chemical']['fine']; ?></td>
        <td><?php echo $chemical['Chemical']['people']; ?></td>
        <td><?php echo $chemical['Chemical']['i_water']; ?></td>
        <td><?php echo $chemical['Chemical']['i_positive']; ?></td>
        <td><?php
        if($chemical['Chemical']['i_water'] > 0) {
            echo (round($chemical['Chemical']['i_positive'] / $chemical['Chemical']['i_water'], 3) * 100) . '%';
        }
        ?></td>
        <td><?php echo $chemical['Chemical']['o_water']; ?></td>
        <td><?php echo $chemical['Chemical']['o_positive']; ?></td>
        <td><?php
        if($chemical['Chemical']['o_water'] > 0) {
            echo (round($chemical['Chemical']['o_positive'] / $chemical['Chemical']['o_water'], 3) * 100) . '%';
        }
        ?></td>
        <td><?php echo $chemical['Chemical']['note']; ?></td>
    </tr>
    <?php } ?>
</tbody>
</table>

<p>八、診所發燒病人就醫健康監視人數（疫情組）</p>
<?php
$keys = array('people_count', 'people_track');
$sum = array();
foreach($keys AS $key) {
    $sum[$key] = 0;
}
$areaSum = array();
foreach($feverMonitors AS $feverMonitor) {
    foreach($keys AS $key) {
        $sum[$key] += $feverMonitor['FeverMonitor'][$key];
    }
}
?>
<table class="table table-bordered">
    <thead>
    <th>區別</th>
    <th>應追蹤人數</th>
    <th>已追蹤人數</th>
    <th>未追蹤人數</th>
    <th>追蹤率</th>
    <th>備註</th>
</thead>
<tbody>
    <?php if(count($feverMonitors) > 1) { ?>
    <tr class="table-info">
        <td>累計</td>
        <td><?php echo $sum['people_count']; ?></td>
        <td><?php echo $sum['people_track']; ?></td>
        <td><?php echo ($sum['people_count'] - $sum['people_track']); ?></td>
        <td><?php
        if($sum['people_count'] > 0) {
            echo (round($sum['people_track'] / $sum['people_count'], 3) * 100) . '%';
        }
        ?></td>
        <td></td>
    </tr>
    <?php } ?>
    <?php foreach($feverMonitors AS $feverMonitor) {
        ?>
    <tr>
        <td><?php echo $feverMonitor['Area']['name']; ?></td>
        <td><?php echo $feverMonitor['FeverMonitor']['people_count']; ?></td>
        <td><?php echo $feverMonitor['FeverMonitor']['people_track']; ?></td>
        <td><?php echo ($feverMonitor['FeverMonitor']['people_count'] - $feverMonitor['FeverMonitor']['people_track']); ?></td>
        <td><?php
        if($feverMonitor['FeverMonitor']['people_count'] > 0) {
            echo (round($feverMonitor['FeverMonitor']['people_track'] / $feverMonitor['FeverMonitor']['people_count'], 3) * 100) . '%';
        }; ?></td>
        <td><?php echo $feverMonitor['FeverMonitor']['note']; ?></td>
    </tr>
    <?php } ?>
</tbody>
</table>

<p>九、醫療院所通報數（疫情組）</p>
<?php
$keys = array('count_p', 'count_n');
$sum = array();
foreach($keys AS $key) {
    $sum[$key] = 0;
}
$areaSum = array();
foreach($clinicReports AS $clinicReport) {
    foreach($keys AS $key) {
        $sum[$key] += $clinicReport['ClinicReport'][$key];
    }
}
?>
<table class="table table-bordered">
    <thead>
    <th>區域</th>
    <th>通報件數</th>
    <th>NS1 (+)</th>
    <th>NS1 (-)</th>
    <th>備註</th>
</thead>
<tbody>
    <?php if(count($clinicReports) > 1) { ?>
    <tr class="table-info">
        <td>累計</td>
        <td><?php echo ($sum['count_p'] + $sum['count_n']); ?></td>
        <td><?php echo $sum['count_p']; ?></td>
        <td><?php echo $sum['count_n']; ?></td>
        <td></td>
    </tr>
    <?php } ?>
    <?php foreach($clinicReports AS $clinicReport) {
        ?>
    <tr>
        <td><?php echo $clinicReport['Area']['name']; ?></td>
        <td><?php echo ($clinicReport['ClinicReport']['count_p'] + $clinicReport['ClinicReport']['count_n']); ?></td>
        <td><?php echo $clinicReport['ClinicReport']['count_p']; ?></td>
        <td><?php echo $clinicReport['ClinicReport']['count_n']; ?></td>
        <td><?php echo $clinicReport['ClinicReport']['note']; ?></td>
    </tr>
    <?php } ?>
</tbody>
</table>

<?php
echo $this->Html->script('c/areas/report.js');
