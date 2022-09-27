<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * FileSearch represents the model behind the search form of `common\models\File`.
 */
class StatisticByDateFileSearch extends File
{
    public $day;
    public $month;
    public $year;

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            ['day', 'datetime', 'format' => 'php:d-m-Y'],
            ['month', 'datetime', 'format' => 'php:m-Y'],
            ['year', 'datetime', 'format' => 'php:Y'],
            ['day', 'validateOnlyOne', 'skipOnEmpty' => false],
        ];
    }

    private function getDateAttributes()
    {
        return ['day' => $this->day, 'month' => $this->month, 'year' => $this->year];
    }

    public function validateOnlyOne()
    {
        $counter = 0;
        foreach ($this->getDateAttributes() as $date) {
            if (empty($date)) {
                continue;
            }
            $counter++;
        }
        if ($counter !== 1) {
            $this->addError('day', 'Only one attribute is possible');
        }
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
            $query->where('0=1');
            return $dataProvider;
        }

        foreach ($this->getDateAttributes() as $timeLength => $date) {
            if (empty($date)) {
                continue;
            }
            $from_date = $this->getStrToTime($timeLength, $date);

            $to_date = strtotime('+1 ' . $timeLength, $from_date);
            break;
        }

        if ($from_date === -1 || $to_date === -1) {
            $this->addError('day', 'time is to big');
            return $dataProvider;
        }

        $query->andFilterWhere(['>=',
            'created_at', $from_date,
        ]);
        $query->andFilterWhere(['<=',
            'created_at', $to_date,
        ]);


        $query->select(['COUNT(*) AS count'])->count();

        return $dataProvider;
    }

    private function getStrToTime(string $legth, string $date)
    {
        if ($legth == 'month') {
            $date = '1-' . $date;
        } elseif ($legth == 'year') {
            $date = '1-1-' . $date;
        }

        return strtotime($date);
    }
}
