<?php

namespace app\models;

use yii\db\ActiveRecord;

class Sections extends ActiveRecord
{

    public static function tableName()
    {
        return 'sections';
    }
}