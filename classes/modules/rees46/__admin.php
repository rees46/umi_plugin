<?php
abstract class __rees46_admin extends baseModuleAdmin {

    public function config() {

        $regedit = regedit::getInstance();
        $params = Array (
            "config" => Array (
                "string:shop-id" => null
            )
        );

        $mode = getRequest("param0");
        if ($mode == "do"){
            if (!is_demo()) {
                $params = $this->expectParams($params);
                $regedit->setVar("//modules/rees46/shop-id", (string) $params["config"]["string:shop-id"]);
                $this->chooseRedirect();
            }
        }
        $params["config"]["string:shop-id"] = (string) $regedit->getVal("//modules/rees46/shop-id");

        $this->setDataType("settings");
        $this->setActionType("modify");

        $data = $this->prepareData($params, "settings");
        $this->setData($data);

        return $this->doData();

    }

}