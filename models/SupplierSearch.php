<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Supplier;

/**
 * SupplierSearch represents the model behind the search form of `app\models\Supplier`.
 */
class SupplierSearch extends Supplier
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'code', 't_status'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $pagination = true)
    {
        $query = Supplier::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination ? ['pageSize' => 3] : false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        switch ($this->id) {
            case 1:
                $query->andFilterWhere(
                    ['>', 'id', 10]
                );
                break;
            case 2:
                $query->andFilterWhere(
                    ['<', 'id', 10]
                );
                break;
            case 3:
                $query->andFilterWhere(
                    ['>=', 'id', 10]
                );
                break;
            case 4:
                $query->andFilterWhere(
                    ['<=', 'id', 10]
                );
                break;
            default:
                break;
        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 't_status', $this->t_status]);

        return $dataProvider;
    }
}
