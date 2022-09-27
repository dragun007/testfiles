<?php

declare(strict_types=1);

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "file".
 *
 * @property int $id
 * @property int $user_id
 * @property string $filename
 * @property string $file_hash
 * @property string $type
 * @property int $created_at
 * @property int $updated_at
 */
class File extends ActiveRecord
{
    public $upload;
    public $count;

    const TYPE_PUBLIC = 'public';
    const TYPE_HALF_PUBLIC = 'half_public';
    const TYPE_PRIVATE = 'private';

    const VIEW_HALF_PUBLIC = 'ViewHalfPublicDocs';
    const VIEW_PRIVATE_DOC = 'ViewPrivateDoc';
    const VIEW_OWN_PRIVATE_DOC = 'ViewOwnPrivateDoc';

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'file';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['type'], 'required'],
            [['user_id', 'created_at', 'updated_at'], 'integer'],
            [['filename'], 'string', 'max' => 255],
            [['file_hash', 'type'], 'string', 'max' => 32],
            [['upload'], 'file', 'extensions' => 'doc, docx, pdf', 'maxSize' => 1024 * 1024 * 2],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'filename' => 'Filename',
            'file_hash' => 'File Hash',
            'type' => 'Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getPath(): string
    {
        return Yii::$app->params['documentPath'] . $this->file_hash;
    }

    public static function getFilesTypes(): array
    {
        return [self::TYPE_PUBLIC, self::TYPE_PRIVATE, self::TYPE_HALF_PUBLIC];
    }
}
