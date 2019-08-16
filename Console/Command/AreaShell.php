<?php

class AreaShell extends AppShell {

    public $uses = array('Area', 'BureauSource');

    public function main() {
        $this->data();
    }

    public function data() {
        $areas = $this->Area->find('list', array(
            'conditions' => array(
                'Area.parent_id IS NULL'
            ),
            'fields' => array(
                'Area.name', 'Area.id'
            ),
        ));

        $fh = fopen(TMP . '/108年本土疫情每日防治成果_01.衛生所 (回應) - 表單回應 1.csv', 'r');
        $head = fgetcsv($fh, 2048);
        while ($line = fgetcsv($fh, 2048)) {
            $data = array_combine($head, $line);
            $data['資料日期'] = date('Y-m-d', strtotime($data['資料日期']));
            if (false === strpos($data['衛生所'], '區')) {
                $data['衛生所'] .= '區';
            }
            $education = array(
                'the_date' => $data['資料日期'],
                'area_id' => $areas[$data['衛生所']],
                'unit' => '衛生所',
            );
            $educationId = $this->Area->Education->field('id', $education);
            if (empty($educationId)) {
                $this->Area->Education->create();
                $education['created_by'] = $education['modified_by'] = 0;
            } else {
                $this->Area->Education->id = $educationId;
                $education['modified_by'] = 0;
            }
            $education['education'] = $data['衛教人次'];
            $this->Area->Education->save(array('Education' => $education));

            $expand = array(
                'the_date' => $data['資料日期'],
                'area_id' => $areas[$data['衛生所']],
            );
            $expandId = $this->Area->Expand->field('id', $expand);
            if (empty($expandId)) {
                $this->Area->Expand->create();
                $expand['created_by'] = $expand['modified_by'] = 0;
            } else {
                $this->Area->Expand->id = $expandId;
                $expand['modified_by'] = 0;
            }
            $expand['count_p'] = $data['NS1(+)'];
            $expand['count_n'] = $data['NS1(-)'];
            $this->Area->Expand->save(array('Expand' => $expand));

            $fever = array(
                'the_date' => $data['資料日期'],
                'area_id' => $areas[$data['衛生所']],
            );
            $feverId = $this->Area->Fever->field('id', $fever);
            if (empty($feverId)) {
                $this->Area->Fever->create();
                $fever['created_by'] = $fever['modified_by'] = 0;
            } else {
                $this->Area->Fever->id = $feverId;
                $fever['modified_by'] = 0;
            }
            $fever['count_people'] = $data['個案戶家人數'];
            $fever['count_fever'] = $data['個案戶家人發燒數'];
            $fever['count_draw'] = $data['個案戶家人採血數'];
            $fever['count_p'] = 0;
            $fever['count_n'] = 0;
            $this->Area->Fever->save(array('Fever' => $fever));

            $track = array(
                'the_date' => $data['資料日期'],
                'area_id' => $areas[$data['衛生所']],
            );
            $trackId = $this->Area->Track->field('id', $track);
            if (empty($trackId)) {
                $this->Area->Track->create();
                $track['created_by'] = $track['modified_by'] = 0;
            } else {
                $this->Area->Track->id = $trackId;
                $track['modified_by'] = 0;
            }
            $track['track_count'] = $data['社區應追蹤人數'];
            $track['track_done'] = $data['社區已追蹤人數'];
            $track['fever_count'] = $data['社區發燒人數'];
            $track['fever_draw'] = $data['社區採血人數'];
            $this->Area->Track->save(array('Track' => $track));
        }
        
        $fh = fopen(TMP . '/108年本土疫情每日防治成果_02.區公所 (回應) - 表單回應 1.csv', 'r');
        $head = fgetcsv($fh, 2048);
        while ($line = fgetcsv($fh, 2048)) {
            $data = array_combine($head, $line);
            $data['資料日期'] = date('Y-m-d', strtotime($data['資料日期']));
            if (false === strpos($data['區公所'], '區')) {
                $data['區公所'] .= '區';
            }
            $education = array(
                'the_date' => $data['資料日期'],
                'area_id' => $areas[$data['區公所']],
                'unit' => '區公所',
            );
            $educationId = $this->Area->Education->field('id', $education);
            if (empty($educationId)) {
                $this->Area->Education->create();
                $education['created_by'] = $education['modified_by'] = 0;
            } else {
                $this->Area->Education->id = $educationId;
                $education['modified_by'] = 0;
            }
            $education['education'] = $data['衛教人次'];
            $this->Area->Education->save(array('Education' => $education));
        }

        $fh = fopen(TMP . '/108年本土疫情每日防治成果_03.各局處 (回應) - 表單回應 1.csv', 'r');
        $head = fgetcsv($fh, 2048);
        while ($line = fgetcsv($fh, 2048)) {
            $data = array_combine($head, $line);
            $data['資料日期'] = date('Y-m-d', strtotime($data['資料日期']));
            $bureau_source = array(
                'the_date' => $data['資料日期'],
                'unit' => $data['局處'],
            );
            $bureauSourceId = $this->BureauSource->field('id', $bureau_source);
            if (empty($bureauSourceId)) {
                $this->BureauSource->create();
                $bureau_source['created_by'] = $bureau_source['modified_by'] = 0;
            } else {
                $this->BureauSource->id = $bureauSourceId;
                $bureau_source['modified_by'] = 0;
            }
            $bureau_source['investigate'] = $data['檢查地點數'];
            $bureau_source['i_water'] = $data['積水容器數(內)'];
            $bureau_source['i_positive'] = $data['陽性容器數(內)'];
            $bureau_source['o_water'] = $data['積水容器數(外)'];
            $bureau_source['o_positive'] = $data['陽性容器數(外)'];
            $bureau_source['positive_done'] = $data['已處理陽性數'];
            $bureau_source['education'] = $data['宣導人次'];
            $bureau_source['people'] = $data['動員人數'];
            $bureau_source['location'] = $data['檢查地點名稱'];
            $bureau_source['note'] = $data['備註'];
            $this->BureauSource->save(array('BureauSource' => $bureau_source));
        }
        
        $fh = fopen(TMP . '/108年本土疫情每日防治成果_04.登革熱防治中心 (回應) - 表單回應 1.csv', 'r');
        $head = fgetcsv($fh, 2048);
        while ($line = fgetcsv($fh, 2048)) {
            $data = array_combine($head, $line);
            if (empty($data['區別'])) {
                continue;
            }
            $data['資料日期'] = date('Y-m-d', strtotime($data['資料日期']));
            if (false === strpos($data['區別'], '區')) {
                $data['區別'] .= '區';
            }

            switch ($data['項目']) {
                case '化學防治':
                    break;
                case '診所發燒病人就醫健康監視':
                    break;
                case '醫療院所通報數':
                    $clinicReport = array(
                        'the_date' => $data['資料日期'],
                        'area_id' => $areas[$data['區別']],
                    );
                    $theId = $this->Area->ClinicReport->field('id', $clinicReport);
                    if (empty($theId)) {
                        $this->Area->ClinicReport->create();
                        $clinicReport['created_by'] = $clinicReport['modified_by'] = 0;
                    } else {
                        $this->Area->ClinicReport->id = $theId;
                        $clinicReport['modified_by'] = 0;
                    }
                    $clinicReport['count_p'] = $data['NS1(+)'];
                    $clinicReport['count_n'] = $data['NS1(-)'];
                    $clinicReport['note'] = $data['備註'];
                    $this->Area->ClinicReport->save(array('ClinicReport' => $clinicReport));
                    break;
            }
        }
        
    }

    public function import() {
        $json = json_decode(file_get_contents(APP . 'webroot/js/cunli.json'), true);
        $db = $this->Area->find('list', array(
            'fields' => array('code', 'id'),
        ));
        foreach ($json['features'] AS $f) {
            if ($f['properties']['COUNTYNAME'] === '臺南市') {
                if (!isset($db[$f['properties']['TOWNCODE']])) {
                    $this->Area->create();
                    $this->Area->save(array('Area' => array(
                            'code' => $f['properties']['TOWNCODE'],
                            'name' => $f['properties']['TOWNNAME'],
                    )));
                    $db[$f['properties']['TOWNCODE']] = $this->Area->getInsertID();
                }
                if (!isset($db[$f['properties']['VILLCODE']])) {
                    $this->Area->create();
                    $this->Area->save(array('Area' => array(
                            'parent_id' => $db[$f['properties']['TOWNCODE']],
                            'code' => $f['properties']['VILLCODE'],
                            'name' => $f['properties']['VILLNAME'],
                    )));
                    $db[$f['properties']['VILLCODE']] = $this->Area->getInsertID();
                }
            }
        }
    }

}
