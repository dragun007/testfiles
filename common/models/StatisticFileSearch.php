<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * FileSearch represents the model behind the search form of `common\models\File`.
 */
class StatisticFileSearch extends File
{
    public $from_date;
    public $to_date;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            ['from_date', 'datetime', 'format' => 'php:d-m-Y'],
            ['to_date', 'datetime', 'format' => 'php:d-m-Y'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios(): array
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     *
     * @param array $params
     *
     * @return \yii\data\ActiveDataProvider
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

        $from_date = strtotime($this->from_date);
        $to_date = strtotime($this->to_date);

        if ($from_date === -1 || $to_date === -1) {
            $this->addError('to_date', 'time is to big');
            return $dataProvider;
        }

        $query->andFilterWhere(['>=',
            'created_at', $from_date,
        ]);

        $query->andFilterWhere(['<=',
            'created_at', $to_date,
        ]);

        $query->select(['type','COUNT(*) AS cnt'])->groupBy(['type'])->count();

        return $dataProvider;
    }
}
