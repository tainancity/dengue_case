<link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<?php echo $this->Html->css('ol'); ?>
<?php echo $this->Html->css('ol3-sidebar.min'); ?>
<script>
    var cakeRoot = '<?php echo $this->Html->url('/'); ?>';
</script>

<div id="fb-root"></div>
<script>
    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = 'https://connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v2.12&appId=1393405437614114&autoLogAppEvents=1';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<div id="sidebar" class="sidebar collapsed">
    <!-- Nav tabs -->
    <div class="sidebar-tabs">
        <ul role="tablist">
            <li><a href="#home" role="tab"><i class="fa fa-bars"></i></a></li>
            <li><a href="#book" role="tab"><i class="fa fa-book"></i></a></li>
            <li><a href="#tools" role="tab"><i class="fa fa-wrench"></i></a></li>
            <li><a href="https://github.com/kiang/ovitrap" role="tab" target="_blank"><i class="fa fa-github"></i></a></li>
            <li><a href="#fb" role="tab"><i class="fa fa-facebook"></i></a></li>
        </ul>
    </div>

    <!-- Tab panes -->
    <div class="sidebar-content">
        <div class="sidebar-pane" id="home">
            <h1 class="sidebar-header"><span id="sidebarTitle">請點選地圖中的點</span><span class="sidebar-close"><i class="fa fa-caret-left"></i></span></h1>
            <div id="sidebarContent">請點選地圖中的點</div>
            <div id="sidebarCunli"></div>
        </div>
        <div class="sidebar-pane" id="book">
            <h1 class="sidebar-header"><span id="weekTitle">說明</span><span class="sidebar-close"><i class="fa fa-caret-left"></i></span></h1>
            <div>
                區塊配色說明（里）
                <ul>
                    <li>深紫色： 誘卵桶卵數數量大於 500 或是陽性率大於 60% (8個以上誘卵桶發現蟲卵)</li>
                    <li>淺紫色： 誘卵桶卵數數量大於 250 或是陽性率大於 40% (4個以上誘卵桶發現蟲卵)</li>
                    <li>淺黃色： 誘卵桶卵數數量大於 0 (1個以上誘卵桶發現蟲卵)</li>
                    <li>白色： 誘卵桶卵數數量等於 0 (沒有誘卵桶發現蟲卵，或是沒有設置誘卵桶)</li>
                </ul>
                圓點配色說明（居住地）
                <ul>
                    <li>黃底紅邊： 確診病例位置</li>
                    <li>紅色圓點： IgM 與 IgG 都呈現陽性案例</li>
                    <li>藍色圓點： IgG 呈現陽性案例</li>
                    <li>紅色圓點： IgM 呈現陽性案例</li>
                </ul>
            </div>
        </div>
        <div class="sidebar-pane" id="tools">
            <h1 class="sidebar-header"><span>工具</span><span class="sidebar-close"><i class="fa fa-caret-left"></i></span></h1>
            <div>
                <br /><a href="#" class="btn btn-primary btn-lg btn-block" id="btn-geolocation">回到目前位置</a>
                <hr /><div class="form-group">
                    <label for="formSelectArea">選擇區域</label>
                    <select class="form-control" id="formSelectArea">
                        <option value="all">顯示全部</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="sidebar-pane" id="fb">
            <div class="fb-page" data-href="https://www.facebook.com/k.olc.tw/" data-tabs="timeline" data-width="380" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/k.olc.tw/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/k.olc.tw/">江明宗</a></blockquote></div>
        </div>
    </div>
</div>

<div id="map" class="sidebar-map"></div>
<?php echo $this->Html->link('全畫面地圖', '/points/map', array('target' => '_blank')); ?>
<?php echo $this->Html->script('proj4'); ?>
<?php echo $this->Html->script('ol'); ?>
<?php echo $this->Html->script('ol-ext'); ?>
<?php echo $this->Html->script('FontAwesomeDef'); ?>
<?php echo $this->Html->script('ol5-sidebar.min'); ?>
<?php echo $this->Html->script('main'); ?>