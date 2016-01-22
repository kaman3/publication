<?php $this->renderPartial('_form',
    array(
        'model'=>$model,
        'idCat' => $idCat,
        'city' => $city,
        'microdistrict' => $microdistrict,
        'transaction' => $transaction,
        'typeHouse' => $typeHouse,
        'countRooms' => $countRooms,
    )); ?>