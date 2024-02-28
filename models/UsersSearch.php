<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * UsersSearch represents the model behind the search form of `app\models\Users`.
 */
class UsersSearch extends Users
{
    public function rules()
    {
        return [
            [['id', 'fk_role'], 'integer'],
            [['firstname', 'middlename', 'lastname', "birthday", 'sex', 'email', 'password', 'date_last_logout', 'nickname'], 'safe'],
        ];
    }

    public function scenarios()
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
    public function search($params)
    {
        $query = Users::find();

        $dataProvider = new ActiveDataProvider(['query' => $query]);

        $dataProvider->pagination->pageSize = 10;


        $this->load($params);

        if (!$this->validate())
        {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'brithday' => $this->birthday,
            'date_last_logout' => $this->date_last_logout,
            'fk_role' => $this->fk_role,
        ]);

        $query->andFilterWhere(['ilike', 'firstname', $this->firstname])
              ->andFilterWhere(['ilike', 'middlename', $this->middlename])
              ->andFilterWhere(['ilike', 'lastname', $this->lastname])
              ->andFilterWhere(['ilike', 'sex', $this->sex])
              ->andFilterWhere(['ilike', 'email', $this->email])
              ->andFilterWhere(['ilike', 'password', $this->password])
              ->andFilterWhere(['ilike', 'nickname', $this->nickname]);

        return $dataProvider;
    }
}