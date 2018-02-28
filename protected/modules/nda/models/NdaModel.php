<?php

namespace humhub\modules\nda\models;

use Yii;
use humhub\modules\nda\models\NdaAgreement;
use humhub\modules\nda\models\NdaModelChoose;

/**
 * This is the model class for table "nda_model".
 *
 * @property integer $id
 * @property string $name
 * @property string $pdf
 *
 * @property NdaAgreement[] $ndaAgreements
 * @property NdaModelChoose[] $ndaModelChooses
 */
class NdaModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nda_model';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'pdf'], 'required'],
            [['name'], 'string', 'max' => 45],
            [['pdf'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'pdf' => 'Pdf',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNdaAgreements()
    {
        return $this->hasMany(NdaAgreement::className(), ['nda_model_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNdaModelChooses()
    {
        return $this->hasMany(NdaModelChoose::className(), ['nda_model_id' => 'id']);
    }

    /**
     * Returns the Path of the File
     */
    public function getPath()
    {
        $path = Yii::getAlias('@webroot') .
                DIRECTORY_SEPARATOR . "uploads";

        if (!is_dir($path)) {
            mkdir($path);
        }

        return $path;
    }

    /**
     * Returns the file and path to the stored file
     */
    public function getStoredFilePath($file)
    {
        return $this->getPath() . DIRECTORY_SEPARATOR . $file;
    }
}
