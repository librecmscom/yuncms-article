<?php

namespace yuncms\article\frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yuncms\article\models\Article;

/**
 * ManageSearch represents the model behind the search form about `yuncms\article\models\Article`.
 */
class ManageSearch extends Article
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'comments', 'supports', 'collections', 'views', 'is_top', 'is_best'], 'integer'],
            [['uuid', 'category_id', 'title', 'sub_title'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
    public function search($params)
    {
        $query = Article::find()->where(['user_id' => Yii::$app->user->id]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([

            'status' => $this->status,
            'comments' => $this->comments,
            'supports' => $this->supports,
            'collections' => $this->collections,
            'views' => $this->views,
            'is_top' => $this->is_top,
            'is_best' => $this->is_best,
        ]);

        $query->andFilterWhere(['like', 'uuid', $this->uuid])
            ->andFilterWhere(['like', 'category_id', $this->category_id])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'sub_title', $this->sub_title]);

        return $dataProvider;
    }
}
