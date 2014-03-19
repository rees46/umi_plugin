<?php
abstract class __eventsHandlersEvents {

    public function onChangeStatus(iUmiEventPoint $event) {
        var_dump($event);
        if ($event->getMode() === "before") return true;
        if ($event->getMode() === "after") {
            //$iCommentId = $oEventPoint->getParam("message_id");
            return true;
        }
    }

}
?>