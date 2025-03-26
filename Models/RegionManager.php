<?php

include_once('AbstractEntityManager.php');

class RegionManager extends AbstractEntityManager{

    function getRegions(){
        $request = "select * from regions";
        $statement = $this -> db -> query($request);

        $regionList=[];
        while ($region = $statement -> fetch()){
            $regionList[] = new Region ($region);

        }
        return $regionList;
    }

    public function getRegionIdByName($region) {
        $sql = 'SELECT idRegion FROM regions WHERE region = :region';
        $idRegion = $this->db->query($sql, ['region' => $region])->fetchColumn();
        return $idRegion !== false ? (int) $idRegion : null;
    }
    
}