<?php

declare(strict_types=1);

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * FileSearch represents the model behind the search form of `common\models\File`.
 */
class FileSearch extends File
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'user_id', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios(): array
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = File::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'filename', $this->filename])
            ->andFilterWhere(['like', 'file_hash', $this->file_hash])
            ->andFilterWhere(['like', 'type', $this->type]);
        $user = Yii::$app->user;
        if ($user->can('user')) {
            $query->andWhere(['OR', [
                'AND',
                ['user_id' => $user->id],
                ['NOT IN', 'type' ,[FILE::TYPE_HALF_PUBLIC, FILE::TYPE_PUBLIC]],
            ],
                ['NOT IN', 'type',FILE::TYPE_PRIVATE],
            ]);
        } elseif(!$user->can('admin')) {
            $query->andWhere(['type'=>FILE::TYPE_PUBLIC]);
        }

        return $dataProvider;
    }
}
